<?php
//$mysqli = @new Mysqli("cl1-sql20", "hht19711", "2slDNSTEWpi", "hht19711");
$mysqli = @new Mysqli("localhost", "root", "", "bestsellers"); // le @ permet d'éviter le message d'erreur généré par php afin de le gérer nous même.
if($mysqli->connect_error)
{
	die ("Un problème est survenu lors de la tentative de connexion à la BDD: ".$mysqli->connect_error);
}
// JAMAIS de ma vie je ne mettrais un @ en PHP sauf si j'ai décidé de gérer moi-même l'erreur proprement avec un IF

$mysqli->set_charset("utf-8"); // en cas de prob d'encodage avec l'utf-8 en BDD




