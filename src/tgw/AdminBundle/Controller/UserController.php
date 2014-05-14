<?php

namespace tgw\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use tgw\AdminBundle\Entity\User;

class UserController extends Controller
{

    public function createAction()
    {
        $user = new User();
        $user->setAdmin(1);
        $user->setLogin('Mcho');
        $user->setPassword(md5("67300sch!"));
        $user->setRole('Administrateur');
        $DoctrineService = $this->getDoctrine()->getManager();

        $DoctrineService->persist($user);
        $DoctrineService->flush();
        return $this->redirect($this->generateUrl('index'));
    }
}
