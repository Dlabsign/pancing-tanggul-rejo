<?php

namespace app\controllers;

use app\models\customerSearch;
use Yii;
use app\models\Customer;
use app\models\Undian;
use yii\web\Controller;
use yii\widgets\ActiveForm;
use yii\web\Response;

class UndianController extends Controller
{
    public function actionIndex()
    {
        // Ambil data customer dari database
        $customers = Customer::find()->all();
        $searchModel = new CustomerSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);


        // Jika data undian dipilih, simpan undian di tabel undian
        if (Yii::$app->request->isPost) {
            $selectedCustomers = Yii::$app->request->post('selected_customers', []);

            // Simpan ke tabel undian
            foreach ($selectedCustomers as $customerId) {
                $undian = new Undian();
                $undian->customer_id = $customerId;
                $undian->save();
            }

            // Berikan response atau redirect setelah sukses
            Yii::$app->session->setFlash('success', 'Undian berhasil dilakukan!');
            return $this->redirect(['index']);
        }

        // Render tampilan dengan data customer
        return $this->render('index', [
            'customers' => $customers,
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }
}
