<?php
	require_once("inc/init.inc.php");


	require_once("inc/header.inc.php");
	require_once("inc/menu.inc.php");


?>
<div id="main" class="shell">
<!-- Content -->
<div class="product-page">
	<div class="form-head">Products</div><br />
	<!-- Products -->
	
	
	<?php 
		
		$resultat = executeRequete("SELECT * FROM article");
		
		while($article = $resultat->fetch_assoc())
		{
			echo '<div class="metirials each-items" title="details">';
				echo '<div class="info">';
					echo '<img src="'.$article['photo'].'" alt="" />';
					echo '<span class="title">'.$article['titre'].'</span>';
					
					echo '<span class="description">'.substr($article['description'], 0, 150).'...</span>';
				echo '</div>';
			 	echo '<a href="javascript:void(0);" class="buy-btn" id="'. $article['id_article'] . '" title="Add to cart">BUY NOW '.$article['prix'].' €</a>';
			 	echo '<a href ="details_article.php?id_article='.$article['id_article'].'" class="price">Details</a>';
			echo '</div>';
		}
			
	?>

	
</div>
<!-- End Content -->
<div class="cl">&nbsp;</div>
	
<?php 

	require_once("inc/footer.inc.php");

?>
		

			
		
			
