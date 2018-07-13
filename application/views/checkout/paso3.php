 <!DOCTYPE html>
<html>
<head>

<!--Import Google Icon Font-->
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>

<!-- JAVASCRIPT -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<!-- Compiled and minified CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-rc.2/css/materialize.min.css">

<!-- Compiled and minified JavaScript -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-rc.2/js/materialize.min.js"></script>


</head>

<body>
<div class="container">
	<h1>III</h1>

	<div class="row">
		<?php echo $Monto_Total; ?>
	</div>
	
	<div class="row">
	PAGAR:
	<a href="<?php echo $preference['response']['init_point']; ?>">MERCADOPAGO</a>	
	</div>
	
	<div class="row">
 			<?php if($NoWebplay == true): ?>
			<span>WebPay no disponible</span>
			<?php endif; ?>

			<?php if (strlen($next_page)) { ?>
			PAGAR: 
			<form action="<?php echo $next_page; ?>" method="post">
				<input type="hidden" name="token_ws" value="<?php echo ($token); ?>">
				<input type="submit" value="Webpay">
			</form>
			<?php } ?>
	</div>
	

</div>
</body>
</html>
