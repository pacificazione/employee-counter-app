<?php

namespace common\models\repositories;

use common\models\Employee2Department;
use Exception;
use RuntimeException;
use Yii;

class Employee2DepartmentRepository
{
    /**
     * @param int $employeeId
     * @param int $departmentId
     */
    public function create(int $employeeId, int $departmentId): void
    {
        $employee2department = new Employee2Department();

        $employee2department->employee_id = $employeeId;
        $employee2department->department_id = $departmentId;

        if (!$employee2department->save()) {
            throw new RuntimeException('Не удалось создать сотрудника.');
        }
    }

    /**
     * @param int $employeeId
     * @param int[] $departmentIds
     * @return void
     * @throws \yii\db\Exception
     */
    public function add(int $employeeId, array $departmentIds): void
    {
        $transaction = Yii::$app->db->beginTransaction();

        foreach ($departmentIds as $id) {

           $employee2Department = new Employee2Department();

           $employee2Department->department_id = $id;
           $employee2Department->employee_id = $employeeId;

           if (!$employee2Department->save()) {
               $transaction->rollBack();
               throw new RuntimeException('Не удалось добавить сотрудника в отделы.');
           }
        }

        $transaction->commit();
    }


    /**
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function deleteAllEmployeesFromDepartment(int $departmentId): void
    {
        $employee2DepartmentList = Employee2Department::findAll(['department_id' => $departmentId]);

        foreach ($employee2DepartmentList as $e2d) {
            $departmentsCountPerEmployee = Employee2Department::find()
                ->andWhere(['employee_id' => $e2d->employee_id])
                ->count();

            if ($departmentsCountPerEmployee < 2) {
                throw new RuntimeException("Этот сотрудник принадлежит только одному отделу, удаление невозможно");
            }

            $e2d->delete();
        }
    }

    /**
     * @throws Exception
     */
    public function getByDepartmentIdAndEmployeeId(int $departmentId, int $employeeId): Employee2Department
    {
        $model = Employee2Department::findOne([
            'department_id' => $departmentId,
            'employee_id' => $employeeId,
        ]);

        if ($model === null) {
            throw new Exception("Сотрудник/отдел не найден!");
        }

        return $model;
    }

    public function getByDepartmentIdAndEmployeeIdList(int $departmentId, array $employeeIdList): array
    {
        $query = Employee2Department::find()
            ->andWhere(['department_id' => $departmentId])
            ->andWhere(['employee_id' => $employeeIdList]);

        return $query->all();
    }

    /**
     * @throws Exception
     * @throws \Throwable
     */
    public function removeEmployee(int $departmentId, int $employeeId): void
    {
        $model = $this->getByDepartmentIdAndEmployeeId($departmentId, $employeeId);

        $departmentCount = Employee2Department::find()
            ->andWhere(['employee_id' => $employeeId])
            ->count();

        if ($departmentCount < 2) {
            throw new RuntimeException("Не удалось удалить сотрудника, он принадлежит только этому отделу!");
        }

        $model->delete();
    }

    /**
     * @param int $employeeId
     * @return Employee2Department[]
     */
    public function getByEmployeeId(int $employeeId): array
    {
        return Employee2Department::find()
            ->andWhere(['employee_id' => $employeeId])
            ->all();
    }

    public function update(int $employeeId, array $departmentIdList)
    {
        $employee2Department = Employee2Department::find()
            ->andWhere(['employee_id' => $employeeId])
            ->all();

        $departmentCount = count($departmentIdList);

        if ($departmentCount < 1) {
            throw new RuntimeException("Не удалось удалить сотрудника, он принадлежит только этому отделу!");
        }

        foreach ($employee2Department as $e2d) {
            $e2d->delete();
        }

        foreach ($departmentIdList as $departmentId) {
            $employee2Department = new Employee2Department();
            $employee2Department->employee_id = $employeeId;
            $employee2Department->department_id = $departmentId;

            $employee2Department->save();
        }
    }
}