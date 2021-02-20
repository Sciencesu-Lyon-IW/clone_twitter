<?php

namespace App\Controller;

use App\Entity\Posts;
use App\Entity\User;
use App\Repository\PostsRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\ORMInvalidArgumentException;
use PhpParser\Node\Expr\New_;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\DateTime;


class HomeController extends AbstractController
{
    private EntityManagerInterface $entityManager;
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;

    }
    /**
     * @Route("/home", name="home")
     */
    public function index(): Response
    {
        $post = $this->entityManager->getRepository(Posts::class)->findAll();
        if (!$post) {
            $error = 'Pas de post ici';
        }

        return $this->render('home/index.html.twig', [
            'user' => $this->getUser(),
            'posts'=> $this->entityManager->getRepository(Posts::class)->findAll(),

        ]);
    }

    /**
     * @Route("/create/tweet", name="ajax_create_tweet")
     * @param Request $request
     * @return JsonResponse
     */
    public function ajaxCreateTweet(Request $request): JsonResponse
    {

        if ($request->request->get('whats_happening')) {
            $this->createTweet($request);
            return new JsonResponse($request->request->get('whats_happening'));
        }
        return new JsonResponse($request->request->get('whats_happening'));

    }

    /**
     * @Route("/create/tweet", name="create_tweet")
     * @param Request $request
     * @return Response
     */
    public function createTweet(Request $request): Response
    {

        if (!$request->request->get('whats_happening') || $request->request->get('whats_happening') === "")
        {
            return new Response('Erreur lors la publication du twwet');
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
        return $this->redirectToRoute('home');
        // do anything else you need here, like send a email
        /*  return $this->render('home/index.html.twig', [
              'user' => $this->getUser(),

          ]);*/
    }

    /**
     * @Route("/like/tweet", name="ajax_like_tweet", methods={"POST"})
     * @param Request $request
     * @return JsonResponse
     * @throws BadRequestException
     */
    public function ajaxLikeTweet(Request $request): JsonResponse
    {
        /*    if (!$request->isXmlHttpRequest() ) {
                return new JsonResponse('Aucune donnée reçu');
            }*/
        // initialise les donnée a envoyé
        $hasLike = $request->request->get('hasLike');
        $whoLike = $request->request->get('whoLike');
        $post = $request->request->get('post');
        $post_search = new Posts();
        $like = new Likes();
        // on cherche si un post liké existe
        $post_find = $this->entityManager->getRepository(Posts::class)->find($post);
        if (!$post_find) {
            return new JsonResponse('aucun post associé');

        }
        // on cherche le post like en fonction de l'id du post liké
        $like_post_find = $this->entityManager->getRepository(Likes::class)->findBy(
            [
                'posts' => $post_find->getId(),
                'user' => $this->getUser(),
            ]
        );
        // on stocke les informations du post liké dans une variable
        // Si le poste n'existe pas dans la table, c'est qu'il liké par un nouvel user, on crée une nouvelle entrée
        if (!$like_post_find) {

            $like->setPosts($post_find);
            $like->setHasLiked($hasLike);
            $like->setUser($this->getUser());
            $this->entityManager->persist($like);
            $this->entityManager->flush();
            return new JsonResponse($request->request->all());



        }
        $like_post_find = $like_post_find[0];

      /*  if ($this->getUser() !== $like_post_find->getUser() && $post !== $like_post_find->getPosts()) {

            $like->setPosts($post_find);
            $like->setHasLiked($hasLike);
            $like->setUser($this->getUser());
            $this->entityManager->persist($like);
            $this->entityManager->flush();
            return new JsonResponse($request->request->all());

        }*/
        if ($like_post_find->getHasLiked() !== true) {

            $like_post_find->setHasLiked(true);
            $like_post_find->setUpdatedAt(date("Y-m-d H:i:s"));

            $this->entityManager->flush();
            return new JsonResponse($request->request->all());

        }
        $like_post_find->setHasLiked(false);
        $like_post_find->setUpdatedAt(date("Y-m-d H:i:s"));
        $this->entityManager->flush();

        return new JsonResponse($request->request->all());

    }

}
