<?php
#Connexion à la bdd
$bdd = new PDO('mysql:host=localhost;dbname=annuaire;charset=utf8', 'root', '');
#Pour afficher tout les enregistrements


?>
<?php



if(isset($_GET['affiche']) AND !empty($_GET['affiche']))
	{
		$affiche = htmlspecialchars($_GET['affiche']);
		$q = $bdd->prepare('SELECT * FROM ENTITE WHERE RefEntite=?');
		$q->execute(array($affiche));
		$q = $q->fetch();
	}

	if(isset($_POST['modifier']) AND !empty($_POST['modifier']))
		{
#Pour éviter les injections!!!
 $libelle=htmlspecialchars($_POST['libelle']);
$contact=htmlspecialchars($_POST['contact']);
$lieu=htmlspecialchars($_POST['lieu']);
$info=htmlspecialchars($_POST['info']);

			$update= $bdd->prepare('UPDATE ENTITE SET LibelEntite = ?,ContactEntite=?,LieuEntite=?,InfoEntite=? WHERE RefEntite=?');
			$update->execute(array($libelle,$info,$contact,$lieu,$affiche));
			$msg='<i class="fa fa-thumbs-up" aria-hidden="true"></i> Modification effectuée';
		}

if(isset($_GET['supprime']) AND !empty($_GET['supprime']))
{
	$supprime = $_GET['supprime'];
	$modif = $bdd->prepare('DELETE FROM ENTITE WHERE RefEntite = ?');
	$modif->execute(array($supprime));
	$msg ="<i class='fa fa-thumbs-up' aria-hidden='true'></i> Suppression effectuée";
}



if(isset($_POST['valider']))
   {

   	
   	 
   	 if (!empty($_POST['libelle']) AND !empty($_POST['contact']) AND !empty($_POST['lieu']))
   	 {
   	 	#Pour éviter les injections!!!
 $libelle=htmlspecialchars($_POST['libelle']);
$contact=htmlspecialchars($_POST['contact']);
$lieu=htmlspecialchars($_POST['lieu']);
$info=htmlspecialchars($_POST['info']);
   	 	#POur éviter les doublons
   	 	$search = $bdd->prepare('SELECT * FROM ENTITE WHERE LibelEntite=?');
   	 	$search-> execute(array($libelle));
        $exist = $search->rowCount();
        if($exist == 0)
        {
        	#Pour enregistrer les données dans la bdd
   		    $req = $bdd->prepare('INSERT INTO ENTITE(LibelEntite,InfoEntite,ContactEntite,LieuEntite) VALUES(?,?,?,?)');
            $req->execute(array($libelle,$info,$contact,$lieu));
   		    $good = "<i class='fa fa-thumbs-up' aria-hidden='true'></i> Entité ajoutée";
        }
        else
        {
        	$msg="<i class='fa fa-times-circle' aria-hidden='true'></i>Vous avez déjà enregistré cette entité";
        }
        
   	 }
   	 else
   	 {
         $erreur ="<i class='fa fa-times-circle' aria-hidden='true'></i> Veuillez remplir tout les champs";
   	 }
   }
?>
<?php
$tout = $bdd->query('SELECT * FROM ENTITE ');
// ▓ 
?>

<html>
<head>
	<meta charset="utf-8">
	<title>Gestion des entités</title>
	<link rel="stylesheet" type="text/css" href="CSS/style.css">
	<meta name="viewport" content="width=device-width,initial-scale= 1.0">
	<!--<link rel="shortcut icon" type="image/x-icon" href="Images/index.png" />-->
</head>
<body>
<div style="text-align: center;">
	<?php include"Include/header_admin.html" ?>
	<h2>AJOUT</h2>
	<p>
		Vous pouvez ajouter des entités comme les vices-rectorats, les écoles ou les facultés etc.
		<div id="block"> <br>
			<form method="POST"> <center>
				<table>
					<tr>
						<td align="right">
							<label>Référence de l'entité:</label>
						</td>
						<td>
							<input disabled='disabled' type="text" name="ref" value="<?php if(isset($q)) { echo $q['RefEntite']; } ?>">
						</td>
					</tr>
					<tr>
						<td align="right">
							<label>Libellé de l'entité:</label>
						</td>
						<td>
							<input type="text" name="libelle" required placeholder="Ex:FASEG-UAC ou FASEG-UP"  value="<?php if(isset($q)) { echo $q['LibelEntite']; }?>">
						</td>
					</tr>
					<tr>
						<td align="right">
							<label>Informations sur l'entité:</label>
						</td>
						<td>
							<input type="text" name="info" value="<?php if(isset($q)) { echo $q['InfoEntite']; } ?>">
						</td>
					</tr>
					<tr>
						<td align="right">
							<label>Contacts de l'entité:</label>
						</td>
						<td>
							<input type="text" name="contact" value="<?php if(isset($q)) { echo $q['ContactEntite']; } ?>">
						</td>
					</tr>
					<tr>
						<td align="right">
							<label>Lieu:</label>
						</td>
						<td>
							<input type="text" name="lieu" placeholder="Ex: UAC, Cotonou ou Ouidah" value="<?php if(isset($q)) { echo $q['LieuEntite']; } ?>" >
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
	<br>
	<?php
	   if(isset($msg))
	   {
           echo '<div class="admin"><span>' .$msg. '</span></div>';
	   }
	
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
							<th>Lieu</th>
							<th>Contact</th>
							<th>Informations</th>
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
							<td> <?= $personne['RefEntite'] ?> </td>
							<td> <?= $personne['LibelEntite'] ?> </td>
							<td> <?= $personne['LieuEntite'] ?> </td>
							<td> <?= $personne['ContactEntite'] ?> </td>
							<td> <?= $personne['InfoEntite'] ?> </td>
							<td> 
								<a onclick="if(confirm('Etes vous sur de bien vouloir supprimer cet enregistrement ?')){ document.location.href = url;} else {return false}"  href="admin_entite.php?supprime=<?= $personne['RefEntite'] ?>">Supprimer
						      </a> 
							</td>
							<td>  
								<a href="admin_entite.php?affiche=<?= $personne['RefEntite'] ?>">Afficher pour modification
						</a>
							</td>
						</tr>
					

				<?php    }   ?>
					</tbody>
					</table>
	</p>

</div>

<div align="center">
	<a href="admin_actualite.php" title="Retourner à l'accueil de l'administrateur"><i class="fa fa-chevron-left" aria-hidden="true"></i>
	</a><pre>    </pre>
	<a href="admin_service.php" title="Gestion des actualités"><i class="fa fa-chevron-right" aria-hidden="true"></i>
	</a>
</div>
<?php include"Include/footer.html" ?>  
</body>
</html>