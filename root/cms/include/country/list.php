<?php
if ($_POST['change_order']) 
{
  $db->begintransaction();
  $lngins=$db->prepare('UPDATE olkeler set ordering=:ord  where u_id=:udi ');
  $lnginscon=$lngins->execute(array('ord'=>s($_POST['this']) , 'udi'=>s($_POST['us_ids']) ));
  if ($lnginscon) 
  {
    $db->commit();
    header('Location:'.$site_url.'country/list/456852/');
  }
  else
  {
    $db->rollBack();
    header('Location:'.$site_url.'country/list/456456/');
  }
}
$blogquer=$db->prepare('SELECT * FROM olkeler where l_id="1" and sub_id="0" order by popular desc , ordering asc ');
$blogquer->execute();

//selecting city counts and assigning to an array***************************************
$citysql=$db->prepare('SELECT `sub_id`, COUNT(`id`) as `say` FROM `cities` where l_id=1 group by sub_id ORDER BY `cities`.`sub_id` ASC ');
$citysql->execute(); 
$cityarr=ARRAY();
while ($citysor=$citysql->fetch(PDO::FETCH_ASSOC))
{
	$oid=$citysor['sub_id'];
	$cityarr[$oid]=$citysor['say'];
}

//**************************************************************************************
?>
<div class="col-md-14 col-sm-14 col-xs-14">
  <?php 
  if ($_GET['val']=='456852') 
  {
  ?>
  <br></br>
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
  <br></br>
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
      <h2>Countries LIST </h2><a style="float: right;" class="btn btn-success" href="<?php echo $site_url.'country/add/' ?>"><i class="fa fa-plus"></i> Əlavə et </a>
      <div class="clearfix"></div>
    </div>
    <div class="x_content">
      <table id="datatable" class="table table-striped table-bordered">
        <thead>
          <tr>
            <th>Ordering</th>
            <th>Name</th>
            <th>Currency</th>
<!--             <th>Description</th>
            <th>Title</th>
            <th>Keyword</th> -->
             <th>Popular</th>
            <th>Url tag</th>
			<th>Prefix</th>
            <th>Image</th>
            <th>Do</th>
          </tr>
        </thead>
        <tbody>
          <?php 
          while ($blogquersor=$blogquer->fetch(PDO::FETCH_ASSOC)) 
          {
            $cur = $db->prepare("SELECT * FROM currency WHERE u_id=:cur_id AND l_id=1");
            $cur->execute(['cur_id'=>$blogquersor['currency_id']]);
            $currency = $cur->fetch(PDO::FETCH_ASSOC);
			$olkid=$blogquersor['kat_id'];
          ?>
          <tr>
            <!-- <td><?php /* echo substr($blogquersor['kat_id'], 0,10); */ ?></td> -->
            <td>
              <form action="" method="post" >
                <input style="width:30px; " name="this" type="text" value='<?php echo $blogquersor['ordering']; ?>'>
                <input value="✔" type="submit" name="change_order">
                <input value="<?php echo $blogquersor['kat_id'] ?>" type="hidden" name='us_ids' >
              </form>
            </td>
            <td><?php echo $blogquersor['name'].' ( <a href="'.$site_url.'country/listcity/'.$blogquersor['kat_id'].'/">'.$cityarr[$olkid].'</a> )';?></td>
            <td><?php echo $currency['short_name']; ?></td>
            <td>
                <?php
                if ($blogquersor['popular']==1) echo "<p style='color: blue; font-weight: bold'>Popular</p>";
                ?>
            </td>
            <td><?php echo $blogquersor['url_tag']; ?></td>
            <td><?php echo $blogquersor['prefix']; ?></td>
            <td><img style="width: 35px;" src="<?php echo $site_url.'images/flags/'.$blogquersor['image_url']; ?>"></td>
            <td>
              <form style=" float: right;" method="POST" action="<?php echo $site_url.$state.'delete/' ?>">
                <input type="hidden" name="delid" value="<?php echo $blogquersor['kat_id'] ?>">
                <button type="button"  onclick="dsomo(this);" name="dbtn"  style="color: red; background-color: rgba(0,0,0,0); border:none;" href="">
                  <i class="fa fa-trash fa-2x" ></i>
                </button>
              </form>
<!--               <a style="margin-right: 5px; float: right;" href="<?php echo $site_url.'country/edit_photo/'.$blogquersor['kat_id'].'/' ?>">
                <i class="fa fa-edit fa-2x" ></i> 
              </a> -->
              <a style="color:green; margin-right: 14px; float: right;" href="<?php echo $site_url.'country/edit/'.$blogquersor['kat_id'].'/' ?>">
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