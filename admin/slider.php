<?php
session_start();
include('include/config.php');
if(strlen($_SESSION['user'])==0)
	{	
header('location:index.php');
}
else{
if(isset($_POST['submit']))
{
	$slider_title=$_POST['slider_title'];
	$slider_description=$_POST['slider_description'];
	$slider_image=$_FILES["slider_image"]["name"];
	move_uploaded_file($_FILES["slider_image"]["tmp_name"],"images/$slider_image");
$sql=mysqli_query($con,"insert into slider(slider_image,slider_title,slider_description)values('$slider_image','$slider_title','$slider_description')");
$_SESSION['msg']="Slider Inserted Successfully !!";

}


?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Insert Product | Admin</title>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<?php require_once('include/common_css.php');?>
</head>
<body>

<?php require_once('include/header.php');?>
<!--sidebar-menu-->
<?php require_once('include/sidebar.php');?>
<!--close-left-menu-stats-sidebar-->

<div id="content">
<div id="content-header">
  <div id="breadcrumb"> <a href="dashboard.php" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="#" class="current">Add Slider</a> </div>
</div>
<div class="container-fluid">
  <hr>
  <div class="row-fluid">
    <div class="span11">
      <div class="widget-box">
        <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
          <h5>Add Slider</h5>
        </div>
        <div class="widget-content nopadding">
		<?php if(isset($_POST['submit'])){?>
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
				<button type="submit" name="submit" class="btn btn-success">Submit</button>
			</div>
		</div>
		</form>
		
		
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
<script src="js/jquery.dataTables.min.js"></script> 
<script src="js/jquery.validate.js"></script>
<script src="http://js.nicedit.com/nicEdit-latest.js" type="text/javascript"></script>
<script type="text/javascript">bkLib.onDomLoaded(nicEditors.allTextAreas);</script>
<script type="text/javascript"> 
 // Setup form validation on the #register-form element
 $("#addproduct").validate({
    
        // Specify the validation rules
        rules: {
            slider_title:{ required : true},
            slider_description:{ required : true},
			slider_image: {required : true},
	
               
        },
        
        // Specify the validation error messages
        messages: {
           
            slider_title:{ required :"Please enter slider title"},
			slider_description:{ required :"Please enter slider description"},
			slider_image: {required :"Please enter slider image"}
		
           
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
</body>
</html>
<?php }?>
