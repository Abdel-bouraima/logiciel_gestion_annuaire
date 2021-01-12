<?php
$bdd = new PDO('mysql:host=localhost;dbname=annuaire;charset=utf8', 'root', '');

//Si l'utilisateur presse le bouton rechercher
if(isset($_GET['valider']))
{
	//Si le champs contenant la valeur existe et n'est pas vide
	if(isset($_GET['valeur']) AND !empty($_GET['valeur']))
	{
		//Mise en place des variables sécurisées
		$valeur = htmlspecialchars($_GET['valeur']);
		//Si l'utilisateur recherche une personne
		if($_GET['filtre'] == 'Une personne')
		{
			//La requete de la recherche
	  		$sql=('SELECT * FROM PERSONNE WHERE Nom LiKE ? OR Prenom LIKE ?');
	  		$req = $bdd->prepare($sql);
			$req->execute(array('%'.$valeur.'%', '%'.$valeur.'%'));
			$nombre = $req->rowCount();

			if($nombre >=1)
			{
				//Traitement pour le résultat
				$erreur = 'Nous avons '.$nombre.' résultat(s) pour <strong>\''.$valeur.'\'</strong>';
				echo'<br><br>';
				while($result= $req->fetch(PDO::FETCH_OBJ))
					{
						$bon="<ul>
								<li>
									<img src='Photo/$result->Photo' >
								</li>
								<li>
									Numéro de téléphone: $result->Telephone
								</li>
								<li>
									Adresse: $result->Adresse
								</li>
								<li>
									Grade: $result->Grade
								</li>
								<li>
									Mail: $result->Email
								</li>
								<li>
									Type: $result->Type
								</li>
							  </ul>	
							  ";  
					}
			}
			else
			{
				$erreur = 'Aucun résulat trouvé pour la valeur: <strong>\''.$valeur.'\'</strong>';
			}
	  	}
	  	elseif($_GET['filtre'] == 'Un numéro de téléphone')
	  	{
	  		$sql=('SELECT * FROM PERSONNE AND AFFECTER WHERE Telephone LiKE ?');
	  		$req = $bdd->prepare($sql);
			$req->execute(array('%'.$valeur.'%'));
			$nombre = $req->rowCount();

			if($nombre >=1)
			{
				//Traitement pour le résultat
				//Affiche le nombre de résultats trouvés
				$erreur = 'Nous avons '.$nombre.' résultat(s) pour <strong>\''.$valeur.'\'</strong>';
				echo'<br><br>';
				while($result= $req->fetch(PDO::FETCH_OBJ))
					{
						$bon="<ul>
								<li>
									<img src='Photo/$result->Photo' >
								</li>
								<li>
									Nom: $result->Nom $result->Prenom 
								</li>
								<li>
									Numéro de téléphone: $result->Telephone
								</li>
								<li>
									Adresse: $result->Adresse
								</li>
								<li>
									Grade: $result->Grade
								</li>
								<li>
									Mail: $result->Email
								</li>
								<li>
									Type: $result->Type
								</li>
							  </ul>	";  
					}
				
			}
			else
			{
				$erreur = 'Aucun résulat trouvé pour la valeur: <strong>\''.$valeur.'\'</strong>';
			}

	  	}
	  	elseif($_GET['filtre'] == 'Un service')
	  	{
	  		$sql=('SELECT * FROM SERVICE WHERE LibelService LiKE ? OR InfoService LIKE ?');
	  		$req = $bdd->prepare($sql);
			$req->execute(array('%'.$valeur.'%', '%'.$valeur.'%'));
			$nombre = $req->rowCount();

			if($nombre >=1)
			{
				//Traitement pour le résultat
				$erreur = 'Nous avons '.$nombre.' résultat(s) pour <strong>\''.$valeur.'\'</strong>';
				echo'<br><br>';
				while($result= $req->fetch(PDO::FETCH_OBJ))
					{
						$bon="<ul>
								<li>
									Libellé: $result->LibelService
								</li>
								<li>
									Informations particulières: $result->InfoService
								</li>
								<li>
									Contact: $result->ContactService
								</li>
								<li>
									Entité mère: $result->RefEntite
								</li>
							  </ul>	";  
					}
			}
			else
			{
				$erreur = 'Aucun résulat trouvé pour la valeur: <strong>\''.$valeur.'\'</strong>';
			}
	  	}
	  	else
	  	{
	  		$sql=('SELECT PERSONNE.Nom,PERSONNE.Prenom, SERVICE.LibelService, AFFECTER.Poste FROM PERSONNE, SERVICE, AFFECTER WHERE PERSONNE.Matricule= AFFECTER.Matricule AND AFFECTER.RefService= SERVICE.RefService AND Poste LIKE ?');
	  		$req = $bdd->prepare($sql);
			$req->execute(array('%'.$valeur.'%'));
			$nombre = $req->rowCount();

			if($nombre >=1)
			{
				//Traitement pour le résultat
				$erreur = 'Nous avons '.$nombre.' résultat(s) pour <strong>\''.$valeur.'\'</strong>';
				echo'<br>';
				while($result= $req->fetch(PDO::FETCH_OBJ))
					{
						$bon="
						<ul>
								
								<li>
									Nom: $result->Nom
								</li>
								<li>
									Prénom: $result->Prenom
								</li>
								<li>
									Poste: $result->Poste
								</li>
								<li>
									Service: $result->LibelService
								</li>
							  </ul>	
							";  
					}
			}
			else
			{
				$erreur = 'Aucun résulat trouvé pour la valeur: <strong>\''.$valeur.'\'</strong>';
			}
	  	}
	  	
	}
	else
	  {
	  	$erreur="<i class='fa fa-times-circle' aria-hidden='true'></i>Veuillez remplir le champs de recherche";
	  }
}
?>

<html>
<head>
	<meta charset="utf-8">
	<title>Search</title>
	<link rel="stylesheet" type="text/css" href="CSS/style.css">
	<link href="https://fonts.googleapis.com/css?family=Roboto+Condensed" rel="stylesheet">
	<link rel="stylesheet" href="CSS/font-awesome.min.css">
	<link href="https://fonts.googleapis.com/css?family=Open+Sans+Condensed:300" rel="stylesheet">
	<meta name="viewport" content="width=device-width,initial-scale= 1.0">
</head>
<body >
	<?php include"Include/header.html" ?>
	<div id="search_page">
	<h2 align="center">RECHERCHE</h2>
	<!--<img class="icone" src="Images/698627-icon-111-search-512.png" width="40">-->
	<p>
		<form method="GET"><center>
			<table>
				<tr>
					<td></td>
					<td></td>
				</tr>
				<tr>
					<td align="right"><label> Entrer votre mot clé </label></td>
					<td><input class="loupe" type="search" name="valeur" placeholder= "" ></td>
				</tr>
				<tr>
	
					<td align="right"><label>Que recherchez-vous ?</label></td>
					<td><select name='filtre'>
							<option>Une personne</option>
							<option>Un numéro de téléphone</option>
							<option>Un service</option>
							<option>Un poste</option>
						</select>
					</td>
				</tr>
				<tr>
					<td></td>
					<td></td>
				</tr>
				<tr>
					<td></td>
					<td></td>
				</tr>
				<tr>
					<td></td>
					<td><input type="submit" name="valider" value="Rechercher"></td>
				</tr>
			</table>
			</center>
		</form>
		<br>
	</p>

<center>
<?php
    if(isset($erreur))
    {
    	echo '<span>'.$erreur.'</span>';
    }
?>
<?php
    if(isset($bon))
    {
    	echo '<span class="good">'.$bon.'</span>';
    }
?>
</center>
</div>
<?php include"Include/footer.html" ?>  
</body>
</html>