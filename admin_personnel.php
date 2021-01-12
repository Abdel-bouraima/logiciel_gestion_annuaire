<?php
try 
{
    $bdd = new PDO('mysql:host=localhost;dbname=annuaire;charset=utf8','root','');
} 
catch(PDOException $e) 
{
    echo 'Erreur PDO : '.$e->getMessage();
}


if(isset($_GET['affiche']) AND !empty($_GET['affiche']))
	{
		$affiche = htmlspecialchars($_GET['affiche']);
		$q = $bdd->prepare('SELECT * FROM PERSONNE WHERE Matricule=?');
		$q->execute(array($affiche));
		$q = $q->fetch();
	}



if(isset($_POST['modifier']) AND !empty($_POST['modifier']))
	{
	$nom=htmlspecialchars($_POST['nom']);
   	$prenom=htmlspecialchars($_POST['prenom']);
   	$grade=htmlspecialchars($_POST['grade']);
   	$telephone=htmlspecialchars($_POST['telephone']);
   	$email=htmlspecialchars($_POST['email']);
   	$adresse=htmlspecialchars($_POST['adresse']);
   	$autorisation=htmlspecialchars($_POST['autorisation']);
   	$type=htmlspecialchars($_POST['type']);
   	$date=htmlspecialchars($_POST['date']);
   	$note=htmlspecialchars($_POST['note']);
   	$bureau=htmlspecialchars($_POST['bureau']);

   	
		
		if(isset($_FILES['image']) AND !empty($_FILES['image']['name']))
					{
						//On définit une taille maximale pour le fichier
						$maxsize = 3145728;
						if ($_FILES['image']['size'] > $maxsize) 
						{
							$erreur="<i class='fa fa-times-circle' aria-hidden='true'></i>Le fichier dépasse la taille maximale qui est de 3Mo";
						}
						else
						{
							$extensions_valides = array( 'jpg' , 'jpeg' , 'gif', 'png' );

							$extension_upload = strtolower(  substr(  strrchr($_FILES['image']['name'], '.')  ,1)  );

							if ( in_array($extension_upload,$extensions_valides) ) 
							{
								//On indique le fichier dans lequel ira l'image est son nom
								$dossier = "Photo/".$nom.'_'.$prenom.".".$extension_upload ;
								//On fait un déplacement
								$deplacement = move_uploaded_file($_FILES['image']['tmp_name'], $dossier);
								if($deplacement)
								{
									if($autorisation=='Oui')
									{
										$reponse = 1;
									}
									elseif($autorisation=='Non')
									{
										$reponse = 0;
									}
									else
									{
										$erreur= "<i class='fa fa-times-circle' aria-hidden='true'></i>Erreur 404";
									}


									$update= $bdd->prepare('UPDATE PERSONNE SET Nom = ?,Prenom=?,Grade=?,Telephone=?,Email=?,Adresse=?,Type=?,DatEmbauche=?,NoteService=?,RefBureau=?,Photo=?,Autorisation=? WHERE Matricule=?');
									$update->execute(array($nom,$prenom,$grade,$telephone,$email,$adresse,$type,$date,$note,$bureau,$nom.'_'.$prenom.".".$extension_upload,$reponse,$affiche));
									$msg='<i class="fa fa-thumbs-up" aria-hidden="true"></i> Modification effectuée';
								}
							}
						}
					}
					else
					{
						$update= $bdd->prepare('UPDATE PERSONNE SET Nom = ?,Prenom=?,Grade=?,Telephone=?,Email=?,Adresse=?,Type=?,DatEmbauche=?,NoteService=?,RefBureau=? WHERE Matricule=?');
									$update->execute(array($nom,$prenom,$grade,$telephone,$email,$adresse,$type,$date,$note,$bureau,$affiche));
									$msg='<i class="fa fa-thumbs-up" aria-hidden="true"></i> Modification effectuée';
					}
	}


if(isset($_GET['autoriser']) AND !empty($_GET['autoriser']))
{
	$autoriser = $_GET['autoriser']; 
	$modif = $bdd->prepare('UPDATE PERSONNE SET Autorisation = ? WHERE Matricule = ?');
	$modif->execute(array(1,$autoriser));
	$msg ="<i class='fa fa-thumbs-up' aria-hidden='true'></i> Opération effectuée";
}
if(isset($_GET['non']) AND !empty($_GET['non']))
{
	$non = $_GET['non'];
	$modif = $bdd->prepare('UPDATE PERSONNE SET Autorisation = ? WHERE Matricule = ?');
	$modif->execute(array(0,$non));
	$msg = "<i class='fa fa-thumbs-up' aria-hidden='true'></i> Opération effectuée";
}

if(isset($_GET['supprime']) AND !empty($_GET['supprime']))
{
	$supprime = $_GET['supprime'];
	$modif = $bdd->prepare('DELETE FROM PERSONNE WHERE Matricule = ?');
	$modif->execute(array($supprime));
	$msg ="<i class='fa fa-thumbs-up' aria-hidden='true'></i> Suppression effectuée";
}



if(isset($_POST['valider']))
    {
		$nom=htmlspecialchars($_POST['nom']);
   		$prenom=htmlspecialchars($_POST['prenom']);
   		$grade=htmlspecialchars($_POST['grade']);
   		$telephone=htmlspecialchars($_POST['telephone']);
   		$email=htmlspecialchars($_POST['email']);
   		$adresse=htmlspecialchars($_POST['adresse']);
   		$autorisation=htmlspecialchars($_POST['autorisation']);
   		$type=htmlspecialchars($_POST['type']);
   		$date=htmlspecialchars($_POST['date']);
   		$note=htmlspecialchars($_POST['note']);
   		$bureau=htmlspecialchars($_POST['bureau']);
   		if (!empty($_POST['nom']) AND !empty($_POST['prenom']) AND !empty($_POST['telephone']) AND !empty($_POST['email']) AND !empty($_POST['adresse']) )
   		{
   	 		#POur éviter les doublons
   	 		$search = $bdd->prepare('SELECT * FROM PERSONNE WHERE Nom=? AND Prenom=?');
   	 		$search-> execute(array($nom, $prenom));
        	$exist = $search->rowCount();

        	if($exist == 0)
        	{
        		if(isset($_FILES['image']) AND !empty($_FILES['image']['name']))
					{
						//On définit une taille maximale pour le fichier
						$maxsize = 3145728;
						if ($_FILES['image']['size'] > $maxsize) 
						{
							$erreur="<i class='fa fa-times-circle' aria-hidden='true'></i>Le fichier dépasse la taille maximale qui est de 3Mo";
						}
						else
						{
							$extensions_valides = array( 'jpg' , 'jpeg' , 'gif', 'png' );

							$extension_upload = strtolower(  substr(  strrchr($_FILES['image']['name'], '.')  ,1)  );

							if ( in_array($extension_upload,$extensions_valides) ) 
							{
								//On indique le fichier dans lequel ira l'image est son nom
								$dossier = "Photo/".$nom.'_'.$prenom.".".$extension_upload ;
								//On fait un déplacement
								$deplacement = move_uploaded_file($_FILES['image']['tmp_name'], $dossier);
								if($deplacement)
								{
									if($autorisation=='Oui')
									{
										$reponse = 1;
									}
									elseif($autorisation=='Non')
									{
										$reponse = 0;
									}
									else
									{
										$erreur= "<i class='fa fa-times-circle' aria-hidden='true'></i>Erreur 404";
									}

									#Pour enregistrer les données dans la bdd
					   		   		$req = $bdd->prepare("INSERT INTO PERSONNE(Nom, Prenom, Grade, Telephone, Email, Adresse, Autorisation, Type, DatEmbauche, NoteService,RefBureau,Photo) VALUES(?,?,?,?,?,?,?,?,?,?,?,?)");
					           		$req->execute(array($nom,$prenom,$grade,$telephone,$email,$adresse,$reponse,$type,$date,$note,$bureau,$nom.'_'.$prenom.".".$extension_upload ));
					   		   		$good ="<i class='fa fa-thumbs-up' aria-hidden='true'></i> Personne ajoutée";
								}
								else
								{
									$erreur="<i class='fa fa-times-circle' aria-hidden='true'></i>ERREUR 404 ";
								}
							}
							else
							{
								$erreur= "<i class='fa fa-times-circle' aria-hidden='true'></i>Désolé! L'extension ".$_FILES['image']['type']." n 'est pas prise en charge";
							}
						}
					} 
        	}
        	else
        	{
        		$msg="<i class='fa fa-times-circle' aria-hidden='true'></i>Vous avez déjà enregistré cette personne";
        	}

   		}
   		else
   		{
    	    $erreur ="<i class='fa fa-times-circle' aria-hidden='true'></i>Veuillez remplir tout les champs";
   		}
    }

   $tout = $bdd->query('SELECT * FROM Personne ORDER BY Matricule ASC');
?>

<?php

if(isset($_POST['upload']))
{

	//Script pour l'upload des images
	#var_dump($_FILES); affiche les informations d'une variable
	if(isset($_FILES['image']) AND !empty($_FILES['image']['name']))
	{
		//On définit une taille maximale pour le fichier
		$maxsize = 3145728;
		if ($_FILES['image']['size'] > $maxsize) 
		{
			$erreur="<i class='fa fa-times-circle' aria-hidden='true'></i>Le fichier dépasse la taille maximale qui est de 3Mo";
		}
		else
		{
			$extensions_valides = array( 'jpg' , 'jpeg' , 'gif', 'png' );

			$extension_upload = strtolower(  substr(  strrchr($_FILES['image']['name'], '.')  ,1)  );

			if ( in_array($extension_upload,$extensions_valides) ) 
			{
				//On indique le fichier dans lequel ira l'image est son nom
				$dossier = "Photo/".$nom.'_'.$prenom.".".$extension_upload ;
				//On fait un déplacement
				$deplacement = move_uploaded_file($_FILES['image']['tmp_name'], $dossier);
				if($deplacement)
				{
					$save_picture = $bdd->prepare('INSERT INTO PERSONNE(Photo) VALUES :image');
					$save_picture->execute(array( 'image'=> $nom.$prenom.".".$extension_upload ));
				}
				else
				{
					$erreur="<i class='fa fa-times-circle' aria-hidden='true'></i>ERREUR 404 ";
				}
			}
			else
			{
				$erreur= "<i class='fa fa-times-circle' aria-hidden='true'></i>Désolé! L'extension ".$_FILES['image']['type']." n 'est pas prise en charge";
			}
		}
	}
}


?>


<html>
<head>
	<meta charset="utf-8">
	<title>Gestion du personnel</title>
	<link rel="stylesheet" type="text/css" href="CSS/style.css">
	<meta name="viewport" content="width=device-width,initial-scale= 1.0">
	<style type="text/css">
		a{text-decoration: none;}
	</style>
</head>
<body>
<div style="text-align: center;">
	<?php include"Include/header_admin.html" ?>

	<h2 id="ancre">AJOUT</h2>
	<p>
		<div  id="block">
			<form method="POST" enctype="multipart/form-data"> <center>
				<table>
					<tr>
						<td align="right">
							<label>Numéro matricule de la personne:</label>
						</td>
						<td>
							<input type="number" name="nom" value="<?php if(isset($q)) { echo $q['Matricule']; }  ?>" disabled='disabled'>
						</td>
					</tr>
					<tr>
						<td align="right">
							<label>Nom de la personne:</label>
						</td>
						<td>
							<input type="text" name="nom" value="<?php if(isset($q)) { echo $q['Nom']; }  ?>" required onkeyup='this.value=this.value.toUpperCase()' >
						</td>
					</tr>
					<tr>
						<td align="right">
							<label>Prénom de la personne:</label>
						</td>
						<td>
							<input type="text" name="prenom" value="<?php if(isset($q)) { echo $q['Prenom']; }  ?>" required>
						</td>
					</tr>
					<tr>
						<td align="right">
							<label>Adresse de la personne:</label>
						</td>
						<td>
							<input type="text" name="adresse" value="<?php if(isset($q)) { echo $q['Adresse']; }  ?>" required>
						</td>
					</tr>
					<tr>
						<td align="right">
							<label>Numéro de téléphone de la personne:</label>
						</td>
						<td>
							<input type="text" name="telephone" value="<?php if(isset($q)) { echo $q['Telephone']; }  ?>" required>
						</td>
					</tr>
					<tr>
						<td align="right">
							<label>Email de la personne:</label>
						</td>
						<td>
							<input type="mail" name="email" value="<?php if(isset($q)) { echo $q['Email']; }  ?>" required>
						</td>
					</tr>
					<tr>
						<td align="right">
							<label>Date d'embauche de la personne:</label>
						</td>
						<td>
							<input type="date" name="date" value="<?php if(isset($q)) { echo $q['DatEmbauche']; }  ?>">
						</td>
					</tr>
					<tr>
						<td align="right">
							<label>Note de service:</label>
						</td>
						<td>
							<input type="text" name="note" value="<?php if(isset($q)) { echo $q['NoteService']; }  ?>">
						</td>
					</tr>
					<tr>
						<td align="right">
							<label>Voulez vous autoriser la personne à accéder à l'annuaire</label>
						</td>
						<td>
							<select name="autorisation">
								<option>Non</option>
								<option>Oui</option>
							</select>
						</td>
					</tr>
					<tr>
						<td align="right">
							<label>Sélectionner le type de la personne</label>
						</td>
						<td>
							<select name="type">
								<?php if(isset($q) AND $q['Type']=='Administratif' ) { 
									echo "<option>Administratif</option>"; } elseif (isset($q) AND $q['Type']=='Enseignant') { echo" <option>Enseignant</option> "; } else { echo "<option></option>";} ?>
							</select>
						</td>
					</tr>
					<tr>
						<td align="right">
							<label>Grade de la personne</label>
						</td>
						<td>
							<input type="text" name="grade" placeholder="Ex: Maitre assistant" value="<?php if(isset($q)) { echo $q['Grade']; }  ?>">
						</td>
					</tr>
					<tr>
						<td align="right">
							<label>Référence du bureau:</label>
						</td>
						<td>
							<input type="text" name="bureau">
						</td>
					</tr>
					<tr>
						<td align="right">
							<label>Photo de la personne(max 3Mo)</label>
						</td>
						<td>
							<input type="hidden" name="MAX_FILE_SIZE" value="10485760">
							<input type="file" name="image">
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
		
		<h2> MODIFICATION</h2>
		
			<table class="previous" align="center">
					<thead>
						<tr align="center" >
							<th colspan='14' bgcolor="#85929e">Enregistrements précédents</th>
						</tr>
						<tr>
							<th>Matricule</th>
							<th>Nom</th>
							<th>Prénom</th>
							<th>Numéro de téléphone</th>
							<th>Photo<i class="fa fa-picture-o" aria-hidden="true"></i>
							</th>
							<th>Adresse</th>
							<th>Adresse électronique</th>
							<th>Grade</th>
							<th>Type </th>
							<th>Note de service </th>
							<th>Date d'embauche </th>
							<th>Référence du bureau </th>
							<th>Autorisation</th>
							<th>Suppression <i class="fa fa-trash" aria-hidden="true"></i>
							</th>
							<th>Modification <i class="fa fa-pencil" aria-hidden="true"></i>
							</th>
						</tr>
					</thead>
					<tbody>
					<?php 
					while ($personne = $tout->fetch()) {
					
						?>
					
						<tr>
							<td> <?= $personne['Matricule'] ?> </td>
							<td> <?= $personne['Nom'] ?> </td>
							<td> <?= $personne['Prenom'] ?> </td>
							<td> <?= $personne['Telephone'] ?> </td>
							<td><?php if($personne['Photo']=='') { echo"Pas d'image";} else{ ?><a href="Photo/<?= $personne['Photo'] ?>"><img class="image" title="Photo de l'employé" src="Photo/<?= $personne['Photo']  ?>" ></a> </td> <?php } ?>
							<td> <?= $personne['Adresse'] ?> </td>
							<td> <?= $personne['Email'] ?> </td>
							<td> <?= $personne['Grade'] ?> </td>
							<td> <?= $personne['Type'] ?> </td>
							<td> <?= $personne['NoteService'] ?> </td>
							<td> <?= $personne['DatEmbauche'] ?> </td>
							<td> <?= $personne['RefBureau'] ?> </td>
							<td> <?php
				   if($personne['Autorisation'] == 0)
				    {
				    	?>
				    	<a href="admin_personnel.php?autoriser=<?=$personne["Matricule"] ?>">Autoriser
				         </a>
				   
<?php
				    }
				    else
				    {
				    	?>
				      <a href='admin_personnel.php?non=<?= $personne['Matricule'] ?>'>Annuler autorisation
				         </a>
				 <?php   }  ?>
				    </td>
				    <td>
				      <a onclick="if(confirm('Etes vous sur de bien vouloir supprimer cet enregistrement ?')){ document.location.href = url;} else {return false}" href="admin_personnel.php?supprime=<?= $personne['Matricule'] ?>">Supprimer
				      </a> </td>
				      <td> <a href="admin_personnel.php?affiche=<?= $personne['Matricule'] ?>">Afficher pour modification
						</a> 
					</td>
						</tr>
					

				<?php    }   ?>
					</tbody>
					</table>
		
	</p>

</div>
<div align="center">
	<a href="clone_page.php" title="Retourner à l'accueil de l'administrateur"><i class="fa fa-chevron-left" aria-hidden="true"></i>
	</a><pre>    </pre>
	<a href="admin_actualite.php" title="Gestion des actualités"><i class="fa fa-chevron-right" aria-hidden="true"></i>
	</a>
</div>
<?php include"Include/footer.html" ?>  
</body>
</html>