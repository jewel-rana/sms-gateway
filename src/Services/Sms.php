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
        self::$config = Config::get('sms');
        self::$params['from'] = self::$config['api_mask'];
        self::$params['channel'] = self::$config['api_mask'];
        self::$params['dcs'] = self::$config['api_dcs'];
        self::$params['channel'] = self::$config['api_channel'];
        self::$params['campaign'] = self::$config['api_campaign'];
        self::$params['flashsms'] = self::$config['api_flash_sms'];
        self::$params['type'] = self::$config['api_message_type'];
    }

    public static function from( string $mask = null )
    {
        if( !is_null( $mask ) ) {
            self::$params['from'] = $mask;
        }
        return new static;
    }

    public static function to( string $number )
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
        // dd( self::$config );
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
        if( self::$config['api_url'] && self::$config['api_key'] && self::$config['api_user'] && self::$params['from'] && self::$params['to'] && self::$params['body'] )
        {
            $response = Http::get(
                self::$config['api_url'], [
                self::$config['keys']['user'] => self::$config['api_user'],
                self::$config['keys']['password'] => self::$config['api_key'],
                self::$config['keys']['from'] => self::$params['from'],
                self::$config['keys']['to'] => self::$params['to'],
                self::$config['keys']['message'] => self::$params['body'],
                self::$config['keys']['channel'] => self::$params['channel'],
                self::$config['keys']['dcs'] => self::$params['dcs'],
                self::$config['keys']['campaign'] => self::$params['campaign'],
                self::$config['keys']['flashsms'] => self::$params['flashsms'],
                self::$config['keys']['type'] => self::$params['type']
            ]);

            if( self::$config['api_method'] == 'xml') {
                // Load the XML
                $xmlResponse = simplexml_load_string($response->body());

                // JSON encode the XML, and then JSON decode to an array.
                return json_decode(json_encode($xmlResponse));
            } else {
                return $response;
            }
        }
        return false;
    }
}