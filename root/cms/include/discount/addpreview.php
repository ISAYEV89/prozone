<?PHP

//print_r($_POST);
$_SESSION['postdata']=$_POST;
$id=$_POST['product'];
$sd=$_POST['sd'];
$ed=$_POST['ed'];

$_SESSION['postdata']['proid']=$id;
//timelari duzgun formata saliriq***********************************
$a=explode(' ',$sd);
$b=$a[0];
$c=explode('/',$b);

$sd=$c[0].'-'.$c[1].'-'.$c[2].' '.$a[1];


$a=explode(' ',$ed);
$b=$a[0];
$c=explode('/',$b);

$ed=$c[0].'-'.$c[1].'-'.$c[2].' '.$a[1];

$_SESSION['postdata']['sd']=$sd;
$_SESSION['postdata']['ed']=$ed;
//******************************************************************

//Mehsul Informasiyasini cixardiriq*********************************
$lngins=$db->prepare('select * from mehsul where u_id=:uid  and l_id=1 ');

$bo=$lngins->execute(array('uid'=>$id ));
  
$b=$lngins->fetch(PDO::FETCH_ASSOC);
//******************************************************************
?>

<div class="row">

  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>Product discount preview - <?PHP echo $b['name'];?></h2>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
		<?PHP
		foreach($_POST as $key=>$value)
		{
			$arr=explode('|',$key);
			if(count($arr)>1)			
			{
				if($arr[0]=='v' and $value!=0)
				{
					if($arr[1]==0) //productun all country qiymetleri istifade olunur
					{
						$p1=$b['price_1'];
						$p2=$b['price_2'];
						$p3=$b['price_3'];
						$vlyt='USD';
						$olke='All countries';
					}
					else
					{
						$x=$arr[1];
						$oc=$db->prepare('select o.* , mop.price_1 , mop.price_2 , mop.price_3, c.short_name from mehsul_olke_price mop, olkeler o, currency c where mop.id=:muid and o.kat_id=mop.o_u_id and o.l_id=1 and o.currency_id=c.u_id and c.l_id=1');
						$oc->execute(array('muid'=>$x ));
						$b1=$oc->fetch(PDO::FETCH_ASSOC);
						
						$p1=$b1['price_1'];
						$p2=$b1['price_2'];
						$p3=$b1['price_3'];
						$vlyt=$b1['short_name'];
						$olke=$b1['name'];
					}
					switch($arr[2])
					{
						case 1:
							$pr=$p1;
							$shop='e-shop';
						break;
						case 2:
							$pr=$p2;
							$shop='Registration';
						break;
						case 3:
							$pr=$p3;
							$shop='Commission shop';
						break;
					}
					$ty='t|'.$arr[1].'|'.$arr[2];
				
					if($_POST[$ty]==1)
					{
						$prn=ceil($pr*(100-$value)/100);
						$sym='%';
					}
					else
					{
						$prn=$pr-$value;
						$sym='fixed';
					}
					?>
					<div class="form-group" id="allcount"  >
						<label class="control-label col-md-3 col-sm-3 col-xs-12"><?PHP echo $olke.'-'.$shop.':'; ?></label>
						<div class="col-md-3 col-sm-3 col-xs-12">
							<span style="border:1px solid black;display: inline-block;padding: 3px;margin:2px;width:100px;"><?PHP echo $pr.' '.$vlyt;?></span>
							<span style="border:1px solid black;display: inline-block;padding: 3px;margin:2px;width:100px;"><?PHP echo $value.' '.$sym;?></span>
						</div>
						<div class="col-md-6 col-sm-6 col-xs-12">
							<span style="border:1px solid black;display: inline-block;padding: 3px;margin:2px;width:100px;"><?PHP echo $prn.' '.$vlyt;?></span>
						</div>
					</div>
					<?PHP
				}
			}
			
		}
		
		?>
          




          <div class="form-group">

            <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-3">

              <input id="btnid" onclick="goback()" type="button" name="btn" value="Back" class="btn btn-success"/>
              <input id="btnid" onclick="forward()"type="button" name="btn" value="submit" class="btn btn-success"/>

            </div>

          </div>



        </form>

      </div>

    </div>

  </div>

</div>

<script>
	function goback()
	{
		window.history.back();
	}
	function forward()
	{
		location.replace('<?PHP echo $site_url ;?>discount/addsubmit/');
	}
</script>