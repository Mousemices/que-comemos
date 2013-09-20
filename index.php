<?php
session_start();

$_SESSION['errorLogin'] = false;

$userinfo = array(
                'admin'=>'21232f297a57a5a743894a0e4a801fc3', //admin
                'admin2'=>'21232f297a57a5a743894a0e4a801fc3' //admin
                );

if(isset($_GET['logout'])) {
    $_SESSION['username'] = '';
}

if(isset($_POST['username'])) {
	//recuerda: @ para no mostrar elNotice si da no encuentra la userinfo
    if(@$userinfo[$_POST['username']] == md5($_POST['password'])) {
        $_SESSION['username'] = $_POST['username'];
    } else {
        //Invalid Login
        $_SESSION['errorLogin'] = true;
    }
}
?>
<!doctype html>
<html lang="es">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Qué comemos esta semana?</title>
<meta name="description" content="" />
<meta name="keywords" content="" />
<link rel="shortcut icon" href="assets/img/favicon.ico" type="image/x-icon" /> 
<link rel="apple-touch-icon" href="assets/img/apple-touch-icon-iphone.png" />
<link rel="apple-touch-icon" sizes="72x72" href="assets/img/apple-touch-icon-ipad.png" />
<link rel="apple-touch-icon" sizes="114x114" href="assets/images/ico/apple-touch-icon-iphone4.png" />
<link rel="stylesheet" href="assets/css/bootstrap.min.css" />
<link rel="stylesheet" href="assets/css/bootstrap-responsive.min.css" />
<link rel="stylesheet" href="assets/css/style.css" />
<link rel="stylesheet" href="assets/css/print.css" media="print" />
<!--ANGULARJS: -->
<script type="text/javascript" src="assets/js/angular.min.js"></script>
<script type="text/javascript" src="assets/js/jquery-2.0.3.min.js"></script>
<script type="text/javascript" src="assets/js/bootstrap.min.js"></script>
<script type="text/javascript" src="assets/js/general.js"></script>
<script type="text/javascript" src="assets/angular-app/app.js"></script>
<script type="text/javascript" src="assets/angular-app/controllers/recipesController.js"></script>
<link rel="stylesheet" href="assets/css/add2home.css" />
<script src="assets/js/add2home.js"></script>
</head>
<body ng-app="queComemosApp" ng-controller="recipesController" ng-init="init()">

<div class="navbar">
	<div class="navbar-inner">
		<ul class="nav">
			<li>
				<a href="#shoppingListModal" class="" data-toggle="modal" title="Ver toda la lista dela compra" ng-click="shoppingList();"><i class="icon-list icon-white"></i> Tu lista de la compra</a>
			</li>
		</ul>
		<ul class="nav pull-right">
			<?php if($_SESSION['username']): ?>
            	<li class="dropdown">
            		<a href="#" class="dropdown-toggle" data-toggle="dropdown">
            			<i class="icon-user icon-white"></i> <?=$_SESSION['username']?> <b class="caret icon-white"></b>
            		</a>
            		<ul class="dropdown-menu">
            			<li>
							<a href="#addRecipeModal" class="" data-toggle="modal" title="Añadir una receta nueva" ng-click="addRecipe();"><i class="icon-plus"></i> Añade una nueva receta</a>
						</li>
            			<li><a href="?logout=1"><i class="icon-lock"></i> Logout</a></li>
            		</ul>
            	</li>
            <?php else: ?>
            	<li>
            		<a href="#loginModal" data-toggle="modal">
            			<i class="icon-user icon-white"></i> Haz login
            		</a>
            	</li>
            <?php endif; ?>
		</ul>
	</div>
</div>
    
<div class="container-fluid">
	
	<div class="content row-fluid">
	
		<?php if($_SESSION['errorLogin']): ?>
		
			    <div class="alert alert-error">
			    	<button type="button" class="close" data-dismiss="alert">&times;</button>
			    	Error de login: la combinación usuario/contraseña no es correcta.
    			</div>
		
		<?php endif; ?>
	
		<div class="span12 tableWeekPlan mln" ng-show="weekSchedule != ''">
			<h1>Esta semana comemos:</h1>
			<table class="table table-bordered">
				<thead>
					<tr>
						<th>Lunes</th>
						<th>Martes</th>
						<th>Miércoles</th>
						<th>Jueves</th>
						<th>Viernes</th>
						<th class="weekend">Sábado</th>
						<th class="weekend">Domingo</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td ng-repeat="recipe in weekSchedule">
							<a href="#ingredientsModal" title="Ver los ingredientes"  data-toggle="modal" ng-click="showIngredients(recipe.id);">{{recipe.name}}</a>
						</td>
					</tr>
				</tbody>
			</table>
		</div><!--span8-->
	
		<div class="mainButton span12 mln">
			 <button class="btn btn-large btn-primary" type="button" ng-click="randIt();">
			 	<span ng-show="weekSchedule == ''">Qué comemos esta semana?</span>
			 	<span ng-show="weekSchedule != ''">Mmm, no me apetece. Dame otra propuesta!</span>
			 </button>
		</div>
		
		<div class="span12 tableResults mln">
			<table class="table table-bordered">
				<thead>
					<tr>
						<th>Lunes</th>
						<th>Martes</th>
						<th>Miércoles</th>
						<th>Jueves</th>
						<th>Viernes</th>
						<th class="weekend">Sábado</th>
						<th class="weekend">Domingo</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td ng-repeat="recipe in recipesChoosen" ng-class="{weekend : $index==(5 && 6)}">
							<a href="#ingredientsModal" title="Ver los ingredientes" data-toggle="modal" ng-click="showIngredients(recipe.id);">{{recipe.name}}</a>
						</td>
					</tr>
				</tbody>
			</table>
		</div><!--span8-->
		
		<?php if($_SESSION['username']): ?>
		
			<div class="captureButton mln">
				 <button class="btn btn-success" type="button" ng-click="storeIt();">Me gusta! guárdala</button>
			</div>
			
		<?php endif; ?>

			
	</div><!--content-->
	
	<div id="shoppingListModal" class="modal hide fade">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			<h3>Ingredientes para la lista de la compra semanal:</h3>
		</div>
		<div class="modal-body">
			<ul>
				<li ng-repeat="ingredient in shoppingListIngredients">{{ingredient}}</li>
			</ul>
		</div>
		 <div class="modal-footer">
			 <p class="text-center"><a href="javascript:window.print()"><i class="icon-print"></i> Imprimir la lista</a></p>
		 </div>
	</div>
	
	<div id="ingredientsModal" class="modal hide fade">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			<h3>Ingredientes de {{recipeName}}:</h3>
		</div>
		<div class="modal-body">
			<ul>
				<li ng-repeat="ingredient in ingredients">{{ingredient}}</li>
			</ul>
		</div>
	</div>
	
	<div id="addRecipeModal" class="modal hide fade">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			<h3>Añade una nueva receta:</h3>
		</div>
		<div class="modal-body">
			    <form method="post" action="assets/angular-app/controllers/addRecipe.php">
				    <fieldset>
					    <p><input type="text" class="input-block-level" placeholder="Nombre de la receta" name="name" /></p>
					    <p><input type="text" class="input-block-level" placeholder="Etiqueta (pej. arroz, pasta...)" name="tag" /></p>
					    <p><textarea class="input-block-level" placeholder="Ingredientes (separados por coma)" name="ingredients"></textarea></p>
					    <input type="hidden" value="{{lastRecipeId}}" name="lastRecipeId" />
					    <p><button type="submit" class="btn  btn-success">Hecho!</button></p>
				    </fieldset>
				</form>
		</div>
	</div>
	
	<div id="loginModal" class="modal hide fade">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			<h3>Introduce la contraseña:</h3>
		</div>
		<div class="modal-body">
			    <form method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>">
				    <fieldset>
					    <p><input type="text" class="input-block-level" placeholder="Usuario" name="username" /></p>
					    <p><input type="password" class="input-block-level" placeholder="Contraseña" name="password" /></p>
					    <p><button type="submit" class="btn  btn-success">Enviar</button></p>
				    </fieldset>
				</form>
		</div>
	</div>
	
</div><!--container-fluid-->

<footer class="footer">
	<p><a href="http://www.albertofortes.com" title="Programador front end JavaScript, HTML 5, CSS 3">Alberto Fortes</a>, 2013</p>
	<p>Qué comemos está hecho con Bootstrap 2 from Twitter, jQuery, AngularJS y PHP 5. Puedes descargarlo desde <a href="https://github.com/albertofortes/que-comemos" title="Proyectos de Alberto Fortes en Github">Github.</p>
</footer>

</body>
</html>