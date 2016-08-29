<?php
namespace App\Entity;

use Doctrine\ORM\Mapping AS ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="departments")
 */
class Department
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\Column(type="string")
     */
    protected $dep_name;


    /**
     * @ORM\Column(type="integer")
     */
    protected $parent_department_id;


    /**
    * @param $dep_name
    */
    public function __construct()
    {
        //$this->dep_name = $dep_name;
        $this->employees = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

/**
    * @param $dep_name
    */
    public function getdepartmentName()
    {
        return $this->dep_name;
    }

/**
    * @param $dep_name
    */
    public function setDepartmentName($name)
    {
        $this->dep_name = $name;
    }

/**
    * @param $parent_department_id
    */
    public function getParentDepartment()
    {
        return $this->dep_name;
    }

/**
    * @param $parent_department_id
    */
    public function setParentDepartment($parent_id)
    {
        $this->parent_department_id = $parent_id;
    }

}
