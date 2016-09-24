

<div class="main-content">
	<div class="main-content-inner">
		<div class="breadcrumbs ace-save-state" id="breadcrumbs">
			<ul class="breadcrumb">
				<li>
					<i class="ace-icon fa fa-home home-icon"></i>
					<a href="<?php echo base_url().""; ?>">Home</a>
				</li>

			 
				<li class="active">Add Amount</li>
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
					Add Amount
				</h1>
			</div><!-- /.page-header -->

			<div class="row">
				<div class="col-xs-12">
					<div class="alert-box"></div>
					<!-- PAGE CONTENT BEGINS -->
					<form class="form-horizontal" role="form" id="addamount">						
						 

						 

					<div class="form-group">
                            <label class="col-sm-1 no-padding-right" for="form-field-2"><b class="red"> * </b>FROM</label>

                            <div class="col-sm-4">
                                <?php 
                                	echo $from_select;
                                ?>
                                <span class="help-inline col-xs-12 col-sm-7">
                                    <span class="middle input-text-error" id="from_ledger_errorlabel"></span>
                                </span>
                            </div>
                            <label class="col-sm-1 no-padding-right" for="form-field-2"><b class="red"> * </b>AMOUNT</label>

                            <div class="col-sm-4">
                                 <input type="text" id="payment_amount" name="payment_amount" value="" placeholder="Enter Amount" class="col-xs-10 col-sm-9 mandatory-field"  onKeyUp="javascript:return check_isammount(event,this);" onblur="sanitize_float(event,this);"/>
                                <span class="help-inline col-xs-12 col-sm-7">
                                    <span class="middle input-text-error" id="payment_amount_errorlabel"></span>
                                </span>
                            </div>
                              
                    </div>


                    <div class="form-group">
                            

                             <label class="col-sm-1 no-padding-right" for="form-field-2"><b class="red"> * </b>NARRATION</label>	
                            <div class="col-sm-4">
                           
                                <textarea id="narration" name="narration"  placeholder="Enter Narration" class="col-xs-10 col-sm-9 mandatory-field" ></textarea>
                                <span class="help-inline col-xs-12 col-sm-7">
                                    <span class="middle input-text-error" id="narration_errorlabel"></span>
                                </span>
                            </div>

                             <label class="col-sm-1 no-padding-right" for="form-field-2"> REFERANCE</label>	
		                    <div class="col-sm-4">
		                        <input type="text" id="referance_no" name="referance_no" placeholder="Enter Referance No" class="col-xs-10 col-sm-9" value=""/>
								<span class="help-inline col-xs-12 col-sm-7">
									<span class="middle input-text-error" id="referance_no_errorlabel"></span>
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
<style>
	optgroup{
		color: black;
		font-size: 15px;
		font-weight: bold;
	}
	#to_ledger{
		height:15%;
		width: 75%;
	}
	#from_ledger{
		height:15%;
		width: 75%;
	}
	option {
    padding: 3px 4px 5px 35px !important;
	}
</style>
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
	
	
		 
	
	});	
</script>
 