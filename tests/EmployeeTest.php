<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class EmployeeTest extends TestCase
{
    /**
     * Test list all department
     *
     * @return void
     */
    /** public function testBasicExample()
    {
        $this->get('api/v1/department')
             ->seeJsonStructure([
                 "id" => "1",
	         "dep_name" => "testing",
	         "parent_department_id" => "0",
	         "created_at" => "null",
	         "updated_at" => "null"
            ]);
    } */

	public function testGetEmployeeListStatusCode(){

		$response = $this->call('GET', '/api/v1/employee');
             $this->assertEquals(200, $response->status());
	}

	public function testGetEmployeeListStatus(){

		$response = $this->call('GET', '/api/v1/employee');
             $this->assertResponseOk();
	}

	public function testGetEmployeeListType(){

		 $this->json('GET', '/api/v1/employee')
            ->seeJsonStructure(['*' => [
                     'id',
		     'dep_name',
		     "parent_department_id",
	         "created_at",
	         "updated_at"
                 ]
             ]);
	}
}
