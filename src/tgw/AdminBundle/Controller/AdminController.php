<?php

namespace tgw\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Security\Core\SecurityContext;
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

    public function articlesAction()
    {

        $lesArticles = $this->getDoctrine()->getRepository('tgwBlogBundle:Article')->findAll();
        return $this->render('tgwAdminBundle:Admin:showArticles.html.twig', array('titre' => 'Les articles', 'articles' => $lesArticles));
    }

    public function showArticlesAction()
    {
    }


    /**
     * Traite le formulaire de connexion admin, ajoute la date et l'heure de connexion de l'utilisateur
     * Redirige vers dashboard
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function loginAction(Request $request)
    {
        /****/
    }


    public function logoutAction()
    {

    }

    public function dashboardAction()
    {

        return $this->render('tgwAdminBundle:Admin:administration.html.twig', array('titre' => 'Dashboard'));
    }

}
