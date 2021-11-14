<?php

namespace common\models\services;

use common\models\Employee;
use common\models\repositories\DepartmentRepository;
use common\models\repositories\Employee2DepartmentRepository;
use common\models\repositories\EmployeeRepository;
use yii\web\NotFoundHttpException;

class EmployeeService
{
    private EmployeeRepository $employeeRepository;
    private DepartmentRepository $departmentRepository;
    private Employee2DepartmentRepository $employee2DepartmentRepository;

    /**
     * @param EmployeeRepository $employeeRepository
     * @param DepartmentRepository $departmentRepository
     * @param Employee2DepartmentRepository $employee2DepartmentRepository
     */
    public function __construct(
        EmployeeRepository $employeeRepository,
        DepartmentRepository $departmentRepository,
        Employee2DepartmentRepository $employee2DepartmentRepository
    ) {
        $this->employeeRepository = $employeeRepository;
        $this->departmentRepository = $departmentRepository;
        $this->employee2DepartmentRepository = $employee2DepartmentRepository;
    }

    /**
     * @param int $id
     * @return EmployeeDto
     */
    public function getById(int $id): EmployeeDto
    {
        $departmentList = $this->departmentRepository->getListByEmployeeId($id);
        $employee = $this->employeeRepository->findById($id);

        if ($employee === null) {
            throw new NotFoundHttpException('Не удалось найти сотрудника.');
        }

        return new EmployeeDto(
          $employee->firstName,
          $employee->lastName,
          $employee->email,
          $employee->education,
          $employee->post,
          $employee->age,
          $employee->nationality,
          $departmentList,
          $employee->id
        );
    }

    /** @return Employee[] */
    public function getList(EmployeeFilterDto $filterDto): array
    {
        return $this->employeeRepository->getList($filterDto);
    }

    public function delete(int $employeeId): void
    {
        $this->employeeRepository->delete($employeeId);
    }

    public function save(EmployeeDto $employeeDto, array $departmentIdList, int $employeeId): void
    {
        $this->employeeRepository->update($employeeId, $employeeDto);
        $this->employee2DepartmentRepository->update($employeeId, $departmentIdList);
    }
}