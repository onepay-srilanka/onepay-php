<?php

$firstname = $_REQUEST["firstname"];
$lastname = $_REQUEST["lastname"];
$email = $_REQUEST["email"];
$contact = $_REQUEST["tele"];
$studentId = $_REQUEST["stuid"];
$pay = $_REQUEST["pay"];
$reference = "1234567898";

$app_id = "6WK61187C45ECB1AB2236";
$hash_salt = "6Y781187C45ECB1AB2262";
$app_token = "39968d0267534abd8777e2b5b39778f57fc587bd36215d3ad527daa748b68863d8711c38a8086301.ZA4G1187C45ECB1AB2283";

$onepay_args = array(
  
  "amount" => floatval($pay),
  "app_id"=> $app_id,
  "reference" => "{$reference}",
  "customer_first_name" => $firstname,
  "customer_last_name"=> $lastname,
  "customer_phone_number" => $contact,
  "customer_email" => $email,
  "transaction_redirect_url" => "https://exmple.lk/respones",

);

$data=json_encode($onepay_args,JSON_UNESCAPED_SLASHES);

$data_json = $data."".$hash_salt;

$hash_result = hash('sha256',$data_json);

$curl = curl_init();

$url = 'https://merchant-api-live-v2.onepay.lk/api/ipg/gateway/request-transaction/?hash=';
$url .= $hash_result;

curl_setopt_array($curl, array(
  CURLOPT_URL => $url,
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'GET',
  CURLOPT_POSTFIELDS => $data,
  CURLOPT_HTTPHEADER => array(
    'Authorization:'."".$app_token,
    'Content-Type:application/json'
  ),
));

$response = curl_exec($curl);

curl_close($curl);

$result = json_decode($response, true);

if (isset($result['data']['gateway']['redirect_url'])) {

  $re_url = $result['data']['gateway']['redirect_url'];
  header('Location: ' . $re_url, true, $permanent ? 301 : 302);

  exit();

} else {

  echo $result['message'];

}


?> 