<?php 
ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);
$mud6=$db->prepare('SELECT * FROM kateqoriyalar where l_id="1" ');
$mud6->execute();

$lngquera=$db->prepare('SELECT short_name as sn , org_name as orgn , u_id FROM lng ');
$lngquera->execute();
$shortname=array();
$orgname=array();
$luid=array();

$catquer=$db->prepare('SELECT kat_id , name, currency_id FROM olkeler where l_id="1" ');
$catquer->execute();
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
        <h2>ADD product  </h2>
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
                    <input name="names<?php echo $shortname[$i]; ?>" type="text" class=" date-picker form-control col-md-7 col-xs-12"  />
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12">Description <span class="required">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input name="desc<?php echo $shortname[$i]; ?>" type="text" class="js-switch date-picker form-control col-md-7 col-xs-12"  />
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12">Title <span class="required">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input name="tit<?php echo $shortname[$i]; ?>" type="text" class="js-switch date-picker form-control col-md-7 col-xs-12"  />
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12">Short title <span class="required">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input name="stit<?php echo $shortname[$i]; ?>" type="text" class="js-switch date-picker form-control col-md-7 col-xs-12"  />
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12">Keyword <span class="required">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input name="key<?php echo $shortname[$i]; ?>" type="text" class="js-switch date-picker form-control col-md-7 col-xs-12"  />
                  </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="">
                        Add characteristics  
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12 increment<?php echo $i+1; ?>">                           
                        <div class="input-group control-group">
                            <input type="text" name="char_title<?php echo $shortname[$i]; ?>[]" class="form-control" placeholder="Title">
                            <input type="text" id="" name="char_desc<?php echo $shortname[$i]; ?>[]"   class="form-control" placeholder="Description" />
                            <div class="input-group-btn">
                                <button class="btn btn-success btn-success-add<?php echo $i+1; ?>" type="button" ><i class="fa fa-plus" ></i>  Add</button>
							</div>
                            <br>
                        </div>
                        <div class="clone<?php echo $i+1; ?>" style="display:none;">                            
                            <div class="control-group input-group" style="margin-top:10px">
                                <input type="text" name="char_title<?php echo $shortname[$i]; ?>[]" class="form-control" placeholder="Title">
                                <input type="text" id="" name="char_desc<?php echo $shortname[$i]; ?>[]"   class="form-control" placeholder="Description"/>                            
                                <div class="input-group-btn">
                                    <button class="btn btn-danger btn-danger-add" type="button"><i class="fa fa-trash"></i> Remove</button>
                                </div>                                
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12">Description Product <span class="required">*</span>
                  </label>
                  <div class="col-md-9 col-sm-9 col-xs-12">
                    <textarea name="desc2<?php echo $shortname[$i]; ?>" ></textarea>
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12">Description Product 2<span class="required">*</span>
                  </label>
                  <div class="col-md-9 col-sm-9 col-xs-12">
                    <textarea name="desc3<?php echo $shortname[$i]; ?>" ></textarea>
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12">Youtube title<span class="required">*</span>
                  </label>
                  <div class="col-md-9 col-sm-9 col-xs-12">
                   <input name="youtubet<?php echo $shortname[$i]; ?>" type="text" class=" form-control col-md-7 col-xs-12"  />
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12">Youtube link<span class="required">*</span>
                  </label>
                  <div class="col-md-9 col-sm-9 col-xs-12">
                   <input name="youtube<?php echo $shortname[$i]; ?>" type="text" class=" form-control col-md-7 col-xs-12"  />
                  </div>
                </div>
              </div>
			  <?php
            }
            ?>
		</div>       
          <div class="form-group">
              <div class="row">
                  <div class="col-md-offset-3">
                      <div style="margin-right: 4%; margin-left: 6%;" class="col-md-2 col-sm-2 col-xs-12">
                          <h4>E-shop</h4>
                      </div>
                      <div style="margin-right: 5%" class="col-md-2 col-sm-2 col-xs-12">
                          <h4>
                              Registration
                          </h4>
                      </div>
                      <div class="col-md-2 col-sm-2 col-xs-12">
                          <h4>Commision shop</h4>
                      </div>
                  </div>
              </div>
				<div class="row">
					<label class="control-label col-md-3 col-sm-3 col-xs-12">Prices:<span class="required">*</span>
					</label>
					<div class="col-md-2 col-sm-2 col-xs-12">
						<input placeholder="price 1" name="prc1" type="number"  class="js-switch date-picker form-control col-md-7 col-xs-12"  />
					</div>
					<div class="col-md-2 col-sm-2 col-xs-12">
						<input placeholder="price 2" name="prc2" type="number"  class="js-switch date-picker form-control col-md-7 col-xs-12"  />
					</div>
					<div class="col-md-2 col-sm-2 col-xs-12">
						<input placeholder="price 3" name="prc3" type="number"  class="js-switch date-picker form-control col-md-7 col-xs-12"  />
					</div>
				</div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Shipping:<span class="required">*</span>
            </label>
            <div class="col-md-2 col-sm-2 col-xs-12">
              <input placeholder="shipping 1" name="ship1" type="number" class="js-switch date-picker form-control col-md-7 col-xs-12"  />
            </div>
            <div class="col-md-2 col-sm-2 col-xs-12">
              <input placeholder="shipping 2" name="ship2" type="number" class="js-switch date-picker form-control col-md-7 col-xs-12"  />
            </div>
            <div class="col-md-2 col-sm-2 col-xs-12">
              <input placeholder="shipping 3" name="ship3" type="number" class="js-switch date-picker form-control col-md-7 col-xs-12"  />
            </div>
          </div> 
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Point:<span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input placeholder="Point" name="poin" type="text" class=" date-picker form-control col-md-7 col-xs-12"  />
            </div>
          </div>   
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Piece:<span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input placeholder="Piece" name="pce" type="number" class=" date-picker form-control col-md-7 col-xs-12"  />
            </div>
          </div>  
          <div id="freeplace">
              <label class="control-label col-md-3 col-sm-3 col-xs-12">Price for special country :<span class="required">*</span>
              </label>
            <button id="loading" style="margin-left:10px; " onclick="addconprc();" type="button" class="btn btn-success" >Add</button>
            <input type="number" hidden="" value="0" name="asdf" readonly="" id="count" >            
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Cover Picture <?php echo pxtostr($staticft['blog_cont_pic']); ?><span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input name="pic" class="date-picker form-control col-md-7 col-xs-12" required="" type="file">
            </div>
          </div>
          <!--div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Content Picture <?php echo pxtostr($staticft['blog_cont_img']); ?><span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input name="pics[]" multiple="" class="date-picker form-control col-md-7 col-xs-12" required=""  type="file">
            </div>
          </div !-->
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">All country <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input name="alcc" onchange="toggle_country();"  class="date-picker form-control col-md-7 col-xs-12 js-switch" type="checkbox">
            </div>
          </div>
          <div class="form-group" style="display: block;" id="allcount"  >
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Select Countries</label>
            <div class="col-md-9 col-sm-9 col-xs-12">
              <select id="allcounts" name="cat1[]"  style="width: 300px; border-radius:5px; margin:10px 0;" multiple data-plugin-selectTwo class="form-control populate">
                <?php
                while($catquerft=$catquer->fetch(PDO::FETCH_ASSOC))
                {
                    $currency = $db->prepare("SELECT * FROM currency WHERE u_id=:uid AND l_id=:lid");
                    $currency->execute(['uid'=>$catquerft['currency_id'], 'lid'=>'1']);
                    $cur = $currency->fetch(PDO::FETCH_ASSOC);
                ?>
                  <option value="<?php echo $catquerft['kat_id'] ?>" ><?php echo $catquerft['name'] ?>&nbsp;<?php echo "<i class='".$cur['sign_fa']."'></i>"; ?></option>
                <?php
                }
                ?>
              </select>
            </div>
          </div>
          <div class="form-group">

            <label class="control-label col-md-3 col-sm-3 col-xs-12">Select Category</label>

            <div class="col-md-9 col-sm-9 col-xs-12">

              <select id="somescountry" name="cat2[]" style="width: 300px; border-radius:5px; margin:10px 0;" multiple data-plugin-selectTwo class="form-control populate">

                <?php 

                while($catquerft2=$mud6->fetch(PDO::FETCH_ASSOC))

                {

                ?>

                  <option value="<?php echo $catquerft2['kat_id'] ?>" ><?php echo $catquerft2['name'] ?></option>

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

              <input checked="" name="sids" class="date-picker form-control col-md-7 col-xs-12 js-switch" type="checkbox">

            </div>

          </div>



          <div class="form-group">

            <label class="control-label col-md-3 col-sm-3 col-xs-12">Display  Home<span class="required">*</span>

            </label>

            <div class="col-md-6 col-sm-6 col-xs-12">

              <input name="sids1" class="date-picker form-control col-md-7 col-xs-12 js-switch" type="checkbox" value=1>

            </div>

          </div>

          <div class="form-group">

            <label class="control-label col-md-3 col-sm-3 col-xs-12">Show in registration shop's main page<span class="required">*</span>

            </label>

            <div class="col-md-6 col-sm-6 col-xs-12">

              <input name="smp1" class="date-picker form-control col-md-7 col-xs-12 js-switch" type="checkbox" value="1">

            </div>

          </div>

          <div class="form-group">

            <label class="control-label col-md-3 col-sm-3 col-xs-12">Show in Signup(online) shop's main page<span class="required">*</span>

            </label>

            <div class="col-md-6 col-sm-6 col-xs-12">

              <input name="smp2" class="date-picker form-control col-md-7 col-xs-12 js-switch" type="checkbox" value="2">

            </div>

          </div>

          <div class="form-group">

            <label class="control-label col-md-3 col-sm-3 col-xs-12">Show in commision shop's main page<span class="required">*</span>

            </label>

            <div class="col-md-6 col-sm-6 col-xs-12">

              <input name="smp3" class="date-picker form-control col-md-7 col-xs-12 js-switch" type="checkbox" value="4">

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



    CKEDITOR.replace( '<?php echo "desc2".$shortname[$i] ?>' );
    CKEDITOR.replace( '<?php echo "desc3".$shortname[$i] ?>' );



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



      data: { pp: "ppa", name: x  },



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

var konfuse=1;

function addconprc()

{

    $('#loading').addClass('disabled');



  //document.getElementById('count').removeAttribute("value");

  document.getElementById('count').setAttribute("value", ""+konfuse+"");

  $.ajax({

    method: "POST",

    url: "<?php echo $site_url.'include/islem.php' ?>",

    data: { olk: "select" },

    success:function(data)

    {
        $('#freeplace').append("<div class='form-group' style='border-top: 1px dashed #000;' ><label class='control-label col-md-3 col-sm-3 col-xs-12'>Select Countries</label>  <div class='col-md-9 col-sm-9 col-xs-12'>    <select id='allcounts-"+konfuse+"' name='"+konfuse+"-addedcon'   style='width: 300px; border-radius:5px; margin:10px 0;'  data-plugin-selectTwo class='form-control '>    </select>  </div></div><div class='form-group' >  <label class='control-label col-md-3 col-sm-3 col-xs-12'>Prices :<span class='required'>*</span>  </label>  <div class='col-md-2 col-sm-2 col-xs-12'>    <input placeholder='price 1' name='"+konfuse+"-prc1' type='number'  class='js-switch date-picker form-control col-md-7 col-xs-12'  />  </div>  <div class='col-md-2 col-sm-2 col-xs-12'>    <input placeholder='price 2' name='"+konfuse+"-prc2' type='number'  class='js-switch date-picker form-control col-md-7 col-xs-12'  />  </div>  <div class='col-md-2 col-sm-2 col-xs-12'>    <input placeholder='price 3' name='"+konfuse+"-prc3' type='number'  class='js-switch date-picker form-control col-md-7 col-xs-12'  />  </div></div>          <div class='form-group' style='border-bottom: 1px double #000;'>  <label class='control-label col-md-3 col-sm-3 col-xs-12'>Shipping :<span class='required'>*</span>  </label>  <div class='col-md-2 col-sm-2 col-xs-12'>    <input placeholder='shipping 1' name='"+konfuse+"-shi1' type='number' class='js-switch date-picker form-control col-md-7 col-xs-12'  />  </div>  <div class='col-md-2 col-sm-2 col-xs-12'>    <input placeholder='shipping 2' name='"+konfuse+"-shi2' type='number' class='js-switch date-picker form-control col-md-7 col-xs-12'  />  </div>  <div class='col-md-2 col-sm-2 col-xs-12'>    <input placeholder='shipping 3' name='"+konfuse+"-shi3' type='number' class='js-switch date-picker form-control col-md-7 col-xs-12'  />  </div></div> ");
      //alert("allcounts-"+konfuse+data);

      document.getElementById("allcounts-"+konfuse).innerHTML="'"+data+"'";

      konfuse+=1;

      $('#loading').removeClass('disabled');

    }

  })

}

</script>



<script>

function toggle_country()

{

  if (document.getElementById('allcount').style.display=='none')

  {

    document.getElementById('allcount').style.display='block';

  }

  else  if (document.getElementById('allcount').style.display=='block')

  {

    document.getElementById('allcount').style.display='none';

  }


}



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

$(document).ready(function() {

    $(".btn-success-add1").click(function(){
        var html = $(".clone1").html();
        $(".increment1").append(html);
    });
    $(".btn-success-add2").click(function(){
        var html = $(".clone2").html();
        $(".increment2").append(html);
    });
    $(".btn-success-add3").click(function(){
        var html = $(".clone3").html();
        $(".increment3").append(html);
    });

    $("body").on("click",".btn-danger-add",function(){
        $(this).parents(".control-group").remove();
    });

});

</script>

<?php

function d($post)

{

  if ($post=='on') 

  {

    return 1;

  }

  else

  {

    return NULL;

  }

}



function d2($post,$post1,$post2)

{

  if ($post!='' or $post1!='' or $post2!='') 

  {

    return 1;

  }

  else

  {

    return 0;

  }

}



function d1($post)

{

  if ($post=='on') 

  {

    return 1;

  }

  else

  {

    return 0;

  }

}



function donull($post)

{

  if ($post=='') 

  {

    $s=NULL;

  }

  else

  {

    $s=$post;

  }

  return $s;

}

function generateRandomString($length) {
    $characters = '0123456789';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}


if (@$_POST['btn']) 

{
  $track_code = generateRandomString(13);   

  $lngquer1=$db->prepare('SELECT MAX(u_id) as max , MAX(ordering) as maxo FROM mehsul ');

  $lngquer1->execute(); 

  $lngquersor1=$lngquer1->fetch(PDO::FETCH_ASSOC);

  $uid=$lngquersor1['max']+1;

  $ord=$lngquersor1['maxo']+10;

  $source=0;

  if($_FILES['pic']['tmp_name']=='')

  {

    print_r($_FILES);

  }

  if($_FILES['pic']['tmp_name']!='')

  {

    echo 'false';

    $unique1=rand(100,999);

    $unique2=rand(1000,9999);

    $unique3=rand(10000,99999);

    $unique=$unique1.$unique2.$unique3;

    $type=explode('.', $_FILES['pic']['name']);

    $type=end($type);

    if ($_FILES['pic']['size']<=600000 && in_array($_FILES['pic']['type'], ['jpg','jpeg','png','image/jpeg','image/jpg','image/png']) && $PCcontrol=move_uploaded_file($_FILES['pic']['tmp_name'], 'images/'.$unique.'.'.$type)) 

    {

      echo $source=1;

    }

  }

  $db->begintransaction();

  $lastcont=1;

  if ($_POST['asdf']>0) 

  {

    for ($i=0; $i <$_POST['asdf'] ; $i++) 

    { 

      if($_POST[($i+1).'-addedcon']!='')

      {

        $lnginsa1=$db->prepare('INSERT INTO mehsul_olke_price set price_1=:pr1, price_2=:pr2, price_3=:pr3, shipping_1=:ship1 , shipping_2=:ship2 , shipping_3=:ship3 ,  o_u_id=:ouid ,  m_u_id=:muid  ');

        $lnginsacon1=$lnginsa1->execute(array('pr1'=>s($_POST[($i+1).'-prc1']),

                                              'pr2'=>s($_POST[($i+1).'-prc2']),

                                              'pr3'=>s($_POST[($i+1).'-prc3']),

                                              'ship1'=>s($_POST[($i+1).'-shi1']), 

                                              'ship2'=>s($_POST[($i+1).'-shi2']), 

                                              'ship3'=>s($_POST[($i+1).'-shi3']), 

                                              'ouid'=>s($_POST[($i+1).'-addedcon']),

                                              'muid'=>$uid

                                              ));

        if (!$lnginsacon1) 

        {

          $lastcont=0;

        }

      }

    }

  }



  if ($_POST['alcc']=='on') 

  {

    $kmk=1;

  }

  else

  {

    $kmk=0;

  }
  //creating value for shopsmain page display***********************************************
  $yt=1;
  $smp=0;
  while($yt<=3)
  {
	  $x='smp'.$yt;
	  if($_POST[$x]){$smp+=$_POST[$x];}
	  $yt++;
  }
  //****************************************************************************************
echo $smp;
  for ($i=0; $i <$lngsay ; $i++) 

  {

    if($_FILES['pic']['tmp_name']!='')

    { 

      echo 'tttt';

      $lngins=$db->prepare('INSERT INTO mehsul set 
												`shops_mainpage`=:smp , 
												
												`point`=:po , 

                                              home=:hm , 

                                              name=:nm , 
                                              
                                              track_code=:tr_code,

                                              title=:ti , 

                                              `int`=:pcee , 

                                              stitle=:tis  , 

                                              keyword=:key , 

                                              `description`=:dc , 

                                              description2=:dc2  , 

                                              description3=:dc3  ,  

                                              youtube_title=:youtt  ,   

                                              youtube=:yout  , 

                                              image_url=:iu , 

                                              s_id=:sid ,

                                              price_1=:pr1 , 

                                              `price_2`=:pr2 , 

                                              price_3=:pr3  , 

                                              shipping_1=:ship1 , 

                                              shipping_2=:ship2 ,

                                              `shipping_3`=:ship3 , 

                                              all_country=:ac  , 

                                              different_country_price=:dcp ,

                                              u_id=:uid ,

                                              ordering=:ord,

                                              l_id=:lng2 ');   



      $lnginscon=$lngins->execute(array('po'=>s($_POST['poin']) , 

                                        'smp'=>$smp , 

                                        'hm'=>$_POST['sids1'] ,  

                                        'pcee'=>s($_POST['pce']) ,  

                                        'nm'=>s($_POST['names'.$shortname[$i]]) ,
                                        
                                        'tr_code'=>$track_code, 

                                        'ti'=>s($_POST['tit'.$shortname[$i]]) ,

                                        'tis'=>s($_POST['stit'.$shortname[$i]]) ,

                                        'key'=>s($_POST['key'.$shortname[$i]]) , 

                                        'dc'=>s($_POST['desc'.$shortname[$i]]) ,  

                                        'dc2'=>$_POST['desc2'.$shortname[$i]] , 

                                        'dc3'=>$_POST['desc3'.$shortname[$i]] ,

                                        'youtt'=>$_POST['youtubet'.$shortname[$i]] ,

                                        'yout'=>$_POST['youtube'.$shortname[$i]] ,

                                        'iu'=>$unique.'.'.$type ,

                                        'sid'=>d1($_POST['sids']) ,  

                                        'pr1'=>s($_POST['prc1']) ,   

                                        'pr2'=>s($_POST['prc2']) ,   

                                        'pr3'=>s($_POST['prc3']) ,   

                                        'ship1'=>s($_POST['ship1']) ,   

                                        'ship2'=>s($_POST['ship2']) ,  

                                        'ship3'=>s($_POST['ship3']) ,

                                        'ac'=>d1($_POST['alcc']) ,  

                                        'dcp'=>d2(@$_POST['1-addedcon'],@$_POST['2-addedcon'],@$_POST['3-addedcon']) ,  

                                        'ord'=>$ord ,

                                        'uid'=>$uid , 

                                        'lng2'=>$luid[$i] 

                                       ));

      echo $unique.'.'.$type;

    }

    else

    {

      $lngins=$db->prepare('INSERT INTO mehsul set `point`=:po , 

                                             `shops_mainpage`=:smp , 

                                              home=:hm , 

                                              name=:nm , 
                                              
                                              track_code=:tr_code,

                                              title=:ti , 

                                              `int`=:pcee , 

                                              stitle=:tis  , 

                                              keyword=:key , 

                                              `description`=:dc , 

                                              description2=:dc2  , 

                                              description3=:dc3  ,  

                                              youtube_title=:youtt  , 

                                              youtube=:yout  , 

                                              s_id=:sid , 

                                              price_1=:pr1 , 

                                              `price_2`=:pr2 , 

                                              price_3=:pr3  , 

                                              shipping_1=:ship1 , 

                                              shipping_2=:ship2 ,

                                              `shipping_3`=:ship3 , 

                                              all_country=:ac  , 

                                              different_country_price=:dcp ,

                                              u_id=:uid ,

                                              ordering=:ord,

                                              l_id=:lng2 ');   

      $lnginscon=$lngins->execute(array('po'=>s($_POST['poin']) , 

                                        'smp'=>$smp , 

                                        'hm'=>$_POST['sids1'] , 

                                        'pcee'=>s($_POST['pce']) ,  

                                        'nm'=>s($_POST['names'.$shortname[$i]]) , 
                                        
                                        'tr_code'=>$track_code,

                                        'ti'=>s($_POST['tit'.$shortname[$i]]) ,

                                        'tis'=>s($_POST['stit'.$shortname[$i]]) ,

                                        'key'=>s($_POST['key'.$shortname[$i]]) , 

                                        'dc'=>s($_POST['desc'.$shortname[$i]]) ,  

                                        'dc2'=>$_POST['desc2'.$shortname[$i]] ,  

                                        'dc3'=>$_POST['desc3'.$shortname[$i]] ,  

                                        'youtt'=>$_POST['youtubet'.$shortname[$i]] ,

                                        'yout'=>$_POST['youtube'.$shortname[$i]] ,

                                        'sid'=>d1($_POST['sids']) ,  

                                        'pr1'=>s($_POST['prc1']) ,   

                                        'pr2'=>s($_POST['prc2']) ,   

                                        'pr3'=>s($_POST['prc3']) ,   

                                        'ship1'=>s($_POST['ship1']) ,   

                                        'ship2'=>s($_POST['ship2']) ,  

                                        'ship3'=>s($_POST['ship3']) ,

                                        'ac'=>d1($_POST['alcc']) ,  

                                        'dcp'=>d2($_POST['1-addedcon'],$_POST['2-addedcon'],$_POST['3-addedcon']) , 

                                        'ord'=>$ord ,

                                        'uid'=>$uid , 

                                        'lng2'=>$luid[$i] ));

    }

    if (!$lnginscon) 

    {

      $lastcont=0;

    }
    for ($j=0; $j<count($_POST['char_title'.$shortname[$i]]); $j++)
    {
        if($_POST['char_title'.$shortname[$i]][$j] !=''){
            $query = $db->prepare('insert into product_details set product_id = ?,l_id=?, title = ?,description = ?');
            $add = $query->execute([$uid,$luid[$i],$_POST['char_title'.$shortname[$i]][$j],$_POST['char_desc'.$shortname[$i]][$j]]);
            if(!$add){
                $lastcont = 0;
            }
        }
    }

  }

  echo $_POST['sids'].d1($_POST['sids']).'-sids-hm-'.d($_POST['sids1']).$_POST['sids1'];

//echo count($_POST['cat1']).'~~';

  for ($i=0; $i<count($_POST['cat2']); $i++) 

  {

    $lnginss=$db->prepare('INSERT INTO mehsul_kateqoriya set kat_u_id=:caid, m_u_id=:coid');

    $lnginsscon=$lnginss->execute(array('coid'=>s($uid) , 'caid'=>s($_POST['cat2'][$i])));

    if (!$lnginsscon) 

    {

      $lastcont=0;

    }

  }



  if ($_POST['alcc']=='') 

  {



    for ($i=0; $i<count($_POST['cat1']); $i++) 

    {

      $lnginss1=$db->prepare('INSERT INTO mehsul_olke set o_u_id=:caid, m_u_id=:coid');

      $lnginsscon1=$lnginss1->execute(array('coid'=>s($uid) , 'caid'=>s($_POST['cat1'][$i])));

      if (!$lnginsscon1) 

      {

        $lastcont=0;

      }

    }

  }

  if ($lastcont==1) 

  {

    $db->commit();

    print_r($lngins->errorInfo());
    header('Location:'.$site_url.'product/list/456852/');

    exit();

  }

  else

  {

    $db->rollBack();

    print_r($lngins->errorInfo());

    header('Location:'.$site_url.'product/list/456456/');

    exit();

  }

}



?>