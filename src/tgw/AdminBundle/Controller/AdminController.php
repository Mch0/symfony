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
        $filArianne = $this->formatArianne($this->getRequest()->getRequestUri());
        return $this->render('tgwAdminBundle:Admin:index.html.twig', array(
            // Valeur du précédent nom d'utilisateur entré par l'internaute
            'last_username' => $session->get(SecurityContext::LAST_USERNAME),
            'error' => $error,
            'titre' => $this->get("translator")->trans("admin.articles"),
            'filArianne' => $filArianne
        ));

    }




    public function redigerAction()
    {
        $filArianne = $this->formatArianne($this->getRequest()->getRequestUri());
        return $this->render('tgwAdminBundle:Admin:redigerArticle.html.twig', array('titre' => $this->get("translator")->trans("admin.rediger"),
                                                                                    'article' => null,
                                                                                        'filArianne' => $filArianne));
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
        $filArianne = $this->formatArianne($this->getRequest()->getRequestUri());
        $lesArticles = $this->getDoctrine()->getRepository('tgwBlogBundle:Article')->findAll();
        return $this->render('tgwAdminBundle:Admin:showArticles.html.twig', array('titre' => $this->get("translator")->trans("admin.articles"),
                                                                                    'articles' => $lesArticles,
                                                                                        'filArianne'=>$filArianne));
    }

   public function editerAction($id)
   {
       $filArianne = $this->formatArianne($this->getRequest()->getRequestUri());
        $em = $this->getDoctrine()->getManager();
        $article = $em->getRepository('tgwBlogBundle:Article')->find($id);
        return $this->render('tgwAdminBundle:Admin:redigerArticle.html.twig', array('titre' => $this->get("translator")->trans("admin.editer"),
                                                                                        'article' => $article,
                                                                                            'filArianne' => $filArianne));
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
    public function dashboardAction()
    {

        $filArianne = $this->formatArianne($this->getRequest()->getRequestUri());

        return $this->render('tgwAdminBundle:Admin:administration.html.twig', array('titre' => $this->get("translator")->trans("admin.dashboard"),
                                                                                     'user' => $this->getUser(),
                                                                                        'filArianne' => $filArianne ));
    }


    public function publieAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $article = $em->getRepository('tgwBlogBundle:Article')->find($request->get('id'));
        $article->setArticlePublie(1);
        $em->flush();
        return $this->redirect($this->generateUrl('articles'));
    }

    public function depublieAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $article = $em->getRepository('tgwBlogBundle:Article')->find($request->get('id'));
        $article->setArticlePublie(0);
        $em->flush();
        return $this->redirect($this->generateUrl('articles'));
    }

}
