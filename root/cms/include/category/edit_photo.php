<?php 
$xamsquera=$db->prepare('SELECT * FROM kateqoriyalar where kat_id=:uid limit 1 ');
$xamsquera->execute(array('uid'=>s($_GET['val'])));
$count=$xamsquera->rowCount();
$xamsquerasor=$xamsquera->fetch(PDO::FETCH_ASSOC);
if (!$_GET['val'] or $count!=1) 
{
  header('Location:'.$site_url.'category/list/');
}
?>
<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>EDIT Category's PHOTOS</h2>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">   
        <form method="POST" action="" id="demo-form2" enctype="multipart/form-data" data-parsley-validate class="form-horizontal form-label-left">   
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Old Icon<span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <img style="width: 150px;" src="<?php echo $site_url.'images/'.$xamsquerasor['picture'] ?>"  class="  col-md-7 col-xs-12" checked />
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">New Icon <?php echo pxtostr($staticft['xams_ico']); ?>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input name="ico" type="file" class="date-picker form-control col-md-7 col-xs-12" />
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
  $controller=1;
  $sunique1=rand(100,999);
  $sunique2=rand(1000,9999);
  $sunique3=rand(10000,99999);
  $sunique=$sunique1.$sunique2.$sunique3;
  $type2=explode('.', $_FILES['ico']['name']);
  $type2=$type2[1];
  $db->begintransaction();

  
  if ($_FILES['ico']['size']<=600000 && in_array($_FILES['ico']['type'], ['svg','image/svg','image/svg+xml','jpg','jpeg','png','image/jpeg','image/jpg','image/png']) && $control=move_uploaded_file($_FILES['ico']['tmp_name'], 'images/'.$sunique.'.'.$type2)) 
  {
    $xamsins=$db->prepare('UPDATE kateqoriyalar set picture=:ico where kat_id=:udi ');
    $xamsinscon=$xamsins->execute(array('ico'=>$sunique.'.'.$type2 , 'udi'=>s($_GET['val']) ));
    if ($xamsinscon) 
    {
      if (is_file('images/'.$xamsquerasor['picture'])) 
      {
        if (!unlink('images/'.$xamsquerasor['picture'])) 
        {
          $controller=0;
        }
      }
    }
    else
    {
      $controller=0;     
      if (is_file('images/'.$sunique.'.'.$type2)) 
      {
        unlink('images/'.$sunique.'.'.$type2);
      }
      header('Location:'.$site_url.'category/list/456456/');
      exit();
    }
  }
  if($controller==1)
  {
    $db->commit();
    header('Location:'.$site_url.'category/list/456852/'); 
    exit();
  }
  else
  {      
    if (is_file('images/'.$sunique.'.'.$type2)) 
    {
      unlink('images/'.$sunique.'.'.$type2);
    }
    header('Location:'.$site_url.'category/list/456456/');
    exit();
  }
}
?>