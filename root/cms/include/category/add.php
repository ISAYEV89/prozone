<?php 
$lngquera=$db->prepare('SELECT short_name as sn , org_name as orgn , u_id FROM lng ');
$lngquera->execute();
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
        <h2>ADD Category </h2>
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
                  <label class="control-label col-md-3 col-sm-3 col-xs-12"> Name  <span class="required">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input name="nm<?php echo $shortname[$i]; ?>" type="text" class="js-switch date-picker form-control col-md-7 col-xs-12" checked />
                  </div>
                </div>
              </div>
            <?php
            }
            ?>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Icon <?php echo pxtostr($staticft['xams_ico']); ?><span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input name="ico" class="date-picker form-control col-md-7 col-xs-12" required="required" type="file">
            </div>
          </div>                
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">All Country <span class="required">*</span>
            </label>
            <div class="col-md-9 col-sm-9 col-xs-12">
               <input name="allc<?php echo $shortname[$i]; ?>" type="checkbox" class="js-switch date-picker form-control col-md-7 col-xs-12"  />
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
  echo '<pre>';print_r($_FILES);echo '</pre>';
  $lngquer=$db->prepare('SELECT MAX(kat_id) as max , MAX(ordering) as maxo FROM kateqoriyalar ');
  $lngquer->execute(); 
  $lngquersor=$lngquer->fetch(PDO::FETCH_ASSOC);
  $sunique1=rand(100,999);
  $sunique2=rand(1000,9999);
  $sunique3=rand(10000,99999);
  $sunique=$sunique1.$sunique2.$sunique3;
  $type2=explode('.', $_FILES['ico']['name']);
  $type2=$type2[1];
  $uid=$lngquersor['max']+1;
  $ord=$lngquersor['maxo']+1;
  $control=1;
  if ($_POST['sids']=='on') 
  {
    $s=0;
  }
  else
  {
    $s=1;
  }
  if ($_POST['allc']=='on') 
  {
    $k=1;
  }
  else
  {
    $k=0;
  }
  $db->begintransaction();
  if ($_FILES['ico']['size']<=600000 && in_array($_FILES['ico']['type'], ['svg','image/svg','image/svg+xml','jpg','jpeg','png','image/jpeg','image/jpg','image/png']) && $control=move_uploaded_file($_FILES['ico']['tmp_name'], 'images/'.$sunique.'.'.$type2)) 
  {
    for ($i=0; $i <$lngsay ; $i++) 
    {      
      $lngins=$db->prepare('INSERT INTO kateqoriyalar set l_id=:lng2 , all_country=:allc , `name`=:name , ordering=:ord , picture=:ico , kat_id=:uid , s_id=:sid ');
      $lnginscon=$lngins->execute(array('lng2'=>$luid[$i] , 'allc'=>$k , 'name'=>s($_POST['nm'.$shortname[$i]]) , 'ico'=>$sunique.'.'.$type2 , 'uid'=>$uid , 'ord'=>$ord , 'sid'=>$s ));
           // echo '<pre>';
      //print_r($lngins); echo '</pre>';
      //echo '<pre>';
      //print_r(array('lng2'=>$luid[$i] , 'sti'=>s($_POST['stit'.$shortname[$i]]) , 'txt'=>s($_POST['txt'.$shortname[$i]]) , 'ico'=>$sunique.'.'.$type2 , 'uid'=>$uid , 'ord'=>$ord , 'sid'=>$s )); echo '</pre>';
      if (!$lnginscon) 
      {
        $control=0;
      }
    }
    if ($control==1) 
    {
      $db->commit();
      header('Location:'.$site_url.'category/list/456852/');
      exit();
    }
    else
    {
      $db->rollBack();          
      if (is_file('images/'.$sunique.'.'.$type2)) 
      {
        unlink('images/'.$sunique.'.'.$type2);
      }
      header('Location:'.$site_url.'category/list/456456/');
      exit();
    }
  }
  else
  {
    $db->rollBack();
    header('Location:'.$site_url.'category/list/456456/');
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