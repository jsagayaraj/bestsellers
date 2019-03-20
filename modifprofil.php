<?php
	require_once("inc/init.inc.php");

	require_once ("inc/header.inc.php");
	require_once ("inc/menu.inc.php");



?>


<div id="main" class="shell">

	<section>
        	<form id="global" method ="post" action = "updateProfile.php">
        			
                	<fieldset>
                        	<div class="form-head">Modifications de vos données personnelles</div>
                        	  
                                <div class="blue-bg">
                                <label class="well" for="pseudo">Pseudo</label>
                                <input class="type_text" type="text" id="pseudo" name="pseudo" value="<?php echo $_SESSION['utilisateur']['pseudo']?>">
                                </div>

                                <div class="blue-bg">
                                <label class="well" for="nom">Nom</label>
                                <input  class="type_text" type="text" id="nom" name="nom" value="<?php echo $_SESSION['utilisateur']['nom']?>" title="caractères acceptés : a-zA-Z0-9_." >
                                </div>

                                <div class="blue-bg">
                                <label class="well"for="prenom">Prénom</label>
                                <input class="type_text" type="text" id="prenom" name="prenom" value="<?php echo $_SESSION['utilisateur']['prenom'] ?>" title="caractères acceptés : a-zA-Z0-9_."  >
                        	</div>

                        	<div class="blue-bg">
                        	<label class="well"for="changemdp">Mot de passe</label>
                                <input class="type_reset mdpmodif" type="submit" id="changemdp" name="changemdp" value="Changer votre mot de passe">
                        	</div>

                        	<div class="blue-bg">
                                <label class="well"for="email">Email</label>
                                <input class="type_text" type="email" id="email" name="email" value="<?php echo $_SESSION['utilisateur']['email'] ?>" title="votre email" ><br>
                                </div>

                                <div class="blue-bg">
                                <label class="well"for="sexe">Sexe</label>
                                <input class="type_radio" type="radio" name="sexe" value="m" <?php if($_SESSION['utilisateur']['sexe'] == 'm') echo 'checked' ?>>Homme
                                <input class="type_radio" type="radio" name="sexe" value="f" <?php if($_SESSION['utilisateur']['sexe'] == 'f') echo 'checked' ?> >Femme<br>
                                </div>

                                <div class="blue-bg">
                                <label class="well"for="ville">Ville</label>
                                <input class="type_text" type="text" id="ville" name="ville" value="<?php echo $_SESSION['utilisateur']['ville'] ?>" title="caractères acceptés : a-zA-Z0-9_." >
                                </div>
                                
                                <div class="blue-bg">
                                <label class="well"for="cp">Code Postal</label>
                                <input class="type_text" type="text" id="cp" name="cp" value="<?php echo $_SESSION['utilisateur']['cp'] ?>" title="5 chiffres requis : [0-9]" maxlength="5" > 
                                </div>

                                <div class="blue-bg">
                                <label class="well"for="adresse">Adresse</label>
                                <textarea id="adresse" name="adresse" title="caractères acceptés : a-zA-Z0-9_." ><?php echo $_SESSION['utilisateur']['adresse'] ?></textarea>
                        	</div>

                                <div class="blue-bg">
                        	<input name="changeinfoprofil" type="submit" class="type_submit" value="Mettre à jour mes informations">
                                </div>

                	</fieldset>
        	</form>

	</section>


<!-- End Content -->
<div class="cl">&nbsp;</div>
	<?php 

		require_once("inc/footer.inc.php");

	?>
			
			

			
		
			
