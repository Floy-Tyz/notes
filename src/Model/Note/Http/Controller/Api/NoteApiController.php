<?php

namespace App\Model\Note\Http\Controller\Api;

use App\Infrastructure\AbstractClass\BaseAbstractController;
use App\Model\Note\Http\Request\CreateApiNoteData;
use App\Model\Note\Http\Request\CreateApiPointData;
use App\Model\Note\Http\Request\UpdateApiNoteData;
use App\Model\Note\Orm\Entity\Note;
use App\Model\Note\Orm\Repository\NoteRepository;
use App\Model\Note\Service\Manager\NoteManagerInterface;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as OA;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[OA\Tag(name: 'Записная книжка')]
class NoteApiController extends BaseAbstractController
{
    /**
     * NoteApiController constructor.
     * @param NoteManagerInterface $manager
     * @param NoteRepository $repository
     */
    public function __construct(
        private readonly NoteManagerInterface $manager,
        private readonly NoteRepository $repository,
    ){}

    #[OA\Get(
        summary: 'Возвращает все записные карточки',
        responses: [
            new OA\Response(
                response: 200,
                description: 'Возвращает все записные карточки',
                content: new OA\JsonContent(
                    type: 'array',
                    items: new OA\Items(ref: new Model(type: Note::class, groups: ['api']))
                )
            )
        ]
    )]
    #[Route("/notes", name: 'get.notes.list', methods: ["GET"])]
    public function getNotes(): Response
    {
        $entities = $this->serializer->normalize($this->repository->findAll(), null, ['groups' => 'api']);

        return $this->success(compact('entities'));
    }

    #[OA\Get(
        summary: 'Возвращает записную карточку по id',
        responses: [
            new OA\Response(
                response: 200,
                description: 'Возвращает записную карточку по id',
                content: new OA\JsonContent(
                    ref: new Model(type: Note::class, groups: ['api']),
                )
            )
        ],
    )]
    #[Route("/notes/{id}", name: 'get.note.by.id', methods: ["GET"])]
    public function getNote(Note $note): Response
    {
        $entity = $this->serializer->normalize($note, null, ['groups' => 'api']);

        return $this->success(compact('entity'));
    }

    #[OA\Post(
        summary: 'Создает новую записную карточку',
        requestBody: new OA\RequestBody(
            description: 'Список записей',
            content: new OA\JsonContent(ref: '#/components/schemas/new-note-request-body')
        ),
        responses: [
            new OA\Response(
                response: 200,
                description: 'Создает новую записную карточку',
                content: new OA\JsonContent(
                    ref: '#components/schemas/note',
                )
            )
        ]
    )]
    #[Route("/notes/new", methods: ["POST"])]
    public function createNote(CreateApiNoteData $data): Response
    {
        $note = new Note();

        $this->manager->createNote($note, $data);

        $entity = $this->serializer->normalize($note, null, ['groups' => ['api', 'list']]);

        return $this->success(compact('entity'));
    }

    #[OA\Patch(
        summary: 'Обновляет записную карточку',
        requestBody: new OA\RequestBody(
            description: 'Список записей',
            content: new OA\JsonContent(ref: '#/components/schemas/update-note-request-body')
        ),
        responses: [
            new OA\Response(
                response: 200,
                description: 'Создает новую записную карточку',
                content: new OA\JsonContent(
                    ref: '#components/schemas/note',
                )
            )
        ]
    )]
    #[Route("/notes/{id}", methods: ["PATCH"])]
    public function updateNote(Note $note, UpdateApiNoteData $data): Response
    {
        $this->manager->updateNote($note, $data);

        $entity = $this->serializer->normalize($note, null, ['groups' => ['api', 'list']]);

        return $this->success(compact('entity'));
    }

    #[OA\Delete(
        summary: 'Удаляет записную карточку по id',
        responses: [
            new OA\Response(
                response: 200,
                description: 'Удаляет записную карточку по id',
            )
        ]
    )]
    #[Route("/notes/{id}", methods: ["DELETE"])]
    public function deleteNote(Note $note): Response
    {
        $id = $note->getId();

        $this->entityManager->remove($note);

        $this->entityManager->flush();

        return $this->success(['id' => $id]);
    }

    #[OA\Get(
        summary: 'Получает все записи карточки',
        responses: [
            new OA\Response(
                response: 200,
                description: 'Получает все записи карточки',
                content: new OA\JsonContent(
                    ref: '#/components/schemas/point',
                )
            )
        ],
    )]
    #[Route("/notes/{id}/points", methods: ["GET"])]
    public function getNotePoints(Note $note): Response
    {
        $entities = $this->serializer->normalize($note->getPoints(), null, ['groups' => 'api']);

        return $this->success(compact('entities'));
    }


    #[OA\Post(
        summary: 'Создает новую запись для карточки',
        responses: [
            new OA\Response(
                response: 200,
                description: 'Создает новую запись для карточки',
                content: new OA\JsonContent(
                    ref: '#/components/schemas/point',
                )
            )
        ],
    )]
    #[Route("/notes/{id}/points/new", name: "create.new.point", methods: ["POST"])]
    public function createPoint(Note $note, CreateApiPointData $data): Response
    {
        $entity = $this->serializer->normalize($this->manager->createPointByData($note, $data), null, ['groups' => ['api']]);

        return $this->success(compact('entity'));
    }

}