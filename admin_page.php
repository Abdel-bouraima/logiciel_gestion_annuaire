<?php 
session_start();
$bdd = new PDO('mysql:host=localhost;dbname=annuaire;charset=utf8', 'root', '');

if(isset($_POST['modifier']) AND !empty($_POST['modifier']))
{
	$newlogin = htmlspecialchars($_POST['newlogin']);
	$newpassword = htmlspecialchars($_POST['newpassword']);
	if(!empty($_POST['newlogin']) AND !empty($_POST['newpassword']) AND !empty($_POST['again']))
	{
		if ($newpassword == $_POST['again'] ) 
		{
			$requete=$bdd->prepare('SELECT * FROM ADMIN WHERE Login=? AND Password=?');
      		$requete->execute(array($newlogin,$newpassword));
      		$existence=$requete->rowCount();
			if($existence ==0)
			{
			$update= $bdd->prepare('UPDATE ADMIN SET Login=?,Password=? WHERE Matricule=?');
			$update->execute(array($newlogin,$newpassword,$_SESSION['Matricule']));
			$notification="<i class='fa fa-thumbs-up' aria-hidden='true'></i> Modification effectuée";
			}
			else
			{
				$notification="<i class='fa fa-times-circle' aria-hidden='true'></i>Aucune modification effectuée!!! ";
			}
		}
		else
		{
			$notification="<i class='fa fa-times-circle' aria-hidden='true'></i>Mots de passe non identiques ";
		}
	}
	else
	{
		$notification= "<i class='fa fa-times-circle' aria-hidden='true'></i>Veuillez remplir tous les champs";
	}
}

?>
<html>
<head>
	<meta charset="utf-8">
	<title>Changer informations</title>
	<link rel="stylesheet" type="text/css" href="CSS/style.css">
	<meta name="viewport" content="width=device-width,initial-scale= 1.0">
</head>
<body style="text-align: center;">
	<?php include"Include/header_admin.html" ?>
	<h2>Modifier vos informations</h2><br>
	<form method="POST">
		<input type="text" name="matricule" value="Votre matricule: <?=$_SESSION['Matricule']  ?>" disabled='disabled'><br><br>
		<input type="text" name="newlogin" placeholder="Nouveau login"> <br><br>

		<input type="password" name="newpassword" placeholder="Nouveau mot de passe"><br><br>
		<input type="password" name="again" placeholder="Confirmer le nouveau mot de passe"><br><br>
		
		<input onclick="if(confirm('Vous etes sur le point de modifier vos paramètres de connexion. Voulez-vous continuer ?')){ document.location.href = url;} else {return false}" type="submit" name="modifier" value="Modifier">
	</form>

<?php
	if(isset($notification))
	{
		echo'<div class="admin"><span>'.$notification.'</span><div>';
	}


?>

<?php 
include"Include/footer.html" 
?>  
</body>
</html>