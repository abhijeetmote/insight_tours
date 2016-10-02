<div class="main-content">
	<div class="main-content-inner">
		<div class="breadcrumbs ace-save-state" id="breadcrumbs">
			<ul class="breadcrumb">
				<li>
					<i class="ace-icon fa fa-home home-icon"></i>
					<a href="<?php echo base_url().""; ?>">Home</a>
				</li>

				<li>
					<a href="<?php echo base_url()."package/packageList"; ?>">Package List</a>
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
					Add Package
				</h1>
			</div><!-- /.page-header -->

			<div class="row">
				<div class="col-xs-12">
					<div class="alert-box"></div>
					<!-- PAGE CONTENT BEGINS -->
					<form class="form-horizontal" role="form" method="post" id="<?php if(isset($package)): echo "package_update"; else: echo "package"; endif; ?>" enctype="multipart/form-data">						
						<div class="form-group">
							<label class="col-sm-2 no-padding-right" for="">Select Vehicle Cat<b class="red"> * </b></label>

							<div class="col-sm-4">
								<select class="chosen-select form-control" name="vehicle" id="form-field-select-3" data-placeholder="Choose a State...">
									<?php
										foreach ($vehicle as $val) 
										{			
									?>								
											<option value="<?php echo $val->cat_id ?>" <?php if(isset($package) && $val->cat_id == $package[0]->vehicle_cat_id): echo "selected"; endif; ?>><?php echo $val->cat_name; ?></option>
									<?php
										}
									?>
									
								</select>
							</div>

							<label class="col-sm-2 no-padding-right" for="">Enter Package Name<b class="red"> * </b></label>

							<div class="col-sm-4">
								<input type="text" id="package_name" name="package_name" placeholder="Enter Package Name" class="col-xs-10 form-control col-sm-5 mandatory-field" value="<?php if(isset($package)): echo $package[0]->package_name; endif; ?>" />
								<span class="help-inline col-xs-12 col-sm-7">
									<span class="middle input-text-error" id="package_name_errorlabel"></span>
								</span>
							</div>

						</div>
						<input type="hidden" value="<?php if(isset($package)): echo $package[0]->package_id; endif; ?>" name="id">
						<div class="form-group">
							<label class="col-sm-2 no-padding-right" for="">Enter Hours<b class="red"> * </b></label>

							<div class="col-sm-4">
								<input type="text" id="hours" name="hours"   placeholder="Enter Hours(s)" class="col-xs-10 form-control col-sm-5 mandatory-field" value="<?php if(isset($package)): echo $package[0]->hours; endif; ?>" />
								<span class="help-inline col-xs-12 col-sm-7">
									<span class="middle input-text-error" id="hours_errorlabel"></span>
								</span>
							</div>
						
							<label class="col-sm-2 no-padding-right" for="">Enter Distance<b class="red"> * </b></label>

							<div class="col-sm-4">
								<input type="text" id="distance"   name="distance" placeholder="Enter Distance in km" class="col-xs-10 form-control col-sm-5 mandatory-field" value="<?php if(isset($package)): echo $package[0]->distance; endif; ?>"/>
								<span class="help-inline col-xs-12 col-sm-7">
									<span class="middle input-text-error" id="distance_errorlabel"></span>
								</span>
							</div>
						</div>
						<div class="form-group">
							
						</div>
						<div class="form-group">
							<label class="col-sm-2 no-padding-right" for="">Enter Min Cost<b class="red"> * </b></label>

							<div class="col-sm-4">
								<input type="text" id="min_cost" onKeyUp="javascript:return check_isammount(event,this);" onblur="sanitize_float(event,this);" name="min_cost" placeholder="Enter Min Cost" class="col-xs-10 form-control col-sm-5 mandatory-field" value="<?php if(isset($package)): echo $package[0]->package_amt; endif; ?>" />
								<span class="help-inline col-xs-12 col-sm-7">
									<span class="middle input-text-error" id="min_cost_errorlabel"></span>
								</span>
							</div>

							<label class="col-sm-2 no-padding-right">Enter Charge/distance</label>

							<div class="col-sm-4">
								<input type="text" id="charge_distance" onKeyUp="javascript:return check_isammount(event,this);" onblur="sanitize_float(event,this);" name="charge_distance" placeholder="Enter Charge per km" class="col-xs-10 form-control col-sm-5 mandatory-field" value="<?php if(isset($package)): echo $package[0]->charge_distance; endif; ?>" />
								<span class="help-inline col-xs-12 col-sm-7">
									<span class="middle input-text-error" id="charge_distance_errorlabel"></span>
								</span>
							</div>
						</div>
						<div class="form-group">
							
						</div>
						<div class="form-group">
							<label class="col-sm-2 no-padding-right">Enter Charge/hour</label>

							<div class="col-sm-4">
								<input type="text" id="charge_hour" onKeyUp="javascript:return check_isammount(event,this);" onblur="sanitize_float(event,this);" name="charge_hour" placeholder="Enter Charge per hour" class="col-xs-10 form-control col-sm-5 mandatory-field" value="<?php if(isset($package)): echo $package[0]->charge_hour; endif; ?>" />
								<span class="help-inline col-xs-12 col-sm-7">
									<span class="middle input-text-error" id="charge_hour_errorlabel"></span>
								</span>
							</div>
						
							<label class="col-sm-2 no-padding-right" for="">Select Status<b class="red"> * </b></label>

							<div class="col-sm-4">
								<select class="chosen-select form-control" name="status" id="form-field-select-3" data-placeholder="Choose a State...">
									<option value="1" <?php if(isset($package) && $package[0]->isactive == 1): echo "selected"; endif; ?>>Active</option>
									<option value="0" <?php if(isset($package) && $package[0]->isactive == 0): echo "selected"; endif; ?>>Inactive</option>
								</select>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-2 no-padding-right" for="">Select Travel Type<b class="red"> * </b></label>

							<div class="col-sm-4">
								<select class="chosen-select form-control" name="travel_type" id="form-field-select-3" data-placeholder="Choose a State...">
									<option value="Local" <?php if(isset($package) && $package[0]->travel_type == 'Local'): echo "selected"; endif; ?>>Local</option>
									<option value="Outstation" <?php if(isset($package) && $package[0]->travel_type == 'Outstation'): echo "selected"; endif; ?>>Outstation</option>
								</select>
							</div>

							<label class="col-sm-2 no-padding-right" for="">Package</label>

							<div class="col-sm-4">
								<div class="control-group">
									<label>
										<input type="checkbox" class="ace" <?php if(isset($package[0]->default) && $package[0]->default == 1) { echo "checked";} ?> value="1" name="default">
										<span class="lbl">Default Package</span>
									</label>
											
								</div>
								
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
	
	 
	
	});
</script>
