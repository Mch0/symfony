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

class AuteurController extends Controller

{
    /*
     * Liste des auteurs actifs
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $auteurs = $em->getRepository('tgwBlogBundle:Auteur')->findAll();

        $arianeHelper = ArianeHelper::getInstance();
        $filAriane = $arianeHelper->formatArianne($this->getRequest()->getRequestUri());
        $titre = $this->get("translator")->trans('admin.auteurs');



        return $this->render('tgwAdminBundle:Auteur:showAuteurs.html.twig',array('titre'=>$titre,
                                                                                    'filArianne' =>$filAriane,
                                                                                    'auteurs' => $auteurs));


    }

    public function redigerAction()
    {

    }

    public function creerAction(Request $request)
    {

    }

    public function editerAction($id)
    {

    }

    public function updateAction($id)
    {

    }

}