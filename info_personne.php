<?php
try
{
    $bdd = new PDO('mysql:host=localhost;dbname=annuaire;charset=utf8', 'root', '');
}
catch(Exception $e)
{
        die('Erreur : '.$e->getMessage());
}

if(isset($_GET['id']))
{
	$getid= htmlspecialchars($_GET['id']);
	$q=$bdd->prepare('SELECT * FROM PERSONNE WHERE Matricule=?');
	$q->execute(array($getid));
	$info = $q->fetch();

?>


<html>
<head>
	<title>Plus de détails</title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="CSS/style.css">
	<meta name="viewport" content="width=device-width,initial-scale= 1.0">
</head>
<body class="animated rollIn" style='font-family: "Trebuchet MS", Arial, sans-serif;'>
<div align="center">

	<?php include"Include/header.html" ?>
		<h2>Informations supplémentaires</h2>
		<?php 

			if( $info['Photo']=='')
			{
		?>
				<img src='Photo/default.jpg' title='Image par défaut'>
		<?php	}
			else
			{
				//La classe pour la photo class="picture"
			?>
				<a href="Photo/<?= $info['Photo']  ?>" target="_blank">
					<img class="foto" title="Photo de l'employé" src="Photo/<?= $info['Photo']  ?>" >
				</a>
		<?php } ?>
		
		<div class="absolute">
			<?php
				//echo '<div style="float: right;">'.$info['Photo'].'</div>';
				echo 'Nom: '.$info['Nom'].' ';
				echo $info['Prenom'];
				echo'<br>';
				echo 'Adresse: '.$info['Adresse'];
				echo'<br>';
				echo 'Numéro de téléphone: '.$info['Telephone'];
				echo'<br>';
				echo 'Adresse mail: '.$info['Email'];
				echo'<br>';
				echo 'Grade: '.$info['Grade'];
			?>
		</div>
</div>

<?php  }  ?>

<?php include"Include/footer.html" ?>  
</body>
</html>
