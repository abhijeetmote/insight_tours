<div class="main-content">
	<div class="main-content-inner">
		<div class="breadcrumbs ace-save-state" id="breadcrumbs">
			<ul class="breadcrumb">
				<li>
					<i class="ace-icon fa fa-home home-icon"></i>
					<a href="<?php echo base_url().""; ?>">Home</a>
				</li>

				<li>
					<a href="<?php echo base_url()."customer/customerList"; ?>">customer</a>
				</li>
				<li class="active">Add Customer</li>
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
					<?php if(isset($customer)): echo "Update Customer"; else: echo "Add Customer"; endif; ?>
				</h1>
			</div><!-- /.page-header -->

			<div class="row">
				<div class="col-xs-12">
					<div class="alert-box"></div>
					<!-- PAGE CONTENT BEGINS -->
					<form class="form-horizontal" role="form" id="<?php if(isset($customer)): echo "customerUpdate"; else: echo "customermaster"; endif; ?>">						
						<div class="form-group">
							<label class="col-sm-2 no-padding-right" for="form-field-2"> First Name<b class="red">*</b></label>

							<div class="col-sm-4">
								<input type="text" id="first_name" name="first_name" value="<?php if(isset($customer)): echo $customer[0]->cust_firstname; endif; ?>" placeholder="Enter First Name" class="col-xs-10 form-control col-sm-5 mandatory-field" onKeyUp="javascript:return check_isalphanumeric(event,this);"/>
								<span class="help-inline col-xs-12 col-sm-7">
									<span class="middle input-text-error" id="first_name_errorlabel"></span>
								</span>
							</div>

<<<<<<< 9862e2053787d0ab7e6292734828b9031f2ecdba
							<label class="col-sm-2 no-padding-right" for="form-field-2"> Middle Name<b class="red">*</b></label>

							<div class="col-sm-4">
								<input type="text" id="middle_name" name="middle_name" value="<?php if(isset($customer)): echo $customer[0]->cust_middlename; endif; ?>" placeholder="Enter Middle Name" class="col-xs-10 form-control col-sm-5 mandatory-field" onKeyUp="javascript:return check_isalphanumeric(event,this);"/>
=======
							<label class="col-sm-2 no-padding-right" for="form-field-2"> Middle Name</label>

							<div class="col-sm-4">
								<input type="text" id="middle_name" name="middle_name" value="<?php if(isset($customer)): echo $customer[0]->cust_middlename; endif; ?>" placeholder="Enter Middle Name" class="col-xs-10 form-control col-sm-5 " onKeyUp="javascript:return check_isalphanumeric(event,this);"/>
>>>>>>> 1b9cb81d52b56e902b2e4de89bb9b6cdd2851a9a
								<span class="help-inline col-xs-12 col-sm-7">
									<span class="middle input-text-error" id="middle_name_errorlabel"></span>
								</span>
							</div>
						</div>
						<div class="form-group">
							
						</div>
						<div class="form-group">
							<label class="col-sm-2 no-padding-right" for="form-field-2"> Last Name<b class="red">*</b></label>
							<div class="col-sm-4">
								<input type="text" id="last_name" name="last_name" value="<?php if(isset($customer)): echo $customer[0]->cust_lastname; endif; ?>" placeholder="Enter Last Name" class="col-xs-10 form-control col-sm-5 mandatory-field" onKeyUp="javascript:return check_isalphanumeric(event,this);"/>
								<span class="help-inline col-xs-12 col-sm-7">
									<span class="middle input-text-error" id="last_name_errorlabel"></span>
								</span>
							</div>

							<label class="col-sm-2 no-padding-right" for="form-field-2">Email<b class="red">*</b></label>

							<div class="col-sm-4">
								<input type="text" id="email" name="email" value="<?php if(isset($customer)): echo $customer[0]->cust_email1; endif; ?>" placeholder="Enter Email" class="col-xs-10 form-control col-sm-5" onblur="check_isemail(this,event);"/>
								<span class="help-inline col-xs-12 col-sm-7">
									<span class="middle input-text-error" id="email_errorlabel"></span>
								</span>
							</div>
						</div>
						<input type="hidden" value="<?php if(isset($customer)): echo $customer[0]->cust_id; endif; ?>" name="id">
						<input type="hidden" value="<?php if(isset($customer)): echo $customer[0]->ledger_id; endif; ?>" name="customer_ledger_id">
						<div class="form-group">
							
						</div>
						<div class="form-group">
							<label class="col-sm-2 no-padding-right" for="form-field-2"> Alternative Email</label>

							<div class="col-sm-4">
								<input type="text" id="alt_email" name="alt_email" value="<?php if(isset($customer)): echo $customer[0]->cust_email2; endif; ?>" placeholder="Enter Alternative Email (Optional)" class="col-xs-10 form-control col-sm-5 " />
								<span class="help-inline col-xs-12 col-sm-7">
									<span class="middle input-text-error" id="alt_email_errorlabel"></span>
								</span>
							</div>

							<label class="col-sm-2 no-padding-right" for="form-field-2">Phone Number</label>

							<div class="col-sm-4">
								<input type="text" id="phone" name="phone" value="<?php if(isset($customer)): echo $customer[0]->cust_telno; endif; ?>" placeholder="Enter Phone Number" class="col-xs-10 form-control col-sm-5" />
								<span class="help-inline col-xs-12 col-sm-7">
									<span class="middle input-text-error" id="phone_errorlabel"></span>
								</span>
							</div>
						</div>
						<div class="form-group">
							
						</div>						
						<div class="form-group">
							<label class="col-sm-2 no-padding-right" for=""> Mobile Number<b class="red">*</b></label>
							<div class="col-sm-4">
								<input type="text" id="mobile" name="mobile" placeholder=" Mobile Number" value="<?php if(isset($customer)): echo $customer[0]->cust_mob1; endif; ?>" class="col-xs-10 form-control col-sm-5 mandatory-field" onKeyUp="javascript:return check_isnumeric(event,this,0);" onblur="javascript:return check_ismobile(event,this,0);"/>
								<span class="help-inline col-xs-12 col-sm-7">
									<span class="middle input-text-error" id="mobile_errorlabel"></span>
								</span>
							</div>

							<label class="col-sm-2 no-padding-right" for="">Alternative Mobile Number </label>
							<div class="col-sm-4">
								<input type="text" id="alt_mobile" name="alt_mobile" placeholder=" Mobile Number (Optional)" value="<?php if(isset($customer)): echo $customer[0]->cust_mob2; endif; ?>" class="col-xs-10 form-control col-sm-5 " onKeyUp="javascript:return check_isnumeric(event,this,0);" onblur="javascript:return check_ismobile(event,this,0);"/>
								<span class="help-inline col-xs-12 col-sm-7">
									<span class="middle input-text-error" id="alt_mobile_errorlabel"></span>
								</span>
							</div>
						</div>
						<div class="form-group">
							
						</div>
						<div class="form-group">
							<label class="col-sm-2 no-padding-right" for="">Company Name</label>
							<div class="col-sm-4">
								<input type="text" id="company_name" name="company_name" placeholder=" Company Name" onKeyUp="javascript:return check_isalphanumeric(event,this);" value="<?php if(isset($customer)): echo $customer[0]->cust_compname; endif; ?>" class="col-xs-10 form-control col-sm-5 " />
								<span class="help-inline col-xs-12 col-sm-7 mandatory-field">
									<span class="middle input-text-error" id="company_name_errorlabel"></span>
								</span>
							</div>

							<label class="col-sm-2 no-padding-right" for=""> Contact Person Name<b class="red">*</b></label>
							<div class="col-sm-4">
								<input type="text" id="contact_person_name" name="contact_person_name" onKeyUp="javascript:return check_isalphanumeric(event,this);" placeholder="Contact Person Name" value="<?php if(isset($customer)): echo $customer[0]->contact_per_name; endif; ?>" class="col-xs-10 form-control col-sm-5 mandatory-field" />
								<span class="help-inline col-xs-12 col-sm-7">
									<span class="middle input-text-error" id="contact_person_name_errorlabel"></span>
								</span>
							</div>
						</div>
						<div class="form-group">
							
						</div>
						<div class="form-group">
							<label class="col-sm-2 no-padding-right" for="form-field-2"> Contact Person Designation<b class="red">*</b></label>

							<div class="col-sm-4">
								<input type="text" id="contact_person_desig" name="contact_person_desig" onKeyUp="javascript:return check_isalphanumeric(event,this);" value="<?php if(isset($customer)): echo $customer[0]->contact_per_desg; endif; ?>" placeholder="Enter Contact Person Designation" class="col-xs-10 form-control col-sm-5 mandatory-field" />
								<span class="help-inline col-xs-12 col-sm-7">
									<span class="middle input-text-error" id="contact_person_desig_errorlabel"></span>
								</span>
							</div>

							<label class="col-sm-2 no-padding-right" for="form-field-2">Address<b class="red">*</b></label>
							<div class="col-sm-4">
								<input type="text" id="address" name="address" value="<?php if(isset($customer)): echo $customer[0]->cust_address; endif; ?>" placeholder="Enter Address" class="col-xs-10 form-control col-sm-5 mandatory-field" />
								<span class="help-inline col-xs-12 col-sm-7">
									<span class="middle input-text-error" id="address_errorlabel"></span>
								</span>
							</div>
						</div>
						<div class="form-group">
							
						</div>
						<div class="form-group">
							<label class="col-sm-2 no-padding-right" for="form-field-2">State<b class="red">*</b></label>
							<div class="col-sm-4">
								<input type="text" id="state" name="state" onKeyUp="javascript:return check_isalphanumeric(event,this);" value="<?php if(isset($customer)): echo $customer[0]->cust_state; endif; ?>" placeholder="Enter State" class="col-xs-10 form-control col-sm-5 mandatory-field" />
								<span class="help-inline col-xs-12 col-sm-7">
									<span class="middle input-text-error" id="state_errorlabel"></span>
								</span>
							</div>

							<label class="col-sm-2 no-padding-right" for="form-field-2">City<b class="red">*</b></label>
							<div class="col-sm-4">
								<input type="text" id="city" name="city" onKeyUp="javascript:return check_isalphanumeric(event,this);" value="<?php if(isset($customer)): echo $customer[0]->cust_city; endif; ?>" placeholder="Enter City " class="col-xs-10 form-control col-sm-5 mandatory-field" />
								<span class="help-inline col-xs-12 col-sm-7">
									<span class="middle input-text-error" id="city_errorlabel"></span>
								</span>
							</div>
						</div>
						<div class="form-group">
							
						</div>
						<div class="form-group">
							<label class="col-sm-2 no-padding-right" for="form-field-2">PIN <b class="red">*</b></label>
							<div class="col-sm-4">
								<input type="text" id="pin" name="pin" value="<?php if(isset($customer)): echo $customer[0]->cust_pin; endif; ?>" onKeyUp="javascript:return check_isnumeric(event,this);" placeholder="Enter PIN" class="col-xs-10 form-control col-sm-5 mandatory-field" />
								<span class="help-inline col-xs-12 col-sm-7">
									<span class="middle input-text-error" id="pin_errorlabel"></span>
								</span>
							</div>

							<label class="col-sm-2 no-padding-right" for="form-field-2">User Name<b class="red">*</b></label>

							<div class="col-sm-4">
								<input type="text" id="user_name" onKeyUp="javascript:return check_isalphanumeric(event,this);" name="user_name" value="<?php if(isset($customer)): echo $customer[0]->cust_username; endif; ?>" placeholder="Enter user name " class="col-xs-10 form-control col-sm-5 mandatory-field" />
								<span class="help-inline col-xs-12 col-sm-7">
									<span class="middle input-text-error" id="user_name_errorlabel"></span>
								</span>
							</div>
						</div>
											
						
						<div class="form-group">
							
						</div>
						<div class="form-group">
							<label class="col-sm-2 no-padding-right" for="form-field-2">Password<b class="red">*</b></label>

							<div class="col-sm-4">
								<input type="password" id="password" name="password" value="<?php if(isset($customer)): echo $customer[0]->cust_password; endif; ?>" placeholder="Enter Password" class="col-xs-10 form-control col-sm-5 mandatory-field" />
								<span class="help-inline col-xs-12 col-sm-7">
									<span class="middle input-text-error" id="password_errorlabel"></span>
								</span>
							</div>

							<label class="col-sm-2 no-padding-right" for="">Select Package<b class="red">*</b></label>

							<div class="col-sm-4">
								<select class="chosen-select form-control" name="package" id="form-field-select-3" data-placeholder="Choose a Package...">
									<option></option>
									<?php
										foreach ($package as $val) 
										{			
									?>								
											<option value="<?php echo $val->package_id ?>" <?php if(isset($customer) && $val->package_id == $customer[0]->package_id): echo "selected"; endif; ?>><?php echo $val->package_name; ?></option>
									<?php
										}
									?>
									
								</select>
							</div>
						</div>	
						<div class="clearfix form-actions">
							<div class="col-md-offset-3 col-md-9">
								<button class="btn btn-info test" type="submit">
									<i class="iconcategory"></i>
									<?php if(isset($customer)): echo "Update"; else: echo "Submit"; endif; ?>
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
			autoclose: true,
			todayHighlight: true
		})
		//show datepicker when clicking on the icon
		.next().on(ace.click_event, function(){
			$(this).prev().focus();
		});
	 
	});
</script>
