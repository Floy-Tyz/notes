<?php

namespace App\Model\Note\Http\Controller\Api;

use App\Infrastructure\AbstractClass\BaseAbstractController;
use App\Model\Note\Orm\Entity\Note;
use App\Model\Note\Orm\Entity\Point;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Attributes as OA;

#[OA\Tag(name: 'Запись записной книжки')]
class PointApiController extends BaseAbstractController
{

    #[Route("/points/{id}", name: "getPointById", methods: ["POST"])]
    public function getPointById(Point $point): Response
    {
        $entity = $this->serializer->normalize($point, null, ['groups' => ['api']]);

        return $this->success(compact('entity'));
    }

    #[Route("/points/{id}/checked", name: "update.point.checked", methods: ["PATCH"])]
    public function updatePointStatus(Point $point, Request $request): Response
    {
        $point->setChecked($request->request->get('checked'));

        $this->entityManager->flush();

        return $this->success();
    }

    /**
     * @param Point $point
     * @return Response
     */
    #[Route("/points/{id}", methods: ["DELETE"])]
    public function deletePoint(Point $point): Response
    {
        $id = $point->getId();

        $this->entityManager->remove($point);

        $this->entityManager->flush();

        return $this->success(['id' => $id]);
    }
}
