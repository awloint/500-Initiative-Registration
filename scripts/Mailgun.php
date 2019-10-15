<?php
/**
 * This script is the Mail Class
 *
 * PHP version 7.2
 *
 * @category Mail_Class
 * @package  Mail_Class
 * @author   Benson Imoh,ST <benson@stbensonimoh.com>
 * @license  MIT https://opensource.org/licenses/MIT
 * @link     https://stbensonimoh.com
 */
class Mailgun
{
    public $list;
    /**
     * Constructor Function
     *
     * @param string $apikey Mailgun Private API Key
     * @param string $domain Your Domain
     */
    public function __construct($apikey, $domain, $list)
    {
        $this->apikey = $apikey;
        $this->domain = $domain;
        $this->list = $list;
    }

    /**
     * Send HTML Email
     *
     * @param string $from    The email address the email is coming from
     * @param string $to      The email address the email is going to
     * @param string $subject The subject of the email
     * @param string $html    The HTML body
     *
     * @return void
     */
    public function sendHTMLEmail($from, $to, $subject, $html)
    {
        $curl = curl_init();
        $curl_post_data=array(
        'from'    => $from,
        'to'      => $to,
        'subject' => $subject,
        // 'text'    => 'This is a sample text.'
        'html'    => $html
        );

        $service_url = 'https://api.mailgun.net/v3/' . $this->domain . '/messages';
        $curl = curl_init($service_url);
        curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($curl, CURLOPT_USERPWD, "api:$this->apikey");

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);

        curl_setopt($curl, CURLOPT_POSTFIELDS, $curl_post_data);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);


        $curl_response = curl_exec($curl);
        $response = json_decode($curl_response);
        curl_close($curl);
    }

    /**
     * Insert User into Mailgun Mailing list
     *
     * @param string $email          The User's Email
     * @param string $fullName       The User's Full Name
     * @param mixed  $otherVariables Other necessary Variables
     *
     * @return void
     */
    public function insertIntoList($email, $fullName, $otherVariables)
    {
        $curl = curl_init();
        $curl_post_data=array(
        'subscribed'    => true,
        'address'      => $email,
        'name' => $fullName,
        'vars'  => $otherVariables
        );

        $service_url = 'https://api.mailgun.net/v3/lists/' . $this->list . '@' . $this->domain . '/members';
        $curl = curl_init($service_url);
        curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($curl, CURLOPT_USERPWD, "api:$this->apikey");

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);

        curl_setopt($curl, CURLOPT_POSTFIELDS, $curl_post_data);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);


        $curl_response = curl_exec($curl);
        $response = json_decode($curl_response);
        curl_close($curl);
    }
}