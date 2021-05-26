<?php 
$blogquera=$db->prepare('SELECT * FROM opportunity_banner where u_id=:uid limit 1 ');
$blogquera->execute(array('uid'=>s($_GET['val'])));
$count=$blogquera->rowCount();
$blogquerasor=$blogquera->fetch(PDO::FETCH_ASSOC);
if (!$_GET['val'] or $count!=1) 
{
  header('Location:'.$site_url.'opportunity_banner/list/');
  exit();
}
$lngquera=$db->prepare('SELECT short_name as sn , org_name as orgn , u_id FROM lng ');
$lngquera->execute();
$categeriinc=array();
$shortname=array();
$orgname=array();
$luid=array();
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
        <h2>Edit Slider </h2>
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
              $blogquers=$db->prepare('SELECT * FROM opportunity_banner where u_id=:uid and l_id=:lid');
              $blogquers->execute(array('uid'=>s($_GET['val']) , 'lid'=>$luid[$i] ));
              $blogquerssor=$blogquers->fetch(PDO::FETCH_ASSOC);
            ?>
              <div id="<?php echo $orgname[$i]; ?>" class="w3-container city" style="display:none">
                <h2><?php echo $orgname[$i]; ?></h2>
				<div class="form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12">Title <span class="required">*</span></label>
					<div class="col-md-6 col-sm-6 col-xs-12">
						<input value="<?php echo $blogquerssor['title'] ?>" name="title<?php echo $shortname[$i]; ?>" type="text" class="js-switch date-picker form-control col-md-7 col-xs-12" checked />
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12">Description  <span class="required">*</span></label>
					<div class="col-md-6 col-sm-6 col-xs-12">
						<textarea name="desc<?php echo $shortname[$i]; ?>"  class="js-switch date-picker form-control col-md-7 col-xs-12" ><?php echo $blogquerssor["description"] ?></textarea>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12">Button text <span class="required">*</span></label>
					<div class="col-md-6 col-sm-6 col-xs-12">
						<input value="<?php echo $blogquerssor['button_text'] ?>" name="button_text<?php echo $shortname[$i]; ?>" type="text" class="js-switch date-picker form-control col-md-7 col-xs-12" checked />
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12">Button link <span class="required">*</span></label>
					<div class="col-md-6 col-sm-6 col-xs-12">
						<input value="<?php echo $blogquerssor['button_link'] ?>" name="button_link<?php echo $shortname[$i]; ?>" type="text" class="js-switch date-picker form-control col-md-7 col-xs-12" checked />
					</div>
				</div>
				
			</div>

            <?php
            }
            ?>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Picture<span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <img style="width: 200px;" src="<?php echo $site_url.'images/'.$blogquerasor['image'] ?>"  class="  col-md-7 col-xs-12" checked />
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Cover Picture <?php echo pxtostr($staticft['blog_cont_pic']); ?><span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input name="image" class="date-picker form-control col-md-7 col-xs-12"  type="file">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Display <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input name="sids" <?php if(is_null($blogquerasor['s_id'])){ echo 'checked=""';} ?> class="date-picker form-control col-md-7 col-xs-12 js-switch" type="checkbox">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Main <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input name="main" <?php if($blogquerasor['is_main']==1){ echo 'checked=""';} ?> class="date-picker form-control col-md-7 col-xs-12 js-switch" type="checkbox">
            </div>
          </div
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
<script src="<?php echo $site_url ?>ckeditor/ckeditor.js"></script>
<?php
for($i=0;$i<$lngsay;$i++)
{
?>
  <script>
  //  var checkcont<?php echo $shortname[$i]; ?> =1;
  //  CKEDITOR.replace( '<?php echo "txt".$shortname[$i] ?>' );
  </script>
<?php
}
?>
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
      data: { mc: "mctagurl", name: x , id: <?php echo s($_GET['val']);  ?> },
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
<?php
function d($post)
{
  if ($post=='on') 
  {
    return NULL;
  }
  else
  {
    return 0;
  }
}
if ($_POST['btn']) 
{	  //echo '<pre>';print_r($_POST);echo '</pre>';
  $source=0;
  if($_FILES['image']['tmp_name']=='')
  {
    print_r($_FILES);
  }
  if($_FILES['image']['tmp_name']!='')
  {
      
    $unique1=rand(100,999);
    $unique2=rand(1000,9999);
    $unique3=rand(10000,99999);
    $unique=$unique1.$unique2.$unique3;
    $type=explode('.', $_FILES['image']['name']);
    $type=end($type);
    if ($_FILES['image']['size']<=600000 && in_array($_FILES['image']['type'], ['jpg','jpeg','png','image/jpeg','image/jpg','image/png']) && $control=move_uploaded_file($_FILES['image']['tmp_name'], 'images/'.$unique.'.'.$type)) 
    {
       $source=1;
    }
  }
  
  $db->begintransaction();
  $lastcont=1;
  if($_POST['main']=='on'){
      $main = 1;
  }else{
      $main=0;
  }
  
  for ($i=0; $i <$lngsay ; $i++) 
  {
    if($_FILES['image']['tmp_name']!='')
    {
      $lngins=$db->prepare('UPDATE opportunity_banner set 
                                              s_id=:sid,
                                              image=:image, 
                                              title=:title,
                                              description=:desc,
                                              button_text=:btn_text,
                                              button_link=:btn_link,
                                              is_main=:main
                                              where u_id=:uid and l_id=:lng2 ');    
      $lnginscon=$lngins->execute(array('lng2'=>$luid[$i] , 
                                        'uid'=>s($_GET['val']) ,
                                        'sid'=>d(s($_POST['sids'])) ,
                                        'title'=>s($_POST['title'.$shortname[$i]]),
                                        'desc'=>s($_POST['desc'.$shortname[$i]]),
                                        'btn_text'=>s($_POST['button_text'.$shortname[$i]]),
                                        'btn_link'=>s($_POST['button_link'.$shortname[$i]]),
                                        'main'=> $main,
                                        'image'=>$unique.'.'.$type   ));
      if (!$lnginscon) 
        {
          $lastcont=0;
          print_r($lngins->errorInfo());
        }
    }
    else
    {
      $lngins=$db->prepare('UPDATE opportunity_banner set 
                                              s_id=:sid ,
                                              title=:title,
                                              description=:desc,
                                               button_text=:btn_text,
                                              button_link=:btn_link,
                                              is_main=:main
                                              where u_id=:uid and l_id=:lng2 ');    
      $lnginscon=$lngins->execute(array('lng2'=>$luid[$i] , 
                                        'uid'=>s($_GET['val']) ,
                                        'sid'=>d(s($_POST['sids'])) ,
                                        'title'=>s($_POST['title'.$shortname[$i]]),
                                        'desc'=>s($_POST['desc'.$shortname[$i]]),
                                        'btn_text'=>s($_POST['button_text'.$shortname[$i]]),
                                        'btn_link'=>s($_POST['button_link'.$shortname[$i]]),
                                        'main'=>$_POST['main']=='on' ? 1:0));
    }
    if (!$lnginscon) 
    {
      $lastcont=0;
      print_r($lngins->errorInfo());
    }
  }
  
  if ($lastcont==1) 
  {
    if ($source==1) 
    {        
      if (is_file('images/'.$blogquerasor['image'])) 
      {
        unlink('images/'.$blogquerasor['image']);
      }  
    }
    $db->commit();
   header('Location:'.$site_url.'opportunity_banners/list/456852/');
    exit();
  }
  else
  {
    if (is_file('images/'.$unique.'.'.$type)) 
    {
      unlink('images/'.$unique.'.'.$type);
    }
    $db->rollBack();
    header('Location:'.$site_url.'opportunity_banners/list/456456/');
    exit();
  } 
}

?>