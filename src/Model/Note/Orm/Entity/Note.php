<?php

namespace App\Model\Note\Orm\Entity;

use App\Model\Note\Orm\Repository\NoteRepository;
use App\Traits\EntityTimestampableTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: NoteRepository::class)]
#[ORM\Table(name: "categories")]
class Note
{
    use EntityTimestampableTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    #[Groups(['api'])]
    private int $id;

    #[ORM\Column(type: 'string', length: 100)]
    #[Groups(['api'])]
    private string $name;

    #[ORM\Column(type: 'string', length: 100)]
    #[Groups(['api'])]
    private string $slug;

    #[Groups(['list'])]
    #[ORM\OneToMany(mappedBy: 'note', targetEntity: Point::class)]
    private Collection $points;

    public function __construct()
    {
        $this->points = new ArrayCollection();
    }

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

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * @return array
     */
    public function urlParameters(): array
    {
        return [
            'slug' => $this->getSlug(),
            'id' => $this->getId()
        ];
    }

    /**
     * @return Collection<int, Point>
     */
    public function getPoints(): Collection
    {
        return $this->points;
    }

    /**
     * @param Collection $points
     */
    public function setPoints(Collection $points): void
    {
        $this->points = $points;
    }

    public function addPoint(Point $point): self
    {
        if (!$this->points->contains($point)) {
            $this->points[] = $point;
            $point->setNote($this);
        }

        return $this;
    }

    public function removePoint(Point $point): self
    {
        $this->points->removeElement($point);

        return $this;
    }

}
