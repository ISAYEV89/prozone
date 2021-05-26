<?php 
$lngquera=$db->prepare('SELECT * FROM lng where u_id=:uid ');
$lngquera->execute(array('uid'=>s($_GET['val'])));
$count=$lngquera->rowCount();
$lngquerasor=$lngquera->fetch(PDO::FETCH_ASSOC);
if (!$_GET['val'] or $count!=1) 
{
  header('Location:'.$site_url.'lng/list/');
  exit();
}
?>
<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>ADD LANGUAGE </h2>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">   
        <form method="POST" action="" id="demo-form2" enctype="multipart/form-data" data-parsley-validate class="form-horizontal form-label-left">   
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Old Icon<span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <img style="width: 150px;" src="<?php echo $site_url.'images/'.$lngquerasor['icon'] ?>"  class="  col-md-7 col-xs-12" checked />
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">New Icon <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input  name="icon" type="file" class=" date-picker form-control col-md-7 col-xs-12" checked />
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
  $db->begintransaction();
  $unique1=rand(100,999);
  $unique2=rand(1000,9999);
  $unique3=rand(10000,99999);
  $unique=$unique1.$unique2.$unique3;
  $type=explode('.', $_FILES['icon']['name']);
  $type=$type[1];

  if ($_FILES['icon']['size']<=600000 && in_array($_FILES['icon']['type'], ['jpg','jpeg','png','image/jpeg','image/jpg','image/png']) && $control=move_uploaded_file($_FILES['icon']['tmp_name'], 'images/'.$unique.'.'.$type)) 
  {
    $lngins=$db->prepare('UPDATE lng set icon=:ico where u_id=:udi ');
    $lnginscon=$lngins->execute(array('ico'=>s($unique.'.'.$type) , 'udi'=>s($_GET['val']) ));
    if ($lnginscon) 
    {
      if (is_file('images/'.$lngquerasor['icon'])) 
      {      
        if (unlink('images/'.$lngquerasor['icon'])) 
        {
          $db->commit();
          header('Location:'.$site_url.'lng/list/456852/');
          exit();
        }
        else
        {
          $db->rollBack();
          if (is_file('images/'.$unique.'.'.$type)) 
          {
            unlink('images/'.$unique.'.'.$type);
            header('Location:'.$site_url.'lng/list/456456/');
            exit();
          }
        }
      }
      else
      {
        $db->commit();
        header('Location:'.$site_url.'lng/list/456852/');
        exit();        
      }
    }
    else
    {
      $db->rollBack();
      if (is_file('images/'.$unique.'.'.$type)) 
      {
        unlink('images/'.$unique.'.'.$type);
        header('Location:'.$site_url.'lng/list/456456/');
        exit();
      }
    }
  }
  else
  {
    header('Location:'.$site_url.'lng/list/456456/');
    exit();
  }
}
?>