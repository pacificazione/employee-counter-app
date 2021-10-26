<?php

namespace common\models\services;

class EmployeeFilterDto
{
    private ?int $departmentId;

    public function __construct(?int $departmentId = null)
    {
        $this->departmentId = $departmentId;
    }

    public function getDepartmentId(): ?int
    {
        return $this->departmentId;
    }
}
