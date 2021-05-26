<?php 

$id=$_GET['val'];





//timelari duzgun formata saliriq***********************************
$sd=$b['start'];
$ed=$b['end'];


$a=explode(' ',$sd);
$b2=$a[0];
$c=explode('/',$b2);

$sd=$c[0].'-'.$c[1].'-'.$c[2].' '.$a[1];


$a=explode(' ',$ed);
$b2=$a[0];
$c=explode('/',$b2);

$ed=$c[0].'-'.$c[1].'-'.$c[2].' '.$a[1];
//echo'<pre>';
//print_r($_POST);
//echo'</pre>';
//******************************************************************


if($_POST['sid']=='on')
{
	$sid=1;
}
else
{
	$sid=4;
}


$sql='update  mehsul_discount set `start`=:start,`end`=:end,`value`=:value,`s_id`=:sid, `type`=:type where id=:id';
$data=ARRAY('start'=>$_POST['sd'], 'end'=>$_POST['ed'] , 'value'=>$_POST['value'], 'type'=>$_POST['type'],   'sid'=>$sid,   'id'=>$id);

try
{
	$db->prepare($sql)->execute($data);
}
catch(PDOException $e)

{

	echo $e->getMessage();

}

?>
<script>
	location.replace('<?PHP echo $site_url ;?>discount/list/');
</script>