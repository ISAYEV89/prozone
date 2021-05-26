<div class="middle">
		<div class="container">
			<div class="page_title_wrapper">
				<h1 class="page_title"><?PHP echo $lostpassword['title'][$lng]; ?></h1>
			</div>
			<div class="middle_content">
				<br />
				<div style="text-align:center;">
					<?PHP echo $lostpassword['topnote'][$lng]; ?> 
				</div>
				<br />
				<br />
				<div class="order_form user_settings">
					<form action="<?PHP echo $site_url.$lng.'/lostpassword/verify/'; ?>"  method="POST">
						<div class="form_item">
							<label for=""><?PHP echo $lostpassword['yourla'][$lng]; ?></label>
							<input type="text" class="form_text" name="la_login" value="" id="lafield" onchange="get_serial(this.value)"><span id="serial_field" style="margin-left:10px; line-height:32px;"></span>
						</div>
						<div class="form_item">
							<label for=""><?PHP echo $lostpassword['youremail'][$lng]; ?></label>
							<input type="email" class="form_text" value="" name="la_email">
						</div>
						<br>
						<div class="form_actions">
							<input type="submit" class="form_submit" value="<?PHP echo $lostpassword['confirm'][$lng]; ?>">
						</div>
					</form>
				</div>
				<div style="text-align:center;">
					<span style="color:red">*</span> <?PHP echo $lostpassword['note'][$lng]; ?> 
				</div>
				<br /><br />
				<br />
				<br />
			</div>
		</div>
	</div>
</div>
<script>
	//**************************************************************************************************************************************
	
	var xmlHttp
function GetXmlHttpObject()
{
var xmlHttp=null;
try
 {
 // Firefox, Opera 8.0+, Safari
 xmlHttp=new XMLHttpRequest();
 }
catch (e)
 {
 //Internet Explorer
 try
  {
  xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
  }
 catch (e)
  {
  xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
 }
return xmlHttp;
}
function get_serial(no)
{
xmlHttp=GetXmlHttpObject()
if (xmlHttp==null)
 {
 alert ("Browser does not support HTTP Request")
 return
 }
var url="<?PHP echo $site_url;?>ajax/get_serial.php"
url=url+"?login="+no
url=url+"&sid="+Math.random()
xmlHttp.onreadystatechange=stateChanged
xmlHttp.open("GET",url,true)
xmlHttp.send(null)
}

function stateChanged()
{ 
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		document.getElementById("serial_field").innerHTML=xmlHttp.responseText ;
	}
}
//**************************************************************************************************************************************
</script>