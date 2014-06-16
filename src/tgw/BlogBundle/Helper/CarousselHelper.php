<?php
/**
 * Created by PhpStorm.
 * User: arnaud
 * Date: 16/06/14
 * Time: 16:30
 */

namespace tgw\BlogBundle\Helper;


use Symfony\Component\HttpFoundation\Request;

class CarousselHelper {

    private static $instance = null;

    public static function getInstance()
    {
        if(!self::$instance instanceof CarousselHelper)
        {
            self::$instance = new CarousselHelper();
        }
        return self::$instance;
    }

    public function getSlide()
    {
            if( $dir = opendir('../../symfony/web/bundles/upload/slider'))
            {
                while(($file = readdir($dir)) !== false)
                {
                    if($file !== '.' && $file !== '..')
                    {
                        $file = "bundles/upload/slider/".$file;
                        $files[] = $file;
                    }
                }
            }
        return $files;
    }

} 