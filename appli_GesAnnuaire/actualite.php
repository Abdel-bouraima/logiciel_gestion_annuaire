<?php
$bdd = new PDO('mysql:host=localhost;dbname=annuaire;charset=utf8', 'root', '');

$req = $bdd->query('SELECT * FROM ACTUALITE WHERE Publication=1 ORDER BY DateActu DESC  LIMIT 0,3');


?>
<html>
<head>
	<meta charset="utf-8">
	<title>Toutes les actualités</title>
	<link rel="stylesheet" type="text/css" href="CSS/style.css">
	<meta name="viewport" content="width=device-width,initial-scale= 1.0">
	<style type="text/css">
		li.content{ list-style-type: square; }
	</style>
</head>
<body>
<div style="text-align: center;">
	<?php include"Include/header.html" ?>
	<h2>Actualités</h2>
	<div id="actu"><p>
		<b>Toutes les actualités </b>
		<marquee direction="down"><ul class="show_news">
			<?php while ($actu = $req-> fetch()) { ?>
		<div id="actu">
			<li class="content">
				<?= $actu['Contenu'] ?>
			</li> </div>
			<?php } ?>
		</ul></marquee>
	</p>
	</div>
</div>
<?php include"Include/footer.html" ?>  
</body>
</html>