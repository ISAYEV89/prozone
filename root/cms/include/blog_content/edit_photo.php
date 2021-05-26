<?php 
$blog_contentquera=$db->prepare('SELECT * FROM blog_content where u_id=:uid limit 1 ');
$blog_contentquera->execute(array('uid'=>s($_GET['val'])));
$count=$blog_contentquera->rowCount();
$blog_contentquerasor=$blog_contentquera->fetch(PDO::FETCH_ASSOC);
if (!$_GET['val'] or $count!=1) 
{
  header('Location:'.$site_url.'blog_content/list/');
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
              <img style="width: 200px;" src="<?php echo $site_url.'images/'.$blog_contentquerasor['photo1'] ?>"  class="  col-md-7 col-xs-12" checked />
              
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Old Photo-2<span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <img style="width: 150px;" src="<?php echo $site_url.'images/'.$blog_contentquerasor['photo2'] ?>"  class="  col-md-7 col-xs-12" checked />
              <input type="checkbox" name="photo2_delete"> Delete second photo
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">New Photo-1 <?php echo pxtostr($staticft['blog_content_pic']); ?>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input name="pic" class="date-picker form-control col-md-7 col-xs-12" type="file"/>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">New Photo-2 <?php echo pxtostr($staticft['blog_content_ico']); ?>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input name="ico" type="file" class="date-picker form-control col-md-7 col-xs-12"/>
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
  $sunique1=rand(100,999);
  $sunique2=rand(1000,9999);
  $sunique3=rand(10000,99999);
  $unique=$unique1.$unique2.$unique3;
  $sunique=$sunique1.$sunique2.$sunique3;
  $type=explode('.', $_FILES['pic']['name']);
  $type2=explode('.', $_FILES['ico']['name']);
  $type=$type[1];
  $type2=$type2[1];

  


  $db->begintransaction();
  
  
  if($_POST['photo2_delete']){
    $delete_image = $db->prepare('UPDATE blog_content set photo2=null where u_id= ? ');
    $delete = $delete_image->execute([s($_GET['val'])]);
    if ($delete) 
    {
      if (is_file('images/'.$blog_contentquerasor['photo2'])) 
      {
        if (!unlink('images/'.$blog_contentquerasor['photo2']) ) 
        {
          $controller=0;
        }
      }
    }
  }
  
  if ($_FILES['pic']['size']<=900000 && in_array($_FILES['pic']['type'], ['jpg','jpeg','png','image/jpeg','image/jpg','image/png']) && $control=move_uploaded_file($_FILES['pic']['tmp_name'], 'images/'.$unique.'.'.$type) ) 
  {
      
      
    $blog_contentins=$db->prepare('UPDATE blog_content set photo1=:pc where u_id=:udi ');
    $blog_contentinscon=$blog_contentins->execute(array('pc'=>$unique.'.'.$type , 'udi'=>s($_GET['val']) ));
    if ($blog_contentinscon) 
    {
      if (is_file('images/'.$blog_contentquerasor['photo1'])) 
      {
        if (!unlink('images/'.$blog_contentquerasor['photo1']) ) 
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
      header('Location:'.$site_url.'blog_content/list/456456/');
      exit();
    }
  }

  if ($_FILES['ico']['size']<=600000 && in_array($_FILES['ico']['type'], ['jpg','jpeg','png','image/jpeg','image/jpg','image/png']) && $control=move_uploaded_file($_FILES['ico']['tmp_name'], 'images/'.$sunique.'.'.$type2)) 
  {
    $blog_contentins=$db->prepare('UPDATE blog_content set photo2=:ico where u_id=:udi ');
    $blog_contentinscon=$blog_contentins->execute(array('ico'=>$sunique.'.'.$type2 , 'udi'=>s($_GET['val']) ));
    if ($blog_contentinscon) 
    {
      if (is_file('images/'.$blog_contentquerasor['photo2'])) 
      {
        if (!unlink('images/'.$blog_contentquerasor['photo2']) ) 
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
      header('Location:'.$site_url.'blog_content/list/456456/');
      exit();
    }
  }

  if($controller==1)
  {
    $db->commit();
    header('Location:'.$site_url.'blog_content/list/456852/'); 
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
    header('Location:'.$site_url.'blog_content/list/456456/');
  }
}
?>