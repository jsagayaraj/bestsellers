<?php
	require_once("inc/init.inc.php");

	require_once ("inc/header.inc.php");
	require_once ("inc/menu.inc.php");



?>


<div id="main" class="shell">

	<section>
		<form id="global" method = "post" action = "">
			
			<fieldset>
				<div class="form-head">Contactez-nous</div>
				<?php	
					if(!utilisateurEstConnecte()){
						echo '<h4>Veuillez vous <a href = "connexion.php"><u><span style="color:#2EAEF0";>connecter</span></u></a> pour pouvoir NOUS contacter </h4>';
					}else
					{

						echo '<div class="blue-bg">';
						echo '<label  class = "well" >Nom</label>';
						echo '<label>'.$_SESSION['utilisateur']['nom'].'</label>';
						echo '</div>';


						echo '<div class="blue-bg" >';
						echo '<label  class = "well">Prenom</label>';
						echo '<label>'.$_SESSION['utilisateur']['prenom'].'</label>';
						echo '</div>';

						echo '<div class="blue-bg">';
						echo '<label  class = "well" for = "sujet">Email</label>';
						echo '<label>'.$_SESSION['utilisateur']['email'].'</label>';
						echo '</div>';

						echo '<div class="blue-bg">';
						echo '<label  class = "well"for = "sujet">Sujet</label>';
						echo '<input class = "type_text" type = "text" name = "sujet" placeholder="sujet..."/>';
						echo '</div>';

						echo '<div class="blue-bg">';
						echo '<label class = "well" id = "adresse_box" for = "adresse">Message</label>';
						echo '<textarea name = "message" cols="10" rows = "5" placeholder="message..."></textarea>';
						echo '</div>';
								
						echo '<div class="blue-bg" style="text-align:center;">';
						echo '<input  class= "type_submit" type = "submit" name = "inscription" value = "Envoyer"/>';
						echo '</div>';
					}

				if (isset($_POST['inscription']))
				{

					$to = "bjsahay@gmail.com";
					$nom = $_SESSION['utilisateur']['nom'];
					$prenom = $_SESSION['utilisateur']['prenom'];
					$header = 'from : '.$_SESSION['utilisateur']['email'];
					$subject = 'sujet : '.$_POST['sujet'];
					$message = 'message : '.$_POST['message'].'<br>';
					
					$sendmail = mail($to, $header, $subject,$message);

					if($sendmail == true) 
					{
						echo 'votre mail a été bine envoyer';
					}else
					{
						echo 'problem de connexion';
					}
				}


			?>
				
			
	
			<div class="google-map">
					<script src='https://maps.googleapis.com/maps/api/js?v=3.exp'></script><div style='overflow:hidden;height:200px;width:100%;'><div id='gmap_canvas' style='height:200px;width:100%;'></div><div><small><a href="http://embedgooglemaps.com">embed google map</a></small></div><div><small><a href="http://www.freedirectorysubmissionsites.com/">www.freedirectorysubmissionsites.com</a></small></div><style>#gmap_canvas img{max-width:none!important;background:none!important}</style></div><script type='text/javascript'>function init_map(){var myOptions = {zoom:8,center:new google.maps.LatLng(20.593684,78.96288000000004),mapTypeId: google.maps.MapTypeId.ROADMAP};map = new google.maps.Map(document.getElementById('gmap_canvas'), myOptions);marker = new google.maps.Marker({map: map,position: new google.maps.LatLng(20.593684,78.96288000000004)});infowindow = new google.maps.InfoWindow({content:'<strong>Indian Cronner</strong><br>India<br>'});google.maps.event.addListener(marker, 'click', function(){infowindow.open(map,marker);});infowindow.open(map,marker);}google.maps.event.addDomListener(window, 'load', init_map);</script>
			</div>

	
			</fieldset>
		
		
		</form>


		

	</section>


<!-- End Content -->
<div class="cl">&nbsp;</div>
	<?php 

		require_once("inc/footer.inc.php");

	?>
			
			

			
		
			
