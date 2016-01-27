<?php

namespace app\modules\admin\controllers;

use Yii;
use app\modules\admin\models\User;
use app\modules\admin\models\UserSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * UsersController implements the CRUD actions for User model.
 */
class UsersController extends Controller
{
    const EXCEPTION_MESS = 'Запрашиваемая страница не существует';
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                    'delete-admin' => ['post'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['create', 'update', 'view', 'delete',
                            'contragents', 'administrators', 'update-admin',
                            'create-admin', 'delete-admin'],
                        'roles' => ['@'],
                    ]
                ]
            ]
        ];
    }
    
    public function beforeAction($action) {
        if(parent::beforeAction($action) && Yii::$app->user->identity->role == 1)
        {
            return TRUE;
        };
        throw new \yii\web\HttpException(404);
    }

    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionContragents()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->searchContragents(Yii::$app->request->queryParams);

        return $this->render('contragents', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
    public function actionAdministrators()
    {
        $this->isSuperAdmin();
        $params = Yii::$app->request->queryParams;
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->searchAdministrators($params);
        
        return $this->render('administrators', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single User model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new User();
        $model->scenario = User::SCENARIO_CREATE_USER;
        $model->status = User::STATUS_ACTIVE;
        $model->role = 2;

        if ($model->load(Yii::$app->request->post()) && $model->save()) 
        {
            Yii::$app->session->setFlash('success', 'Новый контрагент успешно добавлен в систему');
            return $this->redirect(['contragents']);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }
    
    public function actionCreateAdmin()
    {
        $this->isSuperAdmin();
        $model = new User();
        $model->scenario = User::SCENARIO_CREATE_ADMIN;
        $model->status = User::STATUS_ACTIVE;
        $model->role = 1;
        
        if ($model->load(Yii::$app->request->post()) && $model->save()) 
        {
            Yii::$app->session->setFlash('success', 'Новый администратор успешно добавлен в систему');
            return $this->redirect(['administrators']);
        } else {
            return $this->render('createAdmin', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->scenario = User::SCENARIO_UPDATE_USER;
        
        if ($model->load(Yii::$app->request->post()) && $model->save()) 
        {
            Yii::$app->session->setFlash('success', 'Данные контрагента успешно отредактированы');
            return $this->redirect(['contragents']);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }
    
    public function actionUpdateAdmin($id)
    {
        $this->isSuperAdmin();
        $model = $this->findModel($id);
        $model->scenario = User::SCENARIO_UPDATE_ADMIN;
        
        if ($model->load(Yii::$app->request->post()) && $model->save()) 
        {
            Yii::$app->session->setFlash('success', 'Данные администратора успешно изменены');
            return $this->redirect(['administrators']);
        } else {
            return $this->render('updateAdmin', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $user = $this->findModel($id);
        if($user->role == 2) 
        {
            $user->delete();
            return $this->redirect(['contragents']);
        } else {
            throw new NotFoundHttpException(self::EXCEPTION_MESS);
        }
    }
    
    public function actionDeleteAdmin($id)
    {
        $user = $this->findModel($id);
        if(Yii::$app->user->getId() == 1) 
        {
            $user->delete();
            return $this->redirect(['administrators']);
        } else {
            throw new NotFoundHttpException(self::EXCEPTION_MESS);
        }
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) 
        {
            return $model;
        } else {
            throw new NotFoundHttpException(self::EXCEPTION_MESS);
        }
    }
    
    protected function isSuperAdmin()
    {
        if(Yii::$app->user->getId() == 1)
        {
            return true;
        } else {
            throw new NotFoundHttpException(self::EXCEPTION_MESS);
        }
        
    }
}
