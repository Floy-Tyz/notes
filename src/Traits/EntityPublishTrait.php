<?php declare(strict_types=1);

namespace App\Traits;

use Doctrine\ORM\Mapping as ORM;

trait EntityPublishTrait
{
    /**
     * @ORM\Column(type="boolean", nullable=false)
     */
    #[ORM\Column(type: 'boolean', nullable: false)]
    private bool $publish = true;

    /**
     * @return bool
     */
    public function getPublish(): bool
    {
        return $this->publish;
    }

    /**
     * @param bool|null $publish
     */
    public function setPublish(?bool $publish)
    {
        $this->publish = (bool) $publish;
    }
}