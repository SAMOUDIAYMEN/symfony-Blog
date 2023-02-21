<?php

namespace App\Service;

use App\Entity\Article;
use App\Entity\Comment;
use App\Repository\ArticleRepository;
use App\Repository\CommentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class CommentService
{
    public function __construct(
        private CommentRepository      $commentRepo,
        private PaginatorInterface     $paginator,
        private RequestStack           $requestStack,
    )
    {

    }

    public function getPaginatedComments(?Article $article = null): PaginationInterface
    {
        $request = $this->requestStack->getMainRequest();
        $page = $request->query->getInt('page', 1);
        $limit = 3;

        $commentsQuery = $this->commentRepo->findForPagination($article);

        return $this->paginator->paginate($commentsQuery, $page, $limit);
    }

}