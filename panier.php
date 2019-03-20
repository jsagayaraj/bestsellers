<?php
require_once("inc/init.inc.php");

require_once("inc/header.inc.php");
require_once("inc/menu.inc.php");
creationDuPanier(); // creation du panier, s'il est déjà créé, cette fonction ne l'écrase pas.

// VIDER LE PANIER
if(isset($_GET['action']) && $_GET['action'] == 'vider')
{
	unset($_SESSION['panier']); // on vide le panier.
	creationDuPanier();
}
//--------FIN VIDER LE PANIER---------

//----------PARTIE PAIEMENT DU PANIER----------
/* 
Si fait en GET
if(isset($_GET['action']) && $_GET['action'] == 'payer')
{
	
} */
/*
// en POST:
if(isset($_POST['payer']) && $_POST['payer'] == 'Payer')
{
	for($i = 0; $i < count($_SESSION['panier']['prix']); $i++) // boucle qui va nous permette de vérifier le stock restant de chaque article du panier
	{
		$id_article = $_SESSION['panier']['id_article'][$i];
		$resultat = executeRequete("SELECT stock FROM article WHERE id_article='$id_article'");
		$result = $resultat->fetch_assoc();
		
		if($result['stock'] < $_SESSION['panier']['quantite'][$i]) // si le stock est inférieur à la quantité demandée.
		{
			if($result['stock'] > 0) // il reste du stock mais inférieur à la quantité demandée
			{
				$msg .= '<div class="error" >La quantité de l\'article n°'.$_SESSION['panier']['id_article'][$i].' a été modifié car notre stock était insuffisant, Veuillez vérifier votre commande</div>';
				
				$_SESSION['panier']['quantite'][$i] = $result['stock']; // on change la quantité demandée par le stock restant de la BDD
			}
			else { // stock = 0
				$msg .= '<div class="error">L\'article n°'.$_SESSION['panier']['id_article'][$i].' a été retiré de votre panier car nous sommes en rupture de stock, Veuillez vérifier votre commande</div>';
				retirerUnArticleDuPanier($_SESSION['panier']['id_article'][$i]); // on retire l'article
				$i--; // on décrémente car la fonction retirerUnArticleDuPanier() a réorganisée les indices ! pour ne pas rater un article lors du controle.
			}
		$erreur = TRUE; // variable qui nous permet de controler s'il y a au moins une erreur	
		}
	}
	
	if(!isset($erreur)) // on vérifie s'il n'y a pas eu une erreur lors du controle des stock
	{
		executeRequete("INSERT INTO commande (id_membre, montant, date) VALUES ('".$_SESSION['utilisateur']['id_membre']."', '".montantTotal()."', now())"); // on enregistre la commande en BDD
		
		/* // même chose :
		$id_membre = $_SESSION['utilisateur']['id_membre'];
		$montant = montantTotal();
		executeRequete("INSERT INTO commande (id_membre, montant, date) VALUES ('$id_membre', '$montant', now())");
		*/
		/*
		$id_commande = $mysqli->insert_id; // propriété de l'objet $mysqli qui nous permet de récupérer le dernir id créé dans la table commande.
		
		for($i = 0; $i < count($_SESSION['panier']['quantite']); $i++)
		{ // pour chaque article dans le panier nous allons inscrire une ligne dans détails commande et mettre à jour le stock de l'article
			executeRequete("INSERT INTO details_commande (id_commande, id_article, quantite, prix) VALUES ($id_commande, '".$_SESSION['panier']['id_article'][$i]."', '".$_SESSION['panier']['quantite'][$i]."', '".$_SESSION['panier']['prix'][$i]."')");
			
			executeRequete("UPDATE article SET stock=stock-".$_SESSION['panier']['quantite'][$i]." WHERE id_article = '".$_SESSION['panier']['id_article'][$i]."'");	
		}
		unset($_SESSION['panier']);
		$msg .= '<div class="primiere" >Confirmation de votre commande, merci pour vos achats, Votre numéro de suivi est le: '.$id_commande.'</div>';
		//mail($_SESSION['utilisateur']['email'], "Confirmation de votre commande", "Merci pour votre commande, votre numéro de suivi est le $id_commande", "From: vendeur@mail.fr");
		
	}
}
*/


// RETIRER UN ARTICLE DU PANIER
if(isset($_GET['action']) && $_GET['action'] == 'retirer')
{
	retirerUnArticleDuPanier($_GET['id_article']);
}

// AJOUT D'ARTICLE dans le panier
if(isset($_POST['ajout_panier'])) // ce post provient de la page fiche_article.php
{
	$resultat = executeRequete("SELECT * FROM article WHERE id_article='$_POST[id_article]'");
	// on récupère les informations de l'article en BDD afin d'avoir le prix (sécurité !)
	$article = $resultat->fetch_assoc(); // traitement du résultat pour en obtenir un tableau ARRAY
	$article['prix'] = $article['prix'] * 1.2; // calcul du prix en rajoutant la TVA
	ajouterArticleDansPanier($article['titre'], $_POST['id_article'], $_POST['quantite'], $article['prix'], $article['photo']) ; // on rajoute l'article dans le panier
	//header("location:panier.php"); // pour éviter de rajouter plusieurs fois l'article dans le panier si F5
	echo "<script>window.open('panier.php','_self'></script>";
}
	
// debug($_SESSION['panier']);
// debug($_POST);
?>    

<div id="main" class="shell">
	
	<section>
<?php
echo $msg;
echo '<table border="1" style="text-align: center;">';
//echo '<tr><td colspan="5">PANIER</td></tr>';
echo '<tr><div class="form-head">PANIER</tr>';
echo '<tr><th>Titre</th><th>Photo</th><th>Article</th><th>Quantité</th><th>Prix</th><th>Action</th></tr>';


if(empty($_SESSION['panier']['id_article']))
{
	echo '<tr><td colspan="5"><h3>Votre panier est vide</h3></td></tr>';
}
else {
	
	for($i = 0; $i < count($_SESSION['panier']['titre']); $i++) // cette boucle tourne autant de fois qu'il y a d'article dans le panier.
	{
		echo '<tr>';
		echo '<td width="100px"><strong>'.$_SESSION['panier']['titre'][$i].'<strong></td>';
		echo '<td width="300px"><strong><img src="'.$_SESSION['panier']['photo'][$i].'" width="10%"</strong></td>';
		echo '<td><strong>'.$_SESSION['panier']['id_article'][$i].'</strong></td>';
		echo '<td><strong>'.$_SESSION['panier']['quantite'][$i].'</strong></td>';
		echo '<td><strong>'.$_SESSION['panier']['prix'][$i].'</strong></td>';

		
		echo '<td><a href="?action=retirer&id_article='.$_SESSION['panier']['id_article'][$i].'" ><i title = "supprimer" class="fa fa-trash" style="color:red; font-size:18px;"></i></a></td>';
		
		echo '</tr>';
	}
	
	echo '<tr><th colspan="4">Montant total</th><td colspan="1"><strong>'.montantTotal().' € </strong></td></tr>';
// Exercice:
// si l'utilisateur est connecté, afficher un bouton payer.
// sinon afficher du texte avec des liens qui proposent de se connecter ou de s'inscrire.

	echo '<tr>';
	if(utilisateurEstConnecte())
	{
		echo '<td colspan="5">';
		echo '<form method="post" action="paypal/process.php">';
		//echo '<script>window.open("index.php","_self")</script>';
		echo '<a href="' . RACINE_SITE . 'index.php" class="cont-shop">Continue Shopping</a>';
		echo '<input type="submit"  name="payer" class="btn-ajout-panier" value="Payer" />';
		echo '</form>';
		echo '</td>';
	}
	else {
		echo '<td colspan="5">Pour valider vos achats, veuillez vous <a href="connexion.php?redirect_panier=true" > connecter</a> ou vous <a href="inscription.php" >inscrire</a></td>';
	}
	
	echo '</tr>';
	
	echo "<tr><td colspan='5'><a href='?action=vider'>Vider le panier</a></td></tr>";
}


echo '</table>';


echo '<hr /><p>Tous nos article ont un prix calculé avec le taux de TVA à 20%</p><hr />';
// si l'utilisateur est connecté, afficher son adresse de livraison
?>
</section>
		<!-- End Content -->
		<div class="cl">&nbsp;</div>

<?php		
if(utilisateurEstConnecte())
{
	echo '<h3>Vos informations de livraison:</h3>';
	echo '<address><strong>'.$_SESSION['utilisateur']['nom']. ' | '.$_SESSION['utilisateur']['prenom']. '</strong><br />';
	echo $_SESSION['utilisateur']['adresse'] . '<br />';
	echo $_SESSION['utilisateur']['ville'] . '<br />';
	echo $_SESSION['utilisateur']['cp'] . '<br />';
	echo '</address>';
}

// exercice:
// afficher tous les prix présent dans le panier avec un retour à la ligne.

/* for($i = 0; $i < count($_SESSION['panier']['titre']); $i++)
{
	echo $_SESSION['panier']['prix'][$i] .' - '.$_SESSION['panier']['quantite'][$i] . '<br />';
}*/
 


require_once("inc/footer.inc.php");

?>	  
		

	  
	  



