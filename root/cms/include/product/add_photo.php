<?php 
$lngqueras=$db->prepare('SELECT MAX(u_id) as max FROM mehsul_photo ');
$lngqueras->execute(); 
$blog_contqsors=$lngqueras->fetch(PDO::FETCH_ASSOC);
$our_projectsquera=$db->prepare('SELECT * FROM mehsul where u_id=:uid limit 1 ');
$our_projectsquera->execute(array('uid'=>s($_GET['val'])));
$blog_contqsor=$our_projectsquera->fetch(PDO::FETCH_ASSOC);
$count=$our_projectsquera->rowCount();
if (!$_GET['val'] or $count!=1) 
{
  header('Location:'.$site_url.'product/list/');
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
        <h2>ADD Product photo </h2><a style="float: right;" class="btn btn-success" href="<?php echo $site_url.'our_projects/add_photo/' ?>"><i class="fa fa-plus"></i> Əlavə et </a>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">   
        <form method="POST" action="" id="demo-form2" enctype="multipart/form-data" data-parsley-validate class="form-horizontal form-label-left">
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Content Picture <?php echo pxtostr($staticft['blog_cont_img']); ?><span class="required">*</span>
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
    $tuid=$blog_contqsors['max']+1+$t;
    $tunique1=rand(100,999);
    $tunique2=rand(1000,9999);
    $tunique3=rand(10000,99999);
    $tunique=$tunique1.$tunique2.$tunique3;
    $ttype=explode('.', $_FILES['pics']['name'][$t]);
    echo $ttypes=end($ttype);
    if($pccontrol=move_uploaded_file($_FILES['pics']['tmp_name'][$t], 'images/'.$tunique.'.'.$ttypes) && $_FILES['pics']['size'][$t]<=600000 && in_array($_FILES['pics']['type'][$t], ['jpg','jpeg','png','image/jpeg','image/jpg','image/png']))
    {     
      array_push($dir, $tunique.'.'.$ttypes);
      for ($i=0; $i <$lngsay ; $i++) 
      { 
        $lnginsa2=$db->prepare('INSERT INTO mehsul_photo set photo_url=:dire , ordering=:ord , m_u_id=:bid , l_id=:lid , u_id=:uid ');
        $lnginsa2con=$lnginsa2->execute(array( 'dire'=>$tunique.'.'.$ttypes , 'ord'=>$t , 'uid'=>$tuid , 'lid'=>$luid[$i] , 'bid'=>s($_GET['val'])));
        if (!$lnginsa2con) 
        {
          $lastcont=0;
        }
      }
    }
  }
  if ($lastcont==1) 
  {
    $db->commit(); echo "string";
    header('Location:'.$site_url.'product/list/456852/');
    exit();
  }
  else
  {
    $arrsay=count($dir);
    $db->rollBack();
    for ($i=0; $i <$arrsay; $i++) 
    { 
      if (is_file('images/'.$dir[$i])) 
      {
        unlink('images/'.$dir[$i]);
      }
    }
    header('Location:'.$site_url.'product/list/456456/');
    exit();
  }  
}
?>