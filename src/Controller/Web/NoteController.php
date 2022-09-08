<?php

namespace App\Controller\Web;

use App\AbstractEntity\BaseAbstractController;
use App\Entity\Note;
use App\Repository\NoteRepository;
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
     * @param NoteRepository $repository
     */
    public function __construct(
        private readonly NoteService $service,
        private readonly NoteRepository $repository,
    ){}

    /**
     * @return Response
     */
    #[Route("/api/notes", methods: ["GET"])]
    public function getNotes(): Response
    {
        $notes = $this->repository->findAll();
        return $this->response->api->success($notes);
    }

    /**
     * @param Note $note
     * @return Response
     */
    #[Route("/api/notes/{id}", methods: ["GET"])]
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
    #[Route("/api/notes/{id}", methods: ["DELETE"])]
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
        return $this->response->api->success($note->getPoints()->toArray());
    }

}