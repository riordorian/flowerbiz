<?php

namespace app\models\admin;

use Yii;

/**
 * This is the model class for table "sms_settings".
 *
 * @property int $ID
 * @property string $API_ID
 */
class SmsSettings extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sms_settings';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['API_ID'], 'string', 'max' => 255],
            [['ACTIVE'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'API_ID' => 'Ключ сервиса',
            'ACTIVE' => 'Активность',
        ];
    }
}
