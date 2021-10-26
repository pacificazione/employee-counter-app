<?php

namespace common\models\repositories;

use common\models\Department;
use common\models\Employee2Department;
use Exception;
use RuntimeException;

class DepartmentRepository
{
    /**
     * @return Department[]
     */
    public function getList(): array
    {
        return Department::find()->all();
    }

    public function getListByEmployeeId(int $id): array
    {
        $query = Department::find()->alias('d')
            ->innerJoin(Employee2Department::tableName() . ' e2d', 'e2d.department_id = d.id')
            ->andWhere(['e2d.employee_id' => $id]);

        return $query->all();
    }

    /**
     * @throws Exception
     */
    public function delete(int $departmentId): void
    {
        $model = Department::findOne(['id' => $departmentId])
            ->delete();

    }
}