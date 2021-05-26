<?php

if ($_POST['change_order'])

{

    $db->begintransaction();

    $lngins=$db->prepare('UPDATE olkeler set ordering=:ord  where u_id=:udi ');

    $lnginscon=$lngins->execute(array('ord'=>s($_POST['this']) , 'udi'=>s($_POST['us_ids']) ));

    if ($lnginscon)

    {

        $db->commit();

        header('Location:'.$site_url.'country/list/456852/');

    }

    else

    {

        $db->rollBack();

        header('Location:'.$site_url.'country/list/456456/');

    }

}

$blogquer=$db->prepare('SELECT * FROM currency WHERE l_id=1 order by long_name asc');

$blogquer->execute();

?>

<div class="col-md-14 col-sm-14 col-xs-14">

    <?php

    if ($_GET['val']=='456852')

    {

        ?>

        <br></br>

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

        <br></br>

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

            <h2>Countries LIST </h2><a style="float: right;" class="btn btn-success" href="<?php echo $site_url.'currency/add/' ?>"><i class="fa fa-plus"></i> Əlavə et </a>

            <div class="clearfix"></div>

        </div>

        <div class="x_content">

            <table id="datatable" class="table table-striped table-bordered">

                <thead>

                <tr>

                    <th>ID</th>

                    <th>Name</th>
                    <th>Short Name</th>
                    <th>Icon</th>
                    <th>FA Icon</th>
                    <th>DO</th>


                </tr>

                </thead>

                <tbody>

                <?php

                while ($blogquersor=$blogquer->fetch(PDO::FETCH_ASSOC))

                {

                    ?>

                    <tr>

                        <!-- <td><?php /* echo substr($blogquersor['kat_id'], 0,10); */ ?></td> -->


                        <td><?php echo $blogquersor['id']; ?></td>

                        <td><?php echo $blogquersor['long_name']; ?></td>
                        <td><?php echo $blogquersor['short_name']; ?></td>

                        <td><img style="width: 35px;" src="<?php echo $site_url.'images/'.$blogquersor['sign_photo']; ?>"></td>
                        <td><i class="<?php echo $blogquersor['sign_fa']; ?>"></i></td>

                        <td>

                            <form style=" float: right;" method="POST" action="<?php echo $site_url.$state.'delete/' ?>">

                                <input type="hidden" name="delid" value="<?php echo $blogquersor['u_id'] ?>">

                                <button type="button"  onclick="dsomo(this);" name="dbtn"  style="color: red; background-color: rgba(0,0,0,0); border:none;" href="">

                                    <i class="fa fa-trash fa-2x" ></i>

                                </button>

                            </form>

                            <!--               <a style="margin-right: 5px; float: right;" href="<?php echo $site_url.'currency/edit_photo/'.$blogquersor['kat_id'].'/' ?>">

                <i class="fa fa-edit fa-2x" ></i>

              </a> -->

                            <a style="color:green; margin-right: 14px; float: right;" href="<?php echo $site_url.'currency/edit/'.$blogquersor['u_id'].'/' ?>">

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