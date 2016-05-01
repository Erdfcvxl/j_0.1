<?php

namespace frontend\models;

use Yii;
use yii\data\ActiveDataProvider;
use yii\db\Query;

/**
 * This is the model class for table "statistics".
 *
 * @property integer $u_id
 * @property integer $likes
 * @property integer $msg_sent
 * @property integer $msg_recieved
 * @property integer $actions
 * @property integer $forum
 */
class Statistics extends \yii\db\ActiveRecord
{
    public $record;
    public $id;
    public $Rating;
    public $viewsRating;
    public $popRating;
    public $forumRating;
    public $msgRating;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'statistics';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['u_id', 'likes', 'msg_sent', 'msg_recieved', 'actions', 'forum', 'p'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'u_id' => 'U ID',
            'likes' => 'Likes',
            'msg_sent' => 'Msg Sent',
            'msg_recieved' => 'Msg Recieved',
            'actions' => 'Actions',
            'forum' => 'Forum',
        ];
    }

    public function findRecord($u)
    {
        if($record = self::find()->where(['u_id' => $u])->one())
            return $this->record = $record;
        

        $model = new self;
        $model->u_id = $u;
        $model->insert(false);
        
        return $this->record = $model;
    }

    static public function addView($u)
    {
        $model = new self;
        $model->findRecord($u);

        $model->record->profile_visits += 1;
        $model->record->p += 1;
        $model->record->save(false);

        self::addAction();
    }

    static public function addLike($u)
    {
        $model = new self;
        $model->findRecord($u);

        $model->record->likes += 1;
        $model->record->p += 1;
        $model->record->save(false);

        self::addAction();

    }

    static public function addSent()
    {
        $model = new self;
        $model->findRecord(Yii::$app->user->id);

        $model->record->msg_sent += 1;
        $model->record->save(false);

    }

    static public function addForum($u = null)
    {
        if(!$u)
            $u = Yii::$app->user->id;

        $model = new self;
        $model->findRecord($u);

        $model->record->forum += 1;
        $model->record->actions += 1;
        $model->record->save(false);

    }

    static public function addRecieved($u)
    {
        $model = new self;
        $model->findRecord($u);

        $model->record->msg_recieved += 1;
        $model->record->p += 1;
        $model->record->save(false);

    }

    static public function addAction()
    {
        $model = new self;
        $model->findRecord(Yii::$app->user->id);

        $model->record->actions += 1;
        $model->record->save(false);

    }

    public function setID()
    {
        $this->id = (isset($_GET['id'])) ? $_GET['id'] : Yii::$app->user->id;
    }

    public function overall()
    {
        return [];
    }

    public function overallviews()
    {
        $select = [
            'u_id as id',
            'profile_visits',
            'FIND_IN_SET( profile_visits, (
                SELECT GROUP_CONCAT( profile_visits ORDER BY profile_visits DESC ) 
                FROM statistics )
            ) AS rank',
            'u.avatar',
        ];

        $query = new Query;
        $query->select($select)
            ->from('statistics AS s')
            ->join('LEFT JOIN', 'user AS u', 's.u_id = u.id')
            ->orderBy(['profile_visits'=>SORT_DESC])
            ->limit(3);
        
        return $query->all();
    }

    public function ratings()
    {


        $select = [
            'u_id',
            'profile_visits',
            'FIND_IN_SET( profile_visits, (
                SELECT GROUP_CONCAT( profile_visits ORDER BY profile_visits DESC ) 
                FROM statistics )
            ) AS rank'
        ];

        $query = new Query;
        $query->select($select)
            ->from('statistics AS s')
            ->where(['u_id' => $this->id]);

        $this->viewsRating = ($query->one()['rank'] == 0)? '-' : $query->one()['rank'];

        //////////////////////////////////////////////////////////////

        $select = [
            'u_id',
            'p',
            'FIND_IN_SET( p, (
                SELECT GROUP_CONCAT( p ORDER BY p DESC ) 
                FROM statistics )
            ) AS rank'
        ];

        $query = new Query;
        $query->select($select)
            ->from('statistics AS s')
            ->where(['u_id' => $this->id]);

        $this->popRating = ($query->one()['rank'] == 0)? '-' : $query->one()['rank'];

        ///////////////////////////////////////////////////////////////

        $select = [
            'u_id',
            'forum',
            'FIND_IN_SET( forum, (
                SELECT GROUP_CONCAT( forum ORDER BY forum DESC ) 
                FROM statistics )
            ) AS rank'
        ];

        $query = new Query;
        $query->select($select)
            ->from('statistics AS s')
            ->andWhere(['u_id' => $this->id]);

        $this->forumRating = ($query->one()['forum'] == 0)? '-' : $query->one()['rank'];

        ///////////////////////////////////////////////////////////////

        $select = [
            'u_id',
            '(msg_sent + msg_recieved) as msg',
            'FIND_IN_SET( (msg_sent + msg_recieved), (
                SELECT GROUP_CONCAT( (msg_sent + msg_recieved) ORDER BY (msg_sent + msg_recieved) DESC ) 
                FROM statistics AS s
                LEFT JOIN user AS u
                ON s.u_id = u.id
                WHERE u.f = 0)
            ) AS rank'
        ];

        $query = new Query;
        $query->select($select)
            ->from('statistics AS s')
            ->join('LEFT JOIN', 'user AS u', 's.u_id = u.id')
            ->andWhere(['u_id' => $this->id]);

        $this->msgRating = ($query->one()['rank'] == 0)? '-' : $query->one()['rank'];
    }

    public function viewsToday()
    {
        $select = [
            'sum(kartas) AS kartai',
        ];

        $query = new Query;
        $query->select($select)
            ->from('profileview AS p')
            ->where(['ziurimasis' => Yii::$app->user->id])
            ->andWhere(['between', 'timestamp', strtotime('today midnight'), strtotime('today midnight') + 3600 * 24])
            ->groupBy('ziurimasis');

        return ($query->one()['kartai']) ? $query->one()['kartai'] : 0;
    }

    public function viewsWeek()
    {
        $select = [
            'sum(kartas) AS kartai',
        ];

        $query = new Query;
        $query->select($select)
            ->from('profileview AS p')
            ->where(['ziurimasis' => Yii::$app->user->id])
            ->andWhere(['between', 'timestamp', strtotime('today midnight') - 3600 * 24 * 7, strtotime('today midnight') + 3600 * 24])
            ->groupBy('ziurimasis');

        return ($query->one()['kartai']) ? $query->one()['kartai'] : 0;
    }

    public function viewsMonth()
    {
        $select = [
            'sum(kartas) AS kartai',
        ];

        $query = new Query;
        $query->select($select)
            ->from('profileview AS p')
            ->where(['ziurimasis' => Yii::$app->user->id])
            ->andWhere(['between', 'timestamp', strtotime('today midnight') - 3600 * 24 * 31, strtotime('today midnight') + 3600 * 24])
            ->groupBy('ziurimasis');

        return ($query->one()['kartai']) ? $query->one()['kartai'] : 0;
    }

    public function viewsAll()
    {
        $select = [
            'sum(kartas) AS kartai',
        ];

        $query = new Query;
        $query->select($select)
            ->from('profileview AS p')
            ->where(['ziurimasis' => Yii::$app->user->id])
            ->groupBy('ziurimasis');

        return ($query->one()['kartai']) ? $query->one()['kartai'] : 0;
    }
    
    public function overallpop()
    {
        $select = [
            'u_id as id',
            'p',
            'FIND_IN_SET( p, (
                SELECT GROUP_CONCAT( p ORDER BY p DESC ) 
                FROM statistics )
            ) AS rank',
            'u.avatar',
            'u.id'
        ];

        $query = new Query;
        $query->select($select)
            ->from('statistics AS s')
            ->join('LEFT JOIN', 'user AS u', 's.u_id = u.id')
            ->orderBy(['p'=>SORT_DESC])
            ->limit(3);

        return $query->all();
    }

    public function overallforum()
    {
        $select = [
            'u_id as id',
            'forum',
            'u.avatar',
            'u.id'
        ];

        $query = new Query;
        $query->select($select)
            ->from('statistics AS s')
            ->join('LEFT JOIN', 'user AS u', 's.u_id = u.id')
            ->orderBy(['forum'=>SORT_DESC])
            ->limit(3);

        return $query->all();
    }

    public function openedForums()
    {
        $query = Forum::find()->where(['u_id' => $this->id]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['timestamp'=>SORT_DESC]],
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        return $dataProvider;
    }

    public function atsForums()
    {
        $sql = "SELECT DISTINCT forum_id, u_id, COUNT( forum_id ) as count, timestamp
                FROM `post`
                WHERE u_id = '".$this->id."'
                GROUP BY forum_id
                ORDER BY count DESC";
        $query = Post::findBySql($sql);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            //'sort'=> ['defaultOrder' => ['timestamp'=>SORT_DESC]],
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        return $dataProvider;
    }

    public function postForum()
    {
        $count = Post::find()->where(['u_id' => $this->id])->count();

        return $count;
    }

    public function overallmsg()
    {
        $select = [
            'u_id as id',
            '(msg_sent + msg_recieved) AS msg',
            'u.avatar',
            'u.id'
        ];

        $query = new Query;
        $query->select($select)
            ->from('statistics AS s')
            ->join('LEFT JOIN', 'user AS u', 's.u_id = u.id')
            ->orderBy(['msg'=>SORT_DESC])
            ->where(['u.f' => 0])
            ->limit(3);

        return $query->all();
    }
}
