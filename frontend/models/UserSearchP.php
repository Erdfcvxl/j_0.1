<?php
namespace frontend\models;

use Yii;
use frontend\models\UserPack;
use frontend\models\Chat;
use yii\data\ActiveDataProvider;
use yii\db\Query;

class UserSearchP extends UserPack
{
	public function searchPokalbiai($params = null)
	{
		$me = Yii::$app->user->id;

		$this->load($params);
		$this->username = ($this->username)? $this->username : '';

		$chat = new Chat;
		$whochats = Chat::whochats();

		$select = ['u.id', 'u.username', 'u.avatar', 'u.lastOnline', 'i.iesko', 'i.diena', 'i.menuo', 'i.metai', 'i.miestas', 'MAX(c.timestamp)', 'c.sender', 'c.reciever'];


		$query = new Query;
        $query->select($select)
            ->from('user AS u')
            ->join('LEFT JOIN', 'info AS i', 'u.id = i.u_id')
            ->join('INNER JOIN', 'chat AS c', '(u.id = c.sender AND c.reciever = '.$me.') OR (u.id = c.reciever AND c.sender = '.$me.')')
            ->orderBy(['MAX(c.timestamp)'=>SORT_DESC])
            ->groupBy(['u.id'])
            ;

		$dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 7,
            ]
        ]);

        $query->filterWhere(['like', 'u.username', $this->username])
            ->andFilterWhere(['u.id' => $whochats]);

        return $dataProvider;
	}
}

?>