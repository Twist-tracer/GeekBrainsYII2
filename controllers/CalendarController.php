<?php

namespace app\controllers;

use Yii;
use app\models\Calendar;
use app\models\Access;
use app\models\search\CalendarSearch;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;

/**
 * CalendarController implements the CRUD actions for Calendar model.
 */
class CalendarController extends Controller
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
        ];
    }

    /**
     * Lists my Calendar models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CalendarSearch();
        $dataProvider = $searchModel->search([
            'CalendarSearch' => array_merge(
                ['creator' => Yii::$app->user->id],
                Yii::$app->request->queryParams
            )
        ]);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Select all public events.
     * @return mixed
     */
    public function actionPublicdates()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Access::find()->select(['date'])->orderBy('date'),
        ]);

        return $this->render('publicDates', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Calendar model.
     * @param int $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Displays my events.
     * @param $id
     * @return string
     * @throws ForbiddenHttpException
     */
    public function actionEvents($id)
    {
        $model = new Calendar();

        $result = Access::checkAccess($model);

        if($result)
        {
            switch($result) {
                case Access::ACCESS_CREATOR:
                    return $this->render('myEvents', [
                        'model' => $model,
                    ]);
                    break;
                case Access::ACCESS_GUEST:
                    return $this->render('friendsEvents', [
                        'model' => $model,
                    ]);
                    break;
            }
        }
        throw new ForbiddenHttpException("Not allowed! ");
    }

    /**
     * Creates a new Calendar model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Calendar();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Calendar model.
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
     * Deletes an existing Calendar model.
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
     * Finds the Calendar model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Calendar the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Calendar::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
