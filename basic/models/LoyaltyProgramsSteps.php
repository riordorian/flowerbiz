<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "loyalty_programs_steps".
 *
 * @property integer $ID
 * @property integer $TOTAL
 * @property integer $GROUP_ID
 * @property integer $LOYALTY_PROGRAM_ID
 *
 * @property ClientsGroups $gROUP
 * @property LoyaltyPrograms $lOYALTYPROGRAM
 */
class LoyaltyProgramsSteps extends Prototype
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'loyalty_programs_steps';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ID'], 'safe'],
            [['TOTAL', 'CLIENT_GROUP_ID', 'LOYALTY_PROGRAM_ID'], 'required'],
            [['TOTAL', 'CLIENT_GROUP_ID', 'LOYALTY_PROGRAM_ID'], 'integer'],
            [['CLIENT_GROUP_ID'], 'exist', 'skipOnError' => true, 'targetClass' => ClientsGroups::className(), 'targetAttribute' => ['CLIENT_GROUP_ID' => 'ID']],
            [['LOYALTY_PROGRAM_ID'], 'exist', 'skipOnError' => true, 'targetClass' => LoyaltyPrograms::className(), 'targetAttribute' => ['LOYALTY_PROGRAM_ID' => 'ID']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'TOTAL' => 'Сумма покупок',
            'CLIENT_GROUP_ID' => 'Группа',
            'LOYALTY_PROGRAM_ID' => 'Программа лояльности',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGroup()
    {
        return $this->hasOne(ClientsGroups::className(), ['ID' => 'CLIENT_GROUP_ID'])->inverseOf('loyaltyProgramsSteps');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLoyaltyProgram()
    {
        return $this->hasOne(LoyaltyPrograms::className(), ['ID' => 'LOYALTY_PROGRAM_ID'])->inverseOf('loyaltyProgramsSteps');
    }
}
