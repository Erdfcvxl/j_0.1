<?php

namespace frontend\models;

use Yii;
use yii\data\ActiveDataProvider;

/**
 * This is the model class for table "profileview".
 *
 * @property integer $id
 * @property integer $ziuretojas
 * @property integer $ziurimasis
 * @property integer $kartas
 * @property integer $timestamp
 */
class Profileview extends \yii\db\ActiveRecord
{
    public $username;
    public $avatar;
    public $lastOnline;
    public $gimimoTS;
    public $miestas;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'profileview';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ziuretojas', 'ziurimasis', 'kartas', 'timestamp'], 'required'],
            [['ziuretojas', 'ziurimasis', 'kartas', 'timestamp'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ziuretojas' => 'Ziuretojas',
            'ziurimasis' => 'Ziurimasis',
            'kartas' => 'Kartas',
            'timestamp' => 'Timestamp',
        ];
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'ziuretojas']);
    }

    public function getInfo2()
    {
        return $this->hasOne(Info::className(), ['u_id' => 'ziuretojas']);
    }

    public function addView($u)
    {
        if($record = self::find()->where(['ziuretojas' => Yii::$app->user->id])->andWhere(['ziurimasis' => $u])->one()){
            //jei praejo 10min nuo preitos perziuros, duodam perziura
            if(time() - $record->timestamp > 600){
                $record->kartas += 1;
                $record->timestamp = time();
                $record->save();
                Statistics::addView($u);
            }
            
        }else{
            $model = new self;
            $model->ziuretojas = Yii::$app->user->id;
            $model->ziurimasis = $u;
            $model->kartas = 1;
            $model->timestamp = time();
            $model->insert();

            Statistics::addView($u);
        }
    }

    public function getViewers()
    {
        $query = Profileview::find()
            ->select('profileview.ziuretojas, profileview.timestamp, user.username, user.id, user.avatar, user.lastOnline, info.gimimoTS, info.miestas')
            ->joinWith('user')
            ->joinWith('info2')
            ->where(['ziurimasis' => Yii::$app->user->id])
            ->andWhere(['not', ['ziuretojas' => Yii::$app->user->id]]);


        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['timestamp'=>SORT_DESC]],
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        return $dataProvider;
    }
}
