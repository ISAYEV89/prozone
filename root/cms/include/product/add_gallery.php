<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

<form enctype="multipart/form-data" file="true" method="post" target="">
    
    <div class="form-group">
            <div class="row">
                <div class="col-md-2 col-sm-2 col-xs-2"></div>    
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="">
                Add image
            </label>
                
            <div class="col-md-4 col-sm-4 col-xs-12 increment">
                    
                <div class="input-group control-group"  >
                    <input type="number" name="order[]" class="form-control" >
                    <input type="file" id="" name="files[]" value=""  class="form-control" />
                    <div class="input-group-btn">
                        <button class="btn btn-success" type="button" ><i class="fa fa-plus" ></i>  Add</button>
                        
                    </div>
                    <br>
                    
                
                </div>
                <div class="clone" style="display:none;">
                    
                    <div class="control-group input-group" style="margin-top:10px">
                        <input type="number" name="order[]" class="form-control">
                    
                        <input type="file" name="files[]"  class="form-control" />
                        <div class="input-group-btn">
                            <button class="btn btn-danger" type="button"><i class="fa fa-trash"></i> Remove</button>
                        </div>
                        
                    </div>
                </div>
            </div>
            </div>    
        </div>
        <div class="form-group">
            <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-3">
              <input id="btnid" type="submit" name="btn" value="submit" class="btn btn-primary submit_btn" />
            </div>
          </div>
</form>
<br>
<br>
<br>
<div class="row">

<?php

// Get images from the database
$query = $db->prepare("SELECT * FROM product_gallery where product_id = ? ORDER BY ordering ASC");

$query->execute([$_GET['val']]);

while($image = $query->fetch(PDO::FETCH_ASSOC) ){
?>
    <div class="col-md-2 col-sm-2 col-xs-4">
    <img width="100" height="100" src="<?php echo $site_url.'images/'.$image['image']; ?>">
    
    <a href="<?php echo $site_url.'product/delete_gallery/'.$image['id'].'/' ?>"><i class="fa fa-trash fa-2x text-danger"></i></a>
    <form method="post" action="<?php echo $site_url.'product/update_gallery/' ?>" style="display:flex;" >
        <input type="number" value="<?php echo $image['ordering'] ?>" style="width:40px;" name="order">
        <input type="hidden" value="<?php echo $image['id'] ?>" name="id">
        <button type="submit" name="update"><i class="fa fa-undo text-info fa-2x"></i></button>
    </form>   
    </div>
<?php
}
?>
</div>

<?php
if($_POST['btn']){
    
    // File upload configuration
    $targetDir = "images/";
    $allowTypes = array('jpg','png','jpeg','gif','JPG','JPEG','PNG');
    
    $statusMsg = $errorMsg = $insertValuesSQL = $errorUpload = $errorUploadType = '';
    
    $db->begintransaction();
    $check = 1;
    
    if(!empty(array_filter($_FILES['files']['name']))){
        foreach($_FILES['files']['name'] as $key=>$val){
            // File upload path
            $array = explode('.', $val);
            $extension = end($array);
            
            $fileName = basename($_FILES['files']['name'][$key]);
            $fileName = uniqid().md5('helloworld').$filename.'.'.$extension;
            $targetFilePath = $targetDir . $fileName;
            
            // Check whether file type is valid
            
            if(in_array($extension, $allowTypes)){
                // Upload file to server
                if(move_uploaded_file($_FILES["files"]["tmp_name"][$key], $targetFilePath)){
                    move_uploaded_file($_FILES["files"]["tmp_name"][$key], $targetFilePath);
                    // Image db insert sql
                    if($key != intval(count($_POST['order'])) ){
                        $lngins=$db->prepare('INSERT INTO product_gallery set product_id=:id ,ordering=:ordering,image=:image ');
                        $lnginscon=$lngins->execute(array('id'=>$_GET['val'] ,'ordering'=>$_POST['order'][$key], 'image'=>$fileName));
                        if (!$lnginscon) 
                        {
                            $check=0;
                        }
                      //  echo '<br>'.$check;
                        
                    }
                }else{
                    $errorUpload .= $_FILES['files']['name'][$key].', ';
                }
                
            }else{
                $errorUploadType .= $_FILES['files']['name'][$key].', ';
                
            }
            
        }
        
     //   echo '<br>'.$check;
    }else{
        $statusMsg = 'Please select a file to upload.';
    }
    
    
    if ($check==1) 
    {
      $db->commit(); 
      header("Refresh:0");    
      
    }
    else
    {
      $db->rollBack();        
      header("Refresh:0");
      
      
    }
   
   
}





?>


<style>
    .submit_btn{
        float:right;
    }
    @media (min-width: 992px){
        .submit_btn{
        margin-right:35%;
    }   
    }
</style>

<script>
    $(document).ready(function() {

                $(".btn-success").click(function(){
                    var html = $(".clone").html();
                    $(".increment").append(html);
                });

                $("body").on("click",".btn-danger",function(){
                    $(this).parents(".control-group").remove();
                });

            });
</script>