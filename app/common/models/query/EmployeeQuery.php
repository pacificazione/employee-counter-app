<?php

namespace common\models\query;

use common\models\Employee;
use yii\db\ActiveQuery;

/**
 * Query-модель сотрудника.
 *
 * @see \common\models\Employee
 */
class EmployeeQuery extends ActiveQuery
{
    /**
     * {@inheritdoc}
     * @return Employee[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Employee|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
