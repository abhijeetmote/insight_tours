<div class="main-content">
	<div class="main-content-inner">
		<div class="breadcrumbs ace-save-state" id="breadcrumbs">
			<ul class="breadcrumb">
				<li>
					<i class="ace-icon fa fa-home home-icon"></i>
					<a href="<?php echo base_url().""; ?>">Home</a>
				</li>

				 
				<li class="active">Invoice Lists</li>
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
					Invoice List
				</h1>
			</div><!-- /.page-header -->

			<div class="row">
				<div class="col-xs-12">
					<div class="alert-box"></div>
					<!-- PAGE CONTENT BEGINS -->
					<div class="row">
						<div class="col-xs-12">
							<div class="form-group">
								<label class="col-sm-1 no-padding-right" for="form-field-2"><b class="red"> * </b>Cust Type</label>
	                             <div class="col-sm-3">
									<select style="width:240px;" data-placeholder="Customer Type" name="cust_type" id="cust_type" class="chosen-select form-control">
											<option <?php if(isset($c_type) && $c_type == 1) { echo "selected"; }?> value="1">Indivisual</option>
											<option <?php if(isset($c_type) && $c_type == 2) { echo "selected"; }?> value="2">Corporate</option>
	                                </select>
	                                 
									 
								</div>
	                            
	                            <div class="individual" <?php if(isset($c_type) && $c_type == 2) { echo "style='display:none;'"; }?> >
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
	                            </div>

								<div class="corporate" <?php if(isset($c_type) && $c_type == 2) { echo "style='display:block;'"; } else { echo "style='display:none;'"; } ?> >
									<label class="col-sm-1 no-padding-right" for="form-field-2"><b class="red"> * </b>Select Year</label>
		                             <div class="col-sm-3">
										<select style="width:240px;" data-placeholder="Customer Type" id="month" class="chosen-select form-control">
											<option value="">Select Month</option>
											<?php
												foreach ($months as $key=>$val) 
												{			
											?>								
													<option value="<?php echo $key; ?>" ><?php echo $val; ?></option>
											<?php
												}
											?>
		                                </select>
									</div>

									<label class="col-sm-1 no-padding-right" for="form-field-2"><b class="red"> * </b>Select Month</label>
		                             <div class="col-sm-3">
										<select style="width:240px;" data-placeholder="Customer Type" id="year" class="chosen-select form-control">
											<option value="">Select Year</option>
											<?php
												foreach ($years as $val) 
												{			
											?>								
													<option value="<?php echo $val; ?>" ><?php echo $val; ?></option>
											<?php
												}
											?>
		                                </select>
									</div>
								</div>
                   		 	</div>            		 	 
						</div>
					</div>	
		
					<div class="clearfix form-actions">
						<div class="col-md-offset-3 col-md-9">
							<button class="btn btn-info invoice_filter" type="button">
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
			</div>	

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
								Invoice
							</div>

							<!-- div.table-responsive -->

							<!-- div.dataTables_borderWrap -->
							<form class="form" id="bookingList"></form>
							<div>
								<table id="dynamic-table" class="table table-striped table-bordered table-hover">
									<thead>
										<tr>
											 
											<th>Invoice ID</th>
											<th>Customer Name</th>
											<th>Company Name</th>
											<th>Invoice Date/Time</th>
											<th>Cutomer Type</th>
											<th>Service Tax</th>
											<th>Total Amount</th>
											<th>Adv Amount</th>
											<th>Final Amount</th>
											<th>Payment Status</th>
											<th>Action</th>

										</tr>
									</thead>

									<tbody>
										<?php foreach ($invoiceList as $val): ?>
											 <tr>
												 

												<td><?php echo $val->invoice_id; ?></td>
												<td><?php if($val->cust_type_id == 1){ echo $val->cust_firstname." ".$val->cust_lastname; } else { echo "NA"; } ?></td>
												<td><?php if($val->cust_type_id == 2){ echo $val->cust_compname; } else { echo "NA"; } ?></td>
												<td><?php echo $val->invoice_date; ?></td>
												<td><?php if($val->cust_type_id == 2){ echo 'Corporate'; } else { echo "Individual"; } ?></td>
												<td><?php echo number_format($val->service_tax_amt + $val->education_cess_amt + $val->sec_education_cess_amt, 2); ?></td>
												<td><?php echo number_format($val->total_amount, 2) ?></td>
												<td><?php echo number_format($val->adv_amount, 2) ?></td>
												<td><?php echo number_format($val->final_amount, 2) ?></td>
												<td><?php echo ucfirst($val->payment_status); ?></td>
												<td>
													<div class="hidden-sm hidden-xs action-buttons">
														<?php if($val->payment_status == "unpaid" && $val->final_invoice_id != 0){  ?>
																<a class="green" href="<?php echo base_url()."invoice/invoicePaid/".$val->final_invoice_id."/".$val->cust_id ?>">
																	<i class="ace-icon fa fa-pencil bigger-130"></i>
																</a>
														<?php  } ?>

														<?php if($val->final_invoice_id == 0){ ?>
														
															<a class="blue" href="<?php echo base_url()."invoice/invoiceGenerate/".$val->invoice_id."/".$val->cust_id."/".$val->cust_type_id."/".$val->completed_month."/".$val->completed_year; ?>">
															<i class="ace-icon fa fa-print bigger-130"></i></a>
														<?php }else{ ?>

															<a download class="blue" href="<?php echo base_url(). "assets/pdf/".$val->final_invoice_no.".pdf"; ?>">
															<i class="ace-icon fa fa-download bigger-130"></i></a>
														<?php } ?>
														
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

		$('.date-picker').datepicker({
			autoclose: true,
			todayHighlight: true
		})
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
		
		 
	
	})
</script>

<script type="text/javascript">
	$(document).on('click','.invoice_filter', function() {
		var baseUrl = $('#baseUrl').val();
		var from_date = $("#from_date").val();
		var to_date = $("#to_date").val();
		var cust_type = $("#cust_type").val();
		var month = $("#month").val();
		var year = $("#year").val();

		if(cust_type == 2){
			from_date = month;
			to_date = year;
		}else{
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
		}
		window.location.href = baseUrl+"invoice/invoiceList/"+cust_type+"/"+from_date+"/"+to_date;
	});

	$(document).on('click','#cust_type', function() {
		var cust_type = $(this).val();

		if(cust_type == 2){
			$('.individual').css('display', 'none');
			$('.corporate').css('display', 'block');
		}else{
			$('.corporate').css('display', 'none');
			$('.individual').css('display', 'block');
		}
		 
	});
</script>
