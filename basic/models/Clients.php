<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "clients".
 *
 * @property integer $ID
 * @property string $NAME
 * @property string $TYPE
 * @property string $GENDER
 * @property string $BIRTHDAY
 * @property string $PHONE
 * @property string $BONUS
 * @property string $EMAIL
 * @property string $DESCRIPTION
 *
 * @property ClientsClientsGroups[] $clientsClientsGroups
 */
class Clients extends Prototype
{
    public $BIRTHDAY_DAY;
    public $BIRTHDAY_MONTH;
    public $BIRTHDAY_YEAR;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'clients';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['NAME', 'PHONE'], 'required', 'message' => 'Поле обязательно для заполнения.'],
            [['BIRTHDAY'], 'safe'],
            [['BONUS'], 'integer'],
            [['BIRTHDAY_MONTH', 'BIRTHDAY_DAY', 'BIRTHDAY_YEAR'], 'string'],
            [['DESCRIPTION'], 'string'],
            [['NAME'], 'string', 'max' => 100],
            [['GENDER'], 'string', 'max' => 1],
            ['PHONE', 'string', 'max' => 20],
            [['PHONE'], 'unique', 'message' => 'Номер уже зарегистрирован в системе'],
            [['EMAIL'], 'string', 'max' => 40],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => '#',
            'NAME' => 'ФИО',
            'CLIENT_TYPE' => 'Тип клиента',
            'GENDER' => 'Пол',
            'BIRTHDAY_DAY' => 'Дата рождения',
            'BIRTHDAY' => 'Дата рождения',
            'PHONE' => 'Телефон',
            'EMAIL' => 'Email',
            'DESCRIPTION' => 'Описание',
            'CLIENT_GROUP' => 'Группа',
            'BONUS' => 'Бонусов доступно',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClientsClientsGroups()
    {
        return $this->hasOne(ClientsClientsGroups::className(), ['CLIENT_ID' => 'ID']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClientsClientsTypes()
    {
        return $this->hasOne(ClientsClientsTypes::className(), ['CLIENT_ID' => 'ID']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClientsEvents()
    {
        return $this->hasMany(ClientsEvents::className(), ['CLIENT_ID' => 'ID']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrders()
    {
        return $this->hasMany(Orders::className(), ['CLIENT_ID' => 'ID'])->inverseOf('client');
    }


    /**
     * After save element event handler
     * @param bool  $insert
     * @param array $changedAttributes
     */
    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
        $obCCTypes = new ClientsClientsTypes();
        $obCCTypes->load(Yii::$app->request->post());

        $obCCGroups = new ClientsClientsGroups();
        $obCCGroups->load(Yii::$app->request->post());

        $obCCGroups->CLIENT_ID = $obCCTypes->CLIENT_ID = $this->ID;

        try{
            $obCCTypes->save(false);
            $obCCGroups->save(false);
        }
        catch(\Exception $e){
            Yii::trace($e->getMessage(), 'flower');
        }
    }


    public static function getClientsByNameOrPhone($query)
    {
        $arClients = [];

        if( !empty($query) ){
            $obClients = Clients::find();

            if( (int)$query > 0 && strlen($query) == 4 ){
                $arClients = $obClients
                    ->where(['like', 'PHONE', substr($query, 0, 2) . '-' . substr($query, 2, 2)])
                    ->select([
                        'ID',
                        'NAME',
                        'PHONE',
                    ])
                    ->asArray()
                    ->all();
            }
            else{
                $arClients = $obClients
                    ->andFilterWhere(['like', 'clients.NAME', "$query"])->asArray()->all();
            }
        }

        return $arClients;
    }


    /**
     * Getting client discount
     *
     * @param $userId
     *
     * @return array
     */
    public static function getClientDiscounts($userId)
    {
        $arDiscounts = [
            'DISCOUNT' => 0,
            'BONUS' => 0,
        ];
        if( !empty($userId) ){
            $obClients = new Clients();
            $arUser = $obClients->find()->where([
                'ID' => $userId
            ])->with(['clientsClientsGroups', 'clientsClientsGroups.clientsGroups', 'clientsClientsGroups.clientsGroups.loyaltyPrograms'])->asArray()->one();

            $val = $arUser['clientsClientsGroups']['clientsGroups']['PERCENT'];

            $arDiscounts['USER_NAME'] = $arUser['NAME'];
            if( $arUser['clientsClientsGroups']['clientsGroups']['loyaltyPrograms']['CODE'] == 'BONUS' ){
                $arDiscounts['BONUS'] = $val;
                $arDiscounts['CLIENT_BONUS'] = !empty($arUser['BONUS']) ? $arUser['BONUS'] : 0;
                $arDiscounts['MAX_DISCOUNT'] = $arUser['clientsClientsGroups']['clientsGroups']['loyaltyPrograms']['MAX_PERCENT'];
            }
            else{
                $arDiscounts['DISCOUNT'] = $val;
            }
        }
        
        return $arDiscounts;
    }


	/**
	 * Add Events bonuses
	 *
	 * @param $bonus
	 */
	public function addEventsBonuses($bonus)
	{
		$arEvents = ClientsEvents::find()
			->where(['EVENT_DATE' => date('Y-m-d', strtotime('+1 day'))])
			->select(['CLIENT_ID'])
			->asArray()
			->all();

		$arClients = array_unique(array_column($arEvents, 'CLIENT_ID'));
		Clients::updateAllCounters(['BONUS' => $bonus], 'ID IN (' . implode(',', $arClients) . ')');
	}


	/**
	 * Remove bonuses
	 *
	 * @param $bonus
	 */
	public function removeEventsBonuses($bonus)
	{
		$arEvents = ClientsEvents::find()
			->where(['EVENT_DATE' => date('Y-m-d', strtotime('-7 days'))])
			->select(['CLIENT_ID'])
			->asArray()
			->all();

		$arClients = array_unique(array_column($arEvents, 'CLIENT_ID'));
		Clients::updateAllCounters(['BONUS' => (-1 * intval($bonus))], 'ID IN (' . implode(',', $arClients) . ')');
	}
}
