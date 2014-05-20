<?php 
/*
$db1 = new ps_DB(); 
$q = "SELECT country_2_code FROM #__vm_country WHERE country_3_code='".$user->country."' ORDER BY country_2_code ASC"; 
$db1->query($q); 

$url = "https://www.moneybookers.com/app/payment.pl"; 
$tax_total = $db->f("order_tax") + $db->f("order_shipping_tax"); 
$discount_total = $db->f("coupon_discount") + $db->f("order_discount"); 



$post_variables = Array( 
	"pay_to_email" => MB_EMAIL, 
	"detail1_description" => $VM_LANG->_('PHPSHOP_ORDER_PRINT_PO_NUMBER').": ". $db->f("order_id"), 
	"transaction_id" => $db->f("order_number"), 
	"detail1_text" => $db->f("order_id"), 
	"amount" => $db->f("order_total"), 
	"currency" => $db->f("order_currency"), 
	"firstname" => $dbbt->f('first_name'), 
	"lastname" => $dbbt->f('last_name'), 
	"address" => $dbbt->f('address_1'), 
"address2" => $dbbt->f('address_2'), 
"postal_code" => $dbbt->f('zip'), 
"city" => $dbbt->f('city'), 
"hide_login" => "1" , 
"recipient_description" => $vendor_name, 
"country" => $dbbt->f('country'), 
"pay_from_email" => $dbbt->f('user_email'), 
"phone_number" => $dbbt->f('phone_1'), 
"logo_url" => "http://www.moneybookers.com/creatives/pay_below_5.gif", 
"status_url2" => "mailto:" . MB_EMAIL, 
"return_url" => SECUREURL ."index.php?option=com_virtuemart&page=checkout.resultmb&order_id=".$db->f("order_id"), 
"status_url" => SECUREURL ."administrator/components/com_virtuemart/notifymb.php", 
"cancel_url" => SECUREURL ."index.php", 
"merchant_fields" => "softwareproviderjum, order_id" , 
"softwareproviderjum" => "joomvm" , 
"order_id" => $db->f("order_id") , 
"new_window_redirect" => "1", 
"language" => "EN" , 
"payment_methods" => "ACC", 

);  */



echo "<div align=\"center\"><iframe name=\"iframe\" width=\"500\" height=\"700\" src=\"".( @$url . $query_string ). 
"\" scrolling=\"No\" marginwidth=\"0\" marginheight=\"0\"". 
" frameborder=\"No\" id=\"alexiframe\"></iframe> </div>"; 

echo '<form action="'.$url.'" method="post" target="_blank">'; 
echo '<input type="image" name="submit" src="http://www.moneybookers.com/images/logos/checkout_logos/checkout_240x80px.gif" border="0" alt="Click to pay with Moneybookers - it is fast, free and secure!" />'; 

foreach( $post_variables as $name => $value ) { 
echo '<input type="hidden" name="'.$name.'" value="'.htmlspecialchars($value).'" />'; 
} 
echo '</form>'; 

?> “
