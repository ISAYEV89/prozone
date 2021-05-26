<?php 
$lngquera=$db->prepare('SELECT short_name as sn , org_name as orgn , u_id FROM lng ');
$lngquera->execute();
$catquer=$db->prepare('SELECT u_id , name FROM texnika_cat where l_id="1" ');
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
        <h2>ADD Machine Category </h2>
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
                  <label class="control-label col-md-3 col-sm-3 col-xs-12">Url tag <span class="required">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input id="tagurl<?php echo $shortname[$i]; ?>" onchange="check<?php echo $shortname[$i]; ?>();" name="ut<?php echo $shortname[$i]; ?>" type="text" class="js-switch date-picker form-control col-md-7 col-xs-12" checked />
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12">Name <span class="required">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input name="names<?php echo $shortname[$i]; ?>" type="text" class="js-switch date-picker form-control col-md-7 col-xs-12" checked />
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12">Description <span class="required">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input name="desc<?php echo $shortname[$i]; ?>" type="text" class="js-switch date-picker form-control col-md-7 col-xs-12" checked />
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12">Title <span class="required">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input name="tit<?php echo $shortname[$i]; ?>" type="text" class="js-switch date-picker form-control col-md-7 col-xs-12" checked />
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12"> Short Title <span class="required">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input name="stit<?php echo $shortname[$i]; ?>" type="text" class="js-switch date-picker form-control col-md-7 col-xs-12" checked />
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12">Keyword <span class="required">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input name="key<?php echo $shortname[$i]; ?>" type="text" class="js-switch date-picker form-control col-md-7 col-xs-12" checked />
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12">Text <span class="required">*</span>
                  </label>
                  <div class="col-md-9 col-sm-9 col-xs-12">
                    <textarea name="txt<?php echo $shortname[$i]; ?>" ></textarea>
                  </div>
                </div>
              </div>
            <?php
            }
            ?>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Picture <?php echo pxtostr($staticft['texnika_cat_pic']); ?><span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input name="pic" class="date-picker form-control col-md-7 col-xs-12" required="required" type="file">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Icon <?php echo pxtostr($staticft['texnika_cat_ico']); ?><span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input name="ico" class="date-picker form-control col-md-7 col-xs-12" required="required" type="file">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Category <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <select class="form-control" name='subids'>
                <option value="0" >Main</option>
                <?php
                while($catquerft=$catquer->fetch(PDO::FETCH_ASSOC))
                {
                ?>
                  <option value="<?php echo $catquerft['u_id'] ?>" ><?php echo $catquerft['name'] ?></option>
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
              <input name="sids" checked="" class="date-picker form-control col-md-7 col-xs-12 js-switch" type="checkbox">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Display Home<span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input name="sidsh" checked="" class="date-picker form-control col-md-7 col-xs-12 js-switch" type="checkbox">
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
      data: { cc: "tagurlcc", name: x },
      success:function(data)
      {
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
  echo '<pre>';print_r($_POST);echo '</pre>';
  $lngquer=$db->prepare('SELECT MAX(u_id) as max , MAX(ordering) as maxo FROM texnika_cat ');
  $lngquer->execute(); 
  $lngquersor=$lngquer->fetch(PDO::FETCH_ASSOC);
  $unique1=rand(100,999);
  $unique2=rand(1000,9999);
  $unique3=rand(10000,99999);
  $sunique1=rand(100,999);
  $sunique2=rand(1000,9999);
  $sunique3=rand(10000,99999);
  $unique=$unique1.$unique2.$unique3;
  $sunique=$sunique1.$sunique2.$sunique3;
  $type=explode('.', $_FILES['pic']['name']);
  $type2=explode('.', $_FILES['ico']['name']);
  $type=$type[1];
  $type2=$type2[1];
  $uid=$lngquersor['max']+1;
  $ord=$lngquersor['maxo']+1;
  $control=1;
  if ($_POST['sids']=='on') 
  {
    $s=NULL;
  }
  else
  {
    $s=0;
  }
  if ($_POST['sidsh']=='on') 
  {
    $xsh=NULL;
  }
  else
  {
    $xsh=0;
  }

  $db->begintransaction();


  if ($_FILES['pic']['size']<=900000 && in_array($_FILES['pic']['type'], ['jpg','jpeg','png','image/jpeg','image/jpg','image/png']) && $control=move_uploaded_file($_FILES['pic']['tmp_name'], 'images/'.$unique.'.'.$type)  && $_FILES['ico']['size']<=600000 && in_array($_FILES['ico']['type'], ['jpg','jpeg','png','image/jpeg','image/jpg','image/png']) && $control=move_uploaded_file($_FILES['ico']['tmp_name'], 'images/'.$sunique.'.'.$type2)) 
  {

    for ($i=0; $i <$lngsay ; $i++) 
    {      
      $lngins=$db->prepare('INSERT INTO texnika_cat set l_id=:lng2 , `text`=:txt , ordering=:ord , description=:sn , name=:nm , title=:ti ,  stitle=:sti , keyword=:keyw , picture=:pc , icon=:ico , u_id=:uid , url_tag=:utg , s_id=:sid , home=:sidh , sub_id=:subid ');
      $lnginscon=$lngins->execute(array('lng2'=>$luid[$i] , 'sn'=>s($_POST['desc'.$shortname[$i]]) , 'nm'=>s($_POST['names'.$shortname[$i]]) , 'ti'=>s($_POST['tit'.$shortname[$i]]) ,  'sti'=>s($_POST['stit'.$shortname[$i]]) ,  'keyw'=>s($_POST['key'.$shortname[$i]]) , 'txt'=>sck($_POST['txt'.$shortname[$i]]) , 'utg'=>s($_POST['ut'.$shortname[$i]])  , 'ico'=>$sunique.'.'.$type2 , 'pc'=>$unique.'.'.$type , 'uid'=>$uid , 'ord'=>$ord , 'sid'=>$s , 'sidh'=>$xsh , 'subid'=>s($_POST['subids'])));
      if (!$lnginscon) 
      {
        echo $control=0;
      }
    }
    if ($control==1) 
    {
      $db->commit();
      header('Location:'.$site_url.'machine_cat/list/456852/');
    }
    else
    {
      $db->rollBack();         
      if (is_file('images/'.$unique.'.'.$type)) 
      {
        unlink('images/'.$unique.'.'.$type);
      }    
      if (is_file('images/'.$sunique.'.'.$type2)) 
      {
        unlink('images/'.$sunique.'.'.$type2);
      }
      header('Location:'.$site_url.'machine_cat/list/456456/');
    }
  }
  else
  {
    $db->rollBack();
    header('Location:'.$site_url.'machine_cat/list/456456/');
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