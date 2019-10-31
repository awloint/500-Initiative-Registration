<?php
/**
 * This script checks if the user already exists
 *
 * PHP version 7.2
 *
 * @category Registration
 * @package  Registration
 * @author   Benson Imoh,ST <benson@stbensonimoh.com>
 * @license  GPL https://opensource.org/licenses/gpl-license
 * @version  GIT: 1.0
 * @link     https://stbensonimoh.com
 */
// error_reporting(E_ALL);
// ini_set('display_errors', 1);
$_POST = json_decode(file_get_contents("php://input"), true);

require './bootstrap.php';

$email = $_POST['email'];

if ($db->userExists($email, "awlo500reg")) {
    // Check to see if the user has paid
    // echo json_encode("user_exists");
    if ($db->userExistsAndPaid($email, "awlo500reg")) {
        echo json_encode("user_exists");
    } else {
        // Select the user
        $result = $db->userSelect($email, "awlo500reg");
        // get the phone number
        foreach ($result as $key => $value) {
            ${$key} = $value;
        }
        $amount = 15000;

        // Run CURL
        $curl = curl_init();
        $redirect_url = "https://awlo.org/500/register/scripts/verify.php";

        curl_setopt_array(
            $curl,
            array(
            CURLOPT_URL => "https://api.ravepay.co/flwv3-pug/getpaidx/api/v2/hosted/pay",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode(
                [
                'amount'    =>  $amount,
                'customer_email' => $email,
                'customer_phone' => $phone,
                'customer_firstname' => $firstName,
                'customer_lastname' => $lastName,
                'custom_title' => 'AWLO-500',
                'custom_logo' => 'https://awlo.org/wp-content/uploads/2019/01/awlox120.png',
                'custom_description' => 'Enterprise Growth, Business Coaching, Access to Finance.',
                'currency' => 'NGN',
                'txref' =>  $transactionRef,
                'PBFPubKey' => $raveKey,
                'redirect_url' => $redirect_url
                ]
            ),
            CURLOPT_HTTPHEADER => [
                "content-type: application/json",
                "cache-control: no-cache"
            ],
            )
        );

        $response = curl_exec($curl);
        $err = curl_error($curl);
        $transaction = json_decode($response);

        echo $transaction->data->link;
    }
} else {
    echo json_encode("no_user");
}
