<?php
require_once("../inc/init.inc.php");


if(!utilisateurEstConnecteEtEstAdmin())
{
	header("location:../connexion.php");
	exit();
}else{
	require_once("../inc/header.inc.php");
	require_once("../inc/menu.inc.php");
}
?>

<div id="main" class="shell">

<?php  
// SUPPRESSION DE PRODUITS
if(isset($_GET['action']) && $_GET['action'] == 'suppression')
{
	$resultat = executeRequete("SELECT * FROM article WHERE id_article = '$_GET[id_article]'"); // on récupère les informations de l'article afin de connaitre son image pour pouvoir la supprimer
	$article_a_supprimer = $resultat->fetch_assoc();
	$chemin_article = RACINE_SERVER . $article_a_supprimer['photo']; // nous avons besoin du chemin epuis la racine serveur pour supprimer la photo du serveur
	
	if(!empty($article_a_supprimer['photo']) && file_exists($chemin_article)) // file_exists() vérifie si le fichier existe bien.
	{
		unlink($chemin_article); // unlink() va supprimer le fichier du serveur.
	}
	echo '<div class="primiere">Suppression de larticle:' .$_GET[id_article]. '</div>';
	executeRequete("DELETE FROM article WHERE id_article = '$_GET[id_article]'");
	$_GET['action'] = 'affichage';
}


// ENREGISTREMENT DES PRODUITS
if(isset($_POST['enregistrement']))
{
	$reference = executeRequete("SELECT reference FROM article WHERE reference='$_POST[reference]'"); // requete qui va interroger la BDD pour voir si la reference saisie existe !
	if($reference->num_rows > 0 && isset($_GET['action']) && $_GET['action'] == 'ajout') // si la référence existe déjà et qu'il s'agit bien d'un ajout
	{
		$msg .= '<div class="error" style="margin-top: 20px; padding:10px; text-align: center;"><h4>La référence est déjà attribuée, veuillez vérifier votre saisie !</h4></div>';
	}
	else { // sinon la référence est valable.
		// $msg .= 'TEST';
		
		$photo_bdd = ""; // evite une erreur lors de la requete INSERT si le commercant ne charge pas une photo.
		
		if(isset($_GET['action']) && $_GET['action'] == 'modification')
		{
			$photo_bdd = $_POST['photo_actuelle']; // dans le cas d'une modification on récupère la photo actuelle avant de vérifier si l'utilisateur en charge une nouvelle.
		}
		
		if(!empty($_FILES['photo']['name']))
		{ // on vérifie si une photo a bien été postée.
			if(verificationExtensionPhoto())
			{
				// $msg .= '<div class="bg-success" style="margin-top: 20px; padding:10px; text-align: center;"><h4>OK</h4></div>';
				$nom_photo = $_POST['reference'] . '_' . $_FILES['photo']['name']; // afin que le nom de chaque photo soit unique.
				$photo_bdd = RACINE_SITE . "photo/$nom_photo"; // chemin src que l'on va enregistrer dans la BDD
				$photo_dossier = RACINE_SERVER . RACINE_SITE . "photo/$nom_photo"; // chemin pour l'enregistrement dans le dossier quiva servir dans la fonction copy()
				copy($_FILES['photo']['tmp_name'], $photo_dossier); // copy() permet de copier un fichier depuis un endroit (1er argument) vers un autre endroit (2ème argument).
				
			}
			else{
				$msg .= '<div class="error">L\'extension de la photo n\'est pas valide (png, gif, jpg, jpeg) !</div>';
			}			
		}
		if(empty($msg)) // s'il n'y a pas de message d'erreur, nous pouvons enregistrer les produits.
		{
			$msg .= '<div class="primiere">Enregistrement de l\'article !</div>';
			
			foreach($_POST AS $indice => $valeur)
			{
				$_POST[$indice] = htmlentities($valeur, ENT_QUOTES);
			}
			extract($_POST);
			
			if(isset($_GET['action']) && $_GET['action'] == 'modification')
			{
				executeRequete("UPDATE article SET categorie = '$categorie', titre = '$titre', description = '$description', couleur = '$couleur', taille = '$taille', sexe = '$sexe', photo = '$photo_bdd', prix = '$prix', promo = '$promo', stock = '$stock', keywords = '$keywords' WHERE id_article = '$_POST[id_article]'");
			}
			else {
				executeRequete("INSERT INTO article (reference, categorie, titre, description, couleur, taille, sexe, photo, prix, promo, stock, keywords) VALUES ('$reference', '$categorie', '$titre', '$description', '$couleur', '$taille', '$sexe', '$photo_bdd', '$prix', '$promo', '$stock', '$keywords')");
			}
			$_GET['action'] = 'affichage';
			
		}
		
	}
}
// FIN ENREGISTREMENT DES PRODUITS

echo $msg;
// debug($_POST);
// debug($_FILES);
// debug($_SERVER);

   
    
		
		echo '<a href="?action=affichage" class="affiche">Affichage des articles</a> |';
		echo '<a href="?action=ajout" class="ajout">Ajout d\'un article</a>';
      


/*** AFFICHAGE DES ARTICLES ***/
if(isset($_GET['action']) && $_GET['action'] == 'affichage')
{
	echo '<div>';
		echo '<div class="affichage">Affichage des articles</div>';
	
	
	echo '<table> <tr>';
	$resultat = executeRequete("SELECT * FROM article");
	$nb_col = $resultat->field_count; // on récupère le nb de champs contenu dans notre résultat.
	
	for($i = 0; $i < $nb_col; $i++)
	{
		$colonne = $resultat->fetch_field();
		// debug($colonne);
		echo '<th>'.$colonne->name .'</th>';
	}
	echo '<th>Modif</th>';
	echo '<th>Suppr</th>';
	echo '</tr>';
	
	while($ligne = $resultat->fetch_assoc())
	{
		echo '<tr>';
		foreach($ligne AS $indice => $valeur)
		{
			if($indice == 'photo')
			{
				echo '<td><img src="'.$valeur.'" width="100" /></td>';
			}
			elseif($indice == 'description')
			{
				echo '<td>'.substr($valeur, 0, 70).'...</td>';
			}
			elseif($indice == 'promo')
			{
					$resultat_promo = executeRequete("SELECT * FROM promotion WHERE id_promo = '$valeur'");
					$promo_val = $resultat_promo->fetch_assoc();
					echo '<td>'.$promo_val['reduction'].'</td>';
			}
			else {
				echo '<td>'.$valeur.'</td>';
			}			
		}
		echo '<td><a href="?action=modification&id_article='.$ligne['id_article'].'" <i class="fa fa-pencil-square-o" title = "modifier" style="color:green; font-size:18px;"></i></a></td>';

		echo '<td><a href="?action=suppression&id_article='.$ligne['id_article'].'" onClick="return(confirm(\'En êtes vous certain\'));"><i title = "supprimer" class="fa fa-trash" style="color:red; font-size:18px;"></i></a></td>';
		echo '</tr>';
	}
	
	echo '</table>';	
	echo '</div>';
	
}



/*** FORMULAIRE ENREGISTREMENT DES ARTICLES ***/
if(isset($_GET['action']) && ($_GET['action'] == 'ajout' || $_GET['action'] == 'modification'))
{
	
	if(isset($_GET['id_article']))
	{
		$resultat = executeRequete("SELECT * FROM article WHERE id_article='$_GET[id_article]'"); // dans le cas d'une modif, l'id_article est présent dans l'url. On fait donc une requete pour récupérer les informations de cet article.
		$article_actuel = $resultat->fetch_assoc(); // on transforme la ligne de résultat en tableau ARRAY 
		// debug($article_actuel);
	}

	// Promotion
	$resultat_promo = executeRequete("SELECT * FROM promotion"); // dans le cas d'une modif, l'id_article est présent dans l'url. On fait donc une requete pour récupérer les informations de cet article.
	$promotions = $resultat_promo->fetch_all(); // on transforme la ligne de résultat en tableau ARRAY 
?>
<!-- <div id="main" class="shell">-->		
	<section>

		<form id="global" method="post" action="" enctype="multipart/form-data" >
		<!-- l'attribut enctype="multipart/form-data" est obligatoire afin de pouvoir récupérer les pièces jointes du formulaire (champs file updload) le fichier sera dans la superglobale $_FILES -->

		<fieldset>
			<div class="form-head">Gestion de produit</div>
			<input type="hidden" name="id_article" id="id_article" value="<?php if(isset($article_actuel['id_article'])) { echo $article_actuel['id_article'];} ?>" />

			<div class ="blue-bg">
			<label class ="well" for="reference">Référence</label>
			<input type="text" id="reference" name="reference" value="<?php if(isset($article_actuel['reference'])) { echo $article_actuel['reference'];} ?><?php if(isset($_POST['reference'])) { echo $_POST['reference']; } ?>" placeholder="Référence..." class="type_text" />
			</div>
				
			<div class ="blue-bg">
			<label class ="well"  for="categorie">Catégorie</label>
			<input type="text" id="categorie" name="categorie" value="<?php if(isset($article_actuel['categorie'])) { echo $article_actuel['categorie'];} ?><?php if(isset($_POST['categorie'])) { echo $_POST['categorie']; } ?>" placeholder="Catégorie..." class="type_text" />
			</div>
				
			<div class ="blue-bg">
			<label class="well" for="titre">Titre</label>
			<input type="text" id="titre" name="titre" value="<?php if(isset($article_actuel['titre'])) { echo $article_actuel['titre'];} ?><?php if(isset($_POST['titre'])) { echo $_POST['titre']; } ?>" placeholder="Titre..." class="type_text" />
			</div>

			<div class ="blue-bg">	
			<label class ="well" for="description">Description</label>
			<textarea id="description" name="description"  placeholder="Description..."><?php if(isset($article_actuel['description'])) { echo $article_actuel['description'];} ?><?php if(isset($_POST['description'])) { echo $_POST['description']; } ?></textarea>
			</div>
				

			<div class ="blue-bg">
			<label class ="well"  for="couleur">Couleur</label>
			<input type="text" id="couleur" name="couleur" value="<?php if(isset($article_actuel['couleur'])) { echo $article_actuel['couleur'];} ?><?php if(isset($_POST['couleur'])) { echo $_POST['couleur']; } ?>" placeholder="Couleur..." class="type_text" />
			</div>

			<div class ="blue-bg">
			<label class ="well" for="taille">Taille</label>
			<select name="taille" id="taille" >
			<option></option>		
			<option <?php if(isset($article_actuel['taille']) && $article_actuel['taille'] == "M") { echo "selected";} ?> <?php if(isset($_POST['taille']) && $_POST['taille'] == 'M') { echo "selected"; }?>>S</option>
			<option <?php if(isset($article_actuel['taille']) && $article_actuel['taille'] == "M") { echo "selected";} ?> <?php if(isset($_POST['taille']) && $_POST['taille'] == 'M') { echo "selected"; }?>>M</option>
			<option <?php if(isset($article_actuel['taille']) && $article_actuel['taille'] == "L") { echo "selected";} ?><?php if(isset($_POST['taille']) && $_POST['taille'] == 'L') { echo "selected"; }?>>L</option>
			<option <?php if(isset($article_actuel['taille']) && $article_actuel['taille'] == "XL") { echo "selected";} ?><?php if(isset($_POST['taille']) && $_POST['taille'] == 'XL') { echo "selected"; }?>>XL</option>
			</select>
			</div>

			<div class ="blue-bg">	
			<label class ="well" for="sexe">Sexe</label>
			<input type="radio" name="sexe" value="m" class="type_radio" <?php if(isset($article_actuel['sexe']) && $article_actuel['sexe'] == "m") { echo 'checked';}elseif(isset($_POST['sexe']) && $_POST['sexe'] == "m") { echo 'checked';}elseif(!isset($_POST['sexe']) && !isset($article_actuel['sexe'])) { echo 'checked'; } ?> />Homme
				
			<input type="radio" name="sexe" value="f" class="type_radio" <?php if(isset($article_actuel['sexe']) && $article_actuel['sexe'] == "f") { echo "checked";} ?><?php if(isset($_POST['sexe']) && $_POST['sexe'] == "f") { echo 'checked';} ?> />Femme
			</div>

			<div class ="blue-bg">				
			<label class ="well" for="photo">Photo</label>
			<input type="file" id="photo" name="photo"  class="type_text" />
			<?php
				if(isset($article_actuel)) // si article actuel existe alors nous sommes dans une modification et nous affichons la photo actuelle par défaut.
				{
					echo '<label>Photo Actuelle</label><br />';
					echo '<img src="'.$article_actuel['photo'].'" width="140" /><br/>';
					echo '<input type="hidden" name="photo_actuelle" value="'.$article_actuel['photo'].'" />';		
				}
			?>
			</div>

			<div class ="blue-bg">
			<label class ="well" for="prix">Prix</label>
				<input type="text" id="prix" name="prix" value="<?php if(isset($article_actuel['prix'])) { echo $article_actuel['prix'];} ?><?php if(isset($_POST['prix'])) { echo $_POST['prix']; } ?>" placeholder="Prix..." class="type_text" />
			</div>
				
			<div class ="blue-bg">
			<label class ="well" for="promo">Promos</label>
			<select name="promo" id="taille" >
				<option value="0"></option>		
				<?php foreach ($promotions as $promotion) : ?>
					<option value="<?php echo $promotion[0]; ?>" <?php if (isset($article_actuel['promo']) && $article_actuel['promo'] == $promotion[0]) { echo 'selected'; } ?>><?php echo $promotion[2]; ?></option>	
				<?php endforeach ?>
			</select>
			</div>

			<div class ="blue-bg">
			<label class ="well" for="stock">Stock</label>
			<input type="text" id="stock" name="stock" value="<?php if(isset($article_actuel['stock'])) { echo $article_actuel['stock'];} ?><?php if(isset($_POST['stock'])) { echo $_POST['stock']; } ?>" placeholder="Stock..." class="type_text" />
			</div>

			<div class ="blue-bg">
			<label class ="well" for="keywords">Keywords</label>
			<input type="text" id="keywords" name="keywords" value="<?php if(isset($article_actuel['keywords'])) { echo $article_actuel['keywords'];} ?><?php if(isset($_POST['keywords'])) { echo $_POST['keywords']; } ?>" placeholder="Keywords..." class="type_text" />
			</div>

			<div class ="blue-bg" style="text-align:center;">	
			<input class ="type_submit" type="submit" id="enregistrement" name="enregistrement" value="<?php echo ucfirst($_GET['action']); // ucfirst() met la première lettre en majuscule ?>" />
			</div>
		</fieldset>	

		</form>
	</section>
	<div class="cl">&nbsp;</div>
<?php
}
?>

	  
<?php
require_once("../inc/footer.inc.php");


