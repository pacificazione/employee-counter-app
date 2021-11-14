<?php

namespace common\models\services;

use common\models\Department;

class EmployeeDto
{
    private string $firstName;
    private string $lastName;
    private string $email;
    private string $education;
    private string $post;
    private int $age;
    private string $nationality;
    /**
     * @var Department[]
     */
    private array  $departmentList;
    private ?int $employeeId;

    /**
     * @param Department[] $departmentList
     */
    public function __construct(
        string $firstName,
        string $lastName,
        string $email,
        string $education,
        string $post,
        int $age,
        string $nationality,
        array $departmentList = [],
        ?int $employeeId = null
    ) {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->email = $email;
        $this->education = $education;
        $this->post = $post;
        $this->age = $age;
        $this->nationality = $nationality;
        $this->departmentList = $departmentList;
        $this->employeeId = $employeeId;
    }

    /**
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->firstName;
    }

    /**
     * @return string
     */
    public function getLastName(): string
    {
        return $this->lastName;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getEducation(): string
    {
        return $this->education;
    }

    /**
     * @return string
     */
    public function getPost(): string
    {
        return $this->post;
    }

    /**
     * @return int
     */
    public function getAge(): int
    {
        return $this->age;
    }

    /**
     * @return string
     */
    public function getNationality(): string
    {
        return $this->nationality;
    }

    /**
     * @return Department[]
     */
    public function getDepartmentList(): array
    {
        return $this->departmentList;
    }

    /**
     * @return int
     */
    public function getEmployeeId(): int
    {
        return $this->employeeId;
    }
}