<?php 
$shop_itemquera=$db->prepare('SELECT * FROM shop_item where u_id=:uid limit 1 ');
$shop_itemquera->execute(array('uid'=>s($_GET['val'])));
$count=$shop_itemquera->rowCount();
if (!$_GET['val'] or $count!=1) 
{
  header('Location:'.$site_url.'shop_item/list/');
  exit();
}

$lngquera=$db->prepare('SELECT short_name as sn , org_name as orgn , u_id FROM lng ');
$lngquera->execute();
$categeriinc=array();
$shortname=array();
$orgname=array();
$uidarr=array();
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
        <h2>Edit Shop item's content photos </h2><a style="float: right;" class="btn btn-success" href="<?php echo $site_url.'shop_item/add_photo/'.s($_GET['val']).'/' ?>"><i class="fa fa-plus"></i> Əlavə et </a>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">   
        <form method="POST" action="" id="demo-form2" enctype="multipart/form-data" data-parsley-validate class="form-horizontal form-label-left">   
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
                <?php 
                $shop_itemqueras=$db->prepare('SELECT `bi`.`u_id` , `bi`.`id` , `bi`.`item_id` , `bi`.`name` , `bi`.`alt` , `bi`.`ordering` , `bi`.`dir` FROM shop_item bc , shop_img bi where `bc`.`u_id`=:uid and `bc`.`l_id`="1" and `bi`.`item_id`=`bc`.`u_id` and `bi`.`l_id`="'.$luid[$i].'" ');
                $shop_itemqueras->execute(array('uid'=>s($_GET['val'])));
                $counts=$shop_itemqueras->rowCount();
                $num=0;
                while($shop_imgsor=$shop_itemqueras->fetch(PDO::FETCH_ASSOC))
                {
                $num++;
                $dirarr[$shop_imgsor['u_id']]=$shop_imgsor['dir'];
                if (!in_array( $shop_imgsor['u_id'] ,$uidarr )) 
                {
                  array_push($uidarr , $shop_imgsor['u_id']);
                }
                ?>
                  <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">IMAGE <?php echo $num; ?>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <img style="width: 150px;" src="<?php echo $site_url.'images/'.$shop_imgsor['dir'] ?>"  class="col-md-7 col-xs-12"  />
                      <?php
                      if ($i==0) 
                      {
                      ?>
                        <input value="<?php echo $shop_imgsor['u_id'] ?>" id="<?php echo $shop_imgsor['u_id']; ?>" name="del[]"   type="checkbox" />
                        <label style="color:red; width: 50px;" class="fa fa-trash fa-3x" for="<?php echo $shop_imgsor['u_id']; ?>"></label>
                      <?php
                      } 
                      ?>
                    </div>
                  </div>
                  <?php
                  if ($i==0) 
                  {
                  ?>
                    <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12">Ordering  <?php echo $num; ?>
                      </label>
                      <div class="col-lg-1 col-md-1 col-sm-1 col-xs-3">
                        <input value="<?php echo $shop_imgsor['ordering'] ?>" name="ord<?php echo $shop_imgsor['u_id']; ?>" type="number" class=" date-picker form-control col-md-7 col-xs-12" checked />
                      </div>
                    </div>
                  <?php
                  } 
                  ?>
                  <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Name  <?php echo $num; ?>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <input value="<?php echo $shop_imgsor['name'] ?>" name="names<?php echo $shortname[$i].$shop_imgsor['u_id']; ?>" type="text" class=" date-picker form-control col-md-7 col-xs-12" checked />
                    </div>
                  </div>
                  <div class="form-group" style="    border-bottom: 1px dashed #000;">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Alt <?php echo $num; ?>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <input value="<?php echo $shop_imgsor['alt'] ?>" name="alt<?php echo $shortname[$i].$shop_imgsor['u_id']; ?>" type="text" class=" date-picker form-control col-md-7 col-xs-12" checked />
                    </div>
                  </div> 
                <?php
                }
                ?>
            </div>
            <?php
            }
            ?>
          </div>
          <div class="form-group">
            <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-3">
              <input type="submit" name="btn" value="Submit" class="btn btn-success"/>
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
  //print_r($_POST);
  echo $deleteq=count($_POST['del']);
  $updateq=count($uidarr);
  for($i=0;$i<$deleteq;$i++)
  {
    if(is_file('images/'.$dirarr[$_POST['del'][$i]]))
    {
      unlink('images/'.$dirarr[$_POST['del'][$i]]);
    }
    $delete=$db->prepare("DELETE from shop_img where u_id=:uids");
    $delcon=$delete->execute(array('uids'=>s($_POST['del'][$i])));
  }
  $controller=1;
  $db->begintransaction();
  if ($_POST['del']) 
  {
    $src=$_POST['del'];
  }
  else
  {
    $src=array();
  }
  for($i=0;$i<$updateq;$i++)
  {
    if(!in_array($uidarr[$i], $src))
    {
      for($t=0;$t<$lngsay;$t++)
      {
        $update=$db->prepare("UPDATE shop_img set ordering=:ords , alt=:alts , name=:nms  where u_id=:uids and l_id=:lids");
        $updcon=$update->execute(array('ords'=> s($_POST['ord'.$uidarr[$i]]) , 'alts'=> s($_POST['alt'.$shortname[$t].$uidarr[$i]]) , 'nms'=> s($_POST['names'.$shortname[$t].$uidarr[$i]]) , 'uids'=>s($uidarr[$i]) , 'lids'=>s($luid[$t])));
       echo '<br>-ordS'.s($_POST['ord'.$uidarr[$i]]).'-altS'.s($_POST['alt'.$shortname[$t].$uidarr[$i]]).'-nmS'.s($_POST['names'.$shortname[$t].$uidarr[$i]]).'-uidS'.s($uidarr[$i]).'-lidS'.s($luid[$t]);
        if(!$updcon)
        {
          $controller=0;
        }
      }
    }
  }
  if ($controller==1) 
  {
    $db->commit();
    header('Location:'.$site_url.'shop_item/list/456852/');
    exit();
  }
  else
  {
    $db->rollback();
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