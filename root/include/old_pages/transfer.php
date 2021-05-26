<div class="clearfix"></div>
<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2 class="col-md-12 col-xs-12 col-sm-12 col-lg-12" >SEND MONEY <p style="float: right;" >  Your money <?php echo $_SESSION['balan']; ?>  </p></h2>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <br />
        <form  method="POST" action="" class="form-horizontal form-label-left">

          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Login Name*<span class="required"></span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" name="sas" id="ss" required="required" onchange="ds();cont();"  class="form-control col-md-7 col-xs-12">
            </div>
            <input type="number" style="display: none; "  value="<?php echo $_SESSION['balan'];  ?>" name="sasa" id="hds" >
            
          </div>

          <div class="form-group">
            <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Amount*</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input  onchange="sd();cont();" onkeyup="sd();cont();" class="form-control col-md-7 col-xs-12" type="number" name="ount" id="mon">
            </div>
          </div>

          <div class="ln_solid"></div>
          <div class="form-group">
            <div style="float: right;" class="col-md-4 col-sm-6 col-xs-12 col-md-offset-3 ">

              <button onclick="ds();sd();cont();" onmouseover="ds();sd();cont();" type="button" name="bdtn" id="btn" class="btn btn-success">&nbspSend&nbsp</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<script src="<?php echo $site_url ?>include/vendors/jquery/dist/jquery.min.js"></script>
<script >
  var seslog=<?php echo "'".$login."'"; ?>;
  
  var delta = 0;
  var beta = 0;
  function sd()
  {
    var a= document.getElementById('hds').value;
    a=parseInt(a);
    var sck = document.getElementById('mon').value;
    sck=parseInt(sck);

    if (a<sck || sck<=0 ) 
      { delta = 0;
       document.getElementById('btn').type="button";
         // alert('cox getdin%'+a+'%-%'+sck+"%");
         document.getElementById("mon").style.borderColor = "red" ;
       }
       else
       {
         // alert('hele var%'+a+'%-%'+sck+"%");
         document.getElementById("mon").style.borderColor = "#ccc" ; 
         delta = 1;

       }
     }

     function ds()
     {
      var d= document.getElementById('ss').value;
      $.ajax({

        url:"<?php echo $site_url.'include/islem2.php'; ?>",
        method:"POST",
        data:{yol:"dza" , log:d },
        success:function(data)
        {
          if (data=="false" || d===seslog)
          {
            beta = 0;  
            document.getElementById("ss").style.borderColor = "red" ;
            document.getElementById('btn').type="button";
                // document.getElementById('subsub').type="button"; // alert("The name already have in data base");
              }
              else
              {               
                document.getElementById("ss").style.borderColor = "#ccc" ; 

                beta = 1;        
              }
            }
          });
    }
    function cont(){

      if (beta == 1)
      {
        if (delta == 1)
        {
         document.getElementById('btn').type="submit";
       }
       else
       {
        document.getElementById('btn').type="button";
      }
    }
    else
    {
      document.getElementById('btn').type="button";
    }
  }


</script>

<?php if (isset($_POST['bdtn'])) 
{
  if ($_SESSION['balan']>=s($_POST['ount']) && 0<s($_POST['ount']) ) 
  {
   $userdsor = $db->prepare("SELECT login , id , balans_1 FROM user where login='".s($_POST['sas'])."'  ");
   $userdsor->execute();
   $userdsay=$userdsor->rowCount();

   if($userdsay==1 and $login!==s($_POST['sas']))
   {
    $userdcek=$userdsor->fetch(PDO::FETCH_ASSOC);

    $tobal=($userdcek['balans_1']+s($_POST['ount']));
    $frombal=($_SESSION['balan']-s($_POST['ount']));
    $sallary=0;

    $db->beginTransaction();

    $shup=$db->prepare('UPDATE user SET balans_1="'.$frombal.'" where id= "'.$_SESSION['id'].'" ');
    $shupt=$shup->execute();
    if (!$shupt) 
    {
      $sallary=1;
    }

    $shup2=$db->prepare('UPDATE user SET balans_1="'.$tobal.'" where id= "'.$userdcek['id'].'" ');
    $shupt2=$shup2->execute();
    if (!$shupt2) 
    {
     $sallary=1;
   }

   $drop=$db->prepare('INSERT into dropbank set  `change`="'.s($_POST['ount']).'" , `to_balance`="'.$tobal.'" , `from_balance`="'.$frombal.'" , `to`="'.$userdcek['id'].'" , `from`="'.$_SESSION['id'].'" , `s_id`="12" ');
   $dropif= $drop->execute();
   if (!$dropif) 
   {
     $sallary=1;
   }
   if ($sallary==0) 
   {
    $db->commit();
    header("Location:".$site_url.$lng."/myaccounts/15478/"); 
  }
  elseif($sallary==1)
  {
    $db->rollBack();
    header("Location:".$site_url.$lng."/myaccounts/25678/"); 
  }
  }

}
else
{
   header("Location:".$site_url.$lng."/myaccounts/25678/"); 
}
} ?>