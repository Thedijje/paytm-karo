<?php 

require_once("lib/encdec_paytm.php");

require('ENV.php');


$paytmParams = array(
    
	/* Find your MID in your Paytm Dashboard at https://dashboard.paytm.com/next/apikeys */
	"MID" => $payment_keys['MID'],
    
	/* Find your WEBSITE in your Paytm Dashboard at https://dashboard.paytm.com/next/apikeys */
	"WEBSITE" => $payment_keys['WEBSITE'],
    
	/* Find your INDUSTRY_TYPE_ID in your Paytm Dashboard at https://dashboard.paytm.com/next/apikeys */
	"INDUSTRY_TYPE_ID" => $payment_keys['INDUSTRY_TYPE_ID'],
    
	/* WEB for website and WAP for Mobile-websites or App */
	"CHANNEL_ID" => $payment_keys['CHANNEL_ID'],
    
	/* Enter your unique order id */
	"ORDER_ID" => "1999",
    
	/* unique id that belongs to your customer */
	"CUST_ID" => "101",
    
	/* customer's mobile number */
	"MOBILE_NO" => "8826810280",
    
	/* customer's email */
	"EMAIL" => "Dheeraj@tripvenza.com",
    
	/**
	* Amount in INR that is payble by customer
	* this should be numeric with optionally having two decimal points
	*/
	"TXN_AMOUNT" => "2000.00",
    
	/* on completion of transaction, we will send you the response on this URL */
	"CALLBACK_URL" => $payment_keys['CALLBACK_URL'],
);


/**
* Generate checksum for parameters we have
* Find your Merchant Key in your Paytm Dashboard at https://dashboard.paytm.com/next/apikeys 
*/
$checksum = getChecksumFromArray($paytmParams, $payment_keys["MKEY"]);

/* for Staging */
$url = "https://securegw-stage.paytm.in/order/process";

require('status.php');

slack_notify($checksum);


?>
<html>
	<head>
		<title>Merchant Checkout Page</title>
	</head>
	<body>
		<center><h1>Please do not refresh this page...</h1></center>
		<form method='post' action='<?php echo $url; ?>' name='paytm_form'>
				<?php
					foreach($paytmParams as $name => $value) {
						echo '<input type="hidden" name="' . $name .'" value="' . $value . '">';
					}
				?>
				<input type="hidden" name="CHECKSUMHASH" value="<?php echo $checksum ?>">
		</form>
		<script type="text/javascript">
			document.paytm_form.submit();
		</script>
	</body>
</html>