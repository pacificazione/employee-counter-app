<?php

namespace common\models\query;

use common\models\Employee2Department;
use yii\db\ActiveQuery;

/**
 * Query-модель сотрудник2отдел.
 *
 * @see \common\models\Employee2Department
 */
class Employee2DepartmentQuery extends ActiveQuery
{
    /**
     * {@inheritdoc}
     * @return Employee2Department[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Employee2Department|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
