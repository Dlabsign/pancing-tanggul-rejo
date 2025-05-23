<?php

namespace app\models;
use Yii;
use app\models\Customer; // Ensure the correct namespace for the Customer class

class Undian extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return 'undian'; // Ensure this matches your database table name
    }

    public function rules()
    {
        return [
            [['customer_id', 'lomba_id'], 'required'],
            [['customer_id', 'lomba_id', 'lapak1', 'lapak2'], 'integer'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'customer_id' => 'Customer ID',
            'lapak1' => 'Lapak 1',
            'lapak2' => 'Lapak 2',
            'lomba_id' => 'Lomba Id',
        ];
    }

    public function getCustomer()
    {
        return $this->hasOne(Customer::class, ['id' => 'customer_id']);
    }
    public function getLomba()
    {
        return $this->hasOne(Customer::class, ['lomba_id' => 'id']);
    }


}
