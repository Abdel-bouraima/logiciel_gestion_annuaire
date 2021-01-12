<!DOCTYPE html>
<html>
<head>
	<title>Annuaire du personnel de l'uac</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width,initial-scale= 1.0">
	<link href="https://fonts.googleapis.com/css?family=PT+Sans+Narrow" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Yanone+Kaffeesatz" rel="stylesheet">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous"> 
	<style type="text/css">
	    marquee, div.intro { font-family: 'Yanone Kaffeesatz', sans-serif; font-size: 20px; }
	    li{ list-style-type: none;}
		nav.menu li{ list-style-type: none; display: inline-block; }
		a{ text-decoration: none; }
		li:hover { text-decoration: underline; color: #2196F5; transition: 2.3s ; }
		div.welcome {background: url(Images/Annuaire.jpg) no-repeat ; background-size: 100%; }
		p.caracter{ font-family: 'PT Sans Narrow', sans-serif; font-size: 80px; }
		h2{ color: red; }
		.info{ margin: 10px;}
		.actu{ border: 1px solid #5DADE2; }
		footer{ clear: both; }
		div.uac{ margin-left: 30px; }
		nav.autre a, div.uac h3{ color:  #bdc3c7 ; /*font-size: 22px; */}
		div.uac h3{ font-size: 28px;}
		nav.autre a{ font-size: 20px;}
		/*a:visited{
			color: #2E4053;
			}
			*/
	</style>
</head>
<body>
	<header style="background-color: #2196F5;">
		<div style="text-align: right;">
		<nav class="menu">
 			<ol>
 				<li>
 					<a href="recherche.php" title="Recherche"><pre> Recherche </pre> </a>
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
 					<a href="annuaire.php" title="Tout le personnel">Annuaire</a>
 				</li>
 				
                <li>
                    <a href="actualite.php">Actualités</a>
                </li>
                <li>
 					<a href="categorie.php">Catégories</a>
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
                    <a href="contact.php">Nous contacter</a><!--
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
 	 <div class="contenu">
 	  <div class="welcome"><br><br><br><br><br><br><br><br><br><br><br><br>
 	 	<p class="caracter">BIENVENUE! </p>
 	  </div>
 	 	<!--<div class="actu" style="float: left;">
 	 		<h2> Actualités</h2>
 	 		<marquee direction="up"> Aucune nouvelle actualité pour le moment<br>
            Ici, nos verrez toutes les notifications concernant le personnel<br>
            Que ce soit l'arrivée d'un nouvel employé<br>
            ou l'inscription d'un nouvel membre<br> </marquee>
 	 	</div>-->
 	 	<div class="intro">
 	 		<p>Ici vous trouverez toutes les informations sur les membres du personnel de l'université.<br> Vous pourrez aussi communiquer avec eux.<br>
            Vous pouvez aussi faire des recherches à partir d'une information.</p>
 	 	</div>
 	 </div>
 	 <footer style="opacity: 0.75;"> <br> <br>
 	 	<hr>
 	 	<center>Copyright © 2017 Abomey-calavi, All rights reserved</center>
 	 </footer>
</body>
</html>