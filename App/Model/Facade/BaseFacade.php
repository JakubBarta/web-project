<?php
/**
 * Author: Jakub Barta <jakub.barta@gmail.com>
 * Date: 19.09.15
 * Time: 19:40
 */

namespace App\Model\Facade;

use App\Model\Entity\BaseEntity;
use App\Model\Exception\EntityNotFoundException;
use App\Model\Exception\ModelException;
use Kdyby\Doctrine\EntityDao;
use Nette\Object;
use Rhumsaa\Uuid\Uuid;

abstract class BaseFacade extends Object
{
    /** @var EntityDao */
    protected $dao;

    function __construct(EntityDao $dao)
    {
        $this->dao = $dao;
    }

    /**
     * @param BaseEntity $entity
     * @throws ModelException
     */
    public function create(BaseEntity $entity)
    {
        $em = $this->dao->getEntityManager();
        $em->beginTransaction();

        try {
            $this->doCreate($entity);
            $em->flush();
            $em->commit();
        } catch (\Exception $e) {
            $em->rollback();
            throw new ModelException($e->getMessage(), $e->getCode(), $e);
        }

    }

    protected function doCreate(BaseEntity $entity)
    {
        $this->dao->getEntityManager()->persist($entity);
    }

    /**
     * @param BaseEntity|string $entity
     * @throws ModelException
     */
    public function delete($entity)
    {
        if (!is_object($entity)) {
            $entity = $this->get($entity);
        }
        $em = $this->dao->getEntityManager();
        $em->beginTransaction();

        try {
            $this->doDelete($entity);
            $em->flush();
            $em->commit();
        } catch (\Exception $e) {
            $em->rollback();
            throw new ModelException($e->getMessage(), $e->getCode(), $e);
        }

    }

    /**
     * @param BaseEntity $entity
     */
    protected function doDelete(BaseEntity $entity)
    {
        $this->dao->getEntityManager()->remove($entity);
    }

    /**
     * @param string $id
     * @return BaseEntity
     * @throws EntityNotFoundException
     */
    public function get($id)
    {
        $entity = $this->dao->find($id);

        if ($entity === null) {
            throw new EntityNotFoundException("Entity ID: " . $id . " not found");
        }

        return $entity;
    }

    /**
     * @param $orderBy array
     * @return array
     */
    public function getAll(array $orderBy = null)
    {
        return $this->dao->findBy([], $orderBy);
    }

    /**
     * @param BaseEntity $entity
     * @throws ModelException
     */
    public function save(BaseEntity $entity)
    {
        $em = $this->dao->getEntityManager();

        $em->beginTransaction();

        try {
            $em->flush();
            $em->commit();
        } catch (\Exception $e) {
            $em->rollback();
            throw new ModelException($e->getMessage(), $e->getCode(), $e);
        }

    }
}