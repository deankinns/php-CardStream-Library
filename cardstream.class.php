<?php

class CardStream
{
    /**
     * CardStream Hosted API Endpoint
     *
     * @var string
     */
    public $form_url = "https://gateway.cardstream.com/hosted/";

    /**
     * CardStream Direct API Endpoint
     *
     * @var string
     */
    public $direct_url = "https://gateway.cardstream.com/direct/";

    /**
     * CardStream secet key, defined below is the test account details
     * please override this when moving from TEST to LIVE
     *
     * $api->secret = 'NewSecretStrongerThanThis';
     *
     * then
     *
     * $api->signRequest($req);
     *
     * or
     *
     * $api->signRequest($req, 'NewSecretStrongerThanThis');
     *
     * @var string
     */
    public $secret = "Circle4Take40Idea";

    function makeApiCall($url, $params, $verb = 'POST')
    {
        $header = array(
            'http' => array(
                'method' => $verb,
                'ignore_errors' => true
            )
        );
        if ($params !== null && !empty($params)) {
            // check if signature has been provided if not, make it
            if(!isset($params['signature'])){
                $params['signature'] = $this->signRequest($params);
            }

            $params = http_build_query($params);
            if ($verb == 'POST') {
                $header["http"]['header'] = 'Content-Type: application/x-www-form-urlencoded';
                $header['http']['content'] = $params;
            } else {
                $url .= '?' . $params;
            }
        }

        $context = stream_context_create($header);
        $fp = fopen($url, 'rb', false, $context);
        if (!$fp) {
            $res = false;
        } else {
            $res = stream_get_contents($fp);
            parse_str($res, $res);
        }

        if ($res === false) {
            return false;
        }

        return $res;


    }

    function signRequest($sig_fields,$secret = null){

        if(is_array($sig_fields)){
            ksort($sig_fields);
            $sig_fields = http_build_query($sig_fields) . ($secret === null ? $this->secret : $secret);
        }else{
            $sig_fields .= ($secret === null ? $this->secret : $secret);
        }

        return hash('SHA512', $sig_fields);

    }
}
