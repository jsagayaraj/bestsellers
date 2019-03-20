<?php
require_once("../inc/init.inc.php");

	if (isset($_POST)){
		$expediteur = $_POST['expediteur'];
		$sujet = $_POST['sujet'];
		$message = $_POST['message'];
		$headers = "From: " . $expediteur;

		 $resultat = executeRequete("SELECT membre.email FROM membre INNER JOIN newsletter ON newsletter.id_membre = membre.id_membre");
		 echo '<h4>Nombre d\'abonné à la newsletter :' . $resultat->num_rows.'</h4>';
		
		 while ($ligne = $resultat->fetch_assoc()) {
		 	mail($ligne['email'],$sujet,$message,$headers);
		 }
		 header('../location:index.php');
	}


?>