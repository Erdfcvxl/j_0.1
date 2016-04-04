 <?php
/* 
 *@$message
 *@$sender
 */

use yii\helpers\Html;
use yii\helpers\Url;
use frontend\models\User;

?>

<div class="col-xs-10 trans_box" style="padding: 2px 15px; margin: 1px 0; opacity: <?= $o; ?>;">
    <a href="<?= Url::to(['member/msg', 'id' => $sender]); ?>">
    	<?php
        if(substr($message, 0, 8) == "-%necd%%"){
		    $content = substr($message, 8);
		}else{
		    $content = HTML::encode($message);
		}
		$user = User::find('username')->where(['id' => $sender])->one();

		echo $user->username.": ".$content; 
		?>
    </a>
</div>