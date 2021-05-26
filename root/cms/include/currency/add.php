<?php

$lngquera=$db->prepare('SELECT short_name as sn , org_name as orgn , u_id FROM lng ');

$lngquera->execute();

$catquer1=$db->prepare('SELECT u_id , long_name FROM currency where l_id="1"  ');

$catquer1->execute();

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

                <h2>ADD Country CONTENT </h2>

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

                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Long Name <span class="required">*</span>

                                    </label>

                                    <div class="col-md-6 col-sm-6 col-xs-12">

                                        <input name="lnames<?php echo $shortname[$i]; ?>" type="text" class="js-switch date-picker form-control col-md-7 col-xs-12" checked />

                                    </div>

                                </div>



                            </div>

                            <?php

                        }

                        ?>

                    </div>

                    <div class="form-group">

                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Short Name <span class="required">*</span>

                        </label>

                        <div class="col-md-6 col-sm-6 col-xs-12">

                            <input name="snames" type="text" class="js-switch date-picker form-control col-md-7 col-xs-12" checked />

                        </div>

                    </div>

                    <div class="form-group">

                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Picture <?php echo pxtostr($staticft['menu_pic']); ?>

                        </label>

                        <div class="col-md-6 col-sm-6 col-xs-12">

                            <input name="pic" class="date-picker form-control col-md-7 col-xs-12" type="file"/>

                        </div>

                    </div>
                    <div class="form-group">

                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Font Awesome for currency

                        </label>

                        <div class="col-md-6 col-sm-6 col-xs-12">

                            <input name="fa_icon" class="date-picker form-control col-md-7 col-xs-12" type="text"/>

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

    if ($_POST['popular']=='on') {
        $popular = 1;
    } else {
        $popular = 0;
    }

    $source=0;

    if($_FILES['pic']['tmp_name']!='')

    {

        echo 'salse';

        $unique1=rand(100,999);

        $unique2=rand(1000,9999);

        $unique3=rand(10000,99999);

        $unique=$unique1.$unique2.$unique3;

        $type=explode('.', $_FILES['pic']['name']);

        $type=end($type);

        if ($_FILES['pic']['size']<=600000 && in_array($_FILES['pic']['type'], ['jpg','jpeg','png','image/jpeg','image/jpg','image/png']) && $control=move_uploaded_file($_FILES['pic']['tmp_name'], 'images/'.$unique.'.'.$type))

        {

            echo $source=1;

        }

    }

    function d($post)

    {

        if ($post=='on')

        {

            return 0;

        }

        else

        {

            return 1;

        }

    }



    echo '<pre>';print_r($_POST);echo '</pre>';

    $lngquer=$db->prepare('SELECT MAX(u_id) as max FROM currency ');

    $lngquer->execute();

    $lngquersor=$lngquer->fetch(PDO::FETCH_ASSOC);

    $uid=$lngquersor['max']+1;

//    $ord=$lngquersor['maxo']+1;

    $control=1;

    if ($_POST['sids']=='on')

    {

        $s=0;

    }

    else

    {

        $s=1;

    }



    $db->begintransaction();

    for ($i=0; $i <$lngsay ; $i++)

    {

        if($_FILES['pic']['tmp_name']!='')

        {

            $lngins=$db->prepare('INSERT INTO currency set l_id="'.$luid[$i].'" , long_name="'.s($_POST["lnames".$shortname[$i]]).'" , short_name="'.s($_POST["snames"]).'" , u_id="'.$uid.'" , sign_photo="'.$unique.'.'.$type.'", sign_fa="'.$_POST['fa_icon'].'"');

            $lnginscon=$lngins->execute();

        }

        else

        {

            $lngins=$db->prepare('INSERT INTO currency set l_id="'.$luid[$i].'" , long_name="'.s($_POST["lnames".$shortname[$i]]).'" , short_name="'.s($_POST["snames"]).'" , u_id="'.$uid.'" , sign_fa="'.$_POST['fa_icon'].'"');

            $lnginscon=$lngins->execute();



        }

        if (!$lnginscon)

        {

            echo $control=0;

        }

    }

    if ($control==1)

    {

        echo "string";

        $db->commit();

        header('Location:'.$site_url.'currency/list/456852/');

        exit();

    }

    else

    {

        echo "\nPDO::errorInfo():\n";

        print_r($lngins->errorInfo());

        unlink('images/'.$unique.'.'.$type );

        $db->rollBack();

        header('Location:'.$site_url.'currency/list/456456/');

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