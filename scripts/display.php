<?php
/**
 * This script handles the display of the dashboard
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
// echo json_encode($_POST);
require './bootstrap.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Capture Post Data that is coming from the form
$_POST = json_decode(file_get_contents('php://input'), true);
$referrer = $_POST['referrer'];

if (strpos($referrer, 'awloreg500') !== false) {
    $registeredusers = $db->query("SELECT * FROM awloreg500");
} else {
    $registeredusers = $db->query("SELECT * FROM awlorege500 WHERE referrer='{$referrer}' AND paid='yes'");
}
$data = $registeredusers->fetchAll();
echo json_encode($data);
