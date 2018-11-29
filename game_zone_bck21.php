<?php session_start();
include('includes/config.php');
if(strlen($_SESSION['login'])==0)
{   
	header('location:login.php');
}
if(isset($_POST['update']))
{
	$game_id=$_POST['game_id'];
	$game_time=$_POST['game_time'];
	$sql=mysqli_query($con, "update tbl_game set game_start_time='$game_time' where id='$game_id'");

}
?>
<!DOCTYPE html>
<head>
	<title>Game Zone</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php require_once('templates/common_css.php');?>
	<link href="css/custom.css" rel="stylesheet">
	<link rel='stylesheet prefetch' href='https://cdnjs.cloudflare.com/ajax/libs/flipclock/0.7.8/flipclock.min.css'>
	<style>
	body, html {
		height: 100%;
		font-family: Poppins-bold !important;
	  font-weight: 400;	
	}
	.checkbox-inline+.checkbox-inline, .radio-inline+.radio-inline {
    margin-top: 0;
    margin-left: 10px;
}

input:checked {
    height: 13px;
    width: 13px;
    color: #08a6cc;
}
.btn-dng {
    color: #fff;
    background-color: #c82333;
    border-color: #bd2130;
    height: 37px;
}
.btn-suc {
    color: #fff;
    background-color: #218838;
    border-color: #1e7e34;
	height:37px;
}
.text-center{
	color:#08a6cc;
}
.button-main {
    position: absolute;
    top: 1px;
    left: 49px;
}

	</style>
</head>
<body class="animsition">
	<?php require_once('templates/header.php');?>
	<!-- Title Page -->
	<!--<section class="bg-title-page p-t-40 p-b-50 flex-col-c-m" style="background-image: url(images/gamesbanner1.png);">
		<h2 class="l-text2 t-center">
			Game Zone
		</h2>
	</section>-->
	<!-- content page -->
	<section class="bgwhite p-t-33 p-b-38">

						<div class="container-fluid  Gamezone_tab">
							<div class="row">
								<div class="col-sm-10 col-md-8 col-lg-12 m-l-r-auto">
									<div class="col-lg-12">

										<?php
			date_default_timezone_set('UTC');// change according timezone
			$currentTime = date( 'Y-m-d H:i:s', time () );
			//echo 'Cureent time is: 	'.$currentTime = date( 'Y-m-d H:i:s', time () );
			$query = "SELECT * FROM tbl_game where game_start_time >= CURDATE() and is_active =1 limit 1";
			$result = mysqli_query($con, $query) or die(mysqli_error($con));
			//$rowcount=mysqli_num_rows($result);//print_r($rowcount);
			$row = mysqli_fetch_array($result, MYSQLI_BOTH);
			$id = $row['id'];
			$game_start_time = $row['game_start_time'];
			//echo '<br/>Game Start time is: '.$game_start_time;
			$game_duration = $row['game_duration'];
			
			//set timezone
			date_default_timezone_set('UTC');
			//set an date and time to work with
			//$start = '2014-06-01 14:00:00';
			//display the converted time
			$end_date = date('Y-m-d H:i:s',strtotime('+'.$game_duration.' minutes',strtotime($game_start_time)));
			//echo '<br/>End time is: '.$end_date;
			
			$res_declare = date('Y-m-d H:i:s',strtotime('+4 seconds',strtotime($end_date)));
			//echo '<br/>Result Declare time is: '.$res_declare;
			?>
		   <form method="post" action="">
				<input type="text" name="game_time" value="<?php echo $currentTime;?>" >
				<input type="submit" name="update" id="" class="btn btn-success" value="Update">
				<input type="hidden" name="game_id" value="<?php echo $id;?>"/>
			</form>
			<h1 style="text-align:center;font-size:26px;padding-top:1%">
				<?php if($currentTime < $game_start_time) {?>
				Next game starts in:-
				<?php } ?>
				<?php if($currentTime >= $game_start_time  && $currentTime <= $end_date ) {?>
				Game ends in:-
				<?php } ?>
			</h1>
			<div class="clock" id="countdown1" style=" display: flex;justify-content: center;align-items: center; padding-top:15px;padding-bottom:1px"></div>
			<div class="" id="message1" style=" display: flex;justify-content: center;align-items: center; padding-top:15px;padding-bottom:1px"></div>
		</div>
		<div id="message"></div>

	<div class="" style="padding-bottom: 10px;">
		<div class="row col-lg-12" > 
				<div class="col-lg-4">
					<div class="row text-center" style="padding-left:38px">Quick Selection</div>
					<div class="row">
						<div class="col-lg-5" style="padding-top:7px"><label class="radio-inline"><input type="radio" name="add_option" value="ALL" checked="checked">All</label>
							<label class="radio-inline"><input type="radio" name="add_option" value="ODD">ODD</label>
							<label class="radio-inline"><input type="radio" name="add_option" value="EVEN">EVEN</label>
						</div>
						<div class="col-lg-7">
								<button class="btn-num-product-down btn btn-dng">
								<i class="fs-12 fa fa-minus" aria-hidden="true"></i>
							</button>
							<input class="size8 m-text18 t-center num-product" type="number" pattern="[0-9]" name="coin_add" id="coin_add" value="00" maxlength="5">
							<button class="btn-num-product-up btn btn-suc" id="plus<?php echo $row['payout_digit'];?>" onclick="todo()">
								<i class="fs-12 fa fa-plus" aria-hidden="true"></i>
							</button>
							<button type="button" id="MyButton" class="btn btn-info" style="margin-left: 10px;">BID</button>
						</div>
						
					</div>
				</div>
				<div class="col-lg-4 text-center">
					<div class=" text-center">Action</div>
					<div class="text-center">
						<button type="button" id="clear" class="btn btn-warning">Clear All</button>
						<button type="button" id="subbtn" class="btn btn-success" style="margin-left: 10px;" disabled>Submit</button>		
						<button type="button" name="" id="cnl_btn" class="btn btn-danger" value="cancel" onClick="window.location='game_zone.php';" style="margin-left: 10px;" disabled>Cancel</button>
					</div>
				</div>
				<div class="col-lg-4 ">
					<div class=" text-center" >Statics</div>
					<div class="text-center">
						<label style="padding-top:7px">Coin Balance:</label><input type="text" class="width-dynamic proba dva" min="0" name="gift_coins" id="gift_coins" value="<?php echo $_SESSION['gift_coins'];?>" style="align-self:center;min-width: 100px; max-width: 500px; margin-left:10px;" disabled>
					<input type="hidden" id="rem_coins" name="rem_coins" value=""></div>
				</div>
		</div>
	</div>




					<div class="row">
						<div class="col-lg-6">
							<form name="" method="post" action="" id="game_zone">
								<div class="block1 hov-img-zoom pos-relative m-b-30" style="border-bottom:1px solid #08a6cc;">
									<h1 class="list-heading">
										<div class="row">
											<div class="col-lg-1 gftext1">NUMBER</div>
											<div class="col-lg-4 gftext1">PREVIOUS PAYOUT <img src="images/logo-2.png" class="gift"></div>
											<div class="col-lg-4 gftext1">CURRENT PAYOUT<img src="images/logo-2.png" class="gift"></div>
											<div class="col-lg-3 gftext1">YOUR BID</div>
										</div>
									</h1>
									<div>
										<ul class="heading">

											<?php
											/*Previous game id*/
											$query1 = "SELECT * FROM tbl_game where game_start_time < '$currentTime' and is_active =1 limit 1";
											$result1 = mysqli_query($con, $query1) or die(mysqli_error($con));
											$row1 = mysqli_fetch_array($result1, MYSQLI_BOTH);
											$id_pre_game = $row1['id'];


											$query=mysqli_query($con,"select * from tbl_game_payout where game_id = '$id' LIMIT 14");
											$i=0;while($row=mysqli_fetch_array($query)) {

												$payout_digit = $row['payout_digit'];
												$sql22 = mysqli_query($con,"select payout_amount FROM tbl_game_payout WHERE game_id ='$id_pre_game' AND payout_digit ='$payout_digit' ;");
												$result=mysqli_fetch_array($sql22);
												$pre_payout_amt =$result['payout_amount'];
												?>
												<li>
													<div class="row">
														<div class="col-lg-1 size8"><div class="back-img"><?php echo $row['payout_digit'];?></div></div>
														<div class="col-lg-4 size8">
															<div class="row">											
																<div class="col-md-12"><?php echo $pre_payout_amt;?> </div>
															</div>
														</div>
														<div class="col-lg-4 size8">
															<div class="row">
																<div class="col-md-12"><?php echo $row['payout_amount'];?> </div>
															</div>
														</div>														
														<div class="col-lg-3 size8">
															<div class="center">
																<div class="input-group button-main">
																	<button class="btn-num-product-down color1 flex-c-m size7 bg8 eff2 btn btn-dng" onclick="todo()">
																		<i class="fs-12 fa fa-minus" aria-hidden="true"></i>
																	</button>
																	<input class="size8 m-text18 t-center num-product" type="number" pattern="[0-9]" name="payout_amount<?php echo $row['payout_digit'];?>" id="payout_amount<?php echo $row['payout_digit'];?>" value="00" maxlength="5" onkeypress="return AllowOnlyNumbers(event);" onkeyup="todo()">
																	<button class="btn-num-product-up color1 flex-c-m size7 bg8 eff2 btn btn-suc" id="plus<?php echo $row['payout_digit'];?>" onclick="todo()">
																		<i class="fs-12 fa fa-plus" aria-hidden="true"></i>
																	</button>
																</div>
															</div>
														</div>
													</div>
												</li>


												<?php $i++;}?>
											</ul>
										</div>
									</div><!-- end block1 -->
								</div><!-- end of col-lg-6- -->
								<div class="col-lg-6">
									<div class="block1 hov-img-zoom pos-relative m-b-30" style="border-bottom:1px solid #08a6cc;">
										<h1 class="list-heading">
											<div class="row">
												<div class="col-lg-1 gftext1">NUMBER</div>
											<div class="col-lg-4 gftext1">PREVIOUS PAYOUT <img src="images/logo-2.png" class="gift"></div>
											<div class="col-lg-4 gftext1">CURRENT PAYOUT<img src="images/logo-2.png" class="gift"></div>
											<div class="col-lg-3 gftext1">YOUR BID</div>
											</div>
										</h1>
										<div>
											<ul class="heading">
												<?php $query=mysqli_query($con,"select * from tbl_game_payout where game_id = '$id' LIMIT 15 OFFSET 14");
												while($row=mysqli_fetch_array($query)) { 
													$payout_digit = $row['payout_digit'];
													$sql33 = mysqli_query($con,"select payout_amount FROM tbl_game_payout WHERE game_id ='$id_pre_game' AND payout_digit ='$payout_digit' ;");
													$result33=mysqli_fetch_array($sql33);
													$pre_payout_amt =$result33['payout_amount'];
													?>
													<li>
														<div class="row">
															<div class="col-lg-1 size8"><div class="back-img"><?php echo $row['payout_digit'];?></div></div>
															<div class="col-lg-4 size8">
																<div class="row">


																	<div class="col-md-12">
																		<?php echo $pre_payout_amt;?>
																	</div>
																</div>
															</div>
															<div class="col-lg-4 size8">
																<div class="row">

																	<div class="col-md-12">
																		<?php echo $row['payout_amount'];?>
																	</div>
																</div>
															</div>															
															<div class="col-lg-3 size8">
																<div class="center">
																	<div class="input-group button-main">
																		<button class="btn-num-product-down color1 flex-c-m size7 bg8 eff2 btn btn-dng" onclick="todo()">
																			<i class="fs-12 fa fa-minus" aria-hidden="true"></i>
																		</button>
																		<input class="size8 m-text18 t-center num-product" type="number" pattern="[0-9]" name="payout_amount<?php echo $row['payout_digit'];?>" id="payout_amount<?php echo $row['payout_digit'];?>" maxlength="5" value="00" onkeypress="return AllowOnlyNumbers(event);" onkeyup="todo()">
																		<button class="btn-num-product-up color1 flex-c-m size7 bg8 eff2 btn btn-suc" id="plus<?php echo $row['payout_digit'];?>" onclick="todo()">
																			<i class="fs-12 fa fa-plus" aria-hidden="true"></i>
																		</button>
																	</div>
																</div>
															</div>
														</div>
													</li>

													<?php }?>
												</ul>
											</div>
										</div><!-- end block1 -->
									</div><!-- end of col-lg-6- -->

								</div><!-- end of row -->
								<!-- <li>
									<div class="row">
										<div class="col-lg-5"></div>
										<div class="col-lg-1" style="padding:10px" ><button type="button" id="subbtn" class="btn btn-success">Submit</button></div>
										<div class="col-lg-1" style="padding:10px"><button type="button" name="cancel" id="cnl_btn" class="btn btn-danger" value="cancel" onClick="window.location='game_zone.php';" />Cancel</button></div>
										<div class="col-lg-5"></div>
									</div>
								</li> -->
							</div>
						</form>
					</div>
				</div>
			</section>
			<?php require_once('templates/footer.php');?>
			<?php require_once('templates/common_js.php');?>
			<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
			<script src='https://cdnjs.cloudflare.com/ajax/libs/countdown/2.6.0/countdown.min.js'></script>
			<script src='https://cdnjs.cloudflare.com/ajax/libs/flipclock/0.7.8/flipclock.min.js'></script>

			<script>
				$(document).ready(function() {

				});
			</script>


			<?php if($currentTime < $game_start_time) {?>
			<script type="text/javascript">
				var clock;

				$(document).ready(function() {
				document.getElementById("subbtn").disabled = true;
				 document.getElementById("cnl_btn").disabled = true;
    // Set dates.
    var game_start_time = '<?php echo $game_start_time;?>';
    var futureDate  = new Date(game_start_time); //alert(futureDate);
    var currentDate = new Date('<?php echo $currentTime;?>');//alert(currentDate);
	//var currentDate = '<?php echo $currentTime;?>';
	//alert(currentDate);
	

    // Calculate the difference in seconds between the future and current date
    var diff = futureDate.getTime() / 1000 - currentDate.getTime() / 1000; //alert(diff);

    // Calculate day difference and apply class to .clock for extra digit styling.
    function dayDiff(first, second) {
    	return (second-first)/(1000*60*60*24);
    }

    if (dayDiff(currentDate, futureDate) < 100) {
    	$('.clock').addClass('twoDayDigits');
    } else {
    	$('.clock').addClass('threeDayDigits');
    }

    if(diff < 0) {
    	diff = 0;
    }

    /*if (currentDate== futureDate) {
		alert('hi');
		window.setTimeout(function(){location.reload()},100);
	}*/

    // Instantiate a coutdown FlipClock
    clock = $('.clock').FlipClock(diff, {
     //clockFace: 'MinuteCounter',
     countdown: true,
     callbacks: {
     	stop: function() {
						//alert('hi');
						//location.reload();
						window.setTimeout(function(){location.reload()},400);
					}
				}
			});


	/* window.setInterval(function(){
	var currentDate2 = new Date(Date.now());	
	var diff2 =  ((currentDate2.getTime() - 19800857) - futureDate.getTime()) / 1000;
		  /// call your function here
		  // console.log("current date - "+ currentDate + " - " + currentDate.getTime());
		 //  console.log("current date2 - "+ currentDate2 + " - " + currentDate2.getTime());
		 //  console.log("future date - "+ futureDate + " - " + futureDate.getTime());
		//   console.log("difference - "+ diff2);	  
		  
		 if(diff2 >= 0){
		   location.reload();
		 }else{
		 }
		}, 2000);*/

	});




</script>
<?php } ?>
<?php if($currentTime == $game_start_time){?>
<script type="text/javascript">
//alert('hi');
		//window.setTimeout(function(){location.reload()},100);
	</script>
	<?php }?>
	<?php if($currentTime > $game_start_time && $currentTime < $end_date)  {?>
	<script type="text/javascript">
		$(document).ready(function() {
			document.getElementById("subbtn").disabled = false;
				 document.getElementById("cnl_btn").disabled = false;
			window.setInterval(function(){
	//alert('hi');
	$.ajax({  
		type: "POST",
		dataType: "text",
		url: "update_game_payout.php",
		data: "game_id=" + game_id,  
		success: function(rr){
				 //alert(rr);
				  //alert("Record successfully updated");
				  $("#message1").html(rr);
				},
				error:function(jqXHR, textStatus, errorThrown){
				//alert("Error type" + textStatus + "occured, with value " + errorThrown);
			}
		});
       /// call your function here
      //random_no();
}, 10000);  // Change Interval here to test. For eg: 5000 for 5 sec
		});
	</script>
	<?php }?>
	<?php if($currentTime > $game_start_time && $currentTime < $end_date)  {?>
	<script type="text/javascript">
		var clock;
		var game_id = '<?php echo $id ?>';
		$(document).ready(function() {
    // Set dates.
	var game_end_time = '<?php echo $end_date;?>';//alert(game_start_time);
    var futureDate  = new Date(game_end_time); //alert(futureDate);
    var currentDate = new Date('<?php echo $currentTime;?>');
	//var currentDate = '<?php echo $currentTime;?>';
	//alert(currentDate);
	// Calculate the difference in seconds between the future and current date
    var diff = futureDate.getTime() / 1000 - currentDate.getTime() / 1000; //alert(diff);
    // Calculate day difference and apply class to .clock for extra digit styling.
    function dayDiff(first, second) {
    	return (second-first)/(1000*60*60*24);
    }
    if (dayDiff(currentDate, futureDate) < 100) {
    	$('.clock').addClass('twoDayDigits');
    } else {
    	$('.clock').addClass('threeDayDigits');
    }
	if(diff < 0) {
    	diff = 0;
	}
	if(diff < 10) {
    	document.getElementById("subbtn").disabled = true;
		document.getElementById("cnl_btn").disabled = true;
	}
		 // Instantiate a coutdown FlipClock
    clock = $('.clock').FlipClock(diff, {
    	clockFace: 'MinuteCounter',
    	countdown: true,
    	callbacks: {
    		stop: function() {
    			document.getElementById("subbtn").disabled = true;
				 document.getElementById("cnl_btn").disabled = true;
    			window.setTimeout(function(){location.reload()},2000);
						//$('#countdown1').hide();
					}
				}
			});
   

});

</script>
<?php }?>
<?php if($currentTime >= $end_date && $currentTime <= $res_declare ) {?>
<script type="text/javascript">
		//$(document).ready(function() {
			//window.setInterval(function(){
				var game_id = '<?php echo $id ?>';				
				//alert('hi');
				$.ajax({  
								type: "POST",
								dataType: "text",
								url: "game_winning_no.php",
								data: "game_id=" + game_id,  
								success: function(rr){
							 //alert(rr);
							  //alert("Record successfully updated");
							  $("#message1").html(rr);
							},
							error:function(jqXHR, textStatus, errorThrown){
							//alert("Error type" + textStatus + "occured, with value " + errorThrown);
						}
					});
				
	
//}, 1000);  // Change Interval here to test. For eg: 5000 for 5 sec
		//});
</script>
<?php }?>
<script  src="js/custome/increment_bids.js"></script>
<?php require_once('js/custome/ajax_submit_bid_js.php');?>
<script  src="js/custome/allow_numbers.js"></script>
<script  src="js/index.js"></script>
</body>
</html>