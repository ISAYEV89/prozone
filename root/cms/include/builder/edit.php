<?php 
$builderquera=$db->prepare('SELECT * FROM builder where id=:uid ');
$builderquera->execute(array('uid'=>s($_GET['val']))); 
$count=$builderquera->rowCount();
$builderquerasor=$builderquera->fetch(PDO::FETCH_ASSOC);
if (!$_GET['val'] or $count!=1) 
{
  header('Location:'.$site_url.'builder/list/');
}
?>
<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>Edit Builder</h2>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">   
        <form method="POST" action="" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">   
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Type
            </label>
            <div class="col-md-4 col-sm-4 col-xs-12">
              <select id="typ" name="typ" onchange="fetch();" class="form-control" >
                <option <?php if($builderquerasor['type']==1){echo'selected=""';} ?> value="1">Blog</option>
                <option <?php if($builderquerasor['type']==2){echo'selected=""';} ?> value="2">Machine</option>
                <option <?php if($builderquerasor['type']==3){echo'selected=""';} ?> value="3">Shop</option>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Category
            </label>
            <div class="col-md-4 col-sm-4 col-xs-12">
              <select id="cate" name="cate" class="form-control" >
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Function 
            </label>
            <div class="col-md-4 col-sm-4 col-xs-12">
              <select name="funid" class="form-control" >
                <option <?php if($builderquerasor['func_id']==1){echo'selected=""';} ?> value="1">First</option>
                <option <?php if($builderquerasor['func_id']==2){echo'selected=""';} ?> value="2">Last</option>
                <option <?php if($builderquerasor['func_id']==3){echo'selected=""';} ?> value="3">Random</option>
              </select>
            </div>
          </div>          
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Post ID 
            </label>
            <div class="col-md-2 col-sm-2 col-xs-6">
              <input value="<?php echo $builderquerasor['post_id']; ?>" name="poid" type="number" class=" date-picker form-control col-md-7 col-xs-12" />
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
function  fetch()
{
  var x = document.getElementById('typ').value;
  $.ajax({
    method: "POST",
    url: "<?php echo $site_url.'include/islem.php' ?>",
    data: { builder: "fetcha", type: x },
    success:function(data)
    {
      document.getElementById('cate').innerHTML=data;
    }
  })
} 
fetch(); 
</script>
<?php
if ($_POST['btn']) 
{
  function d($post)
  {
    if ($post=='') 
    {
      return NULL;
    }
    else
    {
      return $post;
    }
  }
  $db->begintransaction();
  $builderins=$db->prepare('UPDATE builder set func_id=:fid , post_id=:pid , type=:ty , cat_id=:cid  where id=:udi ');
  $builderinscon=$builderins->execute(array('fid'=>s($_POST['funid']) , 'pid'=>d(s($_POST['poid'])) , 'ty'=>s($_POST['typ']) , 'cid'=>s($_POST['cate']) , 'udi'=>s($_GET['val']) ));
  if ($builderinscon) 
  {
    $db->commit();
    header('Location:'.$site_url.'builder/list/456852/');
  }
  else
  {
    $db->rollBack();
    header('Location:'.$site_url.'builder/list/456456/');
  }
}
?>