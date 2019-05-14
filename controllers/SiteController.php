<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\SignupForm;
use app\models\ActivateForm;
use Exception;
use app\components\AuthHandler;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
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
            'auth' => [
                'class' => 'yii\authclient\AuthAction',
                'successCallback' => [$this, 'onAuthSuccess'],
            ],
        ];
    }
    
    public function onAuthSuccess($client)
    {
        (new AuthHandler($client))->handle();
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
    
    /**
     * Render a page with restricted access.
     * 
     * @param string $role The required role name
     * @return string The rendered page content
     */
    private function renderRestrictedPage($role)
    {
        $user = Yii::$app->user;
        
        if ($user->isGuest or !$user->can($role)) {
            Yii::$app->session->setFlash('error', Yii::t('app', 'You cannot access this page.'));
            return $this->redirect(['login']);
        }
        
        return $this->render('restricted');
    }
    
    
    /**
     * The action to display the user page.
     * 
     * @return string The rendered page content
     */
    public function actionUserPage()
    {
        return $this->renderRestrictedPage('user');
    }

    /**
     * The action to display the manager page.
     * 
     * @return string The rendered page content
     */
    public function actionManagerPage()
    {
        return $this->renderRestrictedPage('manager');
    }
    
    /**
     * The action to display the administrator page.
     * 
     * @return string The rendered page content
     */
    public function actionAdminPage()
    {
        return $this->renderRestrictedPage('admin');
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            Yii::$app->session->setFlash('success', Yii::t('app', 'The user is logged in successfully.'));
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();
        Yii::$app->session->setFlash('info', Yii::t('app', 'The user is logged out.'));

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }
    
    /**
     * Displays registration form.
     * 
     * @return Response|string
     */
    public function actionSignup() 
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post()) && $model->signup()) {
            if (!$model->notify()) {
                Yii::$app->session->setFlash('error', Yii::t('app', 'Cannot send a notification.'));
            }
            if ($model->isPhone()) {
                // Sign up by phone
                Yii::$app->session->setFlash('success', Yii::t('app', 'The user account has successfully been created. Your password has been sent to the phone number you\'ve provided. You now can log into the system.'));
                return $this->redirect(['login']);
            } else {
                // Sign up by email
                Yii::$app->session->setFlash('success', Yii::t('app', 'The user account has successfully been created. Check your email for account activation instructions.'));
                return $this->goHome();
            }
        }

        $model->password = '';
        return $this->render('signup', [
            'model' => $model,
        ]);
    }
    
    public function actionActivate()
    {
        $model = new ActivateForm();
        
        if (!$model->load(Yii::$app->request->post())) {
            throw new Exception('Error loading activation data.', 
                '500');
        }

        if (!$model->getUser()) {
            // Incorrect token
            return $this->goHome();
        }
        
        if ($model->password) {
            // Activate the user account
            if (!$model->setPassword()) {
                Yii::$app->session->setFlash('error', Yii::t('app', 'Cannot activate user account.'));
                return $this->goHome();
            }
            
            Yii::$app->session->setFlash('success', Yii::t('app', 'The user account has been activated. You can now log in.'));
            return $this->redirect(['login']);
            
            return true;
        } else {
            // Display activation form
            return $this->render('activate', [
                'model' => $model,
            ]);
        }
    }
}
