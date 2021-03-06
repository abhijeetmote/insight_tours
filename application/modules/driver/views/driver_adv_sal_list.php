<div class="main-content">
	<div class="main-content-inner">
		<div class="breadcrumbs ace-save-state" id="breadcrumbs">
			<ul class="breadcrumb">
				<li>
					<i class="ace-icon fa fa-home home-icon"></i>
					<a href="<?php echo base_url().""; ?>">Home</a>
				</li>
 
				<li class="active">Driver Advance Salary</li>
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
					Driver Advance Salary List
				</h1>
			</div><!-- /.page-header -->

			<div class="row">
				<div class="col-xs-12">
					<div class="alert-box"></div>
					<!-- PAGE CONTENT BEGINS -->
							<div class="row">
								<div class="col-xs-12">
									<div class="form-group">
				                            <label class="col-sm-1 no-padding-right" for="form-field-2"><b class="red"> * </b>Form Date</label>
				                             <div class="col-sm-3">
												<div class="input-group">
												<input type="text" data-date-format="dd-mm-yyyy" class="date-picker col-xs-10 col-sm-12" id="from_date" name="from_date" placeholder="Enter from Date" value="<?php if(isset($from_date)): echo  $from_date; endif; ?>">
												<span class="input-group-addon">
													<i class="fa fa-calendar bigger-110"></i>
												</span>

												</div>
												 
											</div>

											<label class="col-sm-1 no-padding-right" for="form-field-2"><b class="red"> * </b>To Date</label>
				                             <div class="col-sm-3">
												<div class="input-group">
												<input type="text" data-date-format="dd-mm-yyyy" class="date-picker col-xs-10 col-sm-12" id="to_date" name="to_date" placeholder="Enter User Booking Date" value="<?php if(isset($to_date)): echo $to_date; endif; ?>">
												<span class="input-group-addon">
													<i class="fa fa-calendar bigger-110"></i>
												</span>

												</div>
												 
											</div>


											  <label class="col-sm-1 no-padding-right" for="form-field-2"><b class="red"> * </b>Driver</label>
				                             <div class="col-sm-3">
												<select style="width:240px;" data-placeholder="vendor" name="driver_id" id="driver_id" class="chosen-select form-control">
														<?php
														echo "<option selected value='0'>---None---</option>";
														foreach ($list as $val) {
														if($driver_id == $val->driver_id)
														echo '<option selected value="'.$val->driver_id.'">'.$val->driver_fname." ".$val->driver_lname.'</option>';
														else 
														echo '<option value="'.$val->driver_id.'">'.$val->driver_fname." ".$val->driver_lname.'</option>';	
															}
														?>
				                                </select>
											</div>
 
		                   		 	</div>	

		                   		 	
		                   		 
		                   		 	 
								</div>	

							</div>	
							<br>
							 
				
						<div class="clearfix form-actions">
							<div class="col-md-offset-3 col-md-9">
								<button class="btn btn-info vb_filter" type="button">
									<i class="iconcategory"></i>
									Submit
								</button>

								&nbsp; &nbsp; &nbsp;
								<button class="btn b_reset" type="reset">
									<i class="ace-icon fa fa-undo bigger-110 "></i>
									Reset
								</button>
							</div>
						</div>
			</div>	

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
								Results for "Vendor Bill"
							</div>

							<!-- div.table-responsive -->

							<!-- div.dataTables_borderWrap -->
							<form class="form" id="vendorbillList"></form>
							<div>
								<table id="dynamic-table" class="table table-striped table-bordered table-hover">
									<thead>
										<tr>
											<th>Trans Date</th> 
											<th>Driver Name</th>
											<th>Month</th>
											<th>Year</th>
											<th>Amount</th>
											<th>Mobile</th>
											<th>Pan No</th>

										</tr>
									</thead>

									<tbody>
										<?php foreach ($driversal_list as $val): ?>
											 <tr>
												 

												<td><?php echo $newDateTime = date('d/m/Y', strtotime($val->transaction_date)); ?></td>
												<td><?php echo $val->driver_fname." ".$val->driver_lname; ?></td>
												<td><?php echo $val->salary_month; ?></td>
												<td><?php echo $val->salary_year; ?></td>
												<td><?php echo $val->transaction_amount; ?></td>
												<td><?php echo $val->driver_mobno; ?></td>
												<td><?php echo $val->driver_panno; ?></td>
											 
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


				$('.date-picker').datepicker({
				autoclose: true,
				todayHighlight: true
				})
				//show datepicker when clicking on the icon
				.next().on(ace.click_event, function(){
					$(this).prev().focus();
				});


				//initiate dataTables plugin
				var myTable = 
				$('#dynamic-table')
				//.wrap("<div class='dataTables_borderWrap' />")   //if you are applying horizontal scrolling (sScrollX)
				.DataTable( { 
			    } );
			
				$('.chosen-select').chosen({allow_single_deselect:true}); 
				
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
			            "extend": "copy",
			            "text": "<i class='fa fa-copy bigger-110 pink'></i> <span class='hidden'>Copy to clipboard</span>",
			            "className": "btn btn-white btn-primary btn-bold"
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
			})
		</script>
 

<script type="text/javascript">

$(document).on('click','.vb_filter', function() {
		var baseUrl = $('#baseUrl').val();
		var from_date = $("#from_date").val();
		var to_date = $("#to_date").val();
		var driver_id = $("#driver_id").val();
		

		 
		if(from_date == ""){
			from_date=0;
		}
		if(to_date == ""){
			to_date = 0;
		}
		if(from_date !="" && to_date == "") {
			alert("select To date");
			return false;
		}
		if(to_date !="" && from_date == "") {
			alert("select from date");
			return false;
		}
		 
		window.location.href = baseUrl+"driver/driverbillList/"+from_date+"/"+to_date+"/"+driver_id;
		 
	});

$(document).on('click','.b_reset', function() {
		var baseUrl = $('#baseUrl').val();
		 
		window.location.href = baseUrl+"driver/driverbillList";
		 
	});
</script>
