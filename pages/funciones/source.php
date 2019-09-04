<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Document</title>
</head>


<body>
	
</body>
</html>

<?php
	function encabezadosRespuestas()
	{
		?>
			<div class="col-6 row">															  
			  <div class="col-2">			
				 <h6>Nunca</h6>
			  </div>
			  <div class="col-2">			
				 <h6>Casi nunca</h6>
			  </div>
			  <div class="col-2">			
				 <h6>Algunas veces</h6>
			  </div>
			  <div class="col-2">			
				 <h6>Casi siempre</h6>
			  </div>
			  <div class="col-2">			
				 <h6>Siempre</h6>
			  </div>
			</div>
		<?php
	}
	
	function descripcion($descripcion)
	{
		?>
			<br><br><br><br>
			<div class="col-6 row">
				<p class="card-description col-md-12" style="text-align: justify;font-weight: 1;">
				  <b><?php echo $descripcion; ?></b>
				</p>
			</div>
		<?php
	}
	
	function botonRadio($nameRadio)
	{
		$contador = 1;
		
		?>
			
			<div class="col-6  row" >
			  <?php
				while ($contador <= 5 ){					
					?>
					
					  <div class="col-2">
						<div class="form-radio form-radio-flat" style="" >
						  <label class="form-check-label" >
		
							<input type="radio" class="form-check-input" style="" name="<?php echo $nameRadio; ?>" value="<?php echo $contador; ?>" <?php if ($contador == 1) { echo 'checked';} ?> >
						  </label>
						</div>
					  </div>						
					<?php
					$contador = $contador + 1;
				}
			  ?>
			</div>
		<?php
	}
?>