<?php

namespace App\Controller;


use App\Entity\Follows;
use App\Entity\Likes;
use App\Entity\Posts;
use App\Entity\User;
use App\Form\EditType;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
/**
 * @IsGranted("ROLE_USER")
 * @IsGranted("IS_AUTHENTICATED_FULLY")
 */
class UserController extends AbstractController
{
    private EntityManagerInterface $entityManager;
    private string $error = '';

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

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

    /*    public function profile(Request $request, User $user): Response
        {

            $repository = $this->getDoctrine()->getRepository(User::class);
            $product = $repository->find($user->getId());
            $user = new User();
            /*$user = new User(
            $this->getDoctrine()->getManager()->flush();


            return $this->render('home/index.html.twig', [
                'user' => $user
            ]);
        }*/


    /**
     * @Route("/{username}", name="user_profile")
     * @param Request $request
     * @param $username
     * @return Response
     */
    public function index(Request $request, $username): Response
    {
        if ($request->request->get('username'))
        {
            return $this->ajaxFollow($request);
        }
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
        $user = $em->getRepository(User::class)->findOneBy([
            'username' => $username
        ]);
        return $this->render('user/index.html.twig', [
            'userForm' => $form->createView(),
            'controller_name' => 'UserController',
            'user' => $user,
            'posts' => "",
//            'total_posts' => $total_posts,
        ]);
    }

    /**
     * @Route("/update/profile", name="update_profile", methods={"POST"})
     * @param Request $request
     * @return Response
     */
    public function update(Request $request): Response
    {
//        dump($request->request->get('username'));
//        if (!$request->request->get('username') && !$request->request->get('bio') && !$request->request->get('location') &&!$request->request->get('birthday')
//        || $request->request->get('username') === "" || $request->request->get('bio') === "" || $request->request->get('location') === "" || $request->request->get('birthday') === "")
//        {
//            return new Response('Erreur lors la mise à jour du profil');
//        }
        $username = $request->request->get('username');
        $bio = $request->request->get('bio');
        $location = $request->request->get('location');
//        $birthday = $request->request->get('birthday');
//        dump($request->request->all());
        $user = $this->getUser();
        $user->setUsername($username);
        $user->setBio($bio);
        $user->setLocation($location);
//        $user->setBirthdate($birthday);
        $entityManager = $this->getDoctrine()->getManager();

        $entityManager->persist($user);
        $entityManager->flush();

        return $this->redirectToRoute('user_profile', [
            'user' => $this->getUser(),
        ]);
    }


    /**
     * @Route("/follow", name="ajax_follow")
     * @param Request $request
     * @return JsonResponse
     * @throws BadRequestException
     */
    public function ajaxFollow(Request $request): JsonResponse
    {
        /*   if (!$request->isXmlHttpRequest() ) {
                return new JsonResponse('Aucune donnée reçu');
            }*/
        // initialise les donnée a envoyé


        $follower = $request->request->get('username');

        if ($follower !== '' || !$follower) {
            $getFollower = $this->entityManager->getRepository(User::class)->findOneBy(
                [
                    'username' =>  $follower
                ]
            );

            if (!$getFollower) {
                return new JsonResponse('aucun membre associé');
            }
            if ()
            $follows = new Follows();
            $follows->setFollowing($this->getUser())
                ->setFollowers($getFollower->getId())
                ->setCreateAt(date("Y-m-d H:i:s"))
                ->setHasFollow(false);

            $this->entityManager->persist($follows);
            $this->entityManager->flush();


            return new JsonResponse($request->request->all());

        }

        return new JsonResponse('Aucune post idendifié');

    }
}
