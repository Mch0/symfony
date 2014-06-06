<?php
/**
 * Created by PhpStorm.
 * User: arnaud
 * Date: 02/06/14
 * Time: 12:00
 */

namespace tgw\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Security\Core\SecurityContext;
use tgw\BlogBundle\Entity\Article;
use tgw\BlogBundle\Entity\Categorie;
use tgw\AdminBundle\Helper\ArianeHelper;

class CategorieController extends Controller

{


    public function redigerAction()
    {
        $em = $this->getDoctrine()->getManager();
        $helperArian = ArianeHelper::getInstance();
        $filArianne = $helperArian->formatArianne($this->getRequest()->getRequestUri());

        return $this->render('tgwAdminBundle:Categorie:redigerCategorie.html.twig', array('titre' => $this->get("translator")->trans("admin.rediger"),
                                                                                                                    'filArianne' => $filArianne,
                                                                                                                    'categories' => null));
    }

    public function creerAction(Request $request)
    {

        $categorie = new Categorie();
        $categorie->setTitre($request->get('titre'));
        $DoctrineService = $this->getDoctrine()->getManager();
        $DoctrineService->persist($categorie);
        $DoctrineService->flush();

        return $this->redirect($this->generateUrl('dashboard'));
    }

    public function editerAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $helperArian = ArianeHelper::getInstance();
        $filArianne = $helperArian->formatArianne($this->getRequest()->getRequestUri());
        $categorie = $em->getRepository('tgwBlogBundle:Categorie')->find($id);

       return $this->render('tgwAdminBundle:Categorie:redigerCategorie.html.twig',array('titre' => $this->get('translator')->trans('admin.editer.categorie'),
                                                        'filArianne' => $filArianne,
                                                        'categorie' => $categorie));

    }

    public function updateAction(Request $request)
    {
        $categorie = new Categorie();
        $em = $this->getDoctrine()->getManager();
        $categorie = $em->getRepository('tgwBlogBundle:Categorie')->find($request->get('id'));
        $categorie->setTitre($request->get('titre'));

        $em->flush();

        return $this->redirect($this->generateUrl('categories'));

    }

    public function supprimerAction($id)
    {

        $em = $this->getDoctrine()->getManager();
        $categorie = $em->getRepository('tgwBlogBundle:Categorie')->find($id);
        $em->remove($categorie);
        $em->flush();
        return $this->redirect($this->generateUrl('categories'));

    }

    public function categoriesAction()
    {
        $helperArian = ArianeHelper::getInstance();
        $filArianne = $helperArian->formatArianne($this->getRequest()->getRequestUri());
        $DoctrineService = $this->getDoctrine()->getManager()->getRepository('tgwBlogBundle:Categorie');
        $categories = $DoctrineService->findAll();

        return $this->render('tgwAdminBundle:Categorie:showCategories.html.twig',array('titre' =>$this->get('translator')->trans('admin.categories'),
                                     'categories' => $categories,
                                        'filArianne' => $filArianne));

    }

}