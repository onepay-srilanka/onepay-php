<?php

// Retrieve and sanitize input parameters
$firstname = $_REQUEST["firstname"] ?? '';
$lastname = $_REQUEST["lastname"] ?? '';
$email = $_REQUEST["email"] ?? '';
$contact = $_REQUEST["tele"] ?? '';
$pay = isset($_REQUEST["pay"]) ? number_format((float)$_REQUEST["pay"], 2, '.', '') : '100.00'; // Ensure amount is formatted to two decimal places
$reference = "1234567898"; // Static reference with at least 10 characters

// Define application credentials
$app_id = "Z1DO118BFD7A68F3CA0B5";
$hash_salt = "RNSI118BFD7A68F3CA0DE";
$app_token = "84a5fc2ce89e8d76dcb6a965aeab765e1ec21a85e031cfbbc9cdba24fc6ba4f961254e388988b30e.CI47118C246A5101FF7BC";

// Generate the hash
$hash_string = $app_id . "LKR" . $pay . $hash_salt;
$hash_result = hash('sha256', $hash_string);

// Build the request payload
$request_payload = [
    "currency" => "LKR",
    "amount" => (float)$pay, // Ensure amount is a decimal value
    "app_id" => $app_id,
    "reference" => $reference,
    "customer_first_name" => $firstname,
    "customer_last_name" => $lastname,
    "customer_phone_number" => $contact,
    "customer_email" => $email,
    "transaction_redirect_url" => "https://example.lk/response",
    "hash" => $hash_result,
    "additional_data" => "sample"
];

// Encode the payload to JSON
$data = json_encode($request_payload, JSON_UNESCAPED_SLASHES);

// Configure cURL for API request
$curl = curl_init();

curl_setopt_array($curl, [
    CURLOPT_URL => 'https://api.onepay.lk/v3/checkout/link/',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_POSTFIELDS => $data,
    CURLOPT_HTTPHEADER => [
        'Authorization: ' . $app_token,
        'Content-Type: application/json'
    ],
]);

// Execute the cURL request and handle the response
$response = curl_exec($curl);
curl_close($curl);

$result = json_decode($response, true);

// Redirect or handle errors based on the response
if (isset($result['data']['gateway']['redirect_url'])) {
    header('Location: ' . $result['data']['gateway']['redirect_url'], true, 302);
    exit();
} else {
    echo $result['message'] ?? "An unexpected error occurred.";
}

?>
