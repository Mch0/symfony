<?php
/**
 * Created by PhpStorm.
 * User: arnaud
 * Date: 02/06/14
 * Time: 12:00
 */

namespace tgw\AdminBundle\Controller;

use Proxies\__CG__\tgw\BlogBundle\Entity\Auteur;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Security\Core\SecurityContext;
use tgw\AdminBundle\Helper\ArianeHelper;

class AuteurController extends Controller

{
    /*
     * Liste des auteurs actifs
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $auteurs = $em->getRepository('tgwBlogBundle:Auteur')->findAll();

        $arianeHelper = ArianeHelper::getInstance();
        $filAriane = $arianeHelper->formatArianne($this->getRequest()->getRequestUri());
        $titre = $this->get("translator")->trans('admin.auteurs');



        return $this->render('tgwAdminBundle:Auteur:showAuteurs.html.twig',array('titre'=>$titre,
                                                                                    'filArianne' =>$filAriane,
                                                                                    'auteurs' => $auteurs));


    }

    public function redigerAction()
    {
        $arianeHelper = ArianeHelper::getInstance();
        $filAriane = $arianeHelper->formatArianne($this->getRequest()->getRequestUri());
        $titre = $this->get('translator')->trans('admin.creer.auteur');

        return $this->render('tgwAdminBundle:Auteur:rediger.html.twig',array('titre'=>$titre,
                                        'filArianne' => $filAriane,
                                        'auteur'=> null));


    }

    public function creerAction(Request $request)
    {
        $auteur = new Auteur();
        $auteur->setNom($request->get('nom'));
        $auteur->setPrenom($request->get('prenom'));
        $auteur->setEmail($request->get('email'));
        $auteur->setSignature($request->get('signature'));

        $DoctrineService = $this->getDoctrine()->getManager();
        $DoctrineService->persist($auteur);
        $DoctrineService->flush();
        return $this->redirect($this->generateUrl('tgw_admin_index_auteurs'));
    }

    public function editerAction($id)
    {

        $em = $this->getDoctrine()->getManager();
        $helperArian = ArianeHelper::getInstance();
        $filArianne = $helperArian->formatArianne($this->getRequest()->getRequestUri());
        $auteur = $em->getRepository('tgwBlogBundle:Auteur')->find($id);

        return $this->render('tgwAdminBundle:Auteur:rediger.html.twig',array('titre' => $this->get('translator')->trans('admin.editer.categorie'),
            'filArianne' => $filArianne,
            'auteur' => $auteur));
    }

    public function updateAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $auteur = $em->getRepository('tgwBlogBundle:Auteur')->find($request->get('id'));
        $auteur->setNom($request->get('nom'));
        $auteur->setPrenom($request->get('prenom'));
        $auteur->setEmail($request->get('email'));
        $auteur->setSignature($request->get('signature'));

        $em->flush();
        return $this->redirect($this->generateUrl('tgw_admin_index_auteurs'));
    }

    public function supprimerAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $auteur = $em->getRepository('tgwBlogBundle:Auteur')->find($id);
        $em->remove($auteur);
        $em->flush();
        return $this->redirect($this->generateUrl('tgw_admin_index_auteurs'));
    }

}