<?php  
 //action.php  
 session_start();  
 //$connect = mysqli_connect("localhost", "root", "", "gifts_come");  
 if(isset($_POST["product_id"]))  
 {  
      $order_table = ''; 
      $order_table1 = ''; 	  
      $message = '';  
      if($_POST["action"] == "add")  
      {  
           if(isset($_SESSION["shopping_cart"]))  
           {  
                $is_available = 0;  
                foreach($_SESSION["shopping_cart"] as $keys => $values)  
                {  
                     if($_SESSION["shopping_cart"][$keys]['product_id'] == $_POST["product_id"])  
                     {  
                          $is_available++;  
                          $_SESSION["shopping_cart"][$keys]['product_quantity'] = $_SESSION["shopping_cart"][$keys]['product_quantity'] + $_POST["product_quantity"];  
                     }  
                }  
                if($is_available < 1)  
                {  
                     $item_array = array(  
                          'product_id'               =>     $_POST["product_id"],  
                          'product_name'               =>     $_POST["product_name"],  
                          'product_price'               =>     $_POST["product_price"],  
                          'product_quantity'          =>     $_POST["product_quantity"] ,
						  'product_image'          =>     $_POST["product_image"]
                     );  
                     $_SESSION["shopping_cart"][] = $item_array;  
                }  
           }  
           else  
           {  
                $item_array = array(  
                     'product_id'               =>     $_POST["product_id"],  
                     'product_name'               =>     $_POST["product_name"],  
                     'product_price'               =>     $_POST["product_price"],  
                     'product_quantity'          =>     $_POST["product_quantity"],
					'product_image'          =>     $_POST["product_image"]
                );  
                $_SESSION["shopping_cart"][] = $item_array;  
           } 
           $cart_append ='';
           	if (!empty($_SESSION["shopping_cart"])) {
                $total = 0;
                foreach ($_SESSION["shopping_cart"] as $keys => $values) { 
                    $cart_append.='<ul class="header-cart-wrapitem">
                        <li class="header-cart-item">
                            <div class="header-cart-item-img">
                                <img src="admin/productimages/'.$values["product_name"].'/'.$values["product_image"].'" alt="IMG">
                            </div>
                            <div class="header-cart-item-txt">
                                <a href="#" class="header-cart-item-name">
                                    '.$values["product_name"].'
                                </a>
                                <span class="header-cart-item-info">
                         			'.number_format($values["product_price"]). ' x ' .$values["product_quantity"].'
                                </span>
                               
                            </div>
                        </li>
                    </ul>';
                    $total = $total + ($values["product_quantity"] * $values["product_price"]);
                } 
                 $cart_append.='<div class="header-cart-total">
                    Total: '.number_format($total).'
                </div>
                <div class="header-cart-buttons">
                    <div class="header-cart-wrapbtn">
                        
                    </div>
                   <div class="header-cart-wrapbtn">
                      <!-- <form method="post" action="">
								   <button type="submit" name="ordersubmit"  class="flex-c-m size1 bg1 bo-rad-20 hov1 s-text1 trans-0-4">
									Check Out
								</button>
                                       
								 </form>-->
					 <a href="cart.php" class="flex-c-m size1 bg1 bo-rad-20 hov1 s-text1 trans-0-4">
                            View Cart
                        </a>
                    </div>
                </div>';
            } 
			
            $output = array(  
				'cart_append'     =>     $cart_append,  
				'cart_item'          =>     count($_SESSION["shopping_cart"])  
			);  
			echo json_encode($output); 
      }  
      if($_POST["action"] == "remove")  
      {  
      	$order_table = '';
		$order_table2 = '';
      	$order_table .= '  
      	<table class="table-shopping-cart">
			<tr class="table-head">
				<th class="column-1">Product Image</th>
				<th class="column-2">Product</th>
				<th class="column-4 p-l-70">Quantity</th>
				<th class="column-3">Price (In Coins)</th>
				<th class="column-5">Total</th>
			</tr>';  
           foreach($_SESSION["shopping_cart"] as $keys => $values)  
           {  
                if($values["product_id"] == $_POST["product_id"])  
                {  
                     unset($_SESSION["shopping_cart"][$keys]);  
                     //$message = '<label class="text-success">Product Removed</label>';  
                    
			  			if(!empty($_SESSION["shopping_cart"]))  
			  			{  
			       			$total = 0;  
			       			foreach($_SESSION["shopping_cart"] as $keys => $values)  
			       			{  
			            		$order_table .= '  
			                 	<tr class="table-row">
									<td class="column-1">
										<div class="cart-img-product b-rad-4 o-f-hidden">
											<img src="admin/productimages/'.$values["product_name"].'/'.$values["product_image"].'" alt="IMG-PRODUCT">
										</div>
									</td>  
			                   		<td class="column-2">'.$values["product_name"].'</td>  
			                  		<td class="column-4">
			                  			<input type="button" name="quantityP[]" id="quantity'.$values["product_id"].'" value="+" class="quantity" data-product_id="'.$values["product_id"].'" style="font-size:14pt;border:1px solid #f00;padding:10px;background-color:#45445"/> 
			                  			<input type="text" name="quantityVal[]" id="quantityVal'.$values["product_id"].'" value="'.$values["product_quantity"].'" class="quantityVal" data-product_id="'.$values["product_id"].'" style="margin:0 0px 0 9px;width:25px;"/>
			                  			<input type="button" name="quantityM[]" id="quantityM'.$values["product_id"].'" value="-" class="quantityM" data-product_id="'.$values["product_id"].'" style="font-size:14pt;border:1px solid #f00;padding:10px;background-color:#45445" />
			                  		</td>  
			                    	<td class="column-3">'.$values["product_price"].'</td>  
			                      	<td align="right">'.number_format($values["product_quantity"] * $values["product_price"]).' <button name="delete" class="btn btn-danger btn-xs delete" id="'.$values["product_id"].'"><i class="fa fa-remove"></i></button></td>  
			                      	  
			                 	</tr>';  
			            		$total = $total + ($values["product_quantity"] * $values["product_price"]);
								$_SESSION['tp'] = $total;
								$_SESSION['product_quantity'] = $values["product_quantity"];
								$_SESSION['product_id'] = $values["product_id"];
			       			}
							$order_table .= '<tr>  
                                            <td colspan="3" align="right"><span class="m-text22 w-size19 w-full-sm">Total:</span></td>  
                                            <td align="right">'.number_format($total).'</td>  
                                            <td></td>  
                                        </tr>';
							$order_table .= '</table>';
			       			
			$total = 0; 
			foreach($_SESSION["shopping_cart"] as $keys => $values)  
	       			{
			$order_table2.='<ul class="header-cart-wrapitem">
                        <li class="header-cart-item">
                            <div class="header-cart-item-img">
                                <img src="admin/productimages/'.$values["product_name"].'/'.$values["product_image"].'" alt="IMG">
                            </div>
                            <div class="header-cart-item-txt">
                                <a href="#" class="header-cart-item-name">
                                    '.$values["product_name"].'
                                </a>
                                <span class="header-cart-item-info">
                         			'.$values["product_price"]. ' x ' .$values["product_quantity"].'
                                </span>
                               
                            </div>
                        </li>
                    </ul>';
					 
                    $total = $total + ($values["product_quantity"] * $values["product_price"]);
                   }
                 $order_table2.='<div class="header-cart-total">
                    Total: '.$total.'
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
					
                </div>';
			  			}
						
						
			  		
                }
           }  
            
			$output = array(  
				'order_table'     =>     $order_table,
				'order_table2'     =>     $order_table2,
				'cart_item'          =>     count($_SESSION["shopping_cart"])  
			);  
           echo json_encode($output); 
      }  
      	if($_POST["action"] == "quantity_change")  
      	{  
           foreach($_SESSION["shopping_cart"] as $keys => $values)  
           {  
                if($_SESSION["shopping_cart"][$keys]['product_id'] == $_POST["product_id"])  
                {  
                    $_SESSION["shopping_cart"][$keys]['product_quantity'] = $_POST["quantity"];  
                }  
           }  
      	
	      	$order_table .= ' 
	      	<table class="table-shopping-cart">
				<tr class="table-head">
					<th class="column-1">Product Image</th>
					<th class="column-2">Product</th>
					<th class="column-4 p-l-70">Quantity</th>
					<th class="column-3">Price (In Coins)</th>
					<th class="column-5">Total</th>
				</tr>';  
	  			if(!empty($_SESSION["shopping_cart"]))  
	  			{  
	       			$total = 0;  
	       			foreach($_SESSION["shopping_cart"] as $keys => $values)  
	       			{
						
	            		$order_table .= '  
	                 	<tr class="table-row">
							<td class="column-1">
								<div class="cart-img-product b-rad-4 o-f-hidden">
									<img src="admin/productimages/'.$values["product_name"].'/'.$values["product_image"].'" alt="IMG-PRODUCT">
								</div>
							</td>  
	                   		<td class="column-2">'.$values["product_name"].'</td>  
	                  		<td class="column-4">
	                  			<input type="button" name="quantityP[]" id="quantity'.$values["product_id"].'" value="+" class="quantity" data-product_id="'.$values["product_id"].'" style="font-size:14pt;border:1px solid #f00;padding:10px;background-color:#45445"/> 
	                  			<input type="text" name="quantityVal[]" id="quantityVal'.$values["product_id"].'" value="'.$values["product_quantity"].'" class="quantityVal" data-product_id="'.$values["product_id"].'" style="margin:0 0px 0 9px;width:25px;" />
	                  			<input type="button" name="quantityM[]" id="quantityM'.$values["product_id"].'" value="-" class="quantityM" data-product_id="'.$values["product_id"].'" style="font-size:14pt;border:1px solid #f00;padding:10px;background-color:#45445" />
	                  		</td>  
	                    	<td class="column-3">'.number_format($values["product_price"]).'</td>  
	                      	<td align="right">'.number_format($values["product_quantity"] * $values["product_price"]).' <button name="delete" class="btn btn-danger btn-xs delete" id="'.$values["product_id"].'"><i class="fa fa-remove"></i></button></td>  
	                      	  
	                 	</tr>';  
	            		$total = $total + ($values["product_quantity"] * $values["product_price"]);
							$_SESSION['tp'] = $total;
							$_SESSION['product_quantity'] = $values["product_quantity"];
							$_SESSION['product_id'] = $values["product_id"];
	       			}  
	       			
	  			}  
	  		               $order_table .= '<tr>  
                                            <td colspan="3" align="right"><span class="m-text22 w-size19 w-full-sm">Total:</span></td>  
                                            <td align="right">'.number_format($total).'</td>  
                                            <td></td>  
                                        </tr>';
										$order_table .= '</table>';
			
			
			$total = 0; 
			foreach($_SESSION["shopping_cart"] as $keys => $values)  
	       			{
			$order_table1.='<ul class="header-cart-wrapitem">
                        <li class="header-cart-item">
                            <div class="header-cart-item-img">
                                <img src="admin/productimages/'.$values["product_name"].'/'.$values["product_image"].'" alt="IMG">
                            </div>
                            <div class="header-cart-item-txt">
                                <a href="#" class="header-cart-item-name">
                                    '.$values["product_name"].'
                                </a>
                                <span class="header-cart-item-info">
                         			'.$values["product_price"]. ' x ' .$values["product_quantity"].'
                                </span>
                               
                            </div>
                        </li>
                    </ul>';
					 
                    $total = $total + ($values["product_quantity"] * $values["product_price"]);
                   }
                 $order_table1.='<div class="header-cart-total">
                    Total: '.$total.'
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
                </div>';
					
			
			$output = array(  
				'order_table'     =>     $order_table,
				'order_table1'     =>     $order_table1,
				'cart_item'          =>     count($_SESSION["shopping_cart"])  
			);  
			echo json_encode($output);  
		}  
	}
 ?>