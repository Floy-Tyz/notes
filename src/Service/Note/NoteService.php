<?php

namespace App\Service\Note;

use App\AbstractEntity\BaseAbstractService;
use App\Entity\Note;
use App\Entity\Point;
use App\Repository\NoteRepository;
use App\Repository\PointRepository;
use App\Service\Note\DataTransferObject\CreateUpdateApiNoteDto;
use App\Service\Point\DataTransferObject\CreateUpdateApiPointDto;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\String\Slugger\SluggerInterface;

class NoteService extends BaseAbstractService
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
     * @param CreateUpdateApiNoteDto $dto
     * @return void
     */
    public function createOrUpdateNote(Note $note, CreateUpdateApiNoteDto $dto): void
    {
        $note->setName($dto->getName());
        $note->setSlug($this->slugger->slug(mb_strtolower($dto->getName())));
        $note->setPoints($this->createOrUpdatePoints($note, $dto->getPoints()));

        $this->entityManager->persist($note);
        $this->entityManager->flush();
    }

    /**
     * @param Note $note
     * @param array $rawPoints
     * @return Collection
     */
    public function createOrUpdatePoints(Note $note, array $rawPoints): Collection
    {
        $pointsHashTable = [];

        foreach ($rawPoints as $point) {
            $pointsHashTable[$point['id']] = $point;
        }

        $pointsIds = array_keys($pointsHashTable);

        foreach ($this->pointRepository->findBy(['id' => $pointsIds]) as $pointEntity)
        {
            $pointEntity->setName($pointsHashTable[$pointEntity->getId()]['name']);

            $this->entityManager->persist($pointEntity);

            unset($pointsHashTable[$pointEntity->getId()]);
        }

        foreach ($pointsHashTable as $point)
        {
            $pointEntity = new Point();

            $pointEntity->setName($point['name']);
            $pointEntity->setChecked(false);
            $pointEntity->setNote($note);

            $this->entityManager->persist($pointEntity);
        }

        $this->entityManager->flush();

        return $note->getPoints();
    }
}