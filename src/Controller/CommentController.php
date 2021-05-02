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

class CommentController extends AbstractController
{

    private $twig;
    private $entityManager;

    public function __construct(Environment $twig, EntityManagerInterface $entityManager)
    {
        $this->twig = $twig;
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/comment/{id}/delete", name="delete_comment")
     */
    public function deleteComment(Request $request, $id, CommentRepository $commentRepository): Response
    {
        $comment = $commentRepository->findOneBy(['id' => $id]);

        $this->entityManager->remove($comment);

        $this->entityManager->flush();

        return $this->redirect($request->request->get('referer'));
    }

    /**
     * @Route("/comment/{id}/hide", name="hide_comment")
     */
    public function hideComment(Request $request, $id, CommentRepository $commentRepository): Response
    {
        $comment = $commentRepository->findOneBy(['id' => $id]);

        $comment->setHidden(1);

        $this->entityManager->flush();

        return $this->redirect($request->request->get('referer'));
    }

}
