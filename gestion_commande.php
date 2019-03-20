<?php
require_once("../inc/init.inc.php");

	
if(!utilisateurEstConnecteEtEstAdmin())
{
	header("location:../connexion.php");
	exit();
}
else{
	require_once ("../inc/header.inc.php");
	require_once ("../inc/menu.inc.php");
}

?>


<div id="main" class="shell">

	<section>
<div class="form-head">Liste des Commandes</div>
<?php  
		$resultat = executeRequete("SELECT * FROM commande");


	echo "<h4>Liste des commandes : " . $resultat->num_rows."</h4>";
	echo "<div>";
	echo "<table style ='margin-top:15px;'> <tr>";
	echo "<th>id_commande</th>";
	echo '<th>id_membre</th>';
	echo '<th>montant <a href="gestion_commande.php?orderMontant=asc"><i style="font-size:18px"; class="fa fa-sort-asc"></i></a><a href="gestion_commande.php?orderMontant=desc"><i style="font-size:18px;" class="fa fa-sort-desc"></i></a></th>';
/*	$nbcol = $resultat->field_count;
	for ($i=0; $i < $nbcol; $i++)
	{    
		$colonne = $resultat->fetch_field(); 
		echo '<th>' . $colonne->name . '</th>';
	}*/
	
	echo "</tr>";

	$total=0;
	while ($ligne = $resultat->fetch_assoc())
  	{  
		echo '<tr>';
		echo '<td><a href="detail_commande.php?commande='.$ligne['id_commande'].'">'.$ligne['id_commande'].'</a></td>';
		echo '<td>'.$ligne['id_membre'].'</td>';
		echo '<td>'.$ligne['montant'].'</td>';
		echo '</tr>';
		$total = $total+$ligne['montant'];//chiffre de affaire;
	}


/*else 
{
	echo 'Il faut un commande id.';
}*/
	echo '</table>';
	echo "</div>";
	echo '<h4>Le Chiffre d\'affaires: '.$total.' €</h4>';
?>
		

	</section>


<!-- End Content -->
<div class="cl">&nbsp;</div>
<?php 

	require_once("../inc/footer.inc.php");

?>
			
			

			
		
			
