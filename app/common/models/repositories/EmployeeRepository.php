<?php

namespace common\models\repositories;

use common\models\Employee;
use common\models\Employee2Department;
use common\models\services\EmployeeDto;
use common\models\services\EmployeeFilterDto;
use common\models\services\SignUpDto;
use RuntimeException;
use Yii;
use yii\base\Exception;

class EmployeeRepository
{
    /**
     * @param string $email
     * @return Employee|null
     */
    public function findByEmail(string $email): ?Employee
    {
        return Employee::findOne(['email' => $email, 'status' => Employee::STATUS_ACTIVE]);
    }

    /**
     * @param SignUpDto $signUpDto
     * @return int
     * @throws RuntimeException|Exception
     */
    public function create(SignUpDto $signUpDto): int
    {
        $employee = new Employee();

        $employee->firstName = $signUpDto->getFirstName();
        $employee->lastName = $signUpDto->getLastName();
        $employee->education = $signUpDto->getEducation();
        $employee->post = $signUpDto->getPost();
        $employee->age = $signUpDto->getAge();
        $employee->nationality = $signUpDto->getNationality();
        $employee->email = $signUpDto->getEmail();
        $employee->password_hash = Yii::$app->security->generatePasswordHash($signUpDto->getPassword());
        $employee->auth_key = Yii::$app->security->generateRandomString(32);

        if (!$employee->save()) {
            throw new RuntimeException('Не удалось создать сотрудника.');
        }

        return $employee->id;
    }

    /**
     * @param int $id
     * @return Employee|null
     */
    public function findById(int $id): ?Employee
    {
        return Employee::find()
            ->andWhere(['id' => $id])
            ->one();
    }

    /** @return Employee[] */
    public function getList(EmployeeFilterDto $filterDto): array
    {
        $query = Employee::find()->alias('e');

        if ($filterDto->getDepartmentId() !== null && $filterDto->getDepartmentId() !== 0) {
            $query->innerJoin(Employee2Department::tableName() . ' e2d', 'e2d.employee_id = e.id');
            $query->andWhere(['e2d.department_id' => $filterDto->getDepartmentId()]);
        }

        return $query->all();
    }

    /**
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function delete(int $employeeId): void
    {
        $model = $this->findById($employeeId);
        $model->delete();
    }

    public function findByDepartmentIdAndEmail(int $departmentId, string $email): ?Employee
    {
        $query = Employee::find()->alias('e')
            ->andWhere(['e.email' => $email])
            ->innerJoin(Employee2Department::tableName() . ' e2d', 'e2d.employee_id = e.id')
            ->andWhere(['e2d.department_id' => $departmentId]);

        return $query->one();
    }

    public function update(int $id, EmployeeDto $employeeDto)
    {
        $employee = $this->findById($id);

        $employee->firstName = $employeeDto->getFirstName();
        $employee->lastName = $employeeDto->getLastName();
        $employee->education = $employeeDto->getEducation();
        $employee->post = $employeeDto->getPost();
        $employee->age = $employeeDto->getAge();
        $employee->nationality = $employeeDto->getNationality();
        $employee->email = $employeeDto->getEmail();

        if (!$employee->save()) {
            throw new RuntimeException('Не удалось сохранить сотрудника.');
        }

        return $employee->id;
    }
}