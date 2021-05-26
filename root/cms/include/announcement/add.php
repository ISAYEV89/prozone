<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css" >
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>

<?php 
$lngquera=$db->prepare('SELECT short_name as sn , org_name as orgn , u_id FROM lng ');
$lngquera->execute();
$shortname=array();
$orgname=array();
$luid=array();
while($lngquerasor=$lngquera->fetch(PDO::FETCH_ASSOC))
{
  array_push($orgname, $lngquerasor['orgn']);
  array_push($shortname, $lngquerasor['sn']);
  array_push($luid, $lngquerasor['u_id']);
}
$lngsay=count($luid);
?>
<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>ADD BLOG CONTENT </h2>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">   
        <form method="POST" action="" enctype="multipart/form-data" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
          <div class="w3-container">
            <div class="w3-row">
              <?php
              for($i=0;$i<$lngsay;$i++)
              {
              ?>
                <a id="<?php echo $shortname[$i] ?>" href="javascript:void(0)" onclick="openCity(event, '<?php echo $orgname[$i]; ?>');">
                  <div class="w3-quarter  tablink w3-bottombar w3-hover-light-grey w3-padding"><?php echo $orgname[$i]; ?></div>
                </a>
              <?php
              }
              ?>
            </div>
            <?php
            for($i=0;$i<$lngsay;$i++)
            {
            ?>
              <div id="<?php echo $orgname[$i]; ?>" class="w3-container city" style="display:none">
                <h2><?php echo $orgname[$i]; ?></h2>
                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12">Name <span class="required">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input name="names<?php echo $shortname[$i]; ?>" type="text" class="js-switch date-picker form-control col-md-7 col-xs-12" checked />
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12">Name 2<span class="required">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input name="names2<?php echo $shortname[$i]; ?>" type="text" class="js-switch date-picker form-control col-md-7 col-xs-12" checked />
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12">Description <span class="required">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input name="desc<?php echo $shortname[$i]; ?>" type="text" class="js-switch date-picker form-control col-md-7 col-xs-12" checked />
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12">Title <span class="required">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input name="tit<?php echo $shortname[$i]; ?>" type="text" class="js-switch date-picker form-control col-md-7 col-xs-12" checked />
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12"> Short Title <span class="required">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input name="stit<?php echo $shortname[$i]; ?>" type="text" class="js-switch date-picker form-control col-md-7 col-xs-12" checked />
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12">Keyword <span class="required">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input name="key<?php echo $shortname[$i]; ?>" type="text" class="js-switch date-picker form-control col-md-7 col-xs-12" checked />
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12">Text 1<span class="required">*</span>
                  </label>
                  <div class="col-md-9 col-sm-9 col-xs-12">
                    <textarea name="txt<?php echo $shortname[$i]; ?>" ></textarea>
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12">Text 2<span class="required">*</span>
                  </label>
                  <div class="col-md-9 col-sm-9 col-xs-12">
                    <textarea name="txt1<?php echo $shortname[$i]; ?>" ></textarea>
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12">Text 3<span class="required">*</span>
                  </label>
                  <div class="col-md-9 col-sm-9 col-xs-12">
                    <textarea name="txt2<?php echo $shortname[$i]; ?>" ></textarea>
                  </div>
                </div>
              </div>
            <?php
            }
            ?>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Cover Picture <?php echo pxtostr($staticft['blog_cont_pic']); ?><span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input name="pic" class="date-picker form-control col-md-7 col-xs-12" required="required" type="file">
            </div>
          </div>
        
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Cover Photo-1 <?php echo pxtostr($staticft['blog_cont_pic']); ?><span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input name="pht1" class="date-picker form-control col-md-7 col-xs-12" required="required" type="file">
            </div>
          </div>
        
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Cover Photo-2 <?php echo pxtostr($staticft['blog_cont_pic']); ?><span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input name="pht2" class="date-picker form-control col-md-7 col-xs-12"  type="file">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Date <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                   <input type="text" id="datepicker" name="date" >
              
             <script>
                var $j = jQuery.noConflict();
                $( function() {
                
                    $j('#datepicker').datepicker({
                        dateFormat: 'yy-mm-dd',
                        onSelect: function(datetext) {
                            var d = new Date(); // for now
                
                            var h = d.getHours();
                            h = (h < 10) ? ("0" + h) : h ;
                
                            var m = d.getMinutes();
                            m = (m < 10) ? ("0" + m) : m ;
                
                            var s = d.getSeconds();
                            s = (s < 10) ? ("0" + s) : s ;
                
                            datetext = datetext + " " + h + ":" + m + ":" + s;
                
                            $('#datepicker').val(datetext);
                        }
                    });    
                
              });
            </script>

            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Youtube link
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <textarea name="youtube_link" class="date-picker form-control col-md-7 col-xs-12"  type="text"></textarea>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Display <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input name="sids" checked="" class="date-picker form-control col-md-7 col-xs-12 js-switch" type="checkbox">
            </div>
          </div>
          <div class="form-group">
            <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-3">
              <input id="btnid" type="submit" name="btn" value="submit" class="btn btn-success"/>
            </div>
          </div>
        </form>        
      </div>
    </div>
  </div>
</div>
<script src="<?php echo $site_url ?>ckeditor/ckeditor.js"></script>
<?php
for($i=0;$i<$lngsay;$i++)
{
?>
  <script>
    var checkcont<?php echo $shortname[$i]; ?> =1;
    CKEDITOR.replace( '<?php echo "txt".$shortname[$i] ?>' );
    CKEDITOR.replace( '<?php echo "txt1".$shortname[$i] ?>' );
    CKEDITOR.replace( '<?php echo "txt2".$shortname[$i] ?>' );
  </script>
<?php
}
?>
<script type="text/javascript">
<?php
for ($i=0;$i<$lngsay;$i++) 
{
?>
  function  check<?php echo $shortname[$i]; ?>()
  {
    var check = 1;
    var x = document.getElementById('tagurl<?php echo $shortname[$i]; ?>').value.toLowerCase();
    document.getElementById('tagurl<?php echo $shortname[$i]; ?>').value=x;
    $.ajax({
      method: "POST",
      url: "<?php echo $site_url.'include/islem.php' ?>",
      data: { bco: "contenttagurl", name: x },
      success:function(data)
      {
        //alert(data);
        if (data=='true') 
        {
          var checkcont<?php echo $shortname[$i]; ?> =1;
          document.getElementById("tagurl<?php echo $shortname[$i]; ?>").style.borderColor='#ccc';
          document.getElementById("<?php echo $shortname[$i]; ?>").style.color='#5A738E';
        }
        else if (data=='false')
        {
          var checkcont<?php echo $shortname[$i]; ?> =0;
          document.getElementById("tagurl<?php echo $shortname[$i]; ?>").style.borderColor='red';
        }
        <?php 
        for ($t=0;$t<$lngsay;$t++) 
        {
        ?>
          if (checkcont<?php echo $shortname[$t]; ?>==0)
          {
            check=0;
            document.getElementById("<?php echo $shortname[$i]; ?>").style.color='red';
          }
        <?php 
        }
        ?>
        if(check==1)
        {
          document.getElementById("btnid").type='submit';
        }
        else if (check==0)
        {
          document.getElementById("btnid").type='button';
        }
      }
    })
  }
<?php 
}
?>
</script>
<?php
if ($_POST['btn']) 
{
    
        
  $lngquer=$db->prepare('SELECT MAX(u_id) as max , MAX(ordering) as maxo FROM announcement_content ');
  $lngquer->execute(); 
  $lngquersor=$lngquer->fetch(PDO::FETCH_ASSOC);
  $unique1=rand(100,999);
  $unique2=rand(1000,9999);
  $unique3=rand(10000,99999);

  $t1unique1=rand(100,999);
  $t1unique2=rand(1000,9999);
  $t1unique3=rand(10000,99999);

  $t2unique1=rand(100,999);
  $t2unique2=rand(1000,9999);
  $t2unique3=rand(10000,99999);


  $unique=$unique1.$unique2.$unique3;

  $t1unique=$t1unique1.$t1unique2.$t1unique3;

  $t2unique=$t2unique1.$t2unique2.$t2unique3;

  $type=explode('.', $_FILES['pic']['name']);
  $type=end($type);

  $t1type=explode('.', $_FILES['pht1']['name']);
  $t1type=end($t1type);

  if($_POST['pht2']){        
    $t2type=explode('.', $_FILES['pht2']['name']);
    $t2type=end($t2type);
  }
  $uid=$lngquersor['max']+1;
  $ord=$lngquersor['maxo']+1;
  $catsay=count($_POST['cat']);
  if ($_POST['sids']=='on') 
  {
    $s=NULL;
  }
  else
  {
    $s=0;
  }
  
  
  $db->begintransaction();
  $lastcont=1;
        
               
if($_POST['pht2']){    
      
  if ($_FILES['pic']['size']<=600000 && in_array($_FILES['pic']['type'], ['jpg','jpeg','png','image/jpeg','image/jpg','image/png']) && $control=move_uploaded_file($_FILES['pic']['tmp_name'], 'images/'.$unique.'.'.$type) and $_FILES['pht1']['size']<=600000 && in_array($_FILES['pht1']['type'], ['jpg','jpeg','png','image/jpeg','image/jpg','image/png']) && $control=move_uploaded_file($_FILES['pht1']['tmp_name'], 'images/'.$t1unique.'.'.$t1type) and $_FILES['pht2']['size']<=600000 && in_array($_FILES['pht2']['type'], ['jpg','jpeg','png','image/jpeg','image/jpg','image/png']) && $control=move_uploaded_file($_FILES['pht2']['tmp_name'], 'images/'.$t2unique.'.'.$t2type)) 
  {
    for ($i=0; $i <$lngsay ; $i++) 
    {
          $lngins=$db->prepare('INSERT INTO announcement_content set ordering=:ord ,date=:date, youtube_link=:youtube_link,  description=:sn , name=:nm , title=:ti ,  stitle=:sti , keyword=:keyw , picture=:pc ,  photo1=:pt1 , photo2=:pt2 , u_id=:uid , l_id=:lng2 , s_id=:sid , `text`=:txt , `text1`=:txt1  , `text2`=:txt2  ,`name2`=:nm2 ');
          $lnginscon=$lngins->execute(array('lng2'=>$luid[$i] ,'date'=>$_POST['date'], 'youtube_link'=>$_POST['youtube_link'], 'sn'=>s($_POST['desc'.$shortname[$i]]) , 'nm'=>s($_POST['names'.$shortname[$i]]) , 'nm2'=>s($_POST['names2'.$shortname[$i]]) , 'ti'=>s($_POST['tit'.$shortname[$i]]) ,  'sti'=>s($_POST['stit'.$shortname[$i]]) ,  'keyw'=>s($_POST['key'.$shortname[$i]]) , 'txt'=>($_POST['txt'.$shortname[$i]]) , 'txt1'=>($_POST['txt1'.$shortname[$i]]) , 'txt2'=>($_POST['txt2'.$shortname[$i]]) , 'pc'=>$unique.'.'.$type , 'pt1'=>$t1unique.'.'.$t1type , 'pt2'=>$t2unique.'.'.$t2type , 'uid'=>$uid , 'ord'=>$ord , 'sid'=>$s ));
          if (!$lnginscon) 
          {
            $lastcont=0;
          }
      
    }
  }
  
}else{
   if ($_FILES['pic']['size']<=600000 && in_array($_FILES['pic']['type'], ['jpg','jpeg','png','image/jpeg','image/jpg','image/png']) && $control=move_uploaded_file($_FILES['pic']['tmp_name'], 'images/'.$unique.'.'.$type) and $_FILES['pht1']['size']<=600000 && in_array($_FILES['pht1']['type'], ['jpg','jpeg','png','image/jpeg','image/jpg','image/png']) && $control=move_uploaded_file($_FILES['pht1']['tmp_name'], 'images/'.$t1unique.'.'.$t1type) ) 
  {
    for ($i=0; $i <$lngsay ; $i++) 
    {
          $lngins=$db->prepare('INSERT INTO announcement_content set ordering=:ord ,date=:date, youtube_link=:youtube_link, description=:sn , name=:nm , title=:ti ,  stitle=:sti , keyword=:keyw , picture=:pc ,  photo1=:pt1 , u_id=:uid , l_id=:lng2 , s_id=:sid , `text`=:txt , `text1`=:txt1  , `text2`=:txt2  ,`name2`=:nm2 ');
          $lnginscon=$lngins->execute(array('lng2'=>$luid[$i] ,'date'=>$_POST['date'], 'youtube_link'=>$_POST['youtube_link'], 'sn'=>s($_POST['desc'.$shortname[$i]]) , 'nm'=>s($_POST['names'.$shortname[$i]]) , 'nm2'=>s($_POST['names2'.$shortname[$i]]) , 'ti'=>s($_POST['tit'.$shortname[$i]]) ,  'sti'=>s($_POST['stit'.$shortname[$i]]) ,  'keyw'=>s($_POST['key'.$shortname[$i]]) , 'txt'=>($_POST['txt'.$shortname[$i]]) , 'txt1'=>($_POST['txt1'.$shortname[$i]]) , 'txt2'=>($_POST['txt2'.$shortname[$i]]) , 'pc'=>$unique.'.'.$type , 'pt1'=>$t1unique.'.'.$t1type , 'uid'=>$uid , 'ord'=>$ord , 'sid'=>$s ));
          if (!$lnginscon) 
          {
            $lastcont=0;
          }
      
    }
  }
  echo $lastcont;
}

    if ($lastcont==1) 
    {
      $db->commit(); echo "string";
      header('Location:'.$site_url.'announcement/list/456852/');
      exit();
    }
    else
    {
      $db->rollBack();        
      if (is_file('images/'.$unique.'.'.$type) and is_file('images/'.$t1unique.'.'.$t1type) and is_file('images/'.$t2unique.'.'.$t2type)) 
      {
        unlink('images/'.$unique.'.'.$type);
        unlink('images/'.$t1unique.'.'.$t1type);
        unlink('images/'.$t2unique.'.'.$t2type);
      }  
      header('Location:'.$site_url.'announcement/list/456456/');
      exit();
    }  
  
}

?>
<script>
function openCity(evt, cityName , tol) 
{
  var i, x, tablinks;
  x = document.getElementsByClassName("city");
  for (i = 0; i < x.length; i++) 
  {
    x[i].style.display = "none";
  }
  tablinks = document.getElementsByClassName("tablink");
  for (i = 0; i < x.length; i++) 
  {
    tablinks[i].className = tablinks[i].className.replace(" w3-border-red", "");
  }
  document.getElementById(cityName).style.display = "block";
  if (tol==1) 
  {
    document.getElementById(evt).firstElementChild.className += " w3-border-red";
  }
  else
  {
    evt.currentTarget.firstElementChild.className += " w3-border-red";
  }
}
openCity('<?php echo $shortname[0] ?>', '<?php echo $orgname[0] ?>' , 1);
</script>