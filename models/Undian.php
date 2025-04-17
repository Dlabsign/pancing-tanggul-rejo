<?php

namespace app\models;
use Yii;

class Undian extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return 'undian';
    }
    public function rules()
    {
        return [
            [['customer_id', 'merah_id', 'hitam_id'], 'required'],
            [['customer_id', 'merah_id', 'hitam_id'], 'integer'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'customer_id' => 'Customer ID',
            'merah_id' => 'Merah ID',
            'hitam_id' => 'Hitam ID',
        ];
    }

}
