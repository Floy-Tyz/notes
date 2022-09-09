<?php

namespace App\Controller\Web;

use App\AbstractEntity\BaseAbstractController;
use App\Entity\Note;
use App\Entity\Point;
use App\Repository\NoteRepository;
use App\Service\Note\NoteService;
use App\Service\Note\Request\CreateUpdateApiNoteRequest;
use Nelmio\ApiDocBundle\Annotation\Model;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Attributes as OA;

#[OA\Tag(name: 'notes')]
class NoteController extends BaseAbstractController
{
    /**
     * NoteController constructor.
     * @param NoteService $service
     * @param NoteRepository $repository
     */
    public function __construct(
        private readonly NoteService $service,
        private readonly NoteRepository $repository,
    ){}

    #[Route("/api/notes", methods: ["GET"])]
    #[OA\Response(
        response: 200,
        description: 'Возвращает все записные карточки',
        content: new OA\JsonContent(
            type: 'array',
            items: new OA\Items(ref: new Model(type: Note::class, groups: ['api']))
        )
    )]
    public function getNotes(): Response
    {
        $notes = $this->repository->findAll();
        return $this->response->api->success($notes);
    }

    #[Route("/api/notes/{id}", methods: ["GET"])]
    #[OA\Response(
        response: 200,
        description: 'Возвращает записную карточку по id',
        content: new OA\JsonContent(
            ref: new Model(type: Note::class, groups: ['api']),
        )
    )]
    public function getNote(Note $note): Response
    {
        return $this->response->api->success($note);
    }


    #[Route("/api/note", name: "create.note", methods: ["POST"])]
    #[OA\Response(
        response: 200,
        description: 'Создает новую записную карточку',
        content: new OA\JsonContent(
            ref: new Model(type: Note::class, groups: ['api']),
        )
    )]
//    #[OA\Parameter(
//        name: 'name',
//        description: 'Название записной карточки',
//        in: 'path',
//        required: true,
//        schema:  new OA\Schema(type: 'string')
//    )]
    #[OA\RequestBody(
        description: 'Список записей',
        content: [
//            new OA\MediaType(
//                mediaType: 'application/string',
//                schema: new OA\Schema(
//                    type: 'string',
//                )
//            ),
            new OA\MediaType(
                mediaType: 'application/json',
                schema: new OA\Schema(
                    type: 'array',
                    items: new OA\Items(
                        properties: [
                            new OA\Property(property: 'name', description: 'Название записи', type: 'string')
                        ],
                    ),
                    example: [
                        [
                            'name' => 'first point'
                        ],
                        [
                            'name' => 'second point'
                        ],
                    ]
                )
            )
        ]
    )]
    public function createNote(CreateUpdateApiNoteRequest $request): Response
    {
        $dto = $request->getDTO();

        $note = new Note();

        $this->service->createOrUpdateNote($note, $dto);

        return $this->response->api->success($note);
    }

    #[Route("/api/notes/{id}", methods: ["DELETE"])]
    #[OA\Response(
        response: 200,
        description: 'Удаляет записную карточку по id',
    )]
    public function deleteNote(Note $note): Response
    {
        $id = $note->getId();

        $this->entityManager->remove($note);

        $this->entityManager->flush();

        return $this->success(['id' => $id]);
    }

    /**
     * @param Note $note
     * @return Response
     */
    #[Route("/api/notes/{id}/points", methods: ["GET"])]
    #[OA\Response(
        response: 200,
        description: 'Получает все записи карточки',
        content: new OA\JsonContent(
            ref: new Model(type: Point::class, groups: ['api']),
        )
    )]
    public function getNotePoints(Note $note): Response
    {
        return $this->response->api->success($note->getPoints()->toArray());
    }

}