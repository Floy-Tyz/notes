<?php

namespace App\Controller\Api;

use App\AbstractEntity\BaseAbstractController;
use App\Entity\Article;
use App\Service\Article\ArticleService;
use App\Service\Article\Request\CreateUpdateApiArticleRequest;
use App\Service\Article\Serializer\ArticleApiSerializer;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticleApiController extends BaseAbstractController
{
    /**
     * @param ArticleApiSerializer $serializer
     * @param ArticleService $service
     */
    public function __construct(
        private readonly ArticleService $service,
    ){}

    /**
     * @param Article $article
     * @return Response
     */
    #[Route("/api/articles/{id}", name: "getArticleById", methods: ["POST"])]
    public function getArticleById(Article $article): Response
    {
        return $this->serializer->serialize($article);
    }

    /**
     * @param Article $article
     * @param Request $request
     * @return Response
     */
    #[Route("/api/articles/{id}/content", name: "updateArticleContent", methods: ["PATCH"])]
    public function updateArticleContent(Article $article, Request $request): Response
    {
        $article->setContent($request->request->get('content'));

        $this->entityManager->flush();

        return $this->success();
    }

    /**
     * @param CreateUpdateApiArticleRequest $request
     * @return Response
     */
    #[Route("/api/articles", name: "create.article", methods: ["POST"])]
    public function createArticle(CreateUpdateApiArticleRequest $request): Response
    {
        $dto = $request->getDTO();

        $article = new Article();

        $this->service->createOrUpdateArticle($article, $dto);

        return $this->serializer->serialize($article);
    }

    /**
     * @param CreateUpdateApiArticleRequest $request
     * @param Article $article
     * @return Response
     */
    #[Route("/api/articles/{id}", methods: ["PATCH"])]
    public function patchArticle(CreateUpdateApiArticleRequest $request, Article $article): Response
    {
        $dto = $request->getDTO();

        $this->service->createOrUpdateArticle($article, $dto);

        return $this->serializer->serialize($article);
    }

    /**
     * @param Article $article
     * @return Response
     */
    #[Route("/api/articles/{id}", methods: ["DELETE"])]
    public function deleteArticle(Article $article): Response
    {
        $id = $article->getId();

        $this->entityManager->remove($article);

        $this->entityManager->flush();

        return $this->success(['id' => $id]);
    }
}
