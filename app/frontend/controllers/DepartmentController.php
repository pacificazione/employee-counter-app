<?php

namespace frontend\controllers;

use common\models\Department;
use common\models\DepartmentEmployeeControlForm;
use common\models\repositories\DepartmentRepository;
use common\models\repositories\EmployeeRepository;
use common\models\search\DepartmentSearch;
use common\models\services\DepartmentService;
use common\models\services\EmployeeService;
use Exception;
use RuntimeException;
use Yii;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UnprocessableEntityHttpException;

/**
 * Контроллер отдела.
 */
class DepartmentController extends Controller
{
    private DepartmentService $departmentService;
    private EmployeeRepository $employeeRepository;
    private EmployeeService $employeeService;
    private DepartmentRepository $departmentRepository;

    public function __construct(
        $id,
        $module,
        DepartmentService
        $departmentService,
        EmployeeRepository $employeeRepository,
        EmployeeService $employeeService,
        DepartmentRepository $departmentRepository
    ) {
        parent::__construct($id, $module);
        $this->departmentService = $departmentService;
        $this->employeeRepository = $employeeRepository;
        $this->departmentRepository = $departmentRepository;
        $this->employeeService = $employeeService;
    }

    /**
     * @inheritDoc
     */
    public function behaviors(): array
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
     * Lists all Department models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new DepartmentSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Добавление сотрудника в отдел.
     *
     * @throws ForbiddenHttpException
     * @throws NotFoundHttpException
     * @throws \Throwable
     */
    public function actionAdd(int $departmentId)
    {
        $employeeForm = new DepartmentEmployeeControlForm();
        $bodyParams = Yii::$app->request->post();

        try {
            if ($employeeForm->load($bodyParams) && $employeeForm->validate()) {
                $employee = $this->employeeRepository->findByEmail($employeeForm->email);

                if ($employee === null) {
                    $employeeForm->addError('email', 'Сотрудник с указанной почтой не найден.');

                    return $this->render('add', [
                        'departmentId' => $departmentId,
                        'employeeForm' => $employeeForm,
                    ]);
                }

                $this->departmentService->addEmployee($departmentId, $employee->id);

                return $this->redirect(['department/view', 'id' => $departmentId]);
            }
        } catch (RuntimeException $exception) {
            $employeeForm->addError('email', 'Сотрудник уже находится в этом отделе.');
        }

        return $this->render('add', [
            'departmentId' => $departmentId,
            'employeeForm' => $employeeForm,
        ]);
    }

    /**
     * Удаление сотрудника из отдела.
     *
     * @throws NotFoundHttpException
     */
    public function actionRemove(int $departmentId)
    {
        $employeeForm = new DepartmentEmployeeControlForm();
        $bodyParams = Yii::$app->request->post();

        try {
            if ($employeeForm->load($bodyParams) && $employeeForm->validate()) {
                $employee = $this->employeeRepository->findByDepartmentIdAndEmail($departmentId, $employeeForm->email);

                if ($employee === null) {
                    $employeeForm->addError('email', 'Сотрудник с указанной почтой не найден.');

                    return $this->render('remove', [
                        'departmentId' => $departmentId,
                        'employeeForm' => $employeeForm,
                    ]);
                }

                $this->departmentService->removeEmployee($departmentId, $employee->id);

                return $this->redirect(['department/view', 'id' => $departmentId]);
            }
        } catch (RuntimeException $e) {
            $employeeForm->addError('email', $e->getMessage());
        }

        return $this->render('remove', [
            'departmentId' => $departmentId,
            'employeeForm' => $employeeForm,
        ]);
    }

    /**
     * Displays a single Department model.
     * @param int $id ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView(int $id)
    {
        return $this->render('view', [
            'model' => $this->departmentRepository->find($id),
        ]);
    }

    /**
     * Creates a new Department model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Department();

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
     * Updates an existing Department model.
     * If update is successful, the browser will be redirected to the 'view' page.
     *
     * @param int $id ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate(int $id)
    {
        $model = $this->departmentRepository->find($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['index', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete(int $departmentId)
    {
        $transaction = Yii::$app->db->beginTransaction();

        try {
            $this->departmentService->delete($departmentId);
            $transaction->commit();
        } catch (Exception $e) {
            $transaction->rollBack();
            throw new NotFoundHttpException($e->getMessage());
        }

        return $this->redirect(['index']);
    }
}
