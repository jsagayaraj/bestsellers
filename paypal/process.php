<?php

require_once("../inc/init.inc.php");
require_once("../inc/header.inc.php");

include_once("config.php");
include_once("functions.php");
include_once("paypal.class.php");

$paypal= new MyPayPal();

if(isset($_POST['payer']) && $_POST['payer'] == 'Payer') {

	for($i = 0; $i < count($_SESSION['panier']['prix']); $i++) // boucle qui va nous permette de vérifier le stock restant de chaque article du panier
	{
		$id_article = $_SESSION['panier']['id_article'][$i];
		$resultat = executeRequete("SELECT stock FROM article WHERE id_article='$id_article'");
		$result = $resultat->fetch_assoc();
		
		if($result['stock'] < $_SESSION['panier']['quantite'][$i]) // si le stock est inférieur à la quantité demandée.
		{
			if($result['stock'] > 0) // il reste du stock mais inférieur à la quantité demandée
			{
				$_SESSION['panier']['quantite'][$i] = $result['stock']; // on change la quantité demandée par le stock restant de la BDD
			}
			else { // stock = 0
				retirerUnArticleDuPanier($_SESSION['panier']['id_article'][$i]); // on retire l'article
				$i--; // on décrémente car la fonction retirerUnArticleDuPanier() a réorganisée les indices ! pour ne pas rater un article lors du controle.
			}
		$erreur = TRUE; // variable qui nous permet de controler s'il y a au moins une erreur	
		}
	}

	if(isset($erreur)) {
		header("location:". RACINE_SITE ."payment.php?status=ERROR_STOCK");
	} else {
        $products = [];
        $charges  = [];

        for($i = 0; $i < count($_SESSION['panier']['quantite']); $i++) {
    		$id_article = $_SESSION['panier']['id_article'][$i];
			$resultat = executeRequete("SELECT * FROM article WHERE id_article='$id_article'");
			$result = $resultat->fetch_assoc();

			$products[$i]['ItemName']   = $result['titre']; 
			$products[$i]['ItemPrice']  = $result['prix'] * 1.2;
			$products[$i]['ItemNumber'] = $result['reference']; 
			$products[$i]['ItemDesc']   = $result['description']; 
			$products[$i]['ItemQty']	= $_SESSION['panier']['quantite'][$i];
        }
		
		$charges['TotalTaxAmount'] = 0;  //Sum of tax for all items in this order. 
		$charges['HandalingCost'] = 0;  //Handling cost for this order.
		$charges['InsuranceCost'] = 0;  //shipping insurance cost for this order.
		$charges['ShippinDiscount'] = 0; //Shipping discount for this order. Specify this as negative number.
		$charges['ShippinCost'] = 0; //Although you may change the value later, try to pass in a shipping amount that is reasonably accurate.
		
		// execute the "SetExpressCheckOut" method to obtain paypal token
		$paypal->SetExpressCheckOut($products, $charges);	
	} 
			
} elseif(_GET('token')!=''&&_GET('PayerID')!='') {
		//------------------DoExpressCheckoutPayment-------------------		
		$payment = $paypal->DoExpressCheckoutPayment();

		if ($payment) {
			$paymentId = $payment['TOKEN'];

			executeRequete("INSERT INTO commande (id_membre, montant, date) VALUES ('".$_SESSION['utilisateur']['id_membre']."', '".montantTotal()."', now())"); // on enregistre la commande en BDD
		
			$id_commande = $mysqli->insert_id; // propriété de l'objet $mysqli qui nous permet de récupérer le dernir id créé dans la table commande.
		
			for($i = 0; $i < count($_SESSION['panier']['quantite']); $i++)
			{ // pour chaque article dans le panier nous allons inscrire une ligne dans détails commande et mettre à jour le stock de l'article
				executeRequete("INSERT INTO details_commande (id_commande, id_article, quantite, prix) VALUES ($id_commande, '".$_SESSION['panier']['id_article'][$i]."', '".$_SESSION['panier']['quantite'][$i]."', '".$_SESSION['panier']['prix'][$i]."')");
				
				executeRequete("UPDATE article SET stock=stock-".$_SESSION['panier']['quantite'][$i]." WHERE id_article = '".$_SESSION['panier']['id_article'][$i]."'");	
			}
			
			executeRequete("INSERT INTO payment (commande, token, date) VALUES ('".$id_commande."', '".$paymentId."', now())"); // on enregistre la commande en BDD
		
			unset($_SESSION['panier']);

			//$msg .= '<div class="primiere" >Confirmation de votre commande, merci pour vos achats, Votre numéro de suivi est le: '.$id_commande.'</div>';
			mail($_SESSION['utilisateur']['email'], "Confirmation de votre commande", "Merci pour votre commande, votre numéro de suivi est le $id_commande", "From: vendeur@mail.fr");
			
			header("location:". RACINE_SITE ."payment.php?status=SUCCESS&code=" . $paymentId . '&commande=' . $id_commande);
		} else {
			header("location:". RACINE_SITE ."payment.php?status=ERROR");
		}
		
} else {
		
	header("location:". RACINE_SITE ."payment.php?status=ERROR");
}
