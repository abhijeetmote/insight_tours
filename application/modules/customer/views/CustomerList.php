<div class="main-content">
	<div class="main-content-inner">
		<div class="breadcrumbs ace-save-state" id="breadcrumbs">
			<ul class="breadcrumb">
				<li>
					<i class="ace-icon fa fa-home home-icon"></i>
					<a href="<?php echo base_url().""; ?>">Home</a>
				</li>

				 
				<li class="active">Customer Lists</li>
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
					Customer List
				</h1>
			</div><!-- /.page-header -->

			<div class="row">
				<div class="col-xs-12">
					<div class="alert-box"></div>
					<!-- PAGE CONTENT BEGINS -->
					<div class="row">
						<div class="col-xs-12">
							<h3 class="header smaller lighter blue"></h3>

							<div class="clearfix">
								<div class="pull-right tableTools-container"></div>
							</div>
							<div class="table-header">
								Results for "Customer Data"
							</div>

							<!-- div.table-responsive -->

							<!-- div.dataTables_borderWrap -->
							<form class="form" id="customerList"></form>
							<div>
								<table id="dynamic-table" class="table table-striped table-bordered table-hover">
									<thead>
										<tr>
											 
											<th>Customer Name</th>
											<th>Mobile No</th>
											<th>Contact No</th>
											<th>Address</th>
											<th>Email id</th>
											<th>Company Name</th>
											<th>Action</th>											
										</tr>
									</thead>

									<tbody>
										<?php foreach ($list as $val): ?>
											<tr>
												 

												<td><?php echo $val->cust_firstname; ?></td>
												<td><?php echo $val->cust_mob1; ?></td>
												<td><?php echo $val->cust_telno; ?></td>
												<td><?php echo $val->cust_address; ?></td>
												<td><?php echo $val->cust_email1; ?></td>
												<td><?php echo $val->cust_compname; ?></td>
												<td>
													<div class="hidden-sm hidden-xs action-buttons">
														<a class="green" href="<?php echo base_url().'customer/update/'.$val->cust_id; ?>">
															<i class="ace-icon fa fa-pencil bigger-130"></i>
														</a>

														<a class="red delete" href="#" id="<?php echo $val->cust_id; ?>">
															<i class="ace-icon fa fa-trash-o bigger-130"></i>
														</a>
													</div>

													<div class="hidden-md hidden-lg">
														<div class="inline pos-rel">
															<button class="btn btn-minier btn-yellow dropdown-toggle" data-toggle="dropdown" data-position="auto">
																<i class="ace-icon fa fa-caret-down icon-only bigger-120"></i>
															</button>

															<ul class="dropdown-menu dropdown-only-icon dropdown-yellow dropdown-menu-right dropdown-caret dropdown-close">
																<li>
																	<a href="#" class="tooltip-info" data-rel="tooltip" title="View">
																		<span class="blue">
																			<i class="ace-icon fa fa-search-plus bigger-120"></i>
																		</span>
																	</a>
																</li>

																<li>
																	<a href="#" class="tooltip-success" data-rel="tooltip" title="Edit">
																		<span class="green">
																			<i class="ace-icon fa fa-pencil-square-o bigger-120"></i>
																		</span>
																	</a>
																</li>

																<li>
																	<a href="#" class="tooltip-error" data-rel="tooltip" title="Delete">
																		<span class="red">
																			<i class="ace-icon fa fa-trash-o bigger-120"></i>
																		</span>
																	</a>
																</li>
															</ul>
														</div>
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
				
				
				
				
				
				myTable.on( 'select', function ( e, dt, type, index ) {
					if ( type === 'row' ) {
						$( myTable.row( index ).node() ).find('input:checkbox').prop('checked', true);
					}
				} );
				myTable.on( 'deselect', function ( e, dt, type, index ) {
					if ( type === 'row' ) {
						$( myTable.row( index ).node() ).find('input:checkbox').prop('checked', false);
					}
				} );
			
			
			
			
				 
			
			
			})
		</script>