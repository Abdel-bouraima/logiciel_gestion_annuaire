<?php
session_start();
$bdd = new PDO('mysql:host=localhost;dbname=annuaire;charset=utf8', 'root', '');


if(isset($_GET['supprime']) AND !empty($_GET['supprime']))
{
	$supprime = $_GET['supprime'];
	$modif = $bdd->prepare('DELETE FROM ACTUALITE WHERE NumActu = ?');
	$modif->execute(array($supprime));
	$msg ="<i class='fa fa-thumbs-up' aria-hidden='true'></i>
Suppression effectuée";
}

if(isset($_GET['publie']) AND !empty($_GET['publie']))
{
	$publie = $_GET['publie'];
	$update = $bdd->prepare('UPDATE ACTUALITE SET Publication=1 WHERE NumActu = ?');
	$update->execute(array($publie));
	$msg ="<i class='fa fa-thumbs-up' aria-hidden='true'></i>Cette news a été publié.<br> Elle sera bientot visible par les utilisateurs.";
}

if(isset($_GET['depublier']) AND !empty($_GET['depublier']))
{
	$depublier = $_GET['depublier'];
	$update = $bdd->prepare('UPDATE ACTUALITE SET Publication=0 WHERE NumActu = ?');
	$update->execute(array($depublier));
	$msg ="<i class='fa fa-thumbs-up' aria-hidden='true'></i>Cette news ne sera plus publiée.";
}

if(isset($_POST['valider']))
   {
   	 $contenu=htmlspecialchars($_POST['contenu']);
   	 if (!empty($_POST['contenu']))
   	 {
   	 	if(isset($_POST['statut']) AND !empty($_POST['statut']))
   	 	{
   	 		$check=1;
   	 	}
   	 	else
   	 	{
   	 		$check=0;
   	 	}
		   		$req = $bdd->prepare('INSERT INTO ACTUALITE(Contenu,Login,Publication) VALUES(?,?,?)');
		        $req->execute(array($_POST['contenu'],$_SESSION['Login'],$check));
		   		$good = "<i class='fa fa-thumbs-up' aria-hidden='true'></i> Actualité ajoutée";
   	 }
   	 else
   	 {
         $erreur ="<i class='fa fa-times-circle' aria-hidden='true'></i> 
 Veuillez remplir tout les champs";
   	 }
   }

   $tout = $bdd->query('SELECT * FROM ACTUALITE ORDER BY DateActu DESC ');
?>
<html>
<head>
	<meta charset="utf-8">
	<title>Gestion des actualités</title>
	<link rel="stylesheet" type="text/css" href="CSS/style.css">
	<meta name="viewport" content="width=device-width,initial-scale= 1.0">
</head>
<body>
<div style="text-align: center;">
	<?php include"Include/header_admin.html" ?>
	
	<h2>AJOUT</h2>
	<p>
		
		
			<form method="POST"> 
				
				<textarea name="contenu" id="contenu" rows="10" cols="50">Contenu de la news</textarea> <br><br>
				<label style="text-align: center;">Cochez si vous voulez la publier</label>
				<input align="center" type="checkbox" name="statut" checked><br> <br> <br>
				<input type="submit" name="valider" value="Enregistrer">
			</form>
		
	</p>

<?php
	   if(isset($good))
	   {
           echo '<div class="admin"><span>' .$good. '</span></div>';
	   }
	   if(isset($erreur))
	   {
           echo '<div class="admin"><span>' .$erreur. '</span></div>';
	   }
	   if(isset($msg))
	   {
           echo '<div class="admin"><span>' .$msg. '</span></div>';
	   }
?>

<div>
	<h2>
		MODIFICATION
	</h2>
	<p>

		<table class="previous" align="center">
					<thead>
						<tr align="center" >
							<th colspan='6' bgcolor="#DAF7A6">Enregistrements précédents</th>
						</tr>
						<tr>
							<th>Numéro</th>
							<th>Contenu</th>
							<th>Date de publication</th>
							<th>Statut</th>
							<th>Gérer le statut <i class="fa fa-pencil" aria-hidden="true"></i>
</th>
							<th>Supprimer <i class="fa fa-trash" aria-hidden="true"></i>
</th>
						</tr>
					</thead>
					<tbody>
					<?php 
					while ($personne = $tout->fetch()) {
					
						?>
					
						<tr>
							<td> <?= $personne['NumActu'] ?> </td>
							<td> <?= $personne['Contenu'] ?> </td>
							<td> <?= $personne['DateActu'] ?> </td>
							<td> <?= $personne['Publication'] ?> </td>
							<td>
								<?php 
							    if($personne['Publication'] == 0)
							    {
							?>
							    	<a href="admin_actualite.php?publie=<?= $personne['NumActu'] ?>">Publier
							    	  </a> 
							<?php
							    }
							    else
							    {
							?>
							        <a href="admin_actualite.php?depublier=<?= $personne['NumActu'] ?>">Ne plus publier
							    	</a> 

					 <?php   }  ?> 

							 
							</td>
							<td>  
								<a onclick="if(confirm('Etes vous sur de bien vouloir supprimer cet enregistrement ?')){ document.location.href = url;} else {return false}" href="admin_actualite.php?supprime=<?= $personne['NumActu'] ?>">Supprimer
								</a> 
							</td>
						</tr>
					

				<?php    }   ?>
					</tbody>
					</table>


		    
	</p>
</div>
<div align="center">
	<a href="admin_personnel.php" title="Retourner à l'accueil de l'administrateur"><i class="fa fa-chevron-left" aria-hidden="true"></i>
	</a><pre>    </pre>
	<a href="admin_entite.php" title="Gestion des actualités"><i class="fa fa-chevron-right" aria-hidden="true"></i>
	</a>
</div>

<?php include"Include/footer.html" ?>  
</body>
</html>