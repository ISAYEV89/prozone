
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
      <strong>Process ended with failure !</strong>
    </div>
    <?php
  }  
  ?>
  <div class="x_panel">
    <div class="x_title">
      <h2>Comment LIST </h2>
      <div class="clearfix"></div>
    </div>
    <div class="x_content">
      <table id="datatable" class="table table-striped table-bordered">
        <thead>
          <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Product</th>
            <th>Comment</th>
            <th>Do</th>
          </tr>
        </thead>
        <tbody>
          <?php 
          $blogquer=$db->prepare('SELECT * FROM comment order by date desc ');
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
              <td><?php echo $blogquersor['id']; ?></td>
              <?php 
              $user_commented = $db->prepare('select * from user where id = ?');
              $user_commented->execute([$blogquersor['user_id']]);
              $user=$user_commented->fetch(PDO::FETCH_ASSOC);
              ?>
              <td><?php echo $user['ad'].' '.$user['soyad']  ?></td>
              <?php 
              $product_commented = $db->prepare('select * from mehsul where u_id = ? and l_id = 1');
              $product_commented->execute([$blogquersor['product_id']]);
              $product=$product_commented->fetch(PDO::FETCH_ASSOC);
              ?>
              <td>
                  <?php echo $product['name'] ?>
                  <img style="width: 25px;" src="<?php echo $site_url.'images/'.$product['image_url']; ?>">
              </td>
              <td><?php echo substr($blogquersor['text'],0,30) ?></td>
              <td>
                <form style=" float: right;" method="POST">
                  <input type="hidden" name="delid" value="<?php echo $blogquersor['id'] ?>">
                  <button type="button"  onclick="dsomo(this);" name="dbtn"  style="color: red; background-color: rgba(0,0,0,0); border:none;" href="">
                    <i class="fa fa-trash fa-2x" ></i>
                  </button>
                </form>
                
                <form style=" float: right;" method="POST">
                  <input type="hidden" name="update_id" value="<?php echo $blogquersor['id'] ?>">
                  <button type="submit"  name="abtn"  style="color: green; background-color: rgba(0,0,0,0); border:none;">
                    <i class="fa fa-check-square-o fa-2x" ></i>
                  </button>
                </form>
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

<?php
    
    if(isset($_POST['dbtn'])){
        $delete= $db->prepare('delete from comment where id = ?');
        $delete->execute([$_POST['delid']]);
        header('Location: .');
    }
    
    if(isset($_POST['abtn'])){
        $update = $db->prepare('update comment set s_id = 1 where id = ?');
        $update->execute([$_POST['update_id']]);
        header('Location: .');
    }

?>