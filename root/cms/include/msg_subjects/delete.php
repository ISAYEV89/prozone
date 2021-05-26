<?php



if ($_POST['delid'])

{

    $controller=1;

    echo $_POST['delid'];

    $db->begintransaction();

    $menuquerd=$db->prepare('DELETE FROM msg_subjects where u_id=:uid ');

    $delcont=$menuquerd->execute(array('uid'=>s($_POST['delid'])));

    if($delcont)
    {

            echo "<br>thats okey";

            $db->commit();

            header('Location:'.$site_url.'msg_subjects/list/456852/');


    }

    else

    {

        $db->rollback();

        header('Location:'.$site_url.'msg_subjects/list/456456/');

    }

}

else

{

    header('Location:'.$site_url.'msg_subjects/list/');

}

?>