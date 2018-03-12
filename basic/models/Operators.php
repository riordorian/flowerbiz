<?php

namespace app\models;

use budyaga\users\models\User;
use Yii;

class Operators extends User
{
    public $TERMINAL_PASSWORD;

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), ['pay' => 'Оплата']);
    }


    /**
     * @return array
     */
    public function rules()
    {
        $arRules = parent::rules();
        $arRules[] = [['pay'], 'integer'];

        return $arRules;
    }


    /**
     * @return bool
     */
    public function beforeValidate()
    {
        if( empty($this->email) ){
            $this->setAttribute('email', $this->username);
        }
        
        return parent::beforeValidate();
    }
    

    /**
     * @param bool  $insert
     * @param array $changedAttributes
     */
    public function afterSave($insert, $changedAttributes)
    {
        # Setting operator password
        $password = $this->getAttribute('password_hash');
        if( empty($password) ){
            $password = str_pad($this->id, 4, '0', STR_PAD_LEFT);
            $this->setPassword($password);

            $userRole = Yii::$app->authManager->getRole('operator');
            Yii::$app->authManager->assign($userRole, $this->id);
            
            $this->save();
        }

        parent::afterSave($insert, $changedAttributes);
    }

    /**
     * Finding elem with relations
     *
     * @param int $id
     * @param     $arParams
     *
     * @return array|null|\yii\db\ActiveRecord
     */
    public function findElem($id = 0, $arParams = [])
    {
        $obModel = static::find();

        if( !empty($arParams['with']) && is_array($arParams['with']) ){
            foreach($arParams['with'] as $withOb){
                $obModel->with($withOb);
            }
        }

        $model = $obModel->where(['id' => $id])->one();

        return $model;
    }


    /**
     * Getting operators list
     *
     * @return $this
     */
    public static function getList($arParams = [])
    {
        $query = User::find()
            ->leftJoin('auth_assignment as aa', 'id=aa.user_id')
            ->where(['ACTIVE' => 'Y', 'aa.item_name' => 'operator']);
        
        if( !empty($arParams['select']) ){
            $query->addSelect($arParams['select']);
        }

        if( empty($arParams['RETURN_TYPE']) || $arParams['RETURN_TYPE'] != 'QUERY' ){
            $query->asArray();
            $arRes = $query->all();
        }
        else{
            $arRes = $query;
        }

        return $arRes;
    }
}
