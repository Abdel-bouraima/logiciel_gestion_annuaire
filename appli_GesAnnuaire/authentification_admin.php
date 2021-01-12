<?php
session_start();
$bdd = new PDO('mysql:host=localhost;dbname=annuaire;charset=utf8', 'root', '');



   if(isset($_POST['valider']))
   {
      $login = htmlspecialchars($_POST['login']);
      $password = htmlspecialchars($_POST['password']);

   	if(!empty($_POST['login']) AND !empty($_POST['password']))
   	{
      $requete=$bdd->prepare('SELECT * FROM ADMIN WHERE Login=? AND Password=?');
      $requete->execute(array($login,$password));
      $existence=$requete->rowCount();

   		if ($existence!=0) 
        {
          $info=$requete->fetch();
          if($info['Role']==1)
          {
            $_SESSION['Login']= $info['Login'];
            $_SESSION['Password']=$info['Password'];
            $_SESSION['Matricule']=$info['Matricule'];
            header('Location: admin.php?id='.$_SESSION['Login']);
          }
          elseif($info['Role']==0)
          {
            $_SESSION['Login']= $info['Login'];
            $_SESSION['Password']=$info['Password'];
            $_SESSION['Matricule']=$info['Matricule'];
            header('Location: simple_admin.php?id='.$_SESSION['Login']);
          }
          else
          {
            $erreur = "<i class='fa fa-info' aria-hidden='true'></i>Veuillez contacter l'administrateur pour définir vos droits.";
          }
        }
        else 
        {
            $erreur ="<i class='fa fa-times-circle' aria-hidden='true'></i> Mot de passe ou login incorrect";
        }
   	}
   	else
   	{
         $erreur ="<i class='fa fa-times-circle' aria-hidden='true'></i> Veuillez remplir tout les champs";
   	}
   }

?>
    
<html>
<head>
	<meta charset="utf-8">
	<title>Page protégée</title>
</title>
	<link rel="stylesheet" type="text/css" href="CSS/style.css">
  <link rel="stylesheet" href="CSS/font-awesome-4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
	<meta name="viewport" content="width=device-width,initial-scale= 1.0">
  <style type="text/css">
    input[type="text"],input[type="password"],input[type="email"]
{
  height: 40px;
}
  </style>
</head>
<body>
<div style="text-align: center; ">
	<?php include"Include/header.html" ?>
  <!--<div style="background: url(Images/images.jpg) ; ">-->
	<h2>Authentification</h2>
	<p>
		Veuillez entrer votre login et votre mot de passe d'accès avant de continuer <br>
		<form method="POST">
			<input type="text" name="login" placeholder="Login"> <BR><BR>
			<input type="password" name="password" placeholder="Mot de passe"> <BR><BR><BR>
			<input type="submit" name="valider" value="Vérifier">
		</form>
    <br>
	</p>
<?php
	   if(isset($erreur))
	   {
           echo '<div class="admin"><span style="color: red">' .$erreur. '</span></div>';
	   }
	   
?>
</div>

<?php 
include"Include/footer.html" 
?>  
</body>
</html>