<?php
require_once("../inc/init.inc.php");
require_once("../inc/header.inc.php");
require_once("../inc/menu.inc.php");


if(!utilisateurEstConnecteEtEstAdmin())
{
	header("location:../connexion.php");
	exit();
}

?>

<div id="main" class="shell">
	<section>
			<fieldset>
				<div class="form-head">Newsletter</div>
				<form id="global" method ="post" action = "envoi_newsletter.php">
				<div class="blue-bg">
				<label class = "well" for = "expediteur">Expéditeur</label>
				<input class = "type_text" type = "text" id = "expediteur" name = "expediteur"/>
				</div>

				<div class="blue-bg">
				<label class = "well" for = "sujet">Sujet</label>
				<input  class = "type_text" type = "text" id = "sujet" name = "sujet"/>
				</div>
				
				<div class="blue-bg">
				<label class = "well" id = "message" for = "adresse">Message</label>
				<textarea id = "message" name = "message"></textarea>
				</div>

				<div class="blue-bg" style ="text-align:center;">
				<input  class= "type_submit" type = "submit" id = "send" name = "send" value = "Envoi de la Newsletter aux membres"/>
				</div>
			</fieldset>	

		</form>
	</section>
<div class="cl">&nbsp;</div>

	  
<?php
require_once("../inc/footer.inc.php");


