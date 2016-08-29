<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Entity;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use \App\Entity\Employee;
use \App\Entity\Department;
use Illuminate\Support\Facades\Validator;

class EmployeeController extends Controller
{
    /**
    *EntyityManager
    */
    protected $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
        $this->employees = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try{
                $statusCode = 400;
                $response = [
                        'message' => 'Invalid parameter values.'
                    ];
            if ($this->validateStoreEmployee($request)) {
                if ($this ->insertEmployee($request)>0){
                    $statusCode = 200;
                    $response = [
                        'message' => 'Employee is created.'
                    ];
                }
            }
        }catch (Exception $exception) {
            $statusCode = 404;
            $response = [
                    'message' => 'Error with creating Employee.'
                ];
            Log::error($exception->getMessage());
        }finally {
            return response()->json(['data' => $response,
                'state' => $statusCode]);
        }
    }

    /**
     * Get Employee by department
     *
     * @param  int  $depatments_id
     * @return \Illuminate\Http\Response
     */
    public function getEmployeeByDepartment($depatments_id){
        try{
                $statusCode = 400;
                $response = [
                        'message' => 'Invalid parameter values.'
                    ];
            if ($this->validateDepartmentId($depatments_id)) {
                $statusCode = 200;
                $employees = $this->getEmployees($depatments_id);
                $response = [
                    'message' => 'Employee List',
                    'employees' => $employees
                ];
            }
        }catch (Exception $exception){
            $statusCode = 404;
            $response = [
                    'message' => 'Error with creating Employee.'
                ];
            Log::error($exception->getMessage());
        }finally {
            return response()->json(['data' => $response,
                'state' => $statusCode]);
        }
    }

    /**
     * Validate inputs for store Employee
     *
     * @param  Request object
     * @return boolean
     */
    private function validateStoreEmployee($request){
        $v = Validator::make($request->all(), [
            'emp_name' => 'required',
            'dep_id' => 'required|integer',
        ]);
        if ($v->fails()){
            return false;
        }
        return true;
    }

     /**
     * Validate inputs for store Employee
     *
     * @param  integer
     * @return boolean
     */
    private function validateDepartmentId($dep_id){
        return true;
    }

    /**
     * query departments hierarchical manner
     *
     * @param int
     * @return  array
     */
    private function getEmployees($depatments_id)
    {
        $sql = "SELECT * FROM `employees`
                    WHERE
                    departments_id = :dep_id OR
                    departments_id
                    IN
                    (
                        SELECT id FROM departments
                        WHERE
                        parent_department_id = :dep_id
                    )";
        $find_by = array('departments_id' => $depatments_id);
        $params = array('dep_id'=>$depatments_id);
        $stmt = $this->em->getConnection()->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    /**
     * store new department
     *
     * @param Request
     * @return int
     */
    private function insertEmployee($request)
    {
        $employee =  new Employee();
        $employee->setEmployeeName($request->get('emp_name'));
        $employee->setEmployeeDepartment($request->get('dep_id'));
        $this->em->persist($employee);
        $this->em->flush();
        return $employee->getId();
    }

}

