<div class="main-content">
	<div class="main-content-inner">
		<div class="breadcrumbs ace-save-state" id="breadcrumbs">
			<ul class="breadcrumb">
				<li>
					<i class="ace-icon fa fa-home home-icon"></i>
					<a href="#">Home</a>
				</li>

				<li>
					<a href="#">Forms</a>
				</li>
				<li class="active">Form Elements</li>
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
					<?php if($update == false): echo "Add Slip"; else: echo "Update Slip"; endif; ?>
				</h1>
			</div><!-- /.page-header -->

			<div class="row" style="margin-bottom:3%;">
				<div class="col-xs-12 col-sm-22 widget-container-col ui-sortable" id="widget-container-col-2">
					<div class="widget-box ui-sortable-handle" id="widget-box-2" style="margin-bottom:0;">
						<div class="widget-header">
							<h5 class="widget-title bigger lighter">
								Booking Details
							</h5>							
						</div>

						<div class="widget-body">
							<div class="widget-main no-padding">
								<table class="table table-striped table-bordered table-hover">
									<thead class="thin-border-bottom">
										<tr>
											<th>
												Duty Slip Id
											</th>

											<th>
												Booked By
											</th>
											<th>
												Booked Time
											</th>
											<th>
												Pickup Address
											</th>
											<th>
												Drop Address
											</th>
											<th>
												Tour
											</th>
											<th>
												Vehicle Type
											</th>

										</tr>
									</thead>

									<tbody>
										<?php
											foreach ($bookingDetails as $val) {
												echo "<tr>";
												echo "<td>"."S_".$val->duty_slip_id."</td>";
												echo "<td>".$val->user_first_name. " ".$val->user_last_name."</td>";
												echo "<td>".$val->added_on."</td>";
												echo "<td>".$val->pickup_location."</td>";
												echo "<td>".$val->drop_location."</td>";
												echo "<td>".$val->travel_type."</td>";
												echo "<td>".$val->cat_name."</td>";
												echo "</tr>";
											}
										?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
				<div class="col-xs-12 col-sm-22 widget-container-col ui-sortable" id="widget-container-col-1">
					<div class="widget-box ui-sortable-handle collapsed" id="widget-box-1" style="margin-top:0;">
						<div class="widget-header">
							<h5 class="widget-title">Passenger List</h5>

							<div class="widget-toolbar">
								

								<a href="#" data-action="collapse">
									<i class="ace-icon fa fa-chevron-up"></i>
								</a>
							</div>
						</div>
						
						<div class="widget-body" style="display:none;">
							<div class="widget-main no-padding">
								<table class="table table-striped table-bordered table-hover">
									<thead class="thin-border-bottom">
										<tr>
											<th>
												Passenger Name
											</th>

											<th>
												Passenger Number
											</th>
											<th>
												Pickup Address
											</th>
											<!--<th>
												Pickup Time
											</th>-->
											<th>
												Drop Address
											</th>
											<th>
												Booked Date
											</th>
										</tr>
									</thead>

									<tbody>
										<?php
											foreach ($passengerDetails as $val) {
												echo "<tr>";
												echo "<td>".$val->passenger_name."</td>";
												echo "<td>".$val->passenger_number."</td>";
												echo "<td>".$val->pickup_address."</td>";
												//echo "<td>".$val->pickup_time."</td>";
												echo "<td>".$val->drop_address."</td>";
												echo "<td>".$val->added_on."</td>";
												echo "</tr>";
											}
										?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>

			<form class="form-horizontal" role="form" method="post" id="<?php if($update == false): echo "dutySlip"; else: echo "updateDutySlip"; endif; ?>" enctype="multipart/form-data">

			


			<div class="row" style="margin-bottom:3%;">
				 
				<div class="col-xs-12 col-sm-22 widget-container-col ui-sortable" id="widget-container-col-1">
					<div class="widget-box ui-sortable-handle collapsed" id="widget-box-1" style="margin-top:0;">
						<div class="widget-header">
							<h5 class="widget-title">Booking Advance Payment</h5>

							<div class="widget-toolbar">
								

								<a href="#" data-action="collapse">
									<i class="ace-icon fa fa-chevron-up"></i>
								</a>
							</div>
						</div>
						
						<div class="widget-body" style="display:block;">
							<div class="widget-main no-padding">
								 <div class="form-group">
								 	<input type="hidden" id="cust_ledger_id" name="cust_ledger_id"  class="col-xs-10 form-control col-sm-5 " value="<?php if(isset($custlist)): echo trim($custlist[0]->ledger_account_id); else: echo 0; endif; ?>" />
								 	<input type="hidden" id="cust_ledger_name" name="cust_ledger_name"  class="col-xs-10 form-control col-sm-5 " value="<?php if(isset($custlist)): echo trim($custlist[0]->ledger_account_name); else: echo 0; endif; ?>" />
								 	<input type="hidden" id="pre_advance_leg_id" name="pre_advance_leg_id"  class="col-xs-10 form-control col-sm-5 " value="<?php if(isset($DutySlip)): echo trim($DutySlip[0]->advance_paid_flag); else: echo 0; endif; ?>" />
								 	<input type="hidden" id="booking_date" name="booking_date"  class="col-xs-10 form-control col-sm-5 " value="<?php if(isset($bookingDetails)): echo trim($bookingDetails[0]->booking_date); else: echo 0; endif; ?>" />
								 </div>	

								 <div class="form-group">
			                            <label class="col-sm-2 no-padding-right" for="form-field-2"> In Account</label>

			                            <div class="col-sm-4">
			                                <?php 
			                                	echo $from_select;
			                                ?>
			                                <span class="help-inline col-xs-12 col-sm-2">
			                                    <span class="middle input-text-error" id="from_ledger_errorlabel"></span>
			                                </span>
			                            </div>
			                            <label class="col-sm-2 no-padding-right" for="form-field-2"> AMOUNT</label>

			                            <div class="col-sm-4">
			                                 <input type="text" id="payment_amount" name="payment_amount" <?php if(isset($DutySlip[0]->advance_paid) && !empty($DutySlip[0]->advance_paid)) echo 'readonly';?> placeholder="Enter Amount" class="col-xs-10 col-sm-9 "  onKeyUp="javascript:return check_isammount(event,this);" onblur="sanitize_float(event,this);" value="<?php if(isset($DutySlip)): echo trim($DutySlip[0]->advance_paid); endif; ?>" />
			                                <span class="help-inline col-xs-12 col-sm-7">
			                                    <span class="middle input-text-error" id="payment_amount_errorlabel"></span>
			                                </span>
			                            </div>
		                              
		                   			 </div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="row" style="margin-bottom:3%;">
				 
				<div class="col-xs-12 col-sm-22 widget-container-col ui-sortable" id="widget-container-col-1">
					<div class="widget-box ui-sortable-handle collapsed" id="widget-box-1" style="margin-top:0;">
						<div class="widget-header">
							<h5 class="widget-title">OutSource Booking</h5>

							<div class="widget-toolbar">
								

								<a href="#" data-action="collapse">
									<i class="ace-icon fa fa-chevron-up"></i>
								</a>
							</div>
						</div>
						
						<div class="widget-body" style="display:block;">
							<div class="widget-main no-padding">
								<div class="form-group">
									 

									</div>
								 <div class="form-group">
										 

								<label class="col-sm-2  no-padding-right" data-toggle="tooltip" title="Select Vendor if Booking Outsource!!" for=""><b class="red"><i><u>Select Vendor</u></i></b></label>

								<div class="col-sm-4">
									<input type="hidden" id="pre_vendor_id" name="pre_vendor_id"  class="col-xs-10 form-control col-sm-5 " value="<?php if(isset($DutySlip)): echo trim($DutySlip[0]->vendor_id); else: echo 0; endif; ?>" />
									<select class="chosen-select form-control"  name="vendor" id="vendor" data-placeholder="Choose a vendor...">
										<?php
											/*if(isset($selectDriver)){
												echo '<option value="'.$selectDriver[0]->driver_id.'">'.$selectDriver[0]->driver_fname.' '.$selectDriver[0]->driver_lname.'</option>';
											}*/
											echo "<option selected value='0'>---None---</option>";
											foreach ($vendorlist as $val) {
												if($DutySlip[0]->vendor_id == $val->vendor_id)
												echo '<option selected value="'.$val->vendor_id.'">'.$val->vendor_name.'</option>';
												else 
												echo '<option value="'.$val->vendor_id.'">'.$val->vendor_name.'</option>';	
											}
										?>
									</select>
								</div>
									<?php if(isset($DutySlip[0]) && $DutySlip[0]->status >= 2){ ?>
									<label class="col-sm-2  no-padding-right" for="">Commision A/m</label>

									<div class="col-sm-3">
										<input type="text" id="vendor_fess" <?php if(!isset($DutySlip[0]->vendor_id) && $DutySlip[0]->vendor_id <= 0 ) echo 'disabled';?> name="vendor_fess" onKeyUp="javascript:return check_isammount(event,this);" onblur="sanitize_float(event,this);" name="toll_fess" placeholder="Enter Toll Fess" class="col-xs-10 form-control col-sm-5 " value="<?php if(isset($DutySlip)): echo trim($DutySlip[0]->commision_amount); endif; ?>" />
										<span class="help-inline col-xs-12 col-sm-7">
											<span class="middle input-text-error" id="vendor_fess_errorlabel"></span>
										</span>
									</div>
									<?php }?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>



			 <div class="row" style="margin-bottom:3%;">
				 
				<div class="col-xs-12 col-sm-22 widget-container-col ui-sortable" id="widget-container-col-1">
					<div class="widget-box ui-sortable-handle collapsed" id="widget-box-1" style="margin-top:0;">
						<div class="widget-header">
							<h5 class="widget-title">Booking Expense</h5>

							<div class="widget-toolbar">
								

								<a href="#" data-action="collapse">
									<i class="ace-icon fa fa-chevron-up"></i>
								</a>
							</div>
						</div>
						
						<div class="widget-body" style="display:block;">
							<div class="widget-main no-padding">
								 <div class="form-group">
								 </div>	

								 	<label class="col-sm-2 no-padding-right" for="form-field-2"> From Account</label>

			                            <div class="col-sm-4">
			                                <?php 
			                                	echo $driver_payment;
			                                ?>
			                                <span class="help-inline col-xs-12 col-sm-2">
			                                    <span class="middle input-text-error" id="driver_payment_errorlabel"></span>
			                                </span>
			                            </div>


									<div class="form-group">
											<label class="col-sm-2  no-padding-right">Advance Paid</label>

											<div class="col-sm-3">
												<input type="text" <?php if($DutySlip[0]->status>=3) echo "readonly";?> id="advance_paid" name="driver_advance_paid" onKeyUp="javascript:return check_isammount(event,this);" onblur="sanitize_float(event,this);" placeholder="Enter Total Hrs" class="col-xs-10 form-control col-sm-5 " value="<?php if(isset($DutySlip)): echo trim($DutySlip[0]->driver_advance_paid); else: echo 0; endif; ?>" />
												<span class="help-inline col-xs-12 col-sm-7">
													<span class="middle input-text-error" id="advance_paid_errorlabel"></span>
												</span>
											</div>

											
										</div>
									 
									<div class="form-group" style="float-left:50%;">

										<label class="col-sm-2  no-padding-right" for=""> Return</label>

										<div class="col-sm-4">
											<input type="text" id="advance_return" <?php if($DutySlip[0]->status>=3) echo "readonly";?> name="driver_advance_return" onKeyUp="javascript:return check_isammount(event,this);" onblur="sanitize_float(event,this);" placeholder="Enter Extra Hrs" class="col-xs-10 form-control col-sm-5 " value="<?php if(isset($DutySlip)): echo trim($DutySlip[0]->driver_advance_return); else: echo 0; endif; ?>" />
											<span class="help-inline col-xs-12 col-sm-7">
												<span class="middle input-text-error" id="advance_return_errorlabel"></span>
											</span>
										</div>

										<label class="col-sm-2  no-padding-right" for="">Total Expense</label>

										<div class="col-sm-3">
											<input type="text" id="total_expense" name="total_expense" onKeyUp="javascript:return check_isammount(event,this);" onblur="sanitize_float(event,this);"   placeholder="Total Expense" class="col-xs-10 form-control col-sm-5 " value="<?php if(isset($DutySlip)): echo trim($DutySlip[0]->total_advance_expense); else: echo 0; endif; ?>" readonly/>
											<span class="help-inline col-xs-12 col-sm-7">
												<span class="middle input-text-error" id="total_expense_errorlabel"></span>
											</span>
										</div>

										 
									</div>


							</div>
						</div>
					</div>
				</div>
			</div> 


			<div class="row">
				<div class="col-xs-12">
					<div class="widget-box">
						<div class="widget-header">
							<h4 class="widget-title"><?php if($update == false): echo "Add Slip"; else: echo "Update Slip"; endif; ?></h4>
						</div>
						<div class="widget-body">
							<div class="widget-main">
								<div class="alert-box"></div>
								<!-- PAGE CONTENT BEGINS -->
									

									<div class="form-group"></div>
									<div class="form-group">
										<label class="col-sm-2  no-padding-right" for="">Customer Name</label>
										<input type="hidden" id="cust_type_id" name="cust_type_id" placeholder="Customer name" class="col-xs-10 form-control col-sm-5" value="<?php if(isset($cust_type_id)): echo trim($cust_type_id); endif; ?>" readonly/>
										<input type="hidden" id="cust_id" name="cust_id" placeholder="Customer id" class="col-xs-10 form-control col-sm-5" value="<?php if(isset($cust_id)): echo trim($cust_id); endif; ?>" readonly/>
										<div class="col-sm-4">
											<input type="text" id="cust_name" name="cust_name" placeholder="Customer name" class="col-xs-10 form-control col-sm-5" value="<?php if(isset($cust_name)): echo trim($cust_name); endif; ?>" readonly/>
											 
										</div>

										<label class="col-sm-2  no-padding-right" for="" data-toggle="tooltip" title="Select When Tour End" for="">Customer Type</label>

										<div class="col-sm-4">
											<input type="text" id="cust_type" name="cust_type" placeholder="Customer Type" class="col-xs-10 form-control col-sm-5" value="<?php if(isset($cust_type)): echo trim($cust_type); endif; ?>" readonly/>
											 
										</div>
									</div>
 			
									<div class="form-group">
										<label class="col-sm-2  no-padding-right" for="">Select Vehicle</label>

										<div class="col-sm-4">
											<select class="chosen-select form-control" name="vehicle" id="form-field-select-3" data-placeholder="Choose a State...">
												<?php
													/*if(isset($selectVehicle)){
														echo '<option value="'.$selectVehicle[0]->vehicle_id.'">'.$selectVehicle[0]->vehicle_no.' xyz</option>';
													}*/
													foreach ($vehicleList as $val) {
														if($selectVehicle[0]->vehicle_id == $val->vehicle_id) 
														echo '<option selected value="'.$val->vehicle_id.'">'.$val->vehicle_no.'</option>';
														else 
														echo '<option value="'.$val->vehicle_id.'">'.$val->vehicle_no.'</option>';	
													}
												?>
												
											</select>
										</div>

										<label class="col-sm-2  no-padding-right" for="">Select Driver</label>

										<div class="col-sm-4">
											<select class="chosen-select form-control" name="driver" id="form-field-select-3" data-placeholder="Choose a State...">
												<?php
													/*if(isset($selectDriver)){
														echo '<option value="'.$selectDriver[0]->driver_id.'">'.$selectDriver[0]->driver_fname.' '.$selectDriver[0]->driver_lname.'</option>';
													}*/
													foreach ($driverList as $val) {
														if($selectDriver[0]->driver_id == $val->driver_id)
														echo '<option selected value="'.$val->driver_id.'">'.$val->driver_fname.' '.$val->driver_lname.'</option>';
														else 
														echo '<option value="'.$val->driver_id.'">'.$val->driver_fname.' '.$val->driver_lname.'</option>';	
													}
												?>
												
											</select>
										</div>
									</div>
									<div class="form-group"></div>
									<div class="form-group">
										<label class="col-sm-2  no-padding-right" for="">Start Date</label>

										<div class="col-sm-4">
											<input type="text" id="start_date" name="start_date" placeholder="Enter Start Date" class="col-xs-10 form-control col-sm-5  date-picker" value="<?php if(isset($DutySlip)): echo trim($DutySlip[0]->start_date); endif; ?>" />
											<span class="help-inline col-xs-12 col-sm-7">
												<span class="middle input-text-error" id="start_date_errorlabel"></span>
											</span>
										</div>

										<label class="col-sm-2  no-padding-right" for="" data-toggle="tooltip" title="Select When Tour End" for=""><b class="red"><i><u>End Date</u></i></b></label>

										<div class="col-sm-4">
											<input type="text" id="end_date" name="end_date" placeholder="Enter End Date" class="col-xs-10 form-control col-sm-5  date-picker" value="<?php if(isset($DutySlip) && $DutySlip[0]->end_date != "0000-00-00 00:00:00"): echo trim($DutySlip[0]->end_date); endif; ?>"/>
											<span class="help-inline col-xs-12 col-sm-7">
												<span class="middle input-text-error" id="end_date_errorlabel"></span>
											</span>
										</div>
									</div>
									<div class="form-group"></div>
									<div class="form-group">
										<label class="col-sm-2  no-padding-right" for="">Start kms</label>

										<div class="col-sm-4">
											<input type="text" id="start_km" onKeyUp="javascript:return check_isammount(event,this);" onblur="sanitize_float(event,this);" name="start_km" placeholder="Enter Start kms" class="col-xs-10 form-control col-sm-5 " value="<?php if(isset($DutySlip)): echo trim($DutySlip[0]->start_km); else: echo 0; endif; ?>" />
											<span class="help-inline col-xs-12 col-sm-7">
												<span class="middle input-text-error" id="start_km_errorlabel"></span>
											</span>
										</div>

										<label class="col-sm-2  no-padding-right" for="">End kms</label>

										<div class="col-sm-4">
											<input type="text" id="end_km" onKeyUp="javascript:return check_isammount(event,this);" onblur="sanitize_float(event,this);" name="end_km" placeholder="Enter End kms" class="col-xs-10 form-control col-sm-5 " value="<?php if(isset($DutySlip)): echo trim($DutySlip[0]->end_km); else: echo 0; endif; ?>" />
											<span class="help-inline col-xs-12 col-sm-7">
												<span class="middle input-text-error" id="end_km_errorlabel"></span>
											</span>
										</div>
									</div>
									<div class="form-group"></div>
									<div class="form-group">
										<label class="col-sm-2  no-padding-right" for="">Total kms</label>

										<div class="col-sm-4">
											<input type="text" id="total_km" onKeyUp="javascript:return check_isammount(event,this);" onblur="sanitize_float(event,this);" name="total_km" placeholder="Enter Total kms" class="col-xs-10 form-control col-sm-5 " value="<?php if(isset($DutySlip)): echo trim($DutySlip[0]->total_kms); else: echo 0; endif; ?>" readonly/>
											<span class="help-inline col-xs-12 col-sm-7">
												<span class="middle input-text-error" id="total_km_errorlabel"></span>
											</span>
										</div>

										<label class="col-sm-2  no-padding-right" for="">Extra kms</label>

										<div class="col-sm-4">
											<input type="text" id="extra_kms" onKeyUp="javascript:return check_isammount(event,this);" onblur="sanitize_float(event,this);" name="extra_kms" placeholder="Enter Extra kms" class="col-xs-10 form-control col-sm-5 " value="<?php if(isset($DutySlip)): echo trim($DutySlip[0]->extra_kms); else: echo 0; endif; ?>" readonly/>
											<span class="help-inline col-xs-12 col-sm-7">
												<span class="middle input-text-error" id="extra_kms_errorlabel"></span>
											</span>
										</div>
									</div>

									<div class="form-group"></div>
									<div class="form-group">
										<label class="col-sm-2  no-padding-right" for="">Start Time</label>

										<div class="col-sm-4">
											<input type="text" id="start_time"   name="start_time" placeholder="Enter Start Time" class="col-xs-10 form-control col-sm-5 date-timepicker1" value="<?php if(isset($DutySlip)): echo $newDateTime = date('d/m/Y h:i A', strtotime($DutySlip[0]->start_time)); endif; ?>"  />

											<span class="help-inline col-xs-12 col-sm-7">
												<span class="middle input-text-error" id="start_time_errorlabel"></span>
											</span>
										</div>

										<label class="col-sm-2  no-padding-right" for="">End Time</label>

										<div class="col-sm-4">
											<input type="text" id="end_time"  name="end_time" placeholder="Enter End Time" class="col-xs-10 form-control col-sm-5 date-timepicker1"  value="<?php if(isset($DutySlip)): echo $newDateTime = date('d/m/Y h:i A', strtotime($DutySlip[0]->end_time)); endif; ?>"  />
											<span class="help-inline col-xs-12 col-sm-7">
												<span class="middle input-text-error" id="end_time_errorlabel"></span>
											</span>
										</div>
									</div>
									<div class="form-group"></div>
									<div class="form-group">
										<label class="col-sm-2  no-padding-right">Total Hrs</label>

										<div class="col-sm-4">
											<input type="text" id="total_hrs" onKeyUp="javascript:return check_isammount(event,this);" onblur="sanitize_float(event,this);" name="total_hrs" placeholder="Enter Total Hrs" class="col-xs-10 form-control col-sm-5 " value="<?php if(isset($DutySlip)): echo trim($DutySlip[0]->total_hrs); else: echo 0; endif; ?>" readonly/>
											<span class="help-inline col-xs-12 col-sm-7">
												<span class="middle input-text-error" id="total_hrs_errorlabel"></span>
											</span>
										</div>

										<label class="col-sm-2  no-padding-right" for="">Extra Hrs</label>

										<div class="col-sm-4">
											<input type="text" id="extra_hrs" name="extra_hrs" onKeyUp="javascript:return check_isammount(event,this);" onblur="sanitize_float(event,this);" placeholder="Enter Extra Hrs" class="col-xs-10 form-control col-sm-5 " value="<?php if(isset($DutySlip)): echo trim($DutySlip[0]->extra_hrs); else: echo 0; endif; ?>" readonly/>
											<span class="help-inline col-xs-12 col-sm-7">
												<span class="middle input-text-error" id="extra_hrs_errorlabel"></span>
											</span>
										</div>
									</div>
									<div class="form-group">
										
									</div>
									<div class="form-group">
										<label class="col-sm-2  no-padding-right" for="">Toll Fees</label>

										<div class="col-sm-4">
											<input type="text" id="toll_fess" onKeyUp="javascript:return check_isammount(event,this);" onblur="sanitize_float(event,this);" name="toll_fess" placeholder="Enter Toll Fess" class="col-xs-10 form-control col-sm-5 " value="<?php if(isset($DutySlip)): echo trim($DutySlip[0]->toll_fess); else: echo 0; endif; ?>" />
											<span class="help-inline col-xs-12 col-sm-7">
												<span class="middle input-text-error" id="toll_fess_errorlabel"></span>
											</span>
										</div>

										<label class="col-sm-2  no-padding-right" for="">Parking Fees</label>

										<div class="col-sm-4">
											<input type="text" id="parking_fees" name="parking_fees" onKeyUp="javascript:return check_isammount(event,this);" onblur="sanitize_float(event,this);" placeholder="Enter Parking Fees" class="col-xs-10 form-control col-sm-5 " value="<?php if(isset($DutySlip)): echo trim($DutySlip[0]->parking_fees); else: echo 0; endif; ?>" />
											<span class="help-inline col-xs-12 col-sm-7">
												<span class="middle input-text-error" id="parking_fees_errorlabel"></span>
											</span>
										</div>
									</div>
									<div class="form-group">
										
									</div>
									<div class="form-group">
										
										<input type="hidden" name="booking_id" value="<?php echo $booking_id; ?>">
										<input type="hidden" name="duty_sleep_id" value="<?php if(isset($DutySlip)): echo trim($DutySlip[0]->duty_sleep_id); endif; ?>">

										<label class="col-sm-2  no-padding-right" for="">Total Amt</label>

										<div class="col-sm-4">
											<input type="text" id="total_amt" name="total_amt" placeholder="Enter Total Amt" class="col-xs-10 form-control col-sm-5 " value="<?php if(isset($DutySlip)): echo trim($DutySlip[0]->total_amt); else: echo 0; endif; ?>" readonly/>
											<span class="help-inline col-xs-12 col-sm-7">
												<span class="middle input-text-error" id="total_amt_errorlabel"></span>
											</span>
										</div>

										<label class="col-sm-2  no-padding-right" for="">Comments</label>

										<div class="col-sm-4">
											<input type="text" id="comments" name="comments" placeholder="Enter Comments" class="col-xs-10 form-control col-sm-5 " value="<?php if(isset($DutySlip)): echo trim($DutySlip[0]->comments); endif; ?>" />
											<span class="help-inline col-xs-12 col-sm-7">
												<span class="middle input-text-error" id="comments_errorlabel"></span>
											</span>
										</div>
									</div>
									<div class="form-group">
										
									</div>
									<div class="form-group">
										<label class="col-sm-2  no-padding-right" for="">Payment Status</label>

										<div class="col-sm-4">
											<input type="text" name="payment_status" class="col-xs-10 form-control col-sm-5 " value="<?php 
													if(isset($DutySlip)): 
														if($DutySlip[0]->payment_status == 1){
															echo "Paid";
														}else{
															echo "Unpaid";
														}
													else: 
														echo "Unpaid"; 
													endif; 
												?>" readonly />
										</div>


										<label class="col-sm-2  no-padding-right" for="">Tour Status</label>

										<div class="col-sm-4">
											<select <?php if($DutySlip[0]->status >=3) echo "disabled";?> data-placeholder="Select Status" name="tour_status" id="tour_status" class="chosen-select form-control" style="display: none;">
			                                    <option <?php if(isset($DutySlip) && $DutySlip[0]->status == 1) { echo "selected"; }?> value="1">Pending</option>
			                                    <option value="2" <?php if(isset($DutySlip) &&  $DutySlip[0]->status == 2) { echo "selected"; }?>>On Tour</option>
			                                    <option value="3" <?php if(isset($DutySlip) &&  $DutySlip[0]->status == 3) { echo "selected"; }?>>End Tour</option>
			                                    <option disabled <?php if(isset($DutySlip) && $DutySlip[0]->status == 4) { echo "selected"; }?> value="4">Cancel</option>
			                                    <option disabled <?php if(isset($DutySlip) && $DutySlip[0]->status == 5) { echo "selected"; }?> value="5">UnPaid</option>
			                                    <option disabled value="6" <?php if(isset($DutySlip) &&  $DutySlip[0]->status == 6) { echo "selected"; }?>>Paid</option>
			                                    
			                                </select>
			                                <span class="help-inline col-xs-12 col-sm-7">
			                                    <span class="middle input-text-error" id="tour_status_errorlabel"></span>
			                                </span>
										</div>

										 

									</div>
									<div class="form-group">
										
									</div>
									
									<div class="clearfix form-actions">
										<div class="col-md-offset-3 col-md-9">
											<?php   if(isset($DutySlip[0]->payment_status) ||  $DutySlip[0]->status < 3 ) { ?>
											<button class="btn btn-info test" type="submit">
												<i class="iconvehicle"></i>
												
													<?php if(isset($update) && $update == true){
														echo "Update";
													}else{
														echo "Submit";
													} ?>
											</button>
											<?php } ?>

											&nbsp; &nbsp; &nbsp;
											<button class="btn" type="reset">
												<i class="ace-icon fa fa-undo bigger-110"></i>
												Reset
											</button>
										</div>
									</div>
								<!--</form>-->
							</div>
						</div>
					</div>
				</div><!-- /.col -->
			</div><!-- /.row -->

		</form>
		</div><!-- /.page-content -->
	</div>
</div><!-- /.main-content -->

<!-- basic scripts -->
<style>
	optgroup{
		color: black;
		font-size: 15px;
		font-weight: bold;
	}
	#driver_payment{
		height:15%;
		width: 100%;
	}
	#from_ledger{
		height:15%;
		width: 100%;
	}
	option {
    padding: 3px 4px 5px 35px !important;
	}
</style>
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

<script src="<?php echo base_url(); ?>js/custom.js"></script>
<script src="<?php echo base_url(); ?>js/form-validation.js"></script>

<!-- inline scripts related to this page -->

<script>
    $( document ).ready(function() {    

         var from_val = <?php echo isset($from_selectd_ledger_id) ? $from_selectd_ledger_id : "0"?>;
        
        $("#from_ledger").find("option[value=" + from_val +"]").attr('selected', true);
        
        if(from_val!="" && from_val>0) {
        	 
        	$("#from_ledger option:not(:selected)").prop('disabled','true');
        }	


        //for driver default ledger patty cash

        var driver_val = <?php echo isset($driver_selectd_ledger_id) ? $driver_selectd_ledger_id : "0"?>;
        
        $("#driver_payment").find("option[value=" + driver_val +"]").attr('selected', true);
        
        if(driver_val!="" && driver_val>0) {
        	 
        	$("#driver_payment option:not(:selected)").prop('disabled','true');
        }	
       }); 

</script> 
<script type="text/javascript">
	jQuery(function($) {
		$('#id-disable-check').on('click', function() {
			var inp = $('#form-input-readonly').get(0);
			if(inp.hasAttribute('disabled')) {
				inp.setAttribute('readonly' , 'true');
				inp.removeAttribute('disabled');
				inp.value="This text field is readonly!";
			}
			else {
				inp.setAttribute('disabled' , 'disabled');
				inp.removeAttribute('readonly');
				inp.value="This text field is disabled!";
			}
		});

		$('#vendor').on('change', function() {
			var vendor = $('#vendor').val();
			if(vendor!="" && vendor!=0){
				$('#vendor_fess').prop('disabled',false);

			} else {
				$('#vendor_fess').prop('disabled',true);
			}
		});

		$('#from_ledger').on('change', function() {
			var from_ledger = $('#from_ledger').val();
			if(from_ledger!="" && from_ledger!=0){
				$('#payment_amount').prop('readonly',false);

			} else {
				$('#payment_amount').prop('readonly',true);
			}
		});

		$('#driver_payment').on('change', function() {
			var driver_payment = $('#driver_payment').val();
			if(driver_payment!="" && driver_payment!=0){
				$('#advance_paid').prop('readonly',false);
				$('#advance_return').prop('readonly',false);

			} else {
				$('#advance_paid').prop('readonly',true);
				$('#advance_return').prop('readonly',true);
			}
		});
	
	
		if(!ace.vars['touch']) {
			$('.chosen-select').chosen({allow_single_deselect:true}); 
			//resize the chosen on window resize
	
			$(window)
			.off('resize.chosen')
			.on('resize.chosen', function() {
				$('.chosen-select').each(function() {
					 var $this = $(this);
					 $this.next().css({'width': $this.parent().width()});
				})
			}).trigger('resize.chosen');
			//resize chosen on sidebar collapse/expand
			$(document).on('settings.ace.chosen', function(e, event_name, event_val) {
				if(event_name != 'sidebar_collapsed') return;
				$('.chosen-select').each(function() {
					 var $this = $(this);
					 $this.next().css({'width': $this.parent().width()});
				})
			});
	
	
			$('#chosen-multiple-style .btn').on('click', function(e){
				var target = $(this).find('input[type=radio]');
				var which = parseInt(target.val());
				if(which == 2) $('#form-field-select-4').addClass('tag-input-style');
				 else $('#form-field-select-4').removeClass('tag-input-style');
			});
		}
	
	
		$('[data-rel=tooltip]').tooltip({container:'body'});
		$('[data-rel=popover]').popover({container:'body'});
	
		autosize($('textarea[class=autosize]'));
		
		$('textarea.limited').inputlimiter({
			remText: '%n character%s remaining...',
			limitText: 'max allowed : %n.'
		});
	
		$.mask.definitions['~']='[+-]';
		$('.input-mask-date').mask('99/99/9999');
		$('.input-mask-phone').mask('(999) 999-9999');
		$('.input-mask-eyescript').mask('~9.99 ~9.99 999');
		$(".input-mask-product").mask("a-999-a999",{placeholder:" ",completed:function(){alert("You typed the following: "+this.val());}});
	
	
	
		$( "#input-size-slider" ).css('width','200px').slider({
			value:1,
			range: "min",
			min: 1,
			max: 8,
			step: 1,
			slide: function( event, ui ) {
				var sizing = ['', 'input-sm', 'input-lg', 'input-mini', 'input-small', 'input-medium', 'input-large', 'input-xlarge', 'input-xxlarge'];
				var val = parseInt(ui.value);
				$('#form-field-4').attr('class', sizing[val]).attr('placeholder', '.'+sizing[val]);
			}
		});
	
		$( "#input-span-slider" ).slider({
			value:1,
			range: "min",
			min: 1,
			max: 12,
			step: 1,
			slide: function( event, ui ) {
				var val = parseInt(ui.value);
				$('#form-field-5').attr('class', 'col-xs-'+val).val('.col-xs-'+val);
			}
		});
	
	
		
		//"jQuery UI Slider"
		//range slider tooltip example
		$( "#slider-range" ).css('height','200px').slider({
			orientation: "vertical",
			range: true,
			min: 0,
			max: 100,
			values: [ 17, 67 ],
			slide: function( event, ui ) {
				var val = ui.values[$(ui.handle).index()-1] + "";
	
				if( !ui.handle.firstChild ) {
					$("<div class='tooltip right in' style='display:none;left:16px;top:-6px;'><div class='tooltip-arrow'></div><div class='tooltip-inner'></div></div>")
					.prependTo(ui.handle);
				}
				$(ui.handle.firstChild).show().children().eq(1).text(val);
			}
		}).find('span.ui-slider-handle').on('blur', function(){
			$(this.firstChild).hide();
		});
		
		
		$( "#slider-range-max" ).slider({
			range: "max",
			min: 1,
			max: 10,
			value: 2
		});
		
		$( "#slider-eq > span" ).css({width:'90%', 'float':'left', margin:'15px'}).each(function() {
			// read initial values from markup and remove that
			var value = parseInt( $( this ).text(), 10 );
			$( this ).empty().slider({
				value: value,
				range: "min",
				animate: true
				
			});
		});
		
		$("#slider-eq > span.ui-slider-purple").slider('disable');//disable third item
	
		
		$('#id-input-file-1 , #id-input-file-2').ace_file_input({
			no_file:'No File ...',
			btn_choose:'Choose',
			btn_change:'Change',
			droppable:false,
			onchange:null,
			thumbnail:false //| true | large
			//whitelist:'gif|png|jpg|jpeg'
			//blacklist:'exe|php'
			//onchange:''
			//
		});
		//pre-show a file name, for example a previously selected file
		//$('#id-input-file-1').ace_file_input('show_file_list', ['myfile.txt'])
	
	
		$('.id-input-file-3').ace_file_input({
			style: 'well',
			btn_choose: 'Drop files here or click to choose',
			btn_change: null,
			no_icon: 'ace-icon fa fa-cloud-upload',
			droppable: true,
			thumbnail: 'small'//large | fit
			//,icon_remove:null//set null, to hide remove/reset button
			,before_change:function(files, dropped) {
				//Check an example below
				//or examples/file-upload.html
				return true;
			}
			,before_remove : function() {
				return true;
			}
			,
			preview_error : function(filename, error_code) {
				//name of the file that failed
				//error_code values
				//1 = 'FILE_LOAD_FAILED',
				//2 = 'IMAGE_LOAD_FAILED',
				//3 = 'THUMBNAIL_FAILED'
				//alert(error_code);
			}
	
		}).on('change', function(){
			//console.log($(this).data('ace_input_files'));
			//console.log($(this).data('ace_input_method'));
		});
		
		
		//$('#id-input-file-3')
		//.ace_file_input('show_file_list', [
			//{type: 'image', name: 'name of image', path: 'http://path/to/image/for/preview'},
			//{type: 'file', name: 'hello.txt'}
		//]);
	
		
	
		$('#spinner1').ace_spinner({value:0,min:0,max:200,step:10, btn_up_class:'btn-info' , btn_down_class:'btn-info'})
		.closest('.ace-spinner')
		.on('changed.fu.spinbox', function(){
			//console.log($('#spinner1').val())
		}); 
		$('#spinner2').ace_spinner({value:0,min:0,max:10000,step:100, touch_spinner: true, icon_up:'ace-icon fa fa-caret-up bigger-110', icon_down:'ace-icon fa fa-caret-down bigger-110'});
		$('#spinner3').ace_spinner({value:0,min:-100,max:100,step:10, on_sides: true, icon_up:'ace-icon fa fa-plus bigger-110', icon_down:'ace-icon fa fa-minus bigger-110', btn_up_class:'btn-success' , btn_down_class:'btn-danger'});
		$('#spinner4').ace_spinner({value:0,min:-100,max:100,step:10, on_sides: true, icon_up:'ace-icon fa fa-plus', icon_down:'ace-icon fa fa-minus', btn_up_class:'btn-purple' , btn_down_class:'btn-purple'});
	
		//$('#spinner1').ace_spinner('disable').ace_spinner('value', 11);
		//or
		//$('#spinner1').closest('.ace-spinner').spinner('disable').spinner('enable').spinner('value', 11);//disable, enable or change value
		//$('#spinner1').closest('.ace-spinner').spinner('value', 0);//reset to 0
	
	
		//datepicker plugin
		//link
		$('.date-picker').datepicker({
			format: 'yyyy-mm-dd',
			autoclose: true,
			todayHighlight: true
		})
		//show datepicker when clicking on the icon
		.next().on(ace.click_event, function(){
			$(this).prev().focus();
		});
	
		//or change it into a date range picker
		$('.input-daterange').datepicker({autoclose:true});
	
	
		//to translate the daterange picker, please copy the "examples/daterange-fr.js" contents here before initialization
		$('input[name=date-range-picker]').daterangepicker({
			'applyClass' : 'btn-sm btn-success',
			'cancelClass' : 'btn-sm btn-default',
			locale: {
				applyLabel: 'Apply',
				cancelLabel: 'Cancel',
			}
		})
		.prev().on(ace.click_event, function(){
			$(this).next().focus();
		});
	
	
		$('#timepicker1').timepicker({
			minuteStep: 1,
			showSeconds: true,
			showMeridian: false,
			disableFocus: true,
			icons: {
				up: 'fa fa-chevron-up',
				down: 'fa fa-chevron-down'
			}
		}).on('focus', function() {
			$('#timepicker1').timepicker('showWidget');
		}).next().on(ace.click_event, function(){
			$(this).prev().focus();
		});
		
		
	
		
		if(!ace.vars['old_ie']) $('.date-timepicker1').datetimepicker({
		 format: 'DD/MM/YYYY h:mm:ss A',//use this option to display seconds
		 icons: {
			time: 'fa fa-clock-o',
			date: 'fa fa-calendar',
			up: 'fa fa-chevron-up',
			down: 'fa fa-chevron-down',
			previous: 'fa fa-chevron-left',
			next: 'fa fa-chevron-right',
			today: 'fa fa-arrows ',
			clear: 'fa fa-trash',
			close: 'fa fa-times'
		 }
		}).next().on(ace.click_event, function(){
			$(this).prev().focus();
		});
		
	
		$('#colorpicker1').colorpicker();
		//$('.colorpicker').last().css('z-index', 2000);//if colorpicker is inside a modal, its z-index should be higher than modal'safe
	
		$('#simple-colorpicker-1').ace_colorpicker();
		//$('#simple-colorpicker-1').ace_colorpicker('pick', 2);//select 2nd color
		//$('#simple-colorpicker-1').ace_colorpicker('pick', '#fbe983');//select #fbe983 color
		//var picker = $('#simple-colorpicker-1').data('ace_colorpicker')
		//picker.pick('red', true);//insert the color if it doesn't exist
	
	
		$(".knob").knob();
		
		
		var tag_input = $('#form-field-tags');
		try{
			tag_input.tag(
			  {
				placeholder:tag_input.attr('placeholder'),
				//enable typeahead by specifying the source array
				source: ace.vars['US_STATES'],//defined in ace.js >> ace.enable_search_ahead
				
				//or fetch data from database, fetch those that match "query"
				source: function(query, process) {
				  $.ajax({url: 'remote_source.php?q='+encodeURIComponent(query)})
				  .done(function(result_items){
					process(result_items);
				  });
				}
				
			  }
			)
	
			//programmatically add/remove a tag
			var $tag_obj = $('#form-field-tags').data('tag');
			$tag_obj.add('Programmatically Added');
			
			var index = $tag_obj.inValues('some tag');
			$tag_obj.remove(index);
		}
		catch(e) {
			//display a textarea for old IE, because it doesn't support this plugin or another one I tried!
			tag_input.after('<textarea id="'+tag_input.attr('id')+'" name="'+tag_input.attr('name')+'" rows="3">'+tag_input.val()+'</textarea>').remove();
			//autosize($('#form-field-tags'));
		}
		
		if(!ace.vars['old_ie']) $('.date-timepicker1').datetimepicker({
		 //format: 'MM/DD/YYYY h:mm:ss A',//use this option to display seconds
		 format: 'DD/MM/YYYY h:mm A',//use this option to display seconds
		 icons: {
			time: 'fa fa-clock-o',
			date: 'fa fa-calendar',
			up: 'fa fa-chevron-up',
			down: 'fa fa-chevron-down',
			previous: 'fa fa-chevron-left',
			next: 'fa fa-chevron-right',
			today: 'fa fa-arrows ',
			clear: 'fa fa-trash',
			close: 'fa fa-times'
		 }
		}).next().on(ace.click_event, function(){
			$(this).prev().focus();
		});
		/////////
		$('#modal-form input[type=file]').ace_file_input({
			style:'well',
			btn_choose:'Drop files here or click to choose',
			btn_change:null,
			no_icon:'ace-icon fa fa-cloud-upload',
			droppable:true,
			thumbnail:'large'
		})
		
		//chosen plugin inside a modal will have a zero width because the select element is originally hidden
		//and its width cannot be determined.
		//so we set the width after modal is show
		$('#modal-form').on('shown.bs.modal', function () {
			if(!ace.vars['touch']) {
				$(this).find('.chosen-container').each(function(){
					$(this).find('a:first-child').css('width' , '210px');
					$(this).find('.chosen-drop').css('width' , '210px');
					$(this).find('.chosen-search input').css('width' , '200px');
				});
			}
		})
		
		//or you can activate the chosen plugin after modal is shown
		//this way select element becomes visible with dimensions and chosen works as expected
		$('#modal-form').on('shown', function () {
			$(this).find('.modal-chosen').chosen();
		})
		
	
		
		
		$(document).one('ajaxloadstart.page', function(e) {
			autosize.destroy('textarea[class=autosize]')
			
			$('.limiterBox,.autosizejs').remove();
			$('.daterangepicker.dropdown-menu,.colorpicker.dropdown-menu,.bootstrap-datetimepicker-widget.dropdown-menu').remove();
		});


		var package_amt = '<?php echo $package_amt; ?>'; 
		var hours = '<?php echo $hours; ?>'; 
		var charge_hour = '<?php echo $charge_hour; ?>'; 
		var distance = '<?php echo $distance; ?>'; 
		var charge_distance = '<?php echo $charge_distance; ?>'; 
		

		$(document).on('keyup', '#total_km', function(){
			calculateSlip(distance,hours);
		});

		$(document).on('keyup', '#total_hrs', function(){
			calculateSlip(distance,hours);
		});

		$(document).on('keyup', '#toll_fess', function(){
			calculateSlip(distance,hours);
		});

		$(document).on('keyup', '#parking_fees', function(){
			calculateSlip(distance,hours);
		});

		$(document).on('keyup', '#advance_paid', function(){
			calculateexpense();
		});

		$(document).on('keyup', '#advance_return', function(){
			calculateexpense();
		});


		$(document).on('keyup', '#start_km', function(){
			calculatetotalkm();
		});

		$(document).on('keyup', '#end_km', function(){
			calculatetotalkm();
		});

		$(document).on('keyup', '#start_time', function(){
			calculatetotalhours();
		});

		$(document).on('keyup', '#end_time', function(){
			calculatetotalhours();
		});

		$(document).on('blur', '#start_time', function(){
			calculatetotalhours();
		});

		$(document).on('blur', '#end_time', function(){
			calculatetotalhours();
		});


		function calculatetotalhours(){
			var start_time = $('#start_time').val();
			var end_time = $('#end_time').val();
			fromDate = parseInt(new Date(start_time).getTime()/1000); 
    		toDate = parseInt(new Date(end_time).getTime()/1000);
    		var timeDiff = (toDate - fromDate)/3600;
			 
 			$('#total_hrs').val(timeDiff);
			 calculateSlip(distance,hours);
		}

		function calculatetotalkm(){
			var start_km = $('#start_km').val();
			var end_km = $('#end_km').val();
			 
 			var total_km = end_km - start_km;
 			 
 			$('#total_km').val(total_km);
 			calculateSlip(distance,hours);
			 
		}

		function calculateexpense(){
			var adv_paid = $('#advance_paid').val();
			var adv_return = $('#advance_return').val();

 			var exp = adv_paid - adv_return;
 
 			$('#total_expense').val(exp);
			 
		}



		function calculateSlip(distance,hours){
			var hr = $('#total_hrs').val();
			var km = $('#total_km').val();
			var extraKmCost = 0;
			var extrahrCost = 0;
			var extrakm = km - distance;
			if(extrakm < 0){
				extrakm = 0;
			}else{
				var extraKmCost = extrakm*charge_distance;
			}
			$('#extra_kms').val(extrakm.toFixed(2));
			var extrahr = hr - hours;
			if(extrahr < 0){
				extrahr = 0;
			}else{
				var extrahrCost = extrahr*charge_hour;
			}

			$('#extra_hrs').val(extrahr.toFixed(2));
			var toll_fess = $('#toll_fess').val();
			var parking_fees = $('#parking_fees').val();
			var amount = parseFloat(extraKmCost) + parseFloat(package_amt) + parseFloat(extrahrCost) + parseFloat(toll_fess) + parseFloat(parking_fees);
			$('#total_amt').val(amount);
		}

		 calculateexpense();
		 calculatetotalkm();
		 calculatetotalhours();
	});
</script>
<script>
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();
   
});
</script>

