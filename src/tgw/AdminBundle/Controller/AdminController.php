<?php

namespace tgw\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Security\Core\SecurityContext;
use tgw\BlogBundle\Helper\gapi;
use tgw\BlogBundle\Entity\Auteur;
use tgw\BlogBundle\Entity\Article;
use tgw\BlogBundle\Entity\Categorie;
use tgw\AdminBundle\Helper\ArianeHelper;
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
        $helperArian = ArianeHelper::getInstance();
        $filArianne = $helperArian->formatArianne($this->getRequest()->getRequestUri());
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
        $em = $this->getDoctrine()->getManager();
        $helperArian = ArianeHelper::getInstance();
        $filArianne = $helperArian->formatArianne($this->getRequest()->getRequestUri());

        $categories = $em->getRepository('tgwBlogBundle:Categorie')->findAll();

        $auteurs = $em->getRepository('tgwBlogBundle:Auteur')->findAll();

        return $this->render('tgwAdminBundle:Admin:redigerArticle.html.twig', array('titre' => $this->get("translator")->trans("admin.rediger"),
                                                                                    'article' => null,
                                                                                    'filArianne' => $filArianne,
                                                                                    'categories' => $categories,
                                                                                    'auteurs' => $auteurs));
    }


    public function creerAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $auteur = new Auteur();
        $article = new Article();
        $categorie = new Categorie();

        $auteur = $em->getRepository('tgwBlogBundle:Auteur')->findOneBy(array("id"=>$request->get('auteur')));

        $categorie = $em->getRepository('tgwBlogBundle:Categorie')->findOneBy(array('id'=>$request->get('categorie')));


        $article->setArticleTitre($request->get('titre'));
        $article->setArticleContenu($request->get('contenuArticle'));
        $article->setArticleAuteur($auteur);
        $article->setArticleSynopsis($request->get('synopsis'));
        $article->setArticlePublie(false);
        $article->setArticleDate(new \DateTime());
        $article->setArticleVignette($request->get('vignette'));
        $article->setArticleCategorie($categorie);
        $article->setArticleAuteur($auteur);
		$article->setArticleSlug(str_replace(' ','-',$article->getArticleTitre()));

        $DoctrineService = $this->getDoctrine()->getManager();
        $DoctrineService->persist($auteur);
        $DoctrineService->persist($article);
        $DoctrineService->persist($categorie);
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
        $helperArian = ArianeHelper::getInstance();
        $filArianne = $helperArian->formatArianne($this->getRequest()->getRequestUri());
        $lesArticles = $this->getDoctrine()->getRepository('tgwBlogBundle:Article')->findAll();
        return $this->render('tgwAdminBundle:Admin:showArticles.html.twig', array('titre' => $this->get("translator")->trans("admin.articles"),
                                                                                    'articles' => $lesArticles,
                                                                                        'filArianne'=>$filArianne,));
    }

   public function editerAction($id)
   {
        $helperArian = ArianeHelper::getInstance();
        $filArianne = $helperArian->formatArianne($this->getRequest()->getRequestUri());
        $em = $this->getDoctrine()->getManager();

        $categories = $em->getRepository('tgwBlogBundle:Categorie')->findAll();

        $auteurs = $em->getRepository('tgwBlogBundle:Auteur')->findAll();

        $article = $em->getRepository('tgwBlogBundle:Article')->find($id);
        return $this->render('tgwAdminBundle:Admin:redigerArticle.html.twig', array('titre' => $this->get("translator")->trans("admin.editer"),
                                                                                    'article' => $article,
                                                                                    'filArianne' => $filArianne,
                                                                                    'categories' => $categories,
                                                                                    'auteurs' => $auteurs));
   }

    public function updateAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $categorie = new Categorie();
        $categorie = $em->getRepository('tgwBlogBundle:Categorie')->findOneBy(array('id'=>$request->get('categorie')));
        $auteur = $em->getRepository('tgwBlogBundle:Auteur')->findOneBy(array('id' => $request->get('auteur')));

        $article = $em->getRepository('tgwBlogBundle:Article')->find($request->get('id'));
        $article->setArticleTitre($request->get('titre'));
        $article->setArticleAuteur($auteur);
        $article->setArticleCategorie($categorie);
        $article->setArticleContenu($request->get('contenuArticle'));
        $article->setArticleSynopsis($request->get('synopsis'));
        $article->setArticleVignette($request->get('vignette'));
        $em->flush();

        return $this->redirect($this->generateUrl('articles'));
    }



    public function logoutAction()
    {

    }



    public function dashboardAction()
    {

        $helperArian = ArianeHelper::getInstance();
        $filArianne = $helperArian->formatArianne($this->getRequest()->getRequestUri());
        $em = $this->getDoctrine()->getManager();
        $nbrTotalArticle = count($em->getRepository('tgwBlogBundle:Article')->findAll());
        $nbrArticlePublie = count($em->getRepository('tgwBlogBundle:Article')->findBy(array('articlePublie' => 1)));

        $nbrArticleNonPublie = count($em->getRepository('tgwBlogBundle:Article')->findBy(array('articlePublie' => 0)));
        $nbrCategories = count($em->getRepository('tgwBlogBundle:Categorie')->findAll());



        $ga = new \tgw\AdminBundle\Helper\gapi(ga_email,ga_password);
        $filter = 'browser == Chrome || browser == Firefox || browser == Internet Explorer || browser == Safari || browser == Opera';
        //On fait notre requete sur l'API Google Analytics
        $ga->requestReportData(ga_profile_id,array('browser'),array('pageviews','visits'),'-visits',$filter);
        //On compte le nombre totale de page vues pour tout les navigateurs
        $totalPageVue = 0;
        foreach($ga->getResults() as $pagesviews)
        {
            $totalPageVue += $pagesviews->getPageviews();
        }
        $pourcentageParNavigateur = array();
        foreach($ga->getResults() as $browser)
        {
            $percentForCurrentBrowser = ($browser->getPageviews()*100/$totalPageVue);
            $pourcentageParNavigateur["$browser"] = round($percentForCurrentBrowser);
        }


        $statsGen = $ga->requestReportData(ga_profile_id, NULL,array('visitors','visits','pageviews','pageviewsPerVisit','avgtimeOnSite','visitBounceRate','percentNewVisits'),NULL,NULL,'2012-11-30',(date('Y-m-d',time())));
        $statsGen = $statsGen[0]->getMetrics();

        return $this->render('tgwAdminBundle:Admin:administration.html.twig', array('titre' => $this->get("translator")->trans("admin.dashboard"),
                                                                                     'user' => $this->getUser(),
                                                                                        'filArianne' => $filArianne,
                                                                                        'nbrTotalArticle' => $nbrTotalArticle,
                                                                                        'nbrArticlePublie' => $nbrArticlePublie,
                                                                                        'nbrCategories' => $nbrCategories,
                                                                                        'nbrArticleNonPublie' =>$nbrArticleNonPublie,
                                                                                        'statistiques' => $statsGen,
                                                                                        'pourcentageNavigateur' => $pourcentageParNavigateur));
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
