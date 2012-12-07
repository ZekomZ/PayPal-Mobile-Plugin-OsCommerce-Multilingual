<?php
// if the customer is not logged on, redirect them to the login page
if (!tep_session_is_registered('customer_id')) {
    $navigation->set_snapshot();
    //tep_redirect(tep_href_link(FILENAME_LOGIN, '', 'SSL'));
}

// if there is nothing in the customers cart, redirect them to the shopping cart page
if ($cart->count_contents() < 1) {
    tep_redirect(tep_href_link(FILENAME_SHOPPING_CART));
}

// if no shipping destination address was selected, use the customers own address as default
if (!tep_session_is_registered('sendto')) {
    tep_session_register('sendto');
    $sendto = $customer_default_address_id;
} else {
// verify the selected shipping address
    if ((is_array($sendto) && empty($sendto)) || is_numeric($sendto)) {
        $check_address_query = tep_db_query("select count(*) as total from " . TABLE_ADDRESS_BOOK . " where customers_id = '" . (int) $customer_id . "' and address_book_id = '" . (int) $sendto . "'");
        $check_address = tep_db_fetch_array($check_address_query);

        if ($check_address['total'] != '1') {
            $sendto = $customer_default_address_id;
            if (tep_session_is_registered('shipping'))
                tep_session_unregister('shipping');
        }
    }
}

require(DIR_WS_CLASSES . 'order.php');
$order = new order;

// register a random ID in the session to check throughout the checkout procedure
// against alterations in the shopping cart contents
if (!tep_session_is_registered('cartID'))
    tep_session_register('cartID');
$cartID = $cart->cartID;

// if the order contains only virtual products, forward the customer to the billing page as
// a shipping address is not needed
if ($order->content_type == 'virtual') {
    if (!tep_session_is_registered('shipping'))
        tep_session_register('shipping');
    $shipping = false;
    $sendto = false;
    tep_redirect(tep_href_link(FILENAME_CHECKOUT_PAYMENT, '', 'SSL'));
}

$total_weight = $cart->show_weight();
$total_count = $cart->count_contents();

// load all enabled shipping modules
require(DIR_WS_CLASSES . 'shipping.php');
$shipping_modules = new shipping;

if (defined('MODULE_ORDER_TOTAL_SHIPPING_FREE_SHIPPING') && (MODULE_ORDER_TOTAL_SHIPPING_FREE_SHIPPING == 'true')) {
    $pass = false;

    switch (MODULE_ORDER_TOTAL_SHIPPING_DESTINATION) {
        case 'national':
            if ($order->delivery['country_id'] == STORE_COUNTRY) {
                $pass = true;
            }
            break;
        case 'international':
            if ($order->delivery['country_id'] != STORE_COUNTRY) {
                $pass = true;
            }
            break;
        case 'both':
            $pass = true;
            break;
    }

    $free_shipping = false;
    if (($pass == true) && ($order->info['total'] >= MODULE_ORDER_TOTAL_SHIPPING_FREE_SHIPPING_OVER)) {
        $free_shipping = true;

        include(DIR_WS_LANGUAGES . $language . '/modules/order_total/ot_shipping.php');
    }
} else {
    $free_shipping = false;
}

// process the selected shipping method
if (isset($HTTP_POST_VARS['action']) && ($HTTP_POST_VARS['action'] == 'process')) {
    if (!tep_session_is_registered('comments'))
        tep_session_register('comments');
    if (tep_not_null($HTTP_POST_VARS['comments'])) {
        $comments = tep_db_prepare_input($HTTP_POST_VARS['comments']);
    }

    if (!tep_session_is_registered('shipping'))
        tep_session_register('shipping');

    if ((tep_count_shipping_modules() > 0) || ($free_shipping == true)) {
        if ((isset($HTTP_POST_VARS['shipping'])) && (strpos($HTTP_POST_VARS['shipping'], '_'))) {
            $shipping = $HTTP_POST_VARS['shipping'];

            list($module, $method) = explode('_', $shipping);
            if (is_object($$module) || ($shipping == 'free_free')) {
                if ($shipping == 'free_free') {
                    $quote[0]['methods'][0]['title'] = FREE_SHIPPING_TITLE;
                    $quote[0]['methods'][0]['cost'] = '0';
                } else {
                    $quote = $shipping_modules->quote($method, $module);
                }
                if (isset($quote['error'])) {
                    tep_session_unregister('shipping');
                } else {
                    if ((isset($quote[0]['methods'][0]['title'])) && (isset($quote[0]['methods'][0]['cost']))) {
                        $shipping = array('id' => $shipping,
                            'title' => (($free_shipping == true) ? $quote[0]['methods'][0]['title'] : $quote[0]['module'] . ' (' . $quote[0]['methods'][0]['title'] . ')'),
                            'cost' => $quote[0]['methods'][0]['cost']);

                        tep_redirect(tep_href_link(FILENAME_CHECKOUT_PAYMENT, '', 'SSL'));
                    }
                }
            } else {
                tep_session_unregister('shipping');
            }
        }
    } else {
        $shipping = false;

        tep_redirect(tep_href_link(FILENAME_CHECKOUT_PAYMENT, '', 'SSL'));
    }
}

// get all available shipping quotes
$quotes = $shipping_modules->quote();

// if no shipping method has been selected, automatically select the cheapest method.
// if the modules status was changed when none were available, to save on implementing
// a javascript force-selection method, also automatically select the cheapest shipping
// method if more than one module is now enabled
if (!tep_session_is_registered('shipping') || ( tep_session_is_registered('shipping') && ($shipping == false) && (tep_count_shipping_modules() > 1) ))
    $shipping = $shipping_modules->cheapest();

require(DIR_WS_LANGUAGES . $language . '/' . FILENAME_CHECKOUT_SHIPPING);
?>
<?php $is_cart_page=true; include 'header.php'; ?>

<style>
    table.reviewaddresses td{
        text-align:left;
        vertical-align:top;

    }
    table.reviewaddresses td:last-child{
        padding-left:10px;

    }
    .ui-field-contain{
        border-bottom-width:0 !important;
    }
    hr.underline{
        padding-top: 10px;
    }
    .moduleRow td{
        cursor:pointer;
    }
    /*.moduleRow.active td{
        background-color: #ecf2f9; 
    } */
    .email{
        display: block;
        text-overflow: ellipsis;
        overflow: hidden;
    }
</style>
<script>
    function selectRowEffect(x,y) {
        return true;
    }
    $(function(){
        var total = $(".total").text();
	
        $("tr.moduleRow td").click(function(){
            var row = $(this).closest('tr');
            if(! row.find("[name=shipping]").is(":checked") )
            {
				
                row.find("[name=shipping]").attr("checked","checked");
                $("tr.active").removeClass("active");
                row.addClass("active");

                $("[type=submit]").attr('disabled','disabled').closest("div.ui-btn").css("opacity", "0.4");
		
				
                $.ajax({
                    data: {action:"process", shipping: $("[name=shipping]:checked").val()},
                    type: "POST",
                    success: function(r){
                        $("[type=submit]").removeAttr('disabled').closest("div.ui-btn").css("opacity", "1");
                    }
                });

                var price = row.find("td:nth-child(3)").text().match(/\d+\.\d+/);
                var first = $("tr.moduleRowSelected td:nth-child(3)").text().match(/\d+\.\d+/);
                $(".total").html(total - parseFloat(first) + parseFloat(price));
				
				
            }
			
        });
        $("tr.moduleRowSelected").addClass("active");

    });
</script>

<form id="cartform" method="post" action="checkout_process.php" data-ajax="false">
    <div id="main-page">

        <div id="subhead">
            <h3 class="page"><?php echo BOX_HEADING_REVIEWS; ?></h3>
            <div class="logo user"></div>
        </div> 
               
            <div id="checkoutaddresses" style="margin:10px 15px;">
                <ul data-role="listview" data-inset="true" class="products ui-listview ui-listview-inset ui-corner-all ui-shadow" >
                    <li data-role="list-divider" role="heading" class="ui-li ui-li-divider ui-btn ui-bar-b ui-btn-up-undefined ui-corner-top">
                        <?php echo $_['Billing Address'] ?>
                    </li>
                    <li style="text-align:center; padding:2px;" class="ui-li ui-li-static ui-body-c">
                        <table class="reviewaddresses" width="100%">
                            <tbody><tr>
                                    <td width="20%"><?php echo $_['Name'] ?>:</td><td><?php echo  stripslashes($_SESSION['billto']['firstname'] . " " . $_SESSION['billto']['lastname']) ?></td>
                                </tr>

                                <tr>
                                    <td><?php echo $_['Address'] ?>:</td>
                                    <td>
<?php echo stripslashes($_SESSION['billto']['street_address']) ?><br>
<?php if ($_SESSION['billto']['suburb']) echo stripslashes($_SESSION['billto']['suburb']).'<br>'; ?>
<?php echo stripslashes($_SESSION['billto']['city']) ?>, <?php echo stripslashes($_SESSION['billto']['postcode']) ?>
                                    </td>
                                </tr>

                                <tr>
                                    <td><?php echo $_['Email'] ?></td>
                                    <td><span class="email" style="text-overflow:ellipsis;width:80%" title="<?php echo $order->customer['email_address'] ?>"><?php echo  stripslashes($order->customer['email_address']) ?></span></td>
                                </tr>
                            </tbody></table>
                    </li>
                    <li data-role="list-divider" role="heading" class="ui-li ui-li-divider ui-btn ui-bar-b ui-btn-up-undefined">
                          <?php echo $_['Shipping Address'] ?>
                    </li>
                    <li style="text-align:center; padding:2px;" class="ui-li ui-li-static ui-body-c ui-corner-bottom">
                        <table class="reviewaddresses" width="100%">
                            <tbody>
                                <tr>
                                    <td width="20%"><?php echo $_['Name'] ?>:</td><td><?php echo stripslashes($_SESSION['sendto']['firstname'] . " " . $_SESSION['sendto']['lastname']) ?></td>
                                </tr>

                                <tr>
                                    <td><?php echo $_['Address'] ?>:</td>
                                    <td>
<?php echo stripslashes($_SESSION['sendto']['street_address']) ?><br>
<?php if($_SESSION['sendto']['suburb']) echo stripslashes($_SESSION['sendto']['suburb']).'<br>'; ?>
<?php echo stripslashes($_SESSION['sendto']['city']) ?>, <?php echo stripslashes($_SESSION['sendto']['postcode']) ?>
                                    </td>
                                </tr>
                                <tr style="display:none">
                                    <td>Email</td>
                                    <td></td>
                                </tr>
                            </tbody></table>
                    </li>
                </ul>
            </div>





        <div data-role="content"  class="ui-corner-all ui-corner-all ui-shadow" data-theme="c" style="margin:15px;">
            <fieldset>
                <div data-role="fieldcontain">
                    <table border="0" width="100%" cellspacing="1" cellpadding="2" class="infoBox">
                        <tr class="infoBoxContents">
                            <td><table border="0" width="100%" cellspacing="0" cellpadding="2">
                                        <?php if (sizeof($quotes) > 1 && sizeof($quotes[0]) > 1) { ?>
                                        <tr>
                                            <td><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
                                            <td class="main" width="50%" valign="top"><?php echo TEXT_CHOOSE_SHIPPING_METHOD; ?></td>
                                            <td class="main" width="50%" valign="top" align="right"><?php echo '<b>' . TITLE_PLEASE_SELECT . '</b><br>' . tep_image(DIR_WS_IMAGES . 'arrow_east_south.gif'); ?></td>
                                            <td><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
                                        </tr>
    <?php
} elseif ($free_shipping == false) {
    ?>
                                        <tr>
                                            <td><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
                                            <td class="main" width="100%" colspan="2"><?php echo TEXT_ENTER_SHIPPING_INFORMATION; ?></td>
                                            <td><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
                                        </tr>
                                        <?php
                                    }

                                    if ($free_shipping == true) {
                                        ?>
                                        <tr>
                                            <td><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
                                            <td colspan="2" width="100%"><table border="0" width="100%" cellspacing="0" cellpadding="2">
                                                    <tr>
                                                        <td width="10"><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
                                                        <td class="main" colspan="3"><b><?php echo FREE_SHIPPING_TITLE; ?></b>&nbsp;<?php echo $quotes[$i]['icon']; ?></td>
                                                        <td width="10"><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
                                                    </tr>
                                                    <tr id="defaultSelected" class="moduleRowSelected" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)" onclick="selectRowEffect(this, 0)">
                                                        <td width="10"><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
                                                        <td class="main" width="100%"><?php echo sprintf(FREE_SHIPPING_DESCRIPTION, $currencies->format(MODULE_ORDER_TOTAL_SHIPPING_FREE_SHIPPING_OVER)) . tep_draw_hidden_field('shipping', 'free_free'); ?></td>
                                                        <td width="10"><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
                                                    </tr>
                                                </table></td>
                                            <td><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td> 
                                        </tr>
                                        <?php
                                    } else {
                                        $radio_buttons = 0;
                                        for ($i = 0, $n = sizeof($quotes); $i < $n; $i++) {
                                            ?>
                                            <tr>
                                                <td><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
                                                <td colspan="2">

       <table border="0" width="100%" cellspacing="0" cellpadding="2">                                                                                                               
        <?php
            if (isset($quotes[$i]['error'])) {
        ?>
                                                            <tr>
                                                                <td width="10"><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
                                                                <td class="main" colspan="3"><?php echo $quotes[$i]['error']; ?></td>
                                                                <td width="10"><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
                                                            </tr>
        <?php
        } else {
            for ($j = 0, $n2 = sizeof($quotes[$i]['methods']); $j < $n2; $j++) {
// set the radio button to be checked if it is the method chosen
                 $checked = (($quotes[$i]['id'] . '_' . $quotes[$i]['methods'][$j]['id'] == $shipping['id']) ? true : false);

                 if (($checked == true) || ($n == 1 && $n2 == 1)) {
                                                                    echo '                  <tr id="defaultSelected" class="moduleRow moduleRowSelected" >' . "\n";
                 } else {
                                                                    echo '                  <tr class="moduleRow" >' . "\n";
                                                                }
         ?>
          <td width="10"><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
          <td class="main" width="75%"><b><?php echo $quotes[$i]['module']; ?></b> - <?php echo $quotes[$i]['methods'][$j]['title']; ?></td>
                                                                    <?php
                                                                    if (($n > 1) || ($n2 > 1)) {
                                                                        ?>
                                                                    <td class="main" align="right"><?php echo $currencies->format(tep_add_tax($quotes[$i]['methods'][$j]['cost'], (isset($quotes[$i]['tax']) ? $quotes[$i]['tax'] : 0))); ?></td>
                                                                    <td class="main" align="right">
                                                                    <?php echo tep_draw_radio_field('shipping', $quotes[$i]['id'] . '_' . $quotes[$i]['methods'][$j]['id'], $checked, "id=\"" . $quotes[$i]['id'] . '_' . $quotes[$i]['methods'][$j]['id'] . "\" style='display:none'"); ?>
                                                                    </td>
                                                                    <?php
                                                                } else {
                                                                    ?>
                                                                    <td class="main" align="right" colspan="2"><?php echo $currencies->format(tep_add_tax($quotes[$i]['methods'][$j]['cost'], $quotes[$i]['tax'])) . tep_draw_hidden_field('shipping', $quotes[$i]['id'] . '_' . $quotes[$i]['methods'][$j]['id']); ?></td>
                                                        <?php
                                                    }
                                                    ?>
                                                                <td width="10"><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
                                                    </tr>
                                                    <?php
                                                    $radio_buttons++;
                                                }
                                            }
                                            ?>
                                        </table>


                                    </td>
                                    <td><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td> 
                                </tr>
        <?php
    }
}
?>
                    </table></td>
                    </tr>
                    </table>

                    </select>
                </div>
                <div data-role="fieldcontain">
                    <table width='100%'>
                        <?php
                        for ($i = 0, $n = sizeof($order->products); $i < $n; $i++) {
                            echo '          <tr>' . "\n" .
                            '<td>'.tep_draw_separator('pixel_trans.gif', '10', '1') .
                            '</td>'.
                            '            <td class="main" align="right" valign="top" width="30">' . $order->products[$i]['qty'] . '&nbsp;x</td>' . "\n" .
                            '            <td class="main" valign="top">' . $order->products[$i]['name'];

                            if (STOCK_CHECK == 'true') {
                                echo tep_check_stock($order->products[$i]['id'], $order->products[$i]['qty']);
                            }

                            if ((isset($order->products[$i]['attributes'])) && (sizeof($order->products[$i]['attributes']) > 0)) {
                                for ($j = 0, $n2 = sizeof($order->products[$i]['attributes']); $j < $n2; $j++) {
                                    echo '<br><nobr><small>&nbsp;<i> - ' . $order->products[$i]['attributes'][$j]['option'] . ': ' . $order->products[$i]['attributes'][$j]['value'] . '</i></small></nobr>';
                                }
                            }

                            echo '</td>' . "\n";

                            if (sizeof($order->info['tax_groups']) > 1)
                                echo '            <td class="main" valign="top" align="right">' . tep_display_tax_value($order->products[$i]['tax']) . '%</td>' . "\n";

                            echo '            <td class="main" align="right" style="padding-right:42px" valign="top">' . $currencies->display_price($order->products[$i]['final_price'], $order->products[$i]['tax'], $order->products[$i]['qty']) . '</td>' . "\n" .
                            '          </tr>' . "\n";
                        }
                        ?>
                    </table>
                </div>
                <div align="right" style="padding-right:42px"><?php echo $_['Total'] ?>: <span class="total"><?php echo $order->info['total'] ?></span></div>
                
                <button type="submit" data-theme="e" value="submit-value" data-role="button" class="ui-body"><?php echo $_['Pay Now'] ?></button>
                
            </fieldset>

        </div>
    </div>
</form>

<?php include 'footer.php'; ?>
