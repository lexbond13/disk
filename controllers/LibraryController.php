<?php

namespace app\controllers;

use Yii;
use app\models\Library;
use app\models\Users;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * LibraryController implements the CRUD actions for Library model.
 */
class LibraryController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
            
            
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index','available','myself','another','logout','create','get','back'],
                        'roles' => ['@'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['login'],
                        'roles' => ['?'],
                    ],
                ],
            ],
                        
        ];
    }

    /**
     * Lists all Library models.
     * @return mixed
     */
     
    public function actionAvailable()
    {
        $this->view->title = "Свободные диски";
        $data = Library::find()
                            ->where("id_user = 0 AND id_owner != ".Yii::$app->user->id)
                            ->all();

        return $this->render('index', [
            'data' => $data,
        ]);
    } 
     
 
    public function actionIndex()
    {
        $this->view->title = "Моя коллекция";
        $data = Library::find()
                            ->where(['id_owner'=>Yii::$app->user->id])
                            ->all();

        return $this->render('index', [
            'data' => $data,
        ]);
    }
    
    public function actionMyself()
    {
        $this->view->title = "Взятые мной";
        $data = Library::find()
                            ->where(['id_user'=>Yii::$app->user->id])
                            ->all();

        return $this->render('index', [
            'data' => $data,
        ]);
    }
    
    public function actionAnother()
    {
        $this->view->title = "Взятые у меня";
        $data = Library::find()
                            ->with('users')
                            ->where("id_owner = ".Yii::$app->user->id." AND id_user>0")
                            ->all();
        return $this->render('index', [
            'data' => $data,
        ]);
    }
    
    public function actionGet($id)
    {
        $disk = Library::find()
                            ->where("id = :id", ['id'=>$id])
                            ->one();
        $disk->id_user = Yii::$app->user->id;
        $disk->save(false);
        
        return $this->redirect(['available']);
    }
    
    public function actionBack($id)
    {
        $disk = Library::find()->where("id = :id", ['id'=>$id])->one();
        print_r($disk);
        $disk->id_user = 0;
        $disk->save(false);

        return $this->redirect(['myself']);
    }

    /**
     * Displays a single Library model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }
    
    public function actionLogout()
    {
        $user = new Users;
        $user->Logout();
        return $this->redirect(['library/login']);
    }
    
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }
 
        $model = new Users();
        if ($model->load(Yii::$app->request->post()) 
            && $model->login()) {
            return $this->goBack();
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Creates a new Library model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Library();
        
        $model->id_owner = Yii::$app->user->id;
        
        if ($model->load(Yii::$app->request->post())) {
            $model->img = UploadedFile::getInstance($model, 'img');
            $path = Yii::$app->params['pathUploads'] . 'images/';
            $model->img->saveAs($path . $model->img);
            $model->img = $model->img->baseName.".".$model->img->extension;
            $model->save();
            
            return $this->redirect(['library/index']);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Library model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Library model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Library model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Library the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Library::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
