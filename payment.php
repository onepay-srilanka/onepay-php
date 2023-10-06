<?php

$firstname = $_REQUEST["firstname"];
$lastname = $_REQUEST["lastname"];
$email = $_REQUEST["email"];
$contact = $_REQUEST["tele"];
$studentId = $_REQUEST["stuid"];
$pay = $_REQUEST["pay"];
$reference = "1234567898";

$app_id = "Z1DO118BFD7A68F3CA0B5";
$hash_salt = "RNSI118BFD7A68F3CA0DE";
$app_token = "84a5fc2ce89e8d76dcb6a965aeab765e1ec21a85e031cfbbc9cdba24fc6ba4f961254e388988b30e.CI47118C246A5101FF7BC";

$onepay_args = array(
  
  "amount" => $pay, //only upto 2 decimal points
  "currency" => "LKR", //LKR OR USD
  "app_id"=> $app_id,
  "reference" => "{$reference}", //must have 10 or more digits , spaces are not allowed
  "customer_first_name" => $firstname, // spaces are not allowed
  "customer_last_name"=> $lastname, // spaces are not allowed
  "customer_phone_number" => $contact, //must start with +94, spaces are not allowed
  "customer_email" => $email, // spaces are not allowed
  "transaction_redirect_url" => "https://exmple.lk/respones", // spaces are not allowed
  "additional_data" => "sample" //only support string, spaces are not allowed, this will return in response also
);

$data=json_encode($onepay_args,JSON_UNESCAPED_SLASHES);

$data_json = $data."".$hash_salt;

$hash_result = hash('sha256',$data_json);

$curl = curl_init();

$url = 'https://merchant-api-live-v2.onepay.lk/api/ipg/gateway/request-payment-link/?hash=';
$url .= $hash_result;

curl_setopt_array($curl, array(
  CURLOPT_URL => $url,
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
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
