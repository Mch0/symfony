<?php
/**
 * Created by PhpStorm.
 * User: arnaud
 * Date: 02/06/14
 * Time: 14:28
 */

namespace tgw\AdminBundle\Helper;


class ArianeHelper {

    private static $instance = null;

    public static function getInstance()
    {
        if(!self::$instance instanceof ArianeHelper)
        {
            self::$instance = new ArianeHelper();
        }
        return self::$instance;
    }

    public function formatArianne($uri)
    {
        $tabUri = array();
        $tabUri = explode('/',$uri);
        $formatedUri= array();

        for($i=2; $i < count($tabUri) ; $i++)
        {

            $formatedUri[$i-1] = $tabUri[$i] ;
        }

        return $formatedUri;
    }
} 