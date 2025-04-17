<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "hitam".
 *
 * @property int $id
 * @property int $customer_id
 * @property int $c1
 * @property int $c2
 * @property int $c3
 * @property int $c4
 */
class Hitam extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hitam';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['customer_id', 'c1', 'c2', 'c3', 'c4'], 'required'],
            [['customer_id', 'c1', 'c2', 'c3', 'c4'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'customer_id' => 'Customer ID',
            'c1' => 'C1',
            'c2' => 'C2',
            'c3' => 'C3',
            'c4' => 'C4',
        ];
    }

}
