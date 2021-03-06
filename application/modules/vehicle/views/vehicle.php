<div class="main-content">
	<div class="main-content-inner">
		<div class="breadcrumbs ace-save-state" id="breadcrumbs">
			<ul class="breadcrumb">
				<li>
					<i class="ace-icon fa fa-home home-icon"></i>
					<a href="<?php echo base_url(); ?>">Home</a>
				</li>

				<li class="active">Vehicle</li>
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
					<?php if(isset($update) && $update == true){
						echo "Update Vehicle";
					}else{
						echo "Add Vehicle";
					} ?>
				</h1>
			</div><!-- /.page-header -->

			<?php if(isset($update) && $update == true): ?>
			<div class="row" style="margin-bottom: 2%;">
				<div class="col-xs-12 col-sm-22 widget-container-col ui-sortable" id="widget-container-col-1">
					<div class="widget-box ui-sortable-handle collapsed" id="widget-box-1" style="margin-top:0;">
						<div class="widget-header">
							<h5 class="widget-title">Vehicle Images</h5>

							<div class="widget-toolbar">
								

								<a href="#" data-action="collapse">
									<i class="ace-icon fa fa-chevron-up"></i>
								</a>
							</div>
						</div>
						
						<div class="widget-body" style="display:none;">
							<div class="widget-main">
								
								<?php foreach ($vehicleImages as $key => $val) { ?>
									<span class="images">
										<img  style="width:20%;margin-bottom:1%;" src="<?php echo base_url()."assets/vehicles/".$val->image_name; ?>">
										<span class="cross" id="<?php echo $val->image_id ?>">X</span>
									</span>	
								<?php } ?>
							</div>
						</div>
					</div>
				</div>
			</div>
			<?php endif; ?>

			<div class="row">
				<div class="col-xs-12">
					<div class="alert-box"></div>
					<!-- PAGE CONTENT BEGINS -->
					<form class="form-horizontal" role="form" method="post" id="<?php if(isset($vehicle)): echo "vehicle_update"; else: echo "vehicle"; endif; ?>" enctype="multipart/form-data">				
						<div class="form-group">
							<label class="col-sm-2 no-padding-right" for="">Enter Vehicle Name<b class="red">*</b></label>

							<div class="col-sm-4">
								<input type="text" id="vehicle_name" name="vehicle_name" placeholder="Enter Vehicle Name" class="col-xs-10 form-control col-sm-5 mandatory-field" value="<?php if(isset($vehicle)): echo $vehicle[0]->vehicle_name; endif; ?>" />
								<span class="help-inline col-xs-12 col-sm-7">
									<span class="middle input-text-error" id="vehicle_name_errorlabel"></span>
								</span>
							</div>

							<label class="col-sm-2 no-padding-right" for="">Vehicle status<b class="red">*</b></label>

							<div class="col-sm-4">
								<select class="chosen-select form-control" name="vehicle_status" id="form-field-select-3" data-placeholder="Choose a State...">
									<option <?php if(isset($vehicle)): if($vehicle[0]->vehicle_status == 1): echo 'selected'; endif; endif; ?> value="1">Active</option>';
									<option <?php if(isset($vehicle)): if($vehicle[0]->vehicle_status == 0): echo 'selected'; endif; endif; ?> value="0">Inctive</option>';
								</select>
							</div>
						</div>

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
								<select class="chosen-select form-control" name="vehicle_type" id="form-field-select-3" data-placeholder="Enter Vehicle Type">
									<option value="AC" <?php if(isset($vehicle) && $vehicle[0]->vehicle_type == "AC")  : echo "selected"; endif;?>>AC</option>
                                    <option value="NONAC" <?php if(isset($vehicle) && $vehicle[0]->vehicle_type == "NONAC")  : echo "selected"; endif;?>>NONAC</option>
									
								</select>

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
								<select class="chosen-select form-control" name="fuel_type" id="form-field-select-3" data-placeholder="Enter Fuel Type">
									<option value="Petrol" <?php if(isset($vehicle) && $vehicle[0]->fuel_type == "Petrol")  : echo "selected"; endif;?>>Petrol</option>
                                    <option value="Diesel" <?php if(isset($vehicle) && $vehicle[0]->fuel_type == "Diesel")  : echo "selected"; endif;?>>Diesel</option>
                                    <option value="CNG" <?php if(isset($vehicle) && $vehicle[0]->fuel_type == "CNG")  : echo "selected"; endif;?>>CNG</option>
									
								</select>
								
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
						<div class="form-group">
							<label class="col-sm-2 no-padding-right" for="">Vehicle Description<b class="red">*</b></label>

							<div class="col-sm-4">
								<textarea id="vehicle_desc" name="vehicle_desc" placeholder="Enter Vehicle Desc" class="col-xs-10 form-control col-sm-5 mandatory-field"><?php if(isset($vehicle)): echo $vehicle[0]->vehicle_desc; endif; ?></textarea>
								<span class="help-inline col-xs-12 col-sm-7">
									<span class="middle input-text-error" id="vehicle_desc_errorlabel"></span>
								</span>
							</div>
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
		
		$(document).on('click','.cross', function(e){
	        e.preventDefault();
	        
	        if(confirm("Are you sure you want to delete!")){

	            var id = $(this).attr('id');

	            var obj = array.filter(function(obj){
	                return obj.name === "vehicle-img-remove"
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
	                    if(data.success == false){
	                        
	                    }else{
	                       	point.parent().remove();
	                    }
	                    
	                    alert(data.successMsg);
	                },
	                error: function (xhr, ajaxOptions, thrownError) {
	                    console.log(thrownError);
	                }
	            });
	        }
	    });
	
	});
</script>
