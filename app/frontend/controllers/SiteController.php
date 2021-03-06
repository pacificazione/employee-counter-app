<?php

namespace frontend\controllers;

use common\models\repositories\DepartmentRepository;
use common\models\services\LoginService;
use common\models\repositories\EmployeeRepository;
use common\models\services\SignUpDto;
use common\models\services\SignUpService;
use common\models\SignUpForm;
use Yii;
use yii\base\Exception;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use yii\web\NotFoundHttpException;
use yii\web\ServerErrorHttpException;

/**
 * Site controller
 */
class SiteController extends Controller
{
    private EmployeeRepository $employeeRepository;

    private LoginService $loginService;

    private SignUpService $signUpService;

    private DepartmentRepository $departmentRepository;

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function __construct(
        $id,
        $module,
        EmployeeRepository $employeeRepository,
        LoginService $loginService,
        SignUpService $signUpService,
        DepartmentRepository $departmentRepository
    ) {
        parent::__construct($id, $module);
        $this->loginService = $loginService;
        $this->employeeRepository = $employeeRepository;
        $this->signUpService = $signUpService;
        $this->departmentRepository = $departmentRepository;
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        $request = Yii::$app->request;

        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();

        if ($model->load($request->post())) {
            $employee = $this->employeeRepository->findByEmail($model->email);
            $model->setEmployee($employee);
            $model->validate();

            if ($employee === null) {
                throw new NotFoundHttpException('?????????????????? ?? ?????????? ???????????? ???? ????????????.');
            }

            if ($this->loginService->login($employee, $model->rememberMe)) {
                return $this->redirect(['/']);
            }
        }

        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $request = Yii::$app->request;
        $signUpForm = new SignUpForm();
        $departmentList = ArrayHelper::map($this->departmentRepository->getList(), 'id', 'departmentName');
        $transaction = Yii::$app->db->beginTransaction();

        try {
            if ($signUpForm->load($request->post()) && $signUpForm->validate()) {
                $signUpDto = new SignUpDto(
                    $signUpForm->firstName,
                    $signUpForm->lastName,
                    $signUpForm->education,
                    $signUpForm->post,
                    $signUpForm->age,
                    $signUpForm->nationality,
                    $signUpForm->email,
                    $signUpForm->password,
                    $signUpForm->departmentId,
                );

                $this->signUpService->signUp($signUpDto, $signUpDto->getDepartmentId());
                Yii::$app->session->setFlash('success', '?????????????????????? ???????????? ??????????????.');
                $transaction->commit();

                return $this->goHome();
            }
        } catch (Exception $e) {
            $transaction->rollBack();
            throw new ServerErrorHttpException($e->getMessage());
        }

        return $this->render('signup', [
            'departmentList' => $departmentList,
            'model' => $signUpForm,
        ]);
    }
}
