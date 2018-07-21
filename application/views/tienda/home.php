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
	
	<nav>
		<div class="nav-wrapper">
			<a href="#" class="brand-logo">Logo</a>
			<ul id="nav-mobile" class="right hide-on-med-and-down">
				<li><a href="<?php echo site_url("tienda/categoria/tecnologia"); ?>">Tecnología</a></li>
				<li><a href="#">Moda</a></li>
				<li><a href="#">Salud y Belleza</a></li>
				<li><a href="#">Libros</a></li>
			</ul>
		</div>
	</nav>


<div class="container">
	<div class="row">
		<div class="col s12 m12">        
			<h3>Home</h3>
		</div>
	</div>
	<div class="row">
	<?php foreach($data AS $key => $row): ?>
		<div class="col s12 m6">			
			<div class="card">
				<div class="card-image">
					<!--
					<img src="images/sample-1.jpg">					
					<span class="card-title">Card Title</span>
					-->
					<a class="btn-floating halfway-fab waves-effect waves-light red"><i class="material-icons">add</i></a>					
				</div>
				<div class="card-content">
					<p><?php echo $row->nombre ?> (<?php echo $row->precio_normal; ?>)</p>
				</div>
			</div>			
		</div>
	<?php endforeach; ?>	
	</div>
</div>

    </body>
  </html>
