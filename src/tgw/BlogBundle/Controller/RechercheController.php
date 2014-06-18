<?php

namespace tgw\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use tgw\BlogBundle\Entity\Article;


class RechercheController extends Controller
{

        public function rechercherAction(Request $request)
        {
            $motClef = $request->get('mot-clef');
            $em = $this->getDoctrine()->getManager();
            $query = $em->createQuery("select a FROM tgwBlogBundle:Article a WHERE a.articleContenu like :motClef
            or a.articleTitre like :motClef")->setParameter('motClef',"%".$motClef."%");
            $articles = $query->getResult();

            return $this->render('tgwBlogBundle:Recherche:resultat.html.twig',array('articles'=>$articles,
                'titre' =>  $this->get('translator')->trans('recherche',array('%mot-clef%'=>$motClef))));
        }

}