<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Post;
use App\Form\CommentFormType;
use App\Repository\CommentRepository;
use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Twig\Environment;

class PostController extends AbstractController
{

    private $twig;
    private $entityManager;

    public function __construct(Environment $twig, EntityManagerInterface $entityManager)
    {
        $this->twig = $twig;
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/", name="homepage")
     */
    public function index(Request $request, PostRepository $postRepository): Response
    {

	    $offset = max(0, $request->query->getInt('offset', 0));
	    $paginator = $postRepository->paginatedPosts($offset);

        return new Response($this->twig->render('post/index.html.twig', [
        	  //TODO Pagination
            'posts' => $paginator,
            'previous' => $offset - PostRepository::PAGINATOR_PER_PAGE,
            'next' => min(count($paginator), $offset + PostRepository::PAGINATOR_PER_PAGE),
            ]));
    }

		/**
		 * @Route("/posts/search", name="search")
		 */
		public function search(Request $request, PostRepository $postRepository)
		{
			$query = $request->query->get('q');
			$posts = $postRepository->searchByQuery($query);

			return new Response($this->twig->render('post/search.html.twig', [
				'posts' => $posts,
				'query' => $query,
			]));
	  }

		/**
		 * @Route("/ajax_search", name="ajax_search")
		 */
		public function searchAction(Request $request, PostRepository $postRepository)
		{
			$query = $request->query->get('q');
			$posts = $postRepository->searchByQuery($query);

			if(!$posts) {
				$result['posts']['error'] = "Nothing found";
			} else {
				$result['posts'] = $this->getRealEntities($posts);
			}

			return new Response(json_encode($result));
		}

	public function getRealEntities($entities){

		foreach ($entities as $entity){
			$realEntities[$entity->getId()] = $entity->getTitle();
		}

		return $realEntities;
	}


    /**
     * @Route("/post/{id}", name="post")
     */
    public function show(Request $request, Post $post, CommentRepository $commentRepository): Response
    {
        $comment = new Comment();
        $form = $this->createForm(CommentFormType::class, $comment);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $comment->setPost($post);

            $this->entityManager->persist($comment);
            $this->entityManager->flush();

            return $this->redirectToRoute('post', ['id' => $post->getId()]);
        }

        $offset = max(0, $request->query->getInt('offset', 0));
        $paginator = $commentRepository->getCommentPaginator($post, $offset);

        return new Response($this->twig->render('post/show.html.twig', [
            'post' => $post,
            'comments' => $paginator,
            'previous' => $offset - CommentRepository::PAGINATOR_PER_PAGE,
            'next' => min(count($paginator), $offset + CommentRepository::PAGINATOR_PER_PAGE),
            'comment_form' => $form->createView(),
        ]));
    }
}
