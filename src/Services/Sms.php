<?php
namespace Rajtika\Sms\Services;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;

class Sms
{
    protected static $config;
    protected static $params;
    public function __construct()
    {
        self::$config = [
            'api_url' => '',
            'api_key' => '',
            'api_user' => ''
        ];

        if( !class_exists('Http') ) {
            die('SMS send require guzzlehttp client');
        }
    }

    public function from( string $mask )
    {
        self::$params['from'] = $mask;
        return new static;
    }

    public function to( string $number )
    {
        self::$params['to'] = $number;
        return new static;
    }

    public static function body( string $body )
    {
        self::$params['body'] = $body;
        return new static;
    }

    public static function send()
    {
        $check = self::_check();
        if( $check['status'] === true ) {
            return self::_handShake();
        } else {
            return $check;
        }
    }

    private static function _check()
    {
        $data = ['status' => true];
        $info = array_diff_key(array_flip([
            'from',
            'to',
            'body'
        ]), self::$params);

        if( $info ) {
            $data['status'] = false;
            $data['message'] = ucwords(implode(', ', array_keys( $info ) ) ) . ' is missing in your params.';
        }

        return $data;
    }

    private static function _handShake()
    {
        if( self::$config['api_url'] && $config['api_key'] && self::$config['api_user'] && self::$params['from'] && self::$params['to'] && self::$params['body'] )
        {
            $response = Http::get(
                self::$config['api_url'], [
                'Username' => self::$config['api_user'],
                'Password' => self::$config['api_key'],
                'From' => self::$params['from'],
                'To' => self::$params['to'],
                'Message' => self::$params['body']
            ]);
            // Load the XML
            $xmlResponse = simplexml_load_string($response->body());

            // JSON encode the XML, and then JSON decode to an array.
            return json_decode(json_encode($xmlResponse));

        }
        return false;
    }
}