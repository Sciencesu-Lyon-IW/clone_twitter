<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\EditType;
use Doctrine\ORM\EntityManager;
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


    /**
     * @Route("/dashboard", name="dashboard")
     * @return Response
     */
    public function dashboard(): Response
    {
        return $this->render('user/index.html.twig', [
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
        /*$user = new User();*/
        $this->getDoctrine()->getManager()->flush();


        return $this->render('home/index.html.twig', [
            'user' => $user
        ]);
    }


    /**
     * @Route("/{username}", name="user_profile")
     * @param Request $request
     * @return Response
     */
    public function index(Request $request, $username): Response
    {

        $form = $this->createForm(EditType::class);
        $form->handleRequest($request);
        $em = $this->getDoctrine()->getManager();
        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();
            $em->persist($user);
            $em->flush();
            return $this->redirectToRoute('user_profile');
        }
        return $this->render('user/index.html.twig', [
            'userForm' => $form->createView(),
            'controller_name' => 'UserController',
            'user' => $this->getUser(),
        ]);
    }

}
