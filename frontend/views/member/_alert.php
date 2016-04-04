<div id="myAlert<?= $id; ?>" class="myAlert">
	<div class="container-fluid" >

		<div id="xas<?= $id; ?>" style="position: absolute; right: 1px; top: 1px; color: #A8A8A8; cursor: pointer;" class="glyphicon glyphicon-remove"></div>


		<div class="row" style="margin-bottom: 15px;">

			<div class="col-xs-12">
				<?php if($model == 'susirasinejimas'): ?>
					<b>Ar tikrai norite ištrinti susirašinėjimą?</b>
				<?php endif; ?>
			</div>

		</div>

		<div class="row">
			<a href="<?= $del; ?>"><div class="col-xs-3 col-xs-offset-2 mygtukas">Taip</div></a>
			<a href="#" id="isjunkmane<?= $id; ?>" onclick="isjunkmane(<?= $id; ?>);"><div class="col-xs-3 col-xs-offset-2 mygtukas">Ne</div></a>
		</div>

	</div>
</div>

<script type="text/javascript">

	$('#xas<?= $id; ?>').click(function (){
		isjunkmane(<?= $id; ?>);
	});

	function isjunkmane(id)
	{
		$('#myAlert'+id).fadeOut();
	}

</script>

