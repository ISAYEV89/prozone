<?php 
$machinequera=$db->prepare('SELECT * FROM texnika_content where u_id=:uid limit 1 ');
$machinequera->execute(array('uid'=>s($_GET['val'])));
$count=$machinequera->rowCount();
$machinequerasor=$machinequera->fetch(PDO::FETCH_ASSOC);
if (!$_GET['val'] or $count!=1) 
{
  header('Location:'.$site_url.'machine_content/list/');
}
$lngquera=$db->prepare('SELECT short_name as sn , org_name as orgn , u_id FROM lng ');
$lngquera->execute();
$categeriinc=array();
$shortname=array();
$orgname=array();
$luid=array();
$catquer=$db->prepare('SELECT u_id , name FROM texnika_cat where l_id="1" ');
$catquer->execute();
while($lngquerasor=$lngquera->fetch(PDO::FETCH_ASSOC))
{
  array_push($orgname, $lngquerasor['orgn']);
  array_push($shortname, $lngquerasor['sn']);
  array_push($luid, $lngquerasor['u_id']);
}
$catequer=$db->prepare('SELECT cat_id FROM texnika_cat_cont where cont_id="'.s($_GET['val']).'" ');
$catequer->execute();
while($catequerft=$catequer->fetch(PDO::FETCH_ASSOC))
{
  array_push($categeriinc, $catequerft['cat_id']);
}
$lngsay=count($luid);
?>
<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>ADD machine CONTENT </h2>
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
              $machinequers=$db->prepare('SELECT * FROM texnika_content where u_id=:uid and l_id=:lid');
              $machinequers->execute(array('uid'=>s($_GET['val']) , 'lid'=>$luid[$i] ));
              $machinequerssor=$machinequers->fetch(PDO::FETCH_ASSOC);
            ?>
              <div id="<?php echo $orgname[$i]; ?>" class="w3-container city" style="display:none">
                <h2><?php echo $orgname[$i]; ?></h2>
                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12">Url tag <span class="required">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input value="<?php echo $machinequerssor['url_tag'] ?>" id="tagurl<?php echo $shortname[$i]; ?>" onchange="check<?php echo $shortname[$i]; ?>();" name="urltag<?php echo $shortname[$i]; ?>" type="text" class="js-switch date-picker form-control col-md-7 col-xs-12" checked />
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12">Name <span class="required">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input value="<?php echo $machinequerssor['name'] ?>" name="names<?php echo $shortname[$i]; ?>" type="text" class="js-switch date-picker form-control col-md-7 col-xs-12" checked />
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12">Description <span class="required">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input value="<?php echo $machinequerssor['description'] ?>" name="desc<?php echo $shortname[$i]; ?>" type="text" class="js-switch date-picker form-control col-md-7 col-xs-12" checked />
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12">Title <span class="required">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input value="<?php echo $machinequerssor['title'] ?>" name="tit<?php echo $shortname[$i]; ?>" type="text" class="js-switch date-picker form-control col-md-7 col-xs-12" checked />
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12">Short Title <span class="required">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input name="stit<?php echo $shortname[$i]; ?>" type="text" value='<?php echo $machinequerssor["stitle"] ?>'  class="js-switch date-picker form-control col-md-7 col-xs-12"  />
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12">Keyword <span class="required">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input value="<?php echo $machinequerssor['keyword'] ?>" name="key<?php echo $shortname[$i]; ?>" type="text" class="js-switch date-picker form-control col-md-7 col-xs-12" checked />
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12">Text <span class="required">*</span>
                  </label>
                  <div class="col-md-9 col-sm-9 col-xs-12">
                    <textarea name="txt<?php echo $shortname[$i]; ?>" ><?php echo $machinequerssor['text'] ?></textarea>
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
              <img style="width: 200px;" src="<?php echo $site_url.'images/'.$machinequerasor['picture'] ?>"  class="  col-md-7 col-xs-12" checked />
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Cover Picture <?php echo pxtostr($staticft['texnika_cont_pic']); ?><span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input name="pic" class="date-picker form-control col-md-7 col-xs-12"  type="file">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Select Multiple</label>
            <div class="col-md-9 col-sm-9 col-xs-12">
              <select id="somecountry" name="cat[]" style="width: 300px; border-radius:5px; margin:10px 0;" multiple data-plugin-selectTwo class="form-control populate">
                <?php
                while($catquerft=$catquer->fetch(PDO::FETCH_ASSOC))
                {
                ?>
                  <option <?php if(in_array($catquerft['u_id'] , $categeriinc)){echo 'selected=""';} ?> value="<?php echo $catquerft['u_id'] ?>" ><?php echo $catquerft['name'] ?></option>
                <?php 
                }
                ?>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Display <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input name="sids" <?php if(is_null($machinequerasor['s_id'])){ echo 'checked=""';} ?> class="date-picker form-control col-md-7 col-xs-12 js-switch" type="checkbox">
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
<script src="<?php echo $site_url ?>ckeditor/ckeditor.js"></script>
<?php
for($i=0;$i<$lngsay;$i++)
{
?>
  <script>
    var checkcont<?php echo $shortname[$i]; ?> =1;
    CKEDITOR.replace( '<?php echo "txt".$shortname[$i] ?>' );
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
      data: { bco: "contenttagurl", name: x , id: <?php echo s($_GET['val']);  ?> },
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
{
  $source=0;
  if($_FILES['pic']['tmp_name']=='')
  {
    print_r($_FILES);
  }
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
      $lngins=$db->prepare('UPDATE texnika_content set ordering=:ord , description=:sn , name=:nm , title=:ti ,  stitle=:sti , keyword=:keyw , u_id=:uid , l_id=:lng2 , s_id=:sid , `text`=:txt , url_tag=:utg  , picture=:pc where u_id=:uid and l_id=:lng2 ');    
      $lnginscon=$lngins->execute(array('lng2'=>$luid[$i] , 'sn'=>s($_POST['desc'.$shortname[$i]]) , 'nm'=>s($_POST['names'.$shortname[$i]]) , 'ti'=>s($_POST['tit'.$shortname[$i]]) , 'sti'=>s($_POST['stit'.$shortname[$i]]) , 'keyw'=>s($_POST['key'.$shortname[$i]]) , 'txt'=>($_POST['txt'.$shortname[$i]]) , 'utg'=>s($_POST['urltag'.$shortname[$i]]) ,  'uid'=>s($_GET['val']) , 'ord'=>$ord , 'sid'=>d(s($_POST['sids'])) , 'pc'=>$unique.'.'.$type   ));
      echo $unique.'.'.$type;
    }
    else
    {
      $lngins=$db->prepare('UPDATE texnika_content set ordering=:ord , description=:sn , name=:nm , title=:ti , stitle=:sti , keyword=:keyw , u_id=:uid , l_id=:lng2 , s_id=:sid , `text`=:txt , url_tag=:utg where u_id=:uid and l_id=:lng2 ');
      $lnginscon=$lngins->execute(array('lng2'=>$luid[$i] , 'sn'=>s($_POST['desc'.$shortname[$i]]) , 'nm'=>s($_POST['names'.$shortname[$i]]) , 'ti'=>s($_POST['tit'.$shortname[$i]]) , 'sti'=>s($_POST['stit'.$shortname[$i]]) , 'keyw'=>s($_POST['key'.$shortname[$i]]) , 'txt'=>($_POST['txt'.$shortname[$i]]) , 'utg'=>s($_POST['urltag'.$shortname[$i]]) ,  'uid'=>s($_GET['val']) , 'ord'=>$ord , 'sid'=>d(s($_POST['sids']))));
    }
    if (!$lnginscon) 
    {
      $lastcont=0;
    }
  }
  $delete=array_diff($categeriinc,$_POST['cat']);
  $insert=array_diff($_POST['cat'],$categeriinc);
  foreach ($insert as $key) 
  {
    $lnginss=$db->prepare('INSERT INTO texnika_cat_cont set cat_id=:caid, cont_id=:coid');
    $lnginsscon=$lnginss->execute(array('coid'=>s($_GET['val']) , 'caid'=>s($key)));
    if (!$lnginsscon) 
    {
      $lastcont=0;
    }
  }
  foreach ($delete as $key) 
  {
    $lnginsd=$db->prepare('DELETE FROM texnika_cat_cont where cat_id=:caid and cont_id=:coid');
    $lnginsdcon=$lnginsd->execute(array('coid'=>s($_GET['val']) , 'caid'=>s($key)));
    if (!$lnginsdcon) 
    {
     $lastcont=0;
    }
  }
  if ($lastcont==1) 
  {
    if ($source==1) 
    {
      if (is_file('images/'.$machinequerasor['picture'])) 
      {
        unlink('images/'.$machinequerasor['picture']);
      }
    }
    $db->commit();
    header('Location:'.$site_url.'machine_content/list/456852/');
  }
  else
  {
    if (is_file('images/'.$unique.'.'.$type)) 
    {
      unlink('images/'.$unique.'.'.$type);
    }
    $db->rollBack();
    header('Location:'.$site_url.'machine_content/list/456456/');
  } 
}

?>