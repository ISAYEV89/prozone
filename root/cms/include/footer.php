        <!-- footer content -->
        <footer>
          <div class="pull-right">
             Powered by - LNS! <a href="">LNS International!</a>
          </div>
          <div class="clearfix"></div>
        </footer>
        <!-- /footer content -->
      </div>
    </div>
    <!-- jQuery -->
    <script src="<?php echo $site_url; ?>template/vendors/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="<?php echo $site_url; ?>template/vendors/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- FastClick -->
    <script src="<?php echo $site_url; ?>template/vendors/fastclick/lib/fastclick.js"></script>
    <!-- NProgress -->    <script src="<?php echo $site_url; ?>template/vendors/nprogress/nprogress.js"></script>		<!--date picker stuff  -->	<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>	<!--********************************* -->		<script src="<?php echo $site_url; ?>js/select2.min.js"></script><script>$("#prid").select2( {	placeholder: "Select product",	allowClear: true	} );</script>

    <?php 
    if ($page=='list' || $page=='listcity' || $page=='list_left' || $page=='list_secret' || $page=='list_top' || $page=='list_bottom' || $page=='edit_photo') 
    {
    ?>
    <!-- Datatables -->
    <script src="<?php echo $site_url; ?>template/vendors/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="<?php echo $site_url; ?>template/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
    <?php 
    }
    ?>
    <?php 
    if ($page=='add' || $page=='edit') 
    {
    ?>
    <!-- Switchery -->
    <script src="<?php echo $site_url; ?>template/vendors/switchery/dist/switchery.min.js"></script>
    <?php 
    }
    ?>
    <!-- Custom Theme Scripts -->
    <script src="<?php echo $site_url; ?>template/build/js/custom.min.js"></script>
    <script>
    function dsomo(element)
    {
      if (element.type=='button')
      {
        if (confirm('Are you sure for delete?')) 
        {
          element.type='submit';
        }
      }
    }
    <?php  
    if ($state=='customer')
    {
    ?>
        $(document).ready(function() {
            $('#datatable').DataTable( {
               "order": [[ 0, "desc" ]]
             } );
        } );
    <?php 
    } 
    ?>  
	$( function() {    $( "#datepicker" ).datepicker();		$( "#datepicker" ).datepicker( "option", "dateFormat", "yy-mm-dd" );  
	<?php  
    if ($_GET['state']=='orders' and !empty($_POST['startd']))
    {
        echo "$('#datepicker').datepicker('setDate', '".$_POST['startd']."');";
    }
    ?>
	
	} );
	$( function() {    $( "#datepicker2" ).datepicker();	$( "#datepicker2" ).datepicker( "option", "dateFormat", "yy-mm-dd" );  
	<?php  
    if ($_GET['state']=='orders' and !empty($_POST['endd']))
    {
        echo "$('#datepicker2').datepicker('setDate', '".$_POST['endd']."');";
    }
	?>
	
	
	} );
	$('#countrysel').change(function(){
		$('#citysel').load('<?PHP echo $site_url;?>ajax/selcity.php?country_id='+this.value);
		});
		
	<?php  
    if ($_GET['state']=='orders') //ordersi update etmek uchun funksiya******
    {
    ?>
	
	$('.sts_sel').change(function(){
		var id=$(this).data("id");
		var clrid=$(this).val();
		$.post( "<?PHP echo $site_url;?>ajax/upd_ord_sts.php", { id: id, ds_id: this.value })
		  .done(function( data ) {
			var colors = new Array("", "", "#82E0AA", "#D5F5E3", "#D4E6F1");
			var trid='tr' + id;
			$('#'+trid).css("background-color",colors[clrid]);
			alert("sucsessfully updated");
			
		  });
	});
	<?PHP
    }
	?>
    </script>
	<script src="<?PHP echo $site_url;?>js/jquery.print.js"></script>
<script type='text/javascript'>

$(function() {

$("#printable").find('.print').on('click', function() {

$("#printable").print({
	noPrintSelector : ".avoid-this",
	title: null
});

});

});

</script>
</body>
</html>