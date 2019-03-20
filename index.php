<?php
	require_once("inc/init.inc.php");


	require_once("inc/header.inc.php");
	require_once("inc/menu.inc.php");


?>



<div id="main" class="shell">
<!-- <span id="preloader" style="display:none;"><i class="fa fa-spinner"></i></span> -->
<!-- Sidebar -->
<div class="search-box">
	<form action="index.php" method="get" enctype="multipart/form-data">
		<input type="text" class="type_text sr-box" name="user_query" placeholder="search"/>
		<input type="submit" class="type_submit sr-btn" name="search" value="Ok"/>
	</form>
</div> 
<div id="sidebar">
	 <ul class="categories">
		<li>
			<h4>Categories</h4>

			<ul>
				<?php
					// récupérer la liste des catégories en BDD et les afficher ici par ordre alphabétique dans une liste UL LI
					$resultat = executeRequete("SELECT DISTINCT categorie FROM article ORDER BY categorie");
					
					while($categorie = $resultat->fetch_assoc())
					{
					echo '<li><a href="?categorie='.$categorie['categorie'].'">'.$categorie['categorie'].'</a></li>';
					}	
				
				?>
			</ul>

			<div class="by-price">
				<form action="index.php" method="post" >
					<h4>By Price</h4>
						<ul>
							<li> 10€ - 20€ <input class="in-price" name="prix[]" value="20" type="checkbox"></li>
							<li> 20€ - 30€ <input class="in-price" name="prix[]" value="30" type="checkbox"></li>
							<li> 30€ - 40€ <input class="in-price" name="prix[]" value="40" type="checkbox"></li>
						</ul>
					<input type="submit" name="search_price" class="type_submit" value="search">

				</form>
			</div>	
			<!--<li><a href="#">Women</a></li>
					<div class="sub-categories">
						<ul>
							<li><a href="">Chudithars</a></li>
							<li><a href="">Sarees</a></li>
						</ul>
					</div>
				<li><a href="#">Kids</a></li>
					<div class="sub-categories">
						<ul>
							<li><a href="">Jeans</a></li>
							<li><a href="">T-Shirts</a></li>
						</ul>
					</div>
				<li><a href="#">Accessories</a></li>
					<div class="sub-categories">
						<ul>
							<li><a href="">Jeweles</a></li>
							<li><a href="">Bags</a></li>
						</ul>
					</div>
			
			</ul>
		</li>
			
	</ul> -->
</div>
<!-- End Sidebar -->
<!-- Content -->
<div id="content">
	<!-- Products -->
	
	<div class="products">
		<h3>Featured Products</h3>
	</div> 
		<?php 

			if(isset($_GET['categorie']))
				{
					$resultat = executeRequete("SELECT * FROM article WHERE categorie='$_GET[categorie]'");

					while($article = $resultat->fetch_assoc())
					{
						echo '<div class="metirials">';
							echo '<div class="info">';
								echo '<img src="'.$article['photo'].'" alt="" />';
								echo '<span class="title">'.$article['titre'].'</span>';
							
								echo '<span class="description">'.substr($article['description'], 0, 150).'...</span>';
							echo '</div>';
				 	//echo '<a href="#" class="buy-btn" title="Add to cart">BUY NOW € '.$article['prix']. '</a>';
							//echo '<button class="buy-btn" title="Add to cart">BUY NOW € '.$article['prix']. '</button>';
							echo '<input type="submit" id="'. $article['id_article'] . '" name ="add_cart" class="buy-btn" title="Add to cart" value="BUY NOW '.$article['prix'].' €"/>';

				 			echo '<a class="price" href ="details_article.php?id_article='.$article['id_article'].'" >Details</a>
				 			';
						echo '</div>';
					}
				}elseif(isset($_GET['search'])){

						$search_query = $_GET['user_query'];
										
						$resultat = executeRequete("SELECT * FROM article WHERE keywords like '%$search_query%'");
						
							while($article = $resultat->fetch_assoc())
							{
							echo '<div class="metirials" title="details">';
								echo '<div class="info">';
									echo '<img src="'.$article['photo'].'" alt="" />';
									echo '<span class="title">'.$article['titre'].'</span>';
									
									echo '<span class="description">'.substr($article['description'], 0, 150).'...</span>';
								echo '</div>';
							 	echo '<a href="javascript:void(0);" id="'. $article['id_article'] . '" class="buy-btn" title="Add to cart">BUY NOW '.$article['prix']. ' €</a>';
							 	echo '<a href ="details_article.php?id_article='.$article['id_article'].'" class="price">Details</a>';
							echo '</div>';
							}
							
				} elseif(!empty($_POST['prix'])) {
					$startPrice = 10;
					$endPrice   = 20;
					$allprix    = $_POST['prix'];

					if (count($allprix) == 1) {
						if ($allprix[0]== 20) {	
							$startPrice = 10;
							$endPrice   = 20;
						} elseif ($allprix[0] == 30) {
							$startPrice= 20;
							$endPrice   = 30;
						} else {
							$startPrice = 30;
							$endPrice   = 40;
						}
					} else {
						foreach ($allprix as $prix) {
							if ($prix == 20) {	
								$tempStartPrice = 10;
								$tempEndPrice   = 20;
							} elseif ($prix == 30) {
								$tempStartPrice= 20;
								$tempEndPrice   = 30;
							} else {
								$tempStartPrice = 30;
								$tempEndPrice   = 40;
							}

							if ($tempStartPrice < $startPrice ) {
								$startPrice = $tempStartPrice;
							}

							if ($tempEndPrice > $endPrice ) {
								$endPrice = $tempEndPrice;
							}
						}
					}

					$resultat = executeRequete("SELECT * FROM article WHERE prix >= '$startPrice' AND prix <= '$endPrice' ");			
					while($price = $resultat->fetch_assoc()) {

						echo '<div class="metirials">';
							echo '<div class="info">';
								echo '<img src="'.$price['photo'].'" alt="" />';
								echo '<span class="title">'.$price['titre'].'</span>';
							
								echo '<span class="description">'.substr($price['description'], 0, 150).'...</span>';
							echo '</div>';
				 			//echo '<a href="#" class="buy-btn" title="Add to cart">BUY NOW € '.$article['prix']. '</a>';
							//echo '<button class="buy-btn" title="Add to cart">BUY NOW € '.$article['prix']. '</button>';
							echo '<input type="submit" id="'. $price['id_article'] . '" name ="add_cart" class="buy-btn" title="Add to cart" value="BUY NOW '.$price['prix'].' €"/>';

				 			echo '<a class="price" href ="details_article.php?id_article='.$price['id_article'].'" >Details</a>
				 			';
						echo '</div>';
															
					}
				} else {
					$resultat = executeRequete("SELECT * FROM article ORDER BY RAND() LIMIT 0,15");

					while($article = $resultat->fetch_assoc())
					{
						echo '<div class="metirials">';
							echo '<div class="info">';
								echo '<img src="'.$article['photo'].'" alt="" />';
								echo '<span class="title">'.$article['titre'].'</span>';
							
								echo '<span class="description">'.substr($article['description'], 0, 150).'...</span>';
							echo '</div>';
				 	//echo '<a href="#" class="buy-btn" title="Add to cart">BUY NOW € '.$article['prix']. '</a>';
							//echo '<button class="buy-btn" title="Add to cart">BUY NOW € '.$article['prix']. '</button>';
							echo '<input type="submit" id="'. $article['id_article'] . '" name ="add_cart" class="buy-btn" title="Add to cart" value="BUY NOW '.$article['prix'].' €"/>';

				 			echo '<a class="price" href ="details_article.php?id_article='.$article['id_article'].'" >Details</a>
				 			';
						echo '</div>';
					}
				}
	
		?>

				
	<!--End Products-->
	<div class="cl">&nbsp;</div>
	<!-- Best-sellers -->
	<div id="best-sellers">
		<h3>Special Offers</h3>
		<ul>
			<li>
				<div class="product-promo">
					<!--<?php
					/*$resultat_promotion = executeRequete("SELECT * FROM article");

					while($art_promotion = $resultat_promotion->fetch_assoc())
					{
						echo '<a href ="details_article.php?id_article='.$art_promotion['id_article'].'">';
							echo '<img src="'.$art_promotion['photo'].'" alt="" />';
							echo '<span class="book-name">Blue Jean </span>';
							echo '<span class="author">by John Smith</span>';
							echo '<span class="price"><span class="low">€</span>12<span class="high">00</span></span>';
						echo '</a>';
					}*/
					?>-->
				</div>

				<!--/*************************************/*/-->
				 <div class="product-promo">
					<a href="#">
						<img src="images/products/jean.jpg" alt="" />
						<span class="book-name">Blue Jean </span>
						<span class="author">by John Smith</span>
						<span class="price"><span class="low">€</span>12<span class="high">00</span></span>
					</a>
				</div>
							</li>
							<li>
				<div class="product">
					<a href="#">
						<img src="images/products/chudithar6.jpg" alt="" />
						<span class="book-name">Black Chudithar </span>
						<span class="price"><span class="low">€</span>10<span class="high">00</span></span>
					</a>
				</div>
							</li>
							<li>
				<div class="product">
					<a href="#">
						<img src="images/products/jweles6.jpg" alt="" />
						<span class="book-name">Neckles set </span>
						<span class="price"><span class="low">€</span>8<span class="high">00</span></span>
					</a>
				</div>
							</li>
							<li>
				<div class="product">
					<a href="#">
						<img src="images/products/shirt-red.jpg" alt="" />
						<span class="book-name">Red Shirt </span>
				
						<span class="price"><span class="low">€</span>13<span class="high">99</span></span>
					</a>
				</div>
							</li>
							<li>
				<div class="product">
					<a href="#">
						<img src="images/products/robe2.jpg" alt="" />
						<span class="book-name">Robe </span>
						
						<span class="price"><span class="low">€</span>18<span class="high">00</span></span>
					</a>
				</div>
							</li>
							<li>
				<div class="product">
					<a href="#">
						<img src="images/products/saree3.jpg" alt="" />
						<span class="book-name">Sarees </span>
						
						<span class="price"><span class="low">€</span>12<span class="high">00</span></span>
					</a>
				</div>
							</li>
							<li>
				<div class="product">
					<a href="#">
						<img src="images/products/shirt-blue.jpg" alt="" />
						<span class="book-name">Blue Shirt </span>
						<span class="price"><span class="low">€</span>15<span class="high">00</span></span>
					</a>
				</div>
							</li>
							<li>
				<div class="product">
					<a href="#">
						<img src="images/products/index.jpg" alt="" />
						<span class="book-name">Book Name </span>
						<span class="price"><span class="low">€</span>18<span class="high">99</span></span>
					</a>
				</div> 
			</li>
		</ul>
	</div>
	<!-- End Best-sellers -->
</div>
<!-- End Content -->
<div class="cl">&nbsp;</div>
<?php 
	require_once("inc/footer.inc.php");

	