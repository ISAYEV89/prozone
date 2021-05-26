<?php 
ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);
$categeriinc=array();
$categeriinc2=array();
$blogquera=$db->prepare('SELECT * FROM mehsul where u_id=:uid limit 1 ');
$blogquera->execute(array('uid'=>s($_GET['val'])));
$count=$blogquera->rowCount();
$blogquerasor=$blogquera->fetch(PDO::FETCH_ASSOC);
if (!$_GET['val'] or $count!=1) 
{
  header('Location:'.$site_url.'product/list/');
  exit();
}
$mud7=$db->prepare('SELECT * FROM mehsul_kateqoriya where m_u_id=:uid ');
$mud7->execute(array('uid'=>s($_GET['val'])));
//echo $mud7count=$mud7->rowCount();
while($mudft7=$mud7->fetch(PDO::FETCH_ASSOC))
{
  array_push($categeriinc2, $mudft7['kat_u_id']);
}
$mud6=$db->prepare('SELECT * FROM kateqoriyalar where l_id="1" ');
$mud6->execute();
$mud=$db->prepare('SELECT * FROM mehsul_olke where m_u_id=:uid ');
$mud->execute(array('uid'=>s($_GET['val'])));
$mudcount=$mud->rowCount();
while($mudft=$mud->fetch(PDO::FETCH_ASSOC))
{
  array_push($categeriinc, $mudft['o_u_id']);
}
$mud2=$db->prepare('SELECT * , mop.id as mopid FROM mehsul_olke_price mop , olkeler o where `mop`.`m_u_id`=:uid  and `mop`.`o_u_id`=`o`.`kat_id` and `o`.`l_id`="1" order by mop.id asc ');
$mud2->execute(array('uid'=>s($_GET['val'])));
$mud2count=$mud2->rowCount();
$lngquera=$db->prepare('SELECT short_name as sn , org_name as orgn , u_id FROM lng ');
$lngquera->execute();
$shortname=array();
$orgname=array();
$luid=array();
$catquer=$db->prepare('SELECT kat_id , name FROM olkeler where l_id="1" ');
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
        <h2>EDIT Product  </h2>
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
              $blogquers=$db->prepare('SELECT * FROM mehsul where u_id=:uid and l_id=:lid');
              $blogquers->execute(array('uid'=>s($_GET['val']) , 'lid'=>$luid[$i] ));
              $blogquerssor=$blogquers->fetch(PDO::FETCH_ASSOC);
            ?>
              <div id="<?php echo $orgname[$i]; ?>" class="w3-container city" style="display:none">
                <h2><?php echo $orgname[$i]; ?></h2>
                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12">Name <span class="required">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input value="<?php echo $blogquerssor['name'] ?>" name="names<?php echo $shortname[$i]; ?>" type="text" class="js-switch date-picker form-control col-md-7 col-xs-12"  />
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12">Description <span class="required">*</span></label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input value="<?php echo $blogquerssor['description'] ?>" name="desc<?php echo $shortname[$i]; ?>" type="text" class="js-switch date-picker form-control col-md-7 col-xs-12"  />
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12">Title <span class="required">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input value="<?php echo $blogquerssor['title'] ?>" name="tit<?php echo $shortname[$i]; ?>" type="text" class="js-switch date-picker form-control col-md-7 col-xs-12"  />
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12">Short title <span class="required">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input value="<?php echo $blogquerssor['stitle'] ?>" name="stit<?php echo $shortname[$i]; ?>" type="text" class="js-switch date-picker form-control col-md-7 col-xs-12"  />
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12">Keyword <span class="required">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input value="<?php echo $blogquerssor['keyword'] ?>" name="key<?php echo $shortname[$i]; ?>" type="text" class="js-switch date-picker form-control col-md-7 col-xs-12"  />
                  </div>
                </div>                
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="">
                        Add characteristics  
                    </label>
                    <?php 
                        $details = $db->prepare('select * from product_details where product_id = ? and l_id = ?');
                        $details->execute([$blogquerssor['u_id'],$blogquerssor['l_id']]);
                    if($details->rowCount() == 0){    
                    ?>    
                    <div class="col-md-6 col-sm-6 col-xs-12  increment<?php echo $blogquerssor['l_id'] ?>">
                            
                        <div class="input-group control-group"  >
                            <input type="text" name="char_title<?php echo $shortname[$i]; ?>[]" class="form-control" placeholder="Title">
                            <input type="text" id="" name="char_desc<?php echo $shortname[$i]; ?>[]"   class="form-control" placeholder="Description" />
                            <div class="input-group-btn">
                                <button class="btn btn-success btn-success-add<?php echo $blogquerssor['l_id'] ?>" type="button" ><i class="fa fa-plus" ></i>  Add</button>
							</div>
                            <br>
                        </div>
                        <div class="clone<?php echo $blogquerssor['l_id'] ?>" style="display:none;">
                            <div class="control-group input-group" style="margin-top:10px">
                                <input type="text" name="char_title<?php echo $shortname[$i]; ?>[]" class="form-control" placeholder="Title">
                                <input type="text" id="" name="char_desc<?php echo $shortname[$i]; ?>[]"   class="form-control" placeholder="Description"/>
                            
                                <div class="input-group-btn">
                                    <button class="btn btn-danger btn-danger-add" type="button"><i class="fa fa-trash"></i> Remove</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php }else
					{ 
                        $n = 0;
                    ?>
                    <div class="col-md-6 col-sm-6 col-xs-12 increment<?php echo $blogquerssor['l_id'] ?>">                        
                    <?php while($detail = $details->fetch(PDO::FETCH_ASSOC))
					{ $n++;
                    ?>
                        <?php if($n ==1){ ?>    
                        <div class="input-group control-group">
                            <input type="text" name="char_title<?php echo $shortname[$i]; ?>[]" class="form-control" placeholder="Title" value="<?php echo $detail['title'] ?>">
                            <input type="text" id="" name="char_desc<?php echo $shortname[$i]; ?>[]"   class="form-control" placeholder="Description" value="<?php echo $detail['description'] ?>" />
                            <div class="input-group-btn">
                                <button class="btn btn-success btn-success-add<?php echo $blogquerssor['l_id'] ?>" type="button" ><i class="fa fa-plus" ></i>  Add</button>
                            </div>
                            <br>
                        </div>
                        <?php 
						} 
						else
						{ ?>                            
                            <div class="control-group input-group" style="margin-top:10px">
                                <input type="text" name="char_title<?php echo $shortname[$i]; ?>[]" class="form-control" placeholder="Title" value="<?php echo $detail['title'] ?>">
                                <input type="text" id="" name="char_desc<?php echo $shortname[$i]; ?>[]"   class="form-control" placeholder="Description" value="<?php echo $detail['description'] ?>"/>                            
                                <div class="input-group-btn">
                                    <button class="btn btn-danger btn-danger-add" type="button"><i class="fa fa-trash"></i> Remove</button>
                                </div>
                            </div>
                        <?php 
						} 
						?>
                        <div class="clone<?php echo $blogquerssor['l_id'] ?>" style="display:none;">                            
                            <div class="control-group input-group" style="margin-top:10px">
                                <input type="text" name="char_title<?php echo $shortname[$i]; ?>[]" class="form-control" placeholder="Title">
                                <input type="text" id="" name="char_desc<?php echo $shortname[$i]; ?>[]" value=""  class="form-control" placeholder="Description"/>
                                <div class="input-group-btn">
                                    <button class="btn btn-danger btn-danger-add" type="button"><i class="fa fa-trash"></i> Remove</button>
                                </div>                                
                            </div>
                        </div>    
                    <?php 
					} ?>
                    </div>     
                    <?php 
				} ?>
                </div>
                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12">Description Product <span class="required">*</span>
                  </label>
                  <div class="col-md-9 col-sm-9 col-xs-12">
                    <textarea name="desc2<?php echo $shortname[$i]; ?>" ><?php echo $blogquerssor['description2'] ?></textarea>
                  </div>
                </div>
				<div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12">Description Product 2<span class="required">*</span>
                  </label>
                  <div class="col-md-9 col-sm-9 col-xs-12">
                    <textarea name="desc3<?php echo $shortname[$i]; ?>" ><?php echo $blogquerssor['description3'] ?></textarea>
                  </div>
                </div>
				<div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12">Youtube Title <span class="required">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input value="<?php echo $blogquerssor['youtube_title'] ?>" name="youtubet<?php echo $shortname[$i]; ?>" type="text" class=" form-control col-md-7 col-xs-12"  />
                  </div>
                </div>
				<div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12">Youtube <span class="required">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input value="<?php echo $blogquerssor['youtube'] ?>" name="youtube<?php echo $shortname[$i]; ?>" type="text" class=" form-control col-md-7 col-xs-12"  />
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
                      <input placeholder="price 1" name="prc1" type="number" value="<?php echo $blogquerasor['price_1']; ?>" class="js-switch date-picker form-control col-md-7 col-xs-12"  />
                  </div>
                  <div class="col-md-2 col-sm-2 col-xs-12">
                      <input placeholder="price 2" name="prc2" type="number" value="<?php echo $blogquerasor['price_2']; ?>" class="js-switch date-picker form-control col-md-7 col-xs-12"  />
                  </div>
                  <div class="col-md-2 col-sm-2 col-xs-12">
                      <input placeholder="price 3" name="prc3" type="number" value="<?php echo $blogquerasor['price_3']; ?>" class="js-switch date-picker form-control col-md-7 col-xs-12"  />
                  </div>
              </div>
          </div>       
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Shipping:<span class="required">*</span>
            </label>
            <div class="col-md-2 col-sm-2 col-xs-12">
              <input placeholder="shipping 1" name="ship1" type="number" value="<?php echo $blogquerasor['shipping_1']; ?>" class="js-switch date-picker form-control col-md-7 col-xs-12"  />
            </div>
            <div class="col-md-2 col-sm-2 col-xs-12">
              <input placeholder="shipping 2" name="ship2" type="number" value="<?php echo $blogquerasor['shipping_2']; ?>" class="js-switch date-picker form-control col-md-7 col-xs-12"  />
            </div>
            <div class="col-md-2 col-sm-2 col-xs-12">
              <input placeholder="shipping 3" name="ship3" type="number" value="<?php echo $blogquerasor['shipping_3']; ?>" class="js-switch date-picker form-control col-md-7 col-xs-12"  />
            </div>
          </div>  
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Point:<span class="required">*</span></label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input placeholder="Point" name="poin" type="text" value="<?php echo $blogquerasor['point']; ?>" class="js-switch date-picker form-control col-md-7 col-xs-12"  />
            </div>
          </div>  
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Piece:<span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input placeholder="Piece" name="pce" type="number" value="<?php echo $blogquerasor['int']; ?>" class="js-switch date-picker form-control col-md-7 col-xs-12"  />
            </div>
          </div>  
          <?php 
          $desak=0;
          while($mudft2=$mud2->fetch(PDO::FETCH_ASSOC))
          {
            $desak++;
            ?>
            <div class="form-group" style="<?php if($desak==1){ echo 'border-top: 1px dashed #000;';  } ?>">
              <label class="control-label col-md-3 col-sm-3 col-xs-12">Prices for <?php echo $mudft2['name']; ?>:<span class="required">*</span></label>
              <div class="col-md-2 col-sm-2 col-xs-12">
                <input placeholder="price 1" name="<?php echo $mudft2['mopid'].'-tp1'; ?>" type="number" value="<?php echo $mudft2['price_1']; ?>" class="js-switch date-picker form-control col-md-7 col-xs-12"  />
              </div>
              <div class="col-md-2 col-sm-2 col-xs-12">
                <input placeholder="price 2" name="<?php echo $mudft2['mopid'].'-tp2'; ?>" type="number" value="<?php echo $mudft2['price_2']; ?>" class="js-switch date-picker form-control col-md-7 col-xs-12"  />
              </div>
              <div class="col-md-2 col-sm-2 col-xs-12">
                <input placeholder="price 3" name="<?php echo $mudft2['mopid'].'-tp3'; ?>" type="number" value="<?php echo $mudft2['price_3']; ?>" class="js-switch date-picker form-control col-md-7 col-xs-12"  />
              </div>
            </div>
            <div class="form-group" style=" border-bottom: 1px dashed #000;">
              <label class="control-label col-md-3 col-sm-3 col-xs-12">Shipping for <?php echo $mudft2['name']; ?>:<span class="required">*</span>
              </label>
              <div class="col-md-2 col-sm-2 col-xs-12">
                <input placeholder="shipping 1" name="<?php echo $mudft2['mopid'].'-ship1'; ?>" type="number" value="<?php echo $mudft2['shipping_1']; ?>" class="js-switch date-picker form-control col-md-7 col-xs-12"  />
              </div>
              <div class="col-md-2 col-sm-2 col-xs-12">
                <input placeholder="shipping 2" name="<?php echo $mudft2['mopid'].'-ship2'; ?>" type="number" value="<?php echo $mudft2['shipping_2']; ?>" class="js-switch date-picker form-control col-md-7 col-xs-12"  />
              </div>
              <div class="col-md-2 col-sm-2 col-xs-12">
                <input placeholder="shipping 3" name="<?php echo $mudft2['mopid'].'-ship3'; ?>" type="number" value="<?php echo $mudft2['shipping_3']; ?>" class="js-switch date-picker form-control col-md-7 col-xs-12"  />
              </div>
               <input value="<?php echo $mudft2['mopid'] ?>" id="<?php echo $mudft2['mopid']; ?>" name="del[]"   type="checkbox" />
               <label style="color:red; width: 50px;" class="fa fa-trash fa-2x" for="<?php echo $mudft2['mopid']; ?>"> For:<?php echo $mudft2['name']; ?></label>
            </div> 
            <?php 
          }
          ?>
          <div id="freeplace">
              <label class="control-label col-md-3 col-sm-3 col-xs-12">Price for special country :<span class="required">*</span></label>
            <button id="loading" style="margin-left:10px; " onclick="addconprc();" type="button" class="btn btn-success" >Add</button>
            <input type="number" hidden="" value="0" name="asdf" readonly="" id="count" >
          </div>
		  <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Picture<span class="required">*</span></label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <img style="width: 200px;" src="<?php echo $site_url.'images/'.$blogquerasor['image_url'] ?>"  class="  col-md-7 col-xs-12" checked />
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Cover Picture <?php echo pxtostr($staticft['blog_cont_pic']); ?><span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input name="pic" class="date-picker form-control col-md-7 col-xs-12"  type="file">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">All country <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input name="alcc" <?php if($blogquerasor['all_country']==1){ echo 'checked=""';} ?> onchange="toggle_country();"  class="date-picker form-control col-md-7 col-xs-12 js-switch" type="checkbox">
            </div>
          </div>
          <div class="form-group" style="<?php if($blogquerasor['all_country']==1){ echo 'display: none;';}else{ echo 'display: block;'; } ?>" id="allcount"  >
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Select Countries</label>
            <div class="col-md-9 col-sm-9 col-xs-12">
              <select id="allcounts" name="cat1[]" <?php /* if($blogquerasor['all_country']==1){ echo 'disabled="true"';}else{ echo 'disabled="false"'; } */ ?>  style="width: 300px; border-radius:5px; margin:10px 0;" multiple data-plugin-selectTwo class="form-control populate">
                <?php
                while($catquerft=$catquer->fetch(PDO::FETCH_ASSOC))
                {
                ?>
                  <option <?php if(in_array($catquerft['kat_id'] , $categeriinc)){echo 'selected=""';} ?> value="<?php echo $catquerft['kat_id'] ?>" ><?php echo $catquerft['name'] ?></option>
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
                  <option <?php if(in_array($catquerft2['kat_id'] , $categeriinc2)){echo 'selected=""';} ?> value="<?php echo $catquerft2['kat_id'] ?>" ><?php echo $catquerft2['name'] ?></option>
                <?php 
                }
                ?>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Display <span class="required">*</span></label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input name="sids" <?php if($blogquerasor['s_id']==1){ echo 'checked=""';} ?> class="date-picker form-control col-md-7 col-xs-12 js-switch" type="checkbox">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Display  Home<span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input name="sids1" <?php if($blogquerasor['home']==1){ echo 'checked=""';} ?> class="date-picker form-control col-md-7 col-xs-12 js-switch" type="checkbox">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Show in registration shop's main page<span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input name="smp1" class="date-picker form-control col-md-7 col-xs-12 js-switch" type="checkbox" value="1" 
			  <?PHP if($blogquerasor['shops_mainpage']==1 or $blogquerasor['shops_mainpage']==3 or $blogquerasor['shops_mainpage']==5 or $blogquerasor['shops_mainpage']==7){echo 'checked="checked"';}?>>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Show in Signup(online) shop's main page<span class="required">*</span></label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input name="smp2" class="date-picker form-control col-md-7 col-xs-12 js-switch" type="checkbox" value="2"
			  <?PHP if($blogquerasor['shops_mainpage']==2 or $blogquerasor['shops_mainpage']==3 or $blogquerasor['shops_mainpage']==6 or $blogquerasor['shops_mainpage']==7){echo 'checked="checked"';}?>>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Show in commision shop's main page<span class="required">*</span></label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input name="smp3" class="date-picker form-control col-md-7 col-xs-12 js-switch" type="checkbox" value="4" 
			  <?PHP if($blogquerasor['shops_mainpage']==4 or $blogquerasor['shops_mainpage']==5 or $blogquerasor['shops_mainpage']==6 or $blogquerasor['shops_mainpage']==7){echo 'checked="checked"';}?>>
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
      data: { pp: "ppa", name: x , id: <?php echo s($_GET['val']);  ?> },
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
  document.getElementById('count').setAttribute("value", ""+konfuse+"");
  $.ajax({
    method: "POST",
    url: "<?php echo $site_url.'include/islem.php' ?>",
    data: { olk: "select" },
    success:function(data)
    {
        $('#freeplace').append("<div class='form-group' style='border-top: 1px dashed #000;' ><label class='control-label col-md-3 col-sm-3 col-xs-12'>Select Countries</label>  <div class='col-md-9 col-sm-9 col-xs-12'>    <select id='allcounts-"+konfuse+"' name='"+konfuse+"-addedcon'   style='width: 300px; border-radius:5px; margin:10px 0;'  data-plugin-selectTwo class='form-control '>    </select>  </div></div><div class='form-group' >  <label class='control-label col-md-3 col-sm-3 col-xs-12'>Prices :<span class='required'>*</span>  </label>  <div class='col-md-2 col-sm-2 col-xs-12'>    <input placeholder='price 1' name='"+konfuse+"-prc1' type='number'  class='js-switch date-picker form-control col-md-7 col-xs-12'  />  </div>  <div class='col-md-2 col-sm-2 col-xs-12'>    <input placeholder='price 2' name='"+konfuse+"-prc2' type='number'  class='js-switch date-picker form-control col-md-7 col-xs-12'  />  </div>  <div class='col-md-2 col-sm-2 col-xs-12'>    <input placeholder='price 3' name='"+konfuse+"-prc3' type='number'  class='js-switch date-picker form-control col-md-7 col-xs-12'  />  </div></div>          <div class='form-group' style='border-bottom: 1px double #000;'>  <label class='control-label col-md-3 col-sm-3 col-xs-12'>Shipping :<span class='required'>*</span>  </label>  <div class='col-md-2 col-sm-2 col-xs-12'>    <input placeholder='shipping 1' name='"+konfuse+"-shi1' type='number' class='js-switch date-picker form-control col-md-7 col-xs-12'  />  </div>  <div class='col-md-2 col-sm-2 col-xs-12'>    <input placeholder='shipping 2' name='"+konfuse+"-shi2' type='number' class='js-switch date-picker form-control col-md-7 col-xs-12'  />  </div>  <div class='col-md-2 col-sm-2 col-xs-12'>    <input placeholder='shipping 3' name='"+konfuse+"-shi3' type='number' class='js-switch date-picker form-control col-md-7 col-xs-12'  />  </div></div> ");
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
if (@$_POST['btn']) 
{
  $source=0;
  if($_FILES['pic']['tmp_name']=='')
  {
    print_r($_FILES);
  }
  if($_FILES['pic']['tmp_name']!='')
  {
    echo 'salse';
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
                                              'muid'=>s($_GET['val'])
                                              ));
        if (!$lnginsacon1) 
        {
          $lastcont=0;
        }
      }
    }
  }
  if (count($_POST['del'])>0) 
  {
    $mud4=$db->prepare('DELETE FROM mehsul_olke_price  where id in ('.arrtostr($_POST['del']).')  ');
    echo 'DELETE FROM mehsul_olke_price  where id in ('.arrtostr($_POST['del']).')  ';
    $mud4con=$mud4->execute();
    if (!$mud4con) 
    {
       print_r($mud4->errorInfo());
      $lastcont=0;
    }
  }
  $mud3=$db->prepare('SELECT * FROM mehsul_olke_price mop where `m_u_id`=:uid  ');
  $mud3->execute(array('uid'=>s($_GET['val'])));
  $mud3count=$mud->rowCount();
  if ($mud3count>0) 
  {
    $kmk=1;
  }
  else
  {
    $kmk=0;
  }
  $delete_query = $db->prepare('delete from product_details where product_id = ?');
  $delete_details = $delete_query->execute([s($_GET['val'])]);
  if(!$delete_details){
      $lastcont=0;
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
  for ($i=0; $i <$lngsay ; $i++) 
  {
    if($_FILES['pic']['tmp_name']!='')
    { 
      echo 'tttt';
      $lngins=$db->prepare('UPDATE mehsul set 
                                              `point`=:po ,
											  
                                              `shops_mainpage`=:smp , 
                                              home=:hm , 
                                              name=:nm , 
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
                                              different_country_price=:dcp
                                              where u_id=:uid and l_id=:lng2 ');   
      $lnginscon=$lngins->execute(array('po'=>s($_POST['poin']) , 
                                        'smp'=>$smp , 
                                        'hm'=>d($_POST['sids1']) ,  
                                        'pcee'=>s($_POST['pce']) ,  
                                        'nm'=>s($_POST['names'.$shortname[$i]]) , 
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
                                        'dcp'=>$kmk , 
                                        'uid'=>s($_GET['val']) , 
                                        'lng2'=>$luid[$i] 
                                       ));
      echo $unique.'.'.$type;
    }
    else
    {
      $lngins=$db->prepare('UPDATE mehsul set `point`=:po , 
											  
                                              `shops_mainpage`=:smp ,
                                              home=:hm , 
                                              name=:nm , 
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
                                              different_country_price=:dcp
                                              where u_id=:uid and l_id=:lng2 ');   
      $lnginscon=$lngins->execute(array(
										'smp'=>$smp , 
  
                                        'po'=>s($_POST['poin']) , 
                                        'hm'=>d($_POST['sids1']) ,   
                                        'pcee'=>s($_POST['pce']) , 
                                        'nm'=>s($_POST['names'.$shortname[$i]]) , 
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
                                        'dcp'=>$kmk , 
                                        'uid'=>s($_GET['val']) , 
                                        'lng2'=>$luid[$i] ));
    }
    if (!$lnginscon) 
    {
      $lastcont=0;
    }
    
    
    //echo '<br>count='.count($_POST['char_title'.$shortname[$i]]).'<br>';
    
    for ($j=0; $j<count($_POST['char_title'.$shortname[$i]]); $j++)
    {
        if($_POST['char_title'.$shortname[$i]][$j] !=''){
            $query = $db->prepare('insert into product_details set product_id = ?,l_id=?, title = ?,description = ?');
            $add = $query->execute([s($_GET['val']),$luid[$i],$_POST['char_title'.$shortname[$i]][$j],$_POST['char_desc'.$shortname[$i]][$j]]);
            if(!$add){
                $lastcont = 0;
            }
        }
    }
    
  }
  echo $_POST['sids'].d1($_POST['sids']).'-sids-hm-'.d($_POST['sids1']).$_POST['sids1'];
  if (is_null($_POST['cat2'])) 
  {
    $_POST['cat2']=array();
  }
  $delete=array_diff($categeriinc2,$_POST['cat2']);
  $insert=array_diff($_POST['cat2'],$categeriinc2);
  var_dump($_POST['cat2']);
  echo "<pre>";
  print_r($delete);
  echo "</pre>";echo "<pre>";
  print_r($insert);
  echo "</pre>";echo "<pre>"; 
  print_r($categeriinc2);
  echo "</pre>";  
  foreach ($insert as $key) 
  {
    $lnginss=$db->prepare('INSERT INTO mehsul_kateqoriya set kat_u_id=:caid, m_u_id=:coid');
    $lnginsscon=$lnginss->execute(array('coid'=>s($_GET['val']) , 'caid'=>s($key)));
    if (!$lnginsscon) 
    {
      $lastcont=0;
    }
  }
  foreach ($delete as $key) 
  {
    $lnginsd=$db->prepare('DELETE FROM mehsul_kateqoriya where kat_u_id=:caid and m_u_id=:coid');
    $lnginsdcon=$lnginsd->execute(array('coid'=>s($_GET['val']) , 'caid'=>s($key)));
    if (!$lnginsdcon) 
    {
     $lastcont=0;
    }
  }
  if ($_POST['alcc']=='') 
  {
    if (is_null($_POST['cat1'])) 
    {
      $_POST['cat1']=array();
    }
    $delete1=array_diff($categeriinc,$_POST['cat1']);
    $insert1=array_diff($_POST['cat1'],$categeriinc);  
    var_dump($_POST['cat1']);
    echo "<pre>";
    print_r($_POST['cat1']);
    echo "</pre>";
    foreach ($insert1 as $key) 
    {
      $lnginss1=$db->prepare('INSERT INTO mehsul_olke set o_u_id=:caid, m_u_id=:coid');
      $lnginsscon1=$lnginss1->execute(array('coid'=>s($_GET['val']) , 'caid'=>s($key)));
      if (!$lnginsscon1) 
      {
        $lastcont=0;
      }
    }
    foreach ($delete1 as $key) 
    {
      $lnginsd2=$db->prepare('DELETE FROM mehsul_olke where o_u_id=:caid and m_u_id=:coid');
      $lnginsdcon2=$lnginsd2->execute(array('coid'=>s($_GET['val']) , 'caid'=>s($key)));
      if (!$lnginsdcon2) 
      {
       $lastcont=0;
      }
    } 
  }
  if ($lastcont==1) 
  {
    if ($source==1) 
    { 
      if (is_file('images/'.$blogquerasor['image_url'])) 
      {
        unlink('images/'.$blogquerasor['image_url']);
      }
    }
   $db->commit();
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