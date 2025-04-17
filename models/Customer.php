<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "customer".
 *
 * @property int $id
 * @property string $nama
 * @property int|null $C1
 * @property int|null $C2
 * @property int|null $C3
 * @property int|null $C4
  * @property int|null $ikan_id

 */
class Customer extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'customer';
    }

    public $ikan_id_merah;
    public $c1_merah;
    public $c1_hitam;
    public $c2_merah;
    public $c2_hitam;
    public $c3_merah;
    public $c3_hitam;
    public $c4_merah;
    public $c4_hitam;
    public $ikan_id_hitam;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nama'], 'required'],
            [['ikan_id_merah', 'ikan_id_hitam'], 'safe'],
            [['c1_merah', 'c2_merah', 'c3_merah', 'c4_merah', 'c1_hitam', 'c2_hitam', 'c3_hitam', 'c4_hitam', 'ss1', 'ss2', 'ss3', 'lapak'], 'integer'],
            [['nama'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nama' => 'Nama',
            'ss1' => 'SS1',
            'ss2' => 'SS2',
            'ss3' => 'SS3',
            'lapak' => 'Jumlah Lapak',
            'ikan_id_merah' => 'Merah',
            'ikan_id_hitam' => 'Hitam',
        ];
    }

    public function getMerah()
    {
        return $this->hasOne(Merah::class, ['customer_id' => 'id']);
    }
    public function getHitam()
    {
        return $this->hasOne(Hitam::class, ['customer_id' => 'id']);
    }
}
