<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "merah".
 *
 * @property int $id
 * @property int $c1
 * @property int $c2
 * @property int $c3
 */
class Merah extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'merah';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['c1', 'c2', 'c3','c4'], 'required'],
            [['customer_id','c1', 'c2', 'c3','c4'], 'integer'],
            // [['customer-id'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'customer_id' => 'ID Customer',
            'c1' => 'c1',
            'c2' => 'c2',
            'c3' => 'c3',
            'c4' => 'c4',
        ];
    }

}
