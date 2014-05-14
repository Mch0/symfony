<?php

namespace tgw\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use tgw\BlogBundle\Entity\Article;

class AccueilController extends Controller
{

    /**
     * Page d'accueil de l'application
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        return $this->render('tgwBlogBundle:Default:index.html.twig', array('titre' => 'Accueil'));
    }

}
