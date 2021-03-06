<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;

/**
* Require ROLE_ADMIN for *every* controller method in this class.
*
* @IsGranted("ROLE_ADMIN")
*/

class UserController extends AbstractController
{
    /**
     * @Route("/listuser", name="user_index")
     */
    public function home()
    {
        $repository = $this->getDoctrine()->getRepository(User::class);
        $users = $repository->findAll();
        
        return $this->render("user/index.html.twig", ["user" => $users]);
    }

    /**
     * @Route("/user/{id}", requirements={"id"="\d+"}, name="user_single")
    */
    public function user($id)
    {
        $repository = $this->getDoctrine()->getRepository(User::class);
        $user = $repository->find($id);

        return $this->render('user/single.html.twig',["user" => $user]);
        return new Response();
    }
}