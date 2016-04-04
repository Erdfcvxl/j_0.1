<?php

namespace frontend\models;

use Yii;
use yii\data\ActiveDataProvider;

/**
 * This is the model class for table "favourites".
 *
 * @property integer $id
 * @property integer $u_id
 * @property integer $favs_id
 */
class Favourites extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'favourites';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['u_id', 'favs_id'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'u_id' => 'U ID',
            'favs_id' => 'Favs ID',
        ];
    }

    public static function arFavoritas($id)
    {
        $fav = ($temp = Favourites::find()->select('favs_id')->where(['u_id' => Yii::$app->user->id])->one())? $temp->favs_id : '';

        $favs_id = explode(' ', $fav);

        return array_search($id, $favs_id) !== false;
    }

    public static function manoFavourites()
    {
        $favs = Favourites::find()->where(['u_id' => Yii::$app->user->id])->one();

        $id = (isset($favs->favs_id))? explode(' ', $favs->favs_id) : 'nera';

        $provider = new ActiveDataProvider([
            'query' => UserPack::find()->where(['id' => $id]),
            'sort' => [
                'defaultOrder' => [
                    'username' => SORT_DESC,
                ]
            ],
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);

        return $provider;
    }    

    public static function maneMegsta()
    {
        $favs = Favourites::find()->all();
        $id = array();

        foreach ($favs as $model) {
            $favourited = explode(' ', $model->favs_id);

            if(array_search(Yii::$app->user->id, $favourited) !== false){
                $id[] = $model->u_id;
            }
        }

        $provider = new ActiveDataProvider([
            'query' => UserPack::find()->where(['id' => $id]),
            'sort' => [
                'defaultOrder' => [
                    'username' => SORT_DESC,
                ]
            ],
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);

        return $provider;
    }

    public static function isNew()
    {
        if($favs = Favourites::find()->where(['u_id' => Yii::$app->user->id])->andWhere(['>','new',0])->one()){
            return $favs->new;
        }else{
            return null;
        }        
    }

}
