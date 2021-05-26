<?php
$sitequer=$db->prepare('SELECT * FROM site_general where l_id="1" ');
$sitequer->execute();
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
      <h2>Site general settings </h2>
      <div class="clearfix"></div>
    </div>
    <div class="x_content">
      <table id="datatable" class="table table-striped table-bordered">
        <thead>
          <tr>
            <th>Name</th>
            <th>Domain</th>
            <th>Mail</th>
            <th>Telephone</th>
            <th>Address</th>
            <th>Title</th>
            <th>Keyword</th>
            <th>Description</th>
            <th>Logo</th>
            <th>Do</th>
          </tr>
        </thead>
        <tbody>
          <?php 
          while ($sitequersor=$sitequer->fetch(PDO::FETCH_ASSOC)) 
          {
          ?>
          <tr>
            <td><?php echo $sitequersor['name']; ?></td>
            <td><?php echo $sitequersor['domain']; ?></td>
            <td><?php echo $sitequersor['mail']; ?></td>
            <td><?php echo $sitequersor['tel']; ?></td>
            <td><?php echo $sitequersor['adress']; ?></td>
            <td><?php echo $sitequersor['title']; ?></td>
            <td><?php echo $sitequersor['keyword']; ?></td>
            <td><?php echo $sitequersor['description']; ?></td>
            <td><img src="<?php echo $site_url.'images/'.$sitequersor['logo']; ?>" style="width: 35px;"  ></td>
            <td>
              <a style="color:green; margin-right: 12px; float: right;" href="<?php echo $site_url.'general_site/edit/'.$sitequersor['id'].'/' ?>">
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