<?php 
$lngquera=$db->prepare('SELECT short_name as sn , org_name as orgn , u_id FROM lng ');
$lngquera->execute();
$shortname=array();
$orgname=array();
$luid=array();
$catquer=$db->prepare('SELECT u_id , name FROM opportunity_banner where l_id="1" ');
$catquer->execute();
while($lngquerasor=$lngquera->fetch(PDO::FETCH_ASSOC))
{
  array_push($orgname, $lngquerasor['orgn']);
  array_push($shortname, $lngquerasor['sn']);
  array_push($luid, $lngquerasor['u_id']);
}
$lngsay=count($luid);
?>
<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>ADD  opportunity banner </h2>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">   
        <form method="POST" action="" enctype="multipart/form-data" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
          <div class="w3-container">
            <div class="w3-row">
              <?php
              for($i=0;$i<$lngsay;$i++)
              {
              ?>
                <a id="<?php echo $shortname[$i] ?>" href="javascript:void(0)" onclick="openCity(event, '<?php echo $orgname[$i]; ?>');">
                  <div class="w3-quarter  tablink w3-bottombar w3-hover-light-grey w3-padding"><?php echo $orgname[$i]; ?></div>
                </a>
              <?php
              }
              ?>
            </div>
            <?php
            for($i=0;$i<$lngsay;$i++)
            {
            ?>
              <div id="<?php echo $orgname[$i]; ?>" class="w3-container city" style="display:none">
                <h2><?php echo $orgname[$i]; ?></h2>
				<div class="form-group">                  
 <label class="control-label col-md-3 col-sm-3 col-xs-12">Title <span class="required">*</span></label>
                  <div class="col-md-6 col-sm-6 col-xs-12">                    <input name="title<?php echo $shortname[$i]; ?>" type="text" class="js-switch date-picker form-control col-md-7 col-xs-12" checked />                  </div>                </div> 
				  
				<div class="form-group">                  
                 <label class="control-label col-md-3 col-sm-3 col-xs-12">Description<span class="required">*</span>                  
                 </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">                    
                  <textarea name="desc<?php echo $shortname[$i]; ?>" type="text" class="js-switch date-picker form-control col-md-7 col-xs-12" checked ></textarea>                   
                  </div>                
                </div>
                
                <div class="form-group">                  
                 <label class="control-label col-md-3 col-sm-3 col-xs-12">Button text<span class="required">*</span>                  
                 </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">                    
                  <input name="button_text<?php echo $shortname[$i]; ?>" type="text" class="js-switch date-picker form-control col-md-7 col-xs-12" checked />                  
                  </div>                
                </div>
                
			    <div class="form-group">                  
                 <label class="control-label col-md-3 col-sm-3 col-xs-12">Button link<span class="required">*</span>                  
                 </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">                    
                  <input name="button_link<?php echo $shortname[$i]; ?>" type="text" class="js-switch date-picker form-control col-md-7 col-xs-12" checked />                  
                  </div>                
                </div>
				
				</div>
            <?php
            }
            ?>
            <div class="form-group">            
				<label class="control-label col-md-3 col-sm-3 col-xs-12">Cover Picture <?php echo pxtostr($staticft['blog_cont_pic']); ?><span class="required">*</span>
				</label>

				<div class="col-md-6 col-sm-6 col-xs-12">
				<input name="image" class="date-picker form-control col-md-7 col-xs-12" required="required" type="file">
				</div>
		    </div>
          </div>
          <div class="form-group">
            
 <label class="control-label col-md-3 col-sm-3 col-xs-12">Display <span class="required">*</span>
            </label>

            <div class="col-md-6 col-sm-6 col-xs-12">
              <input name="sids" checked="" class="date-picker form-control col-md-7 col-xs-12 js-switch" type="checkbox">
            </div>
          </div>
          
          <div class="form-group">
            
 <label class="control-label col-md-3 col-sm-3 col-xs-12">Main banner <span class="required">*</span>
            </label>

            <div class="col-md-6 col-sm-6 col-xs-12">
              <input name="main" checked="" class="date-picker form-control col-md-7 col-xs-12 js-switch" type="checkbox">
            </div>
          </div>
          <div class="form-group">
            <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-3">
              <input id="btnid" type="submit" name="btn" value="submit" class="btn btn-success"/>
            </div>
          </div>
        </form>        
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
<?php
for ($i=0;$i<$lngsay;$i++) 
{
?>
  function  check<?php echo $shortname[$i]; ?>()
  {
    var check = 1;
    var x = document.getElementById('tagurl<?php echo $shortname[$i]; ?>').value.toLowerCase();
    document.getElementById('tagurl<?php echo $shortname[$i]; ?>').value=x;
    $.ajax({
      method: "POST",
      url: "<?php echo $site_url.'include/islem.php' ?>",
      data: { bco: "contenttagurl", name: x },
      success:function(data)
      {
        //alert(data);
        if (data=='true') 
        {
          var checkcont<?php echo $shortname[$i]; ?> =1;
          document.getElementById("tagurl<?php echo $shortname[$i]; ?>").style.borderColor='#ccc';
          document.getElementById("<?php echo $shortname[$i]; ?>").style.color='#5A738E';
        }
        else if (data=='false')
        {
          var checkcont<?php echo $shortname[$i]; ?> =0;
          document.getElementById("tagurl<?php echo $shortname[$i]; ?>").style.borderColor='red';
        }
        <?php 
        for ($t=0;$t<$lngsay;$t++) 
        {
        ?>
          if (checkcont<?php echo $shortname[$t]; ?>==0)
          {
            check=0;
          }
        <?php 
        }
        ?>
        if(check==1)
        {
          document.getElementById("btnid").type='submit';
        }
        else if (check==0)
        {
          document.getElementById("btnid").type='button';
        }
      }
    })
  }
<?php 
}
?>
</script>
<?php
if ($_POST['btn']) 
{
  $lngquer=$db->prepare('SELECT MAX(u_id) as max , MAX(ordering) as maxo FROM opportunity_banner ');
  $lngquer->execute(); 
  $lngquersor=$lngquer->fetch(PDO::FETCH_ASSOC);
  echo '<pre>';print_r($_POST);echo '</pre>';
  //echo '<pre>';print_r($_FILES['pic']);echo '</pre>';
  

  $uid=$lngquersor['max']+1;
  $ord=$lngquersor['maxo']+10;
  if ($_POST['sids']=='on') 
  {
    $s=NULL;
  }
  else
  {
    $s=0;
  }
  
  if ($_POST['main']=='on') 
  {
    $main=1;
  }
  else
  {
    $main=0;
  }
  $db->begintransaction();

  
    $lastcont=1;
    
    $unique1=rand(100,999);
  $unique2=rand(1000,9999);
  $unique3=rand(10000,99999);
  $unique=$unique1.$unique2.$unique3;
  $picf='image';
  $type=explode('.', $_FILES[$picf]['name']);
	$type=end($type);
	echo '<pre>';print_r($_FILES[$picf]);echo '</pre>';
      
    
    for ($i=0; $i <$lngsay ; $i++) 
    {
		
	  
	  $control=move_uploaded_file($_FILES[$picf]['tmp_name'], 'images/'.$unique.'.'.$type);
	  
	  if ($_FILES[$picf]['size']<=600000 && in_array($_FILES[$picf]['type'], ['jpg','jpeg','png','image/jpeg','image/jpg','image/png'])   ) 
	  {
	  
		  $lngins=$db->prepare('INSERT INTO opportunity_banner set ordering=:ord ,is_main=:is_main, image=:image , u_id=:uid , l_id=:lng2 , s_id=:sid , title=:title, description=:desc, button_text=:button_text, button_link=:button_link');
		  $lnginscon=$lngins->execute(array('lng2'=>$luid[$i] , 
											'image'=>$unique.'.'.$type ,
											'uid'=>$uid ,
											'is_main'=>$main,
											'ord'=>$ord ,
											'sid'=>$s,
											'title'=>s($_POST['title'.$shortname[$i]]),
											'desc'=>s($_POST['desc'.$shortname[$i]]),
											'button_text'=>s($_POST['button_text'.$shortname[$i]]),
											'button_link'=>s($_POST['button_link'.$shortname[$i]]) ));
		  if (!$lnginscon) 
		  {
			echo $lastcont=5;
			$lngins->errorInfo();
		  }
	  }
	  else
	  {
		 echo $shortname[$i].'<br>';
		 echo $lastcont=4;
		 echo '<br>';
		$db->rollBack();
		header('Location:'.$site_url.'opportunity_banners/list/456456/');
		exit();

	  }
    }
    if ($lastcont==1) 
    {
      $db->commit(); echo "string";
      header('Location:'.$site_url.'opportunity_banners/list/456852/');
      exit();
    }
    else
    {
      $db->rollBack();        
      if (is_file('images/'.$unique.'.'.$type) and is_file('images/'.$t1unique.'.'.$t1type) ) 
      {
        unlink('images/'.$unique.'.'.$type);
        unlink('images/'.$t1unique.'.'.$t1type);
      }  
      echo 'ss';
      header('Location:'.$site_url.'opportunity_banners/list/456456/');
      exit();
    }
  
}

?>
<script>
function openCity(evt, cityName , tol) 
{
  var i, x, tablinks;
  x = document.getElementsByClassName("city");
  for (i = 0; i < x.length; i++) 
  {
    x[i].style.display = "none";
  }
  tablinks = document.getElementsByClassName("tablink");
  for (i = 0; i < x.length; i++) 
  {
    tablinks[i].className = tablinks[i].className.replace(" w3-border-red", "");
  }
  document.getElementById(cityName).style.display = "block";
  if (tol==1) 
  {
    document.getElementById(evt).firstElementChild.className += " w3-border-red";
  }
  else
  {
    evt.currentTarget.firstElementChild.className += " w3-border-red";
  }
}
openCity('<?php echo $shortname[0] ?>', '<?php echo $orgname[0] ?>' , 1);
</script>