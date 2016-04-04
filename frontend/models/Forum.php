<?php

namespace frontend\models;

use Yii;
use yii\data\ActiveDataProvider;

/**
 * This is the model class for table "forum".
 *
 * @property integer $id
 * @property integer $u_id
 * @property string $name
 * @property string $extra_info
 * @property integer $views
 */
class Forum extends \yii\db\ActiveRecord
{

    public $posts;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'forum';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['u_id', 'views'], 'safe'],
            [['u_id', 'views'], 'integer'],
            [['name', 'extra_info'], 'string'],
            [['name', 'extra_info'], 'required', 'message' => 'Šis laukelis negali būti tuščias']
        ];
    }

    /**
     * @inheritdoc
     */

    static public function sort_two(&$comments, $props)
    {
        usort($comments, function($a, $b) use ($props) {
            if($a->$props[0] == $b->$props[0])
                return $a->$props[1] < $b->$props[1] ? 1 : -1;
            return $a->$props[0] < $b->$props[0] ? 1 : -1;
        });
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'u_id' => 'U ID',
            'name' => 'Name',
            'extra_info' => 'Extra Info',
            'views' => 'Views',
        ];
    }

    static public function getSections($param) //'top', new, check, mine, drg
    {
        $models = Forum::find()->all();

        if($param == ""){
            

            foreach ($models as $model) {
               $modelPost = Post::find()->where(['forum_id' => $model->id])->all();

               $model->posts = count($modelPost);

            }

            Forum::sort_two($models,array("posts","views"));     

        }elseif($param == "new"){
            $models = Forum::find()->orderBy(['id'=>SORT_DESC])->all();
        
        }elseif($param == "check"){
            if($modelCheck = CheckedForums::find()->where(['u_id' => Yii::$app->user->id])->one()){

                $ids = explode(' ', $modelCheck->forum_ids);

                $models = Forum::find()->where(['id' => $ids])->all();
            }else{
                $models = Forum::find()->where(['id' => 'nera'])->all();
            }
        
        }elseif($param == "mine"){
            $models = Forum::find()->where(['u_id' => Yii::$app->user->id])->all();
        
        }elseif($param == "drg"){
            if($modelFriends = Friends::find()->where(['u_id' => Yii::$app->user->id])->one()){
                $ids = explode(' ', $modelFriends->friends);
            }else{
                $ids = "nera";
            }

            

            $models = Forum::find()->where(['u_id' => $ids])->all();
        }


        $i = 0;

        $sections = array();
        $sections['left'] = array();
           $sections['right'] = array();

           foreach ($models as $model) {
               if($i == 0){
                   $sections['left'][] = $model;
                   $i++; 
               }else{
                   $sections['right'][] = $model; 
                   $i = 0;
            }
        }

        return($sections);
    }

    public function addView()
    {
        $this->views++;
        $this->save();
    }

    public function kurti()
    {
        $model = new Forum;
        $modelPost = new Post;

        if($this->validate()){
            $model->name = $this->name;
            $model->extra_info = "|newForum|".$this->extra_info;
            $model->u_id = Yii::$app->user->id;
            $model->timestamp = time();
            $model->save();

            $modelPost->forum_id = $model->id;
            $modelPost->u_id = Yii::$app->user->id;
            $modelPost->text = $this->extra_info;
            $modelPost->timestamp = time();
            $modelPost->save();

            return $model->id;
        }

        return false;
    }
}
