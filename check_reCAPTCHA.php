<?php
require('public_include.php');

$data = array(
	'secret' => __reCAPTCHA_Secret_key,
	'response' => $_POST['g-recaptcha-response'],
	'remoteip' => Func::get_client_ip()
);

$verify = curl_init();
curl_setopt($verify, CURLOPT_URL, "https://www.google.com/recaptcha/api/siteverify");
curl_setopt($verify, CURLOPT_POST, true);
curl_setopt($verify, CURLOPT_POSTFIELDS, http_build_query($data));
curl_setopt($verify, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($verify, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($verify);
curl_close($verify);
$json = json_decode($response);

if ($json->success==false) {
	//This user was not verified by recaptcha.
	echo 0;
}else if ($json->success==true) {
	//This user is verified by recaptcha
	echo 1;
}