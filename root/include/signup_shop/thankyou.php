<?PHP
	echo'<script>localStorage.clear();</script>';//girishde localstorage-i temizleyirik
	unset($_SESSION['signup_referer_id'] ,$_SESSION['signup_country_id'] ,$_SESSION['post_shop_data'] ,$_SESSION['post_reg_data']);
?>

<div class="middle">
	<div class="container">
		<div class="page_title_wrapper">
			<h1 class="page_title"><?php echo $thankyou['thankyou'][$lng] ?></h1>
		</div>
		<div class="middle_content clearfix" style="text-align:center;">
			<br>
				<?PHP echo $thankyou['text1'][$lng] ?>
			<br> 
			<br>
		</div>
	</div>
</div>