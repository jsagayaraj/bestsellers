<?php
	require_once("inc/init.inc.php");


	require_once("inc/header.inc.php");
	require_once("inc/menu.inc.php");


?>



		<div id="main" class="shell">
		<!-- Sidebar -->
		<div class="search-box">
			<form action="results.php" method="get" enctype="multipart/form-data">
				<input class = "type_text" type="text" name="user_query" placeholder="search"/>
				<input type="submit" class="type_submit" name="search" value="Ok"/>
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
			if(isset($_GET['search']))
				{
					$search_query = $_GET['user_query'];
										
						$resultat = executeRequete("SELECT * FROM article WHERE keywords like '%$search_query%'");
						
							while($article = $resultat->fetch_assoc())
							{
							echo '<div class="product" title="details">';
								echo '<div class="info">';
									echo '<img src="'.$article['photo'].'" alt="" />';
									echo '<span class="title">'.$article['titre'].'</span>';
									
									echo '<span class="description">'.substr($article['description'], 0, 150).'...</span>';
								echo '</div>';
							 	echo '<a href="#" class="buy-btn" title="Add to cart">BUY NOW € '.$article['prix']. '</a>';
							 	echo '<a href ="details_article.php?id_article='.$article['id_article'].'" class="price">Details</a>';
							echo '</div>';
							}
							
				}
					

			if(isset($_GET['categorie']))
				{
					
					$resultat = executeRequete("SELECT * FROM article WHERE categorie='$_GET[categorie]'");
					
					while($article = $resultat->fetch_assoc())
					{
						echo '<div class="product" title="details">';
						echo '<div class="info">';
						echo '<img src="'.$article['photo'].'" alt="" />';
						echo '<span class="title">'.$article['titre'].'</span>';
						
						echo '<span class="description">'.substr($article['description'], 0, 150).'...</span>';
						echo '</div>';
				 	echo '<a href="#" class="buy-btn" title="Add to cart">BUY NOW $ '.$article['prix']. '</a>';
				 	echo '<a href ="details_article.php?id_article='.$article['id_article'].'" class="price">Details</a>';
					echo '</div>';
					}

				}



		?>

		<!-- 	<div class="product">
			<div href="#" class="info">
				<img src="images/products/shirt-red.jpg" alt="" />
				<span class="title">Book Name</span>
				<span class="author">by John Smith</span>
				<span class="description">Maecenas vehicula ante eu enim pharetra<br />scelerisque dignissim <br />sollicitudin nisi</span>
			</div>
			 	<a href="#" class="buy-btn">BUY NOW </a> 
			 	<a href ="#" class="price"> 22</a>
		</div> -->
				
			<!--End Products-->
			<div class="cl">&nbsp;</div>
			<!-- Best-sellers -->
			<div id="best-sellers">
				<h3>Best Sellers</h3>
				<ul>
					<li>
						<div class="product-promo">
							<a href="#">
								<img src="images/image-best01.jpg" alt="" />
								<span class="book-name">Book Name </span>
								<span class="author">by John Smith</span>
								<span class="price"><span class="low">$</span>35<span class="high">00</span></span>
							</a>
						</div>
					</li>
					<li>
						<div class="product">
							<a href="#">
								<img src="images/image-best02.jpg" alt="" />
								<span class="book-name">Book Name </span>
								<span class="author">by John Smith</span>
								<span class="price"><span class="low">$</span>45<span class="high">00</span></span>
							</a>
						</div>
					</li>
					<li>
						<div class="product">
							<a href="#">
								<img src="images/image-best03.jpg" alt="" />
								<span class="book-name">Book Name </span>
								<span class="author">by John Smith</span>
								<span class="price"><span class="low">$</span>15<span class="high">00</span></span>
							</a>
						</div>
					</li>
					<li>
						<div class="product">
							<a href="#">
								<img src="images/image-best04.jpg" alt="" />
								<span class="book-name">Book Name </span>
								<span class="author">by John Smith</span>
								<span class="price"><span class="low">$</span>27<span class="high">99</span></span>
							</a>
						</div>
					</li>
					<li>
						<div class="product">
							<a href="#">
								<img src="images/image-best01.jpg" alt="" />
								<span class="book-name">Book Name </span>
								<span class="author">by John Smith</span>
								<span class="price"><span class="low">$</span>35<span class="high">00</span></span>
							</a>
						</div>
					</li>
					<li>
						<div class="product">
							<a href="#">
								<img src="images/image-best02.jpg" alt="" />
								<span class="book-name">Book Name </span>
								<span class="author">by John Smith</span>
								<span class="price"><span class="low">$</span>45<span class="high">00</span></span>
							</a>
						</div>
					</li>
					<li>
						<div class="product">
							<a href="#">
								<img src="images/image-best03.jpg" alt="" />
								<span class="book-name">Book Name </span>
								<span class="author">by John Smith</span>
								<span class="price"><span class="low">$</span>15<span class="high">00</span></span>
							</a>
						</div>
					</li>
					<li>
						<div class="product">
							<a href="#">
								<img src="images/image-best04.jpg" alt="" />
								<span class="book-name">Book Name </span>
								<span class="author">by John Smith</span>
								<span class="price"><span class="low">$</span>27<span class="high">99</span></span>
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

	?>