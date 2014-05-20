<?php

namespace tgw\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Security\Core\SecurityContext;
use tgw\BlogBundle\Entity\Article;
class AdminController extends Controller
{

    public function indexAction()
    {
        //Si le visiteur est déjà identifié, on le redirige vers l'accueil
        if ($this->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirect($this->generateUrl('dashboard'));
        }

        $request = $this->getRequest();
        $session = $request->getSession();

        // On vérifie s'il y a des erreurs d'une précédente soumission du formulaire
        if ($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
            $error = $request->attributes->get(SecurityContext::AUTHENTICATION_ERROR);
        } else {
            $error = $session->get(SecurityContext::AUTHENTICATION_ERROR);
            $session->remove(SecurityContext::AUTHENTICATION_ERROR);
        }

        return $this->render('tgwAdminBundle:Admin:index.html.twig', array(
            // Valeur du précédent nom d'utilisateur entré par l'internaute
            'last_username' => $session->get(SecurityContext::LAST_USERNAME),
            'error' => $error,
            'titre' => "Administration"
        ));

    }




    public function redigerAction()
    {
        return $this->render('tgwAdminBundle:Admin:redigerArticle.html.twig', array('titre' => 'Rediger un article','article' => null));
    }


    public function creerAction(Request $request)
    {
        $article = new Article();
        $article->setArticleTitre($request->get('titre'));
        $article->setArticleContenu($request->get('contenuArticle'));
        $article->setArticleAuteur($request->get('auteur'));
        $article->setArticleCategorie($request->get('categorie'));
        $article->setArticleSynopsis("synopsys tout moisi ");
        $article->setArticlePublie(false);
        $article->setArticleDate(new \DateTime());
        $DoctrineService = $this->getDoctrine()->getManager();

        $DoctrineService->persist($article);
        $DoctrineService->flush();

        return $this->redirect($this->generateUrl('articles'));
    }


    public function supprimerAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $article = $em->getRepository('tgwBlogBundle:Article')->find($id);
        $em->remove($article);
        $em->flush();
        return $this->redirect($this->generateUrl('articles'));
    }

    public function articlesAction()
    {

        $lesArticles = $this->getDoctrine()->getRepository('tgwBlogBundle:Article')->findAll();
        return $this->render('tgwAdminBundle:Admin:showArticles.html.twig', array('titre' => 'Les articles', 'articles' => $lesArticles));
    }

   public function editerAction($id)
   {
        $em = $this->getDoctrine()->getManager();
        $article = $em->getRepository('tgwBlogBundle:Article')->find($id);
        return $this->render('tgwAdminBundle:Admin:redigerArticle.html.twig', array('titre' => 'Les articles', 'article' => $article));
   }

    public function updateAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $article = $em->getRepository('tgwBlogBundle:Article')->find($request->get('id'));
        $article->setArticleTitre($request->get('titre'));
        $article->setArticleAuteur($request->get('auteur'));
        $article->setArticleCategorie($request->get('categorie'));
        $article->setArticleContenu($request->get('contenuArticle'));
        $em->flush();

        return $this->redirect($this->generateUrl('articles'));
    }



    public function logoutAction()
    {

    }

    public function dashboardAction()
    {
        return $this->render('tgwAdminBundle:Admin:administration.html.twig', array('titre' => 'Dashboard',
                                                                                     'user' => $this->getUser()));
    }

}
