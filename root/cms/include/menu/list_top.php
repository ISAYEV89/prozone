<?php
if ($_POST['change_order']) 
{
  $db->begintransaction();
  $lngins=$db->prepare('UPDATE menu set ordering=:ord  where u_id=:udi ');
  $lnginscon=$lngins->execute(array('ord'=>s($_POST['this']) , 'udi'=>s($_POST['us_ids']) ));
  if ($lnginscon) 
  {
    $db->commit();
    header('Location:'.$site_url.'menu/list_top/456852/');
  }
  else
  {
    $db->rollBack();
    header('Location:'.$site_url.'menu/list_top/456456/');
  }
}
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
      <h2>MENU TOP LIST </h2><a style="float: right;" class="btn btn-success" href="<?php echo $site_url.'menu/add/' ?>"><i class="fa fa-plus"></i> Əlavə et </a>
      <div class="clearfix"></div>
    </div>
    <div class="x_content">
      <table id="datatable" class="table table-striped table-bordered">
        <thead>
          <tr>
            <th>Ordering</th>
            <th>ID</th>
            <th>Name</th>
            <th>Description</th>
            <th>Title</th>
            <th>Keyword</th>
            <th>Url tag</th>
            <th>Link</th>
            <th>Do</th>
          </tr>
        </thead>
        <tbody>
          <?php 
            function to_list ($fsubid,$db,$site_url,$deep,$state)
            {
              $blogquer=$db->prepare('SELECT * FROM menu where l_id="1" and sub_id="'.$fsubid.'" and type="1" order by ordering asc ');
              $blogquer->execute();
              for($i=0;$i<$deep;$i++)
              {
                $deeps.='&nbsp;-&nbsp;';
              }
              $deep++;
              while ($blogquersor=$blogquer->fetch(PDO::FETCH_ASSOC)) 
              {
              ?>
                <tr>             
                  <td>
                    <form action="" method="post" >
                      <input style="width:30px; " name="this" type="text" value='<?php echo $blogquersor['ordering']; ?>'>
                      <input value="✔" type="submit" name="change_order">
                      <input value="<?php echo $blogquersor['u_id'] ?>" type="hidden" name='us_ids' >
                    </form>
                  </td>
                  <td><?php echo substr($blogquersor['u_id'], 0,10); ?></td>   
                  <td style=" <?php 
                                if (is_null($blogquersor['s_id']))
                                {
                                  echo 'color: rgba(0,0,0,1); font-weight:bold;';
                                }
                                elseif($blogquersor['s_id']==0)
                                {
                                  echo 'color: rgba(0,0,0,0.4)';
                                }
                              ?>">
                      <?php echo $deeps.substr($blogquersor['name'], 0,50); ?></td>
                  <td><?php echo substr($blogquersor['description'], 0,10); ?></td>
                  <td><?php echo substr($blogquersor['title'], 0,10); ?></td>
                  <td><?php echo substr($blogquersor['keyword'], 0,10); ?></td>
                  <td><?php echo substr($blogquersor['url_tag'], 0,10); ?></td>
                  <td><?php echo substr($blogquersor['link'], 0,15); ?></td>
                  <td>
                    <form style=" float: right;" method="POST" action="<?php echo $site_url.$state.'delete/' ?>">
                      <input type="hidden" name="delid" value="<?php echo $blogquersor['u_id'] ?>">
                      <button type="button"  onclick="dsomo(this);" name="dbtn"  style="color: red; background-color: rgba(0,0,0,0); border:none;" href="">
                        <i class="fa fa-trash fa-2x" ></i>
                      </button>
                    </form>
                    <a style="color:green; margin-right: 14px; float: right;" href="<?php echo $site_url.'menu/edit/'.$blogquersor['u_id'].'/' ?>">
                      <i class="fa fa-pencil fa-2x" ></i> 
                    </a>
                  </td>
                </tr>
                <?php 
                $blog2quer=$db->prepare('SELECT * FROM menu where l_id="1" and sub_id="'.$blogquersor['u_id'].'" ');
                $blog2quer->execute();
                $blogquer2sor=$blog2quer->rowCount();
                if ($blogquer2sor) 
                {
                  to_list($blogquersor['u_id'],$db,$site_url,$deep,$state);  
                }
              }
            }
            to_list(0,$db,$site_url,'',$state);  
          ?>
        </tbody>
      </table>
    </div>
  </div>
</div> 