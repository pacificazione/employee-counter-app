<?php

namespace common\models\services;

use common\models\repositories\DepartmentRepository;
use common\models\repositories\Employee2DepartmentRepository;
use common\models\repositories\EmployeeRepository;
use Exception;

class DepartmentService
{
    private DepartmentRepository $departmentRepository;
    private Employee2DepartmentRepository $employee2DepartmentRepository;
    private EmployeeRepository $employeeRepository;

    /**
     * @param DepartmentRepository $departmentRepository
     * @param Employee2DepartmentRepository $employee2DepartmentRepository
     */
    public function __construct(
        DepartmentRepository $departmentRepository,
        Employee2DepartmentRepository $employee2DepartmentRepository,
        EmployeeRepository $employeeRepository
    ){
        $this->departmentRepository = $departmentRepository;
        $this->employee2DepartmentRepository = $employee2DepartmentRepository;
        $this->employeeRepository = $employeeRepository;
    }


    /**
     * @throws Exception
     */
    public function delete(int $departmentId): void
    {
        $this->employee2DepartmentRepository->deleteAllEmployeesFromDepartment($departmentId);
        $this->departmentRepository->delete($departmentId);
    }

    /**
     * @throws Exception
     */
    public function addEmployee(int $departmentId, int $employeeId): void
    {
        $this->employee2DepartmentRepository->create($employeeId, $departmentId);
    }

    /**
     * @throws Exception
     */
    public function removeEmployee(int $departmentId, int $employeeId): void
    {
        $this->employee2DepartmentRepository->removeEmployee($departmentId, $employeeId);
    }
}