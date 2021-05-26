<?php 
$sliderquera=$db->prepare('SELECT * FROM slider where u_id=:uid limit 1 ');
$sliderquera->execute(array('uid'=>s($_GET['val'])));
$count=$sliderquera->rowCount();
$sliderquerasor=$sliderquera->fetch(PDO::FETCH_ASSOC);
if (!$_GET['val'] or $count!=1) 
{
  header('Location:'.$site_url.'slider/list/');
}
?>
<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">Photo-2
      <div class="x_title">
        <h2>Edit machine category's photos</h2>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">   
        <form method="POST" action="" id="demo-form2" enctype="multipart/form-data" data-parsley-validate class="form-horizontal form-label-left">   
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Old Photo-1<span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <img style="width: 200px;" src="<?php echo $site_url.'images/'.$sliderquerasor['photo2'] ?>"  class="  col-md-7 col-xs-12" checked />
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">New Photo-1 <?php echo pxtostr($staticft['slider_pic']); ?>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input name="pic" class="date-picker form-control col-md-7 col-xs-12" type="file"/>
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
  $unique1=rand(100,999);
  $unique2=rand(1000,9999);
  $unique3=rand(10000,99999);
  $unique=$unique1.$unique2.$unique3;
  $type=explode('.', $_FILES['pic']['name']);
  $type=$type[1];

  $db->begintransaction();
  if ($_FILES['pic']['size']<=900000 && in_array($_FILES['pic']['type'], ['jpg','jpeg','png','image/jpeg','image/jpg','image/png']) && $control=move_uploaded_file($_FILES['pic']['tmp_name'], 'images/'.$unique.'.'.$type) ) 
  {
    $sliderins=$db->prepare('UPDATE slider set photo2=:pc where u_id=:udi ');
    $sliderinscon=$sliderins->execute(array('pc'=>$unique.'.'.$type , 'udi'=>s($_GET['val']) ));
    if ($sliderinscon) 
    {
      if (is_file('images/'.$sliderquerasor['photo2'])) 
      {
        if (!unlink('images/'.$sliderquerasor['photo2']) ) 
        {
          $controller=0;
        }
      }
    }
    else
    {
      $controller=0;      
      if (is_file('images/'.$unique.'.'.$type)) 
      {
        unlink('images/'.$unique.'.'.$type);
      }
      if (is_file('images/'.$sunique.'.'.$type2)) 
      {
        unlink('images/'.$sunique.'.'.$type2);
      }
      header('Location:'.$site_url.'slider/list/456456/');
      exit();
    }
  }


  if($controller==1)
  {
    $db->commit();
    header('Location:'.$site_url.'slider/list/456852/'); 
  }
  else
  {      
    if (is_file('images/'.$unique.'.'.$type)) 
    {
      unlink('images/'.$unique.'.'.$type);
    }
    if (is_file('images/'.$sunique.'.'.$type2)) 
    {
      unlink('images/'.$sunique.'.'.$type2);
    }
    header('Location:'.$site_url.'slider/list/456456/');
  }
}
?>