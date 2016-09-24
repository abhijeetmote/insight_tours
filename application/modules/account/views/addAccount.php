
<div class="main-content">
	<div class="main-content-inner">
		<div class="breadcrumbs ace-save-state" id="breadcrumbs">
			<ul class="breadcrumb">
				<li>
					<i class="ace-icon fa fa-home home-icon"></i>
					<a href="#">Home</a>
				</li>

				<li>
					<a href="#">Account</a>
				</li>
				<li class="active">Add Account</li>
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
					Add Account
				</h1>
			</div><!-- /.page-header -->

			<div class="row">
				<div class="col-xs-12">
					<div class="alert-box"></div>
					<!-- PAGE CONTENT BEGINS -->
					<form class="form-horizontal" role="form" id="<?php if(isset($account)): echo "updateaccount"; else: echo "insertaccount"; endif; ?>">						
						
						<input type="hidden" value="<?php if(isset($account)): echo $account[0]->account_id; endif; ?>" name="id">
						<input type="hidden" value="<?php if(isset($account)): echo $account[0]->ledger_id; endif; ?>" name="ledger_id">
						
						<div class="form-group">
                            <label class="col-sm-1 no-padding-right" for="form-field-2"> A/C Group<b class="red"> * </b></label>

                            <div class="col-sm-4">
                                <select data-placeholder="Account Type" name="account_type" id="account_type" class="chosen-select form-control" style="display: none;">
                                    <option value="<?php echo $cash_group;?>" <?php if(isset($account) && $account[0]->group_id == $cash_group)  : echo "selected"; endif;?>>Cash</option>
                                    <option value="<?php echo $bank_group;?>" <?php if(isset($account) && $account[0]->group_id == $bank_group)  : echo "selected"; endif;?>>Bank</option>
                                    
                                </select>
								<span class="help-inline col-xs-12 col-sm-7">
									<span class="middle input-text-error" id="account_type_errorlabel"></span>
								</span>
                            </div>


                            <label class="col-sm-1 no-padding-right" for="">A/C Name<b class="red"> * </b></label>

							<div class="col-sm-4">
								<input type="text" id="account_name" name="account_name" placeholder="Enter Account Name" class="col-xs-10 col-sm-12 mandatory-field" value="<?php if(isset($account)): echo $account[0]->account_name; endif; ?>" onKeyUp="javascript:return check_isalphanumeric(event,this);" />
								<span class="help-inline col-xs-12 col-sm-7">
									<span class="middle input-text-error" id="account_name_errorlabel"></span>
								</span>
							</div>
                            
                            
                            
                        </div>


						<div class="form-group">
							
							<label class="col-sm-1 no-padding-right" for="">A/C No</label>

							<div class="col-sm-4">
								<input type="text" id="account_no" name="account_no" placeholder="Enter Account no" class="col-xs-10 col-sm-12" value="<?php if(isset($account)): echo $account[0]->account_no; endif; ?>" onKeyUp="javascript:return check_isalphanumeric(event,this);" />
								<span class="help-inline col-xs-12 col-sm-7">
									<span class="middle input-text-error" id="account_no_errorlabel"></span>
								</span>
							</div>

							<label class="col-sm-1 no-padding-right" for=""> Amount<b class="red"> * </b></label>
                            <div class="col-sm-4">
                               <input type="text" id="amount" name="amount" placeholder="Enter Amount" class="col-xs-10 col-sm-12 <?php if(!isset($account)) :  echo "mandatory-field"; endif;?>"  value="<?php if(isset($account)) : echo $account[0]->amount; endif;?>" <?php if(isset($account)) :  echo "disabled"; endif;?> onKeyUp="javascript:return check_isammount(event,this);" onblur="sanitize_float(event,this);"/>
								<span class="help-inline col-xs-12 col-sm-7">
									<span class="middle input-text-error" id="amount_errorlabel"></span>
								</span>
                            </div>
						</div>


						<div class="form-group">
							<label class="col-sm-1 no-padding-right" for="form-field-2">Comment</label>	
                            <div class="col-sm-4">
                           
                                <textarea id="comment" name="comment"  placeholder="Enter Narration" class="col-xs-10 col-sm-12 mandatory-field" ><?php if(isset($account)) : echo $account[0]->comment; endif;?></textarea>
                                <span class="help-inline col-xs-12 col-sm-7">
                                    <span class="middle input-text-error" id="comment_errorlabel"></span>
                                </span>
                            </div>

                            <label class="col-sm-1 no-padding-right" for="form-field-2"> Status<b class="red"> * </b></label>

                            <div class="col-sm-4">
                                <select data-placeholder="Account Status" name="account_status" id="account_status" class="chosen-select form-control" style="display: none;">
                                    <option value="1" <?php if(isset($account) && $account[0]->status == 1)  : echo "selected"; endif;?>>Active</option>
                                    <option value="0" <?php if(isset($account) && $account[0]->status == 0)  : echo "selected"; endif;?>>Inactive</option>

                                    
                                </select>
								<span class="help-inline col-xs-12 col-sm-7">
									<span class="middle input-text-error" id="account_status_errorlabel"></span>
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
	 
		//datepicker plugin
		//link
		$('.date-picker').datepicker({
			autoclose: true,
			todayHighlight: true
		})
		//show datepicker when clicking on the icon
		.next().on(ace.click_event, function(){
			$(this).prev().focus();
		});
	
		//or change it into a date range picker
		$('.input-daterange').datepicker({autoclose:true});
	
	 
	
		
		if(!ace.vars['old_ie']) $('#date-timepicker1').datetimepicker({
		 //format: 'MM/DD/YYYY h:mm:ss A',//use this option to display seconds
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
		
		 
	
	});
</script>