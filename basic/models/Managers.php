<?php

namespace app\models;

use app\models\User;
use Yii;

class Managers extends User
{
    public $PASSWORD;
    public $PASSWORD_CONFIRM;

    public function rules() {
        return array_merge(parent::rules(), [
            [['PASSWORD_CONFIRM', 'PASSWORD'], 'string', 'max' => 15],
            [ ['PASSWORD_CONFIRM'], 'compare', 'compareAttribute' => 'PASSWORD', 'message' => 'Значение поля должно совпадать со значением поля ' . $this->getAttributeLabel('PASSWORD')],
        ]);
    }


    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'PASSWORD' => 'Пароль',
            'PASSWORD_CONFIRM' => 'Подтверждение пароля',
        ];
    }


    /**
     * @param bool  $insert
     * @param array $changedAttributes
     */
    public function beforeSave($insert)
    {
        # Setting manager password
        if( !empty($this->PASSWORD) && !empty($this->PASSWORD_CONFIRM)
            && $this->PASSWORD == $this->PASSWORD_CONFIRM ){

            $this->setPassword($this->PASSWORD);
        }

        return parent::beforeSave($insert);
    }


    /**
     * @param bool  $insert
     * @param array $changedAttributes
     */
    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes); // TODO: Change the autogenerated stub

        try{
            if( $insert ){
                # Setting manager role for new manager
                $userRole = Yii::$app->authManager->getRole('manager');
                Yii::$app->authManager->assign($userRole, $this->id);
            }
        }
        catch(\Exception $e){
            Yii::trace($e->getMessage(), 'flower');
        }

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
            ->where(['ACTIVE' => 'Y', 'aa.item_name' => 'manager']);

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
