<?php 
$lngquera=$db->prepare('SELECT * FROM lng where u_id=:uid ');
$lngquera->execute(array('uid'=>s($_GET['val'])));
$count=$lngquera->rowCount();
$lngquerasor=$lngquera->fetch(PDO::FETCH_ASSOC);
if (!$_GET['val'] or $count!=1) 
{
  header('Location:'.$site_url.'lng/list/');
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
        <form method="POST" action="" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">   
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Short name <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input id="shortname" onchange="check();" value="<?php echo $lngquerasor['short_name'] ?>" name="short" type="text" class=" date-picker form-control col-md-7 col-xs-12" checked />
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Orginal name <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input value="<?php echo $lngquerasor['org_name'] ?>" name="org" type="text" class=" date-picker form-control col-md-7 col-xs-12" checked />
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Default <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input  <?php if(!is_null($lngquerasor["default"])){echo 'checked=""';} ?>  name="sids" class="date-picker form-control col-md-7 col-xs-12 js-switch" type="checkbox">
            </div>
          </div>
          <div class="form-group">
            <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-3">
              <input id="btnid" type="submit" name="btn" value="Submit" class="btn btn-success"/>
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
  $lngquer=$db->prepare('SELECT * , MAX(u_id) as max FROM lng , (SELECT u_id as def from lng where `default` is not null ) g ');
  $lngquer->execute(); 
  $lngquersor=$lngquer->fetch(PDO::FETCH_ASSOC);
  $default=$lngquersor['def'];
  function d($post)
  {
    if ($post=='on') 
    {
      return 1;
    }
    else
    {
      return NULL;
    }
  }
  if ($_POST['sids']=='on') 
  {
    $s=1; 
  }
  else
  {
    $s=NULL;
  }
  $lngquerx=$db->prepare('SELECT * FROM lng where u_id!=:udi');
  $lngquerx->execute(array('udi'=>s($_GET['val']))); 
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
  $db->begintransaction();
  $lngins=$db->prepare('UPDATE lng set `default`=:df ,  short_name=:sn , org_name=:non where u_id=:udi ');
  $lnginscon=$lngins->execute(array( 'df'=>d($_POST['sids']) , 'sn'=>s($_POST['short']) , 'non'=>s($_POST['org']) , 'udi'=>s($_GET['val']) ));
  if ($s==1) 
  {
    echo 'aa';
    if(is_null($lngquerasor["default"]))
    {
      $lngup=$db->prepare('UPDATE lng set `default`=:df where u_id=:udi ');
      $lngupcon=$lngup->execute(array('df'=>NULL , 'udi'=>s($default) ));
      if (!$lngupcon) 
      {
        $lnginscon=0;
      }
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
  }
  else
  {
    $db->rollBack();
    header('Location:'.$site_url.'lng/list/456456/');
  }
}
?>