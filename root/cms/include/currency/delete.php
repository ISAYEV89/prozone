<?php



if ($_POST['delid'])

{

    $controller=1;

    echo $_POST['delid'];

    $menuquera=$db->prepare('SELECT * FROM currency where u_id=:uid ');

    $menuquera->execute(array('uid'=>s($_POST['delid'])));

    $count=$menuquera->rowCount();

    if ($count!=1)

    {

        //header('Location:'.$site_url.'/menu/list/');

    }

    $menuquerasor=$menuquera->fetch(PDO::FETCH_ASSOC);

    $db->begintransaction();

    $menuquerd=$db->prepare('DELETE FROM currency where u_id=:uid ');

    $delcont=$menuquerd->execute(array('uid'=>s($_POST['delid'])));

    if (!is_null($menuquerasor['sign_photo']))

    {

        if (!unlink('images/'.$menuquerasor['sign_photo']))

        {

            $controller=0;

        }

    }

    if($delcont)

    {	echo "<br>string";

        if ($controller==1)

        {

            echo "<br>thats okey";

            $db->commit();

            header('Location:'.$site_url.'currency/list/456852/');

        }

        else

        {

            $db->rollback();

            header('Location:'.$site_url.'currency/list/456456/');

        }

    }

    else

    {

        $db->rollback();

        header('Location:'.$site_url.'currency/list/456456/');

    }

}

else

{

    header('Location:'.$site_url.'currency/list/');

}

?>