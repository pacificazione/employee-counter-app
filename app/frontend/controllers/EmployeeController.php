<?php

namespace frontend\controllers;


use common\models\Employee;
use common\models\EmployeeDepartmentForm;
use common\models\EmployeeFilterForm;
use common\models\repositories\DepartmentRepository;
use common\models\repositories\EmployeeRepository;
use common\models\services\DepartmentService;
use common\models\services\EmployeeFilterDto;
use common\models\services\EmployeeService;
use Exception;
use RuntimeException;
use Yii;
use yii\data\ArrayDataProvider;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\ServerErrorHttpException;

/**
 * Контроллер сотрудника.
 */
class EmployeeController extends Controller
{
    private DepartmentRepository $departmentRepository;
    private EmployeeService $employeeService;
    private DepartmentService $departmentService;
    private EmployeeRepository $employeeRepository;

    /**
     * @param $id
     * @param $module
     * @param EmployeeService $employeeService
     */
    public function __construct(
        $id,
        $module,
        EmployeeService $employeeService,
        DepartmentRepository $departmentRepository,
        EmployeeRepository $employeeRepository,
        DepartmentService $departmentService
    ) {
        parent::__construct($id, $module);
        $this->departmentService = $departmentService;
        $this->employeeService = $employeeService;
        $this->departmentRepository = $departmentRepository;
        $this->employeeRepository = $employeeRepository;
    }

    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::class,
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Employee models.
     * @return mixed
     */
    public function actionIndex()
    {
        $params = Yii::$app->request->queryParams;

        $filterForm = new EmployeeFilterForm();
        $filterForm->load($params);

        $filterDto = new EmployeeFilterDto($filterForm->getDepartmentId());

        $dataProvider = new ArrayDataProvider([
            'allModels' => $this->employeeService->getList($filterDto),
        ]);

        $departmentList = ArrayHelper::map(
            $this->departmentRepository->getList(),
            'id',
            'departmentName'
        );

        return $this->render('index', [
            'filterForm' => $filterForm,
            'dataProvider' => $dataProvider,
            'departmentList' => $departmentList,
        ]);
    }

    /**
     * Добавление сотрудника в отделы.
     *
     * @throws ForbiddenHttpException
     * @throws NotFoundHttpException
     * @throws \Throwable
     */
    public function actionAdd()
    {
        $employeeForm = new EmployeeDepartmentForm();
        $params = Yii::$app->request->post();

        $departmentList = ArrayHelper::map($this->departmentRepository->getList(), 'id', 'departmentName');

        try {
            if ($employeeForm->load($params) && $employeeForm->validate()) {
                $employee = $this->employeeRepository->findByEmail($employeeForm->email);

                if ($employee === null) {
                    $employeeForm->addError('email', 'Сотрудник с указанной почтой не найден.');

                    return $this->render('add', [
                        'departmentList' => $departmentList,
                        'employeeForm' => $employeeForm,
                    ]);
                }

                $this->departmentService->addEmployee2MultipleDepartments($employeeForm->departmentIds, $employee->id);

                return $this->redirect(['employee/view', 'id' => $employee->id]);
            }
        } catch (RuntimeException $exception) {
            $employeeForm->addError('departmentIds', 'Сотрудник уже находится в этом отделе.');
        }

        return $this->render('add', [
            'departmentList' => $departmentList,
            'employeeForm' => $employeeForm,
        ]);
    }
    /**
     * Displays a single Employee model.
     * @param int $id ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView(int $id)
    {
        $employeeDto = $this->employeeService->getById($id);

        return $this->render('view', [
            'model' => $employeeDto,
        ]);
    }

    /**
     * Creates a new Employee model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Employee();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['index', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Employee model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->employeeRepository->findById($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['index', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Employee model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete(int $id)
    {
        $currentEmployee = $this->employeeRepository->findById($id);
        $transaction = Yii::$app->db->beginTransaction();

        try {
            $this->employeeService->delete($currentEmployee->id);
            $transaction->commit();
        } catch (RuntimeException | Exception $e) {
            $transaction->rollBack();
            throw new ServerErrorHttpException($e->getMessage());
        }

        return $this->redirect(['index']);
    }
}
