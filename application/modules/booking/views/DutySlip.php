<div class="main-content">
	<div class="main-content-inner">
		<div class="breadcrumbs ace-save-state" id="breadcrumbs">
			<ul class="breadcrumb">
				<li>
					<i class="ace-icon fa fa-home home-icon"></i>
					<a href="#">Home</a>
				</li>

				<li>
					<a href="#">Forms</a>
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
					Add Slip
				</h1>
			</div><!-- /.page-header -->

			<div class="row">
				<div class="col-xs-12">
					<div class="alert-box"></div>
					<!-- PAGE CONTENT BEGINS -->
					<form class="form-horizontal" role="form" method="post" id="dutySlip" enctype="multipart/form-data">						
						<div class="form-group">
							<label class="col-sm-3 control-label no-padding-right" for="">Select Vehicle*</label>

							<div class="col-sm-4">
								<select class="chosen-select form-control" name="vehicle" id="form-field-select-3" data-placeholder="Choose a State...">
									<?php
										foreach ($vehicleList as $val) {
											echo '<option value="'.$val->vehicle_id.'">'.$val->vehicle_no.'</option>';
										}
									?>
									
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label no-padding-right" for="">Select Driver*</label>

							<div class="col-sm-4">
								<select class="chosen-select form-control" name="driver" id="form-field-select-3" data-placeholder="Choose a State...">
									<?php
										foreach ($driverList as $val) {
											echo '<option value="'.$val->driver_id.'">'.$val->driver_fname.' '.$val->driver_lname.'</option>';
										}
									?>
									
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label no-padding-right" for="">Total kms*</label>

							<div class="col-sm-9">
								<input type="text" id="total_km" name="total_km" placeholder="Enter Total kms" class="col-xs-10 col-sm-5 mandatory-field" value="" />
								<span class="help-inline col-xs-12 col-sm-7">
									<span class="middle input-text-error" id="total_km_errorlabel"></span>
								</span>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-3 control-label no-padding-right" for="">Extra kms*</label>

							<div class="col-sm-9">
								<input type="text" id="extra_kms" name="extra_kms" placeholder="Enter Extra kms" class="col-xs-10 col-sm-5 mandatory-field" value="" />
								<span class="help-inline col-xs-12 col-sm-7">
									<span class="middle input-text-error" id="extra_kms_errorlabel"></span>
								</span>
							</div>
						</div>
						
						<div class="form-group">
							<label class="col-sm-3 control-label no-padding-right" for="">Start Date*</label>

							<div class="col-sm-9">
								<input type="text" id="start_date" name="start_date" placeholder="Enter Start Date" class="col-xs-10 col-sm-5 mandatory-field date-picker" value="" />
								<span class="help-inline col-xs-12 col-sm-7">
									<span class="middle input-text-error" id="start_date_errorlabel"></span>
								</span>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label no-padding-right" for="">End Date*</label>

							<div class="col-sm-9">
								<input type="text" id="end_date" name="end_date" placeholder="Enter End Date" class="col-xs-10 col-sm-5 mandatory-field date-picker" value=""/>
								<span class="help-inline col-xs-12 col-sm-7">
									<span class="middle input-text-error" id="end_date_errorlabel"></span>
								</span>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label no-padding-right" for="">Extra Hrs*</label>

							<div class="col-sm-9">
								<input type="text" id="extra_hrs" name="extra_hrs" placeholder="Enter Extra Hrs" class="col-xs-10 col-sm-5 mandatory-field" value="" />
								<span class="help-inline col-xs-12 col-sm-7">
									<span class="middle input-text-error" id="extra_hrs_errorlabel"></span>
								</span>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label no-padding-right">Total Hrs</label>

							<div class="col-sm-9">
								<input type="text" id="total_hrs" name="total_hrs" placeholder="Enter Total Hrs" class="col-xs-10 col-sm-5 mandatory-field" value="" />
								<span class="help-inline col-xs-12 col-sm-7">
									<span class="middle input-text-error" id="total_hrs_errorlabel"></span>
								</span>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label no-padding-right" for="">Toll Fess*</label>

							<div class="col-sm-9">
								<input type="text" id="toll_fess" name="toll_fess" placeholder="Enter Toll Fess" class="col-xs-10 col-sm-5 mandatory-field" value="" />
								<span class="help-inline col-xs-12 col-sm-7">
									<span class="middle input-text-error" id="toll_fess_errorlabel"></span>
								</span>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label no-padding-right" for="">Parking Fees*</label>

							<div class="col-sm-9">
								<input type="text" id="parking_fees" name="parking_fees" placeholder="Enter Parking Fees" class="col-xs-10 col-sm-5 mandatory-field" value="" />
								<span class="help-inline col-xs-12 col-sm-7">
									<span class="middle input-text-error" id="parking_fees_errorlabel"></span>
								</span>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label no-padding-right" for="">Advance Paid*</label>

							<div class="col-sm-9">
								<input type="text" id="advance_paid" name="advance_paid" placeholder="Enter Advance Paid" class="col-xs-10 col-sm-5 mandatory-field" value="" />
								<span class="help-inline col-xs-12 col-sm-7">
									<span class="middle input-text-error" id="advance_paid_errorlabel"></span>
								</span>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label no-padding-right" for="">Total Amt*</label>

							<div class="col-sm-9">
								<input type="text" id="total_amt" name="total_amt" placeholder="Enter Total Amt" class="col-xs-10 col-sm-5 mandatory-field" value="" />
								<span class="help-inline col-xs-12 col-sm-7">
									<span class="middle input-text-error" id="total_amt_errorlabel"></span>
								</span>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label no-padding-right" for="">Comments*</label>

							<div class="col-sm-9">
								<input type="text" id="tpermit_exp" name="tpermit_exp" placeholder="Enter Comments" class="col-xs-10 col-sm-5 mandatory-field" value="" />
								<span class="help-inline col-xs-12 col-sm-7">
									<span class="middle input-text-error" id="tpermit_exp_errorlabel"></span>
								</span>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label no-padding-right" for="">Payment Status*</label>

							<div class="col-sm-9">
								<input type="text" id="payment_status" name="payment_status" placeholder="Enter Payment Status" class="col-xs-10 col-sm-5 mandatory-field" value="" />
								<span class="help-inline col-xs-12 col-sm-7">
									<span class="middle input-text-error" id="payment_status_errorlabel"></span>
								</span>
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
	
	
		$('[data-rel=tooltip]').tooltip({container:'body'});
		$('[data-rel=popover]').popover({container:'body'});
	
		autosize($('textarea[class*=autosize]'));
		
		$('textarea.limited').inputlimiter({
			remText: '%n character%s remaining...',
			limitText: 'max allowed : %n.'
		});
	
		$.mask.definitions['~']='[+-]';
		$('.input-mask-date').mask('99/99/9999');
		$('.input-mask-phone').mask('(999) 999-9999');
		$('.input-mask-eyescript').mask('~9.99 ~9.99 999');
		$(".input-mask-product").mask("a*-999-a999",{placeholder:" ",completed:function(){alert("You typed the following: "+this.val());}});
	
	
	
		$( "#input-size-slider" ).css('width','200px').slider({
			value:1,
			range: "min",
			min: 1,
			max: 8,
			step: 1,
			slide: function( event, ui ) {
				var sizing = ['', 'input-sm', 'input-lg', 'input-mini', 'input-small', 'input-medium', 'input-large', 'input-xlarge', 'input-xxlarge'];
				var val = parseInt(ui.value);
				$('#form-field-4').attr('class', sizing[val]).attr('placeholder', '.'+sizing[val]);
			}
		});
	
		$( "#input-span-slider" ).slider({
			value:1,
			range: "min",
			min: 1,
			max: 12,
			step: 1,
			slide: function( event, ui ) {
				var val = parseInt(ui.value);
				$('#form-field-5').attr('class', 'col-xs-'+val).val('.col-xs-'+val);
			}
		});
	
	
		
		//"jQuery UI Slider"
		//range slider tooltip example
		$( "#slider-range" ).css('height','200px').slider({
			orientation: "vertical",
			range: true,
			min: 0,
			max: 100,
			values: [ 17, 67 ],
			slide: function( event, ui ) {
				var val = ui.values[$(ui.handle).index()-1] + "";
	
				if( !ui.handle.firstChild ) {
					$("<div class='tooltip right in' style='display:none;left:16px;top:-6px;'><div class='tooltip-arrow'></div><div class='tooltip-inner'></div></div>")
					.prependTo(ui.handle);
				}
				$(ui.handle.firstChild).show().children().eq(1).text(val);
			}
		}).find('span.ui-slider-handle').on('blur', function(){
			$(this.firstChild).hide();
		});
		
		
		$( "#slider-range-max" ).slider({
			range: "max",
			min: 1,
			max: 10,
			value: 2
		});
		
		$( "#slider-eq > span" ).css({width:'90%', 'float':'left', margin:'15px'}).each(function() {
			// read initial values from markup and remove that
			var value = parseInt( $( this ).text(), 10 );
			$( this ).empty().slider({
				value: value,
				range: "min",
				animate: true
				
			});
		});
		
		$("#slider-eq > span.ui-slider-purple").slider('disable');//disable third item
	
		
		$('#id-input-file-1 , #id-input-file-2').ace_file_input({
			no_file:'No File ...',
			btn_choose:'Choose',
			btn_change:'Change',
			droppable:false,
			onchange:null,
			thumbnail:false //| true | large
			//whitelist:'gif|png|jpg|jpeg'
			//blacklist:'exe|php'
			//onchange:''
			//
		});
		//pre-show a file name, for example a previously selected file
		//$('#id-input-file-1').ace_file_input('show_file_list', ['myfile.txt'])
	
	
		$('.id-input-file-3').ace_file_input({
			style: 'well',
			btn_choose: 'Drop files here or click to choose',
			btn_change: null,
			no_icon: 'ace-icon fa fa-cloud-upload',
			droppable: true,
			thumbnail: 'small'//large | fit
			//,icon_remove:null//set null, to hide remove/reset button
			/**,before_change:function(files, dropped) {
				//Check an example below
				//or examples/file-upload.html
				return true;
			}*/
			/**,before_remove : function() {
				return true;
			}*/
			,
			preview_error : function(filename, error_code) {
				//name of the file that failed
				//error_code values
				//1 = 'FILE_LOAD_FAILED',
				//2 = 'IMAGE_LOAD_FAILED',
				//3 = 'THUMBNAIL_FAILED'
				//alert(error_code);
			}
	
		}).on('change', function(){
			//console.log($(this).data('ace_input_files'));
			//console.log($(this).data('ace_input_method'));
		});
		
		
		//$('#id-input-file-3')
		//.ace_file_input('show_file_list', [
			//{type: 'image', name: 'name of image', path: 'http://path/to/image/for/preview'},
			//{type: 'file', name: 'hello.txt'}
		//]);
	
		
	
		$('#spinner1').ace_spinner({value:0,min:0,max:200,step:10, btn_up_class:'btn-info' , btn_down_class:'btn-info'})
		.closest('.ace-spinner')
		.on('changed.fu.spinbox', function(){
			//console.log($('#spinner1').val())
		}); 
		$('#spinner2').ace_spinner({value:0,min:0,max:10000,step:100, touch_spinner: true, icon_up:'ace-icon fa fa-caret-up bigger-110', icon_down:'ace-icon fa fa-caret-down bigger-110'});
		$('#spinner3').ace_spinner({value:0,min:-100,max:100,step:10, on_sides: true, icon_up:'ace-icon fa fa-plus bigger-110', icon_down:'ace-icon fa fa-minus bigger-110', btn_up_class:'btn-success' , btn_down_class:'btn-danger'});
		$('#spinner4').ace_spinner({value:0,min:-100,max:100,step:10, on_sides: true, icon_up:'ace-icon fa fa-plus', icon_down:'ace-icon fa fa-minus', btn_up_class:'btn-purple' , btn_down_class:'btn-purple'});
	
		//$('#spinner1').ace_spinner('disable').ace_spinner('value', 11);
		//or
		//$('#spinner1').closest('.ace-spinner').spinner('disable').spinner('enable').spinner('value', 11);//disable, enable or change value
		//$('#spinner1').closest('.ace-spinner').spinner('value', 0);//reset to 0
	
	
		//datepicker plugin
		//link
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
	
	
		//to translate the daterange picker, please copy the "examples/daterange-fr.js" contents here before initialization
		$('input[name=date-range-picker]').daterangepicker({
			'applyClass' : 'btn-sm btn-success',
			'cancelClass' : 'btn-sm btn-default',
			locale: {
				applyLabel: 'Apply',
				cancelLabel: 'Cancel',
			}
		})
		.prev().on(ace.click_event, function(){
			$(this).next().focus();
		});
	
	
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
		
		
	
		
		if(!ace.vars['old_ie']) $('.date-timepicker1').datetimepicker({
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
		
		
		var tag_input = $('#form-field-tags');
		try{
			tag_input.tag(
			  {
				placeholder:tag_input.attr('placeholder'),
				//enable typeahead by specifying the source array
				source: ace.vars['US_STATES'],//defined in ace.js >> ace.enable_search_ahead
				/**
				//or fetch data from database, fetch those that match "query"
				source: function(query, process) {
				  $.ajax({url: 'remote_source.php?q='+encodeURIComponent(query)})
				  .done(function(result_items){
					process(result_items);
				  });
				}
				*/
			  }
			)
	
			//programmatically add/remove a tag
			var $tag_obj = $('#form-field-tags').data('tag');
			$tag_obj.add('Programmatically Added');
			
			var index = $tag_obj.inValues('some tag');
			$tag_obj.remove(index);
		}
		catch(e) {
			//display a textarea for old IE, because it doesn't support this plugin or another one I tried!
			tag_input.after('<textarea id="'+tag_input.attr('id')+'" name="'+tag_input.attr('name')+'" rows="3">'+tag_input.val()+'</textarea>').remove();
			//autosize($('#form-field-tags'));
		}
		
		
		/////////
		$('#modal-form input[type=file]').ace_file_input({
			style:'well',
			btn_choose:'Drop files here or click to choose',
			btn_change:null,
			no_icon:'ace-icon fa fa-cloud-upload',
			droppable:true,
			thumbnail:'large'
		})
		
		//chosen plugin inside a modal will have a zero width because the select element is originally hidden
		//and its width cannot be determined.
		//so we set the width after modal is show
		$('#modal-form').on('shown.bs.modal', function () {
			if(!ace.vars['touch']) {
				$(this).find('.chosen-container').each(function(){
					$(this).find('a:first-child').css('width' , '210px');
					$(this).find('.chosen-drop').css('width' , '210px');
					$(this).find('.chosen-search input').css('width' , '200px');
				});
			}
		})
		/**
		//or you can activate the chosen plugin after modal is shown
		//this way select element becomes visible with dimensions and chosen works as expected
		$('#modal-form').on('shown', function () {
			$(this).find('.modal-chosen').chosen();
		})
		*/
	
		
		
		$(document).one('ajaxloadstart.page', function(e) {
			autosize.destroy('textarea[class*=autosize]')
			
			$('.limiterBox,.autosizejs').remove();
			$('.daterangepicker.dropdown-menu,.colorpicker.dropdown-menu,.bootstrap-datetimepicker-widget.dropdown-menu').remove();
		});
	
	});
</script>