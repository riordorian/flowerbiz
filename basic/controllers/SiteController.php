<?php

namespace app\controllers;

use app\models\Sms;
use budyaga\users\models\forms\LoginForm;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\ContactForm;

class SiteController extends Controller
{
    /**
     * @inheritdoc
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
     * @inheritdoc
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
    
    
    public function beforeAction($action)
    {
        $bIsGuest = Yii::$app->user->isGuest;

        if( $bIsGuest ){
            switch( $this->getRoute() ){
                case 'site/admin':
				case 'site/index':
                    return $this->redirect('/login/');

                    break;
                case 'site/terminal':
                    return $this->redirect('/terminal/login/');

                    break;
            }
        }
        elseif( Yii::$app->user->can('adminWork') ){
			$this->redirect('/admin/clients/');
        }


        return parent::beforeAction($action); // TODO: Change the autogenerated stub
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
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
        $this->layout = 'admin-login';


        $model = new LoginForm();

        if (!Yii::$app->user->isGuest) {
            return $this->goBack();
        }

        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->redirect('/admin/clients/');
        }

        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();
    }

    /**
     * Displays contact page.
     *
     * @return string
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
    public function actionResetPassword()
    {
        return $this->render('about');
    }


}
