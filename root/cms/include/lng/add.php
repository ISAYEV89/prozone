<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>ADD LANGUAGE </h2>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">   
        <form method="POST" action="" enctype="multipart/form-data" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">   
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Icon <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input name="icon" class="date-picker form-control col-md-7 col-xs-12" required="required" type="file">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Short name <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input id="shortname" onchange="check();" name="short" type="text" class="js-switch date-picker form-control col-md-7 col-xs-12" checked />
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Orginal name <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input name="org" type="text" class="js-switch date-picker form-control col-md-7 col-xs-12" checked />
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Default <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input name="sids" class="date-picker form-control col-md-7 col-xs-12 js-switch" type="checkbox">
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
<script type="text/javascript">
function  check()
{
  var x = document.getElementById('shortname').value.toLowerCase();
  document.getElementById('shortname').value=x;
  $.ajax({
    method: "POST",
    url: "<?php echo $site_url.'include/islem.php' ?>",
    data: { lng: "shrtnm", name: x },
    success:function(data)
    {
      if (data=='true') 
      {
        document.getElementById("shortname").style.borderColor='#ccc';
        document.getElementById("btnid").type='submit';
      }
      else if (data=='false')
      {
        document.getElementById("shortname").style.borderColor='red';
        document.getElementById("btnid").type='button';
      }
    }
  })
}  
</script>
<?php
if ($_POST['btn']) 
{
  echo '<pre>';
  print_r($_POST);
  echo '</pre>';
  if ($_POST['sids']=='on') 
  {
    $s=1; 
  }
  else
  {
    $s=NULL;
  }
  echo $s;
  $lngquer=$db->prepare('SELECT * , MAX(u_id) as max FROM lng , (SELECT u_id as def from lng where `default` is not null ) g ');
  $lngquer->execute(); 
  $lngquersor=$lngquer->fetch(PDO::FETCH_ASSOC);
  echo $default=$lngquersor['def'];
  $lngquerx=$db->prepare('SELECT * FROM lng ');
  $lngquerx->execute(); 
  $lngstring='';
  $wnum=0;
  while($lngquerxcek=$lngquerx->fetch(PDO::FETCH_ASSOC))
  {
    if ($wnum==0) 
    {
      $lngstring=$lngquerxcek['short_name'];
    }
    else
    {
      $lngstring.='|'.$lngquerxcek['short_name'];
    }
    $wnum++;
  }
  $lngstring.='|'.s($_POST['short']);
  echo '<pre>';print_r($_POST);echo '</pre>';
  echo '<pre>';print_r($_FILES['icon']);echo '</pre>';
  $unique1=rand(100,999);
  $unique2=rand(1000,9999);
  $unique3=rand(10000,99999);
  $unique=$unique1.$unique2.$unique3;
  $type=explode('.', $_FILES['icon']['name']);
  $type=$type[1];
  $uid=$lngquersor['max']+1;
  $db->begintransaction();
  if ($_FILES['icon']['size']<=600000 && in_array($_FILES['icon']['type'], ['jpg','jpeg','png','image/jpeg','image/jpg','image/png']) && $control=move_uploaded_file($_FILES['icon']['tmp_name'], 'images/'.$unique.'.'.$type)) 
  {
    $lngins=$db->prepare('INSERT INTO lng set `default`=:df , short_name=:sn , org_name=:non , icon=:ico , u_id=:uid ');
    $lnginscon=$lngins->execute(array( 'df'=>$s , 'sn'=>s($_POST['short']) , 'non'=>s($_POST['org']) , 'ico'=>$unique.'.'.$type , 'uid'=>$uid));
    if ($s==1) 
    {
      echo 'aa';
      $lngup=$db->prepare('UPDATE lng set `default`=:df where u_id=:udi ');
      $lngupcon=$lngup->execute(array('df'=>NULL , 'udi'=>s($default) ));
      if (!$lngupcon) 
      {
        $lnginscon=0;
      }
    }
    if ($lnginscon) 
    {
      $db->commit();
      $txt='RewriteEngine On
RewriteRule ^('.$lngstring.')/(shop|blog|menu|machine)/([A-z0-9\-\_]+)/(page)/([0-9]+)/ index.php?lng=$1&state=$2&cat=$3&static=$4&page=$5 [NC,L]
RewriteRule ^('.$lngstring.')/(shop|blog|menu|machine)/([A-z0-9\-\_]+)/([A-z0-9\-\_]+)/ index.php?lng=$1&state=$2&cat=$3&cname=$4 [NC,L]
RewriteRule ^('.$lngstring.')/(shop|blog|menu|machine)/([A-z0-9\-\_]+)/ index.php?lng=$1&state=$2&cat=$3 [NC,L]
RewriteRule ^('.$lngstring.')/(shop|blog|menu|machine)/ index.php?lng=$1&state=$2 [NC,L]
RewriteRule ^('.$lngstring.')/ index.php?lng=$1 [NC,L]'; 
      $f = fopen('../.htaccess', 'w+');
      fwrite($f, $txt);
      fclose($f);
      header('Location:'.$site_url.'lng/list/456852/');
      exit();
    }
    else
    {
      $db->rollBack();
      if (is_file('images/'.$unique.'.'.$type)) 
      {
        unlink('images/'.$unique.'.'.$type);
      }
      header('Location:'.$site_url.'lng/list/456456/');
      exit();
    } 
  }
  else
  {
    $db->rollBack();
    header('Location:'.$site_url.'lng/list/456456/');
    exit();
  }
}

?>