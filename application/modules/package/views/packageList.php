<div class="main-content">
	<div class="main-content-inner">
		<div class="breadcrumbs ace-save-state" id="breadcrumbs">
			<ul class="breadcrumb">
				<li>
					<i class="ace-icon fa fa-home home-icon"></i>
					<a href="<?php echo base_url().""; ?>">Home</a>
				</li>
				<li class="active">Package List</li>
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
					Package List
				</h1>
			</div><!-- /.page-header -->
			<a id="gritter-without-image" class="btn btn-success" class="white" href="<?php echo base_url().'package/packageMaster'; ?>">ADD New</a> 
			<div class="row">
				<div class="col-xs-12">
					<div class="alert-box"></div>
					<!-- PAGE CONTENT BEGINS -->
					<div class="row">
						<div class="col-xs-12">

							<div class="clearfix">
								<div class="pull-right tableTools-container"></div>
							</div>
							<div class="table-header">
								Package
							</div>

							<!-- div.table-responsive -->

							<!-- div.dataTables_borderWrap -->
							<form class="form" id=""></form>
							<div>
								<table id="dynamic-table" class="table table-striped table-bordered table-hover">
									<thead>
										<tr>
											 
											<th>Package Name</th>
											<th>Vehicle Type</th>
											<th>Travel Type</th>
											<th>Package Amount</th>
											<th>Hours</th>
											<th>Distance</th>
											<th>Charge Distance</th>
											<th>Charge Hour</th>
											<th>Defalut Package</th>
											<th>Status</th>
											<th>Added on</th>
											<th>Action</th>
										</tr>
									</thead>

									<tbody>
										<?php foreach ($packageList as $val): ?>
											<tr>
												 

												<td><?php echo $val->package_name; ?></td>
												<td><?php echo $val->cat_name; ?></td>
												<td><?php echo $val->travel_type; ?></td>
												<td><?php echo $val->package_amt; ?></td>
												<td><?php echo $val->hours; ?></td>
												<td><?php echo $val->distance; ?></td>
												<td><?php echo $val->charge_distance; ?></td>
												<td><?php echo $val->charge_hour; ?></td>
												<td><?php if($val->default == 1): echo "Yes"; else: echo "No"; endif; ?></td>
												<td><?php if($val->isactive == 1): echo "Active"; else: echo "Inactive"; endif; ?></td>
												<td><?php echo $val->added_on; ?></td>

												<td>
													<div class="hidden-sm hidden-xs action-buttons">
														<a class="green" href="<?php echo base_url().'package/update/'.$val->package_id; ?>">
															<i class="ace-icon fa fa-pencil bigger-130"></i>
														</a>
													</div>
												</td>
											</tr>
										<?php endforeach; ?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div><!-- /.col -->
			</div><!-- /.row -->
		</div><!-- /.page-content -->
	</div>
</div><!-- /.main-content -->
<div id="modal-table" class="modal fade" tabindex="-1">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header no-padding">
				<div class="table-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
						<span class="white">&times;</span>
					</button>
					Vehicle Details
				</div>
			</div>

			<div class="modal-body no-padding">
				<table class="table table-striped table-bordered table-hover no-margin-bottom no-border-top">
					<thead>
						<tr>
							<th>Name</th>
							<th>Date</th>
						</tr>
					</thead>

					<tbody class="detailsBody">
						
					</tbody>
				</table>
			</div>

			<div class="modal-footer no-margin-top">
				<button class="btn btn-sm btn-danger pull-left" data-dismiss="modal">
					<i class="ace-icon fa fa-times"></i>
					Close
				</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div>
<!-- basic scripts -->

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
<script src="<?php echo base_url(); ?>components/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
<script src="<?php echo base_url(); ?>components/datatables.net-buttons/js/buttons.flash.min.js"></script>
<script src="<?php echo base_url(); ?>components/datatables.net-buttons/js/buttons.html5.min.js"></script>
<script src="<?php echo base_url(); ?>components/datatables.net-buttons/js/buttons.print.min.js"></script>
<script src="<?php echo base_url(); ?>components/datatables.net-buttons/js/buttons.colVis.min.js"></script>
<script src="<?php echo base_url(); ?>components/datatables.net-select/js/dataTables.select.min.js"></script>

<script src="<?php echo base_url(); ?>js/custom.js"></script>
<script src="<?php echo base_url(); ?>js/form-validation.js"></script>

<!-- inline scripts related to this page -->
<script type="text/javascript">
	jQuery(function($) {
		//initiate dataTables plugin
		var myTable = 
		$('#dynamic-table')
		//.wrap("<div class='dataTables_borderWrap' />")   //if you are applying horizontal scrolling (sScrollX)
		.DataTable( { 
	    } );
	
		
		
		$.fn.dataTable.Buttons.swfPath = "<?php echo base_url(); ?>components/datatables.net-buttons-swf/index.html"; //in Ace demo ./components will be replaced by correct assets path
		$.fn.dataTable.Buttons.defaults.dom.container.className = 'dt-buttons btn-overlap btn-group btn-overlap';
		
		new $.fn.dataTable.Buttons( myTable, {
			buttons: [
			    {
            "extend": "colvis",
            "text": "<i class='fa fa-search bigger-110 blue'></i> <span class='hidden'>Show/hide columns</span>",
            "className": "btn btn-white btn-primary btn-bold",
            columns: ':not(:first):not(:last)'
            },
			  {
				"extend": "csv",
				"text": "<i class='fa fa-database bigger-110 orange'></i> <span class='hidden'>Export to CSV</span>",
				"className": "btn btn-white btn-primary btn-bold"
			  },
			   
			  {
				"extend": "print",
				"text": "<i class='fa fa-print bigger-110 grey'></i> <span class='hidden'>Print</span>",
				"className": "btn btn-white btn-primary btn-bold",
				autoPrint: false,
				message: 'This print was produced using the Print button for DataTables'
			  }		  
			]
		} );
		myTable.buttons().container().appendTo( $('.tableTools-container') );
		
		//style the message box
		var defaultCopyAction = myTable.button(1).action();
		myTable.button(1).action(function (e, dt, button, config) {
			defaultCopyAction(e, dt, button, config);
			$('.dt-button-info').addClass('gritter-item-wrapper gritter-info gritter-center white');
		});
		
		
		var defaultColvisAction = myTable.button(0).action();
		myTable.button(0).action(function (e, dt, button, config) {
			
			defaultColvisAction(e, dt, button, config);
			
			
			if($('.dt-button-collection > .dropdown-menu').length == 0) {
				$('.dt-button-collection')
				.wrapInner('<ul class="dropdown-menu dropdown-light dropdown-caret dropdown-caret" />')
				.find('a').attr('href', '#').wrap("<li />")
			}
			$('.dt-button-collection').appendTo('.tableTools-container .dt-buttons')
		});
	
		////
	
		setTimeout(function() {
			$($('.tableTools-container')).find('a.dt-button').each(function() {
				var div = $(this).find(' > div').first();
				if(div.length == 1) div.tooltip({container: 'body', title: div.parent().text()});
				else $(this).tooltip({container: 'body', title: $(this).text()});
			});
		}, 500);
		
		
		
		
	
	
	})
</script>
<script type="text/javascript">
	$(document).on('click','.details', function(e){
	    e.preventDefault();
	    
        var id = $(this).attr('id');
        
        var obj = array.filter(function(obj){
            return obj.name === 'vehicle-detail-view'
        })[0];

        var uri = obj['value'];

        jobject = {
            'id' : id
        }

        var point = $(this);
        
        $.ajax({
            url: uri,
            method: 'POST',
            crossDomain: true,
            data: jobject,
            dataType: 'json',
            beforeSend: function (xhr) {
                //$('.icon'+id).addClass('ace-icon fa fa-spinner fa-spin orange bigger-125');
            },
            success: function (data) {
                if(data.success == true){
                	$('.detailsBody').html(data.successMsg);

                }else{

                }
            },
            error: function (xhr, ajaxOptions, thrownError) {
                console.log(thrownError);
            }
        });
	});
</script>
