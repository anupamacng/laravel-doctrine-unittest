<?php
namespace App\Entity;

use Doctrine\ORM\Mapping AS ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="employees")
 */
class Employee
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\Column(type="integer")
     */
    protected $departments_id;

    /**
     * @ORM\Column(type="string")
     */
    protected $emp_name;

    /**
    *
    */
    public function __construct()
    {

    }
/**
    * @param $id
    */
    public function getId()
    {
        return $this->id;
    }

/**
    * @param $emp_name
    */
    public function getEmployeeName()
    {
        return $this->emp_name;
    }

/**
    * @param $emp_name
    */
    public function setEmployeeName($name)
    {
        $this->emp_name = $name;
    }

    /**
    * @param $departments_id
    */
    public function setEmployeeDepartment($dep_id)
    {
        $this->departments_id = $dep_id;
    }


     /**
    * @param $emp_name
    */
    public function setEmployee(Employee $employee)
    {
        $this->employee = $employee;
    }

}
