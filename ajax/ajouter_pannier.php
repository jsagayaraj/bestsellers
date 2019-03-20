<?php
require_once("../inc/init.inc.php");

if (isset($_GET['id'])) {
	$resultat = executeRequete("SELECT * FROM article WHERE id_article='$_GET[id]'");

	// on récupère les informations de l'article en BDD afin d'avoir le prix (sécurité !)
	$article = $resultat->fetch_assoc(); // traitement du résultat pour en obtenir un tableau ARRAY
	$article['prix'] = $article['prix'] * 1.2;

	creationDuPanier();
	ajouterArticleDansPanier($article['titre'], $article['id_article'], '1', $article['prix'], $article['photo']);

	echo montantTotal(); 

} else {
	echo '0';
}
	
