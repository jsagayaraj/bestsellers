<?php
	require_once("inc/init.inc.php");

	require_once ("inc/header.inc.php");
	require_once ("inc/menu.inc.php");


if(isset($_POST['valider']))
	{
		$selection_membre = executeRequete("SELECT * FROM membre WHERE email='$_POST[email]'");
			if($selection_membre->num_rows == 0)
			{
				$msg .="<div class='error'>Cette adresse mail n'est pas valide, vérifier votre saisie.</div>";
			}
			else
			{
				$newpw = substr(md5(uniqid(rand(), true)), 3, 10); // Génération d'un nouveau mot de passe.
				$changepw = executeRequete("UPDATE membre SET mdp='$newpw' WHERE email='$_POST[email]'"); // Mise à jour du mot de passe dans la base de données.
				$message = "Votre mot de passe a été réinitialisé. Il est maintenant : ".$newpw;
				mail ($_POST['email'], 'Votre nouveau mot de passe', $message, 'From:adminlokisalle.com');
				echo $msg .="<div class='primiere'>Nous vous avons renvoyé un mail avec votre nouveau mot de passe.</div>";
			}
}


?>


<div id="main" class="shell">

<?php 
	echo $msg;
?>

	<section>
		<form id="global" nam="lostpw" method="post" action=" ">
			<fieldset>
				<div class="form-head">Mot de passe oubié</div>
					<div class="blue-bg">
					<p style="text-align:center;"><b>Afin de pouvoir réinitialiser votre mot de passe, veuillez saisir votre adresse mail
					</b></p>
					</div>

					<div class="blue-bg">
					<label class="well" for="email">Email : </label>
					<input class="type_text" type="email" id="email" name="email"/>
					</div>

					<div class="blue-bg" style="text-align:center;">
					<input class= "type_submit" type="submit" name="valider" value="Valider"/>
					</div>

			</fieldset>
					
		</form>			
					
	</section>

<!-- End Content -->
<div class="cl">&nbsp;</div>

<?php 

	require_once("inc/footer.inc.php");

?>
			
			

			
		
			
