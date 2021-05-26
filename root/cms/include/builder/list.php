<?php
$builderquer=$db->prepare('SELECT * FROM builder ');
$builderquer->execute();
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
      <h2>Builder LIST </h2><a style="float: right;" class="btn btn-success" href="<?php echo $site_url.'builder/add/' ?>"><i class="fa fa-plus"></i> Əlavə et </a>
      <div class="clearfix"></div>
    </div>
    <div class="x_content">
      <table id="datatable" class="table table-striped table-bordered">
        <thead>
          <tr>
            <th>ID</th>
            <th>Type</th>
            <th>Category Name</th>
            <th>Function</th>
            <th>Post</th>
            <th>Do</th>
          </tr>
        </thead>
        <tbody>
          <?php 
          while ($builderquersor=$builderquer->fetch(PDO::FETCH_ASSOC)) 
          {
          ?>
          <tr>
            <td><?php echo $builderquersor['id']; ?></td>
            <td><?php switch ($builderquersor['type']) 
                      {
                        case '1':
                        echo 'Blog';
                        break;
                        case '2':
                        echo 'Machine';
                        break;
                        case '3':
                        echo 'Shop';
                        break;                        
                        default:
                        echo 'error';
                        break;
                      }  
                ?>                
            </td>
            <td><?php
                      switch ($builderquersor['type']) 
                      {
                        case '1':
                        $source='blog_cat';
                        break;
                        case '2':
                        $source='texnika_cat';
                        break;
                        case '3':
                        $source='shop_cat';
                        break;    
                        default:
                        $source='';
                        break;
                      }
                      $catsor = $db->prepare('SELECT * FROM '.$source.' where u_id=:ds and  l_id="1" ');
                      $catsor->execute(array('ds'=>$builderquersor['cat_id']));
                      $catsay=$catsor->rowCount();
                      if($catsay>=1)
                      {
                        $catcek=$catsor->fetch(PDO::FETCH_ASSOC);                        
                        if ($catcek['name']=='') 
                        {
                          echo 'Name is free , id: '.$catcek['u_id'];
                        }
                        else
                        {
                          echo $catcek['name'];
                        }                        
                      }
                ?>                  
            </td>
            <td><?php if(!is_null($builderquersor['post_id']))
                      {
                        echo 'Current Post ';
                      }
                      else
                      {
                        switch ($builderquersor['func_id']) 
                        {
                          case '1':
                          echo 'First';
                          break;
                          case '2':
                          echo 'Last';
                          break;
                          case '3':
                          echo 'Random';
                          break;                       
                          default:
                          echo 'error';
                          break;
                        }
                      }  
                ?>                
            </td>
            <td><?php
                      switch ($builderquersor['type']) 
                      {
                        case '1':
                        $source='blog_content';
                        break;
                        case '2':
                        $source='texnika_content';
                        break;
                        case '3':
                        $source='shop_item';
                        break;    
                        default:
                        $source='';
                        break;
                      }
                      $catsor = $db->prepare('SELECT * FROM '.$source.' where u_id=:ds and  l_id="1" ');
                      $catsor->execute(array('ds'=>$builderquersor['post_id']));
                      $catsay=$catsor->rowCount();
                      if($catsay==1)
                      {
                        $catcek=$catsor->fetch(PDO::FETCH_ASSOC);                        
                        if ($catcek['name']=='') 
                        {
                          echo 'Name is free , id: '.$catcek['u_id'];
                        }
                        else
                        {
                          echo $catcek['name'];
                        }                        
                      }
                ?>                  
            </td>
            <td>
              <a style="color:green; margin-right: 12px; float: right;" href="<?php echo $site_url.'builder/edit/'.$builderquersor['id'].'/' ?>">
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