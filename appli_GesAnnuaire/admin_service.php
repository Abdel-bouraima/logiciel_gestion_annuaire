<?php

$bdd = new PDO('mysql:host=localhost;dbname=annuaire;charset=utf8', 'root', '');

?>
<?php

	

	if(isset($_GET['affiche']) AND !empty($_GET['affiche']))
	{
		$affiche = htmlspecialchars($_GET['affiche']);
		$q = $bdd->prepare('SELECT * FROM SERVICE WHERE RefService=?');
		$q->execute(array($affiche));
		$q = $q->fetch();
	}

	if(isset($_POST['modifier']) AND !empty($_POST['modifier']))
		{
			$libelle=htmlspecialchars($_POST['libelle']);
   	$contact=htmlspecialchars($_POST['contact']);
   	$info=htmlspecialchars($_POST['info']);
   	$ref=htmlspecialchars($_POST['ref']);
			$update= $bdd->prepare('UPDATE SERVICE SET LibelService = ?,ContactService=?,InfoService=?,RefEntite=? WHERE RefService=?');
			$update->execute(array($libelle,$info,$contact,$ref,$affiche));
			$msg='<i class="fa fa-thumbs-up" aria-hidden="true"></i> Modification effectuée';
		}

	if(isset($_GET['supprime']) AND !empty($_GET['supprime']))
{
	$supprime = $_GET['supprime'];
	$modif = $bdd->prepare('DELETE FROM SERVICE WHERE RefService = ?');
	$modif->execute(array($supprime));
	$msg ="Suppression effectuée";
}

	if(isset($_POST['valider']))
{
	
   	if (!empty($_POST['libelle']) AND !empty($_POST['contact']) AND !empty($_POST['ref']))
   	 {
   	 	$libelle=htmlspecialchars($_POST['libelle']);
   	$contact=htmlspecialchars($_POST['contact']);
   	$info=htmlspecialchars($_POST['info']);
   	$ref=htmlspecialchars($_POST['ref']);
   	 	#POur éviter les doublons
   	 	$search = $bdd->prepare('SELECT * FROM SERVICE WHERE LibelService=?');
   	 	$search-> execute(array($libelle));
        $exist = $search->rowCount();
        if($exist == 0)
        {
        	/*Compte le nombre de fois que la référence de l'entité existe. si le nombre= 1 alors insere sinon message l'entité n'existe pas*/
        	$recherche=$bdd->prepare('SELECT * FROM ENTITE WHERE RefEntite=?');
            $recherche->execute(array($ref));
            $existence = $recherche->rowCount();
            if($existence >= 1 )
            	{
            		#Pour enregistrer les données dans la bdd
   		    		$req = $bdd->prepare('INSERT INTO SERVICE(LibelService,InfoService,ContactService,RefEntite) VALUES(?,?,?,?)');
            		$req->execute(array($libelle,$info,$contact,$ref));
   		    		$good = "<i class='fa fa-thumbs-up' aria-hidden='true'></i> Service ajouté";
            	}
            	else
            	{
            		$erreur = "<i class='fa fa-times-circle' aria-hidden='true'></i><p>Désolé! Cette entité n'existe pas. <br>Voulez-vous l'enregistrer? Si oui, <a href=\" admin_entite.php\" target=\"_blank\" title= \"enregistrer une nouvelle entité\"  >Cliquez ici.</a>";
            	}

        	
        }
        else
        {
        	$msg="<i class='fa fa-times-circle' aria-hidden='true'></i>Vous avez déjà enregistré ce service";
        }

   	 }
   	 else
   	 {
         $erreur ="<i class='fa fa-times-circle' aria-hidden='true'></i>Veuillez remplir tout les champs";
   	 }
   }
?>
<?php
$tout = $bdd->query('SELECT * FROM SERVICE');
?>

<html>
<head>
	<meta charset="utf-8">
	<title>Gestion des services</title>
	<link rel="stylesheet" type="text/css" href="CSS/style.css">
	<meta name="viewport" content="width=device-width,initial-scale= 1.0">
</head>
<body>
<div style="text-align: center;">
	<?php include"Include/header_admin.html" ?>
	
	<h2>AJOUT</h2>
	<p class="p">
		<div id="block">
			<br>
			Vous pouvez ajouter des services comme les différents services sous le rectorat ou les départements ou les services sous les écoles etc. <br><br>
			<form method="POST"> <center>
				<table>
					<tr>
						<td align="right">
							<label> Référence du service:</label>
						</td>
						<td>
							<input disabled='disabled' type="text" name="refservice"  value="<?php if(isset($q)) { echo $q['RefService']; }  ?>">
						</td>
					</tr>
					<tr>
						<td align="right">
							<label>Libellé du service:</label>
						</td>
						<td>
							<input type="text" name="libelle" value="<?php if(isset($q)) { echo $q['LibelService']; }  ?>" required>
						</td>
					</tr>
					<tr>
						<td align="right">
							<label>Informations sur le service:</label>
						</td>
						<td>
							<input type="text" name="info" value="<?php if(isset($q)) { echo $q['InfoService']; }  ?>">
						</td>
					</tr>
					<tr>
						<td align="right">
							<label>Contacts du service:</label>
						</td>
						<td>
							<input type="text" name="contact" value="<?php if(isset($q)) { echo $q['ContactService']; }  ?>">
						</td>
					</tr>
					<tr>
						<td align="right">
							<label>Référence de l'entité:</label>
						</td>
						<td>
							<input type="text" name="ref" value="<?php if(isset($q)) { echo $q['RefEntite']; }  ?>" >
						</td>
					</tr>
						<td>
						</td>
						<td>
						</td>
					</tr>
					<tr>
						<td>
						</td>
						<td>
							<input type="submit" name="valider" value="Enregistrer">
						</td>
					</tr>
					<tr>
						<td>
						</td>
						<td>
							<input onclick="if(confirm('Vous etes sur le point de modifier ses informations. Voulez-vous continuer ?')){ document.location.href = url;} else {return false}" type="submit" name="modifier" value="Modifier">
						</td>
					</tr>
				</table></center>
			</form>
		</div>
	</p>
	<?php
	   if(isset($msg))
	   {
           echo '<div class="admin"><span>' .$msg. '</span></div>';
	   }
	?>
	<?php
	   if(isset($good))
	   {
           echo '<div class="admin"><span>' .$good. '</span></div>';
	   }
	   if(isset($erreur))
	   {
           echo '<div class="admin"><span>' .$erreur. '</span></div>';
	   }
	?>

	<p>
		<h2>MODIFICATION</h2>

		<table class="previous" align="center">
					<thead>
						<tr align="center" >
							<th colspan='7' bgcolor="#DAF7A6">Enregistrements précédents</th>
						</tr>
						<tr>
							<th>Référence</th>
							<th>Libellé</th>
							<th>Informations</th>
							<th>Contact</th>
							<th>Référence de l'entité parraine</th>
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
							<td> <?= $personne['RefService'] ?> </td>
							<td> <?= $personne['LibelService'] ?> </td>
							<td> <?= $personne['InfoService'] ?> </td>
							<td> <?= $personne['ContactService'] ?> </td>
							<td> <?= $personne['RefEntite'] ?> </td>
							<td> 
								<a onclick="if(confirm('Etes vous sur de bien vouloir supprimer cet enregistrement ?')){ document.location.href = url;} else {return false}" href="admin_service.php?supprime=<?= $personne['RefService'] ?>">Supprimer
								</a>
							</td>
							<td>  
								<a href="admin_service.php?affiche=<?= $personne['RefService'] ?>">Afficher pour modification
								</a>
							</td>
						</tr>
					

				<?php    }   ?>
					</tbody>
					</table>
	</p>

</div>

<div align="center">
	<a href="admin_entite.php" title="Retourner à l'accueil de l'administrateur"><i class="fa fa-chevron-left" aria-hidden="true"></i>
	</a><pre>    </pre>
	<a href="admin_bureau.php" title="Gestion des actualités"><i class="fa fa-chevron-right" aria-hidden="true"></i>
	</a>
</div>

<?php include"Include/footer.html" ?>  
</body>
</html>