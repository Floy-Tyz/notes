<?php

namespace App\Controller\Web;

use App\AbstractEntity\BaseAbstractController;
use App\Entity\Point;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PointController extends BaseAbstractController
{
    /**
     * @param Point $point
     * @return Response
     */
    #[Route("/api/points/{id}", name: "getPointById", methods: ["POST"])]
    public function getPointById(Point $point): Response
    {
        return $this->response->api->success($point);
    }

    /**
     * @param Point $point
     * @param Request $request
     * @return Response
     */
    #[Route("/api/points/{id}/checked", name: "update.point.checked", methods: ["PATCH"])]
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
    #[Route("/api/points/{id}", methods: ["DELETE"])]
    public function deletePoint(Point $point): Response
    {
        $id = $point->getId();

        $this->entityManager->remove($point);

        $this->entityManager->flush();

        return $this->success(['id' => $id]);
    }
}
