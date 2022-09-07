<?php

namespace App\Controller\Api;

use App\AbstractEntity\BaseAbstractController;
use App\Entity\Category;
use App\Exception\BusinessException;
use App\Repository\CategoryRepository;
use App\Serializer\Interfaces\SerializerManagerInterface;
use App\Service\Article\Serializer\ArticleApiSerializer;
use App\Service\Category\CategoryService;
use App\Service\Category\Request\CreateUpdateApiCategoryRequest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class CategoryApiController
 */
class CategoryApiController extends BaseAbstractController
{
    /**
     * CategoryApiController constructor.
     * @param CategoryService $service
     * @param CategoryRepository $repository
     * @param ArticleApiSerializer $articleApiSerializer
     */
    public function __construct(
        private readonly CategoryService $service,
        private readonly CategoryRepository $repository,
        private readonly ArticleApiSerializer $articleApiSerializer,
    ){}

    /**
     * @param SerializerManagerInterface $manager
     * @return Response
     */
    #[Route("/api/categories/parent", methods: ["GET"])]
    public function getParentCategories(): Response
    {
        $repositoryHash = $this->entityManager->getClassMetadata(Category::class);
//        dd($repositoryHash);
//        $this->entityManager->getRepository();
        $categories = $this->repository->findBy(['id' =>[3,1]]);
//
//        $builder = $manager->createSerializerBuilder('1');
//
//        $builder->addFields('parent', ['id', 'name']);
//
//        $builder->addAlias('parent.parent', 'second_parent');
//        $builder->addFields('second_parent', ['id', 'slug']);
//
//        $serialized = $this->serializer->serialize($categories, 'api', $builder->normalizerParts);
//        $this->serializer->getResourse(Category::class)->serialize($categories, 'api');

        $res = $this->serializer->normalize($categories, 'api', Category::class);

        dd($res);

        $serialized = $this->serializer->serialize($categories, 'api');

        dd($serialized);

        $deserialized = $this->serializer->deserialize($serialized, Category::class);

        dd($deserialized);

        return $this->serializer->serialize($categories);
    }

    /**
     * @param Request $request
     * @return Response
     */
    #[Route("/api/categories/select", methods: ["GET"])]
    public function getCategoriesSelect(Request $request): Response
    {
        $categories = $this->repository->findAll();

        $response = array_map(function (Category $category){
            return [
                'id' => $category->getId(),
                'name' => $category->getName()
            ];
        }, $categories);

        return $this->success(['entities' => $response]);
    }

    /**
     * @param Category $category
     * @return Response
     */
    #[Route("/api/category/{id}", methods: ["GET"])]
    public function getCategory(Category $category): Response
    {
        return $this->serializer->serialize($category);
    }

    /**
     * @param CreateUpdateApiCategoryRequest $request
     * @return Response
     */
    #[Route("/api/category", name: "create.category", methods: ["POST"])]
    public function createCategory(CreateUpdateApiCategoryRequest $request): Response
    {
        $dto = $request->getDTO();

        $category = new Category();

        $this->service->createOrUpdateCategory($category, $dto);

        return $this->serializer->serialize($category);
    }

    /**
     * @param CreateUpdateApiCategoryRequest $request
     * @param Category $category
     * @return Response
     */
    #[Route("/api/category/{id}", methods: ["PATCH"])]
    public function patchCategory(CreateUpdateApiCategoryRequest $request, Category $category): Response
    {
        $dto = $request->getDTO();

        $this->service->createOrUpdateCategory($category, $dto);

        return $this->serializer->serialize($category);
    }

    /**
     * @param Category $category
     * @return Response
     */
    #[Route("/api/category/{id}", methods: ["DELETE"])]
    public function deleteCategory(Category $category): Response
    {
        $id = $category->getId();

        $this->entityManager->remove($category);

        $this->entityManager->flush();

        return $this->success(['id' => $id]);
    }

    /**
     * @param Category $category
     * @return Response
     */
    #[Route("/api/category/children/{id}", methods: ["GET"])]
    public function getCategoryChildrenById(Category $category): Response
    {
        return $this->serializer->serialize($category->getChildren()->getValues());
    }

    /**
     * @param Category $category
     * @return Response
     */
    #[Route("/api/category/child/{id}", methods: ["GET"])]
    public function getParentsCategoriesByChildId(Category $category): Response
    {
        $path = array_slice(explode('/', $category->getPath()), 1, -1);

        foreach ($path as $id){

            $parentCategory = $this->repository->find($id);

            if (!$parentCategory){
                return throw new BusinessException();
            }

            $categories[] = $parentCategory->getId();
        }

        return $this->success(['ids' => $categories ?? []]);
    }

    /**
     * @param Category $category
     * @return Response
     */
    #[Route("/api/categories/{id}/articles", methods: ["GET"])]
    public function getCategoryArticles(Category $category): Response
    {
        return $this->articleApiSerializer->serialize($category->getArticles()->toArray());
    }

}