<div class="middle">
	<div class="container">
		<div class="page_title_wrapper">
			<h1 class="page_title"><?PHP echo $loginupdate['title'][$lng]; ?></h1>
		</div>
		<div class="middle_content">
		<?PHP
		if($_POST['sbmtbtn'])
		{
			$login=htmlspecialchars(addslashes($_POST['curr_login']));
			$password=htmlspecialchars(addslashes($_SESSION['pass_real']));
			$pass_real=htmlspecialchars(addslashes($_SESSION['pass_real']));
			
			//$password=passme($password);
			$sas=$db->prepare('SELECT 
			`u`.*
			
			FROM 
			
			`user` u 
			
			WHERE 
			
			`u`.`login`="'.$login.'" and 
			`u`.`pass_real`="'.$pass_real.'" and 
			`u`.`question`="'.$_POST['sec_q'].'" and 
			`u`.`answer`="'.$_POST['sec_a'].'" 
			
			LIMIT 1');
			
			$sas->execute();
			$cnt=$sas->rowCount();
			if($cnt==1)
			{
				$b = $sas->fetch(PDO::FETCH_ASSOC);
				if(password_verify($password, $b['pass']))
				{
					//setting login filters************************************************   
					$_POST['la_login'] = str_replace(' ', '', $_POST['la_login']);// Replaces all spaces with hyphens. 
					$_POST['la_login'] = preg_replace('/[^A-Za-z0-9\_]/', '', $_POST['la_login']);// Removes special chars.
					if(strlen($_POST['la_login'])<3 or strlen($_POST['la_login'])>20)
					{
						$error=1;
						$errortype[]=1;// login lenth is not correct
					}
					$a=$db->prepare('SELECT * from `user` where  `login` = :mailx limit 1');
					$a->execute(ARRAY('mailx'=>$_POST['la_login']));
					$ab=$a->fetch(PDO::FETCH_ASSOC);
					if($ab['serial'])	
					{
						$error=2;
						$errortype[]=2; // login already taken	

					}
					$a=$db->prepare('SELECT * from `onlinestore` where  `login` =:mailx limit 1');
					$a->execute(ARRAY('mailx'=>$_POST['la_login']));
					$ab=$a->fetch(PDO::FETCH_ASSOC);
					if($ab['serial'])	
					{
						$error=3;
						$errortype[]=2; // login already taken	
					}
					$_POST['la_login']=strtolower($_POST['la_login']);

					//*********************************************************************
					
					if($error>=1)
					{
						//error with login
					}
					else
					{
						$sas=$db->prepare('update `user` set `login`="'.$_POST['la_login'].'" where id="'.$b['id'].'" LIMIT 1');
						$sas->execute();
						
						//redirect to login.php***********************************************
						//isset($_POST['loginPost']) && isset($_POST['_originalToken']) && $_POST['_originalToken']==$_SESSION['_originalToken']
						echo'
						<form action="'.$site_url.$lng.'/login/ok/" method="post" id="formsubmit4">
							<input type="hidden" name="loginPost" value="ok">
							<input type="hidden" name="_originalToken" value="'.$_SESSION['_originalToken'].'">
							<input type="hidden" name="login" value="'.$_POST['la_login'].'">
							<input type="hidden" name="pass" value="'.$pass_real.'">
						</form>
						
						<script>
							document.getElementById("formsubmit4").submit();
						</script>';
						//********************************************************************
					}
				}
				else
				{
					//something went wrong error page
				}
			}
			else
			{
				//something went wrong error page
			}
		}
		else
		{
		?>
			<br />
			<div style="text-align:center;">
				<?PHP echo $loginupdate['topnote'][$lng]; ?> 
			</div>
			<?PHP
			if(empty($_SESSION['false_login']))
			{
				//error line will go here
			}
			else
			{
			?>
			<br />
			<br />
			<div class="order_form user_settings">
				<form action=""  method="POST"  onsubmit="return validateme()">
					<div class="form_item">
						<label for=""><?PHP echo $loginupdate['currla'][$lng]; ?> :</label>
						<input type="text" class="form_text" name="curr_login" value="<?PHP echo $_SESSION['false_login'];?>" id="flafield" readonly>
					</div>
					<div class="form_item">
						<label for=""><?PHP echo $loginupdate['yourla'][$lng]; ?> :</label>
						<input type="text" class="form_text margin_right" name="la_login" value="" id="login" onchange="checklogin()">
						<a href="" onclick="event.preventDefault()" id="loginhint" class="hint">?</a>
							<div id="loginerr" class="rederror"><?php echo $loginupdate['lifeaccounttext'][$lng] ?></div>
					</div>
					
					<div class="form_item">
						<label for=""><?PHP echo $loginupdate['secquest'][$lng]; ?></label>
						<input type="text" class="form_text" name="sec_q" value="<?PHP echo $_SESSION['question'];?>" id="flafield" readonly>
					</div>
					
					<div class="form_item">
						<label for=""><?PHP echo $loginupdate['secansw'][$lng]; ?> :</label>
						<input type="text" class="form_text" name="sec_a" value="">
					</div>
					<br>
					<div class="form_actions">
						<input type="submit" class="form_submit" value="<?PHP echo $lostpassword['confirm'][$lng]; ?>" name="sbmtbtn">
					</div>
				</form>
			</div>
			<br /><br />
			<br />
			<br />
		<?PHP
			}
		}
		?>
		</div>
	</div>
</div>

<style>
.form_item {
    margin-bottom: 30px;
     width: 100%; 
}
.form_item label {
    margin: 0px 0px 5px 0px;
    text-align: left; 
}
.order_form .form_item:not(.form_textarea):not(.form_checkbox) label {
    float: left;
    width: 38%;
    text-align: right;
    line-height: 32px;
    padding-right: 0.5%;
}
.block_title
{
	padding:0px !important;
}
.rederror
{
	color: gray;
	padding: 3px;
	float: right;
	width: 34%;
	visibility: hidden;
	border-radius: 7px;
	-moz-border-radius: 7px;
	-webkit-border-radius: 7px;
	font-size: 11px;
	text-align: center;
	box-shadow: 2px 2px 3px #f5f5f5;
	-moz-box-shadow: 2px 2px 3px #f5f5f5;
	-webkit-box-shadow: 2px 2px 3px #f5f5f5;
}
.margin_right
{
	margin-right:20px;
}
.phoneholder
{
	width: 221px;
	height: 32px;
	float: left;
	border: 1px solid #bbd2d7;
	padding-left: 10px;
}
.phoneprefix
{
	width: 45px;
	height: 32px;
	float: left;
	border: 1px solid #bbd2d7;
	text-align: center;
	margin-right: 4px;
}
.hint
{
	padding: 1px 6px;
	display: inline-block;
	text-decoration: none;
	border: 1px solid #bbd2d7;
	border-radius: 32px;
	color: #bbd2d7;
	margin-top: 5px;
	float: left;
	font-size: 12px;
}
.hint:hover + .rederror
{
	visibility:visible;
} 
.hinterror
{
	border: 1px solid red !important;
	padding: 1px 7px !important;
	color:red !important;
}
@media (max-width: 767px)
{
	.order_form .form_item:not(.form_textarea):not(.form_checkbox) .form_text, .order_form .form_item:not(.form_textarea):not(.form_checkbox) select
	{
    width: 83%;
    margin-right: 10px;
	}
	.order_form .form_item:not(.form_textarea):not(.form_checkbox) label 
	{
    width: 100%;
    text-align: left;
    line-height: 32px;
    padding-right: 0.5%;
    margin: 0px auto;
	}
	.rederror {
    color: gray;
    padding: 3px;
    float: right;
	width:100%;
    visibility: hidden;
    border-radius: 7px;
    -moz-border-radius: 7px;
    -webkit-border-radius: 7px;
    font-size: 11px;
    text-align: center;
    box-shadow: 2px 2px 3px #f5f5f5;
    -moz-box-shadow: 2px 2px 3px #f5f5f5;
    -webkit-box-shadow: 2px 2px 3px #f5f5f5;
	}
}
</style>
<script>
	//**************************************************************************************************************************************
	
function checklogin()
	{
		var lg=document.getElementById("login").value;
		//alert(lg);
		$.post( "<?PHP echo $site_url;?>ajax/check_login_post.php", { login: lg, lng: "<?PHP echo $lng; ?>" })
		  .done(function( data ) {
			//$( "#loginerr" ).html( data );
			data2=jQuery.parseJSON(data);
			console.log(data2.type);
			var lg=document.getElementById("login").value;
			var spn = document.getElementById("loginhint");
			var div = document.getElementById("loginerr");
			var element = document.getElementById("login");
			if(data2.type==1)
			{
				element.classList.add("error");
				spn.classList.add("hinterror"); 
				window.value400=1;
				spn.innerHTML = '!' ;
				window.value=1 ;
				window.red=1 ;
			}
			else if(data2.type==2)
			{				
				element.classList.add("error");
				spn.classList.add("hinterror"); 
				window.value400=1;
				spn.innerHTML = '!' ;
				window.value=1 ;
				window.red=1 ;
				div.innerHTML += "<span id='loginexist'><?PHP echo $loginupdate['lifeaccountexist'][$lng]; ?></span>" ;
			}
			else if(data2.type==3)
			{				
				element.classList.remove("error");
				spn.classList.remove("hinterror");
				spn.innerHTML = '?' ; 
				window.value400=0;
				var spn2 = document.getElementById("loginexist");
				if(spn2)
				{
					spn2.innerHTML='';
				}
			}
		  });
	}
	function validateme()
	{
		if(window.value400==0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
//**************************************************************************************************************************************
</script>