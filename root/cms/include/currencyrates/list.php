<?php

if ($_POST['upid']) 

{

  $db->begintransaction();

  $lngins=$db->prepare('UPDATE currency_rates set value=:ord  where id=:udi ');

  $lnginscon=$lngins->execute(array('ord'=>s($_POST['upval']) , 'udi'=>s($_POST['upid']) ));

  if ($lnginscon) 

  {

    $db->commit();

    header('Location:'.$site_url.'currencyrates/list/456852/');

  }

  else

  {

    $db->rollBack();

    header('Location:'.$site_url.'currencyrates/list/456456/');

  }

}

$blogquer=$db->prepare('SELECT * FROM currency_rates order by id asc');

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

      <h2>Currency rates</h2>

      <div class="clearfix"></div>

    </div>

    <div class="x_content">

      <table id="datatable" class="table table-striped table-bordered">

        <thead>

          <tr>

            <th>ID</th>

            <th>Name</th>

            <th>Nominal</th>

            <th>Value</th>

            <th>Do</th>

          </tr>

        </thead>

        <tbody>

          <?php 

          while ($blogquersor=$blogquer->fetch(PDO::FETCH_ASSOC)) 

          {

          ?>

          <tr>

            <td><?php echo $blogquersor['id']; ?></td>

            <td>
                <?php echo $blogquersor['NAME']; ?>
            </td>

            <td><?php echo $blogquersor['Nominal']; ?></td>

            <td>
				<form style=" float: right;" method="POST" action="">
				<input type="text" name="upval" value="<?php echo $blogquersor['value'] ?>">
			</td>

            <td>

              

                <input type="hidden" name="upid" value="<?php echo $blogquersor['id'] ?>">

                <button type="Submit" onclick="" name="dbtn" style="color: red; background-color: rgba(0,0,0,0); border:none;" href="">

                  <i class="fa fa-refresh fa-2x" ></i>

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