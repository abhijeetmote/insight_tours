<div class="main-content">
	<div class="main-content-inner">
		

		<div class="page-content">
			

			<div class="row">
				<div class="col-xs-12">
					<!-- PAGE CONTENT BEGINS -->
					<div class="space-6"></div>

					<div class="row">
						<div class="col-sm-10 col-sm-offset-1">
							<div class="widget-box transparent">
								<div class="widget-header widget-header-large">
									<h3 class="widget-title grey lighter">
										<i class="ace-icon fa fa-leaf green"></i>
										Customer Invoice
									</h3>

									<div class="widget-toolbar no-border invoice-info">
										<span class="invoice-info-label">Invoice:</span>
										<span class="red">#<?php echo $invoice_no; ?></span>

										<br />
										<?php 
											$date = new DateTime($booking[0]->booking_date);	
										?>
										<span class="invoice-info-label">Date:</span>
										<span class="blue"><?php echo $date->format('Y-m-d'); ?></span>
									</div>

									<div class="widget-toolbar hidden-480">
										<a href="<?php echo base_url()."invoice/invoicePdf/".$invoiceId ?>">
											<i class="ace-icon fa fa-print"></i>
										</a>
									</div>
								</div>

								<div class="widget-body">
									<div class="widget-main padding-24">
										<div class="row">
											<div class="col-sm-6">
												<div class="row">
													<div class="col-xs-11 label label-lg label-info arrowed-in arrowed-right">
														<b>Company Info</b>
													</div>
												</div>

												<div>
													<ul class="list-unstyled spaced">
														<li>
															<i class="ace-icon fa fa-caret-right blue"></i>Street, City
														</li>

														<li>
															<i class="ace-icon fa fa-caret-right blue"></i>Zip Code
														</li>

														<li>
															<i class="ace-icon fa fa-caret-right blue"></i>State, Country
														</li>

														<li>
															<i class="ace-icon fa fa-caret-right blue"></i>Phone:
															<b class="red">111-111-111</b>
														</li>

														<li class="divider"></li>

														<li>
															<i class="ace-icon fa fa-caret-right blue"></i>
															Paymant Info
														</li>
													</ul>
												</div>
											</div><!-- /.col -->

											<div class="col-sm-6">
												<div class="row">
													<div class="col-xs-11 label label-lg label-success arrowed-in arrowed-right">
														<b>Customer Info</b>
													</div>
												</div>

												<div>
													<ul class="list-unstyled  spaced">
														<li>
															<i class="ace-icon fa fa-caret-right green"></i>Name: <?php echo $booking[0]->cust_firstname." ".$booking[0]->cust_middlename." ".$booking[0]->cust_lastname; ?>
														</li>
														<li>
															<i class="ace-icon fa fa-caret-right green"></i>Add: <?php echo $booking[0]->cust_address; ?>
														</li>
														<li>
															<i class="ace-icon fa fa-caret-right green"></i>City: <?php echo $booking[0]->cust_city; ?>
														</li>
														<li>
															<i class="ace-icon fa fa-caret-right green"></i>Pincode: <?php echo $booking[0]->cust_pin; ?>
														</li>
														<li>
															<i class="ace-icon fa fa-caret-right green"></i>Phone: <?php echo $booking[0]->cust_mob1; ?>
														</li>
														<li>
															<i class="ace-icon fa fa-caret-right green"></i>PickUp Add: <?php echo $booking[0]->pickup_location; ?>
														</li>
														<li>
															<i class="ace-icon fa fa-caret-right green"></i>Drop Add: <?php echo $booking[0]->drop_location; ?>
														</li>
													</ul>
												</div>
											</div><!-- /.col -->
										</div><!-- /.row -->

										<div class="space"></div>

										<div>
											<table class="table table-striped table-bordered">
												<thead>
													<tr>
														<th class="center">#</th>
														<th>Package Name</th>
														<th class="hidden-xs">Package Amt</th>
														<th class="hidden-480">Hours</th>
														<th class="hidden-480">Charge/Hour</th>
														<th>Km</th>
														<th>Charge/Km</th>
														<th>Travel Type</th>
													</tr>
												</thead>

												<tbody>
													<tr>
														<td class="center">1</td>

														<td>
															<?php echo $booking[0]->package_name ?>
														</td>
														<td class="hidden-xs">
															<?php echo $booking[0]->package_amt ?>
														</td>
														<td class="hidden-480"><?php echo $booking[0]->hours ?></td>
														<td><?php echo $booking[0]->charge_hour ?></td>
														<td><?php echo $booking[0]->distance; ?></td>
														<td><?php echo $booking[0]->charge_distance; ?></td>
														<td><?php echo $booking[0]->travel_type; ?></td>
													</tr>
												</tbody>
											</table>
										</div>

										<div class="hr hr8 hr-double hr-dotted"></div>

										<div>
											<table class="table table-striped table-bordered" style="text-align:right;">
												<thead>
													<tr>
														<th class="hidden-480">Details</th>
														<th>Km/Hr</th>
														<th>Extra Km/Hr(If Any)</th>
														<th class="hidden-xs" style="text-align:right;">Amount</th>
													</tr>
												</thead>
												<tbody>
													<tr>
														<td class="hidden-480">Package Amt</td>
														<td class="hidden-xs">
															 
														</td>
														<td class="hidden-xs">
															
														</td>
														<td class="hidden-xs">
															<?php echo $booking[0]->package_amt ?>
														</td>
													</tr>
													<tr>
														<td class="hidden-480"> Kms</td>
														<td class="hidden-xs">
															 <?php echo $booking[0]->distance ?>
														</td>
														<td class="hidden-xs">
															<?php echo $dutySlipData[0]->extra_kms ?>
														</td>
														 
														<td class="hidden-xs">
															<?php echo $dutySlipData[0]->extra_kms * $booking[0]->charge_distance ?>
														</td>
														 
													</tr>
													<tr>
														<td class="hidden-480"> Hours</td>
														<td class="hidden-xs">
															<?php echo $booking[0]->hours  ?>
														</td>
														<td class="hidden-xs">
															<?php echo $dutySlipData[0]->extra_hrs ?>
															
														</td>
														<td class="hidden-xs">
															<?php echo $dutySlipData[0]->extra_hrs * $booking[0]->charge_hour;?>
														</td>
														 
													</tr>
													<tr>
														<td class="hidden-480">Toll Fees</td>
														<td class="hidden-xs">
															 
														</td>
														<td class="hidden-xs">
															 
															
														</td>
														<td class="hidden-xs">
															<?php echo $dutySlipData[0]->toll_fess; ?>
														</td>
													</tr>
													<tr>
														<td class="hidden-480">Parking Fees</td>
														<td class="hidden-xs">
															 
														</td>
														<td class="hidden-xs">
															 
															
														</td>
														<td class="hidden-xs">
															<?php echo $dutySlipData[0]->parking_fees ?>
														</td>
													</tr>
													<tr>
														<td class="hidden-480"><b>Total Amount</b></td>
														<td class="hidden-xs">
															 
														</td>
														<td class="hidden-xs">
															 
															
														</td>
														<td class="hidden-xs">
															<b><?php echo $dutySlipData[0]->total_amt."/-" ?></b>
														</td>
													</tr>
												</tbody>
											</table>
										</div>

										<!-- <div class="row">
											<div class="col-sm-5 pull-right">
												<h4 class="pull-right">
													Total amount :
													<span class="red"><?php echo $dutySlipData[0]->total_amt ?></span>
												</h4>
											</div>
										</div>

										<div class="space-6"></div> -->
										<!-- <div class="well">
											Thank you for choosing Ace Company products.We believe you will be satisfied by our services.
										</div> -->
									</div>
								</div>
							</div>
						</div>
					</div>

					<!-- PAGE CONTENT ENDS -->
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