<?php 
	try
{
    $db = new PDO('mysql:host=localhost;dbname=annuaire;charset=utf8', 'root', '');
}
catch(Exception $e)
{
        die('Erreur : '.$e->getMessage());
}

	$req = $db->query('SELECT Matricule FROM PERSONNE');

	$nbre_total_articles = $req->rowCount();

	$nbre_articles_par_page = 10;

	$nbre_pages_max_gauche_et_droite = 4;

	$last_page = ceil($nbre_total_articles / $nbre_articles_par_page);

	if(isset($_GET['page']) && is_numeric($_GET['page'])){
		$page_num = $_GET['page'];
	} else {
		$page_num = 1;
	}

	if($page_num < 1){
		$page_num = 1;
	} else if($page_num > $last_page) {
		$page_num = $last_page;
	}

	$limit = 'LIMIT '.($page_num - 1) * $nbre_articles_par_page. ',' . $nbre_articles_par_page;

	//Cette requête sera utilisée plus tard
	$sql = "SELECT * FROM PERSONNE ORDER BY Nom ASC $limit";

	$pagination = '';

	if($last_page != 1){
		if($page_num > 1){
			$previous = $page_num - 1;
			$pagination .= '<a href="annuaire.php?page='.$previous.'">Précédent</a> &nbsp;';

			for($i = $page_num - $nbre_pages_max_gauche_et_droite; $i < $page_num; $i++){
				if($i > 0){
					$pagination .= '<a href="annuaire.php?page='.$i.'">'.$i.'</a> &nbsp;';
				}
			}
		}

		$pagination .= '<span class="active">'.$page_num.'</span>&nbsp;';

		for($i = $page_num+1; $i <= $last_page; $i++){
			$pagination .= '<a href="annuaire.php?page='.$i.'">'.$i.'</a> ';
			
			if($i >= $page_num + $nbre_pages_max_gauche_et_droite){
				break;
			}
		}

		if($page_num != $last_page){
			$next = $page_num + 1;
			$pagination .= '<a href="annuaire.php?page='.$next.'">Suivant</a> ';
		}
	}

	$req = 'SELECT COUNT(*) AS nb FROM PERSONNE';
    $result = $db->query($req);
    $columns = $result->fetch();
    $nb = $columns['nb'];
?> 

<html>
<head>
	<meta charset="utf-8">
	<title>Tout le personnel</title>
	<link rel="stylesheet" type="text/css" href="CSS/style.css">
	<link rel="stylesheet" href="CSS/font-awesome.min.css">
	<meta name="viewport" content="width=device-width,initial-scale= 1.0">
	<style>
		body
		{
			font-family: "Trebuchet MS", Arial, sans-serif;
		}

		/*a:visited{
			color: #2E4053;
		}*/

		#pagination{
			/*background-color: #eaeaea;*/
			padding: 10px;
			border: 0px solid #DDDDDD;
			text-align: right;
			font-size: 25px;
		}

		#pagination .active{
			background-color: #337AB7;
			color: #FFF;
			/*padding: 0px 5px 0px 5px;*/
			border-radius: 20%;
			font-size: 25px;
		}

		</style>
	</head>
	<body class="animated jello">
		<div style="text-align: center;">
	<?php include"Include/header.html" ?>
	<h2>Annuaire</h2>
	<p>
		<strong>Tout le personnel de l'Université d'Abomey-calavi</strong>
		<br> <br>
	<?php 	
	if(isset($nb))
		{
			echo"Nous avons ".$nb." personnes enregistrées dans l'annuaire";
		}
	$req = $db->query($sql);
	?>
	<ul>
		<?php while($data = $req->fetch()){ ?>
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
	<?php

		echo '<div id="pagination">'.$pagination.'</div>';
		$req->closeCursor();
		?>
<br>
		<?php include"Include/footer.html" ?>
	</body>
</html>