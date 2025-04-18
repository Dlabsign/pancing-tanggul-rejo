<?php

namespace app\controllers;

use app\models\Customer;
use app\models\CustomerSearch;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CustomerController implements the CRUD actions for customer model.
 */
class CustomerController extends Controller
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
     * Lists all customer models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new CustomerSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single customer model.
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
     * Creates a new customer model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    // public function actionCreate()
    // {
    //     $model = new customer();

    //     if ($this->request->isPost) {
    //         if ($model->load($this->request->post()) && $model->save()) {
    //             return $this->redirect(['view', 'id' => $model->id]);

    //         }
    //     } else {
    //         $model->loadDefaultValues();
    //     }

    //     return $this->render('create', [
    //         'model' => $model,
    //     ]);
    // }

    public function actionCreate()
    {
        $model = new Customer();

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                $existingCustomer = Customer::find()->where(['nama' => $model->nama])->one();

                if ($existingCustomer) {
                    Yii::$app->session->setFlash('error', 'Nama customer sudah ada.');
                    return $this->refresh();
                }
                $nama = $model->nama;
                $ss1 = $model->ss1;
                $ss2 = $model->ss2;
                $ss3 = $model->ss3;
                $lapak = $model->lapak;
                $c1_merah = $model->c1_merah;
                $c2_merah = $model->c2_merah;
                $c3_merah = $model->c3_merah;
                $c4_merah = $model->c4_merah;
                $c1_hitam = $model->c1_hitam;
                $c2_hitam = $model->c2_hitam;
                $c3_hitam = $model->c3_hitam;
                $c4_hitam = $model->c4_hitam;
                $ikan_id_merah = $model->ikan_id_merah;
                $ikan_id_hitam = $model->ikan_id_hitam;

                $connection = Yii::$app->db;

                $connection->createCommand()->insert('customer', [
                    'nama' => $nama,
                    'ss1' => $ss1,
                    'ss2' => $ss2,
                    'ss3' => $ss3,
                    'lapak' => $lapak,
                ])->execute();

                $customerId = $connection->getLastInsertID();

                // Merah
                if ($ikan_id_merah == 1) {
                    $connection->createCommand()->insert('merah', [
                        'customer_id' => $customerId,
                        'c1' => $c1_merah,
                        'c2' => $c2_merah,
                        'c3' => $c3_merah,
                        'c4' => $c4_merah,
                    ])->execute();
                }
                // Hitam
                if ($ikan_id_hitam == 2) {
                    $connection->createCommand()->insert('hitam', [
                        'customer_id' => $customerId,
                        'c1' => $c1_hitam,
                        'c2' => $c2_hitam,
                        'c3' => $c3_hitam,
                        'c4' => $c4_hitam,
                    ])->execute();
                }

                return $this->redirect(['index']);
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }




    /**
     * Updates an existing customer model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $merah = (new \yii\db\Query())->from('merah')->where(['customer_id' => $id])->one();
        $hitam = (new \yii\db\Query())->from('hitam')->where(['customer_id' => $id])->one();

        if ($merah) {
            $model->c1_merah = $merah['c1'] ?? null; // Gunakan 'c1' sesuai nama kolom di tabel 'merah'
            $model->c2_merah = $merah['c2'] ?? null;
            $model->c3_merah = $merah['c3'] ?? null;
            $model->c4_merah = $merah['c4'] ?? null;
            $model->ikan_id_merah = 1;
        }

        if ($hitam) {
            $model->c1_hitam = $hitam['c1'] ?? null; // Gunakan 'c1' sesuai nama kolom di tabel 'hitam'
            $model->c2_hitam = $hitam['c2'] ?? null;
            $model->c3_hitam = $hitam['c3'] ?? null;
            $model->c4_hitam = $hitam['c4'] ?? null;
            $model->ikan_id_hitam = 2; // Asumsi ikan_id untuk hitam adalah 2
        }

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                $nama = $model->nama;
                $ss1 = $model->ss1;
                $ss2 = $model->ss2;
                $ss3 = $model->ss3;
                $lapak = $model->lapak;
                $c1_merah = $model->c1_merah;
                $c2_merah = $model->c2_merah;
                $c3_merah = $model->c3_merah;
                $c4_merah = $model->c4_merah;
                $c1_hitam = $model->c1_hitam;
                $c2_hitam = $model->c2_hitam;
                $c3_hitam = $model->c3_hitam;
                $c4_hitam = $model->c4_hitam;
                $ikan_id_merah = $model->ikan_id_merah;
                $ikan_id_hitam = $model->ikan_id_hitam;

                $connection = Yii::$app->db;

                $connection->createCommand()->update('customer', [
                    'nama' => $nama,
                    'ss1' => $ss1,
                    'ss3' => $ss3,
                    'ss2' => $ss2,
                    'lapak' => $lapak,
                ], ['id' => $id])->execute();

                // Merah
                $cekMerah = (new \yii\db\Query())
                    ->from('merah')
                    ->where(['customer_id' => $id])
                    ->exists();

                if ($ikan_id_merah == 1) {
                    if ($cekMerah) {
                        $connection->createCommand()->update('merah', [
                            'c1' => $c1_merah, // Gunakan 'c1'
                            'c2' => $c2_merah,
                            'c3' => $c3_merah,
                            'c4' => $c4_merah,
                        ], ['customer_id' => $id])->execute();
                    } else {
                        $connection->createCommand()->insert('merah', [
                            'customer_id' => $id,
                            'c1' => $c1_merah,
                            'c2' => $c2_merah,
                            'c3' => $c3_merah,
                            'c4' => $c4_merah,
                        ])->execute();
                    }
                } else {
                    if ($cekMerah) {
                        $connection->createCommand()->delete('merah', ['customer_id' => $id])->execute();
                    }
                }

                $cekHitam = (new \yii\db\Query())
                    ->from('hitam')
                    ->where(['customer_id' => $id])
                    ->exists();

                if ($ikan_id_hitam == 2) {
                    if ($cekHitam) {
                        $connection->createCommand()->update('hitam', [
                            'c1' => $c1_hitam, // Gunakan 'c1'
                            'c2' => $c2_hitam,
                            'c3' => $c3_hitam,
                            'c4' => $c4_hitam,
                        ], ['customer_id' => $id])->execute();
                    } else {
                        $connection->createCommand()->insert('hitam', [
                            'customer_id' => $id,
                            'c1' => $c1_hitam,
                            'c2' => $c2_hitam,
                            'c3' => $c3_hitam,
                            'c4' => $c4_hitam,
                        ])->execute();
                    }
                } else {
                    if ($cekHitam) {
                        $connection->createCommand()->delete('hitam', ['customer_id' => $id])->execute();
                    }
                }

                // return $this->redirect(['index', 'id' => $id]);
                return $this->redirect(['index']);

            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing customer model.
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
     * Finds the customer model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return customer the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Customer::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
