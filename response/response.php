<!-- This is sample code for read response for after each transaction. you need to host this file in your server and provide us url in our portal (callback url) -->

<!-- Sample response -> {'transaction_id': 'E2D51187B9A137DB7E867', 'pl_ref_no': '', 'status': 1, 'status_message': 'SUCCESS'} -->

<?php
$inputJSON = file_get_contents('php://input');
$input = json_decode($inputJSON, TRUE);
echo $input['transaction_id'];
echo $input['status'];
?>
