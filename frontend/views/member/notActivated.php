<?php
use yii\helpers\Url;
use yii\widgets\ActiveForm;

@extract($_GET);

?>

<div class="alert alert-warning" style="text-align: left;">
	<h3>Jūsų el. paštas<small>(<?= $user->email; ?>)</small> nėra aktyvuotas. </h3>
	<p>
		Prašome pasitikrinti savo pašto dėžutę ir aktyvuoti savo paskyrą.
	</p>

	<br>

	<p>
		<small>
			Po registracijos laišką turėtumėte gauti per 10 minučių. Jei negavote laiško:  
		</small>
	</p>

	<br><br>
	<h4>Veiksmai</h4>

	<?php if(isset($psl)): ?>
		<p>
			
			<form method="post">
				El. paštas:
				<input type="text" name="email" value="<?= $user->email; ?>" class="form-control" style="display: inline-block; width : 40%;">
				<p style="color: #a94442;"><?= isset($error['email']) ? $error['email'] : ''; ?></p>
				<input type="submit" value="Keisti" class="btn btn-success" style="position:relative; top :-3px;">
			</form>
		</p>

		<br>
	<?php endif; ?>

	<p>
		<a class="btn btn-primary btn-sm" href="<?= Url::current(['psl' => 'rs']); ?>">Siųsti laišką iš naujo</a> 
		<a class="btn btn-primary btn-sm" href="<?= Url::current(['psl' => 'ch']); ?>">Keisti el. pašto adresą</a>
	</p>
</div>