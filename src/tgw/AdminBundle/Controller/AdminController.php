<?php

namespace tgw\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

class AdminController extends Controller
{

    public function indexAction()
    {
        if(!isset($_SESSION['popin']))
        {
            $_SESSION['popin'] = 0;
        }
        return $this->render('tgwAdminBundle:Admin:index.html.twig', array('popin' => $_SESSION['popin'],
                                                                            'titre' => 'Administration'));

    }

    public function articlesAction()
    {
        return $this->render('tgwAdminBundle:Admin:showArticles.html.twig',array('titre'=>'Les articles'));
    }

    public function showArticlesAction()
    {
    }

    public function loginAction(Request $request)
    {

        $session = new Session();
        $session->start();
        $login = $request->request->get('login');
        $password = $request->request->get('password');
        $passwordMD5 = md5($password);
        $user = $this->getDoctrine()->getRepository('tgwAdminBundle:User')->findOneBy(array('login' => $login));
        if($user == null || $user->getPassword() != $passwordMD5)
        {
            $session->set('popin',1);
            return $this->redirect($this->generateUrl('index'));
            //return $this->render('tgwAdminBundle:Admin:index.html.twig',array('titre' => 'Administration'));

        }
        $session->set('login',$login);
        $session->set('role',$user->getRole());
        $session->set('admin', $user->getAdmin());
        $session->set('popin',0);

        return $this->redirect($this->generateUrl('dashboard'));
    }

    public function logoutAction()
    {

    }

    public function dashboardAction()
    {

        return $this->render('tgwAdminBundle:Admin:administration.html.twig', array('titre' => 'Dashboard'));
    }

}
