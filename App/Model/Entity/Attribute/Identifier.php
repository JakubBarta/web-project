<?php
/**
 * Author: Jakub Barta <jakub.barta@gmail.com>
 * Date: 19.09.15
 * Time: 16:52
 */

namespace App\Model\Entity\Attribute;

use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;

/**
 * @property-read string $id
 */
trait Identifier
{
    /**
     * @ORM\Id
     * @ORM\Column(type="guid")
     * @var string
     */
    private $id;

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    private function init()
    {
        $this->id = Uuid::uuid4()->toString();
    }
}
