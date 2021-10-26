<?php

namespace common\tests\unit\employeeService;

use Codeception\Test\Unit;
use common\models\repositories\DepartmentRepository;
use common\models\repositories\EmployeeRepository;
use common\models\services\EmployeeService;
use common\tests\UnitTester;

class GetByIdTest extends Unit
{
    /**
     * @var UnitTester
     */
    protected $tester;

    private EmployeeService $service;

    protected function _before()
    {
        $this->service = new EmployeeService(
            new EmployeeRepository(),
            new DepartmentRepository()
        );
    }

    public function testGetByIdSuccess(): void
    {
        $this->tester->haveFixtures([
            'common\tests\fixtures\DepartmentFixture',
            'common\tests\fixtures\EmployeeFixture',
            'common\tests\fixtures\Employee2DepartmentFixture',
        ]);

        $employee = $this->service->getById(1);
        $employeeModel = $this->tester->grabFixture('common\tests\fixtures\EmployeeFixture', 'employee1');

        static::assertEquals($employeeModel->id, $employee->getEmployeeId());
        static::assertEquals($employeeModel->firstName, $employee->getFirstName());
        static::assertEquals($employeeModel->lastName, $employee->getLastName());
        static::assertEquals($employeeModel->education, $employee->getEmail());
        static::assertEquals($employeeModel->post, $employee->getPost());
        static::assertEquals($employeeModel->age, $employee->getAge());
        static::assertEquals($employeeModel->nationality, $employee->getNationality());
        static::assertEquals($employeeModel->email, $employee->getEmail());
        static::assertCount(1, $employee->getDepartmentList());
    }
}