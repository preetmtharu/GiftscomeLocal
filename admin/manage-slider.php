<?php
session_start();
include('include/config.php');
include('include/function.php');
if(strlen($_SESSION['user'])==0)
	{	
header('location:index.php');
}
else{
date_default_timezone_set('Asia/Kolkata');// change according timezone
$currentTime = date( 'd-m-Y h:i:s A', time () );
if(isset($_POST['submit']) && @$_SESSION["csrf_token"] == @$_POST['csrf_token'])
{
	$slider_title=$_POST['slider_title'];
	$slider_description=$_POST['slider_description'];
	$slider_image=$_FILES["slider_image"]["name"];
	move_uploaded_file($_FILES["slider_image"]["tmp_name"],"images/$slider_image");
$sql=mysqli_query($con,"insert into slider(slider_image,slider_title,slider_description)values('$slider_image','$slider_title','$slider_description')");
$_SESSION['msg']="Slide Inserted Successfully !!";

}
if(isset($_GET['del']))
		  {
		          $id = toInternalId($_GET['id']);
				  mysqli_query($con,"delete from slider where slider_id = '".$id."'");
                  $_SESSION['delmsg']="Slide deleted !!";?>
				  <script type="text/javascript">
					setTimeout(function () {
					var basepath = window.location.protocol + '//' + window.location.hostname;
					var path = basepath + '/admin/manage-slider.php';
					window.location.href= path; // the redirect goes here
					},1000); // 5 seconds
				</script>
<?php } ?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Admin| Manage Products</title>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<?php require_once('include/common_css.php');?>
</head>
<body>

<?php require_once('include/header.php');?>

<?php require_once('include/sidebar.php');?>
<div id="content">
  <div id="content-header">
    <div id="breadcrumb"> <a href="dashboard.php" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="#" class="current"> Manage Slider</a> </div>
  </div>
  <div class="container-fluid">
    <hr>
	  <div class="row-fluid">
    <div class="span11">
      <div class="widget-box">
	  <?php if(!empty($_SESSION['msg'])){?>
									<div class="alert alert-success" id="successMessage">
									<button type="button" class="close" data-dismiss="alert">×</button>
									<strong>Well done!</strong>	<?php echo htmlentities($_SESSION['msg']);?><?php echo htmlentities($_SESSION['msg']="");?>
									<script type="text/javascript">
											setTimeout(function () {
											var basepath = window.location.protocol + '//' + window.location.hostname;
											var path = basepath + '/admin/manage-slider.php';
											window.location.href= path; // the redirect goes here
											},1000); // 5 seconds
						          </script>
								  
									</div>
		<?php } ?>
		<?php if(isset($_GET['del'])){?>
									<div class="alert alert-error" id="successMessage">
										<button type="button" class="close" data-dismiss="alert">×</button>
									<strong>Oh snap!</strong> 	<?php echo htmlentities($_SESSION['delmsg']);?><?php echo htmlentities($_SESSION['delmsg']="");?>
									</div>
		<?php } ?>
        <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
           <input type="button" class="btn btn-success" data-toggle="collapse" data-target="#collapseOne" value="Add Slide">
        </div>
        <div class="widget-content nopadding panel-collapse collapse" id="collapseOne">
		<form class="form-horizontal"name="insertproduct" id ="addproduct" method="post"  enctype="multipart/form-data" >
									
			<div class="control-group">
		<label class="control-label" for="basicinput">Slider Title</label>
		<div class="controls">
		<input type="text" name="slider_title" id="productShippingcharge"  placeholder="Enter Product Shipping Charge" class="span8 tip" required>
		</div>
		</div>

		<div class="control-group">
		<label class="control-label" for="basicinput">Slider Description</label>
		<div class="controls">
		<textarea  name="slider_description" id="productDescription" placeholder="Enter Product Description" rows="6" class="span8 tip">
		</textarea>  
		</div>
		</div>

		<div class="control-group">
		<label class="control-label" for="basicinput">Slider image</label>
		<div class="controls">
		<input type="file" name="slider_image" id="productimage1" value="" class="span8 tip" required>
		</div>
		</div>


		<div class="control-group">
			<div class="controls">
			<?php $_SESSION["csrf_token"] = md5(rand(0,10000000)).time(); ?>
			<input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION["csrf_token"]);?>">
			<button type="reset" name="reset" class="btn btn-success">Cancel</button>
				<button type="submit" name="submit" class="btn btn-success">Submit</button>
			</div>
		</div>
		</form>
		
		
        </div>
      </div>
    </div>
	</div>
	
	
    <div class="row-fluid">
      <div class="span12">
  
        <div class="widget-box">
        <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
            <input type="button" class="btn btn-success" data-toggle="collapse" data-target="#collapsetwo" value="View All Slides">
          </div>
         <div class="widget-content nopadding panel-collapse collapse in" id="collapsetwo">
            <table class="table table-bordered data-table">
             <thead>
										<tr>
											<th>#</th>
											<th>Slider Image</th>
											<th>Slider Title </th>
											<th>Slider Description</th>
											<th>Active</th>
											<th>Action</th>
										</tr>
			</thead>
              <tbody>

									<?php 
									    $query=mysqli_query($con,"select * from slider");
										$cnt=1;
										while($row=mysqli_fetch_array($query))
										{ ?>									
										<tr>
											<td><?php echo htmlentities($cnt);?></td>
											<td style="width:20%;"><img src="images/<?php echo $row['slider_image'];?>" style="width:100%;"></td>
											<td><?php echo htmlentities($row['slider_title']);?></td>
											<td><?php echo htmlentities($row['slider_description']);?></td>
											<td class="">
											<?php $stylepopular= ''; $stylenotpopular= '';?>
											<?php 
											if($row['is_active']==0)
											{
												$stylepopular= "style= display:none";
											}
											
											if($row['is_active']==1)
											{
												$stylenotpopular= "style= display:none";
											}
											
											?>
				                          <img id="imgnotpopular<?php echo $row['slider_id']; ?>" onclick="funisactive(<?php echo $row['slider_id']; ?>,1,'slider');" src='images/off.png' width='60' <?php echo $stylenotpopular;?> />
				                          <img id="imgpopular<?php echo $row['slider_id']; ?>" onclick="funisactive(<?php echo $row['slider_id']; ?>,0,'slider');" src='images/on.png'  width='60' <?php echo $stylepopular;?> />
										  </td>
										  <td>
											<a href="edit_slider.php?id=<?php echo toPublicId($row['slider_id']);?>" ><i class="fa fa-edit"></i></a>
											<a href="manage-slider.php?id=<?php echo toPublicId($row['slider_id']);?>&del=delete" onClick="return confirm('Are you sure you want to delete?')"><i class="fa fa-trash-o"></i></a></td>
										</tr>
										<?php $cnt=$cnt+1; } ?>
										
				</tbody>				
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!--Footer-part-->
<?php require_once('include/footer.php');?>
<!--end-Footer-part-->
<?php require_once('include/common_js.php');?>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>
<script src="js/jquery.validate.js"></script>
<script src="http://js.nicedit.com/nicEdit-latest.js" type="text/javascript"></script>
<script type="text/javascript">bkLib.onDomLoaded(nicEditors.allTextAreas);</script>
<script src="js/jquery.dataTables.min.js"></script> 
<script src="js/matrix.tables.js"></script>
<script type="text/javascript"> 
 // Setup form validation on the #register-form element
 $("#addproduct").validate({
    
        // Specify the validation rules
        rules: {
            slider_title:{ required : true},
            slider_description:{ required : true},
			slider_image: {required : true,accept:"image/jpg,image/jpeg,image/png"},
	
               
        },
        
        // Specify the validation error messages
        messages: {
           
            slider_title:{ required :"Please enter slider title"},
			slider_description:{ required :"Please enter slider description"},
			slider_image: {required :"Please enter slider image",accept:"Please upload .jpg or .png or .jpeg file of notice."}
		
           
        },
		errorClass: "help-inline",
		errorElement: "span",
		highlight:function(element, errorClass, validClass) {
			$(element).parents('.control-group').addClass('error');
		},
		unhighlight: function(element, errorClass, validClass) {
			$(element).parents('.control-group').removeClass('error');
			$(element).parents('.control-group').addClass('success');
		},
        
        submitHandler: function(form) {
            form.submit();
        }
    });
  </script>
<script>
 $(document).ready(function(){
        setTimeout(function() {
          $('#successMessage').fadeOut('fast');
        }, 5000); // <-- time in milliseconds
    });
</script>
<script>
		
		function funisactive(id,is_active,table_name)
		{
			 $.ajax({  
			 type: "POST",  
			 url: "change_active_slider.php",  
			 data: "id=" + id + "& is_active=" + is_active + "& table_name=" + table_name,  
			 success: function(){  
				//success (not finished)
				if(is_active=='1')
				{
				document.getElementById('imgnotpopular'+id).style.display='none';
				document.getElementById('imgpopular'+id).style.display='block';
				}
				else
				{
				document.getElementById('imgnotpopular'+id).style.display='block';
				document.getElementById('imgpopular'+id).style.display='none';
				}
				
				}  
			 });  
		  return false;  
		   
		}
</script>
</body>
</html>
<?php }?>
