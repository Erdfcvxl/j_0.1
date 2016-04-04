
<?php if(Yii::$app->user->identity->attributes['blocked']): ?>
<div class="alert alert-danger" style="text-align: left; position: relative; top: -75px; padding-bottom: 120px;">
	<h3><span class="glyphicon glyphicon-remove-sign"></span> Jūs esate blokuotas!</h3>
	<hr>
	<p class="lead">
		<b>Priežastis:</b>
		<?= Yii::$app->user->identity->attributes['blockedInfo'] ?>
	</p>
	<div style="position: absolute; bottom: 0; padding: 20px 0;">
		Susisiekite su mumis <a href="mailto:pagalba@pazintyslietuviams.co.uk" style="text-decoration: underline;">Pagalba</a>, jei turite klausimų ar esate nepatenknti mūsų sprendimu.
		<br>
		<br>
		Pagarbiai Pažintyslietuviams.co.uk komanda
	</div>
</div>
<?php endif; ?>
