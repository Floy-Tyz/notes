<?php

namespace App\Entity;

use App\Repository\PointRepository;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: PointRepository::class)]
class Point
{
    use TimestampableEntity;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(['api'])]
    private int $id;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(['api'])]
    private string $name;

    #[ORM\Column(type: 'boolean')]
    #[Groups(['api'])]
    private bool $checked;

    #[ORM\ManyToOne(targetEntity: Note::class, inversedBy: 'notes')]
    #[ORM\JoinColumn(name: "note_id", nullable: false, onDelete: "CASCADE")]
    private Note $note;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Note
     */
    public function getNote(): Note
    {
        return $this->note;
    }

    /**
     * @param Note $note
     */
    public function setNote(Note $note): void
    {
        $this->note = $note;
    }

    /**
     * @return bool
     */
    public function isChecked(): bool
    {
        return $this->checked;
    }

    /**
     * @param bool $checked
     */
    public function setChecked(bool $checked): void
    {
        $this->checked = $checked;
    }

    /**
     * @return array
     */
    public function urlParameters(): array
    {
        return [
            'id' => $this->getId()
        ];
    }
}
