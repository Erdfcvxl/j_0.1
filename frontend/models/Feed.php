<?php

namespace frontend\models;

use Yii;
use yii\data\ActiveDataProvider;
use frontend\models\Favourites;
use frontend\models\Friends;

/**
 * This is the model class for table "feed".
 *
 * @property integer $id
 * @property integer $u_id
 * @property integer $action
 * @property integer $info
 * @property integer $timestamp
 */
class Feed extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'feed';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['u_id', 'action', 'info', 'timestamp'], 'safe']
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
            'action' => 'Action',
            'info' => 'Info',
            'timestamp' => 'Timestamp',
        ];
    }

    public static function tapoDraugais($user1, $user2)
    {
        $feed = new Feed;

        $feed->u_id = $user1;
        $feed->action = "tapoDraugais";
        $feed->info = $user2;
        $feed->timestamp = time();
        $feed->insert();


        $feed = new Feed;

        $feed->u_id = $user2;
        $feed->action = "tapoDraugais";
        $feed->info = $user1;
        $feed->timestamp = time();
        $feed->insert();
        
        return true;
    }

    public static function pakeitePPic($user)
    {
        $feed = new Feed;

        $feed->u_id = $user;
        $feed->action = "pakeitePPic";
        $feed->timestamp = time();
        $feed->insert();
        
        return true;
    }

    public static function newFoto($user, $filename, $filedir)
    {
        $feed = new Feed;

        $feed->u_id = $user;
        $feed->action = "newFoto";
        $feed->info = $filename." ".$filedir;
        $feed->timestamp = time();
        $feed->insert();
        
        return true;
    }

    public static function newAlbum($user, $albumName)
    {
        $feed = new Feed;

        $feed->u_id = $user;
        $feed->action = "newAlbum";
        $feed->info = $albumName;
        $feed->timestamp = time();
        $feed->insert();
        
        return true;
    }

    public static function pakeiteZodi($user)
    {
        $feed = new Feed;

        $feed->u_id = $user;
        $feed->action = "pakeiteZodi";
        $feed->timestamp = time();
        $feed->insert();
        
        return true;
    }

    public static function favsFeed()
    {
        $fav = ($temp = Favourites::find()->where(['u_id' => Yii::$app->user->id])->one())? $temp->favs_id : '';

        $favs_id = explode(' ', $fav);


        $friends = ($temp = Friends::find()->where(['u_id' => Yii::$app->user->id])->one())? $temp->friends : '';

        $friends_id = explode(' ', $friends);


        $naujokai = ($temp = Feed::find('u_id')->where(['action' => 'newUser'])->andWhere(['not', ['u_id' => Yii::$app->user->id]])->all())? $temp : array();

        $naujokaiId = array();
        foreach ($naujokai as $model) {
            $naujokaiId[] = $model->id;
        }


        $full = array_merge($favs_id, $friends_id);

        if(($key = array_search(Yii::$app->user->id, $full)) !== false) {
            unset($full[$key]);
        }


        $draugaiSuSavimi = Feed::find()->where(['and', ['info' => Yii::$app->user->id, 'action' => 'tapoDraugais']])->all();

        $suSavimId = array();
        foreach ($draugaiSuSavimi as $model) {
            $suSavimId[] = $model->id;
        }

        $provider = new ActiveDataProvider([
            'query' => Feed::find()->where(['u_id' => $full])->andWhere(['not', ['id' => $suSavimId]])->orWhere(['id' => $naujokaiId]),
            'sort' => [
                'defaultOrder' => [
                    'timestamp' => SORT_DESC,
                ]
            ],
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);
        
        return $provider;
    }

    public static function noobies()
    {
        $ieskau = (substr(Yii::$app->user->identity->info->iesko, 1) == "m")? ['mm', 'mv'] : ['vv', 'vm'];

        $query = UserPack::find()->joinWith('info');//->andWhere(['activated' => 1]);

        $provider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC,
                ]
            ],
            'pagination' => [
                'pageSize' =>18,
            ],
        ]);

        $query->filterWhere(['info.iesko' => $ieskau]);

        if(isset($_GET['vip']) && $_GET['vip'])
            $query->andFilterWhere(['vip' => 1]);

        if(isset($_GET['on']) && $_GET['on'])
            $query->andFilterWhere(['>=', 'lastOnline', time() - 600]);
        
        return $provider;
    }

    public static function friendsFeed()
    {
        $friends = ($temp = Friends::find()->where(['u_id' => Yii::$app->user->id])->one())? $temp->friends : '';

        $friends_id = explode(' ', $friends);


        $draugaiSuSavimi = Feed::find()->where(['and', ['info' => Yii::$app->user->id, 'action' => 'tapoDraugais']])->all();

        $suSavimId = array();
        foreach ($draugaiSuSavimi as $model) {
            $suSavimId[] = $model->id;
        }

        $provider = new ActiveDataProvider([
            'query' => Feed::find()->where(['u_id' => $friends_id])->andWhere(['not', ['id' => $suSavimId]]),
            'sort' => [
                'defaultOrder' => [
                    'timestamp' => SORT_DESC,
                ]
            ],
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);
        
        return $provider;
    }

    public static function editAnketa($user)
    {
        $feed = new Feed;

        $feed->u_id = $user;
        $feed->action = "editAnketa";
        $feed->timestamp = time();
        $feed->insert();
        
        return true;
    }

    public static function editIesko($user)
    {
        $feed = new Feed;

        $feed->u_id = $user;
        $feed->action = "editIesko";
        $feed->timestamp = time();
        $feed->insert();
        
        return true;
    }
}
