<?php

namespace common\tests\unit\employeeService;

use Codeception\Test\Unit;
use common\models\Employee;
use common\models\repositories\DepartmentRepository;
use common\models\repositories\EmployeeRepository;
use common\models\services\EmployeeService;
use common\tests\UnitTester;
use yii\web\NotFoundHttpException;

class DeleteTest extends Unit
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
            new DepartmentRepository(),
        );
    }

    public function testDeleteSuccess(): void
    {
        $this->tester->haveFixtures([
            'common\tests\fixtures\DepartmentFixture',
            'common\tests\fixtures\EmployeeFixture',
            'common\tests\fixtures\Employee2DepartmentFixture',
        ]);

        $this->service->delete(1);
        $this->tester->seeRecord(Employee::class, [
            'id' => 1,
        ]);
    }

    public function testDeleteNotFoundFail(): void
    {
        static::expectException(NotFoundHttpException::class);
        $this->service->delete(1);
    }
}