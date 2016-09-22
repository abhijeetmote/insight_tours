<div class="main-content">
	<div class="main-content-inner">
		<div class="breadcrumbs ace-save-state" id="breadcrumbs">
			<ul class="breadcrumb">
				<li>
					<i class="ace-icon fa fa-home home-icon"></i>
					<a href="<?php echo base_url(); ?>">Home</a>
				</li>

				<li>
					<a href="<?php echo base_url()."vehicle/vehicleList"; ?>">Vehicle</a>
				</li>
				<li class="active">Add Vehicle</li>
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
					Add Vehicle
				</h1>
			</div><!-- /.page-header -->

			<div class="row">
				<div class="col-xs-12">
					<div class="alert-box"></div>
					<!-- PAGE CONTENT BEGINS -->
					<form class="form-horizontal" role="form" method="post" id="<?php if(isset($vehicle)): echo "vehicle_update"; else: echo "vehicle"; endif; ?>" enctype="multipart/form-data">						
						<div class="form-group">
							<label class="col-sm-2 no-padding-right" for="">Enter Vehicle No<b class="red">*</b></label>

							<div class="col-sm-4">
								<input type="text" id="vehicle_no" name="vehicle_no" placeholder="Enter Vehicle Number" class="col-xs-10 form-control col-sm-5 mandatory-field" value="<?php if(isset($vehicle)): echo $vehicle[0]->vehicle_no; endif; ?>" />
								<span class="help-inline col-xs-12 col-sm-7">
									<span class="middle input-text-error" id="vehicle_no_errorlabel"></span>
								</span>
							</div>

							<label class="col-sm-2 no-padding-right" for="">Enter Vehicle Type<b class="red">*</b></label>

							<div class="col-sm-4">
								<input type="text" id="vehicle_type" name="vehicle_type" placeholder="Enter Vehicle Type" class="col-xs-10 form-control col-sm-5 mandatory-field" value="<?php if(isset($vehicle)): echo $vehicle[0]->vehicle_type; endif; ?>" />
								<span class="help-inline col-xs-12 col-sm-7">
									<span class="middle input-text-error" id="vehicle_type_errorlabel"></span>
								</span>
							</div>

						</div>
						<input type="hidden" value="<?php if(isset($vehicle)): echo $vehicle[0]->vehicle_id; endif; ?>" name="id">
						<div class="form-group">
							<label class="col-sm-2 no-padding-right" for="">Enter Vehicle Model<b class="red">*</b></label>

							<div class="col-sm-4">
								<input type="text" id="vehicle_model" name="vehicle_model" placeholder="Enter Vehicle Model" class="col-xs-10 form-control col-sm-5 mandatory-field" value="<?php if(isset($vehicle)): echo $vehicle[0]->vehicle_model; endif; ?>" />
								<span class="help-inline col-xs-12 col-sm-7">
									<span class="middle input-text-error" id="vehicle_model_errorlabel"></span>
								</span>
							</div>
						
							<label class="col-sm-2 no-padding-right" for="">Enter Fuel Type<b class="red">*</b></label>

							<div class="col-sm-4">
								<input type="text" id="fuel_type" name="fuel_type" placeholder="Enter Fuel Type" class="col-xs-10 form-control col-sm-5 mandatory-field" value="<?php if(isset($vehicle)): echo $vehicle[0]->fuel_type; endif; ?>"/>
								<span class="help-inline col-xs-12 col-sm-7">
									<span class="middle input-text-error" id="fuel_type_errorlabel"></span>
								</span>
							</div>
						</div>
						<div class="form-group">
							
						</div>
						<div class="form-group">
							<label class="col-sm-2 no-padding-right" for="">Enter Passenger Capacity<b class="red">*</b></label>

							<div class="col-sm-4">
								<input type="text" id="passenger_capacity" name="passenger_capacity" placeholder="Enter Passenger Capacity" class="col-xs-10 form-control col-sm-5 mandatory-field" value="<?php if(isset($vehicle)): echo $vehicle[0]->passanger_capacity; endif; ?>" />
								<span class="help-inline col-xs-12 col-sm-7">
									<span class="middle input-text-error" id="passenger_capacity_errorlabel"></span>
								</span>
							</div>

							<label class="col-sm-2 no-padding-right">Enter Vehicle Category</label>

							<div class="col-sm-4">
								<select class="chosen-select form-control" name="vehicle_category" id="form-field-select-3" data-placeholder="Choose a State...">
									<?php
										foreach ($category as $val) {
											if($val->cat_id == $vehicle[0]->vehicle_category){
												echo '<option selected value="'.$val->cat_id.'">'.$val->cat_name.'</option>';
											}else{
												echo '<option value="'.$val->cat_id.'">'.$val->cat_name.'</option>';
											}
										}
									?>
									
								</select>
							</div>
						</div>
						<div class="form-group">
							
						</div>
						<div class="form-group">
							<label class="col-sm-2 no-padding-right" for="">Enter Vehicle Features<b class="red">*</b></label>

							<div class="col-sm-4">
								<input type="text" id="vehicle_features" name="vehicle_features" placeholder="Enter vehicle Features" class="col-xs-10 form-control col-sm-5 mandatory-field" value="<?php if(isset($vehicle)): echo $vehicle[0]->vehicle_features; endif; ?>" />
								<span class="help-inline col-xs-12 col-sm-7">
									<span class="middle input-text-error" id="vehicle_features_errorlabel"></span>
								</span>
							</div>
						
							<label class="col-sm-2 no-padding-right" for="">Enter Insurance Expiry Date<b class="red">*</b></label>

							<div class="col-sm-4">
								<input type="hidden" name="insuranceid" value="<?php if(isset($insurance) && (!empty($insurance) || $insurance == 0)): echo $vehicleDetails[$insurance]['vldetail_id']; endif; ?>">
								<input type="text" id="insurance_exp" name="insurance_exp" placeholder="Enter Insurance Expiry Date" class="col-xs-10 form-control col-sm-5 date-picker mandatory-field" value="<?php if(isset($insurance) && (!empty($insurance) || $insurance == 0)): echo $vehicleDetails[$insurance]['vehicle_exp_value']; endif; ?>" />
								<span class="help-inline col-xs-12 col-sm-9">
									<span class="middle input-text-error" id="insurance_exp_errorlabel"></span>
								</span>
							</div>
						</div>
						<div class="form-group">
							
						</div>
						<div class="form-group">
							<label class="col-sm-2 no-padding-right" for="">Enter PUC Expiry Date<b class="red">*</b></label>

							<div class="col-sm-4">
								<input type="hidden" name="pucid" value="<?php if(isset($puc) && (!empty($puc) || $puc == 0)): echo $vehicleDetails[$puc]['vldetail_id']; endif; ?>">
								<input type="text" id="puc_exp" name="puc_exp" placeholder="Enter PUC Expiry Date" class="col-xs-10 form-control col-sm-5 date-picker mandatory-field" value="<?php if(isset($puc) && (!empty($puc) || $puc == 0)): echo $vehicleDetails[$puc]['vehicle_exp_value']; endif; ?>" />
								<span class="help-inline col-xs-12 col-sm-7">
									<span class="middle input-text-error" id="puc_exp_errorlabel"></span>
								</span>
							</div>
						
							<label class="col-sm-2 no-padding-right" for="">Enter Tpermit Expiry Date<b class="red">*</b></label>

							<div class="col-sm-4">
								<input type="hidden" name="tpermitid" value="<?php if(isset($tpermit) && (!empty($tpermit) || $tpermit == 0)): echo $vehicleDetails[$tpermit]['vldetail_id']; endif; ?>">
								<input type="text" id="tpermit_exp" name="tpermit_exp" placeholder="Enter Tpermit Expiry Date" class="col-xs-10 form-control col-sm-5 date-picker mandatory-field" value="<?php if(isset($tpermit) && (!empty($tpermit) || $tpermit == 0)): echo $vehicleDetails[$tpermit]['vehicle_exp_value']; endif; ?>" />
								<span class="help-inline col-xs-12 col-sm-7">
									<span class="middle input-text-error" id="tpermit_exp_errorlabel"></span>
								</span>
							</div>
						</div>
						<div class="form-group">
							
						</div>
						<div class="form-group">
							<label class="col-sm-2 no-padding-right" for="">Enter Oil change Date<b class="red">*</b></label>

							<div class="col-sm-4">
								<input type="hidden" name="oil_changeid" value="<?php if(isset($oilchange) && (!empty($oilchange) || $oilchange == 0)): echo $vehicleDetails[$oilchange]['vldetail_id']; endif; ?>">
								<input type="text" id="oil_change" name="oil_change" placeholder="Enter Oil Change Date" class="col-xs-10 form-control col-sm-5 date-picker mandatory-field" value="<?php if(isset($oilchange) && (!empty($oilchange) || $oilchange == 0)): echo $vehicleDetails[$oilchange]['vehicle_exp_value']; endif; ?>" />
								<span class="help-inline col-xs-12 col-sm-7">
									<span class="middle input-text-error" id="oil_change_errorlabel"></span>
								</span>
							</div>
						
							<label class="col-sm-2 no-padding-right" for="">Enter Oil Change Km<b class="red">*</b></label>

							<div class="col-sm-4">
								<input type="hidden" name="oil_changekmid" value="<?php if(isset($oilchangekm) && (!empty($oilchangekm) || $oilchangekm == 0)): echo $vehicleDetails[$oilchangekm]['vldetail_id']; endif; ?>">
								<input type="text" id="oil_changekm" name="oil_changekm" placeholder="Enter Oil Change Km" onKeyUp="javascript:return check_isnumeric(event,this,0);" class="col-xs-10 form-control col-sm-5 mandatory-field" value="<?php if(isset($oilchangekm) && (!empty($oilchangekm) || $oilchangekm == 0)): echo $vehicleDetails[$oilchangekm]['vehicle_exp_value']; endif; ?>" />
								<span class="help-inline col-xs-12 col-sm-7">
									<span class="middle input-text-error" id="oil_changekm_errorlabel"></span>
								</span>
							</div>
						</div>
						<div class="form-group">
							
						</div>
						<div class="form-group files">
							<label class="col-sm-3 no-padding-right" for="">Select Image</label>

							<div class="col-sm-4">
								<input type="file" name="vehichleImage1" />
								<span class="help-inline col-xs-12 col-sm-7">
									<span class="middle input-text-error" id="tpermit_exp_errorlabel" ></span>
								</span>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 no-padding-right" for=""></label>

							<div class="col-sm-1">
								<button class="btn btn-info test" type="button" id="add">
									<i class="ace-icon fa fa-plus bigger-110"></i>
									Add Photo
								</button>
							</div>
						</div>
						
						<div class="clearfix form-actions">
							<div class="col-md-offset-3 col-md-9">
								<button class="btn btn-info test" type="submit">
									<i class="iconvehicle"></i>
									<?php if(isset($update) && $update == true){
										echo "Update";
									}else{
										echo "Submit";
									} ?>
								</button>

								&nbsp; &nbsp; &nbsp;
								<button class="btn" type="reset">
									<i class="ace-icon fa fa-undo bigger-110"></i>
									Reset
								</button>
							</div>
						</div>
					</form>
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

<script src="<?php echo base_url(); ?>js/custom.js"></script>
<script src="<?php echo base_url(); ?>js/form-validation.js"></script>

<!-- inline scripts related to this page -->
<script type="text/javascript">
	jQuery(function($) {
		 
			$('.chosen-select').chosen({allow_single_deselect:true}); 
			//resize the chosen on window resize
	
			 
		$('.date-picker').datepicker({
			format: 'yyyy-mm-dd',
			autoclose: true,
			todayHighlight: true
		})
		 
	
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
		
		 
	
	});
</script>
