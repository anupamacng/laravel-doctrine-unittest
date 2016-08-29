<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class DepartmentTest extends TestCase
{

	public function testGetDepartmentListStatusCode(){

		$response = $this->call('GET', '/api/v1/department');
             $this->assertEquals(200, $response->status());
	}

	public function testGetDepartmentListStatus(){

		$response = $this->call('GET', '/api/v1/department');
             $this->assertResponseOk();
	}

	public function testGetDepartmentListType(){

		 $this->json('GET', '/api/v1/department')
            ->seeJsonStructure(['*' => [
            'lev1',
		      'lev2',
		     "lev3",
	         "lev4",
                 ]
             ]);
	}
}
