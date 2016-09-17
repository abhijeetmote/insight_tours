

<div class="main-content">
	<div class="main-content-inner">
		<div class="breadcrumbs ace-save-state" id="breadcrumbs">
			<ul class="breadcrumb">
				<li>
					<i class="ace-icon fa fa-home home-icon"></i>
					<a href="#">Home</a>
				</li>

				<li>
					<a href="#">Booking</a>
				</li>
				<li class="active">Booking Lists</li>
			</ul><!-- /.breadcrumb -->

			<div class="nav-search" id="nav-search">
				<form class="form-search">
					<span class="input-icon">
						<input type="text" placeholder="Search ..." class="nav-search-input" id="nav-search-input" autocomplete="off" />
						<i class="ace-icon fa fa-search nav-search-icon"></i>
					</span>
				</form>
			</div><!-- /.nav-search -->
		</div>










		<div class="page-content">
			
			<div class="page-header">
				<h1>
					Booking List
				</h1>
			</div><!-- /.page-header -->

		<div class="row">

			<?php foreach($ledgers as $ledg){  ?> 
				<div class="col-xs-12 col-sm-22 widget-container-col ui-sortable" id="widget-container-col-1">
					<div class="widget-box ui-sortable-handle collapsed" id="widget-box-1" style="margin-top:0;">
						<div class="widget-header">
							<h5 class="widget-title"><?php echo ucwords(strtolower($ledg['name'])); ?></h5>

							<div class="widget-toolbar">
								

								<a href="#" data-action="collapse">
									<i class="ace-icon fa fa-chevron-up"></i>
								</a>
							</div>
						</div>
						
						<div class="widget-body" style="display:none;">
							<div class="widget-main no-padding">
								 <?php     
               
						                echo "<table border=\"0\" width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" class=\"fht-table mt2 tablerow\" >
						                <thead>
						                <th class=\"firstth\"  >Name</th>
						                  <th>Group/Ledger</th>
						                  <th>Nature</th>
						                  <th>Behaviour</th>
						                  <th>Purpose</th>
						                  <th>Status</th>
						                  <th class=\"width100\">Actions</th>
						                </thead>
						                <tbody>";
						                $flag = 0;    
						            ?>
						            <tr data-tt-id="<?php echo $ledg["ledger_account_id"]; ?>" <?php if ($flag == 0) { $flag = 1;} else {echo "data-tt-parent-id=" . $ledg["parent"];} ?>>
						                    <td width=\"30%\"><b><?php echo ucwords(strtolower($ledg['name'])); ?></b></td>
						                    <td><b><?php echo $ledg['entity_type']; ?></b></td>
						                    <td><b><?php if($ledg['nature']=='cr') { echo "Credit";} else if($ledg['nature']=='dr'){ echo "Debit";} else {echo "";} ?></b></td>
						                    <td><b><?php echo $ledg['behaviour']; ?></b></td>
						                    <td>&nbsp;</td>
						                    <td><b><?php if($ledg['status']==1){ echo "Active";} else {echo "Inactive";}?></b></td>
						                    <td>&nbsp;</td>
						                  </tr>
						                <?php
						                recursiveArr($ledg['children']);
						                echo "</tbody></table>";        
					                ?>
								</div>
							</div>
						</div>
				</div>
				<?php } ?>
			</div>	

		 
		</div><!-- /.page-content -->


	</div>
</div>		


  

 <?php

function recursiveArr($ledgers){
   
    global $flag;
    $txt=array();
  
    if (isset($ledgers) && is_array($ledgers)) {
        
        global $config;
                   
        foreach($ledgers as $val){
?>
                    <tr data-tt-id="<?php echo $val["ledger_account_id"]; ?>" <?php if ($flag == 1) { $flag = 0;} else {echo "data-tt-parent-id=" . $val["parent"];} ?>>
                    <td width=\"30%\"><?php echo ucwords($val["name"]); ?></td>
                    <td><?php echo $val['entity_type']; ?></td>
                    <td><?php if($val['nature']=='cr') { echo "Credit";} else if($val['nature']=='dr'){ echo "Debit";} else {echo "";} ?></td>
                    <td><?php echo $val['behaviour']; ?></td>
                    <td><?php echo $val['context']; ?></td>
                    <td><?php if($val['status']==1){ echo "Active";$class = "times";} else {echo "Inactive"; $class = "check";}?></td>                    
                    <td><?php if($val['entity_type']=='ledger' ){?><a href="editLedger/<?php echo $val["ledger_account_id"]; ?>"><i class="fa fa-edit"></i></a> <a href="<?php echo $config->system->full_base_url; ?>listTransaction/<?php echo $val["ledger_account_id"]; ?>" target="_blank"><i class="fa fa-credit-card"></i></a> <a href="<?php echo $config->system->full_base_url ?>accounts/deleteLedger/<?php echo $val["ledger_account_id"]; ?>"><i class="fa fa-<?php echo $class; ?>"></i></a><?php } ?></td>
                  </tr>
<?php
            
            if($val['children'] && is_array($val['children'])){           
                recursiveArr($val['children']);
            }
        }
    }
   
}

?>

<!--[if !IE]> -->
<script src="<?php echo base_url(); ?>js/jquery.min.js"></script>

<!-- <![endif]-->

<!--[if IE]>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<![endif]-->
<script type="text/javascript">
	if('ontouchstart' in document.documentElement) document.write("<script src='components/_mod/jquery.mobile.custom/jquery.mobile.custom.min.js'>"+"<"+"/script>");
</script>
<script src="<?php echo base_url(); ?>js/bootstrap.min.js"></script>

<!-- page specific plugin scripts -->

<!--[if lte IE 8]>
  <script src="./components/ExplorerCanvas/excanvas.min.js"></script>
<![endif]-->
<link rel="stylesheet" href="<?php echo base_url(); ?>css/ledgerlist.css" />
<script src="<?php echo base_url(); ?>components/_mod/jquery-ui.custom/jquery-ui.custom.min.js"></script>
<script src="<?php echo base_url(); ?>components/jqueryui-touch-punch/jquery.ui.touch-punch.min.js"></script>
<script src="<?php echo base_url(); ?>components/chosen/chosen.jquery.min.js"></script>
<script src="<?php echo base_url(); ?>components/fuelux/js/spinbox.min.js"></script>
<script src="<?php echo base_url(); ?>components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<script src="<?php echo base_url(); ?>components/bootstrap-timepicker/js/bootstrap-timepicker.min.js"></script>
<script src="<?php echo base_url(); ?>components/moment/moment.min.js"></script>
<script src="<?php echo base_url(); ?>components/bootstrap-daterangepicker/daterangepicker.min.js"></script>
<script src="<?php echo base_url(); ?>components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>
<script src="<?php echo base_url(); ?>components/mjolnic-bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js"></script>
<script src="<?php echo base_url(); ?>components/jquery-knob/dist/jquery.knob.min.js"></script>
<script src="<?php echo base_url(); ?>components/autosize/dist/autosize.min.js"></script>
<script src="<?php echo base_url(); ?>components/jquery-inputlimiter/jquery.inputlimiter.min.js"></script>
<script src="<?php echo base_url(); ?>components/jquery.maskedinput/dist/jquery.maskedinput.min.js"></script>
<script src="<?php echo base_url(); ?>components/_mod/bootstrap-tag/bootstrap-tag.min.js"></script>

<!-- ace scripts -->
<script src="<?php echo base_url(); ?>js/ace-elements.min.js"></script>
<script src="<?php echo base_url(); ?>js/ace.min.js"></script>

<script src="<?php echo base_url(); ?>components/datatables/media/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url(); ?>components/_mod/datatables/jquery.dataTables.bootstrap.min.js"></script>

<script src="<?php echo base_url(); ?>js/custom.js"></script>
<script src="<?php echo base_url(); ?>js/form-validation.js"></script>
 <!-- slidertabs script -->
<script src="<?php echo base_url(); ?>js/src/jquery.treetable-ajax-persist.js"></script> 
<script src="<?php echo base_url(); ?>js/src/jquery.treetable-3.0.0.js"></script>
<script src="<?php echo base_url(); ?>js/src/persist-min.js"></script> 
<script>
$(document).ready(function() {
    $('.fht-table').dataTable( {
        "paging":   false,
        "ordering": false,
        "info":     false,
	"bFilter": false,
    } );
} );
</script> 
<script>
$(document).ready(function(){
	$("table").agikiTreeTable({persist: true, persistStoreName: "files"});
	});
</script>
<!-- inline scripts related to this page -->
 