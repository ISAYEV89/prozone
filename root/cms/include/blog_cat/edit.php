<?php 
$blogquera=$db->prepare('SELECT * FROM blog_cat where u_id=:uid limit 1 ');
$blogquera->execute(array('uid'=>s($_GET['val'])));
$count=$blogquera->rowCount();
$blogquerasor=$blogquera->fetch(PDO::FETCH_ASSOC);
if (!$_GET['val'] or $count<1) 
{
  header('Location:'.$site_url.'blog_cat/list/');
}
$lngquera=$db->prepare('SELECT short_name as sn , org_name as orgn , u_id FROM lng ');
$lngquera->execute();
$catquer=$db->prepare('SELECT u_id , name , sub_id FROM blog_cat where l_id="1" ');
$catquer->execute();
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
              $blogquers=$db->prepare('SELECT * FROM blog_cat where u_id=:uid and l_id=:lid');
              $blogquers->execute(array('uid'=>s($_GET['val']) , 'lid'=>$luid[$i] ));
              $blogquerssor=$blogquers->fetch(PDO::FETCH_ASSOC);
            ?>
              <div id="<?php echo $orgname[$i]; ?>" class="w3-container city" style="display:none">
                <h2><?php echo $orgname[$i]; ?></h2>
                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12">Url tag <span class="required">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input id="tagurl<?php echo $shortname[$i]; ?>" value='<?php echo $blogquerssor["url_tag"] ?>'   onchange="check<?php echo $shortname[$i]; ?>();" name="ut<?php echo $shortname[$i]; ?>" type="text" class="js-switch date-picker form-control col-md-7 col-xs-12"  />
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12">Name <span class="required">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input name="names<?php echo $shortname[$i]; ?>" type="text" value='<?php echo $blogquerssor["name"] ?>'   class="js-switch date-picker form-control col-md-7 col-xs-12"  />
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12">Description <span class="required">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input name="desc<?php echo $shortname[$i]; ?>" type="text" value='<?php echo $blogquerssor["description"] ?>'   class="js-switch date-picker form-control col-md-7 col-xs-12"  />
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12">Title <span class="required">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input name="tit<?php echo $shortname[$i]; ?>" type="text" value='<?php echo $blogquerssor["title"] ?>'  class="js-switch date-picker form-control col-md-7 col-xs-12"  />
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12">Short Title <span class="required">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input name="stit<?php echo $shortname[$i]; ?>" type="text" value='<?php echo $blogquerssor["stitle"] ?>'  class="js-switch date-picker form-control col-md-7 col-xs-12"  />
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12">Keyword <span class="required">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input name="key<?php echo $shortname[$i]; ?>" value='<?php echo $blogquerssor["keyword"] ?>' type="text" class="js-switch date-picker form-control col-md-7 col-xs-12"  />
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12">Text <span class="required">*</span>
                  </label>
                  <div class="col-md-9 col-sm-9 col-xs-12">
                    <textarea name="txt<?php echo $shortname[$i]; ?>" ><?php echo $blogquerssor["text"] ?></textarea>
                  </div>
                </div>
              </div>
            <?php
            }
            ?>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Category <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <select class="form-control" name='subids'>
                <option  value="0" <?php if($blogquerssor["sub_id"]==0){echo 'selected="" ';} ?> >Main</option>
                <?php
                while($catquerft=$catquer->fetch(PDO::FETCH_ASSOC))
                {
                  if ($catquerft['u_id']==$_GET['val'] || $catquerft['sub_id']==$_GET['val']) 
                  {
                    continue;
                  }
                ?>
                  <option  value="<?php echo $catquerft['u_id']; ?>" <?php if($blogquerasor["sub_id"]==$catquerft['u_id']){echo 'selected="" ';} ?> ><?php echo $catquerft['name'] ?></option>
                <?php 
                }
                ?>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Display <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input name="sids"  <?php if(is_null($blogquerasor["s_id"])){echo 'checked=""';} ?> class="date-picker form-control col-md-7 col-xs-12 js-switch" type="checkbox">
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
      data: { bc: "tagurl", name: x , id: <?php echo s($_GET['val']); ?> },
      success:function(data)
      {
        if (data=='true') 
        {
          var checkcont<?php echo $shortname[$i]; ?> =1;
          // alert(checkcont<?php echo $shortname[$i]; ?>);
          document.getElementById("tagurl<?php echo $shortname[$i]; ?>").style.borderColor='#ccc';
          document.getElementById("<?php echo $shortname[$i]; ?>").style.color='#5A738E';
          // alert('#5A738E');
        }
        else if (data=='false')
        {
          var checkcont<?php echo $shortname[$i]; ?> =0;
          // alert(checkcont<?php echo $shortname[$i]; ?>);
          document.getElementById("tagurl<?php echo $shortname[$i]; ?>").style.borderColor='red';
          document.getElementById("<?php echo $shortname[$i]; ?>").style.color='#5A738E';
        }
        <?php 
        for ($t=0;$t<$lngsay;$t++) 
        {
        ?>

          if (checkcont<?php echo $shortname[$t]; ?>==0)
          {
            check=0;
            document.getElementById("<?php echo $shortname[$i]; ?>").style.color='red';
            // alert("<?php echo $shortname[$i]; ?>");
          }
          else if (checkcont<?php echo $shortname[$t]; ?>==1)
          {
            //document.getElementById("<?php echo $shortname[$i]; ?>").style.color='#5A738E';
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
  $control=1;
  function d($post)
  {
    if ($post=='on') 
    {
      return NULL;
    }
    else
    {
      return 0;
    }
  }
  $db->begintransaction();
    echo '<pre>';print_r($_POST);echo '</pre>';
  for ($i=0; $i <$lngsay ; $i++) 
  {      
    $lngins=$db->prepare('UPDATE blog_cat set l_id=:lng2 , `text`=:txt , description=:sn , name=:nm , title=:ti , stitle=:sti , keyword=:keyw , u_id=:uid , url_tag=:utg , s_id=:sid , sub_id=:subid where u_id=:uid and l_id=:lng2');
    $lnginscon=$lngins->execute(array('lng2'=>$luid[$i] , 'sn'=>s($_POST['desc'.$shortname[$i]]) , 'nm'=>s($_POST['names'.$shortname[$i]]) , 'ti'=>s($_POST['tit'.$shortname[$i]]) , 'sti'=>s($_POST['stit'.$shortname[$i]]) , 'keyw'=>s($_POST['key'.$shortname[$i]]) , 'txt'=>sck($_POST['txt'.$shortname[$i]]) , 'utg'=>s($_POST['ut'.$shortname[$i]]) , 'uid'=>s($_GET['val']) , 'sid'=>d($_POST['sids']) , 'subid'=>s($_POST['subids'])));
    if (!$lnginscon) 
    {
      $control=0;
    }
    // echo 'lng2'.'=>'.$luid[$i].','.'sn'.'=>'.s($_POST['desc'.$shortname[$i]]).','.'nm'.'=>'.s($_POST['names'.$shortname[$i]]).','.'ti'.'=>'.s($_POST['tit'.$shortname[$i]]).','.'keyw'.'=>'.s($_POST['key'.$shortname[$i]]).','.'txt'.'=>'.s($_POST['txt'.$shortname[$i]]).','.'utg'.'=>'.s($_POST['ut'.$shortname[$i]]).','.'uid'.'=>'.s($_GET['val']).','.'sid'.'=>'.d($_POST['sids']).','.'subid'.'=>'.s($_POST['subids']);
  }
  if ($control==1) 
  {
    $db->commit(); 
    echo "string";
    header('Location:'.$site_url.'blog_cat/list/456852/');
  }
  else
  {
    $db->rollBack();
    header('Location:'.$site_url.'blog_cat/list/456456/');
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