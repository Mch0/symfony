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
        $categories = $em->getRepository('tgwBlogBundle:Categorie')->findAll();
        return $this->render('tgwAdminBundle:Admin:redigerCategorie.html.twig', array('titre' => $this->get("translator")->trans("admin.rediger"),
                                                                                                                    'filArianne' => $filArianne,
                                                                                                                    'categories' => $categories));
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

    public function categoriesAction()
    {
        $helperArian = ArianeHelper::getInstance();
        $filArianne = $helperArian->formatArianne($this->getRequest()->getRequestUri());
        $DoctrineService = $this->getDoctrine()->getManager()->getRepository('tgwBlogBundle:Categorie');
        $categories = $DoctrineService->findAll();

        return $this->render('tgwAdminBundle:Admin:showCategories.html.twig',array('titre' =>$this->get('translator')->trans('admin.creer.categorie'),
                                     'categories' => $categories,
                                        'filArianne' => $filArianne));

    }

}