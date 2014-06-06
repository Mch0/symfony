<?php
/**
 * Created by PhpStorm.
 * User: arnaud
 * Date: 02/06/14
 * Time: 12:00
 */

namespace tgw\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Security\Core\SecurityContext;
use tgw\AdminBundle\Helper\ArianeHelper;

class FileManagerController extends Controller

{

    public function indexAction()
    {
        $helperArian = ArianeHelper::getInstance();
        $filArianne = $helperArian->formatArianne($this->getRequest()->getRequestUri());
        return $this->render('tgwAdminBundle:Bloc:Bloc-File-Manager.html.twig',array('titre' => "File manager",
                                                                                'filArianne' => $filArianne));
    }

}