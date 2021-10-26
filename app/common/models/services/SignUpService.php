<?php

namespace common\models\services;

use common\models\repositories\Employee2DepartmentRepository;
use common\models\repositories\EmployeeRepository;

class SignUpService
{
    private EmployeeRepository $employeeRepository;
    private Employee2DepartmentRepository $employee2DepartmentRepository;

    /**
     * @param EmployeeRepository $employeeRepository
     * @param Employee2DepartmentRepository $employee2DepartmentRepository
     */
    public function __construct(EmployeeRepository $employeeRepository, Employee2DepartmentRepository $employee2DepartmentRepository)
    {
        $this->employeeRepository = $employeeRepository;
        $this->employee2DepartmentRepository = $employee2DepartmentRepository;
    }

    public function signUp(SignUpDto $signUpDto, int $departmentId): void
    {
        $employeeId = $this->employeeRepository->create($signUpDto);
        $this->employee2DepartmentRepository->create($employeeId, $departmentId);
    }
}