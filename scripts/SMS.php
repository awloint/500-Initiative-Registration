<?php
/**
 * This script is the SMS Class
 *
 * PHP version 7.2
 *
 * @category SMS_Class
 * @package  SMS_Class
 * @author   Benson Imoh,ST <benson@stbensonimoh.com>
 * @license  MIT https://opensource.org/licenses/MIT
 * @link     https://stbensonimoh.com
 */
class SMS
{
    /**
     * Constructor Function
     *
     * @param string $smstoken The token for the SMS API
     */
    public function __construct($smstoken)
    {
        $this->smstoken = $smstoken;
    }

    /**
     * Send SMS
     *
     * @param string $from  The Sender ID
     * @param string $body  The body of the SMS
     * @param string $phone The phone number of the recipient
     *
     * @return void
     */
    public function send($from, $body, $phone)
    {
        // prepare the parameters
        $url = 'https://www.bulksmsnigeria.com/api/v1/sms/create';
        $token = $this->smstoken;
        $myvars = 'api_token=' . $token . '&from=' . $from . '&to='
                    . $phone . '&body=' . $body;
        //start CURL
        // create curl resource
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $myvars);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_exec($ch);
    }
}
