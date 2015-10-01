<?php
/**
 * Author: Jakub Barta <jakub.barta@gmail.com>
 * Date: 19.09.15
 * Time: 16:43
 */

namespace App\Model\Entity;


use App\Model\Entity\Attribute\Identifier;
use Doctrine\ORM\Mapping as ORM;
use Nette\Reflection\ClassType;

/**
 * Class BaseEntity
 * @package App\Model\Entity
 * @ORM\MappedSuperclass()
 */
abstract class BaseEntity extends \Kdyby\Doctrine\Entities\BaseEntity
{
    use Identifier {
        Identifier::init as identifierInit;
    }

    public function __construct()
    {
        parent::__construct();
        $this->identifierInit();
    }

    public function setValues($values)
    {
        $values = (array) $values;

        $refl = new ClassType($this->getClassName());

        foreach ($values as $key => $value) {
            if ($refl->hasProperty($key)) {
                $setterName = 'set' . ucfirst($key);
                if ($refl->hasMethod($setterName)) {
                    $this->$setterName($value);
                } else {
                    $this->$key = $value;
                }
            }
        }
    }
}