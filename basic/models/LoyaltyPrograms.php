<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "loyalty_programs".
 *
 * @property integer $ID
 * @property string $NAME
 * @property integer $MAX_PERCENT
 * @property integer $WELCOME_BONUS
 *
 * @property ClientsGroups $iD
 */
class LoyaltyPrograms extends Prototype
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'loyalty_programs';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['NAME', 'MAX_PERCENT', 'WELCOME_BONUS'], 'required'],
            [['MAX_PERCENT', 'WELCOME_BONUS'], 'integer'],
            [['NAME'], 'string', 'max' => 50],
            [['ID'], 'exist'],
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
            'MAX_PERCENT' => 'Максимальный %',
            'WELCOME_BONUS' => 'Приветственный бонус',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    /*public function getGroupId()
    {
        return $this->hasOne(ClientsGroups::className(), ['LOYALTY_PROGRAM_ID' => 'ID'])->inverseOf('loyaltyPrograms');
    }*/

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClientsGroups()
    {
        return $this->hasMany(ClientsGroups::className(), ['LOYALTY_PROGRAM_ID' => 'ID'])->inverseOf('lOYALTYPROGRAM');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLoyaltyProgramsSteps()
    {
        return $this->hasMany(LoyaltyProgramsSteps::className(), ['LOYALTY_PROGRAM_ID' => 'ID'])->inverseOf('lOYALTYPROGRAM');
    }
}
