<?php

namespace common\tests\unit\departmentService;

use Codeception\Test\Unit;
use common\models\Employee2Department;
use common\models\repositories\DepartmentRepository;
use common\models\repositories\Employee2DepartmentRepository;
use common\models\repositories\EmployeeRepository;
use common\models\services\DepartmentService;
use Exception;

class AddEmployeeTest extends Unit
{
    /**
     * @var \common\tests\UnitTester
     */
    protected $tester;

    private DepartmentService $service;

    protected function _before()
    {
        $this->service = new DepartmentService(
           new DepartmentRepository(),
           new Employee2DepartmentRepository(),
           new EmployeeRepository()
        );
    }

    public function testAddSuccess(): void
    {
        $this->tester->haveFixtures([
            'common\tests\fixtures\DepartmentFixture',
            'common\tests\fixtures\EmployeeFixture',
            'common\tests\fixtures\Employee2DepartmentFixture',
        ]);

        $this->service->addEmployee(2, 2);

        $this->tester->seeRecord(Employee2Department::class, [
            'department_id' => 2,
            'employee_id' => 2,
        ]);

        $this->tester->seeRecord(Employee2Department::class, [
            'department_id' => 1,
            'employee_id' => 2,
        ]);
    }

    public function testAddNotFoundFail(): void
    {
        static::expectException(Exception::class);
        $this->service->addEmployee(2, 2);
    }
}
