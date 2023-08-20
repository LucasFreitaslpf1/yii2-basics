<?php

namespace app\controllers;

use app\models\SaldoForm;
use app\models\Tipoconta;
use app\models\Tipotransacao;
use app\models\Transacao;
use app\models\TransacaoCadastro;
use app\models\TransacaoSearch;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\widgets\ActiveForm;

/**
 * TransacaoController implements the CRUD actions for Transacao model.
 */
class TransacaoController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Transacao models.
     *
     * @return string
     */
    public function actionIndex()
    {

        if (Yii::$app->user->can('admin')) {
            $searchModel = new TransacaoSearch();
            $dataProvider = $searchModel->search($this->request->queryParams);

            return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        } else {
            $this->redirect(Yii::$app->homeUrl);
        }
    }

    /**
     * Displays a single Transacao model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Transacao model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new TransacaoCadastro();

        if (Yii::$app->request->isAjax && $model->load($this->request->post())) {
            Yii::$app->response->format = 'json';
            return ActiveForm::validate($model);
        }

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {

                return $this->redirect(['painel/index']);
            }
        } else

            return $this->render('create', [
                'model' => $model,
            ]);
    }

    /**
     * Updates an existing Transacao model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        if (Yii::$app->user->can('admin')) {
            $model = $this->findModel($id);

            if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }

            return $this->render('update', [
                'model' => $model,
            ]);
        } else {
            $this->redirect(Yii::$app->homeUrl);
        }
    }

    /**
     * Deletes an existing Transacao model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Transacao model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Transacao the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Transacao::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionNovotipo()
    {
        if (Yii::$app->user->can('admin')) {
            $tipo = new Tipotransacao();
            if ($this->request->isPost) {
                if ($tipo->load($this->request->post()) && $tipo->save()) {
                    return $this->redirect('novotipo');
                }
            }
            return $this->render('novotipo', ['tipo' => $tipo]);
        } else {
            $this->redirect(Yii::$app->homeUrl);
        }
    }
}
