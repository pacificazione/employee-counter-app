<?php

namespace common\models\query;

use common\models\Department;
use yii\db\ActiveQuery;

/**
 * Query-модель отдела.
 *
 * @see \common\models\Department
 */
class DepartmentQuery extends ActiveQuery
{
    /**
     * {@inheritdoc}
     * @return Department[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Department|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
