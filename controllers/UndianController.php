<?php

namespace app\controllers;

use app\models\Customer;
use app\models\Lomba;
use app\models\Undian;
use Yii;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class UndianController extends Controller
{
    public function actionIndex($id = null)
    {

        $undianCustomers = Undian::find()
            ->select('customer_id, lomba_id')
            ->indexBy('lomba_id') // Mengelompokkan undian berdasarkan lomba_id
            ->all();

        $tanggal = new Lomba();

        // Jika user submit tanggal lomba
        if ($tanggal->load(Yii::$app->request->post()) && $tanggal->validate()) {
            $tanggal->save();
            return $this->redirect(['index', 'id' => $tanggal->id]);
        }

        $customers = Customer::find()->all();

        // Jika ada POST dari AJAX (penyimpanan undian)
        if (Yii::$app->request->isPost && Yii::$app->request->post('undian_data')) {
            $undianData = Yii::$app->request->post('undian_data');
            if ($undianData) {
                $data = json_decode($undianData, true);

                // Pastikan customer_id dan lapak tersedia (lomba_id pakai dari URL $id)
                if (!isset($data['customer_id'], $data['lapak1'], $data['lapak2'])) {
                    return $this->asJson([
                        'success' => false,
                        'message' => 'Data tidak lengkap. Pastikan customer_id dan lapak tersedia.'
                    ]);
                }

                // Pastikan id lomba dari URL valid
                $lomba = Lomba::findOne($id);
                if (!$lomba) {
                    return $this->asJson(['success' => false, 'message' => 'Lomba tidak ditemukan']);
                }

                $model = new Undian();
                $model->customer_id = $data['customer_id'];
                $model->tanggal = $lomba->tanggal;
                $model->lapak1 = $data['lapak1'];
                $model->lapak2 = $data['lapak2'];
                $model->lomba_id = $id; // gunakan id dari URL, bukan dari POST

                if ($model->save()) {
                    return $this->asJson([
                        'success' => true,
                        'data' => [
                            'customer_id' => $model->customer_id,
                            'tanggal' => $model->tanggal,
                            'lapak1' => $model->lapak1,
                            'lapak2' => $model->lapak2,
                            'lomba_id' => $model->lomba_id,
                        ]
                    ]);
                } else {
                    Yii::error('Gagal menyimpan data: ' . json_encode($model->errors), __METHOD__);
                    return $this->asJson([
                        'success' => false,
                        'message' => 'Gagal menyimpan data',
                        'errors' => $model->errors
                    ]);
                }
            }
        }


        $dataProvider = new \yii\data\ArrayDataProvider([
            'allModels' => $customers,
            'pagination' => false, // <-- agar semua data ditampilkan
        ]);

        return $this->render('index', [
            'customers' => $customers,
            'dataProvider' => $dataProvider,
            'tanggal' => $tanggal,
            'undianCustomers' => $undianCustomers,
            'lomba_id' => $id,
        ]);
    }

    public function actionPrint()
    {
        // Ambil parameter 'id' dari URL (lomba_id)
        $lomba_id = Yii::$app->request->get('id');

        // Pastikan 'lomba_id' ada, jika tidak lempar error
        if (!$lomba_id) {
            throw new NotFoundHttpException('Lomba ID tidak ditemukan');
        }

        // Buat query dengan kondisi berdasarkan 'lomba_id'
        $dataProvider = new ActiveDataProvider([
            'query' => Customer::find()->with([
                'undians' => function ($query) use ($lomba_id) {
                    $query->andWhere(['lomba_id' => $lomba_id]);
                }
            ]),
            'pagination' => false,
        ]);

        // Render tampilan print dengan data yang disaring berdasarkan 'lomba_id'
        return $this->render('print', [
            'dataProvider' => $dataProvider,
            'lomba_id' => $lomba_id,
        ]);
    }

    public function actionGetLapakUsed($id)
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $data = Undian::find()
            ->select(['lapak1', 'lapak2'])
            ->where(['lomba_id' => $id])
            ->asArray()
            ->all();

        return $data;
    }



}

?>