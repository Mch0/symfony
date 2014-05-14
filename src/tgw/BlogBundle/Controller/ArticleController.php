<?php

namespace tgw\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use tgw\BlogBundle\Entity\Article;

class ArticleController extends Controller
{


    /**
     * Ajoute un article en base
     * @return \Symfony\Component\HttpFoundation\Response
     *
     */
    public function ajouterArticleAction()
    {
        $article = new Article();
        $article->setArticleTitre("Titre test");
        $article->setArticleAuteur("Arnaud");
        $article->setArticleCategorie("Une categorie");
        $article->setArticleContenu("Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque luctus pulvinar est. Integer rhoncus nunc elit, non rutrum velit sagittis in. Sed adipiscing, diam lacinia rhoncus vestibulum, magna turpis iaculis arcu, at varius tortor lorem eget ante. Aenean ipsum lorem, ultrices ac enim nec, laoreet bibendum turpis. Sed in malesuada tortor. Etiam non nunc ac mi suscipit luctus eget id ligula. Nullam dignissim metus id dictum pretium. Curabitur eu eleifend nulla. Nunc at ligula id massa convallis tempus. Donec luctus, felis in tempor eleifend, massa turpis posuere magna, a ultrices mauris tellus a ante. Morbi dictum ornare turpis in hendrerit. Nam vestibulum cursus interdum. Vivamus elit neque, malesuada eget cursus fermentum, sodales id massa. Phasellus congue porta nunc, quis pharetra felis convallis ut. Curabitur ac neque vitae diam blandit rhoncus. Phasellus malesuada massa sapien, in malesuada tellus placerat eu.");
        $article->setArticlePublie(false);
        $article->setArticleSynopsis("consectetur adipiscing elit. Quisque luctus pulvinar est.");

        $DoctrineService = $this->getDoctrine()->getManager();

        $DoctrineService->persist($article);
        $DoctrineService->flush();
        return $this->render('tgwBlogBundle:Default:index.html.twig', array('name' => "test", 'titre' => 'Accueil'));
    }


    /**
     * @param $id
     * @return array
     */
    public function showAction($id)
    {

        $DoctrineService = $this->getDoctrine()->getManager();
        $article = $DoctrineService->getRepository('tgwBlogBundle:Article')->find($id);
        return $this->render('tgwBlogBundle:Default:showArticle.html.twig' , array('titre' => $article->getArticleTitre(),
                                                                            'article' => $article ));
    }

    /**
     *
     * Liste les articles présent en base et publiés
     * @return \Symfony\Component\HttpFoundation\Response
     *
     */
    public function articlesAction()
    {

        $DoctrineService = $this->getDoctrine()->getManager();
        $lesArticles = $DoctrineService->getRepository('tgwBlogBundle:Article')->findAllPublished();

        return $this->render('tgwBlogBundle:Default:listeArticles.html.twig', array('titre' => "Les articles",
            'articles' => $lesArticles));
    }


    public function supprimerAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $article = $em->getRepository('tgwBlogBundle:Article')->find($id);
        //$em->remove($article);
        //$em->flush();
        return $this->redirect($this->generateUrl('dashboard'));
    }
}