<?php

namespace App\Controller;

use App\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @IsGranted("ROLE_USER")
 * @IsGranted("IS_AUTHENTICATED_FULLY")
 */
class UserController extends AbstractController
{

    /* @Route("/{username}", name="user_profile")
     * @param User $user
     * @param Request $request
     * @param $username
     * @return Response
     */
    public function index(User $user, Request $request, $username): Response
    {
        return $this->render('user/dashboard.html.twig', [
            'controller_name' => 'UserController',
            'user' => $this->getUser(),
        ]);
    }



    /**
     * @Route("/dashboard", name="dashboard")
     * @return Response
     */
    public function dashboard(): Response
    {
        return $this->render('user/dashboard.html.twig', [
            'controller_name' => 'UserController',
            'user' => $this->getUser(),
        ]);
    }



    /*
    * @Route("/profile/{id}", name="user_profile", methods={"GET","POST"})
    * @param Request $request
    * @param User $user
    * @return Response
        */
    public function profile(Request $request, User $user): Response
    {

        $repository = $this->getDoctrine()->getRepository(User::class);
        $product = $repository->find($user->getId());
        $user = new User();
        $this->getDoctrine()->getManager()->flush();


        return $this->render('user/index.html.twig', [
            'user' => $user
        ]);
    }

}
