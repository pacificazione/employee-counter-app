<?php

namespace common\tests\unit\employeeService;

use Codeception\Test\Unit;
use common\models\repositories\DepartmentRepository;
use common\models\repositories\EmployeeRepository;
use common\models\services\EmployeeFilterDto;
use common\models\services\EmployeeService;
use common\tests\UnitTester;

class GetListTest extends Unit
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

        $this->tester->haveFixtures([
            'common\tests\fixtures\DepartmentFixture',
            'common\tests\fixtures\EmployeeFixture',
            'common\tests\fixtures\Employee2DepartmentFixture',
        ]);
    }

    public function testGetListSuccess(): void
    {
        $employeeList = $this->service->getList(new EmployeeFilterDto());
        static::assertCount(6, $employeeList);
    }

    public function testGetListByDepartmentIdSuccess(): void
    {
        $employeeList = $this->service->getList(new EmployeeFilterDto(1));
        static::assertCount(3, $employeeList);
    }

    public function testGetEmptyListSuccess(): void
    {
        $employeeList = $this->service->getList(new EmployeeFilterDto(100));
        static::assertCount(0, $employeeList);
    }
}