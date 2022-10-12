<?php

namespace App\Model\Note\Service\Manager;

use App\Infrastructure\AbstractClass\BaseAbstractService;
use App\Model\Note\Http\Request\CreateApiNoteData;
use App\Model\Note\Http\Request\CreateApiPointData;
use App\Model\Note\Http\Request\UpdateApiNoteData;
use App\Model\Note\Orm\Entity\Note;
use App\Model\Note\Orm\Entity\Point;
use App\Model\Note\Orm\Repository\PointRepository;
use Symfony\Component\String\Slugger\SluggerInterface;

class NoteManager extends BaseAbstractService implements NoteManagerInterface
{
    /**
     * @param SluggerInterface $slugger
     * @param PointRepository $pointRepository
     */
    public function __construct(
        private readonly SluggerInterface $slugger,
        private readonly PointRepository $pointRepository
    ){}

    /**
     * @param Note $note
     * @param CreateApiNoteData $data
     * @return void
     */
    public function createNote(Note $note, CreateApiNoteData $data): void
    {
        $note->setName($data->getName());

        $note->setSlug($this->slugger->slug(mb_strtolower($data->getName())));

        foreach ($data->getPoints() as $point) {
            $this->createPointByArray($note, $point);
        }

        $this->entityManager->persist($note);
        $this->entityManager->flush();
    }

    /**
     * @param Note $note
     * @param UpdateApiNoteData $data
     * @return void
     */
    public function updateNote(Note $note, UpdateApiNoteData $data): void
    {
        $note->setName($data->getName());

        $note->setSlug($this->slugger->slug(mb_strtolower($data->getName())));

        $this->updateOrRemovePoints($note, $data->getPoints());

        $this->entityManager->persist($note);
        $this->entityManager->flush();
    }

    /**
     * @param Note $note
     * @param CreateApiPointData $data
     * @return Point
     */
    public function createPointByData(Note $note, CreateApiPointData $data): Point
    {
        $pointEntity = new Point();

        $pointEntity->setName($data->getName());
        $pointEntity->setChecked($data->getChecked());
        $pointEntity->setNote($note);

        $this->entityManager->persist($pointEntity);
        $this->entityManager->flush();

        return $pointEntity;
    }

    /**
     * @param Note $note
     * @param array $data
     * @return void
     */
    private function createPointByArray(Note $note, array $data): void
    {
        $pointEntity = new Point();

        $pointEntity->setName($data['name']);
        $pointEntity->setChecked($data['checked']);
        $pointEntity->setNote($note);

        $this->entityManager->persist($pointEntity);
    }

    /**
     * @param Note $note
     * @param array $rawPoints
     */
    private function updateOrRemovePoints(Note $note, array $rawPoints): void
    {
        $pointsHashTable = [];
        foreach ($rawPoints as $point) {
            $pointsHashTable[$point['id']] = $point;
        }
        $rawPointsIds = array_keys($pointsHashTable);

        $pointEntities = $this->pointRepository->findBy(['note' => $note->getId()]);
        $pointEntitiesIds = array_map(function (Point $point){
            return $point->getId();
        }, $pointEntities);

        $toRemovePointsIds = array_diff($pointEntitiesIds, $rawPointsIds);
        $toUpdatePointsIds = array_intersect($rawPointsIds, $pointEntitiesIds);

        foreach ($this->pointRepository->findBy(['id' => $toRemovePointsIds]) as $pointEntity)
        {
            $this->entityManager->remove($pointEntity);
        }

        foreach ($this->pointRepository->findBy(['id' => $toUpdatePointsIds]) as $pointEntity)
        {
            $pointEntity->setName($pointsHashTable[$pointEntity->getId()]['name']);
            $pointEntity->setChecked($pointsHashTable[$pointEntity->getId()]['checked']);

            $this->entityManager->persist($pointEntity);
        }
    }
}