<div class="main-content">
	<div class="main-content-inner">
		<div class="breadcrumbs ace-save-state" id="breadcrumbs">
			<ul class="breadcrumb">
				<li>
					<i class="ace-icon fa fa-home home-icon"></i>
					<a href="#">Home</a>
				</li>

				<li>
					<a href="#">Vendor</a>
				</li>
				<li class="active">Add Vendor</li>
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
					Add Vendor
				</h1>
			</div><!-- /.page-header -->

			<div class="row">
				<div class="col-xs-12">
					<div class="alert-box"></div>
					<!-- PAGE CONTENT BEGINS -->
					<form class="form-horizontal" role="form" id="<?php if(isset($vendor)): echo "vendor_update"; else: echo "vendormaster"; endif; ?>">						
						
						<input type="hidden" value="<?php if(isset($vendor)): echo $vendor[0]->vendor_id; endif; ?>" name="id">
						<input type="hidden" value="<?php if(isset($vendor)): echo $vendor[0]->vendor_ledger_id; endif; ?>" name="vendor_ledger_id">
						
						<div class="form-group">
                            <label class="col-sm-2 no-padding-right" for="form-field-2"> Vendor Name<b class="red">*</b></label>

                            <div class="col-sm-4">
                                <input type="text" id="vendor_name" name="vendor_name" value="<?php if(isset($vendor)): echo $vendor[0]->vendor_name; endif; ?>" placeholder="Enter Vendor Name" onKeyUp="javascript:return check_isalphanumeric(event,this);" class="col-xs-10 col-sm-12 mandatory-field" />
								<span class="help-inline col-xs-12 col-sm-7">
									<span class="middle input-text-error" id="vendor_name_errorlabel"></span>
								</span>
                            </div>
                            <label class="col-sm-2 no-padding-right" for=""> Mobile Number<b class="red">*</b></label>
                            <div class="col-sm-4">
                               <input type="text" id="vendor_contact_number" onKeyUp="javascript:return check_isnumeric(event,this,0);" onblur="javascript:return check_ismobile(event,this,0);" name="vendor_contact_number" placeholder=" Mobile Number" value="<?php if(isset($vendor)): echo $vendor[0]->vendor_contact_number; endif; ?>" class="col-xs-10 col-sm-12 mandatory-field" />
								<span class="help-inline col-xs-12 col-sm-7">
									<span class="middle input-text-error" id="vendor_contact_number_errorlabel"></span>
								</span>
                            </div>
                        </div>


						<div class="form-group">
							<label class="col-sm-2 no-padding-right" for="form-field-2"> Phone Number</label>

							<div class="col-sm-4">
								<input type="text" id="vendor_phone_number" onKeyUp="javascript:return check_isnumeric(event,this,0);" name="vendor_phone_number" value="<?php if(isset($vendor)): echo $vendor[0]->vendor_contact_number; endif; ?>" placeholder=" Phone Nubmer" class="col-xs-10 col-sm-12" />
								<span class="help-inline col-xs-12 col-sm-7">
									<span class="middle input-text-error" id="vendor_phone_numbererrorlabel"></span>
								</span>
							</div>
							<label class="col-sm-2 no-padding-right" for="form-field-2"> Vendor Email<b class="red">*</b></label>

							<div class="col-sm-4">
								<input type="text" id="vendor_email" name="vendor_email" value="<?php if(isset($vendor)): echo $vendor[0]->vendor_email; endif; ?>" placeholder="Enter Vendor Email" class="col-xs-10 col-sm-12 mandatory-field" />
								<span class="help-inline col-xs-12 col-sm-7">
									<span class="middle input-text-error" id="vendor_email_errorlabel"></span>
								</span>
							</div>
						</div>
						 

						<div class="form-group">
							<label class="col-sm-2 no-padding-right" for="form-field-2"> Vendor Notes</label>

							<div class="col-sm-4">
								<input type="text" id="vendor_notes" name="vendor_notes" value="<?php if(isset($vendor)): echo $vendor[0]->vendor_notes; endif; ?>" placeholder="Enter Vendor Notes" class="col-xs-10 col-sm-12" />
								<span class="help-inline col-xs-12 col-sm-7">
									<span class="middle input-text-error" id="vendor_notes_errorlabel"></span>
								</span>
							</div>

							<label class="col-sm-2 no-padding-right" for="form-field-2">Vendor Service Region</label>

							<div class="col-sm-4">
								<input type="text" id="vendor_service_regn" name="vendor_service_regn" value="<?php if(isset($vendor)): echo $vendor[0]->vendor_service_regn; endif; ?>" placeholder="Eneter Service Region" class="col-xs-10 col-sm-12" />
								<span class="help-inline col-xs-12 col-sm-7">
									<span class="middle input-text-error" id="vendor_service_regn_errorlabel"></span>
								</span>
							</div>
						</div>
						 

						<div class="form-group">
							<label class="col-sm-2 no-padding-right" for="form-field-2"> Vendor PAN Number<b class="red">*</b></label>

							<div class="col-sm-4">
								<input type="text" id="vendor_pan_num" name="vendor_pan_num" onblur="check_ispan(this,event);" value="<?php if(isset($vendor)): echo $vendor[0]->vendor_pan_num; endif; ?>" placeholder="Enter Vendor PAN Number" onchange="check_isalphanumeric(event,this);" class="col-xs-10 col-sm-12 mandatory-field" />
								<span class="help-inline col-xs-12 col-sm-7">
									<span class="middle input-text-error" id="vendor_pan_num_errorlabel"></span>
								</span>
							</div>

							<label class="col-sm-2 no-padding-right" for="form-field-2"> Vendor Section Code</label>

							<div class="col-sm-4">
								<input type="text" id="vendor_section_code" name="vendor_section_code" value="<?php if(isset($vendor)): echo $vendor[0]->vendor_section_code; endif; ?>" placeholder="Enter Section Code" class="col-xs-10 col-sm-12" />
								<span class="help-inline col-xs-12 col-sm-7">
									<span class="middle input-text-error" id="vendor_section_code_errorlabel"></span>
								</span>
							</div>
						</div>


						 
						<div class="form-group">
							<label class="col-sm-2 no-padding-right" for="form-field-2"> Vendor Payee Name<b class="red">*</b></label>

							<div class="col-sm-4">
								<input type="text" id="vendor_payee_name" name="vendor_payee_name" onKeyUp="javascript:return check_isalphanumeric(event,this);"onKeyUp="javascript:return check_isalphanumeric(event,this);" value="<?php if(isset($vendor)): echo $vendor[0]->vendor_payee_name; endif; ?>" placeholder="Enter Vendor Payee Name" class="col-xs-10 col-sm-12 mandatory-field" />
								<span class="help-inline col-xs-12 col-sm-7">
									<span class="middle input-text-error" id="vendor_payee_name_errorlabel"></span>
								</span>
							</div>
							<label class="col-sm-2 no-padding-right" for="form-field-2"> Vendor Address<b class="red">*</b></label>
							<div class="col-sm-4">
								<textarea id="vendor_address" name="vendor_address" placeholder="Enter Vendor Address" class="col-xs-10 col-sm-12 mandatory-field" ><?php if(isset($vendor)): echo $vendor[0]->vendor_address; endif; ?></textarea>
								<span class="help-inline col-xs-12 col-sm-7">
									<span class="middle input-text-error" id="vendor_address_errorlabel"></span>
								</span>
							</div>
						</div>


						 


						<div class="form-group">
							<label class="col-sm-2 no-padding-right" for="form-field-2"> VAT</label>

							<div class="col-sm-4">
								<input type="text" id="vendor_vat" name="vendor_vat" value="<?php if(isset($vendor)): echo $vendor[0]->vendor_vat; endif; ?>" placeholder="Enter Vendor VAT Number" class="col-xs-10 col-sm-12  " />
								<span class="help-inline col-xs-12 col-sm-7">
									<span class="middle input-text-error" id="vendor_vat_errorlabel"></span>
								</span>
							</div>

							<label class="col-sm-2 no-padding-right" for="form-field-2"> CST</label>

							<div class="col-sm-4">
								<input type="text" id="vendor_cst" name="vendor_cst" value="<?php if(isset($vendor)): echo $vendor[0]->vendor_cst; endif; ?>" placeholder="Enter  CST " class="col-xs-10 col-sm-12   " />
								<span class="help-inline col-xs-12 col-sm-7">
									<span class="middle input-text-error" id="vendor_cst_errorlabel"></span>
								</span>
							</div>
						</div>
						
						 
						
						<div class="form-group">
							<label class="col-sm-2 no-padding-right" for="form-field-2"> GST</label>

							<div class="col-sm-4">
								<input type="text" id="vendor_gst" name="vendor_gst" value="<?php if(isset($vendor)): echo $vendor[0]->vendor_gst; endif; ?>" placeholder="Enter GST" class="col-xs-10 col-sm-12  " />
								<span class="help-inline col-xs-12 col-sm-7">
									<span class="middle input-text-error" id="vendor_gst_errorlabel"></span>
								</span>
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
		 
			$('.chosen-select').chosen({allow_single_deselect:true}); 
			//resize the chosen on window resize
	 
		//link
		$('.date-picker').datepicker({
			autoclose: true,
			todayHighlight: true
		})
		 
	
	});
</script>