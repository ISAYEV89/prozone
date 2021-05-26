<?php
$blogquer=$db->prepare('SELECT * FROM customer ');
$blogquer->execute();
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
      <h2> Customer  LIST </h2>
      <div class="clearfix"></div>
    </div>
    <div class="x_content">
      <table id="datatable" class="table table-striped table-bordered">
        <thead>
          <tr>
            <th>Date</th>
            <th>Produce name</th>
            <th>Tel-1</th>
            <th>Tel-2</th>
            <th>Pay-method</th>
            <th>Full-name</th>
            <th>Produc-price</th>
            <th>Email</th>
            <th>Do</th>
          </tr>
        </thead>
        <tbody>
          <?php 
          while ($blogquersor=$blogquer->fetch(PDO::FETCH_ASSOC)) 
          {
          ?>
          <tr>
            <td><?php echo substr($blogquersor['date'], 0,16); ?></td>
            <td><?php $tso=$db->prepare('SELECT * FROM shop_item where u_id=? and l_id="1"  ');
                      $tso->execute([$blogquersor['product_id']]);
                      $tsof=$tso->fetch(PDO::FETCH_ASSOC);
                      echo $tsof['name'].$blogquersor['product_id']; ?></td>
            <td><?php echo $blogquersor['tel1']; ?></td>
            <td><?php echo $blogquersor['tel2']; ?></td>
            <td><?php switch ($blogquersor['pay_method']) 
                      {
                        case 1:
                        echo 'Visa';
                        break;
                        case 2:
                        echo 'PayPal';
                        break;
                        case 3:
                        echo 'Görüşdə';
                        break;

                        default:
                        echo 'UNKNOWN';
                        break;
                      } ?></td>
            <td><?php echo $blogquersor['full_name']; ?></td>
            <td><?php echo $blogquersor['price']; ?></td>
            <td><?php echo $blogquersor['mail']; ?></td>
            <td>
              <form style=" float: right;" method="POST" action="<?php echo $site_url.$state.'delete/' ?>">
                <input type="hidden" name="delid" value="<?php echo $blogquersor['id'] ?>">
                <button type="button"  onclick="dsomo(this);" name="dbtn"  style="color: red; background-color: rgba(0,0,0,0); border:none;" href="">
                  <i class="fa fa-trash fa-2x" ></i>
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