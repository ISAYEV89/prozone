<?php 
$faqquera=$db->prepare('SELECT * FROM faq where u_id=:uid limit 1 ');
$faqquera->execute(array('uid'=>s($_GET['val'])));
$count=$faqquera->rowCount();
$faqquerasor=$faqquera->fetch(PDO::FETCH_ASSOC);
if (!$_GET['val'] or $count<1) 
{
  header('Location:'.$site_url.'faq/list/');
}
$lngquera=$db->prepare('SELECT short_name as sn , org_name as orgn , u_id FROM lng ');
$lngquera->execute();
$shortname=array();
$orgname=array();
$luid=array();
$category=array();
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
        <h2>FAQ edit </h2>
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
              $faqquers=$db->prepare('SELECT * FROM faq where u_id=:uid and l_id=:lid');
              $faqquers->execute(array('uid'=>s($_GET['val']) , 'lid'=>$luid[$i] ));
              $faqquerssor=$faqquers->fetch(PDO::FETCH_ASSOC);
            ?>              
              <div id="<?php echo $orgname[$i]; ?>" class="w3-container city" style="display:none">
                <h2><?php echo $orgname[$i]; ?></h2>  
                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12">Sual <span class="required">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input name="sl<?php echo $shortname[$i]; ?>" type="text" value="<?php echo $faqquerssor['sual'] ?>" class="js-switch date-picker form-control col-md-7 col-xs-12" checked />
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12">Cavab <span class="required">*</span>
                  </label>
                  <div class="col-md-9 col-sm-9 col-xs-12">
                    <textarea  class="col-md-8 col-lg-8 col-sm-8 col-xs-12" rows="9" name="cvb<?php echo $shortname[$i]; ?>" ><?php echo $faqquerssor['cavab'] ?></textarea>
                  </div>
                </div>
              </div>
            <?php
            }
            ?>
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
<script src="<?php echo $site_url ?>ckeditor/ckeditor.js"></script>
<?php
for($i=0;$i<$lngsay;$i++)
{
?>
  <script>
    var checkcont<?php echo $shortname[$i]; ?> =1;
    CKEDITOR.replace( '<?php echo "cvb".$shortname[$i] ?>' );
  </script>
<?php
}
?>

<?php
if ($_POST['btn']) 
{
  echo '<pre>';print_r($_POST);echo '</pre>';
  $lngquer=$db->prepare('SELECT MAX(u_id) as max , MAX(ordering) as maxo FROM faq ');
  $lngquer->execute(); 
  $lngquersor=$lngquer->fetch(PDO::FETCH_ASSOC);
  $uid=s($_GET['val']);
  $control=1;
  $db->begintransaction();
  for ($i=0; $i <$lngsay ; $i++) 
  { 
    $lngins=$db->prepare('UPDATE faq set  `cavab`=:csvb ,  sual=:sul  where u_id=:uid and l_id=:lng2 ');
    $lnginscon=$lngins->execute(array('lng2'=>$luid[$i] ,'csvb'=>sck($_POST['cvb'.$shortname[$i]]) ,'sul'=>s($_POST['sl'.$shortname[$i]]),'uid'=>$uid ));
    if (!$lnginscon) 
    {
      echo $control=0;
    }
  }
  if ($control==1) 
  { 
    $db->commit(); 
    header('Location:'.$site_url.'faq/list/456852/');
  }
  else
  {
    $db->rollBack();
    header('Location:'.$site_url.'faq/list/456456/');
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