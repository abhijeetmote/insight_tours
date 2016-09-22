<div class="main-content">
	<div class="main-content-inner">
		<div class="breadcrumbs ace-save-state" id="breadcrumbs">
			<ul class="breadcrumb">
				<li>
					<i class="ace-icon fa fa-home home-icon"></i>
					<a href="<?php echo base_url()."tours"; ?>">Home</a>
				</li>

				<li>
					<a href="<?php echo base_url()."User/viewuser"; ?>">User List</a>
				</li>
				<li class="active">Add User</li>
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
					Add User
				</h1>
			</div><!-- /.page-header -->

			<div class="row">
				<div class="col-xs-12">
					<div class="alert-box"></div>
					<!-- PAGE CONTENT BEGINS -->
					<form class="form-horizontal" role="form" enctype="multipart/form-data" method="post" id="<?php if(isset($user)): echo "user_update"; else: echo "useradd"; endif; ?>">			

						<div class="form-group">
                            <label class="col-sm-2 no-padding-right" for="form-field-2">User Type</label>

                            <div class="col-sm-4">
                                <select data-placeholder="Active/Inactive" name="staff_status" id="staff_status" class="chosen-select form-control" style="display: none;">
                                    <option value="1">Admin</option>
                                    <option value="0">Super Admin</option>
                                    
                                </select>
                                <span class="help-inline col-xs-12 col-sm-7">
                                    <span class="middle input-text-error" id="staff_status_errorlabel"></span>
                                </span>
                            </div>

                            <label class="col-sm-2 no-padding-right" for="">User first name<b class="red">*</b></label>

							 <div class="col-sm-4">
                               <input type="text" id="first_name" name="first_name" placeholder="Enter First Name" class="col-xs-10 col-sm-12 mandatory-field" value="<?php if(isset($user)): echo $user[0]->user_first_name; endif; ?>" onKeyUp="javascript:return check_isalphanumeric(event,this);" />
								<span class="help-inline col-xs-12 col-sm-7">
									<span class="middle input-text-error" id="first_name_errorlabel"></span>
								</span>
                            </div>
                        </div>			
						 
						<input type="hidden" value="<?php if(isset($user)): echo $user[0]->user_id; endif; ?>" name="user_id">

						<div class="form-group">
							<label class="col-sm-2 no-padding-right" for="">User last name<b class="red">*</b></label>
						<div class="col-sm-4">
								<input type="text" id="last_name" name="last_name" placeholder="Enter Last Name" class="col-xs-10 col-sm-12 mandatory-field" value="<?php if(isset($user)): echo $user[0]->user_last_name; endif; ?>"  onKeyUp="javascript:return check_isalphanumeric(event,this);"/>
								<span class="help-inline col-xs-12 col-sm-7">
									<span class="middle input-text-error" id="last_name_errorlabel"></span>
								</span>
						</div>

						<label class="col-sm-2 no-padding-right" for="">User Email id<b class="red">*</b></label>
						<div class="col-sm-4">
								<input type="text" id="email_id" name="email_id" placeholder="Enter Email id" class="col-xs-10 col-sm-12 mandatory-field" value="<?php if(isset($user)): echo $user[0]->user_email_id; endif; ?>" onblur="check_isemail(this,event);"/>
								<span class="help-inline col-xs-12 col-sm-7">
									<span class="middle input-text-error" id="email_id_errorlabel"></span>
								</span>
							</div>	
						</div>


						 

						<div class="form-group">
							<label class="col-sm-2 no-padding-right" for="form-field-2">User Birth Date<b class="red">*</b></label>

							<div class="col-sm-4">
								 
								<input type="text" id="user_dob" data-date-format="dd-mm-yyyy" name="user_dob" placeholder="Enter User Birth Date" class="date-picker col-xs-10 col-sm-12 mandatory-field" 
								value="<?php if(isset($user)): echo $user[0]->user_dob; endif; ?>" />
								 
								<span class="help-inline col-xs-12 col-sm-7">
									<span class="middle input-text-error" id="user_dob_errorlabel"></span>
								</span>
							</div>

							<label class="col-sm-2 no-padding-right" for="">User Name<b class="red">*</b></label>
							<div class="col-sm-4">
								<input type="text" id="user_name" name="user_name" placeholder="Enter UserName" class="col-xs-10 col-sm-12 mandatory-field" value="<?php if(isset($user)): echo $user[0]->user_name; endif; ?>" onKeyUp="javascript:return check_isalphanumeric(event,this);" />
								<span class="help-inline col-xs-12 col-sm-7">
									<span class="middle input-text-error" id="user_name_errorlabel"></span>
								</span>
							</div>


						</div>


						 		 


						<div class="form-group">
							<label class="col-sm-2 no-padding-right" for="">Password<b class="red">*</b></label>
							<div class="col-sm-4">
								<input type="password" id="password" name="password" placeholder="Enter Password" class="col-xs-10 col-sm-12 mandatory-field" value="<?php if(isset($user)): echo $user[0]->password; endif; ?>" />
								<span class="help-inline col-xs-12 col-sm-7">
									<span class="middle input-text-error" id="password_errorlabel"></span>
								</span>
							</div>

							<label class="col-sm-2 no-padding-right" for="">Retype Password<b class="red">*</b></label>
							<div class="col-sm-4">
								<input type="password" id="re_password" onblur="javascript:return check_password();" name="re_password" placeholder="Retype Password" class="col-xs-10 col-sm-12 mandatory-field" value="<?php if(isset($user)): echo $user[0]->password; endif; ?>" />
								<span class="help-inline col-xs-12 col-sm-7">
									<span class="middle input-text-error" id="re_password_errorlabel"></span>
								</span>
							</div>
						</div>				 

						 			 
						<div class="form-group">
							<label class="col-sm-2 no-padding-right" for="">User Mobile Number</label>

							<div class="col-sm-4">
								<input type="text" id="mob_no" name="mob_no" onblur="javascript:return check_ismobile(event,this,0);"  onKeyUp="javascript:return check_isnumeric(event,this,0);" placeholder="Enter Mobile Number" class="col-xs-10 col-sm-12 mandatory-field" value="<?php if(isset($user)): echo $user[0]->user_mobile_number; endif; ?>" onChange="javascript:return check_ismobile(event,this);" />
								<span class="help-inline col-xs-12 col-sm-7">
									<span class="middle input-text-error" id="mob_no_errorlabel"></span>
								</span>
							</div>
						</div>

						<?php if(isset($user)){?>
							<div class="form-group files">
							<label class="col-sm-2 no-padding-right" for="">User Profile Photo</label>
							<div class="col-sm-4">
							<img src="<?php echo base_url().$user[0]->user_profile_photo; ?>" />
							<input type="file" id="profilephoto" name="profilephoto" />
							
						</div>
						</div>
						<?php } else {?>
						 <div class="form-group files">
							<label class="col-sm-2 no-padding-right" for="">User Profile Photo</label>

							<div class="col-sm-4">
								<input type="file" id="profilephoto" name="profilephoto" />
								<span class="help-inline col-xs-12 col-sm-7">
									<span class="middle input-text-error" id="profilephoto_errorlabel" ></span>
								</span>
							</div>
						</div>
						<?php } ?>
						<!--<div class="form-group">
							<label class="col-sm-2 no-padding-right" for=""></label>

							<div class="col-sm-1">
								<button class="btn btn-info test" type="button" id="add">
									<i class="ace-icon fa fa-plus bigger-110"></i>
									Add Photo
								</button>
							</div>
						</div> -->
						
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

	function check_password(){
		var pass = $('#password').val();
		var repass = $('#re_password').val();
		if(pass != repass ) {
			$("#re_password_errorlabel").html("Password Not Match");
			$("#re_password").val('');
	       $("#re_password").focus();
	       return false;
		}
	}
</script>