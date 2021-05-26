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
$sitequera=$db->prepare('SELECT * FROM site_general where u_id=:uid and l_id="1" ');
$sitequera->execute(array('uid'=>s($_GET['val']))); 
$count=$sitequera->rowCount();
$sitequerasor=$sitequera->fetch(PDO::FETCH_ASSOC);
if (!$_GET['val'] or $count!=1) 
{
  header('Location:'.$site_url.'general_site/list/');
  exit();
}
?>
<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>Edit Site General Settings</h2>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">   
        <form method="POST" action="" id="demo-form2"  enctype="multipart/form-data" data-parsley-validate class="form-horizontal form-label-left">
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
              $sitequers=$db->prepare('SELECT * FROM site_general where u_id=:uid and l_id=:lid');
              $sitequers->execute(array('uid'=>s($_GET['val']) , 'lid'=>$luid[$i] ));
              $sitequerssor=$sitequers->fetch(PDO::FETCH_ASSOC);
            ?>
              <div id="<?php echo $orgname[$i]; ?>" class="w3-container city" style="display:none">
                <h2><?php echo $orgname[$i]; ?></h2>
                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12">Name 
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input name="names<?php echo $shortname[$i]; ?>" type="text" value='<?php echo $sitequerssor["name"] ?>'   class="js-switch date-picker form-control col-md-7 col-xs-12"  />
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12">Description 
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input name="desc<?php echo $shortname[$i]; ?>" type="text" value='<?php echo $sitequerssor["description"] ?>'   class="js-switch date-picker form-control col-md-7 col-xs-12"  />
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12">Title 
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input name="tit<?php echo $shortname[$i]; ?>" type="text" value='<?php echo $sitequerssor["title"] ?>'   class="js-switch date-picker form-control col-md-7 col-xs-12"  />
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12">Keyword 
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input name="key<?php echo $shortname[$i]; ?>" type="text" value='<?php echo $sitequerssor["keyword"] ?>'   class="js-switch date-picker form-control col-md-7 col-xs-12"  />
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12">Address 
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input name="add<?php echo $shortname[$i]; ?>" type="text" value='<?php echo $sitequerssor["adress"] ?>'   class="js-switch date-picker form-control col-md-7 col-xs-12"  />
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12">About Home
                  </label>
                  <div class="col-md-9 col-sm-9 col-xs-12">
                    <textarea name="abh<?php echo $shortname[$i]; ?>" ><?php echo $sitequerssor["about_home"] ?></textarea>
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12">About 
                  </label>
                  <div class="col-md-9 col-sm-9 col-xs-12">
                    <textarea name="ab<?php echo $shortname[$i]; ?>" ><?php echo $sitequerssor["about"] ?></textarea>
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12">Copyright 
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <textarea name="copyright<?php echo $shortname[$i]; ?>"  class="js-switch date-picker form-control col-md-7 col-xs-12"  ><?php echo $sitequerssor["copyright"] ?></textarea>
                  </div>
                </div>
              </div>
              
            <?php
            }
            ?>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Domain 
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input name="dom" type="text" value='<?php echo $sitequerssor["domain"] ?>'   class="js-switch date-picker form-control col-md-7 col-xs-12"  />
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Mail 1
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input name="email" type="text" value='<?php echo $sitequerssor["mail"] ?>'   class="js-switch date-picker form-control col-md-7 col-xs-12"  />
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Mail 2 
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input name="email2" type="text" value='<?php echo $sitequerssor["mail2"] ?>'   class="js-switch date-picker form-control col-md-7 col-xs-12"  />
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Logo <?php echo pxtostr($staticft['site_gen_pic']); ?>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input name="pic" type="file" value='<?php echo $sitequerssor["logo"] ?>'   class="js-switch date-picker form-control col-md-7 col-xs-12" />
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Google Api 
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input name="googlea" type="text" value='<?php echo $sitequerssor["google_api"] ?>'   class="js-switch date-picker form-control col-md-7 col-xs-12"  />
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Facebook Api 
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input name="fba" type="text" value='<?php echo $sitequerssor["fb_api"] ?>'   class="js-switch date-picker form-control col-md-7 col-xs-12"  />
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Instagram 
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input name="ins" type="text" value='<?php echo $sitequerssor["ins"] ?>'   class="js-switch date-picker form-control col-md-7 col-xs-12"  />
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Facebook 
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input name="fb" type="text" value='<?php echo $sitequerssor["fb"] ?>'   class="js-switch date-picker form-control col-md-7 col-xs-12"  />
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Telephone 1
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input name="ph1" type="text" value='<?php echo $sitequerssor["tel1"] ?>'   class="js-switch date-picker form-control col-md-7 col-xs-12"  />
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Telephone 2
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input name="ph2" type="text" value='<?php echo $sitequerssor["tel2"] ?>'   class="js-switch date-picker form-control col-md-7 col-xs-12"  />
            </div>
          </div>
          <div class="form-group">
            <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-3">
              <input id="btnid" type="submit" name="btn" value="Submit" class="btn btn-success"/>
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
    CKEDITOR.replace( '<?php echo "ab".$shortname[$i] ?>' );
    CKEDITOR.replace( '<?php echo "abh".$shortname[$i] ?>' );
  </script>
<?php
}
?>
<?php
if ($_POST['btn']) 
{
  print_r($_POST);
  $source=0;
  if($_FILES['pic']['tmp_name']!='')
  {
    echo 'salse';
    $unique1=rand(100,999);
    $unique2=rand(1000,9999);
    $unique3=rand(10000,99999);
    $unique=$unique1.$unique2.$unique3;
    $type=explode('.', $_FILES['pic']['name']);
    $type=end($type);
    if ($_FILES['pic']['size']<=600000 && in_array($_FILES['pic']['type'], ['jpg','jpeg','png','image/jpeg','image/jpg','image/png']) && $control=move_uploaded_file($_FILES['pic']['tmp_name'], 'images/'.$unique.'.'.$type)) 
    {
      echo $source=1;
    }
  }
  $db->begintransaction();
  $lastcont=1;
  for ($i=0; $i <$lngsay ; $i++) 
  {
    if($_FILES['pic']['tmp_name']!='')
    { 
      echo 'tttt';
      $lngins=$db->prepare('UPDATE site_general set description=:sn ,
                                                    title=:ti ,
                                                    keyword=:keyw ,
                                                    mail=:ml ,
                                                    mail2=:ml2 ,
                                                    `tel1`=:tl1 ,
                                                    `tel2`=:tl2 ,
                                                    adress=:add  ,
                                                    domain=:dom ,
                                                    name=:nm  ,
                                                    about=:abo  ,                                                    
                                                    about_home=:aboh  ,
                                                    logo=:pc ,
                                                    google_api=:gogapi ,
                                                    fb_api=:fbap ,
                                                    ins=:inst ,
                                                    fb=:fab,
                                                    copyright=:copy
                                                    where u_id=:uid and l_id=:lng2 ');    
      $lnginscon=$lngins->execute(array('lng2'=>$luid[$i] ,
                                        'sn'=>s($_POST['desc'.$shortname[$i]]) ,
                                        'nm'=>s($_POST['names'.$shortname[$i]]) ,
                                        'ti'=>s($_POST['tit'.$shortname[$i]]) ,
                                        'keyw'=>s($_POST['key'.$shortname[$i]]) ,
                                        'abo'=>sck($_POST['ab'.$shortname[$i]]) ,
                                        'aboh'=>sck($_POST['abh'.$shortname[$i]]) ,
                                        'uid'=>s($_GET['val']) ,
                                        'pc'=>$unique.'.'.$type ,
                                        'ml'=>s($_POST['email']) ,
                                        'ml2'=>s($_POST['email2']) ,
                                        'tl1'=>s($_POST['ph1']) ,
                                        'tl2'=>s($_POST['ph2']) ,
                                        'add'=>sck($_POST['add'.$shortname[$i]]) ,
                                        'dom'=>s($_POST['dom']) ,
                                        'gogapi'=>s($_POST['googlea']) ,
                                        'fbap'=>s($_POST['fba']) ,
                                        'inst'=>s($_POST['ins']) ,
                                        'fab'=>s($_POST['fb']) ,
                                        'copy'=>s($_POST['copyright'.$shortname[$i]])));
    }
    else
    {
      $lngins=$db->prepare('UPDATE site_general set description=:sn ,
                                                    title=:ti ,
                                                    keyword=:keyw ,
                                                    mail=:ml ,
                                                    mail2=:ml2 ,
                                                    `tel1`=:tl1 ,
                                                    `tel2`=:tl2 ,
                                                    adress=:add  ,
                                                    domain=:dom ,
                                                    name=:nm  ,
                                                    about=:abo  ,                                              
                                                    about_home=:aboh  ,
                                                    google_api=:gogapi ,
                                                    fb_api=:fbap ,
                                                    ins=:inst ,
                                                    fb=:fab,
                                                    copyright=:copy
                                                    where u_id=:uid and l_id=:lng2 ');  
      $lnginscon=$lngins->execute(array('lng2'=>$luid[$i] ,
                                        'sn'=>s($_POST['desc'.$shortname[$i]]) ,
                                        'nm'=>s($_POST['names'.$shortname[$i]]) ,
                                        'ti'=>s($_POST['tit'.$shortname[$i]]) ,
                                        'keyw'=>s($_POST['key'.$shortname[$i]]) ,
                                        'abo'=>sck($_POST['ab'.$shortname[$i]]) ,
                                        'aboh'=>sck($_POST['abh'.$shortname[$i]]) ,
                                        'uid'=>s($_GET['val']) ,
                                        'ml'=>s($_POST['email']) ,
                                        'ml2'=>s($_POST['email2']) ,
                                        'tl1'=>s($_POST['ph1']) ,
                                        'tl2'=>s($_POST['ph2']) ,
                                        'add'=>sck($_POST['add'.$shortname[$i]]) ,
                                        'dom'=>s($_POST['dom']) ,
                                        'gogapi'=>s($_POST['googlea']) ,
                                        'fbap'=>s($_POST['fba']) ,
                                        'inst'=>s($_POST['ins']) ,
                                        'fab'=>s($_POST['fb'])   ,
                                        'copy'=>s($_POST['copyright'.$shortname[$i]])));
    }
    if (!$lnginscon) 
    {
      echo $lastcont=0;
    }
  }

  if ($lastcont==1) 
  {
    if ($source==1) 
    {
      if (is_file('images/'.$sitequerasor['logo']))       
      {
        if(unlink('images/'.$sitequerasor['logo']))
        {
          $db->commit(); 
          echo('dsa');
          header('Location:'.$site_url.'general_site/list/456852/');
          exit();
        }  
        else
        {
          echo('datasa');
          $db->rollBack();
          header('Location:'.$site_url.'general_site/list/456456/');
          exit();
        } 
      }
      else
      {        
        $db->commit(); 
        echo('dsa');
        header('Location:'.$site_url.'general_site/list/456852/');
        exit();
      }
    }
    else
    {
      $db->commit(); 
      echo('dsa');
      header('Location:'.$site_url.'general_site/list/456852/');
      exit();
    }
  }
  else
  {
    echo('daasa');
    $db->rollBack();
    header('Location:'.$site_url.'general_site/list/456456/');
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