<div class="main-content">
	<div class="main-content-inner">
		<div class="breadcrumbs ace-save-state" id="breadcrumbs">
			<ul class="breadcrumb">
				<li>
					<i class="ace-icon fa fa-home home-icon"></i>
					<a href="<?php echo base_url().""; ?>">Home</a>
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


											<label class="col-sm-1 no-padding-right" for="form-field-2"><b class="red"> * </b>Status</label>
				                             <div class="col-sm-3">
												<select style="width:250px;" data-placeholder="Status" name="booking_status" id="booking_status" class="chosen-select form-control">
														<option selected value="0">ALL</option>
														 <option <?php if(isset($status) && $status == 1) { echo "selected"; }?> value="1">Pending</option>
					                                    <option value="2" <?php if(isset($status) &&  $status == 2) { echo "selected"; }?>>Start Tour</option>
					                                    <option value="3" <?php if(isset($status) &&  $status == 3) { echo "selected"; }?>>End Tour</option>
					                                    <option <?php if(isset($status) && $status == 4) { echo "selected"; }?> value="4">Cancel</option>
					                                    <option <?php if(isset($status) && $status == 5) { echo "selected"; }?> value="5">UnPaid</option>
					                                    <option value="6" <?php if(isset($status) &&  $status == 6) { echo "selected"; }?>>Paid</option>
				                                </select>
				                                <span class="help-inline col-xs-12 col-sm-7">
				                                    <span class="middle input-text-error" id="salary_month_errorlabel"></span>
				                                </span>
												 
											</div>
 
		                   		 	</div>	

		                   		 	
		                   		 
		                   		 	 
								</div>	

							</div>	
							
							<div class="row">
								<div class="col-xs-12">
									 

		                   		 	<div class="form-group">
				                            <label class="col-sm-1 no-padding-right" for="form-field-2"><b class="red"> * </b>Cust Type</label>
				                             <div class="col-sm-3">
												<select style="width:240px;" data-placeholder="Customer Type" name="cust_type" id="cust_type" class="chosen-select form-control">
														<option selected value="0">ALL</option>
														<option <?php if(isset($c_type) && $c_type == 1) { echo "selected"; }?> value="1">Indivisual</option>
														<option <?php if(isset($c_type) && $c_type == 2) { echo "selected"; }?> value="2">Corporate</option>
				                                </select>
				                                 
												 
											</div>

											<label class="col-sm-1 no-padding-right" for="form-field-2"><b class="red"> * </b>Type</label>
				                             <div class="col-sm-3">
												<select style="width:240px;" data-placeholder="Booking Type" name="b_type" id="b_type" class="chosen-select form-control">
														<option selected value="0">ALL</option>
														<option <?php if(isset($b_type) && $b_type == 1) { echo "selected"; }?> value="1">Booking</option>
														<option <?php if(isset($b_type) && $b_type == 2) { echo "selected"; }?> value="2">Duty Sleep</option>
				                                </select>
				                                 
												 
											</div>

		                   		 	</div>
		                   		 
		                   		 	 
								</div>	

							</div>
				
						<div class="clearfix form-actions">
							<div class="col-md-offset-3 col-md-9">
								<button class="btn btn-info b_filter" type="button">
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
			<a id="gritter-without-image" class="btn btn-success" class="white" href="<?php echo base_url().'booking/bookingMaster'; ?>">ADD New</a> 
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
								Results for "Booking"
							</div>

							<!-- div.table-responsive -->

							<!-- div.dataTables_borderWrap -->
							<form class="form" id="bookingList"></form>
							<div>
								<table id="dynamic-table" class="table table-striped table-bordered table-hover">
									<thead>
										<tr>
											 
											<th>BK ID</th>
											<th>BK Date</th>
											<th>BOk Date</th>
											<th>Cust Name</th>
											<th>Cust Type</th>
											<th>Vehicale Type</th>
											<th>T Type</th>
											<th>DS Id</th>
											<th>Status</th>
											<th>Action</th>

										</tr>
									</thead>

									<tbody>
										<?php foreach ($booking_list as $val): ?>
											 <tr>
												 

												<td><?php echo "BK_".$val->booking_id; ?></td>
												<td><?php echo $val->booking_date; ?></td>
												<td><?php echo $val->booked_on; ?></td>
												<td><?php echo $val->cust_firstname . " " .$val->cust_lastname; ?></td>
												<td><?php if($val->cust_type_id == 1) echo "Indivisual"; else echo "Corporate"; ?></td>
												<td><?php echo $val->cat_name; ?></td>
												<td><?php echo $val->travel_type; ?></td>
												<td><?php echo isset($val->duty_slip_id) ? "S_".$val->duty_slip_id : "Not Generated"; ?></td>
												<td><?php if($val->booking_status == 1){echo "Pending";}else if($val->booking_status == 2){echo "Start Tour";}
														else if($val->booking_status == 3){echo "End Tour";}else if($val->booking_status == 4){echo "Cancel";}
														else if($val->booking_status == 5){echo "UnPaid";}else if($val->booking_status == 6){echo "Paid";} ?></td>

												<td>
													<div class="hidden-sm hidden-xs action-buttons">
														
														<?php if(!isset($val->duty_slip_id) && empty($val->duty_slip_id)) { ?>
														<a class="green" href="<?php echo base_url().'booking/update/'.$val->booking_id; ?>">
															<i class="ace-icon fa fa-pencil bigger-130" title="Edit Booking"></i>
														</a>
														<?php }?>
														<a class="red delete" href="#" id="<?php echo $val->booking_id; ?>">
															<i class="ace-icon fa fa-trash-o bigger-130" title="Delete Booking"></i>
														</a>
														<!--<a class="blue" href="#modal-table" id="<?php echo $val->booking_id; ?>" data-toggle="modal">
															<i class="ace-icon fa fa-eye bigger-130 b_details" id="<?php echo $val->booking_id; ?>"></i>
														</a>-->
														<a class="blue" href="<?php echo base_url().'booking/view/'.$val->booking_id; ?>">
															<i class="ace-icon fa fa-eye bigger-130" title="View Booking"></i>
														</a>
														<a class="blue" href="<?php echo base_url().'booking/addSlip/'.$val->booking_id; ?>">
															<i class="ace-icon fa fa-edit" title="Duty Slip"></i> 
														</a>
														<?php if(isset($val->duty_slip_id) && !empty($val->duty_slip_id) && $val->booking_status<3) { ?>
														<a class="blue" href="<?php echo base_url().'booking/generateDutyslip/'.$val->booking_id; ?>">
															<i class="ace-icon glyphicon glyphicon-print" title="Generate Duty Slip"></i>
														</a>
														<?php }?>
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
<div id="modal-table" class="modal fade" tabindex="-1">
	<div class="modal-dialog" style="margin-top:10%;">
		<div class="modal-content">
			<div class="modal-header no-padding">
				<div class="table-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
						<span class="white">&times;</span>
					</button>
					Passenger Details
				</div>
			</div>

			<div class="modal-body no-padding">
				<table class="table table-striped table-bordered table-hover no-margin-bottom no-border-top">
					<thead>
						<tr>
							<th>Name</th>
							<th>Number</th>
							<th>Pickup Address</th>
							<th>Drop Address</th>
						</tr>
					</thead>

					<tbody class="detailsBody" id="pass_data">
						
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
	$(document).on('click','.b_details', function(e){
	    e.preventDefault();
	    
        var id = $(this).attr('id');
        
        var obj = array.filter(function(obj){
            return obj.name === 'passenger-detail-view'
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
                	$('#pass_data').html(data.successMsg);

                }else{

                }
            },
            error: function (xhr, ajaxOptions, thrownError) {
                console.log(thrownError);
            }
        });
	});
</script>

<script type="text/javascript">

$(document).on('click','.b_filter', function() {
		var baseUrl = $('#baseUrl').val();
		var from_date = $("#from_date").val();
		var to_date = $("#to_date").val();
		var booking_status = $("#booking_status").val();
		var cust_type = $("#cust_type").val();
		var b_type = $("#b_type").val();

		alert("aaa");
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
		if(b_type !="" && b_type == "") {
			 b_type = 0;
		}
		window.location.href = baseUrl+"booking/bookingList/"+from_date+"/"+to_date+"/"+booking_status+"/"+cust_type+"/"+b_type;
		 
	});

$(document).on('click','.b_reset', function() {
		var baseUrl = $('#baseUrl').val();
		 
		window.location.href = baseUrl+"booking/bookingList";
		 
	});
</script>
