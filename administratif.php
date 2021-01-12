<?php
$bdd = new PDO('mysql:host=localhost;dbname=annuaire;charset=utf8', 'root', '');
$requete = $bdd->query('SELECT * FROM Personne WHERE Type="administratif" ORDER BY Nom ASC ');
$req = 'SELECT COUNT(*) AS nb FROM PERSONNE WHERE Type="administratif"';
$result = $bdd->query($req);
$columns = $result->fetch();
$nb = $columns['nb'];
?>

<html>
<head>
	<meta charset="utf-8">
	<title>Personnel Administratif</title>
	<link rel="stylesheet" type="text/css" href="CSS/style.css">
	<meta name="viewport" content="width=device-width,initial-scale= 1.0">
</head>
<body>

	<?php include"Include/header.html" ?>

	<h2>ADMINISTRATIF</h2>
		<div align="center">A ce jour, l'Université d'Abomey-Calavi compte plus de <span class="nombre"><?= $nb  ?> </span>administratifs </div>
			<ul>
				<?php while($data = $requete->fetch()){ ?>
				<li>
					<div id="block">

					<?php 
							echo"<br>";

								if( $data['Photo']=='')
								{
								?>
									<img class="default" src='Photo/default.jpg'  title='Image par défaut'>
								<?php	}
									else
									{
										//La classe pour la photo class="picture"
									?>
									<a href="info_personne.php?id=<?= $data['Matricule'] ?>">
										<img class="picture"  title="Photo de l'employé" src="Photo/<?= $data['Photo']  ?>" >
								    </a>
								<?php } ?>

								<!--<i class="fa fa-user-circle" aria-hidden="true"></i>-->
							<div class="fin">
								<a href="info_personne.php?id=<?= $data['Matricule'] ?>">
									<?= $data['Grade'].' '.$data['Nom'].' '.$data['Prenom'] ?>
								</a>
								<br>
								<?= $data['Email'] ?> <br> <?= $data['Telephone'] ?>
								<br>
							</div>		
					</div>
				</li>
				<?php } ?>
			</ul>

	<?php include"Include/footer.html" ?>  

</body>
</html>