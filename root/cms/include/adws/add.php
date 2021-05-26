<?php 
$lngquera=$db->prepare('SELECT short_name as sn , org_name as orgn , u_id FROM lng ');
$lngquera->execute();
$catquer=$db->prepare('SELECT u_id , name FROM blog_cat where l_id="1" ');
$catquer->execute();
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
        <h2>ADD Adwords  </h2>
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
                  <label class="control-label col-md-3 col-sm-3 col-xs-12">link <span class="required">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input name="li<?php echo $shortname[$i]; ?>" type="text" class="js-switch date-picker form-control col-md-7 col-xs-12" />
                  </div>
                </div>
              </div>
            <?php
            }
            ?>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Picture <?php echo pxtostr($staticft['blog_cat_pic']); ?><span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input name="pic" class="date-picker form-control col-md-7 col-xs-12" required="required" type="file">
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
<?php
if ($_POST['btn']) 
{
  echo '<pre>';print_r($_POST);echo '</pre>';
  $lngquer=$db->prepare('SELECT MAX(u_id) as max  FROM announce ');
  $lngquer->execute(); 
  $lngquersor=$lngquer->fetch(PDO::FETCH_ASSOC);
  $unique1=rand(100,999);
  $unique2=rand(1000,9999);
  $unique3=rand(10000,99999);
  $unique=$unique1.$unique2.$unique3;
  $type=explode('.', $_FILES['pic']['name']);
  $type=$type[1];
  $uid=$lngquersor['max']+1;
  $control=1;
  $db->begintransaction();

  if ($_FILES['pic']['size']<=600000 && in_array($_FILES['pic']['type'], ['jpg','jpeg','png','image/jpeg','image/jpg','image/png']) && $control=move_uploaded_file($_FILES['pic']['tmp_name'], 'images/'.$unique.'.'.$type)) 
  {

    for ($i=0; $i <$lngsay ; $i++) 
    {      
      $lngins=$db->prepare('INSERT INTO announce set l_id=:lng2 , link=:lk , picture=:pc , u_id=:uid  ');
      $lnginscon=$lngins->execute(array('lng2'=>$luid[$i] , 'lk'=>s($_POST['li'.$shortname[$i]]) , 'pc'=>$unique.'.'.$type , 'uid'=>$uid ));
      if (!$lnginscon) 
      {
       echo  $control=0;  echo '<pre>'; print_r( $lngins); echo '<pre>';
      }
    }
    if ($control==1) 
    {
      $db->commit();
      header('Location:'.$site_url.'adws/list/456852/');
      exit();
    }
    else
    {
      $db->rollBack();         
      if (is_file('images/'.$unique.'.'.$type)) 
      {
        unlink('images/'.$unique.'.'.$type);
      }    
      header('Location:'.$site_url.'adws/list/456456/');
      exit();
    }
  }
  else
  {
    $db->rollBack();
    header('Location:'.$site_url.'adws/list/456456/');
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