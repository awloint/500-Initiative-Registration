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

// Send SMS Notification
$SMS->send("AWLO-500", "This is the body of test SMS.", "+2348054610438");

// Send Email
