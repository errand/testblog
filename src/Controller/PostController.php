<?php

namespace App\Controller;

use App\Entity\Post;
use App\Repository\CommentRepository;
use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

class PostController extends AbstractController
{
    /**
     * @Route("/", name="homepage")
     */
    public function index(Environment $twig, PostRepository $postRepository): Response
    {
        return new Response($twig->render('post/index.html.twig', [
            'posts' => $postRepository->findAll(),
            ]));
    }

    /**
     * @Route("/post/{id}", name="post")
     */
    public function show(Environment $twig, Post $post, CommentRepository $commentRepository): Response
    {
        return new Response($twig->render('post/show.html.twig', [
            'post' => $post,
            'comments' => $commentRepository->findBy(['post' => $post], ['createdAt' => 'DESC']),
        ]));
    }
}
