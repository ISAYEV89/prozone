<?php 
$menuquera=$db->prepare('SELECT * FROM menu where u_id=:uid limit 1 ');
$menuquera->execute(array('uid'=>s($_GET['val'])));
$count=$menuquera->rowCount();
$menuquerasor=$menuquera->fetch(PDO::FETCH_ASSOC);
if (!$_GET['val'] or $count<1) 
{
  header('Location:'.$site_url.'menu_cat/list/');
}
$lngquera=$db->prepare('SELECT short_name as sn , org_name as orgn , u_id FROM lng ');
$lngquera->execute();
$catquer1=$db->prepare('SELECT u_id , name FROM menu where l_id="1" and type="1" and u_id!=:uidss  and sub_id!=:subs');
$catquer1->execute(array('uidss'=>s($_GET['val']) , 'subs'=>s($_GET['val'])));
$catquer2=$db->prepare('SELECT u_id , name FROM menu where l_id="1" and type="2" and u_id!=:uidss  and sub_id!=:subs');
$catquer2->execute(array('uidss'=>s($_GET['val']) , 'subs'=>s($_GET['val'])));
$catquer3=$db->prepare('SELECT u_id , name FROM menu where l_id="1" and type="3" and u_id!=:uidss  and sub_id!=:subs');
$catquer3->execute(array('uidss'=>s($_GET['val']) , 'subs'=>s($_GET['val'])));
$catquer4=$db->prepare('SELECT u_id , name FROM menu where l_id="1" and type="4"  and u_id!=:uidss and sub_id!=:subs');
$catquer4->execute(array('uidss'=>s($_GET['val']) , 'subs'=>s($_GET['val'])));
$shortname=array();
$orgname=array();
$luid=array();
$category=array();
$category[0]=array(0);
$category[1]=array(0);
$category[2]=array(0);
$category[3]=array(0);
$category[4]=array(0);
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
        <h2>ADD menu CONTENT </h2>
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
              $menuquers=$db->prepare('SELECT * FROM menu where u_id=:uid and l_id=:lid');
              $menuquers->execute(array('uid'=>s($_GET['val']) , 'lid'=>$luid[$i] ));
              $menuquerssor=$menuquers->fetch(PDO::FETCH_ASSOC);
            ?>
              <div id="<?php echo $orgname[$i]; ?>" class="w3-container city" style="display:none">
                <h2><?php echo $orgname[$i]; ?></h2>
                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12">Url tag <span class="required">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input id="tagurl<?php echo $shortname[$i]; ?>" value="<?php echo $menuquerssor['url_tag'] ?>"   onchange="check<?php echo $shortname[$i]; ?>();" name="ut<?php echo $shortname[$i]; ?>" type="text" class="js-switch date-picker form-control col-md-7 col-xs-12" checked />
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12">Name <span class="required">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input name="names<?php echo $shortname[$i]; ?>" type="text" value="<?php echo $menuquerssor['name'] ?>" class="js-switch date-picker form-control col-md-7 col-xs-12" checked />
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12">Description <span class="required">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input name="desc<?php echo $shortname[$i]; ?>" type="text" value="<?php echo $menuquerssor['description'] ?>" class="js-switch date-picker form-control col-md-7 col-xs-12" checked />
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12">Title <span class="required">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input name="tit<?php echo $shortname[$i]; ?>" type="text" value="<?php echo $menuquerssor['title'] ?>" class="js-switch date-picker form-control col-md-7 col-xs-12" checked />
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12">Keyword <span class="required">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input name="key<?php echo $shortname[$i]; ?>" type="text" value="<?php echo $menuquerssor['keyword'] ?>" class="js-switch date-picker form-control col-md-7 col-xs-12" checked />
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12">Link <span class="required">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input name="link<?php echo $shortname[$i]; ?>" value="<?php echo $menuquerssor['link'] ?>" type="text" class="js-switch date-picker form-control col-md-7 col-xs-12" checked />
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12">Text <span class="required">*</span>
                  </label>
                  <div class="col-md-9 col-sm-9 col-xs-12">
                    <textarea name="txt<?php echo $shortname[$i]; ?>" ><?php echo $menuquerssor['text'] ?></textarea>
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
              <select class="select2_group form-control" name='subids'>
                <option value="0" >Main</option>
                <optgroup label="Top">
                <?php
                while($catquerft1=$catquer1->fetch(PDO::FETCH_ASSOC))
                {
                  array_push($category[1],$catquerft1['u_id']);
                ?>
                  <option <?php if($menuquerasor["sub_id"]==$catquerft1['u_id']){echo 'selected="" ';} ?> value="<?php echo $catquerft1['u_id'] ?>" ><?php echo $catquerft1['name'] ?></option>
                <?php 
                }
                ?>
                </optgroup>
                <optgroup label="Bottom">
                <?php
                while($catquerft2=$catquer2->fetch(PDO::FETCH_ASSOC))
                {
                  array_push($category[2],$catquerft2['u_id']);
                ?>
                  <option <?php if($menuquerasor["sub_id"]==$catquerft2['u_id']){echo 'selected="" ';} ?> value="<?php echo $catquerft2['u_id'] ?>" ><?php echo $catquerft2['name'] ?></option>
                <?php 
                }
                ?>
                </optgroup>
                <optgroup label="Left">
                <?php
                while($catquerft3=$catquer3->fetch(PDO::FETCH_ASSOC))
                {
                  array_push($category[3],$catquerft3['u_id']);
                ?>
                  <option <?php if($menuquerasor["sub_id"]==$catquerft3['u_id']){echo 'selected="" ';} ?> value="<?php echo $catquerft3['u_id'] ?>" ><?php echo $catquerft3['name'] ?></option>
                <?php 
                }
                ?>
                </optgroup>
                <optgroup label="Secret">
                <?php
                while($catquerft4=$catquer4->fetch(PDO::FETCH_ASSOC))
                {
                  array_push($category[4],$catquerft4['u_id']);
                ?>
                  <option <?php if($menuquerasor["sub_id"]==$catquerft4['u_id']){echo 'selected="" ';} ?> value="<?php echo $catquerft4['u_id'] ?>" ><?php echo $catquerft4['name'] ?></option>
                <?php 
                }
                ?>
                </optgroup>
              </select>
            </div>
          </div>          
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Class <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input name="cl" value="<?php echo $menuquerssor['class'] ?>" type="text" class="js-switch date-picker form-control col-md-7 col-xs-12" checked />
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Type <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <select class="form-control" name='typ'>
                <option <?php if($menuquerasor["type"]==1){echo 'selected=""';} ?> value="1" >Top</option>
                <option <?php if($menuquerasor["type"]==2){echo 'selected=""';} ?> value="2" >Bottom</option>
                <option <?php if($menuquerasor["type"]==3){echo 'selected=""';} ?> value="3" >Left</option>
                <option <?php if($menuquerasor["type"]==4){echo 'selected=""';} ?> value="4" >Secret</option>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Display <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input name="sids"  <?php if(is_null($menuquerasor["s_id"])){echo 'checked=""';} ?> class="date-picker form-control col-md-7 col-xs-12 js-switch" type="checkbox">
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
      data: { mn: "menu", name: x },
      success:function(data)
      {
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
  switch (s($_POST['typ'])) 
  {
    case '1':
    $refer='list_top';
    break;
    case '2':
    $refer='list_bottom';
    break;    
    case '3':
    $refer='list_left';
    break;
    case '4':
    $refer='list_secret';
    break;    
    default:
    $refer='list_top';
    break;
  }
  echo '<pre>';print_r($_POST);echo '</pre>';
  $lngquer=$db->prepare('SELECT MAX(u_id) as max , MAX(ordering) as maxo FROM menu ');
  $lngquer->execute(); 
  $lngquersor=$lngquer->fetch(PDO::FETCH_ASSOC);
  $uid=s($_GET['val']);
  $control=1;
  if ($_POST['sids']=='on') 
  {
    $s=NULL;
  }
  else
  {
    $s=0;
  }
  $db->begintransaction();

  for ($i=0; $i <$lngsay ; $i++) 
  {      
    $lngins=$db->prepare('UPDATE menu set class=:cl , type=:typse , link=:links , `text`=:txt , description=:sn , name=:nm , title=:ti , keyword=:keyw , url_tag=:utg , s_id=:sid , sub_id=:subid  where u_id=:uid and l_id=:lng2 ');
    $lnginscon=$lngins->execute(array( 'cl'=>s($_POST['cl']) , 'typse'=>s($_POST['typ']) , 'lng2'=>$luid[$i] , 'sn'=>s($_POST['desc'.$shortname[$i]]) , 'links'=>s($_POST['link'.$shortname[$i]]) , 'nm'=>s($_POST['names'.$shortname[$i]]) , 'ti'=>s($_POST['tit'.$shortname[$i]]) , 'keyw'=>s($_POST['key'.$shortname[$i]]) , 'txt'=>sck($_POST['txt'.$shortname[$i]]) , 'utg'=>s($_POST['ut'.$shortname[$i]])  , 'uid'=>$uid , 'sid'=>d(s($_POST['sids'])) , 'subid'=>s($_POST['subids'])));

  // echo  'typse-'.s($_POST['typ']).'<br>'.'lng2-'.$luid[$i].'<br>'.'sn-'.s($_POST['desc'.$shortname[$i]]).'<br>'.'links-'.s($_POST['link'.$shortname[$i]]).'<br>'.'nm-'.s($_POST['names'.$shortname[$i]]).'<br>'.'ti-'.s($_POST['tit'.$shortname[$i]]).'<br>'.'keyw-'.s($_POST['key'.$shortname[$i]]).'<br>'.'txt-'.s($_POST['txt'.$shortname[$i]]).'<br>'.'utg-'.s($_POST['ut'.$shortname[$i]]) .'<br>'.'uid-'.$uid.'<br>'.'sid-'.d(s($_POST['sids'])).'<br>'.'subid-'.s($_POST['subids'])."<br>".'UPDATE menu set type=:typse , link=:links , `text`=:txt , description=:sn , name=:nm , title=:ti , keyword=:keyw , url_tag=:utg , s_id=:sid , sub_id=:subid  where u_id=:uid and l_id=:lng2 ';
    if (!$lnginscon) 
    {
      $control=0;
    }
  }
  function alledit($db,$u_id,&$control,$type)
  { echo "<br>yeniye:".$u_id." kecid-<br>";
    $menuquer=$db->prepare('SELECT * FROM menu where sub_id=:subid ');
    $menuquer->execute(array('subid'=>s($u_id)));
    $counts=$menuquer->rowCount();
    if ($counts>0) 
    {
      while($menuquersor=$menuquer->fetch(PDO::FETCH_ASSOC))
      {
        $menuquerda=$db->prepare('UPDATE menu SET type=:typesa where u_id=:uid ');
        $delconta=$menuquerda->execute(array('uid'=>s($menuquersor['u_id']) , 'typesa'=>$type));
        if($delconta)
        { 
          alledit($db,$menuquersor['u_id'],$control,$type);            
        }
          else
        {
          echo 'a'.$control=0;
        }
      }
    }
    echo '<br>-yeni:'.$u_id.'-n sonu<br>';
  } 
  alledit($db,s($_GET['val']),$control,s($_POST['typ']));
  if (!in_array(s($_POST['subids']), $category[s($_POST['typ'])])) 
  {
    $control=0;
  }
  if ($control==1) 
  {
    $db->commit();
    header('Location:'.$site_url.'menu/'.$refer.'/456852/');
  }
  else
  {
    $db->rollBack();
    header('Location:'.$site_url.'menu/'.$refer.'/456456/');
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