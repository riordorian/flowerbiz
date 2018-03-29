<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "providers".
 *
 * @property integer $ID
 * @property string $NAME
 * @property string $PHONE
 * @property string $EMAIL
 * @property string $MANAGER
 * @property string $ADDRESS
 */
class Providers extends Prototype
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'providers';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['NAME'], 'required'],
            [['NAME', 'EMAIL'], 'string', 'max' => 50],
            [['PHONE'], 'string', 'max' => 20],
            [['MANAGER', 'ADDRESS'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'NAME' => 'Название',
            'PHONE' => 'Телефон',
            'EMAIL' => 'Почта',
            'MANAGER' => 'ФИО менеджера',
            'ADDRESS' => 'Адрес',
        ];
    }


    public function getGoodSupplies()
    {
        return $this->hasMany(GoodSupply::className(), ['PROVIDER' => 'ID'])->inverseOf('provider');
    }

    public function getGoodsSupplies()
    {
//        return $this->hasMany(GoodsSupplies::className(), ['PROVIDER_ID' => 'ID'])->inverseOf('provider');
    }
}
