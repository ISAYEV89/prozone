<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<div class="middle">
    <div class="container">
        <div class="page_title_wrapper">
            <h1 class="page_title"><?PHP echo $signup['header1'][$lng] ; ?></h1>
        </div>

		<div class="middle_content">
			<br />
			<div style="text-align:center;">
				<?PHP echo $signup['topnote'][$lng]; ?> 
			</div>
			<br />
			<br />
			<div class="order_form user_settings">
				<form action="<?PHP echo $site_url.$lng.'/signup_shop/1/'?>"  method="POST">
				<?PHP
				if($_GET['cat'])
				{
					$lng06sor=$db->prepare('SELECT id, login, serial FROM `user` where serial=:lid limit 1');
					$lng06sor->execute(array('lid'=>$_GET['cat']));
					$lng06count=$lng06sor->rowCount();
					if($lng06count==1)
					{
						$usinf=$lng06sor->fetch(PDO::FETCH_ASSOC);
						$llfd=1;
					}
					else
					{
						$llfd=2;
					}
				}
				else
				{
					$llfd=2;
				}
				
				if($llfd==1)
				{
					echo'<div class="form_item">
						<label for="">'.$signup['referlogin'][$lng].'</label> 
						<input type="text" class="form_text" value="'.$usinf['login'].'" name="la_login" readonly>
					</div>
					<div class="form_item">
						<label for="">'.$signup['referlaid'][$lng].'</label>
						<input type="text" class="form_text" name="la_id" value="'.$usinf['serial'].'" id="lafield" readonly><span id="serial_field" style="margin-left:10px; line-height:32px;"></span>
					</div>';
				}
				else
				{
					echo'<div class="form_item">
						<label for="">'.$signup['referlogin'][$lng].'</label> 
						<input type="text" class="form_text" value="" name="la_login">
					</div>
					<div class="form_item">
						<label for="">'.$signup['referlaid'][$lng].'</label>
						<input type="text" class="form_text" name="la_id" value="" id="lafield" ><span id="serial_field" style="margin-left:10px; line-height:32px;"></span>
					</div>';
				}
				?>
					<div class="form_item">
						<label ><?PHP echo $signup['mycountry'][$lng]; ?></label>
						<select id="country_login" name="country_login">
							<option value="Countries" disabled selected><?PHP echo $signup['mycountry1'][$lng]; ?></option>
							
							<?PHP
								$lng01sor=$db->prepare('SELECT * FROM olkeler where l_id=:lid and sub_id=0  ');

							$lng01sor->execute(array('lid'=>$lng1));

							$lng01count=$lng01sor->rowCount();

							while($olke=$lng01sor->fetch(PDO::FETCH_ASSOC))
							{
								echo '<option value="'.$olke['kat_id'].'">'.$olke['name'].'</option>';
							}
							?>
							
						</select>
					</div>
					<div class="form_actions">
						<a href="#" class="no-referrer" style="color: #3dc8e4;"><?PHP echo $signup['donthaveref'][$lng]; ?></a>
					</div>
					
					<br>
					<div class="form_actions">
						<input type="submit" class="form_submit" value="<?PHP echo $signup['confirm'][$lng]; ?>">
					</div>
				</form>
			</div>
			<div style="text-align:center;">
				<?PHP echo $signup['note'][$lng]; ?> 
			</div>
			<br /><br />
			<br />
			<br />
		</div>
    </div>
    <!--class="container"-->

    <div class="request-modal">
        <div class="addition-modal-box"></div>

        <div class="content-request">
            <div class="close-request-modal"></div>
            <div class="block_title">Request LA ID referrer number</div>
        
            <form action="" method="post" id="modAja" name="modAja" method="post">
                <div class="form_item">
                    <input name="modal_name" id='modal_name' type="text" class="form_text" placeholder="Name">
                </div>
                <div class="form_item">
                    <input name="modal_surname" id="modal_surname" type="text" class="form_text" placeholder="Surname">
                </div>
                <div class="form_item">
                    <select  class="form_text loginaj" name="modal_country" id="modal_country">
                        <option value="Countries" disabled selected>Country I live in</option>
                        <option value="AFG">Afghanistan</option>
                        <option value="ALA">Åland Islands</option>
                        <option value="ALB">Albania</option>
                        <option value="DZA">Algeria</option>
                        <option value="ASM">American Samoa</option>
                        <option value="AND">Andorra</option>
                        <option value="AGO">Angola</option>
                        <option value="AIA">Anguilla</option>
                        <option value="ATA">Antarctica</option>
                        <option value="ATG">Antigua and Barbuda</option>
                        <option value="ARG">Argentina</option>
                        <option value="ARM">Armenia</option>
                        <option value="ABW">Aruba</option>
                        <option value="AUS">Australia</option>
                        <option value="AUT">Austria</option>
                        <option value="AZE">Azerbaijan</option>
                       
                    </select>
                </div>
                <div class="form_item">
                    <input name="modal_passport" id="modal_passport" type="text" class="form_text" placeholder="Passport number">
                </div>
                <div class="form_item" style="display:none;">
                    <p id="ajax" style='color:red'></p>
                </div>

                <div class="btn-next">
                    <button id="lns-btn"  name="lns-btn" class="lns-btn" type="submit"> Send</button>
                </div>
            </form>
            <div class="thank-you" style="display:none;">
                <div class="tick-box">
                    <i class="fa fa-check" aria-hidden="true" style="margin: 0px;"></i>
                </div>
                
                <div class="thank-you-msg">
                    <p>Sizin sorğunuz müvəffəqiyyətlə göndərildi </p>
                </div>
                
                <div class="thank-you-notice">
                    <p><b>Important Notice:</b> Əgər şəxs Refferer nömrəsi almaq üçün şirkətə sorğu göndərib və heç bir cavab almayıbsa bu zaman şirkət Referer nömrəsini göndərməmək hüququnu özündə saxlayır.</p>
                </div>
            </div>
            
        </div>

    </div>

</div>


