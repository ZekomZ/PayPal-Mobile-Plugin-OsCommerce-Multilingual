<?php
        $catalog_path = "";
        
	ini_set('display_errors', 'on');
	error_reporting(E_ALL);
	
	if(isset($_GET["main_page"]) && $_GET["main_page"] == "login")
	{
		unset($_SESSION['paypal_ec_token']);
		header("HTTP/1.1 303 See Other");
		header("Location: http://".$_SERVER[HTTP_HOST]."/ipn_main_handler.php?type=ec");
	}

	define('SKIP_SINGLE_PRODUCT_CATEGORIES', 'False');
	require('includes/application_top.php');
	require('includes/classes/http_client.php');
	require('includes/database_tables.php');
	tep_session_unregister('navigation');
        header("Content-type: text/html; charset=".strtolower(CHARSET), true);
	if(defined("PROJECT_VERSION"))
	{
			preg_match("/\d+\.?\d+/",PROJECT_VERSION, $matches);
			if($matches)
				define("PP_OSC_VERSION", (float)$matches[0]);
			else
				define("PP_OSC_VERSION", 2.3);
	}
	else
		define("PP_OSC_VERSION", 2.3);

	if(PP_OSC_VERSION<2.3)
	{
		define("IPN_HANDLER", preg_replace("/\/+$/","",DIR_WS_CATALOG) . "/ext/modules/payment/paypal/express_mobile.php");
		define("SHIPPING_SELECTOR", "on"); //on / off


		// include boxes template  
		require('mobile/lib/boxes/bm_categories.php');
      
		// to remove product function in cart page
		if($HTTP_GET_VARS['action'] == 'remove_product') 
		{
			if (isset($HTTP_GET_VARS['products_id'])) 
			{
				$cart->remove($HTTP_GET_VARS['products_id']);
			}
			tep_redirect(tep_href_link($goto, tep_get_all_get_params($parameters)));
		}
		
		if(!function_exists("tep_draw_button")) {
			function tep_draw_button($title = null, $icon = null, $link = null, $priority = null, $params = null) {
			static $button_counter = 1;

			$types = array('submit', 'button', 'reset');

			if ( !isset($params['type']) ) {
			  $params['type'] = 'submit';
			}

			if ( !in_array($params['type'], $types) ) {
			  $params['type'] = 'submit';
			}

			if ( ($params['type'] == 'submit') && isset($link) ) {
			  $params['type'] = 'button';
			}

			if (!isset($priority)) {
			  $priority = 'secondary';
			}

			$button = '<span class="tdbLink">';

			if ( ($params['type'] == 'button') && isset($link) ) {
			  $button .= '<a id="tdb' . $button_counter . '" href="' . $link . '"';

			  if ( isset($params['newwindow']) ) {
				$button .= ' target="_blank"';
			  }
			} else {
			  $button .= '<button id="tdb' . $button_counter . '" type="' . tep_output_string($params['type']) . '"';
			}

			if ( isset($params['params']) ) {
			  $button .= ' ' . $params['params'];
			}

			$button .= '>' . $title;

			if ( ($params['type'] == 'button') && isset($link) ) {
			  $button .= '</a>';
			} else {
			  $button .= '</button>';
			}

			$button .= '</span><script type="text/javascript">$("#tdb' . $button_counter . '").button(';

			$args = array();

			if ( isset($icon) ) {
			  if ( !isset($params['iconpos']) ) {
				$params['iconpos'] = 'left';
			  }

			  if ( $params['iconpos'] == 'left' ) {
				$args[] = 'icons:{primary:"ui-icon-' . $icon . '"}';
			  } else {
				$args[] = 'icons:{secondary:"ui-icon-' . $icon . '"}';
			  }
			}

			if (empty($title)) {
			  $args[] = 'text:false';
			}

			if (!empty($args)) {
			  $button .= '{' . implode(',', $args) . '}';
			}

			$button .= ').addClass("ui-priority-' . $priority . '").parent().removeClass("tdbLink");</script>';

			$button_counter++;

			return $button;
		  }
		}
	}
	else //oscommerce 2.3+
	{
		define("SHIPPING_SELECTOR", "off"); //on / off
		require('includes/modules/boxes/bm_categories.php');
		define("IPN_HANDLER", "ipn_main_handler.php");
	}

	function get_expressURL(){
	  if(PP_OSC_VERSION<2.3) 
		  echo 'mobile/lib/express_mobile.php';
	  else
		  echo 'ext/modules/payment/paypal/express.php';
	}
	
        $lang_id = isset($lng->language['id'])?$lng->language['id']:$_SESSION['languages_id'];
	$lang = tep_db_fetch_array(tep_db_query("SELECT * FROM " . TABLE_LANGUAGES . " WHERE languages_id=". $lang_id));
	include("mobile/language_".$lang['code'] .".php");
	function get_paypalLanguages($lang){ 
		$l = array();
		$l['language'] = $lang['code'] . "_" . strtoupper($lang['code']);
		$l['checkoutWithPaypal'] = "mobile/images/" . $l['language'] . "/" . $l['language'].".png";
		$l['checkoutWithPaypalDown'] = "mobile/images/" . $l['language']. "/" . $l['language']."_pressed.png";
		
		return $l;
	}
	$GLOBALS['PaypalLanguages'] = get_paypalLanguages($lang);
	$GLOBALS['language_pp']=$lang;
	$_SESSION['paypal_ec_markflow'] = 1;
	global $bm_categories, $tree;
	$bm_categories = new bm_categories();
	$bm_categories->getData();
	global $products;

function requestURI(){
   
  $requestURI = $_SERVER['REQUEST_URI']; 
  
  $catalogFolder = DIR_WS_CATALOG;
  $catalogFolder = preg_replace("/\/+$/", "", $catalogFolder);
  $subject = preg_replace("/".preg_quote($catalogFolder, "/")."/", "", $requestURI);
  return array(
      $requestURI,
      $catalogFolder,
      $subject
  );
}

function matchhome() {
	global $bm_categories, $tree, $currency;

	list($requestURI, $catalogFolder, $subject) = requestURI();
	$pattern = '/^\/(?:$|\?)/';
	preg_match($pattern, $subject, $matches);
	if ($matches) {
		return true;
	}
	return false;
}
if(matchhome()) {
  	$select_column_list = 'pd.products_name, p.products_image, ';
    $listing_sql = "select " . $select_column_list . " p.products_id, p.manufacturers_id, p.products_price, 
	p.products_tax_class_id, IF(s.status, s.specials_new_products_price, NULL) as specials_new_products_price, 
	IF(s.status, s.specials_new_products_price, p.products_price) as final_price from " . TABLE_PRODUCTS_DESCRIPTION . " pd, " 
	. TABLE_PRODUCTS . " p left join " . TABLE_MANUFACTURERS . " m on p.manufacturers_id = m.manufacturers_id left join " 
	. TABLE_SPECIALS . " s on p.products_id = s.products_id, " . TABLE_PRODUCTS_TO_CATEGORIES . " p2c 
	where p.products_status = '1' and p.products_id = p2c.products_id and pd.products_id = p2c.products_id and pd.language_id = '" . (int)$languages_id . "'
	order by s.specials_new_products_price desc, p.products_date_added desc";
    $categories_query = tep_db_query("select count(*) as total from " . TABLE_CATEGORIES 
	. " c, " . TABLE_CATEGORIES_DESCRIPTION . " cd where c.parent_id = '" 
	. (int)$category_links[$i] . "' and c.categories_id = cd.categories_id and cd.language_id = '" . (int)$languages_id . "'");
    $categories = tep_db_fetch_array($categories_query);      
        
	global $listing_sql, $db, $listing_query, $categories;
	include 'mobile/index.php';
	die();
}
 
function matchcart() {
	global $bm_categories, $tree, $cart, $cartShowTotal, $currency, $currencies;
	list($requestURI, $catalogFolder, $subject) = requestURI();
	$pattern = '/(index.php\?main_page=shopping_cart|shopping_cart.php)/';
	preg_match($pattern, $subject, $matches);
	return (boolean) $matches;
}
if(matchcart())
{
    include 'mobile/cart.php';
    die();	
}

function matchcheckoutsuccess(){
	global $zv_orders_id, $orders_id, $orders, $define_page, $currency;
	list($requestURI, $catalogFolder, $subject) = requestURI();
	$pattern = '/checkout_success.php/';
	preg_match($pattern, $subject, $matches);
	return (boolean) $matches; 
}
if(matchcheckoutsuccess())
{
	require(DIR_WS_CLASSES . 'order.php');
	include 'mobile/checkoutsuccess.php';
	die();
}
function matchminicart() 
{
	global $cart, $cartShowTotal, $currency, $currencies;
	list($requestURI, $catalogFolder, $subject) = requestURI();
	$pattern = '/minicart.php/';
	preg_match($pattern, $subject, $matches);
	return (boolean) $matches;
}
if(matchminicart())
{
 	header("Content-type: text/html; charset=".strtolower(CHARSET), true);
	include 'mobile/minicart.php';
	die();
}

function matchcookies() {
	global $cart, $cartShowTotal, $currency;
	list($requestURI, $catalogFolder, $subject) = requestURI();
	$pattern = '/cookies.php/';
	preg_match($pattern, $subject, $matches);
	return (boolean) $matches;
}
if(matchcookies())
{
	include 'mobile/cookies.php';
	die();
}

function matchminicartview() {
	global $cart, $cartShowTotal, $currency, $currencies;
	list($requestURI, $catalogFolder, $subject) = requestURI();
	$pattern = '/minicartview.php/';
	preg_match($pattern, $subject, $matches);
	return (boolean)$matches;
}
if(matchminicartview())
{
	include 'mobile/minicartview.php';
	die();
}

function matchcategory(){
	global $currency;

	list($requestURI, $catalogFolder, $subject) = requestURI();
	$pattern = '/category/';
	preg_match($pattern, $subject, $matches);
	if ($matches) {
		return true;
	}

	return false;
}
if(matchcategory())
{
    header("Content-type: text/html; charset=".strtolower(CHARSET), true);
  	$select_column_list = 'pd.products_name, p.products_image, ';
    $listing_sql = "select " . $select_column_list . " p.products_id, p.manufacturers_id, p.products_price, p.products_tax_class_id, IF(s.status, s.specials_new_products_price, NULL) as specials_new_products_price, IF(s.status, s.specials_new_products_price, p.products_price) as final_price from " . TABLE_PRODUCTS_DESCRIPTION . " pd, " . TABLE_PRODUCTS . " p left join " . TABLE_MANUFACTURERS . " m on p.manufacturers_id = m.manufacturers_id left join " . TABLE_SPECIALS . " s on p.products_id = s.products_id, " . TABLE_PRODUCTS_TO_CATEGORIES . " p2c where p.products_status = '1' and p.products_id = p2c.products_id and pd.products_id = p2c.products_id and pd.language_id = '" . (int)$languages_id . "' and p2c.categories_id = '" . (int)$current_category_id . "'";
    $categories_query = tep_db_query("select count(*) as total from " . TABLE_CATEGORIES . " c, " . TABLE_CATEGORIES_DESCRIPTION . " cd where c.parent_id = '" . (int)$category_links[$i] . "' and c.categories_id = cd.categories_id and cd.language_id = '" . (int)$languages_id . "'");
    $categories = tep_db_fetch_array($categories_query);
	global $listing_sql, $db, $listing_query, $categories;
	include 'mobile/category.php';
	die();
}

function matchproduct() {
	global $sql, $currency, $currencies;
	list($requestURI, $catalogFolder, $subject) = requestURI();
	$pattern = '/^\/prod\d+\.htm(?:$|\?)/';
	preg_match($pattern, $subject, $matches);
	if ($matches) {
		return true;
	}

	return false;
}
if(matchproduct()) {
	include 'mobile/product.php';
	die();
}

function matchgallery() {
	global $currency;

	list($requestURI, $catalogFolder, $subject) = requestURI();
	$pattern = '/gallery/';
	preg_match($pattern, $subject, $matches);
	if ($matches) {
		return true;
	}

	return false;
}

if(matchgallery()) {
	$select_column_list = 'pd.products_name, p.products_image, ';
	//require('includes/index_filters/default_filter.php');
	include 'mobile/gallery.php';
	die();
}

function matchsearch() {
	global $currency, $currencies;

	list($requestURI, $catalogFolder, $subject) = requestURI();
	$pattern = '/(^\/search\/?(?:$|\?)|^\/advanced_search_result.php)/';
	preg_match($pattern, $subject, $matches);
	return (boolean) $matches;
}
if(matchsearch())
{
	    $select_column_list = 'pd.products_name, p.products_image, ';
	    $listing_sql = "select " . $select_column_list . " p.products_id, p.manufacturers_id, p.products_price, p.products_tax_class_id, IF(s.status, s.specials_new_products_price, NULL) as specials_new_products_price, IF(s.status, s.specials_new_products_price, p.products_price) as final_price from " . TABLE_PRODUCTS_DESCRIPTION . " pd, " . TABLE_PRODUCTS . " p left join " . TABLE_MANUFACTURERS . " m on p.manufacturers_id = m.manufacturers_id left join " . TABLE_SPECIALS . " s on p.products_id = s.products_id, " . TABLE_PRODUCTS_TO_CATEGORIES . " p2c where p.products_status = '1' and p.products_id = p2c.products_id and pd.products_id = p2c.products_id and pd.language_id = '" . 1 . "' and pd.products_name like '%" . $_GET['keywords'] ."%'";
	    include 'mobile/search.php';
}

function matchcheckoutconfirmation(){
	
	global $zv_orders_id, $orders_id, $orders, $define_page, $currency, $tree;
	list($requestURI, $catalogFolder, $subject) = requestURI();
	$pattern = '/checkout_confirmation.php/';
	preg_match($pattern, $subject, $matches);
	if ($matches) return true;
	return false;
}
if(matchcheckoutconfirmation())
{
	if(SHIPPING_SELECTOR == "on")
		include 'mobile/checkoutshipping.php';
	else
		header("Location: " . 'http'.(empty($_SERVER['HTTPS'])?'':'s').'://'.$_SERVER['SERVER_NAME'].str_replace("checkout_confirmation", "checkout_process", $_SERVER['REQUEST_URI']) );
        die();
}

// not match above  - go to cart
function non_match_page() {

    global $bm_categories, $tree, $cart, $cartShowTotal, $currency, $currencies;

    list($requestURI, $catalogFolder, $subject) = requestURI();
    $pattern = '/(index.php\?main_page=shopping_cart|shopping_cart.php)/';

    // error log
    error_log('version=' . PROJECT_VERSION . ', requestURI=' . $requestURI, $catalogFolder, $subject);

    preg_match($pattern, $subject, $matches);

    return (boolean) $matches;
}

if (!non_match_page()) {
    include 'mobile/cart.php';
    die();
}
?>
