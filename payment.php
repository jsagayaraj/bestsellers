<?php
require_once("inc/init.inc.php");
require_once ("inc/header.inc.php");
require_once ("inc/menu.inc.php");
?>

<div id="main" class="shell">
	<section>
		<?php if (isset($_GET['status'])) :?>
			<?php if ($_GET['status'] == 'SUCCESS'):?>
				<div class="primiere" >
					Confirmation de votre commande, merci pour vos achats, Votre numéro de suivi est le:
					<?php 
						if(isset($_GET['commande'] )) {
							echo $_GET['commande'];
						}
					?>
					<br/>
					Reference transaction paypal. 
					<?php 
						if(isset($_GET['code'] )) {
							echo $_GET['code'];
						}
					?>
				</div>
			<?php elseif ($_GET['status'] == 'ERROR_STOCK') : ?>
				<div class="error">
					L'article a été retiré de votre panier car nous sommes en rupture de stock, Veuillez vérifier votre commande
				</div>
			<?php else : ?>
				<div class="error">
					ERROR: Payment not processed
				</div>
			<?php endif ?>
		<?php else : ?>
			<div class="error">
					ERROR: Payment not processed
			</div>
		<?php endif ?>
	</section>
	
	<!-- End Content -->
	<div class="cl">&nbsp;</div>
	<?php 
	require_once("inc/footer.inc.php");
	?>
			
			

			