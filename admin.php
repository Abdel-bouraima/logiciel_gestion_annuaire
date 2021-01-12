<?php
session_start();
$bdd = new PDO('mysql:host=localhost;dbname=annuaire;charset=utf8', 'root', '');

if(isset($_GET['id']))
{
	$getid= htmlspecialchars($_GET['id']);
	$q=$bdd->prepare('SELECT * FROM ADMIN WHERE Login=?');
	$q->execute(array($getid));
	$info = $q->fetch();

?>

<html>
<head>
	<meta charset="utf-8">
	<title>Espace administration</title>
	<link rel="stylesheet" type="text/css" href="CSS/style.css">
	<meta name="viewport" content="width=device-width,initial-scale= 1.0">
	<style type="text/css">
	    li{ list-style-type: none; }
		li.liste:before { content: "\A4\ ";}
		nav.autre a { color: #021b2c; }
	</style>
</head>
<body>
<div style="text-align: center;">
	<?php include"Include/header.html" ?>

	<p>
		Bienvenue Administrateur <span style="color:#0F1424;">'<?= $_SESSION['Login'] ;  ?>'</span>
	</p>
	<div>
	<h2>Administration</h2>
	<nav>
 		<ul>
 			<li class="liste">
 				<a href="admin_personnel.php">Gestion du personnel </a><br><br>
 			</li>
 			<li class="liste">
 				<a href="admin_actualite.php">Gestion des actualités</a><br><br>
 			</li>
 			<li class="liste">
 				<a href="admin_entite.php">Gestion des entités</a><br><br>
 			</li>
 			<li class="liste">
 				<a href="admin_service.php">Gestion des services</a><br><br>
 			</li>
 			<li class="liste">
 				<a href="admin_bureau.php">Gestion des bureaux</a><br><br>
 			</li>
 			<li class="liste">
 				<a href="affectation.php">Gestion des affectations</a><br><br>
 			</li>
 		</ul>
 	</nav>
 	<br>
 	</div>
 	<?php  
 		if($info['Login']==$_SESSION['Login'])
 		{
 			?>
 		

 	<ol>
 		<li>
 			<a href="admin_page.php">
 			Modifier vos paramètres de connexion <i class="fa fa-cog" aria-hidden="true"></i>

 			</a>
 		</li>
 	</ol>
<?php } ?>
</div>
<?php include"Include/footer.html" ?>  
</body>
</html>

<?php
}
else
{
	//Permet de toujours etre rediriger vers la page d'authentification si la variable "Login" n'existe pas
	//Ici, pour sécuriser l'application il vaut écrire header('Location:authentification_admin.php'); mais dans le cas ou il y aurait un dashboord qui permettrait de naviguer dans le back-end
	header('Location:authentification_admin.php');
}
?>