<?php

namespace common\models\services;

/**
 * Dto регистрации сотрудника.
 */
class SignUpDto
{
    private string $firstName;
    private string $lastName;
    private string $education;
    private string $post;
    private int $age;
    private string $nationality;
    private string $email;
    private string $password;
    private int $departmentId;

    public function __construct(
        string $firstName,
        string $lastName,
        string $education,
        string $post,
        int    $age,
        string $nationality,
        string $email,
        string $password,
        int    $departmentId
    ) {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->education = $education;
        $this->post = $post;
        $this->age = $age;
        $this->nationality = $nationality;
        $this->email = $email;
        $this->password = $password;
        $this->departmentId = $departmentId;
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
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @return int
     */
    public function getDepartmentId(): int
    {
        return $this->departmentId;
    }
}