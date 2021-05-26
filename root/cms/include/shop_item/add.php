<?php 
$lngquera=$db->prepare('SELECT short_name as sn , org_name as orgn , u_id FROM lng ');
$lngquera->execute();
$shortname=array();
$orgname=array();
$luid=array();
$catquer=$db->prepare('SELECT u_id , name FROM shop_cat where l_id="1" ');
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
        <h2>ADD SHOP ITEM </h2>
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
                    <input id="tagurl<?php echo $shortname[$i]; ?>" onchange="check<?php echo $shortname[$i]; ?>();" name="urltag<?php echo $shortname[$i]; ?>" type="text" class="js-switch date-picker form-control col-md-7 col-xs-12"  />
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12">Name <span class="required">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input name="names<?php echo $shortname[$i]; ?>" type="text" class="js-switch date-picker form-control col-md-7 col-xs-12"  />
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12">Description <span class="required">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input name="desc<?php echo $shortname[$i]; ?>" type="text" class="js-switch date-picker form-control col-md-7 col-xs-12"  />
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12">Title <span class="required">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input name="tit<?php echo $shortname[$i]; ?>" type="text" class="js-switch date-picker form-control col-md-7 col-xs-12"  />
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12"> Short Title <span class="required">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input name="stit<?php echo $shortname[$i]; ?>" type="text" class="js-switch date-picker form-control col-md-7 col-xs-12"  />
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12">Keyword <span class="required">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input name="key<?php echo $shortname[$i]; ?>" type="text" class="js-switch date-picker form-control col-md-7 col-xs-12"  />
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
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Price <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input name="pri" type="number" class="js-switch date-picker form-control col-md-7 col-xs-12"  />
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Cover Picture <?php echo pxtostr($staticft['shop_item_pic']); ?><span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input name="pic" class="date-picker form-control col-md-7 col-xs-12" required="required" type="file">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Content Picture <?php echo pxtostr($staticft['shop_item_img']); ?><span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input name="pics[]" multiple="" class="date-picker form-control col-md-7 col-xs-12" required="required" type="file">
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
      data: { sco: "scotagurl", name: x },
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
  $lngquer=$db->prepare('SELECT MAX(u_id) as max , MAX(ordering) as maxo FROM shop_item ');
  $lngquer->execute(); 
  $lngquersor=$lngquer->fetch(PDO::FETCH_ASSOC);
  echo '<pre>';print_r($_POST);echo '</pre>';
  echo '<pre>';print_r($_FILES['pic']);echo '</pre>';
  echo '<pre>';print_r($_FILES['pics']);echo '</pre>';
  $unique1=rand(100,999);
  $unique2=rand(1000,9999);
  $unique3=rand(10000,99999);
  $unique=$unique1.$unique2.$unique3;
  $type=explode('.', $_FILES['pic']['name']);
  $type=end($type);
  $uid=$lngquersor['max']+1;
  $ord=$lngquersor['maxo']+1;
  $catsay=count($_POST['cat']);
  if ($_POST['sids']=='on') 
  {
    $s=NULL;
  }
  else
  {
    $s=0;
  }
  $db->begintransaction();

  if ($_FILES['pic']['size']<=600000 && in_array($_FILES['pic']['type'], ['jpg','jpeg','png','image/jpeg','image/jpg','image/png']) && $control=move_uploaded_file($_FILES['pic']['tmp_name'], 'images/'.$unique.'.'.$type)) 
  {
    $lastcont=1;
    for ($i=0; $i <$lngsay ; $i++) 
    {
      $lngins=$db->prepare('INSERT INTO shop_item set ordering=:ord , price=:pric , description=:sn , name=:nm , title=:ti , stitle=:sti , keyword=:keyw , picture=:pc , u_id=:uid , l_id=:lng2 , s_id=:sid , `text`=:txt , url_tag=:utg');
      $lnginscon=$lngins->execute(array('lng2'=>$luid[$i] , 'pric'=>s($_POST['pri']) , 'sn'=>s($_POST['desc'.$shortname[$i]]) , 'nm'=>s($_POST['names'.$shortname[$i]]) , 'ti'=>s($_POST['tit'.$shortname[$i]]) , 'sti'=>s($_POST['stit'.$shortname[$i]]) , 'keyw'=>s($_POST['key'.$shortname[$i]]) , 'txt'=>sck($_POST['txt'.$shortname[$i]]) , 'utg'=>s($_POST['urltag'.$shortname[$i]]) , 'pc'=>$unique.'.'.$type , 'uid'=>$uid , 'ord'=>$ord , 'sid'=>NULL ));
      if (!$lnginscon) 
      {
        echo '____________'.$lastcont=0;
      }
    }
    for ($i=0; $i <$catsay ; $i++) 
    { 
      $lnginsa=$db->prepare('INSERT INTO shop_cat_item set cat_id=:caid, item_id=:coid ');
      $lnginsacon=$lnginsa->execute(array('coid'=>$uid , 'caid'=>s($_POST['cat'][$i])));
      if (!$lnginsacon) 
      {
        $lastcont=0;
      }
    }
    echo $picsay=count($_FILES['pics']['name']);
    for ($t=0; $t <$picsay ; $t++) 
    { 
      $lngqueras=$db->prepare('SELECT MAX(u_id) as max FROM shop_img ');
      $lngqueras->execute(); 
      $lngquerasor=$lngqueras->fetch(PDO::FETCH_ASSOC);
      $tuid=$lngquerasor['max']+1;
      $tunique1=rand(100,999);
      $tunique2=rand(1000,9999);
      $tunique3=rand(10000,99999);
      $tunique=$tunique1.$tunique2.$tunique3;
      $ttype=explode('.', $_FILES['pics']['name'][$t]);
      $ttypes=end($ttype);
      if($control=move_uploaded_file($_FILES['pics']['tmp_name'][$t], 'images/'.$tunique.'.'.$ttypes))
      { echo "str";
        for ($i=0; $i <$lngsay ; $i++) 
        { 
          echo '-'.$t.'/'.$luid[$i];
          if ($_FILES['pics']['size'][$t]<=600000 && in_array($_FILES['pics']['type'][$t], ['jpg','jpeg','png','image/jpeg','image/jpg','image/png'])) 
          { echo "string";
            $lnginsa2=$db->prepare('INSERT INTO shop_img set dir=:dire , ordering=:ord , item_id=:itemid , l_id=:lid , u_id=:uid ');
            $lnginsa2con=$lnginsa2->execute(array( 'dire'=>$tunique.'.'.$ttypes , 'ord'=>$t , 'uid'=>$tuid , 'lid'=>$luid[$i] , 'itemid'=>$uid));
            if (!$lnginsa2con) 
            {
              echo '_________'.$lastcont=0;
            }
          }
        }
      }
    }
    if ($lastcont==1) 
    {
      $db->commit(); echo "string";
      header('Location:'.$site_url.'shop_item/list/456852/');
      exit();
    }
    else
    {
      echo 'burda1';
      $db->rollBack();
      if (is_file('images/'.$unique.'.'.$type)) 
      {
        unlink('images/'.$unique.'.'.$type);
      }
      header('Location:'.$site_url.'shop_item/list/456456/');
      exit();
    }  
  }
  else
  {
    echo 'burda2';
    $db->rollBack();
    header('Location:'.$site_url.'shop_item/list/456456/');
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