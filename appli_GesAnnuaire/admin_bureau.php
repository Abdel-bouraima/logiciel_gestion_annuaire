<?php
$bdd = new PDO('mysql:host=localhost;dbname=annuaire;charset=utf8', 'root', '');



if(isset($_GET['affiche']) AND !empty($_GET['affiche']))
	{
		$affiche = htmlspecialchars($_GET['affiche']);
		$q = $bdd->prepare('SELECT * FROM BUREAU WHERE RefBureau =?');
		$q->execute(array($affiche));
		$q = $q->fetch();
	}

	if(isset($_POST['modifier']) AND !empty($_POST['modifier']))
		{
			$libelle=htmlspecialchars($_POST['libelle']);
			$lieu=htmlspecialchars($_POST['lieu']);
			$update= $bdd->prepare('UPDATE BUREAU SET LibelBureau = ?,LieuBureau=? WHERE RefBureau=?');
			$update->execute(array($libelle,$lieu,$affiche));
			$msg='<i class="fa fa-thumbs-up" aria-hidden="true"></i> Modification effectuée';
		}

if(isset($_GET['supprime']) AND !empty($_GET['supprime']))
{
	$supprime = (int) $_GET['supprime'];
	$modif = $bdd->prepare('DELETE FROM BUREAU WHERE RefBureau = ?');
	$modif->execute(array($supprime));
	$msg ="<i class='fa fa-thumbs-up' aria-hidden='true'></i> Suppression effectuée";
}

if(isset($_POST['valider']))
   {
   	$libelle=htmlspecialchars($_POST['libelle']);
	$lieu=htmlspecialchars($_POST['lieu']);
   	 if (!empty($_POST['libelle'])  AND !empty($_POST['lieu']))
   	 {
   	 	$search = $bdd->prepare('SELECT * FROM BUREAU WHERE LibelBureau =?');
   	 	$search-> execute(array($libelle));
        $exist = $search->rowCount();
        if($exist == 0)
        {
        	#Pour enregistrer les données dans la bdd
   		    $req = $bdd->prepare('INSERT INTO BUREAU(LibelBureau, LieuBureau) VALUES(?,?)');
            $req->execute(array($libelle,$lieu));
   		    $good = "<i class='fa fa-thumbs-up' aria-hidden='true'></i> Bureau ajouté";
        }
        else
        {
        	$msg="<i class='fa fa-times-circle' aria-hidden='true'></i>Vous avez déjà enregistré ce bureau";
        }
	
   	 }
   	 else
   	 {
         $erreur =" <i class='fa fa-times-circle' aria-hidden='true'></i> Veuillez remplir tout les champs";
   	 }
   }

$tout = $bdd->query('SELECT * FROM BUREAU ');
?>
<html>
<head>
	<meta charset="utf-8">
	<title>Gestion des bureaux</title>
	<link rel="stylesheet" type="text/css" href="CSS/style.css">
	<meta name="viewport" content="width=device-width,initial-scale= 1.0">
</head>
<body>
<div style="text-align: center;">
	<?php include"Include/header_admin.html" ?>
	<h2>AJOUT</h2>
	<p>
		<div id="block">
			<br>
				<form method="POST"> <center>
					<table>
						<tr>
							<td align="right">
								<label>Référence du bureau:</label>
							</td>
							<td>
								<input type="text" disabled='disabled' name="ref"  value="<?php if(isset($q)) { echo $q['RefBureau']; }  ?>">
							</td>
						</tr>
						<tr>
							<td align="right">
								<label>Libellé:</label>
							</td>
							<td>
								<input type="text" name="libelle" value="<?php if(isset($q)) { echo $q['LibelBureau']; }  ?>">
							</td>
						</tr>
						<tr>
							<td align="right">
								<label>Lieu:</label>
							</td>
							<td>
								<input type="text" name="lieu" value="<?php if(isset($q)) { echo $q['LieuBureau']; }  ?>">
							</td>
						</tr>
							<td>
							</td>
							<td>
							</td>
						</tr>
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
						</tr>
							<td>
							</td>
							<td>
							</td>
						</tr>
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
							<th colspan='5' bgcolor="#DAF7A6">Enregistrements précédents</th>
						</tr>
						<tr>
							<th>Référence</th>
							<th>Libellé</th>
							<th>Lieu</th>
							<th>Supprimer 
								<i class="fa fa-trash" aria-hidden="true"></i>
							</th>
							<th>Modifier 
								<i class="fa fa-pencil" aria-hidden="true"></i>
							</th>
						</tr>
					</thead>
					<tbody>
					<?php 
					while ($personne = $tout->fetch()) {
					
						?>
					
						<tr>
							<td> <?= $personne['RefBureau'] ?> </td>
							<td> <?= $personne['LibelBureau'] ?> </td>
							<td> <?= $personne['LieuBureau'] ?> </td>
							<td> 
								<a onclick="if(confirm('Etes vous sur de bien vouloir supprimer cet enregistrement ?')){ document.location.href = url;} else {return false}"  href="admin_bureau.php?supprime=<?= $personne['RefBureau'] ?>">Supprimer
					    		</a> 
							</td>
							<td>  
								<a href="admin_bureau.php?affiche=<?= $personne['RefBureau'] ?>">Afficher pour modification
								</a>
							</td>
						</tr>

				<?php    }   ?>
					</tbody>
					</table>

	</p>

</div>

<div align="center">
	<a href="admin_service.php" title="Retourner à l'accueil de l'administrateur"><i class="fa fa-chevron-left" aria-hidden="true"></i>
	</a><pre>    </pre>
	<a href="affectation.php" title="Gestion des actualités"><i class="fa fa-chevron-right" aria-hidden="true"></i>
	</a>
</div>
<?php include"Include/footer.html" ?>  
</body>
</html>