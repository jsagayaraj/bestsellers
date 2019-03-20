<?php
	require_once("inc/init.inc.php");

	require_once ("inc/header.inc.php");
	require_once ("inc/menu.inc.php");



	if(isset($_GET['id_article']))
	{
		$resultat = executeRequete("SELECT * FROM article WHERE id_article='$_GET[id_article]'");
		if($resultat->num_rows <= 0)
		{
			header("location:index.php");
			exit();
		}
	}
	else { // s'il n'y a pas d'id_article dans l'url
		header("location:index.php");
		exit();
	}

	$article = $resultat->fetch_assoc();
	
   

echo '<div id="main" class="shell">';
	echo $msg;
	echo '<div class="form-head">Product details</div>';

	echo '<div class="product-page">';

		echo '<h4>'.$article['titre'].'</h4>';
		echo '<div class="left-side">';
			echo '<img  src="'.$article['photo'].'" style="max-width: 100%;" />';
		echo '</div>';

		echo '<div class="right-side">';
			echo '<p><strong>Description: </strong>'.$article['description'].'</p>';
			echo '<p><strong>Catégorie: </strong>'.$article['categorie'].'</p>';
			echo '<p><strong>Taille: </strong>'.$article['taille'].'</p>';
			echo '<p><strong>Couleur: </strong>'.$article['couleur'].'</p>';
			echo '<p><strong>Prix HT: </strong>'.$article['prix'].' €</p>';

			if($article['stock'] > 0)
			{
				echo '<p><strong>Stock: </strong>'.$article['stock'].'</p>';
				
				echo '<form method="post" action="panier.php">';
					echo '<input type="hidden" name="id_article" value="'.$article['id_article'].'" />';
					echo '<label style="margin-top:10px;" for="quantite"><strong>Quantité &nbsp &nbsp</strong></label>';
					echo '<select style="margin-top:10px;"id="quantite" name="quantite"  style="width: 50px;">';
						for($i = 1; $i <= $article['stock'] && $i <= 10; $i++)
						{
							echo '<option>'.$i.'</option>';
						}
					echo '</select><br/>';
					echo '<input type="submit" name="ajout_panier" value="Ajouter au panier" class="btn-ajout-panier"/>';
					
				
				echo '</form>'; 
				
			}
			else {
				echo '<p style="color:red"><strong>Rupture de stock pour ce produit>/strong></p>';
			}
			
	
		echo '<h4><a href="index.php?categorie='.$article['categorie'].'" >Retour à votre sélection</a></h4>';
		echo '</div>';

	
		
	echo '</div>';
	echo '<div class="clear"></div>';
	echo '<hr />';

//**************************************FIN DETAILS PAGE *************************

//*************************************** AVIS*******************************************


	echo '<div class="product-page">';

               echo '<h4>Avis</h4>';
               //$affiche = executeRequete("SELECT id_salle, commentaire, note, date_format(date,'%d/%m/%Y') As date_fr, date_format(date, '%H:%i') As heure_fr, membre.`nom` FROM avis INNER JOIN membre ON avis.`id_membre`=`membre`.id_membre ORDER BY date DESC LIMIT 0,5");

                $affiche = executeRequete("SELECT id_article, commentaire, note, date_format(date,'%d/%m/%Y') As date_fr, date_format(date, '%H:%i') As heure_fr, membre.`nom` FROM avis INNER JOIN membre ON avis.`id_membre`=`membre`.id_membre WHERE `avis`.`id_article` = '$_GET[id_article]' ORDER BY date DESC LIMIT 0,5");

              while ($comments = $affiche->fetch_assoc())
              {
                echo '<p>'.$comments['nom'].', le '.$comments['date_fr'].' à '.$comments['heure_fr']. ' '.$comments['note'].'</p>';
                echo '<p>'.$comments['commentaire'].'</p><hr>';
              }
               
                  if(!utilisateurEstConnecte())
                  {
                    echo '<p>Il faut être <a href="connexion.php">connecté</a> pour pouvoir déposer des commentaires</p>';
                  }else
                  {
                    echo '<form id="global" method="post" action="">';
                    echo '<div class="blue-bg">';
                    echo '<label class="well" for ="message">Note</label>';

                    echo '<select class="select_avis" name="note">';
                    echo '<option value="1/10">01/10</option>';
                    echo '<option value="2/10">02/10</option>';
                    echo '<option value="3/10">03/10</option>';
                    echo '<option value="4/10">04/10</option>';
                    echo '<option value="5/10">05/10</option>';
                    echo '<option value="6/10">06/10</option>';
                    echo '<option value="7/10">07/10</option>';
                    echo '<option value="8/10">08/10</option>';
                    echo '<option value="9/10">09/10</option>';
                    echo '<option value="10/10">10/10</option>';
                  	echo '</select>';
                  	echo '</div>';

                echo '<div class="blue-bg">';
                echo '<label class="well" for ="message">Ajouter un commentaire</label>';
                echo '<textarea class="textarea" type name="message" cols="10" rows="5"></textarea>';
                echo '</div>';

                echo '<div class="blue-bg" style="text-align:center">';
                echo '<input class="type_submit" type="submit" name="soumettre" value="Soumettre">';
                echo '</div>';
                echo '</form>';
                    
                  }


            if ($_POST){
                $id_membre = $_SESSION['utilisateur']['id_membre'];
                $id_article = $article['id_article'];
                $message = htmlentities($_POST['message'], ENT_QUOTES);
                $note = $_POST['note'];

                $resultat = executeRequete("INSERT INTO avis (id_membre, id_article, commentaire, note, date) VALUES ('$id_membre','$id_article','$message','$note', NOW())");
                  // requete BD table avis
            }
              
	echo '</div>';

            
?>
	
	<!-- End Content -->
	<div class="cl">&nbsp;</div>
<?php 

	require_once("inc/footer.inc.php");

?>
			
			

			
		
			
