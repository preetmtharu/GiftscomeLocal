<?php @session_start();
require_once 'includes/config.php';
error_reporting(1);
?>
<?php
$uid= $_SESSION['id'];
$ret=mysqli_query($con,"select game_coins, gift_coins from users where id=$uid");
$row=mysqli_fetch_array($ret);
$user_balance = $row['game_coins'];
$_SESSION['gift_coins'] = $row['gift_coins'];
$_SESSION['game_coins'] = $user_balance;
if(isset($_POST['ordersubmit'])) 
{
	//echo '<pre>';print_r($_SESSION); die();
	$quantity=$_SESSION['product_quantity'];
	$pdd=$_SESSION['product_id'];
	
	$_SESSION['tp'] = $_SESSION['tp'];
	
	if (!isset($_SESSION['login']))
	{   
		header('location:login.php');
	}
	elseif($_SESSION['tp'] <= $_SESSION['game_coins'])
	{
		header('location:payment-method.php');
	}
	else
	{
		echo "<script>alert('Your Balance is not enough to purchase items');</script>";
	//header('location:index.php');
	}
}
?>
<!-- Header -->
<header class="header1">
	<!-- Header desktop -->
	<div class="container-menu-header">
		<div class="topbar">
			<div class="topbar-social">
				<a href="#" class="topbar-social-item fa fa-facebook"></a>
				<a href="#" class="topbar-social-item fa fa-instagram"></a>
				<!--<a href="#" class="topbar-social-item fa fa-pinterest-p"></a>
				<a href="#" class="topbar-social-item fa fa-snapchat-ghost"></a>
				<a href="#" class="topbar-social-item fa fa-youtube-play"></a>-->
			</div>

			<span class="topbar-child1">
				<a href="#" class="top-icons-link" ><img alt="Game Coins" src="images/GameCoin.png" class="top-icons" /><?php if (isset($_SESSION['game_coins'])) { echo $_SESSION['game_coins']; } else {echo '0000';} ?> </a> <a href="#"><img alt="Gift Coins" src="images/GiftCoin.png" class="top-icons" /><?php  if (isset($_SESSION['gift_coins'])) { echo $_SESSION['gift_coins']; } else {echo '0000';} ?></a>
			</span>


			<?php 
			if(isset($_SESSION['name']) && $_SESSION['name']){
				$_SESSION['username'] =	$_SESSION['name'];
			}
			?>
			<div class="topbar-child2">
				<?php if(strlen(@$_SESSION['login'])==0)
				{ 
					echo $_SESSION['login'];  ?>
					<span class="topbar-email">
						<a href="login.php"><i class="icon fa fa-sign-in"></i> Login</a>
					</span>
					<?php } 
					else { ?>
					<span class="topbar-email" style="padding-right:10px;">
						Welcome, <?php echo htmlentities(@$_SESSION['username']);?>
					</span>
					<span class="topbar-email"  style="padding-right:10px;">
						<a href="my-account.php"><i class="icon fa fa-user"></i> My account</a>
					</span>
					<span class="topbar-email">
						<a href="logout.php"><i class="icon fa fa-sign-out"></i> Logout</a>
					</span>
					
					<?php } ?>

				</div>
			</div>

			<div class="wrap_header">
				<!-- Logo -->
				<a href="index.php" class="logo">
					<img style="max-height:100%;" src="images/logo.png" alt="IMG-LOGO">
				</a>

				<!-- Menu -->
				<div class="wrap_menu">
					<nav class="menu">
						<ul class="main_menu">
							<li class="">
								<a href="index.php"  onclick="localStorage.clear();">HOME</a>
							</li>
							<li class="sale-noti">
								<a href="game_zone.php"  onclick="localStorage.clear();">GAME ZONE</a>
							</li>
							<li class="sale-noti">
								<a href="game-history.php"  onclick="localStorage.clear();">GAME HISORY</a>
							</li>
							<li class="">
								<a href="package.php"  onclick="localStorage.clear();">PACKAGES</a>
							</li>
							<li class="">
								<a href="coins-earning.php"  onclick="localStorage.clear();">Gift COINS EARNING </a>
							</li>
							<li class="">
								<a href="product.php"  onclick="localStorage.clear();">REDEEM</a>
							</li>
							<li class="">
								<a href="about.php"  onclick="localStorage.clear();">ABOUT</a>
							</li>							
							
							<li class="">
								<a href="contact.php"  onclick="localStorage.clear();">CONTACT</a>
							</li>
							<?php if(strlen(@$_SESSION['login'])==0) {   ?>
							<?php } else { ?>
							<li class="">
								<a href="chatting.php"  onclick="localStorage.clear();">CHAT</a>
							</li>
							<?php }?>
							
						</ul>
					</nav>
				</div>

				<!-- Header Icon -->

				<div class="header-icons">
                    <!--<a href="#" class="header-wrapicon1 dis-block">
                        <img src="images/icons/icon-header-01.png" class="header-icon1" alt="ICON">
                    </a>

                    <span class="linedivide1"></span>-->

                    <div class="header-wrapicon2">
                    	<span class="header-icons-noti badge"><?php if (!empty($_SESSION["shopping_cart"])) { echo  count($_SESSION["shopping_cart"]); } else { echo '0';} ?></span>
                    	<img src="images/icons/cart.png" class="header-icon1 js-show-header-dropdown" alt="ICON">


                    	<div class="header-cart header-dropdown" id="order_table">
                    		<?php
                    		if (!empty($_SESSION["shopping_cart"])) {
                    			$total = 0;
                    			foreach ($_SESSION["shopping_cart"] as $keys => $values) {
                    				$_SESSION['product_quantity'] = $values["product_quantity"];
                    				$_SESSION['product_id'] = $values["product_id"];
                    				?> 
                    				<ul class="header-cart-wrapitem">
                    					<li class="header-cart-item">
                    						<div class="header-cart-item-img">
                    							<img src="admin/productimages/<?php echo $values["product_name"]?>/<?php echo $values["product_image"];?>" alt="IMG">
                    						</div>

                    						<div class="header-cart-item-txt">
                    							<a href="#" class="header-cart-item-name">
                    								<?php echo $values["product_name"]; ?>
                    							</a>
                    							<span class="header-cart-item-info">
                    								<?php echo $values["product_price"]; ?> x <?php echo $values["product_quantity"]; ?>
                    							</span>



                    						</div>
                    					</li>
                    				</ul>
                    				<?php
                    				$total = $total + ($values["product_quantity"] * $values["product_price"]);
                    				$_SESSION['tp'] = $total;
                    			} ?>
                    			<div class="header-cart-total">
                    				Total: <?php echo number_format($total, 2); ?>
                    			</div>
                    			<div class="header-cart-buttons">
                    				<div class="header-cart-wrapbtn">
                    					<a href="cart.php" class="flex-c-m size1 bg1 bo-rad-20 hov1 s-text1 trans-0-4">
                    						View Cart
                    					</a>
                    				</div>
                    				<div class="header-cart-wrapbtn">
                    					<form method="post" action="">
                    						<button type="submit" name="ordersubmit"  class="flex-c-m size1 bg1 bo-rad-20 hov1 s-text1 trans-0-4">
                    							Check Out
                    						</button>

                    					</form>
                    				</div>
                    			</div>
                    			<?php } else { ?>
                    			Your Shopping Cart Is Empty!!
                    			<?php } ?>
                    		</div>

                    	</div>
                    </div>






                </div>
            </div>

            <!-- Header Mobile -->
            <div class="wrap_header_mobile">
            	<!-- Logo moblie -->
            	<a href="index.php" class="logo-mobile">
            		<img src="images/logo.png" alt="IMG-LOGO">
            	</a>

            	<!-- Button show menu -->
            	<div class="btn-show-menu">
            		<!-- Header Icon mobile -->
            		<div class="header-icons-mobile">
					<!--<a href="#" class="header-wrapicon1 dis-block">
						<img src="images/icons/icon-header-01.png" class="header-icon1" alt="ICON">
					</a>

					<span class="linedivide2"></span>-->

					<div class="header-wrapicon2">
						<img src="images/icons/cart.png" class="header-icon1 js-show-header-dropdown" alt="ICON">
						<span class="header-icons-noti badge"><?php if (!empty($_SESSION["shopping_cart"])) { echo  count($_SESSION["shopping_cart"]); } else { echo '0';} ?></span>

						<!-- Header cart noti -->
						<div class="header-cart header-dropdown" id="order_table">
							<?php
							if (!empty($_SESSION["shopping_cart"])) {
								$total = 0;
								foreach ($_SESSION["shopping_cart"] as $keys => $values) {
									$_SESSION['product_quantity'] = $values["product_quantity"];
									$_SESSION['product_id'] = $values["product_id"];
									?> 
									<ul class="header-cart-wrapitem">
										<li class="header-cart-item">
											<div class="header-cart-item-img">
												<img src="admin/productimages/<?php echo $values["product_name"]?>/<?php echo $values["product_image"];?>" alt="IMG">
											</div>

											<div class="header-cart-item-txt">
												<a href="#" class="header-cart-item-name">
													<?php echo $values["product_name"]; ?>
												</a>
												<span class="header-cart-item-info">
													<?php echo $values["product_price"]; ?> x <?php echo $values["product_quantity"]; ?>
												</span>



											</div>


										</li>
									</ul>
									<?php
									$total = $total + ($values["product_quantity"] * $values["product_price"]);
									$_SESSION['tp'] = $total;
								} ?>

								<div class="header-cart-total">
									Total: <?php echo number_format($total, 2); ?>
								</div>

								<div class="header-cart-buttons">
									<div class="header-cart-wrapbtn">
										<a href="cart.php" class="flex-c-m size1 bg1 bo-rad-20 hov1 s-text1 trans-0-4">
											View Cart
										</a>
									</div>
									<div class="header-cart-wrapbtn">
										<form method="post" action="">
											<button type="submit" name="ordersubmit"  class="flex-c-m size1 bg1 bo-rad-20 hov1 s-text1 trans-0-4">
												Check Out
											</button>

										</form>
									</div>
								</div>
								<?php } else { ?>
								Your Shopping Cart Is Empty!!
								<?php } ?>
								
								
							</div>
						</div>
					</div>

					<div class="btn-show-menu-mobile hamburger hamburger--squeeze">
						<span class="hamburger-box">
							<span class="hamburger-inner"></span>
						</span>
					</div>
				</div>
			</div>

			<!-- Menu Mobile -->
			<div class="wrap-side-menu" >
				<nav class="side-menu">
					<ul class="main-menu">
						<li class="item-topbar-mobile p-l-10">
							<div class="topbar-social-mobile">
								<a href="#" class="topbar-social-item fa fa-facebook"></a>
								<a href="#" class="topbar-social-item fa fa-instagram"></a>
								<!--<a href="#" class="topbar-social-item fa fa-pinterest-p"></a>
								<a href="#" class="topbar-social-item fa fa-twitter"></a>
								<a href="#" class="topbar-social-item fa fa-youtube-play"></a>-->
							</div>
						</li>
						<span class="topbar-child1">
							<a href="#" class="top-icons-link" ><img alt="Game Coins" src="images/GameCoin.png" class="top-icons" /><?php if (isset($_SESSION['game_coins'])) { echo $_SESSION['game_coins']; } else {echo '0000';} ?> </a> <a href="#"><img alt="Gift Coins" src="images/GiftCoin.png" class="top-icons" /><?php  if (isset($_SESSION['gift_coins'])) { echo $_SESSION['gift_coins']; } else {echo '0000';} ?></a>
						</span>				
						<?php 
						if(isset($_SESSION['name']) && $_SESSION['name']){
							$_SESSION['username'] =	$_SESSION['name'];
						}
						?>
			<?php if(strlen(@$_SESSION['login'])==0) {   ?>
					<div class="topbar-child2">
						<span class="topbar-email">
							<a href="login.php"><i class="icon fa fa-sign-in"></i> Login</a>
						</span>
					</div> <?php }
					 else { ?>
					<div class="topbar-child2">
						<span class="topbar-email" style="padding-right:10px;">
							Welcome, <?php echo htmlentities(@$_SESSION['username']);?>
						</span>
						<span class="topbar-email"  style="padding-right:10px;">
							<a href="my-account.php"><i class="icon fa fa-user"></i> My account</a>
						</span>
						<span class="topbar-email">
							<a href="logout.php"><i class="icon fa fa-sign-out"></i> Logout</a>
						</span>
					</div>
					<?php } ?>

					<li class="item-menu-mobile">
						<a href="/index.php">HOME</a>
					</li>

					<li class="item-menu-mobile">
						<a href="game_zone.php">GAME ZONE</a>
					</li>

					<li class="item-menu-mobile">
						<a href="package.php">PACKAGES</a>
					</li>

					<li class="item-menu-mobile">
						<a href="product.php">REDEEM</a>
					</li>

					<li class="item-menu-mobile">
						<a href="about.php">ABOUT</a>
					</li>

					<li class="item-menu-mobile">
						<a href="contact.php">CONTACT</a>
					</li>
					<?php if(strlen(@$_SESSION['login'])!=0) {   ?>
					<li class="item-menu-mobile">
						<a href="my-account.php">MY ACCOUNT</a>
					</li>
					<li class="item-menu-mobile">
						<a href="logout.php">LOGOUT</a>
					</li>
					<?php } else {?>
					<li class="item-menu-mobile">
						<a href="login.php">LOGIN</a>
					</li> <?php } ?>

				</ul>
			</nav>
		</div>
	</header>