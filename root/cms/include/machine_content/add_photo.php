<?php
$lngqueras=$db->prepare('SELECT MAX(u_id) as max FROM texnika_img ');
$lngqueras->execute(); 
$texnika_contqsors=$lngqueras->fetch(PDO::FETCH_ASSOC); 
$texnika_contentquera=$db->prepare('SELECT * FROM texnika_content where u_id=:uid limit 1 ');
$texnika_contentquera->execute(array('uid'=>s($_GET['val'])));
$texnika_contqsor=$texnika_contentquera->fetch(PDO::FETCH_ASSOC);
$texnika_contentquera3=$db->prepare('SELECT MAX(ordering) as maxa  FROM texnika_img where t_id=:uid  ');
$texnika_contentquera3->execute(array('uid'=>s($_GET['val'])));
$texnika_contqsor3=$texnika_contentquera3->fetch(PDO::FETCH_ASSOC);
$count=$texnika_contentquera->rowCount();
if (!$_GET['val'] or $count!=1) 
{
  header('Location:'.$site_url.'machine_content/list/');
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
        <h2>ADD machine content's photos </h2><a style="float: right;" class="btn btn-success" href="<?php echo $site_url.'machine_content/add_photo/' ?>"><i class="fa fa-plus"></i> Əlavə et </a>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">   
        <form method="POST" action="" id="demo-form2" enctype="multipart/form-data" data-parsley-validate class="form-horizontal form-label-left">
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Content Picture <?php echo pxtostr($staticft['texnika_cont_img']); ?><span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input name="pics[]" multiple="" class="date-picker form-control col-md-7 col-xs-12" required="required" type="file">
            </div>
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
  // unlink('images/'.$dirarr[$_POST['del'][$i]];
  $lastcont=1;
  $db->begintransaction();
  $dir=array();
  $picsay=count($_FILES['pics']['name']);
  for ($t=0; $t <$picsay ; $t++) 
  { 
    $xord=$texnika_contqsor3['maxa']+1+$t;
    $tuid=$texnika_contqsors['max']+1+$t;
    $tunique1=rand(100,999);
    $tunique2=rand(1000,9999);
    $tunique3=rand(10000,99999);
    $tunique=$tunique1.$tunique2.$tunique3;
    $ttype=explode('.', $_FILES['pics']['name'][$t]);
    echo $ttypes=end($ttype);
    if($control=move_uploaded_file($_FILES['pics']['tmp_name'][$t], 'images/'.$tunique.'.'.$ttypes))
    { echo "str";
      for ($i=0; $i <$lngsay ; $i++) 
      { 
        echo '-'.$t.'/'.$luid[$i];
        if ($_FILES['pics']['size'][$t]<=600000 && in_array($_FILES['pics']['type'][$t], ['jpg','jpeg','png','image/jpeg','image/jpg','image/png'])) 
        { echo "string";

          $lnginsa2=$db->prepare('INSERT INTO texnika_img set dir=:dire , ordering=:ord , t_id=:tid , l_id=:lid , u_id=:uid ');
          $lnginsa2con=$lnginsa2->execute(array( 'dire'=>$tunique.'.'.$ttypes , 'ord'=>$xord , 'uid'=>$tuid , 'lid'=>$luid[$i] , 'tid'=>s($_GET['val'])));
          if (!in_array( $tunique.'.'.$ttypes ,$dir )) 
          {
            array_push($dir, $tunique.'.'.$ttypes);
          }
          if (!$lnginsa2con) 
          {
            $lastcont=0;
          }
        }
      }
    }
  }
  if ($lastcont==1) 
  {
    $db->commit(); echo "string";
    header('Location:'.$site_url.'machine_content/list/456852/');
  }
  else
  {
    $arrsay=count($dir);
    $db->rollBack();
    for ($i=0; $i <$arrsay; $i++) 
    { 
      if(is_file('images/'.$dir[$i]))
      {
        unlink('images/'.$dir[$i]);
      }
    }
    header('Location:'.$site_url.'machine_content/list/456456/');
  }  
}
?>