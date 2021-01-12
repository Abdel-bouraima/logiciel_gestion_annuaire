<?php

$bdd = new PDO('mysql:host=localhost;dbname=annuaire;charset=utf8', 'root', '');


if(isset($_GET['valider']))
{
  $matricule=htmlspecialchars($_GET['matricule']);

    if(isset($_GET['matricule']) AND !empty($_GET['matricule']))
    {
      $search = $bdd->prepare('SELECT * FROM PERSONNE WHERE Matricule=?');

      $search-> execute(array($matricule));

      $exist = $search->rowCount();

      if($exist == 0)
      {
        $erreur = '<i class="fa fa-times-circle" aria-hidden="true"></i> Ce matricule n\'existe pas. Veuillez entrer un matricule valide.';
      }
      else
      {
        $sql=('SELECT * FROM PERSONNE WHERE Matricule LiKE ?');
        $req = $bdd->prepare($sql);
      $req->execute(array($matricule));
      while($result= $req->fetch(PDO::FETCH_OBJ))
          {
            if( $result->Autorisation==0)
              {
                $erreur = '<p><i class="fa fa-times-circle" aria-hidden="true"></i> Désolé! Vous n\'avez pas accès à l\'annuaire <br>
                  Contactez <a href="mailto:baamouinz14@gmail.com">l\'administrateur</a> pour y avoir accès.
                        </p>';
              }
              else
              {
              header('location:accueil.php');
              }
          }
      }
    
  }
  else
    {
      $erreur = '<i class="fa fa-times-circle" aria-hidden="true"></i> Veuillez saisir votre matricule';
    }
}


?>
<html>
<head>
	<meta charset="utf-8">
	<title>Annuaire</title>
	<link rel="stylesheet" type="text/css" href="CSS/style.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
  <link rel="stylesheet" href="CSS/font-awesome-4.7.0/css/font-awesome.min.css">
	<meta name="viewport" content="width=device-width,initial-scale= 1.0">
	<link href="https://fonts.googleapis.com/css?family=PT+Sans+Narrow" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Yanone+Kaffeesatz" rel="stylesheet"> 
	<style type="text/css">
	    marquee, div.intro { font-family: 'Yanone Kaffeesatz', sans-serif; font-size: 20px; }
	    li{ list-style-type: none;}
		nav.menu li{ list-style-type: none; display: inline-block; }
		a{ text-decoration: none; }
		li:hover { text-decoration: underline; color: #2196F5; transition: 2.3s ; }
		div.welcome {background: url(Images/Annuaire.jpg) no-repeat ; background-size: 100%; }
		div.contenu{ margin-left: 15%; margin-right: 15%; }
		p.caracter{ font-family: 'PT Sans Narrow', sans-serif; font-size: 80px; }
		h2{ color: red; }
		.info{ margin: 10px;}
		.actu{ border: 1px solid #5DADE2; }
		footer{ clear: both; }
		div {text-align: center;}
    body{text-align: center;}
    div.uac{ margin-left: 30px; }
    nav.autre  a{ color: #2E4053; }
    /*a{ color: #2E4053; }*/
    div.form{ margin-left: 5%; }
    nav.autre a, div.uac h3{ color:  #bdc3c7 ; /*font-size: 22px; */}
    div.uac h3{ font-size: 28px;}
    nav.autre a{ font-size: 20px;}
	</style>
</head>
<body>
	<header style="background-color: #2196F5;">
		<div style="text-align: right;">
		<nav class="menu">
 			<ol>
 				<li>
 					<a href="#" title="Recherche"><pre> Recherche </pre> </a>
 				</li>
 				<li>
 					<a href="authentification_admin.php" title="Espace réservée à l'administrateur"><pre> Admin </pre></a>
 				</li>
 			</ol>
 		</nav>
 		</div>
    <div class="uac">
   		<a href="http://www.uac.bj/" title="Site officiel de l'uac" target="_blank">
   			<center><img src="Images/logouac.jpg" width="120px" height="120px">  <br>
   				<h3>Annuaire du personnel de l'UAC</h3> </center></a>
    </div>
 		<nav class="autre" >
 			<ul><center>
 				<li>
 					<a href="#" title="Page d'accueil"> Accueil</a>
 				</li>
 				<li>
 					<a href="#" title="Tout le personnel">Annaire</a>
 				</li>
        <li>
                    <a href="#">Actualités</a>
                </li>
 				<li>
 					<a href="#">Catégories</a>
 					<!--<ul>
 						<li>
 							<a href="#">Personnel administratif</a>
 						</li>
 						<li>
 							<a href="#">Personnel enseignant</a>
 						</li>
 					</ul>-->
 				</li>
                
                <li>
                    <a href="#">Nous contacter</a><!--
                    <ul>
                        <li>
                            <a href="mailto:baamouinz14@gmail.com">Par mail</a>
                        </li>
                        <li>
                            <a href="#">Adresse</a>
                        </li>
                    </ul>-->
                </li>
 			</ul>
 			</center>
 		</nav>
 	 </header>
   <div class="uac">
	<h2>Authentification</h2>
  <div class="form">
  <form method="GET">
    <center>
    <table>
      <tr>
        <td align="center">
          <label>Veuillez entrer votre matricule avant de continuer</label>
        </td>
      </tr>
      <tr>
        <td>
          
        </td>
      </tr>
      <tr>
        <td>
          <input type="number" name="matricule">
        </td>
      </tr>
      <tr>
        <td>
          
        </td>
      </tr>
      <tr>
        <td>
          
        </td>
      </tr>
      <tr>
        <td>
          <input type="submit" name="valider" value="Entrer">
        </td>
      </tr>
      </center>
    </table>
  </form>
  </div>
<br><br>
  <?php

    if(isset($erreur))
    {
      echo '<div class="admin"><span>'.$erreur.'</span></div>';
    }
  ?>
</div>
</body>
</html>
<?php include"Include/footer.html" ?>  
</body>
</html>