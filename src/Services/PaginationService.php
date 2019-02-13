<?php
namespace App\Services;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Created by PhpStorm.
 * User: Administrateur
 * Date: 13/02/2019
 * Time: 12:47
 */

class PaginationService
{
    private $entityClass;
    private $limite = 5;
    private $manager;
    private $nbDePages;

    /**
     * PaginationService constructor.
     * @param ObjectManager $manager
     */
    public function __construct(ObjectManager $manager)
    {
        $this->manager = $manager;
    }

    public function getData($page){
        // calcul de l'offset
        $offset = $page * $this->limite - $this->limite;
        $repo = $this->manager->getRepository($this->entityClass);
        $data = $repo->findBy([],[],$this->limite,$offset);
        return $data;
    }

    /**
     * @return mixed
     */
    public function getEntityClass()
    {
        return $this->entityClass;
    }

    /**
     * @param mixed $entityClass
     */
    public function setEntityClass($entityClass): void
    {
        $this->entityClass = $entityClass;
    }

    /**
     * @return int
     */
    public function getLimite(): int
    {
        return $this->limite;
    }

    /**
     * @param int $limite
     */
    public function setLimite(int $limite): void
    {
        $this->limite = $limite;
    }

    /**
     * @return mixed
     */
    public function getNbDePages()
    {
        $repo = $this->manager->getRepository($this->entityClass);
        $this->nbDePages = ceil(count($repo->findAll())/$this->limite);
        return $this->nbDePages;
    }




}