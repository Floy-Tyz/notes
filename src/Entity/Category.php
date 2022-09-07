<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use App\Serializer\Attributes\Relation;
use App\Service\Category\Normalizer\CategoryNormalizerBuilder;
use App\Traits\EntityTimestampableTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\MaxDepth;
use Symfony\Component\Serializer\Annotation\SerializedName;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
#[ORM\Table(name: "categories")]
#[Relation(builder: CategoryNormalizerBuilder::class)]
class Category
{
    use EntityTimestampableTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    #[Groups(['api'])]
    private int $id;

    #[ORM\Column(length: 100)]
    #[Groups(['api'])]
    private string $name;

    #[ORM\Column(type: "string", length: 100)]
    #[Groups(['api'])]
    private string $slug;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $path;

    #[ORM\ManyToOne(targetEntity: "Category", inversedBy: "children")]
    #[ORM\JoinColumn(name: "parent_id", onDelete: "CASCADE")]
    #[Groups(['api'])]
    private ?Category $parent = null;

    #[ORM\OneToMany(mappedBy: "parent", targetEntity: "Category")]
    private Collection $children;

    #[ORM\Column(type: "text", nullable: true)]
    private ?string $description;

    #[ORM\Column(type: "boolean")]
    private int $popular = 0;

    #[ORM\OneToMany(mappedBy: 'category', targetEntity: Article::class)]
    private Collection $articles;

    public function __construct()
    {
        $this->children = new ArrayCollection();
        $this->articles = new ArrayCollection();
    }

    /**
     * @return array|null
     */
//    #[Groups(['api'])]
//    #[SerializedName('parent')]
    public function getParentGroup(): array|null
    {
        if ($this->parent){
            return [
                'id' => $this->parent->getId(),
                'name' => $this->parent->getName(),
            ];
        }
        return null;
    }

    #[Groups(['api'])]
    #[SerializedName('has_children')]
    public function hasChildrenGroup(): bool
    {
        return count($this->children) > 0;
    }

//    #[Groups(['api'])]
//    #[SerializedName('path')]
//    public function getPathGroup(): array
//    {
//        return array_slice(explode('/', $this->getPath()), 1, -1);
//    }

    #[Groups(['api'])]
    #[SerializedName('articles_count')]
    public function getArticlesCountGroup(): int
    {
        return count($this->articles);
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection<Category>
     */
    public function getChildren(): Collection
    {
        return $this->children;
    }

    public function addChild(Category $child): self
    {
        if (!$this->children->contains($child)) {
            $this->children[] = $child;
            $child->setParent($this);
        }

        return $this;
    }

    public function removeChild(Category $child): self
    {
        if ($this->children->removeElement($child)) {
            // set the owning side to null (unless already changed)
            if ($child->getParent() === $this) {
                $child->setParent(null);
            }
        }

        return $this;
    }

    /**
     * @return Category|null
     */
    public function getParent(): ?Category
    {
        return $this->parent;
    }

    /**
     * @param Category|null $parent
     */
    public function setParent(?Category $parent): void
    {
        $this->parent = $parent;
    }

    public function getPopular(): ?bool
    {
        return $this->popular;
    }

    public function setPopular(bool $popular): self
    {
        $this->popular = $popular;

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

    public function getPath(): ?string
    {
        return $this->path;
    }

    public function setPath(?string $path): self
    {
        $this->path = $path;

        return $this;
    }

    /**
     * @return Collection<int, Article>
     */
    public function getArticles(): Collection
    {
        return $this->articles;
    }

    public function addArticle(Article $article): self
    {
        if (!$this->articles->contains($article)) {
            $this->articles[] = $article;
            $article->setCategory($this);
        }

        return $this;
    }

    public function removeArticle(Article $article): self
    {
        if ($this->articles->removeElement($article)) {
            // set the owning side to null (unless already changed)
            if ($article->getCategory() === $this) {
                $article->setCategory(null);
            }
        }

        return $this;
    }

}
