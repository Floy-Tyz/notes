<?php

namespace App\Controller\Web;

use App\AbstractEntity\BaseAbstractController;
use App\Entity\Note;
use App\Service\Note\NoteService;
use App\Service\Note\Request\CreateUpdateApiNoteRequest;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class NoteController
 */
class NoteController extends BaseAbstractController
{
    /**
     * NoteController constructor.
     * @param NoteService $service
     */
    public function __construct(
        private readonly NoteService $service,
    ){}

    /**
     * @param Note $note
     * @return Response
     */
    #[Route("/api/note/{id}", methods: ["GET"])]
    public function getNote(Note $note): Response
    {
        return $this->response->api->success($note);
    }

    /**
     * @param CreateUpdateApiNoteRequest $request
     * @return Response
     */
    #[Route("/api/note", name: "create.note", methods: ["POST"])]
    public function createNote(CreateUpdateApiNoteRequest $request): Response
    {
        $dto = $request->getDTO();

        $note = new Note();

        $this->service->createOrUpdateNote($note, $dto);

        return $this->response->api->success($note);
    }

    /**
     * @param Note $note
     * @return Response
     */
    #[Route("/api/note/{id}", methods: ["DELETE"])]
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
    public function getNotePoints(Note $note): Response
    {
        return $this->response->api->success($note->getPoints());
    }

}