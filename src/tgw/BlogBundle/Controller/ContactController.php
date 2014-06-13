<?php

namespace tgw\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ContactController extends Controller
{

    public function indexAction($name)
    {
        return $this->render('tgwBlogBundle:Contact:index.html.twig',array('titre' => $this->get('translator')->trans('Contact',array('%name%' => $name)),
                                                                    'name' => $name));
    }

    public function sendAction($name,Request $request)
    {
        $adresse = "contact@thegeekway.fr";
        if($name === "Arnaud")
        {
            $adresse = "arnaud.scote@gmail.com";
        }
        elseif( $name === "Nadege")
        {
            $adresse = "perez.nadege5@gmail.com";
        }


        $sujet = $request->get('sujet');
        $message = $request->get('message');
        $header = "From: ". $request->get('email');

        mail($adresse,$sujet,$message,$header);

        return $this->redirect($this->generateUrl('blog_home'));


    }

}