<?php
session_start();
error_reporting(0);
include('includes/config.php');
$user_obj = new Cl_User();
//extract($_POST);
//print_r($_POST);
$game_id=$_POST['game_id'];
$total_bids=$_POST['total_bids'];
$user_id=$_POST['user_id'];
$final_gift_coins=$_POST['final_gift_coins'];
/*Check if user's bids on current game is not null then update tbl userbids else insert bids on table*/
$bids_by_user = $user_obj->bids_ongame_byuser($game_id,$user_id);
$result=mysqli_fetch_array($bids_by_user);
if($result=='')
{
for ($i = 0; $i <28; $i++) {
   //count($id_array) --> if I input 4 fields, count($id_array) = 4)
$payout_amount = $_POST['payout_amount'.$i];  //$payout_amount[$i];
$bid_no = $i;
$sql=mysqli_query($con,"insert into tbl_userbids(game_id,bid_no,bid_amount,user_id) values('$game_id','$bid_no','$payout_amount','$user_id')");
		}
}
else
{
$prev_bet = $user_obj->total_bids_ongame_byuser($game_id,$user_id);

$gift_coins_bal = $user_obj->get_user_coins_balance($user_id);
$gift_coins = $gift_coins_bal['gift_coins'];


$final_gift_coins = $gift_coins + $prev_bet - $total_bids;


//$final_gift_coins = $prev_bet + $final_gift_coins;
for ($i = 0; $i <28; $i++) {
//count($id_array) --> if I input 4 fields, count($id_array) = 4)
$payout_amount = $_POST['payout_amount'.$i]; 
$bid_no = $i;
$sql=mysqli_query($con,"update tbl_userbids set bid_amount='$payout_amount' where game_id ='$game_id' AND user_id ='$user_id' AND bid_no ='$bid_no'");
	}
}										
?>
<?php
@$data = $user_obj->update_gift_coins_final_balance($user_id,$final_gift_coins);
$total_bets = $user_obj->total_bids_ongame_byuser($game_id,$user_id);
$gc = $user_obj->get_user_coins_balance($user_id);
$gift_coins_bal_final = $gc['gift_coins'];
?>
<div class="alert alert-success col-lg-12 text-center" id="successMessage" style="z-index: 500;opacity: 0.9;">
<?php //echo '<pre>'; print_r($data); ?>
<strong>Well done!! </strong>Your bid has been submitted successfully !!
</div>
<script>
 $(document).ready(function(){
	 var total_bids = '<?php echo $total_bets;?>';
	 var gift_coins_bal_final = '<?php echo $gift_coins_bal_final;?>';
	 document.getElementById("total_bids").value = total_bids;
	 document.getElementById("prev_bets").value = total_bids;
	 document.getElementById("gift_coins_bal_final").value = gift_coins_bal_final;
	 //document.getElementById("game_zone").reset();
        setTimeout(function() {
          $('#successMessage').fadeOut('fast');
        }, 3000); // <-- time in milliseconds
    });
</script>