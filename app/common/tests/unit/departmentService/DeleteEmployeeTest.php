<?php

namespace common\tests\unit\departmentService;

use Codeception\Test\Unit;
use common\models\Department;
use common\models\Employee2Department;
use common\models\repositories\DepartmentRepository;
use common\models\repositories\Employee2DepartmentRepository;
use common\models\repositories\EmployeeRepository;
use common\models\services\DepartmentService;

class DeleteTest extends Unit
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

    public function testDeleteSuccess(): void
    {
        $this->tester->haveFixtures([
            'common\tests\fixtures\DepartmentFixture',
            'common\tests\fixtures\EmployeeFixture',
            'common\tests\fixtures\Employee2DepartmentFixture',
        ]);

        for ($i = 1; $i < 4; $i++) {
            $this->tester->haveRecord(Employee2Department::class, [
                'department_id' => 2,
                'employee_id' => $i,
                'created_at' => time(),
                'updated_at' => time(),
            ]);
        }

        $this->service->delete(1);

        $this->tester->seeRecord(Department::class, [
            'id' => 1,
        ]);

        for ($i = 1; $i < 4; $i++) {
            $this->tester->seeRecord(Employee2Department::class, [
                'department_id' => 1,
                'employee_id' => $i,
            ]);
        }
    }

    public function testDeleteEmployeeLeftWithOnlyOneDepartmentFail(): void
    {
        $this->tester->haveFixtures([
            'common\tests\fixtures\DepartmentFixture',
            'common\tests\fixtures\EmployeeFixture',
            'common\tests\fixtures\Employee2DepartmentFixture',
        ]);

        static::expectException(\RuntimeException::class);
        $this->service->delete(1);
    }
}