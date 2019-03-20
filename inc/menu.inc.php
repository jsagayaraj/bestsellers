
	<!-- Header -->
	<div id="header" class="shell">
		 
		<?php 
		echo '<div id="logo"><h1><a href="'.RACINE_SITE.'index.php"">BestSeller</a></h1><span><a href="'.RACINE_SITE.'index.php">Indian online store</a></span></div>';
		//echo '<div id="logo"><h1><a href="'.RACINE_SITE.'index.php""><img src ="images/logo.png"/></a></h1><span><a href="'.RACINE_SITE.'index.php">Indian online store</a></span></div>';
		 ?>
		<!-- Navigation -->
		<div id="navigation">
			<ul>
				<?php 
					if(utilisateurEstConnecte())
					{
						echo '<li><a href="'.RACINE_SITE.'index.php" class="active">Home</a></li>';
						echo '<li><a href="'.RACINE_SITE.'products.php">Products</a></li>';
						echo '<li><a href="'.RACINE_SITE.'promotion.php">Promotions</a></li>';
						echo '<li><a href="'.RACINE_SITE.'panier.php">panier</a></li>';
						echo '<li><a href="?action=deconnexion">Deconnecter</a></li>';
						
					}
					else{	

						echo '<li><a href="'.RACINE_SITE.'index.php" class="active">Home</a></li>';
						echo '<li><a href="'.RACINE_SITE.'products.php">Products</a></li>';
						echo '<li><a href="'.RACINE_SITE.'promotion.php">Promotions</a></li>';
						echo '<li><a href="'.RACINE_SITE.'connexion.php">Connexion</a></li>';
						echo '<li><a href="'.RACINE_SITE.'inscription.php">Inscriptions</a></li>';
						//echo '<li><a href="'.RACINE_SITE.'contact.php">Contacts</a></li>';
					}
					if (utilisateurEstConnecteEtEstAdmin()){	
							
							echo '<li><a href="'.RACINE_SITE.'admin/gestion_membre.php">Gestion des Membre</a></li>';
							echo '<li><a href="'.RACINE_SITE.'admin/gestion_produit.php">Gestion des Produits</a></li>';
							echo '<li><a href="'.RACINE_SITE.'admin/gestion_commande.php">Gestion des Commandes</a></li>';
							echo '<li><a href="'.RACINE_SITE.'admin/gestion_avis.php">Gestion des Avis</a></li>';
							echo '<li><a href="'.RACINE_SITE.'admin/gestion_promos.php">Gestion codes Promo</a></li>';
							echo '<li><a href="'.RACINE_SITE.'admin/newsletter.php">Envoyer la newsletter</a></li>'; 
				 	}		echo '<li><a href="'.RACINE_SITE.'contact.php">Contacts</a></li>';

				 	if(utilisateurEstConnecte() && isset($_GET['action']) && $_GET['action'] == 'deconnexion')
						{
						session_destroy();
						header("location:". RACINE_SITE ."connexion.php");
						}
						if(utilisateurEstConnecteEtEstAdmin() && isset($_GET['action']) && $_GET['action'] == 'deconnexion')
						{
						session_destroy();
						header("location:". RACINE_SITE ."connexion.php");
						}
		 ?>
			</ul>
		</div>
		<!-- End Navigation -->
		<div class="cl">&nbsp;</div>
		<!-- Login-details -->
		<?php 
			echo '<div id="login-details">';
			echo '<p>Welcome, <a href="'.RACINE_SITE.'profil.php" id="user"> ';

				if(utilisateurEstConnecte()){
					echo strtoupper($_SESSION['utilisateur']['nom']).' '.ucfirst($_SESSION['utilisateur']['prenom']);
				}
			echo '</a></p> ';
			echo '<p><a href="panier.php" class="cart" ><img src="images/cart-icon.png" alt="shopping cart" /></a><span class="sum1">Shopping Cart </span> <a href="panier.php" class="sum"><span class="sum_header">' .montantTotal(). '</span>€ TTC</a></p>';
			echo '</div>';
		 ?>
		<!-- End Login-details -->
	</div>
	<!-- End Header -->
	<!-- Slider -->
	<div id="slider">
		<div class="shell">
			<ul>
				<li>
					<div class="image">
						<img src="images/girl2.jpg" alt="" />
						<img src="../images/girl2.jpg" alt="" /><!-- cet balise image pour l'affichage d'admin page -->
					</div>
					<div class="details">
						<h2>Indian corners</h2>
						<h3>Special Offers</h3>
						<p class="title">Pellentesque congue lorem quis massa blandit non pretium nisi pharetra</p>
						<p class="description">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent id odio in tortor scelerisque dictum. Phasellus varius sem sit amet metus volutpat vel vehicula nunc lacinia.</p>
						
					</div>
				</li>
				<li>
					<div class="image">
						<img src="images/girl1.jpg" alt="" />
						<img src="../images/girl1.jpg" alt="" /><!-- cet balise image pour l'affichage d'admin page -->
					</div>
					<div class="details">
						<h2>Indian corners</h2>
						<h3>Special Offers</h3>
						<p class="title">Pellentesque congue lorem quis massa blandit non pretium nisi pharetra</p>
						<p class="description">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent id odio in tortor scelerisque dictum. Phasellus varius sem sit amet metus volutpat vel vehicula nunc lacinia.</p>
						
					</div>
				</li>
				<li>
					<div class="image">
						<img src="images/girl3.jpg" alt="" />
						<img src="../images/girl3.jpg" alt="" /><!-- cet balise image pour l'affichage d'admin page -->
					</div>
					<div class="details">
						<h2>Indian corners</h2>
						<h3>Special Offers</h3>
						<p class="title">Pellentesque congue lorem quis massa blandit non pretium nisi pharetra</p>
						<p class="description">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent id odio in tortor scelerisque dictum. Phasellus varius sem sit amet metus volutpat vel vehicula nunc lacinia.</p>
						
					</div>
				</li>
				<li>
					<div class="image">
						<img src="images/girl2.jpg" alt="" />
						<img src="../images/girl2.jpg" alt="" />
					</div>
					<div class="details">
						<h2>Indian corners</h2>
						<h3>Special Offers</h3>
						<p class="title">Pellentesque congue lorem quis massa blandit non pretium nisi pharetra</p>
						<p class="description">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent id odio in tortor scelerisque dictum. Phasellus varius sem sit amet metus volutpat vel vehicula nunc lacinia.</p>
						
					</div>
				</li>
			</ul>
			<div class="nav">
				<a href="#">1</a>
				<a href="#">2</a>
				<a href="#">3</a>
				<a href="#">4</a>
			</div>
		</div>
	</div>
	<!-- End Slider -->
	<!-- Main -->
	<!-- <div id="main" class="shell">
		Content -->
		<!--<div id="content"> -->