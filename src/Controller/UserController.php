<?php

namespace App\Controller;

use App\Entity\Posts;
use App\Entity\User;
use App\Form\EditType;
use Doctrine\ORM\EntityManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
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
    public function index(Request $request, User $user, $username): Response
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
        $post = $em->getRepository(Posts::class)->findAll();
        if (!$post) {
            $error = 'Pas de post ici';
        }
        return $this->render('user/index.html.twig', [
            'userForm' => $form->createView(),
            'controller_name' => 'UserController',
            'user' => $this->getUser(),
            'posts' => $post,
        ]);
    }

    /**
     * @Route("/update_profile_ajax", name="ajax_update_profile")
     * @param Request $request
     * @return JsonResponse
     */
    public function ajaxCreateTweet(Request $request): JsonResponse
    {

        if ($request->request->get('data')) {
            $this->createTweet($request);
            return new JsonResponse($request->request->get('data'));
        }
        return new JsonResponse($request->request->get('data'));
    }

    /**
     * @Route("/update_profile", name="update_profile")
     * @param Request $request
     * @return Response
     */
    public function createTweet(Request $request): Response
    {

        if (!$request->request->get('data') || $request->request->get('data') === "")
        {
            return new Response('Erreur lors la mise à jour du profil');
        }
        $whats_happening = $request->request->get('whats_happening');
        $posts = new Posts();
        $posts->setBody($whats_happening);
        $posts->setCreateat(date("Y-m-d H:i:s"));
        $posts->addUser($this->getUser());
        $entityManager = $this->getDoctrine()->getManager();

        $entityManager->persist($posts);
        $entityManager->flush();



        /*new Response('Tweet publié '.$posts->getId());*/
        return $this->redirectToRoute('dashboard');
        // do anything else you need here, like send a email
        /*  return $this->render('home/index.html.twig', [
              'user' => $this->getUser(),

          ]);*/
    }

}
