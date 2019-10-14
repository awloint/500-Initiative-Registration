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

// // Send SMS Notification
// $SMS->send("AWLO-500", "Dear {$firstName} {$lastName}, your registration was successful! We are super excited about this huge step you have taken by registering for the AWLO-500 Capacity Building Workshop. Kindly check your email for more details.", $phone);

// Send Email
// $mg->sendHTMLEmail("AWLO-500 Workshop <500@awlo.org>", $email, "AWLO-500 Capacity Building Workshop", $emailBody);

// Insert user into the mailing list
// $mg->insertIntoList($email, $fullName, $otherVariables);