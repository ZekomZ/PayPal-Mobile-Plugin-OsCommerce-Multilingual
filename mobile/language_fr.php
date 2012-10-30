<?php
$_['Products'] = "Produits";
$_['Featured Products'] = "Top produits";
$_['Oops'] = "Oops";
$_['Total'] = "Total";
$_['Sorry the page you visited does not exist'] = "Désolé, la page que vous avez visité n'existe pas";
$_['Cart'] = $_['cart'] = "Panier";
$_['Name'] = "Nom";
$_['Price']= "Prix";
$_['Delete'] = "Delete";
$_['TITLE'] = "TITRE";
$_['Qty'] = $_['qty'] =  "Quantité";
$_['Thank You! We Appreciate your Business!'] = "Nous vous remercions de votre confiance. Détails de votre commande";
$_['OsCommerce'] = "OsCommerce";
$_['cookies'] = "Désolé, les cookies ne sont pas actuellement activé sur votre navigateur, les cookies sont nécessaires pour acheter sur ce site, vous serez en mesure de trouver une préférence dans le navigateur de votre téléphone pour les réactiver à nouveau si vous le souhaitez";
$_['You can click here once you have enabled them again to start shopping.'] = 'You can <a href="./">click here</a>once you have enabled them again to start shopping.';
$_['Done'] = "fini";
$_['Home'] = "Accueil";
$_['Your search has produced no results'] = "Aucun résultat trouvé";
$_['Categories'] = "Catégories";
$_['Search'] = "Recherche";
$_['OR'] = "OU";
 $_['Cookies are not enabled'] = "les cookies ne sont pas actuellement activé";
$_['Your customer id:'] = "Votre numéro client:";
$_['Cookies are not enabled'] = "Cookies are not enabled";
$_['Results'] = "Résultats";
$_['More info...'] = "Plus d'infos";
$_['You can'] = "Vous pouvez";
$_['click here'] = "Cliquer ici";
$_['once you have enabled them again to start shopping.'] = "une fois que vous les avez réactiver pour continuer vos achats.";
$_['Your cart is empty'] =$_L['Your cart is empty']= "Votre panier est vide";
$_['Shopping Cart'] = "Panier";
$_['Edit...'] = "Modifier";
$_['Product'] = "Product";
$_['OR'] = "OU";
$_['Gallery'] = "galerie";
$_['Continue Shopping'] = "Continuer vos achats";
$_['clear text'] = "texte clair";
$_['Return to Desktop site']  = "Revenir à la version web";
$_['Search Results'] = "Résultats de la recherche";
$_['Add to Cart'] = "Ajouter au panier";
$_['Update Cart'] = "Mettre à jour le panier";
$_['Edit Cart'] = "Modifier le panier";
$_['There is no description for this product'] = 'There is no description for this product';
$_['You have x items in your cart the total is y'] = 'Votre panier contient <span class="itemcount">{count}</span> article(s).<br/>Total: <span class="total">{total}</span>';
$_['Your order number is x'] = "Votre numéro de commande : {order}";
$_['You have'] = "vous avez";
$_['items in your cart'] = "articles dans votre panier";
$_['the total is'] = "le total est";
$_['Product Options'] = "options du produit";
$_['No Products in this category'] = "Pas de produits dans cette catégorie";
$_['Go'] = "Go";

$_['Address'] = "Adresse";
$_['Billing Address'] = "Adresse de facturation";
$_['Shipping Address'] = "Adresse de livraison";
$_['Addresses'] = "Les adresses";
$_['Pay Now'] = "Payer Maintenant";

foreach($_ as $k => $v){	
$_[$k] =  iconv("ISO-8859-1//TRANSLIT",CHARSET, $v);
}
