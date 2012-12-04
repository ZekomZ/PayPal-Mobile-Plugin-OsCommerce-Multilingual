<!DOCTYPE html>
<html lang="<?php echo $_SESSION['languages_code'] ?>">
<head>
    <title><?php echo TITLE; ?></title>
    <meta http-equiv="Content-Type" content="text/html; charset=<?php echo strtolower(CHARSET) ?>">
    <link rel="search" type="application/opensearchdescription+xml" href="osd.xml" title="<?php echo $_['Search']; ?>"/>

	<script type="text/javascript">
		document.cookie = "checkit=checkit;";
		if(!/checkit/i.test(document.cookie))
		{
			window.location = "/cookies.php";
		}

		var language = { 
			code: "<?php echo $_SESSION['languages_code'] ?>",
			id: "<?php echo $_SESSION['languages_id'] ?>",
			language: "<?php echo $_SESSION['language'] ?>",
			paypal: "<?php echo $_SESSION['PaypalLanguages']['language'] ?>",
		};
		language.checkoutWithPaypal = "<?php echo $_SESSION['PaypalLanguages']['checkoutWithPaypal'] ?>";
		language.checkoutWithPaypalDown = "<?php echo $_SESSION['PaypalLanguages']['checkoutWithPaypalDown'] ?>";
	</script>

	<script src="mobile/js/jquery-1.6.2.min.js"></script>
	<script src="mobile/js/jquery.mobile-1.0b3.min.js"></script>
	<script type="text/javascript" src="mobile/js/ezi-mobile.js?3"></script>

	<link rel="stylesheet" href="mobile/css/jquery.mobile-1.0b3.min.css" />
	<link rel="stylesheet" type="text/css" href="mobile/css/style.css" />
  
	<link rel="stylesheet" type="text/css" href="mobile/css/cart.css" />
	<link rel="stylesheet" type="text/css" href="mobile/css/checkout.css" />
	<link rel="stylesheet" type="text/css" href="mobile/css/style_shipping.css" />
  
	<link rel="apple-touch-icon" href="../includes/templates/classic/images/logo.gif">
	<meta name="viewport" content="width=device-width, minimum-scale=1, maximum-scale=1"> 
	<meta name="apple-mobile-web-app-capable" content="yes" />
		
</head>

<body class="{documentclass}" id="{documentid}" >

<div id="mainpage" style="background-color:#ECF2F9;min-height:1000px">

	<div align="center" id="checkouthead">	
        <div id="merchant">
          <b><?php echo STORE_NAME; ?></b>
        </div>
        <div id="exit">
             <a href="<?php echo DIR_WS_CATALOG ?>"><div class="nav"></div></a>
        </div>				
	</div><!-- /header -->	

	<div id="content" data-role="content">	
  <div class="segment"></div>
