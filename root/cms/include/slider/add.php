<?php 
$lngquera=$db->prepare('SELECT short_name as sn , org_name as orgn , u_id FROM lng ');
$lngquera->execute();
$shortname=array();
$orgname=array();
$luid=array();
$catquer=$db->prepare('SELECT u_id , name FROM slider where l_id="1" ');
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
        <h2>ADD  Slider </h2>
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
 <label class="control-label col-md-3 col-sm-3 col-xs-12">Name <span class="required">*</span></label>
                  <div class="col-md-6 col-sm-6 col-xs-12">                    <input name="names<?php echo $shortname[$i]; ?>" type="text" class="js-switch date-picker form-control col-md-7 col-xs-12" checked />                  </div>                </div> 
				  
				<div class="form-group">                  
 <label class="control-label col-md-3 col-sm-3 col-xs-12">Button name<span class="required">*</span>                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">                    <input name="button<?php echo $shortname[$i]; ?>" type="text" class="js-switch date-picker form-control col-md-7 col-xs-12" checked />                  </div>                </div>                <div class="form-group">                  
 <label class="control-label col-md-3 col-sm-3 col-xs-12">Button style<span class="required">*</span>                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">                    <input name="style5<?php echo $shortname[$i]; ?>" type="text" class="js-switch date-picker form-control col-md-7 col-xs-12" checked />                  </div>                </div>
			  <div class="form-group">
                  
 <label class="control-label col-md-3 col-sm-3 col-xs-12"> Link <span class="required">*</span>
                  </label>

                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input name="li<?php echo $shortname[$i]; ?>" type="text" class="js-switch date-picker form-control col-md-7 col-xs-12" checked />
                  </div>
                </div>
			
				<div class="form-group">            
				<label class="control-label col-md-3 col-sm-3 col-xs-12">Cover Picture <?php echo pxtostr($staticft['blog_cont_pic']); ?><span class="required">*</span>
				</label>

				<div class="col-md-6 col-sm-6 col-xs-12">
				<input name="pic<?php echo $shortname[$i]; ?>" class="date-picker form-control col-md-7 col-xs-12" required="required" type="file">
				</div>
				</div>
				</div>
            <?php
            }
            ?>
          </div>
<!--           <div class="form-group">
            
 <label class="control-label col-md-3 col-sm-3 col-xs-12">Content Picture <?php /* echo pxtostr($staticft['blog_cont_img']); */ ?><span class="required">*</span>
            </label>

            <div class="col-md-6 col-sm-6 col-xs-12">
              <input name="pics[]" multiple="" class="date-picker form-control col-md-7 col-xs-12" required="required" type="file">
            </div>
          </div> -->
<!--           <div class="form-group" style="display: none;">
            
 <label class="control-label col-md-3 col-sm-3 col-xs-12">Select Multiple</label>

            <div class="col-md-9 col-sm-9 col-xs-12">
              <select  id="somecountry" name="cat[]" style="width: 300px; border-radius:5px; margin:10px 0; display: none;" multiple data-plugin-selectTwo class="form-control populate">
                <?php /*
                while($catquerft=$catquer->fetch(PDO::FETCH_ASSOC))
                {
                ?>
                  <option value="<?php echo $catquerft['u_id'] ?>" ><?php echo $catquerft['name'] ?></option>
                <?php 
                } */
                ?>
              </select>
            </div>
          </div> -->
          <div class="form-group">
            
 <label class="control-label col-md-3 col-sm-3 col-xs-12">Display <span class="required">*</span>
            </label>

            <div class="col-md-6 col-sm-6 col-xs-12">
              <input name="sids" checked="" class="date-picker form-control col-md-7 col-xs-12 js-switch" type="checkbox">
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
            document.getElementById("<?php echo $shortname[$i]; ?>").style.color='red';
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
  $lngquer=$db->prepare('SELECT MAX(u_id) as max , MAX(ordering) as maxo FROM slider ');
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
  $db->begintransaction();

  
    $lastcont=1;
    for ($i=0; $i <$lngsay ; $i++) 
    {
		$unique1=rand(100,999);
		$unique2=rand(1000,9999);
		$unique3=rand(10000,99999);
		$unique=$unique1.$unique2.$unique3;
		$picf='pic'.$shortname[$i];
	  
		$type=explode('.', $_FILES[$picf]['name']);
		$type=end($type);
		echo '<pre>';print_r($_FILES[$picf]);echo '</pre>';
	  
	  if ($_FILES[$picf]['size']<=6000000 && in_array($_FILES[$picf]['type'], ['jpg','jpeg','png','image/jpeg','image/jpg','image/png']) && $control=move_uploaded_file($_FILES[$picf]['tmp_name'], 'images/'.$unique.'.'.$type) ) 
	  {
	  
		  $lngins=$db->prepare('INSERT INTO slider set ordering=:ord , name=:nm ,   photo1=:pt1 , u_id=:uid , l_id=:lng2 , `link`=:lik , s_id=:sid ,  style5=:style5, button=:button');
		  $lnginscon=$lngins->execute(array('lng2'=>$luid[$i] , 
											'lik'=>s($_POST['li'.$shortname[$i]]) ,
											'nm'=>s($_POST['names'.$shortname[$i]]) ,
											'pt1'=>$unique.'.'.$type ,
											'uid'=>$uid , 
											'ord'=>$ord ,
											'sid'=>$s,
											'style5'=>s($_POST['style5'.$shortname[$i]]),
											'button'=>s($_POST['button'.$shortname[$i]]) ));
		  if (!$lnginscon) 
		  {
			echo $lastcont=5;
			$lngins->errorInfo();
		  }
	  }
	  else
	  {
		  echo $shortname[$i];
		 echo $lastcont=4;
		 echo '<br>';
		$db->rollBack();
		//header('Location:'.$site_url.'slider/list/456456/');
		//exit();

	  }
    }
	echo $lastcont;
    if ($lastcont==1) 
    {
      $db->commit(); echo "string";
      header('Location:'.$site_url.'slider/list/456852/');
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
      //header('Location:'.$site_url.'slider/list/456456/');
      //exit();
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