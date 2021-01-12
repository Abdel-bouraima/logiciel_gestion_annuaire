<?php
try 
{
    $bdd = new PDO('mysql:host=localhost;dbname=annuaire;charset=utf8','root','');
 
} 
catch(PDOException $e) 
{
    echo 'Erreur PDO : '.$e->getMessage();
}
?>

<?php

	if(isset($_GET['affiche']) AND !empty($_GET['affiche']) AND isset($_GET['key']) AND !empty($_GET['key']) )
	{
		$affiche = htmlspecialchars($_GET['affiche']);
		$key = htmlspecialchars($_GET['key']);
		$q = $bdd->prepare('SELECT * FROM AFFECTER WHERE Matricule=? AND RefService=? ');
		$q->execute(array($affiche,$key));
		$q = $q->fetch();
	}


	if(isset($_POST['modifier']) AND !empty($_POST['modifier']))
	{
		#Pour éviter les injections!!!
 		$matricule=htmlspecialchars($_POST['matricule']);
		$service=htmlspecialchars($_POST['service']);
		$entite=htmlspecialchars($_POST['entite']);
		$poste=htmlspecialchars($_POST['poste']);

		$update= $bdd->prepare('UPDATE AFFECTER SET Matricule = ?,RefService=?,RefEntite=?,Poste=? WHERE Matricule=? AND RefService=?');
		$update->execute(array($matricule,$entite,$service,$poste,$affiche,$key));
		$msg='<i class="fa fa-thumbs-up" aria-hidden="true"></i> Modification effectuée';
	}

	if(isset($_GET['supprime']) AND !empty($_GET['supprime']))
	{
	$supprime = $_GET['supprime'];
	$ref = $_GET['ref'];
	$modif = $bdd->prepare('DELETE FROM AFFECTER WHERE Matricule = ? AND RefService=?');
	$modif->execute(array($supprime,$ref));
	}

	

	if(isset($_POST['ajouter']))
	{
		$matricule=htmlspecialchars($_POST['matricule']);
		$service=htmlspecialchars($_POST['service']);
		$entite=htmlspecialchars($_POST['entite']);
		$poste=htmlspecialchars($_POST['poste']);

		if(!empty($_POST['matricule']) AND !empty($_POST['service']) AND !empty($_POST['entite']) AND !empty($_POST['poste']))
		{
			$search= $bdd->prepare('SELECT * FROM PERSONNE WHERE Matricule = ?');
			$search-> execute(array($matricule));
            $exist = $search->rowCount();
            if($exist != 0)
            {
            	$recherche=$bdd->prepare('SELECT * FROM SERVICE WHERE RefService = ?');
            	$recherche->execute(array($service));
            	$existence = $recherche->rowCount();
            	if($existence != 0)
            	{
            		$ajout=$bdd->prepare('INSERT INTO AFFECTER(Matricule,RefEntite,RefService,Poste) VALUES (?,?,?,?) ');
            		$ajout->execute(array($matricule,$entite,$service,$poste));
            		$erreur= '<i class="fa fa-thumbs-up" aria-hidden="true"></i> Affectation réussie!';
            	}
            	else
            	{
            		$erreur = "<i class='fa fa-times-circle' aria-hidden='true'></i> <p>Désolé! Ce service n'existe pas. <br>Voulez-vous l'enregistrer? Si oui, <a href=\" admin_service.php\" target=\"_blank\" title= \"enregistrer un nouveau service\"  >Cliquez ici.</a>";
            	}
            }
            else
            {
            	$erreur = "<p> <i class='fa fa-times-circle' aria-hidden='true'></i> Désolé! Cette personne n'existe pas. <br>Voulez-vous l'enregistrer? Si oui, <a href=\" admin_personnel.php\" target=\"_blank\" title= \"enregistrer un nouvel employé\"  >Cliquez ici.</a>";
            }

		}
		else
		{
			$erreur = "<i class='fa fa-times-circle' aria-hidden='true'></i> Veuillez remplir tout les champs";
		}
	}
	



?>


<?php  include'Include/header_admin.html' ?>
<html>
<head>
	<meta charset="utf-8">
	<title>Affectation de poste</title>
	<link rel="stylesheet" type="text/css" href="CSS/style.css">
	<meta name="viewport" content="width=device-width,initial-scale= 1.0">
</head>
<body>
	<div>
		<p>
			<h2>AJOUT</h2>
			<center>
				<form method="POST">
			<table>
				<tr>
					<td align='right'>
						<label>Entrez le matricule</label>
					</td>
					<td>
						<input type="number" name="matricule" value="<?php if(isset($q)) { echo $q['Matricule']; } ?>" required>
					</td>
				</tr>
				<tr>
					<td align='right'>
						<label>Entrez la référence du service</label>
					</td>
					<td>
						<input type="text" name="service" value="<?php if(isset($q)) { echo $q['RefService']; } ?>" required>
					</td>
				</tr>
				<tr>
					<td align='right'>
						<label>Entrez la référence de l'entité</label>
					</td>
					<td>
						<input type="text" name="entite" value="<?php if(isset($q)) { echo $q['RefEntite']; } ?>" required>
					</td>
				</tr>
				<tr>
					<td align='right'>
						<label>Entrez le poste</label>
					</td>
					<td>
						<input type="text" name="poste" value="<?php if(isset($q)) { echo $q['Poste']; } ?>" required>
					</td>
				</tr>
				<tr>
					<td>
						
					</td>
					<td>
						
					</td>
				</tr>
				<tr>
					<td>
						
					</td>
					<td>
						
					</td>
				</tr>
				<tr>
					<td>
						
					</td>
					<td>
						<input type="submit" name="ajouter" value="Enregistrer">
					</td>
				</tr>
				<tr>
					<td>
					</td>
					<td>
						<input onclick="if(confirm('Vous etes sur le point de modifier ses informations. Voulez-vous continuer ?')){ document.location.href = url;} else {return false}" type="submit" name="modifier" value="Modifier">
					</td>
				</tr>
			</table>
				</form>
			</center>
			
		</p>
	</div>

<?php

	$tout = $bdd->query('SELECT * FROM AFFECTER ORDER BY Matricule DESC');
	if(isset($erreur))
	{
		echo '<div class="admin"><span>'.$erreur.'</span></div>';
	}

?>
	<div>
		<p>
			<h2>MODIFICATION</h2>
	
			<table class="previous" align="center">
					<thead>
						<tr align="center" >
							<th colspan='6' bgcolor="#DAF7A6">Enregistrements précédents</th>
						</tr>
						<tr>
							<th>Matricule</th>
							<th>Référence du service</th>
							<th>Référence de l'entité</th>
							<th>Poste</th>
							<th>Supprimer <i class="fa fa-trash" aria-hidden="true"></i>
							</th>
							<th>Modifier <i class="fa fa-pencil" aria-hidden="true"></i>
							</th>
						</tr>
					</thead>
					<tbody>
					<?php 
					while ($personne = $tout->fetch()) {
					
						?>
					
						<tr>
							<td> <?= $personne['Matricule'] ?> </td>
							<td> <?= $personne['RefService'] ?> </td>
							<td> <?= $personne['RefEntite'] ?> </td>
							<td> <?= $personne['Poste'] ?> </td>
							<td> 
								<a onclick="if(confirm('Etes vous sur de bien vouloir supprimer cet enregistrement ?')){ document.location.href = url;} else {return false}" href="affectation.php?supprime=<?= $personne['Matricule']?>&ref=<?= $personne['RefService'] ?>">Supprimer
				      			</a>
							</td>
							<td>  
								<a href="affectation.php?affiche=<?= $personne['Matricule'] ?>&key=<?= $personne['RefService']?>">Afficher pour modification
								</a>
							</td>
						</tr>
					

				<?php    }   ?>
					</tbody>
					</table>

		</p>
	</div>

<div align="center">
	<a href="admin_bureau.php" title="Retourner à la page précédente"><i class="fa fa-chevron-left" aria-hidden="true"></i>
	</a>
</div>

<?php include'Include/footer.html' ?>

</body>
</html>