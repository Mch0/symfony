<?php

namespace tgw\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use tgw\BlogBundle\Entity\Article;
use tgw\BlogBundle\Helper\CarousselHelper;


class AccueilController extends Controller
{

    /**
     * Page d'accueil de l'application
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        $DoctrineService = $this->getDoctrine()->getManager();
        $articles = $DoctrineService->getRepository('tgwBlogBundle:Article')->findBy(array('articlePublie' =>true),array('articleDate' => 'DESC'),5,0);
        $carousselHelper = CarousselHelper::getInstance();
        $slides = $carousselHelper->getSlide();

        return $this->render('tgwBlogBundle:Default:index.html.twig', array('titre' => 'Accueil','articles' => $articles,
                                                                            'slides' => $slides));
    }

}
