<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	<?php 
if(!isset($_GET['page']) or $_GET['page']!='basket'){
	echo'<script>window.location="'.$site_url.'";</script>'; 
	die();  
}
	

$db_handle = new DBController();
if(!empty($_GET['val'])) {
$links = explode("__",$_GET['val']);
$action = strip_tags($links[0]);
$name   = (int)strip_tags($links[1]);
switch($action) {
	case "add":
		if(!empty($_POST["quantity"]) && is_numeric($_POST["ccid"])) {
			
			
			$select_true_olke = mysqli_query($connection, "SELECT `kat_id` FROM olkeler WHERE l_id='".$lng."' AND kat_id='" . (int)$_POST["ccid"]. "' limit 1");
			if(mysqli_num_rows($select_true_olke)<=0){
				die('xeta var');
			}

			$select_elan = mysqli_query($connection, "SELECT `elan_id` FROM elanlar WHERE l_id='".$lng."' AND elan_id='" . $name . "' limit 1");
			if(mysqli_num_rows($select_elan)>0){
				$secilmish_elan_price = mysqli_query($connection, "SELECT * FROM mehsul_olke WHERE olke_id='".(int)$_POST["ccid"]."' && elan_id='".$name."'");
				
				if(mysqli_num_rows($secilmish_elan_price)>0){
					// yeni ferqli qiymeti varsa 
					$sql_sorgu = "SELECT e.`elan_id`,e.`name`, e.`image_url`, f.`price1`, f.`price2`, f.`price3`, f.`valyuta_id` FROM `elanlar` AS e JOIN `mehsul_olke` AS f ON e.`elan_id`=f.`elan_id` WHERE e.`l_id`='".$lng."' AND e.`elan_id`='" . $name . "' AND f.`olke_id`='".(int)$_POST["ccid"]."' ";
				}else{
					$sql_sorgu = "SELECT * FROM elanlar WHERE l_id='".$lng."' AND elan_id='" . $name . "'";
				}
			}else{
				die('yanlish sorgu');
			}
			$productByCode = $db_handle->runQuery($sql_sorgu);
			

			$itemArray = array($productByCode[0]["name"]=>array('name'=>$productByCode[0]["name"], 'elan_id'=>$productByCode[0]["elan_id"], 'quantity'=>$_POST["quantity"], 'price1'=>$productByCode[0]["price1"],'image_url'=>$productByCode[0]["image_url"]));
			
			if(!empty($_SESSION["cart_item"])) {
				if(in_array($productByCode[0]["name"],array_keys($_SESSION["cart_item"]))) {
					foreach($_SESSION["cart_item"] as $k => $v) {
							if($productByCode[0]["name"] == $k) {
								if(empty($_SESSION["cart_item"][$k]["quantity"])) {
									$_SESSION["cart_item"][$k]["quantity"] = 0;
								}
								$_SESSION["cart_item"][$k]["quantity"] += $_POST["quantity"];
							}
					}
				} else {
					$_SESSION["cart_item"] = array_merge($_SESSION["cart_item"],$itemArray);
				}
			} else {
				$_SESSION["cart_item"] = $itemArray;
			}
		}
	break; 
	case "remove":
		if(!empty($_SESSION["cart_item"])) {
			/*
			echo '<pre>';
			var_dump($_SESSION["cart_item"]);
			echo '</pre>';
			echo '<hr/>'.$name;
			die();
			*/
			foreach($_SESSION["cart_item"] as $k => $v) {
					if($name == $_SESSION["cart_item"][$k]["elan_id"])
						unset($_SESSION["cart_item"][$k]);				
					if(empty($_SESSION["cart_item"]))
						unset($_SESSION["cart_item"]);
			}
		}
	break;
	case "empty":
		unset($_SESSION["cart_item"]);
	break;	
}
}
?>
<div class="middle">
		<div class="container">
			<div class="page_title_wrapper">
				<h1 class="page_title">Корзина</h1>
			</div>
			<div class="middle_content">
				<section class="basket_check">
				    <div class="basket_check_list">
				        <div class="basket_check_list_title">Товар</div>
				        <div class="basket_check_list_title">Цена, руб</div>
				        <div class="basket_check_list_title">Количество</div>
				        <div class="basket_check_list_title">Сумма, руб</div>
				    </div>
			<?php 
				if(isset($_SESSION["cart_item"]) && count($_SESSION["cart_item"])>0 && $_SESSION["cart_item"]!=""){
					$item_total = 0;
				 	foreach ($_SESSION["cart_item"] as $item){

						?>

						 <div class="basket_check_items">
						        <div class="basket_check_items_item" >
						            <div class="basket_check_items_item_photo"><img src="<?=$site_url?>products/elanlar/<?=explode('||', $item['image_url'])[0];?>" alt=""></div>
						            <div class="basket_check_items_item_title">
						                <div class="item_name"> <?php echo $item["name"]; ?></div>
						                <!-- <div class="item_article">Артикул: <span>45971644</span></div> -->
						            </div>
						           <!--  <div class="basket_check_items_item_price"> <?php echo $item["price1"]; ?></div> -->
						            <div class="basket_check_items_item_counter" style="width: 290px;">
						                <footer class="content">

									<div class="col-md-2">
										<h2 class="price float" style="margin-left: -33px">
											<?php echo $item["price1"]; ?> azn
										</h2>
									</div>
										
										<span class="qt-minus float">-</span>
										<span class="qt float">1</span>
										<span class="qt-plus float">+</span>
									
										<h2 class="full-price float">
											<?php echo $item["price1"]; ?> azn
										</h2>
										<input type="hidden" id="last_price" name="last_price[<?php echo $item["elan_id"]; ?>]" value="<?php echo $item["price1"]; ?>"/>
										<h2 class="price" style="display: none">
											<?php echo $item["price1"]; ?>
										</h2>
										
				                </footer>
						            </div>
						            <!-- <div class="basket_check_items_item_total">2 256</div> -->
						           <a href="<?=$site_url.$lng2?>/basket/remove__<?php echo $item["elan_id"]; ?>/"> <div class="item_close"><img src="images/close-icon.png" alt=""></div></a>
						        </div>
				 	   </div>
				
					<?php
			        	$item_total += ($item["price1"]*$item["quantity"]);
					}

				}else{
					echo "Hal-hazırda səbətdə məhsul yoxdur";
				}
				?>

				    <div class="basket_controls">
				        <div class="basket_controls_goback"><a href="#">Продолжить покупки</a></div>
				        <div class="basket_sum">
				           	<div class="total_price_wrap">
           			            <div class="basket_sum_total"><span><!--Сумма вашего заказа:--></span>
           			            	<?php
				                    echo '
           		                <h3 class="subtotal">Ümumi məbləğ: <span name="subtotal"> '.@$item_total.'</span>azn</h3>
							<input type="hidden" name="last_total" id="last_total" value="'.@$item_total.'"/>';?>
				           	</div>
				           	<form action="<?=$site_url.$lng2?>/order/" method="POST">
					            <div class="basket_sum_submit">
					                <input type="submit" value='Оформить заказ'>
					            </div>
				            </form>
				        </div>
				    </div>
				</section>
			</div>
		</div>
	</div>
<script>
var check = false;

function changeVal(el) {
  var qt = parseFloat(el.parent().children(".qt").html());
  var price = parseFloat(el.parent().children(".price").html());
  var eq = Math.round(price * qt * 100) / 100;
  
  el.parent().children(".full-price").html( eq + "azn" );
  el.parent().children("#last_price").val(eq);
  
  changeTotal();			
}

function changeTotal() {
  
  var price = 0;
  
  $(".full-price").each(function(index){
    price += parseFloat($(".full-price").eq(index).html());
  });
  
  price = Math.round(price * 100) / 100;
  var tax = Math.round(price * 0.05 * 100) / 100
  var shipping = parseFloat($(".shipping span").html());
  var fullPrice = Math.round((price + tax + shipping) *100) / 100;
  
  if(price == 0) {
    fullPrice = 0;
  }

  $(".subtotal span").html(price);
  $(".tax span").html(tax);
  $(".total span").html(fullPrice);
  
  $("#last_total").val(price);
  
}

$(document).ready(function(){
  

  
  $(".qt-plus").click(function(){
    $(this).parent().children(".qt").html(parseInt($(this).parent().children(".qt").html()) + 1);
    
    $(this).parent().children(".full-price").addClass("added");
    
    var el = $(this);
    window.setTimeout(function(){el.parent().children(".full-price").removeClass("added"); changeVal(el);}, 150);
  });
  
  $(".qt-minus").click(function(){
    
    child = $(this).parent().children(".qt");
    
    if(parseInt(child.html()) > 1) {
      child.html(parseInt(child.html()) - 1);
    }
    
    $(this).parent().children(".full-price").addClass("minused");
    
    var el = $(this);
    window.setTimeout(function(){el.parent().children(".full-price").removeClass("minused"); changeVal(el);}, 150);
  });
  
  window.setTimeout(function(){$(".is-open").removeClass("is-open")}, 1200);
  

});
</script>
<style>
	.float{
		float: left;
	}
</style>





