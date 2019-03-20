<?php
require_once("inc/init.inc.php");


if(utilisateurEstConnecte()) // Verification de la connextion de l'utilisateur
{
	header("location:index.php"); // s'il l'est il est renvoyé vers sa page de profil
}

if(isset($_GET['action']) && $_GET['action'] == 'deconnexion')
{
	//session_start();
	//setcookie('pseudo','',time()-3600);
	//setcookie('mdp','',time()-3600);
	//$_SESSION = array();
	session_destroy();
	//header("location:connexion.php");
	// unset($_SESSION['utilisateur']);
}


if(isset($_POST['connexion']))
		{

			//$pseudo = htmlentities($_POST['pseudo'], ENT_QUOTES);
			$email = htmlentities($_POST['email'], ENT_QUOTES);
			$mdp = htmlentities($_POST['mdp'], ENT_QUOTES);

			  $selection_membre =  executeRequete("SELECT * FROM membre WHERE email='$email'"); //On vérifie que le pseudo existe dans la base de données.
			  if($selection_membre->num_rows !=0)
				{
						$membre = $selection_membre->fetch_assoc();
						if($membre['mdp'] == $mdp) //On vérifie si le mot de passe saisi par l'utilisateur correspond à celui de la base de données.
						{
							foreach($membre as $indice => $valeurs)
							  {
								if($indice != 'mdp')
								if(isset($_POST['rememberme'])){
									setcookie('pseudo',$_POST['pseudo'], time()+365*24*3600,null,null,false,true);
									setcookie('mdp',$_POST['mdp'], time()+365*24*3600,null,null,false,true);

								}
									{
										$_SESSION['utilisateur'][$indice] = $valeurs;
									}
							  }

							  if (isset($_POST['redirect_panier']) && $_POST['redirect_panier'] == true) {
						  			header("location:panier.php"); 
							  } else {
							  		header("location:index.php"); //Si le pseudo et le mot de passe sont corrects, l'utilisateur est renvoyé vers sa page de profil.
							  }
						}
						else //Le mot de passe est incorrect : 
						{
						  $msg .="<div class='error'>Mot de passe incorrect.</div>";
						}
				}
		  else //Le pseudo est incorrect :
		  {
			  $msg .="<div class='error'>Email incorrect.</div>";    
		  }
		}


require_once ("inc/header.inc.php");
require_once ("inc/menu.inc.php");


?>


		<div id="main" class="shell">
		<?php 
			echo $msg;
		 ?>
			
		<section >
			<form id = "global" method="post" action = "">
				<div class="con-page">
					<fieldset>
						<div class="form-head">Connexion</div>
						<p class = "text-connexion-su">Déjà membre?</p>
						<div class = "blue-bg">
							<label class = "well text" for = "pseudo">Email</label>
							<input class = "type_text connexion" type = "text" id = "pseudo" name = "email" value = "<?php if(isset($_POST['email'])) { echo $_POST['email']; } ?>"  placeholder="Email..."/>
						</div>
							
						<div class = "blue-bg">
							<label class = "well text" for = "mdp">Mot de passe</label>
							<input class = "type_text connexion" type ="password" id = "mdp" name = "mdp" maxlength="14" value = ""   placeholder="Mot de passe..."/>
						</div>
						<div class = "blue-bg">
							<label class="well text" for="remembercheckbox">Se souvenir de moi</label>
							<input class= "type_radio rd-con"; type ="checkbox" name = "rememberme" id="rememberme" />
							<span class="mdp"><a href = "mdpperdu.php">Mot de passe oublié?</a></span>
						</div>

						<div class = "blue-bg" style="text-align:center;">
						<input  class= "type_submit" type = "submit" id = "connexion" name = "connexion" value = "Connexion">
						</div>

						<?php
							echo '<p class="text-connexion-su">Pas encore membre?</p>';
							echo '<p class="text-connexion"><a href = "'.RACINE_SITE.'inscription.php">Inscrivez-vous</a></p>';
							
							if (isset($_GET['redirect_panier'])) {
								echo '<input class= "hidden" type ="hidden" name = "redirect_panier" id="redirect_panier" value="true"/>';
							}
						?>
						

					</fieldset>
				</div>
				
			</form>
</section>
		
		
		<!-- End Content -->
		<div class="cl">&nbsp;</div>
	<?php 

		require_once("inc/footer.inc.php");

	?>
			
			

			
		
			
