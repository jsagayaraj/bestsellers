<?php 
function executeRequete($req)
{
	global $mysqli; // permet d'avoir la variable dans l'environnement local de la fonction.
	$resultat = $mysqli->query($req); // on exécute la requete reçue en argument.
	if(!$resultat)// équivalent à if($resultat == FALSE) // si c'est le cas alors il y a une erreur de requete.
	{
		die ("Erreur sur la requete SQL<br />Message: ".$mysqli->error . '<br />Code: '.$req); // s'il y a eu une erreur sur la requete, on affiche tout.
	}
	return $resultat; // on retourne l'objet issu de la classe Mysqli_result qui contient le resultat de la requete.
}
//--------------------------------------
function debug($var, $mode = 1)
{
	echo '<div>';	
	if($mode === 1)
	{
		echo '<pre>'; var_dump($var); echo '</pre>';
	}
	else {
		echo '<pre>'; print_r($var); echo '</pre>';
	}	
	echo '</div>';
	return;
}

/****************FONCTIONS USER **************/
function utilisateurEstConnecte ()
{
	// cette fonction indique si l'utilisateur est connecté.
	if(!isset($_SESSION['utilisateur']))
	{
		return FALSE;
	}
	else {
		return TRUE;
	}
}
//--------------------------------
function utilisateurEstConnecteEtEstAdmin ()
{
	if(utilisateurEstConnecte() && $_SESSION['utilisateur']['statut'] == 1)
	{ // on controle s'il est bien connecté et en plus si son statut est celui d'administrateur.(ici statut à 1 = administrateur)
		return TRUE;
	}
	return FALSE;
}
/**************** FIN FONCTIONS USER ***********/

function verificationExtensionPhoto()
{
	$extension = strrchr($_FILES['photo']['name'], '.'); // permet de retourner le texte contenu après le . (fourni en 2eme argument) en partant de la fin. Si le nom du fichier est pantalon.jpg => on récupère .jpg
	$extension = strtolower(substr($extension, 1)); // nous coupons le point avec substr et strtolower transforme d'éventuelles majuscule en minuscule.
	$tab_extension_valide = array("gif", "jpg", "jpeg", "png"); // on déclare un tableau array contenant les extension que nous autorisons.
	$verif_extension = in_array($extension, $tab_extension_valide); // in_array vérifi si la valeur du premier argument correspond à une des valeurs du tableau ARRAY. si c'est le cas $verif_extension contiendra TRUE sinon FALSE
	return $verif_extension; // on retourne le résultat qui sera soit TRUE soit FALSE !
}

/****************FONCTIONS PANIER **************/

// fonction qui crée le panier:
// nous créons dans la session un tableau ARRAY panier qui contiendra 4 tableaux ARRAY (prix, id, quantité, titre)

function creationDuPanier()
{
	if(!isset($_SESSION['panier'])) // si le panier n'existe pas
	{
		$_SESSION['panier'] = array();
		$_SESSION['panier']['titre'] = array();
		$_SESSION['panier']['id_article'] = array();
		$_SESSION['panier']['quantite'] = array();
		$_SESSION['panier']['prix'] = array();
		$_SESSION['panier']['photo'] = array();

	}
	return TRUE;
}

// fonction qui ajoute les bonnes informations d'un article dans le panier.

function ajouterArticleDansPanier($titre, $id_article, $quantite, $prix, $photo) // réception d'argument en provenance de panier.php
{
	// nous devons savoir si l'id_article que l'on souhaite ajouter est déjà présent dans le panier en cours
	$position_article = array_search($id_article, $_SESSION['panier']['id_article']); // la fonction array_search() nous donne l'index où se trouve l'article que l'on recherche (var_dump($position_article))
	if($position_article !== FALSE) // si l'article a été trouvé dans le panier.
	{
		$_SESSION['panier']['quantite'][$position_article] += $quantite; //si l'article a été trouvé alors on ne change que sa quantité en ajoutant la nouvelle quantité choisie.		
	}
	else { // sinon l'id_article n'est pas déjà présent dans le panier c'est donc un nouvel ajout.
	$_SESSION['panier']['titre'][] = $titre;	
	$_SESSION['panier']['id_article'][] = $id_article;	
	$_SESSION['panier']['quantite'][] = $quantite;	
	$_SESSION['panier']['prix'][] = $prix;
	$_SESSION['panier']['photo'][]	= $photo;
	}
}

function montantTotal() {
	$total = 0; // on prépare la variable afin de ne pas avoir d'erreur undefined lors de l'ajout des valeur dans cette variable
	if (isset($_SESSION['panier'])) {
		for($i = 0; $i < count($_SESSION['panier']['quantite']); $i++) // boucle qui parcourt tous les articles dans le panier
		{
			$total += $_SESSION['panier']['quantite'][$i] * $_SESSION['panier']['prix'][$i];
			// on multiplie la quantité par le prix de chaque article.
		}	
	}
	
	return round($total, 2); // prix total du panier (arrondi 2 chiffre après la virgule.)
}

//-------------------------------------

function retirerUnArticleDuPanier($article_a_supprimer)
{
	$position_article = array_search($article_a_supprimer, $_SESSION['panier']['id_article']); // retourne un chiffre correspondant à l'indice du tableau ARRAY où se trouve cette valeur (1er argument fourni)
	if($position_article !== FALSE) // si l'article est présent dans le panier, on le retire.
	{
		array_splice($_SESSION['panier']['titre'], $position_article, 1);
		array_splice($_SESSION['panier']['id_article'], $position_article, 1);
		array_splice($_SESSION['panier']['quantite'], $position_article, 1);
		array_splice($_SESSION['panier']['prix'], $position_article, 1);
		array_splice($_SESSION['panier']['photo'], $position_article, 1);
		// array_splice (à ne pas conforndre avec array_slice) permet de retirer un élément d'un tableau ARRAY et de réordonner les indices du tableau afin de ne pas avoir de trou dans le tableau.
	}
	
}

/*function add_Items(){
	if(isset('add_cart')){
		for($i = 0; $i < count($_SESSION['panier']['quantite']); $i++) // cette boucle tourne autant de fois qu'il y a d'article dans le panier.
	{
					
		echo $_SESSION['panier']['quantite'][$i];
		
	}
	return TRUE;
}*/

 ?>

