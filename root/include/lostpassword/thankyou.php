<div class="middle">
		<div class="container">
			<div class="page_title_wrapper">
				<h1 class="page_title"><?PHP echo $lostpassword['pwdredemption'][$lng]; ?></h1>
			</div>
			<div class="middle_content">
				<div class="order_form user_settings">
					<br />
					<h3 style="text-align:center;"><?PHP echo $lostpassword['thankyoutext1'][$lng]; ?></h3>
					<br />
					<div style="text-align:center;width: 400px;margin: 0px auto;margin-bottom: 30px;">
						<?PHP echo $lostpassword['thankyoutext2'][$lng]; ?>
					</div>
					<div style="text-align:center;">
						<Div style="min-height: 48px;    -webkit-box-shadow: 0 2px 2px rgba(15, 55, 66, 0.1);    box-shadow: 0 2px 2px rgba(15, 55, 66, 0.1);    background: #43b9da;
    text-shadow: 0 1px 1px rgba(0, 0, 0, 0.15);  cursor:pointer;  font-size: 24px;    font-weight: 300;    border: none;    width: 270px;    color: #fff; padding:7px;  line-height: 30px; margin:0px auto;" id="backBtn">
							<?PHP echo $lostpassword['backbtn'][$lng]; ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
	$('#backBtn').click(function()
	{
		location.replace("<?PHP echo $site_url.$lng.'/'; ?>");
	})
</script>