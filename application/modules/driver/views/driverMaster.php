
<div class="main-content">
	<div class="main-content-inner">
		<div class="breadcrumbs ace-save-state" id="breadcrumbs">
			<ul class="breadcrumb">
				<li>
					<i class="ace-icon fa fa-home home-icon"></i>
					<a href="#">Home</a>
				</li>

				<li>
					<a href="#">Driver</a>
				</li>
				<li class="active">Add Driver</li>
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
					Add Driver
				</h1>
			</div><!-- /.page-header -->

			<div class="row">
				<div class="col-xs-12">
					<div class="alert-box"></div>
					<!-- PAGE CONTENT BEGINS -->
					<form class="form-horizontal" role="form" id="<?php if(isset($driver)): echo "driver_update"; else: echo "drivermaster"; endif; ?>">						
						<div class="form-group">
							<label class="col-sm-2  no-padding-right" for="">Driver First Name<b class="red">*</b></label>

							<div class="col-sm-4">
								<input type="text" id="driver_fname" name="driver_fname" value="<?php if(isset($driver)): echo $driver[0]->driver_fname; endif; ?>" placeholder="Enter Driver First Name" class="col-xs-10 col-sm-12 mandatory-field" onKeyUp="javascript:return check_isalphanumeric(event,this);"/>
								<span class="help-inline col-xs-12 col-sm-7">
									<span class="middle input-text-error" id="driver_fname_errorlabel"></span>
								</span>
							</div>

							<label class="col-sm-2  no-padding-right" for="">Driver Middle Name</label>

							<div class="col-sm-4">
								<input type="text" id="driver_mname" name="driver_mname" value="<?php if(isset($driver)): echo $driver[0]->driver_mname; endif; ?>" placeholder="Enter Driver Middle Name" class="col-xs-10 col-sm-12" onKeyUp="javascript:return check_isalphanumeric(event,this);"/>
								<span class="help-inline col-xs-12 col-sm-7">
									<span class="middle input-text-error" id="driver_mname_errorlabel"></span>
								</span>
							</div>
						</div>

						 

						<div class="form-group">
							<label class="col-sm-2  no-padding-right" for="">Driver Last Name<b class="red">*</b></label>

							<div class="col-sm-4">
								<input type="text" id="driver_lname" name="driver_lname" placeholder="Enter Driver Last Name" value="<?php if(isset($driver)): echo $driver[0]->driver_lname; endif; ?>" class="col-xs-10 col-sm-12 mandatory-field" onKeyUp="javascript:return check_isalphanumeric(event,this);"/>
								<span class="help-inline col-xs-12 col-sm-7">
									<span class="middle input-text-error" id="driver_lname_errorlabel"></span>
								</span>
							</div>

							<label class="col-sm-2  no-padding-right" for="">Diver DOB</label>

							<div class="col-sm-4">
								<input type="text" data-date-format="dd-mm-yyyy" id="driver_dob" name="driver_dob" value="<?php if(isset($driver)): echo $newDateTime = date('d/m/Y', strtotime($driver[0]->driver_bdate)); endif; ?>" class="date-picker col-xs-10 col-sm-12"/>
								<span style="width:10px;height:35px;" class="input-group-addon">
									<i class="fa fa-calendar bigger-110"></i>
								</span>
								<span class="help-inline col-xs-12 col-sm-7">
									<span class="middle input-text-error" id="driver_dob_errorlabel"></span>
								</span>
							</div>
						</div>


 
						
						<input type="hidden" value="<?php if(isset($driver)): echo $driver[0]->driver_id; endif; ?>" name="id">
						<input type="hidden" value="<?php if(isset($driver)): echo $driver[0]->ledger_id; endif; ?>" name="ledger_id">	

						<div class="form-group">
							<label class="col-sm-2  no-padding-right" for="">Driver Address<b class="red">*</b></label>

							<div class="col-sm-4">
								<textarea id="driver_address" name="driver_address" value="<?php if(isset($driver)): echo $driver[0]->driver_add; endif; ?>" placeholder="Enter Driver Address" class="col-xs-10 col-sm-12 mandatory-field" ><?php if(isset($driver)): echo trim($driver[0]->driver_add); endif; ?></textarea>
								<span class="help-inline col-xs-12 col-sm-7">
									<span class="middle input-text-error" id="driver_address_errorlabel"></span>
								</span>
							</div>

							<label class="col-sm-2  no-padding-right" for="">Driver Mobile1<b class="red">*</b></label>

							<div class="col-sm-4">
								<input type="text" id="driver_mobile" name="driver_mobile" onblur="javascript:return check_ismobile(event,this,0);" value="<?php if(isset($driver)): echo $driver[0]->driver_mobno; endif; ?>" placeholder="Enter Driver Mobile No" class="col-xs-10 col-sm-12 mandatory-field"  onKeyUp="javascript:return check_isnumeric(event,this,0);" />
								<span class="help-inline col-xs-12 col-sm-7">
									<span class="middle input-text-error" id="driver_mobile_errorlabel"></span>
								</span>
							</div>
						</div>


					 


						<div class="form-group">
							<label class="col-sm-2  no-padding-right" for="">Driver Mobile2</label>

							<div class="col-sm-4">
								<input type="text" id="driver_mobile1" name="driver_mobile1" onblur="javascript:return check_ismobile(event,this,0);" value="<?php if(isset($driver)): echo $driver[0]->driver_mobno1; endif; ?>" placeholder="Enter Driver Mobile No" class="col-xs-10 col-sm-12" onKeyUp="javascript:return check_isnumeric(event,this,0);"/>
								<span class="help-inline col-xs-12 col-sm-7">
									<span class="middle input-text-error" id="driver_mobile1_errorlabel"></span>
								</span>
							</div>


							<label class="col-sm-2  no-padding-right" for="">Licence No<b class="red">*</b></label>

							<div class="col-sm-4">
								<input type="text" id="driver_licence" name="driver_licence" value="<?php if(isset($driver)): echo $driver[0]->driver_licno; endif; ?>" placeholder="Enter Driver Licence No" class="col-xs-10 col-sm-12 mandatory-field"  onKeyUp="javascript:return check_gernalstring(event,this);"/>
								<span class="help-inline col-xs-12 col-sm-7">
									<span class="middle input-text-error" id="driver_licence_errorlabel"></span>
								</span>
							</div>
						</div>
 

						<div class="form-group">
							<label class="col-sm-2  no-padding-right" for="">Licence Exp Date<b class="red">*</b></label>

							<div class="col-sm-4">
								<input type="text" data-date-format="dd-mm-yyyy" value="<?php if(isset($driver)): echo $newDateTime = date('d/m/Y', strtotime($driver[0]->driver_licexpdate)); endif; ?>" placeholder=" Licence Exp Date" id="licence_exp" name="licence_exp" class="date-picker col-xs-10 col-sm-12 mandatory-field"/>
								<span style="width:10px;height:35px;" class="input-group-addon">
									<i class="fa fa-calendar bigger-110"></i>
								</span>
								<span class="help-inline col-xs-12 col-sm-7">
									<span class="middle input-text-error" id="licence_exp_errorlabel"></span>
								</span>
							</div>

							<label class="col-sm-2  no-padding-right" for="">Diver Pan<b class="red">*</b></label>

							<div class="col-sm-4">
								<input type="text" id="driver_pan" name="driver_pan" value="<?php if(isset($driver)): echo $driver[0]->driver_panno; endif; ?>" placeholder="Enter Driver Pan No" class="col-xs-10 col-sm-12 mandatory-field"  onKeyUp="javascript:return check_isalphanumeric(event,this);" onblur="check_ispan(this,event);"/>
								<span class="help-inline col-xs-12 col-sm-7">
									<span class="middle input-text-error" id="driver_pan_errorlabel"></span>
								</span>
							</div>
						</div>
 

						<div class="form-group">
							<label class="col-sm-2  no-padding-right" for="">Diver Fix Pay<b class="red">*</b></label>

							<div class="col-sm-4">
								<input type="text" id="driver_fix_pay" name="driver_fix_pay" value="<?php if(isset($driver)): echo $driver[0]->driver_fix_pay; endif; ?>" placeholder="Enter Driver Fix Pay" class="col-xs-10 col-sm-12 mandatory-field"  onKeyUp="javascript:return check_isammount(event,this);" onblur="sanitize_float(event,this);"/>
								<span class="help-inline col-xs-12 col-sm-7">
									<span class="middle input-text-error" id="driver_fix_pay_errorlabel"></span>
								</span>
							</div>

							<label class="col-sm-2  no-padding-right" for="">Diver DA</label>

							<div class="col-sm-4">
								<input type="text" id="driver_da" name="driver_da" value="<?php if(isset($driver)): echo $driver[0]->driver_da; endif; ?>" placeholder="Enter Driver DA" class="col-xs-10 col-sm-12 "  onKeyUp="javascript:return check_isammount(event,this);" onblur="sanitize_float(event,this);"/>
								<span class="help-inline col-xs-12 col-sm-7">
									<span class="middle input-text-error" id="driver_da_errorlabel"></span>
								</span>
							</div>
						</div>
 

						<div class="form-group">
							<label class="col-sm-2  no-padding-right" for="">Diver Naight Allownace</label>

							<div class="col-sm-4">
								<input type="text" id="driver_na" name="driver_na" value="<?php if(isset($driver)): echo $driver[0]->driver_na; endif; ?>" placeholder="Enter Driver NA" class="col-xs-10 col-sm-12 "  onKeyUp="javascript:return check_isammount(event,this);" onblur="sanitize_float(event,this);"/>
								<span class="help-inline col-xs-12 col-sm-7">
									<span class="middle input-text-error" id="driver_na_errorlabel"></span>
								</span>
							</div>

							<label class="col-sm-2  no-padding-right" for="">IS</label>

							<div class="col-sm-4">
								<div class="control-group">
									<label>
										<input type="checkbox" class="ace" <?php if(isset($driver[0]->is_da) && $driver[0]->is_da == 1) { echo "checked";} ?> value="DA" name="da" id="da">
										<span class="lbl">DA</span>
									</label>

									<label>
										<input type="checkbox" class="ace" value="Night Allownce"  <?php if(isset($driver[0]->is_da) && $driver[0]->is_night_allowance == 1) { echo "checked";} ?> name="night" id="night">
										<span class="lbl">Night Allownce</span>
									</label>
											
								</div>
								
							</div>
						</div>

						 


						


						<div class="clearfix form-actions">
							<div class="col-md-offset-3 col-md-9">
								<button class="btn btn-info test" type="submit">
									<i class="iconcategory"></i>
									Submit
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
	
	
		 
			$('.chosen-select').chosen({allow_single_deselect:true}); 
			//resize the chosen on window resize
	 
		$('.date-picker').datepicker({
			autoclose: true,
			todayHighlight: true
		})
		//show datepicker when clicking on the icon
		.next().on(ace.click_event, function(){
			$(this).prev().focus();
		});
	
		 
	
	});
</script>