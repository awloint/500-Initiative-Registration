<?php
/**
 * This script verifies the trnasaction
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
error_reporting(E_ALL);
ini_set('display_errors', 1);
// $_POST = json_decode(file_get_contents("php://input"), true);

require './bootstrap.php';

if (isset($_GET['txref'])) {
    $ref = $_GET['txref'];
    $amount = 25000;
    $currency = 'NGN';
    $query = array(
        "SECKEY"    => $raveSecKey,
        "txref"     => $ref
    );

    $data_string = json_encode($query);

    $ch = curl_init('https://api.ravepay.co/flwv3-pug/getpaidx/api/v2/verify');
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

    $response = curl_exec($ch);

    $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
    $header = substr($response, 0, $header_size);
    $body = substr($response, $header_size);

    curl_close($ch);

    $resp = json_decode($response, true);

    $paymentStatus = $resp['data']['status'];
    $chargeResponsecode = $resp['data']['chargecode'];
    $chargeAmount = $resp['data']['amount'];
    $chargeCurrency = $resp['data']['currency'];

    if (($chargeResponsecode == "00" || $chargeResponsecode == "0") && ($chargeAmount == $amount)  && ($chargeCurrency == $currency)) {
        // transaction was successful...
        // please check other things like whether you already gave value for this ref
        // if the email matches the customer who owns the product etc
        $email = $resp['data']['custemail'];

        $date = date("Y-m-d H:i:s");
        $details = array(
            "paid" => "yes",
            "paid_at" => $date,
        );

        // Update the database with paid
        if ($db->updatePaid("awlo500reg", $details, "email", $email)) {
            // Select the user
            $result = $db->userSelect($email, "awlo500reg");
            // get the phone number
            foreach ($result as $key => $value) {
                ${$key} = $value;
            }

            $fullName = $firstName . ' ' . $lastName;
            $vars = [
            'phone' =>  $phone,
            'occupation' => $occupation
            ];

            $otherVariables = '{"phone": "$phone", "occupation": "$occupation"}';

            // Load Email
            require './emails.php';


            //Give Value and return to Success page
            header('Location: ../success.html');

            // Send SMS Notification
            $SMS->send("AWLO-500", "Dear {$firstName} {$lastName}, your registration was successful! We are super excited about this huge step you have taken by registering for the AWLO-500 Capacity Building Workshop. Kindly check your email for more details.", $phone);

            // Send Email
            $mg->sendHTMLEmail("AWLO-500 Workshop <500@awlo.org>", $email, "AWLO-500 Capacity Building Workshop", $emailBody);

            // Insert user into the mailing list
            $mg->insertIntoList($email, $fullName, $otherVariables);
        }
    } else {
        //Dont Give Value and return to Failure page
    }
} else {
    die('No reference supplied');
}
