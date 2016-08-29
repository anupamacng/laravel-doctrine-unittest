<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Entity\Department;
use Doctrine\ORM\Query\ResultSetMapping;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Illuminate\Support\Facades\Validator;

class DepartmentController extends Controller
{
    /**
    *EntyityManager
    */
    protected $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
                $statusCode = 200;
                $departmentArray =$this->getDepartmentHierachy();
                $response = [
                    'message' => 'Department List.',
                    'departments_hierarchy' => $departmentArray,
                ];
        }catch (Exception $exception) {
            $statusCode = 404;
            $response = [
                    'message' => 'Error Listing departments',
                    ];
            Log::error($exception->getMessage());
        }finally {
            return response()->json(['data' => $response, 'state' => $statusCode]);
        }
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
            if ($this->validateStoreDepartment($request)) {

                if ($this ->insertDepartment($request)>0){
                    $statusCode = 200;
                    $response = [
                        'message' => 'Department is created.'
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
            return response()->json(['data' => $response, 'state' => $statusCode]);
        }
    }

     /**
     * Validate inputs for store Departments
     *
     * @param  Request object
     * @return boolean
     */
    private function validateStoreDepartment($request){
        $v = Validator::make($request->all(), [
            'department_name' => 'required',
            'parent_id' => 'required',
        ]);

        if ($v->fails()){
            return false;
        }
        return true;
    }

    /**
     * query departments hierarchical manner
     *
     * @param
     * @return result array
     */
    private function getDepartmentHierachy()
    {
        $dept = $this->em ->getRepository(Department::class)->findAll();
        $sql = "SELECT
            t1.dep_name AS lev1,
            t2.dep_name as lev2,
            t3.dep_name as lev3,
            t4.dep_name as lev4
            FROM departments AS t1
            LEFT JOIN departments AS t2 ON t2.`parent_department_id` = t1.id
            LEFT JOIN departments AS t3 ON t3.`parent_department_id` = t2.id
            LEFT JOIN departments AS t4 ON t4.`parent_department_id` = t3.id
            ORDER BY `lev1` DESC";
            $stmt = $this->em->getConnection()->prepare($sql);
            $stmt->execute();
            return  $stmt->fetchAll();
    }

    /**
     * store new department
     *
     * @param Request
     * @return int
     */
    private function insertDepartment($request)
    {
        $dept =  new Department();
        $dept->setDepartmentName($request->get('department_name'));
        $dept->setParentDepartment($request->get('parent_id'));
        $this->em ->persist($dept);
        $this->em ->flush();
        return $dept->getId();
    }

}

