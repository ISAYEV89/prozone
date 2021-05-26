<pre>
<?PHP
	//print_r($_SESSION['postdata']);
	
	
	foreach($_SESSION['postdata'] as $key=>$value)
		{
			$arr=explode('|',$key);
			if(count($arr)>1)			
			{
				
			echo $key.'=>'.$value.'<br>';
				if($arr[0]=='v' and $value!=0)
				{
					if($arr[1]==0) //productun all country qiymetleri istifade olunur
					{
						$x='NULL';
					}
					else
					{
						$x=$arr[1];
						
					}
					$ty='t|'.$arr[1].'|'.$arr[2];
					
					$sql='insert into mehsul_discount (`m_u_id`,`start`,`end`,`type`,`value`,`shop_type`,`mop_id`,`s_id`) values (:muid , :start, :end , :type, :value, :shop_type, :mop, :sid)';
					$data=ARRAY('muid'=>$_SESSION['postdata']['product'] , 'start'=>$_SESSION['postdata']['sd'], 'end'=>$_SESSION['postdata']['ed'] , 'type'=>$_SESSION['postdata'][$ty], 'value'=>$value, 'shop_type'=>$arr[2], 'mop'=>$x, 'sid'=>'2');
					
					try
					{
						$db->prepare($sql)->execute($data);
					}
					catch(PDOException $e)

					{

						echo $e->getMessage();

					}
				}
			}
			
		}

?>
</pre>
<script>
	location.replace('<?PHP echo $site_url ;?>discount/list/');
</script>