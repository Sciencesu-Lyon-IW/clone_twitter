<?php

namespace App\Controller;

use App\Entity\Comments;
use App\Entity\Likes;
use App\Entity\Posts;
use App\Entity\Repost;
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
    private Posts $posts;
    private Likes $likes;
    private string $error = '';
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->posts = new Posts();
        $this->likes = new Likes();
    }

    /**
     * @Route("/home", name="home")
     * @return Response
     */
    public function index(): Response
    {

        $post = $this->entityManager->getRepository(Posts::class)->findAll();
        $comment = [];
        if (!$post) {
            $this->error = 'Pas de post ici';
        }

        for ($i = 0, $iMax = count($post); $i < $iMax; $i++)
        {
            $comment += [$post[$i]];

            $s = $this->entityManager->getRepository(Comments::class)->findBy(
                [
                    'posts' => $post,
                ]
            );
        }

        return $this->render('home/index.html.twig', [
            'user' => $this->getUser(),
            'posts'=> $this->entityManager->getRepository(Posts::class)->findAll(),
            'error' => $this->error,
            'comments' => $s,

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
        // do anything else you need here, like send an email
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

        if (!$like_post_find || $like_post_find === null)
        {
            $like->setPosts($post_find);
            $like->setHasLiked($hasLike);
            $like->setUser($this->getUser());
            $this->entityManager->persist($like);
            $this->entityManager->flush();
            return new JsonResponse($request->request->all());

        }
        $like_post_find = $like_post_find[0];
        // on stocke les informations du post liké dans une variable
        // Si le poste n'existe pas dans la table, c'est qu'il liké par un nouvel user, on crée une nouvelle entrée*
        if ($like_post_find->getPosts() !== $request->request->get('post') && $like_post_find->getUser()->getUsername() !== $whoLike) {


            $like->setPosts($post_find);
            $like->setHasLiked($hasLike);
            $like->setUser($this->getUser());
            $this->entityManager->persist($like);
            $this->entityManager->flush();
            return new JsonResponse($request->request->all());



        }

        // on verifie si il l'user a deja liker
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

    /**
     * @Route("/retweet/tweet", name="ajax_retweet_tweet")
     * @param Request $request
     * @return JsonResponse
     * @throws BadRequestException
     */
    public function ajaxRetweet(Request $request): JsonResponse
    {
        /*    if (!$request->isXmlHttpRequest() ) {
               return new JsonResponse('Aucune donnée reçu');
           }*/
        // initialise les donnée a envoyé
        $whoRetweet = $request->request->get('whoRetweet');
        $post = $request->request->get('post');
        $post_search = new Posts();
        $retweet = new Repost();
        // on cherche si un post liké existe

        $post_find = $this->entityManager->getRepository(Posts::class)->find($post);

        if (!$post_find) {

            return new JsonResponse('aucun post associé');
        }
        // on cherche le post like en fonction de l'id du post liké
        $retweet_post_find = $this->entityManager->getRepository(Repost::class)->findBy(
            [
                'posts' => $post_find->getId(),
                'user' => $this->getUser(),
            ]
        );

        if (!$retweet_post_find)
        {

            $retweet->setPosts($post_find);
            $retweet->setHasReposted(true);
            $retweet->setUser($this->getUser());
            $this->entityManager->persist($retweet);
            $this->entityManager->flush();
            return new JsonResponse($request->request->all());

        }
        $retweet_post_find = $retweet_post_find[0];
        // on stocke les informations du post liké dans une variable
        // Si le poste n'existe pas dans la table, c'est qu'il liké par un nouvel user, on crée une nouvelle entrée*
       /* if ($retweet_post_find->getPosts() !== $request->request->get('post') && $retweet_post_find->getUser()->getUsername() !== $whoRetweet) {


            $retweet->setPosts($post_find);
            $retweet->setHasReposted(true);
            $retweet->setUser($this->getUser());
            $this->entityManager->persist($retweet);
            $this->entityManager->flush();
            return new JsonResponse($request->request->all());



        }*/

        // on verifie si il l'user a deja liker
        if ($retweet_post_find->getHasReposted() !== true) {
            $retweet_post_find->setHasReposted(true);
            $retweet_post_find->setUpdatedAt(date("Y-m-d H:i:s"));

            $this->entityManager->flush();
            return new JsonResponse($request->request->all());

        }

        $retweet_post_find->setHasReposted(false);
        $retweet_post_find->setUpdatedAt(date("Y-m-d H:i:s"));
        $this->entityManager->flush();

        return new JsonResponse($request->request->all());


    }

    /**
     * @Route("/comment/tweet", name="ajax_comment_tweet")
     * @param Request $request
     * @return JsonResponse
     * @throws BadRequestException
     */
    public function ajaxComment(Request $request): JsonResponse
    {
       /*   if (!$request->isXmlHttpRequest() ) {
               return new JsonResponse('Aucune donnée reçu');
           }*/
        // initialise les donnée a envoyé
        $post = $request->request->get('post');
        $body = $request->request->get('comment');
        if ($post !== '' || !$post) {

            if ($body !== '' || !$body) {
                $setPost = $this->entityManager->getRepository(Posts::class)->find($post);
                $comment = new Comments();

                $comment->setUser($this->getUser());
                $comment->setPosts($setPost);
                $comment->setBody($body);
                $comment->setCreatedAt(date("Y-m-d H:i:s"));
                $this->entityManager->persist($comment);

                $this->entityManager->flush();

                return new JsonResponse($request->request->all());
            }
            return new JsonResponse('Contenu vide');

        }

        return new JsonResponse('Aucune post idendifié');


    }

}
