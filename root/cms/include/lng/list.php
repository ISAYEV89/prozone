<?php
$lngquer=$db->prepare('SELECT * FROM lng order by ordering asc ');
$lngquer->execute();
if ($_POST['change_order']) 
{
  $db->begintransaction();
  $lngins=$db->prepare('UPDATE lng set ordering=:ord  where u_id=:udi ');
  $lnginscon=$lngins->execute(array('ord'=>s($_POST['this']) , 'udi'=>s($_POST['us_ids']) ));
  if ($lnginscon) 
  {
    $db->commit();
    header('Location:'.$site_url.'lng/list/456852/');
  }
  else
  {
    $db->rollBack();
    header('Location:'.$site_url.'lng/list/456456/');
  }
}
?>
<div class="col-md-12 col-sm-12 col-xs-12">
  <?php 
  if ($_GET['val']=='456852') 
  {
  ?>
  <div style="margin-top:10px; " class="alert alert-success alert-dismissible fade in" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
    </button>
    <strong>Process ended with success !</strong>
  </div>
  <?php
  }
  elseif ($_GET['val']=='456456') 
  {
  ?>
  <div style="margin-top:10px; " class="alert alert-danger alert-dismissible fade in" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
    </button>
    <strong>Process ended with not success !</strong>
  </div>
  <?php
  }  
  ?>
  <div class="x_panel">
    <div class="x_title">
      <h2>LANGUAGE LIST </h2><a style="float: right;" class="btn btn-success" href="<?php echo $site_url.'lng/add/' ?>"><i class="fa fa-plus"></i> Əlavə et </a>
      <div class="clearfix"></div>
    </div>
    <div class="x_content">
      <table id="datatable" class="table table-striped table-bordered">
        <thead>
          <tr>
            <th>Ordering</th>
            <th>Short Name</th>
            <th>Orginal Name</th>
            <th>icon</th>
            <th>Do</th>
          </tr>
        </thead>
        <tbody>
          <?php 
          while ($lngquersor=$lngquer->fetch(PDO::FETCH_ASSOC)) 
          {
          ?>
          <tr>
            <td>
              <form action="" method="post" >
                <input style="width:30px; " name="this" type="text" value='<?php echo $lngquersor['ordering']; ?>'>
                <input value="✔" type="submit" name="change_order">
                <input value="<?php echo $lngquersor['u_id'] ?>" type="hidden" name='us_ids' >
              </form>
            </td>
            <td><?php echo $lngquersor['short_name']; ?></td>
            <td><?php echo $lngquersor['org_name']; ?></td>
            <td><img style="width: 35px;" src="<?php echo $site_url.'images/'.$lngquersor['icon']; ?>"></td>
            <td>
              <form style=" float: right;" method="POST" action="<?php echo $site_url.$state.'delete/' ?>">
                <input type="hidden" name="delid" value="<?php echo $lngquersor['u_id'] ?>">
                <button type="button"  onclick="dsomo(this);" name="dbtn"  style="color: red; background-color: rgba(0,0,0,0); border:none;" href="">
                  <i class="fa fa-trash fa-2x" ></i>
                </button>
              </form>
              <a style="margin-right: 5px; float: right;" href="<?php echo $site_url.'lng/edit_photo/'.$lngquersor['u_id'].'/' ?>">
                <i class="fa fa-edit fa-2x" ></i> 
              </a>
              <a style="color:green; margin-right: 12px; float: right;" href="<?php echo $site_url.'lng/edit/'.$lngquersor['u_id'].'/' ?>">
                <i class="fa fa-pencil fa-2x" ></i> 
              </a>
            </td>
          </tr>
          <?php 
          }
          ?>
        </tbody>
      </table>
    </div>
  </div>
</div>