<?php

namespace App\Controller;

use App\Entity\Posts;
use App\Entity\User;
use App\Repository\PostsRepository;
use PhpParser\Node\Expr\New_;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\DateTime;
/**
 * @IsGranted("IS_AUTHENTICATED_FULLY")
 */
class HomeController extends AbstractController
{
    /**
     * @Route("/home", name="home")
     */
    public function index(): Response
    {
        if(!$this->isGranted("IS_AUTHENTICATED_FULLY"))
        {
            $this->redirectToRoute("app_register");
        }
        $entityManager = $this->getDoctrine()->getManager();
        $post = $entityManager->getRepository(Posts::class)->findAll();
        if (!$post) {
            $error = 'Pas de post ici';
        }

        return $this->render('home/index.html.twig', [
            'user' => $this->getUser(),
            'posts'=> $entityManager->getRepository(Posts::class)->findAll(),

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
}
