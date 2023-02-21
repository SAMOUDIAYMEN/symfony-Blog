<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\User;
use App\Repository\ArticleRepository;
use App\Repository\CommentRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
/** @method User getUser() */
class CommentController extends AbstractController
{
    #[Route('/article/ajax/comments', name: 'comment_add')]
    public function add(Request $request, ArticleRepository $articleRepo, UserRepository $userRepo, EntityManagerInterface $em, CommentRepository $commentRepo): Response
    {
        $commentData = $request->request->all('comment');
        // dd($commentData);Créer un blog avec Symfony 6 - 06 - Création du système de commentaires
        if(!$this->isCsrfTokenValid('comment-add',$commentData['_token'])){
            return $this->json([
                'code' => 'INVALID_CSRF_TOKEN'
            ],Response::HTTP_BAD_REQUEST);
        }
        
        $article = $articleRepo->findOneBy(['id' => $commentData['articleId']]);

        if(!$article){
            return $this->json([
                'code' => 'ARTICLE_NOT_FOUND'
            ],Response::HTTP_BAD_REQUEST);
        }
        $user = $this->getUser();

        if(!$user){
            return $this->json(['code'=>'USER_IS_NOT_AUTHENTICATED_FULLY'],Response::HTTP_BAD_REQUEST);
        }

        $comment = new Comment($article);
        $comment->setContent($commentData['content']);
        $comment->setUser($user); 
        $comment->setCreatedAt(new \DateTime());

        $em->persist($comment);
        $em->flush();

        $html = $this->renderView('comment/index.html.twig', [
            'comment' => $comment,
        ]);
        return $this->json([
            'code' => 'COMMENT_ADDED_SUCCESSFULLY',
            'message' => $html,
            'numberOfComments' => $commentRepo->count(['articleId' => $article]),
        ]);
    }
}
