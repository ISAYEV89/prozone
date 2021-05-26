<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.12/js/select2.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.12/css/select2.min.css">
<?php 
    $products = $db->prepare('select * from mehsul where l_id=1');
    $products->execute();
    
    $stocks = $db->prepare('select * from stock');
    $stocks ->execute();
?>

<form method="POST" action="" enctype="multipart/form-data" id="demo-form2" data-parsley-validate class="form-horizontal">   

<div class="form-group"  id="allcount"  >

    <label class="control-label">Select Countries</label>
     
      <select id="allcounts" name="products[]"  style="width: 60%; border-radius:5px; margin:10px 0;" multiple data-plugin-selectTwo class="form-control populate select2">
    
        <?php
    
        while($product=$products->fetch(PDO::FETCH_ASSOC))
    
        {
            
        ?>
          <?php
            $in_stock = $db->prepare('select * from stock where product_id = ?');
            $in_stock->execute([$product['u_id']]);
          ?>    
          <option value="<?php echo $product['u_id'] ?>" <?php if($in_stock->rowCount() > 0) echo 'disabled'; ?> ><?php echo $product['name'] ?></option>
    
        <?php
    
        }
    
        ?>
    
      </select>
    
    
    
    </div>
<div class="form-group">

    <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-3">

      <input id="btnid" type="submit" name="btn" value="submit" class="btn btn-success"/>

    </div>

  </div>
          
</form>

<table class="table table-bordered">
    <thead>
        <th>#</th>
        <th>Product name</th>
        <th>Product picture</th>
        <th>Amount</th>
        <th>Actions</th>
    </thead>
    <tbody>
        <?php 
        $n=0;
        while($stock = $stocks->fetch(PDO::FETCH_ASSOC)){
            $n++;
            $items = $db->prepare('select * from mehsul where u_id = ? and l_id = 1');
            $items->execute([$stock['product_id']]);
            $item = $items->fetch(PDO::FETCH_ASSOC);
            
        ?>
        <tr>
        <td><?php echo $n ?></td>
        <td><?php echo $item['name'] ?></td>
        <td><img width="80" height="80" src="<?php echo $site_url.'images/'.$item['image_url']; ?>"></td>
        <td>
            <form method="POST" enctype="multipart/form-data" id="demo-form2" data-parsley-validate class="form-horizontal" >

                <input type="hidden" name="update_id" value="<?php echo $stock['product_id'] ?>">
                <input type="number" name="amount" value="<?php echo $stock['amount'] ?>">

                <button id="btnid" type="submit" name="ubtn" value="" class="btn btn-info"><i class="fa fa-undo"></i></button>

              </form>
        </td>
        <td>
            <form method="POST" enctype="multipart/form-data" id="demo-form2" data-parsley-validate class="form-horizontal" action="<?php echo $site_url.'product/delete_stock/';?>">

                <input type="hidden" name="delete_id" value="<?php echo $stock['product_id'] ?>">

                <button id="btnid" type="submit" name="dbtn" value="" class="btn btn-danger"><i class="fa fa-trash"></i></button>

              </form>
            
        </td>
        <?php } ?>
        </tr>
    </tbody>
</table>

<?php ?>


<script>
    $('.select2').select2();
</script>

<?php 
if($_POST['btn']){
    
    $db->begintransaction();
    $control = 1;
    
    for ($i=0; $i<count($_POST['products']); $i++)
    {
        $query = $db->prepare('insert into stock set product_id = ?, amount = 1');
        $add = $query->execute([$_POST['products'][$i]]);
        if(!$add){
            $control = 0;
        }
    }
    if($control == 0){
        $db->rollBack();
        //echo 'no';
    }else{
        $db->commit();
        //echo 'yeah';
    }
    header('Location: .');
}

if(isset($_POST['ubtn'])){
    $query = $db->prepare('update stock set amount= ? where product_id = ?');
    $update = $query->execute([$_POST['amount'],$_POST['update_id']]);
    header('Location: .');
}


?>


