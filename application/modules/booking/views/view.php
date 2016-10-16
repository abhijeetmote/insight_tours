<div class="main-content">
	<div class="main-content-inner">
		<div class="breadcrumbs ace-save-state" id="breadcrumbs">
			<ul class="breadcrumb">
				<li>
					<i class="ace-icon fa fa-home home-icon"></i>
					<a href="<?php echo base_url().""; ?>">Home</a>
				</li>

				<li>
					<a href="<?php echo base_url()."booking/bookingList"; ?>"> Booking List</a>
				</li>
				<li class="active">Add Booking</li>
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
					Add Booking
				</h1>
			</div><!-- /.page-header -->

			<div class="row">
				<div class="col-xs-12">
					<div class="alert-box"></div>

					<!-- PAGE CONTENT BEGINS -->
					<form class="form-horizontal" role="form" id="<?php if(isset($booking)): echo "booking_update"; else: echo "bookingmaster"; endif; ?>">						
						<input type="hidden" value="<?php if(isset($booking)): echo $booking[0]->booking_id; endif; ?>" name="id">
						
						<div class="form-group">
							<label class="col-sm-2 no-padding-right" for="form-field-2">Booking Date*</label>

							<div class="col-sm-4">
								<div class="input-group">
								<input disabled type="text" class="form-control mandatory-field" id="date-timepicker1" name="booking_date" placeholder="Enter User Booking Date" value="<?php if(isset($booking)): echo $newDateTime = date('d/m/Y h:i A', strtotime($booking[0]->booking_date)); endif; ?>">
								<span class="input-group-addon">
									<i class="fa fa-clock-o bigger-110"></i>
								</span>

								</div>
								<span class="help-inline col-xs-12 col-sm-7">
									<span class="middle input-text-error" id="booking_date_errorlabel"></span>
								</span>
							</div>

							 <label class="col-sm-1 no-padding-right" for="form-field-2">Customer</label>

                            <div class="col-sm-4">
                                <select disabled data-placeholder="Active/Inactive" name="customer_id" id="customer_id" class="chosen-select form-control" style="display: none;">
                                    
									<?php 
										foreach ($customerList as $val) {
											if(isset($booking) && $val->cust_id == $booking[0]->cust_id){
												echo '<option selected value="'.$val->cust_id.'">'.$val->cust_firstname." " . $val->cust_lastname.'</option>';
											}else{
												echo '<option value="'.$val->cust_id.'">'.$val->cust_firstname." " . $val->cust_lastname.'</option>';
											}
										}
									?>
                                    
                                </select>
                                <span class="help-inline col-xs-12 col-sm-7">
                                    <span class="middle input-text-error" id="customer_id_errorlabel"></span>
                                </span>
                            </div>
						</div>

						<div class="form-group">
                            <label class="col-sm-2 no-padding-right" for="form-field-2">Vehicale Type</label>

                            <div class="col-sm-4">
                                <select disabled data-placeholder="vehicale type" name="vehicale_type" id="vehicale_type" class="chosen-select form-control" style="display: none;">
                                    <option></option>
									<?php 
										foreach ($vechileTList as $val) {
											if(isset($booking) && $val->cat_id == $booking[0]->vehicle_type){
												echo '<option selected value="'.$val->cat_id.'">'.$val->cat_name.'</option>';
											}else{
												echo '<option value="'.$val->cat_id.'">'.$val->cat_name.'</option>';
											}
										}
									?>
                                    
                                </select>
                                <span class="help-inline col-xs-12 col-sm-7">
                                    <span class="middle input-text-error" id="vehicale_type_errorlabel"></span>
                                </span>
                            </div>
                            <label class="col-sm-1 no-padding-right" for="form-field-2">Travel Type</label>
                            <div class="col-sm-4">
                                <select disabled data-placeholder="Local/Outstation" name="travel_type" id="travel_type" class="chosen-select form-control" style="display: none;">
                                	<option></option>
                                    <option <?php if(isset($booking) && $booking[0]->travel_type == "Local") { echo "selected"; }?> value="Local">Local</option>
                                    <option value="Outstation" <?php if(isset($booking) &&  $booking[0]->travel_type == "Outstation") { echo "selected"; }?>>Outstation</option>
                                     
                                    
                                </select>
                                <span class="help-inline col-xs-12 col-sm-7">
                                    <span class="middle input-text-error" id="travel_type_errorlabel"></span>
                                </span>
                            </div>
                        </div>

                         
                        <br>

                        <div class="form-group">
                            <label class="col-sm-2 no-padding-right" for="form-field-2">Package</label>

                            <div class="col-sm-4">
                                <select disabled name="package" id="package" placeholder="select package" class="form-control mandatory-field">
                                    <?php if(isset($booking)): ?>
                                    	<option value="<?php echo $booking[0]->package_id; ?>"><?php echo $booking[0]->package_name; ?></option>
                                	<?php endif; ?>
                                </select>
                                <span class="help-inline col-xs-12 col-sm-7">
                                    <span class="middle input-text-error" id="package_errorlabel"></span>
                                </span>
                            </div>
                        </div>


                        <div class="form-group">
							<label class="col-sm-2 no-padding-right" for="form-field-2">PickUp / Dropp Address*</label>
								
							<div class="col-sm-8">
								<div class="col-sm-6">   
								<textarea disabled id="pickup_address" style="width: 100%; height: 40px;" name="pickup_address" placeholder="Enter pickup Address" class="col-xs-10 col-sm-5 mandatory-field" ><?php if(isset($booking)): echo trim($booking[0]->pickup_location); endif; ?></textarea>
								<span class="help-inline col-xs-12 col-sm-7">
									<span class="middle input-text-error" id="pickup_address_errorlabel"></span>
								</span>
								</div>
								<div class="col-sm-6">   
								 <textarea disabled id="drop_address" style="width: 100%; height: 40px;" name="drop_address" placeholder="Enter drop Address" class="col-xs-10 col-sm-5 mandatory-field" ><?php if(isset($booking)): echo trim($booking[0]->drop_location); endif; ?></textarea>
								<span class="help-inline col-xs-12 col-sm-7">
									<span class="middle input-text-error" id="drop_address_errorlabel"></span>
								</span>
								</div>
								 
							</div>
					
						</div>

						<?php if(isset($passenger) && !empty($passenger)) { ?>
						<div class="form-group">
							<label class="col-sm-2 no-padding-right" for="form-field-2">Booking Status*</label>
								
							<div class="col-sm-8">
								<div class="col-sm-6">
                                <select disabled data-placeholder="Select Status" name="booking_status" id="booking_status" class="chosen-select form-control" style="display: none;">
                                    <option <?php if(isset($booking) && $booking[0]->booking_status == 1) { echo "selected"; }?> value="1">Pending</option>
                                    <option value="2" <?php if(isset($booking) &&  $booking[0]->booking_status == 2) { echo "selected"; }?>>On Tour</option>
                                    <option value="3" <?php if(isset($booking) &&  $booking[0]->booking_status == 3) { echo "selected"; }?>>End Tour</option>
                                    <option <?php if(isset($booking) && $booking[0]->booking_status == 4) { echo "selected"; }?> value="4">Cancel</option>
                                    <option <?php if(isset($booking) && $booking[0]->travel_type == 5) { echo "selected"; }?> value="5">UnPaid</option>
                                    <option value="6" <?php if(isset($booking) &&  $booking[0]->booking_status == 6) { echo "selected"; }?>>Paid</option>
                                    
                                </select>
                                <span class="help-inline col-xs-12 col-sm-7">
                                    <span class="middle input-text-error" id="booking_status_errorlabel"></span>
                                </span>
                            	</div>
                            	 
                            	<div style="display:none;" class="col-sm-6" id="cancel_reason">
                                <input disabled type="text" class="form-control" id="cancel_comment" name="cancel_comment" placeholder="Enter Cancel Reason" value="<?php if(isset($booking)): echo  $booking[0]->cancel_comment; endif; ?>">
                                <span class="help-inline col-xs-12 col-sm-7">
                                    <span class="middle input-text-error" id="cancel_reason_errorlabel"></span>
                                </span>
                            	</div>
								  
							</div>
					
						</div>
 						<?php } ?>
 						
 						<br>
 						<div id="passenger_div">

 						<?php if(isset($passenger) && !empty($passenger)) {
 						
 								$i = 1;
 								$count = count($passenger);
 								foreach ($passenger as $passenger) {
 								?>

 						
						<div class="form-group" id="passenger_details<?php echo $i;?>">
							<label class="col-sm-2 no-padding-right" for="form-field-2">Passenger Details <?php echo $i;?> *</label>
							
							
							
								
							<div class="col-sm-8">
								<div class="col-sm-6">    
								<input disabled type="text"  id="passenger_name<?php echo $i;?>" value="<?php if(isset($passenger)): echo $passenger->passenger_name; endif; ?>" name="passenger_name_edit[<?php echo $passenger->id;?>]" placeholder="Enter Passenger Name" class="col-xs-10 col-sm-12 mandatory-field" onKeyUp="javascript:return check_isalphanumeric(event,this);" />
								<span class="help-inline col-xs-12 col-sm-10">
									<span class="middle input-text-error" id="passenger_name<?php echo $i;?>_errorlabel"></span>
								</span>
								</div>
								<div class="col-sm-6">   
								<input disabled type="text"  id="passenger_number<?php echo $i;?>" value="<?php if(isset($passenger)): echo $passenger->passenger_number; endif; ?>" name="passenger_number_edit[<?php echo $passenger->id;?>]" onblur="javascript:return check_ismobile(event,this,0);" placeholder="Enter Mobile" class="col-xs-10 col-sm-12 mandatory-field" onKeyUp="javascript:return check_isnumeric(event,this);" />
								<span class="help-inline col-xs-12 col-sm-10">
									<span class="middle input-text-error" id="passenger_number<?php echo $i;?>_errorlabel"></span>
								</span>
								</div>
							</div>
							
							
							<div class="col-sm-8" style="margin-left:16.5%;">
								<div class="col-sm-6">   
								<textarea  disabled id="pass_pickup_address<?php echo $i;?>" style="width: 100%; height: 40px;" name="pass_pickup_address_edit[<?php echo $passenger->id;?>]" placeholder="Enter pickup Address" class="col-xs-10 col-sm-5 mandatory-field" ><?php if(isset($passenger)): echo trim($passenger->pickup_address); endif; ?></textarea>
								<span class="help-inline col-xs-12 col-sm-10">
									<span class="middle input-text-error" id="pass_pickup_address<?php echo $i;?>_errorlabel"></span>
								</span>
								</div>
								<div class="col-sm-6">   
								<textarea  disabled id="pass_drop_address<?php echo $i;?>" style="width: 100%; height: 40px;" name="pass_drop_address_edit[<?php echo $passenger->id;?>]" placeholder="Enter drop Address" class="col-xs-10 col-sm-5 mandatory-field" ><?php if(isset($passenger)): echo trim($passenger->drop_address); endif; ?></textarea>
								<span class="help-inline col-xs-12 col-sm-10">
									<span class="middle input-text-error" id="pass_drop_address<?php echo $i;?>_errorlabel"></span>
								</span>
								</div>
							</div>
						</div>

						 

 						<?php $i ++ ;} 
 						}else { ?>
						
						<div class="form-group" id="passenger_details">
							<label class="col-sm-2 no-padding-right" for="form-field-2">Passenger Details 1 *</label>
							

								
							<div class="col-sm-8">
								<div class="col-sm-6">   
								<input disabled type="text" id="passenger_name" value="" name="passenger_name[]" placeholder="Enter Passenger Name" class="col-xs-10 col-sm-12 mandatory-field" onKeyUp="javascript:return check_isalphanumeric(event,this);" />
								<span class="help-inline col-xs-12 col-sm-10">
									<span class="middle input-text-error" id="passenger_name_errorlabel"></span>
								</span>
								</div>
								<div class="col-sm-6">   
								<input disabled type="text" id="passenger_number" value="" name="passenger_number[]" placeholder="Enter Mobile" onblur="javascript:return check_ismobile(event,this,0);" class="col-xs-10 col-sm-12 mandatory-field" onKeyUp="javascript:return check_isnumeric(event,this);" />
								<span class="help-inline col-xs-12 col-sm-10">
									<span class="middle input-text-error" id="passenger_number_errorlabel"></span>
								</span>
								</div>
							</div>
							
							
							<div class="col-sm-8" style="margin-left:16.5%;">
								<div class="col-sm-6">   
								<textarea disabled id="pass_pickup_address" style="width: 100%; height: 40px;" name="pass_pickup_address[]" placeholder="Enter pickup Address" class="col-xs-10 col-sm-5 mandatory-field" ></textarea>
								<span class="help-inline col-xs-12 col-sm-10">
									<span class="middle input-text-error" id="pass_pickup_address_errorlabel"></span>
								</span>
								</div>
								<div class="col-sm-6">   
								<textarea disabled id="pass_drop_address" style="width: 100%; height: 40px;" name="pass_drop_address[]" placeholder="Enter drop Address" class="col-xs-10 col-sm-5 mandatory-field" ></textarea>
								<span class="help-inline col-xs-12 col-sm-10">
									<span class="middle input-text-error" id="pass_drop_address_errorlabel"></span>
								</span>
								</div>
							</div>
						</div>

						 
						 <?php } ?>

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

	$(document).ready(function(){
		$(document).on('click','.add_new_person', function() {
			 
			 var id = $(this).attr('id');
			 var tabId = id.split("_").pop();
			 //alert(tabId);
			 tabId =parseInt(tabId)+1;
			 var htmlString = '<div class="form-group" id="passenger_details'+tabId+'"><label class="col-sm-2 no-padding-right" for="form-field-2">Passenger Details '+tabId+'*</label><button class="btn btn-success add_new_person" id="add_new_person_'+tabId+'" type="button"><i class="iconcategory"></i><b style="color:black;">+</b></button><div class="col-sm-8"><div class="col-sm-6"><input type="text" id="passenger_name'+tabId+'"  name="passenger_name[]" placeholder="Enter Passenger Name" class="col-xs-10 col-sm-12 mandatory-field" onKeyUp="javascript:return check_isalphanumeric(event,this);" /><span class="help-inline col-xs-12 col-sm-10"><span class="middle input-text-error" id="passenger_name'+tabId+'_errorlabel"></span></span></div><div class="col-sm-6"><input type="text" id="passenger_number'+tabId+'"  name="passenger_number[]" onblur="javascript:return check_ismobile(event,this,0);" placeholder="Enter Mobile" class="col-xs-10 col-sm-12 mandatory-field" onKeyUp="javascript:return check_isnumeric(event,this);" /><span class="help-inline col-xs-12 col-sm-10"><span class="middle input-text-error" id="passenger_number'+tabId+'_errorlabel"></span></span></div></div><button class="btn btn-danger remove_person" id="remove_person_'+tabId+'" type="button"><i class="iconcategory"></i><b style="color:black;">-</b></button><div class="col-sm-8" style="margin-left:16.5%;"><div class="col-sm-6">   <textarea id="pass_pickup_address'+tabId+'" style="width: 100%; height: 40px;" name="pass_pickup_address[]" placeholder="Enter pickup Address" class="col-xs-10 col-sm-5 mandatory-field" ></textarea><span class="help-inline col-xs-12 col-sm-10"><span class="middle input-text-error" id="pass_pickup_address'+tabId+'_errorlabel"></span></span></div><div class="col-sm-6"><textarea id="pass_drop_address'+tabId+'" style="width: 100%; height: 40px;" name="pass_drop_address[]" placeholder="Enter drop Address" class="col-xs-10 col-sm-5 mandatory-field" ></textarea><span class="help-inline col-xs-12 col-sm-10"><span class="middle input-text-error" id="pass_drop_address'+tabId+'_errorlabel"></span></span></div></div></div>';
			 $('#passenger_div').append(htmlString);
			 $("#"+id).remove();

		});

		$(document).on('change','#booking_status', function() {
			 $('#cancel_reason').hide();
			 var id = $(this).val();
			 //alert(id);
			 if(id == 4) {
			 	//alert("aa");
			 	$('#cancel_reason').show();
			 }
			 

		});

		

		$(document).on('click','.remove_person', function() {
			 
			 var div_id = $(this).attr('id');
			 var name = $(this).attr('name');
			alert(name);

			 if(name != "" && name!=undefined) {

			 	if(confirm("Are you sure you want to delete!")){
			 		var id = name;
        
			        var obj = array.filter(function(obj){
			            return obj.name === 'passenger-detail-delete'
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
			                if(data.success == true){
			                	$('#pass_data').html(data.successMsg);

			                }else{

			                }
			            },
			            error: function (xhr, ajaxOptions, thrownError) {
			                console.log(thrownError);
			            }
			        });
			     } else {
			     	return false;
			     }   
			 } 

			 var tabId = div_id.split("_").pop();
			 //alert(tabId);
			 $("#passenger_details"+tabId).remove();

			 
		});

		$(document).on('change','#vehicale_type', function() {
			 
			var v_type = $(this).val();
			var t_type = $("#travel_type").val();
			if(v_type != "" && t_type != ""){
				var obj = array.filter(function(obj){
		            return obj.name === 'package-List-booking'
		        })[0];

		        var uri = obj['value'];

		        jobject = {
		            'v_type' : v_type,
		            't_type' : t_type
		        }
		        
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
		            	 
		                if(data.success == true){
		                	 
		                	$('#package').html(data.successMsg);
		                }
		            },
		            error: function (xhr, ajaxOptions, thrownError) {
		                console.log(thrownError);
		            }
		        });
			}
		});

		$(document).on('change','#travel_type', function() {
			 
			var t_type = $(this).val();
			var v_type = $("#vehicale_type").val();
			if(v_type != "" && t_type != ""){
				var obj = array.filter(function(obj){
		            return obj.name === 'package-List-booking'
		        })[0];

		        var uri = obj['value'];

		        jobject = {
		            'v_type' : v_type,
		            't_type' : t_type
		        }
		        
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
		            	 
		                if(data.success == true){
		                	 
		                	$('#package').html(data.successMsg);
		                }
		            },
		            error: function (xhr, ajaxOptions, thrownError) {
		                console.log(thrownError);
		            }
		        });
			}
		});

	});
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
	
	
		$('#id-input-file-3').ace_file_input({
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
	
		
		
	
		//dynamically change allowed formats by changing allowExt && allowMime function
		$('#id-file-format').removeAttr('checked').on('change', function() {
			var whitelist_ext, whitelist_mime;
			var btn_choose
			var no_icon
			if(this.checked) {
				btn_choose = "Drop images here or click to choose";
				no_icon = "ace-icon fa fa-picture-o";
	
				whitelist_ext = ["jpeg", "jpg", "png", "gif" , "bmp"];
				whitelist_mime = ["image/jpg", "image/jpeg", "image/png", "image/gif", "image/bmp"];
			}
			else {
				btn_choose = "Drop files here or click to choose";
				no_icon = "ace-icon fa fa-cloud-upload";
				
				whitelist_ext = null;//all extensions are acceptable
				whitelist_mime = null;//all mimes are acceptable
			}
			var file_input = $('#id-input-file-3');
			file_input
			.ace_file_input('update_settings',
			{
				'btn_choose': btn_choose,
				'no_icon': no_icon,
				'allowExt': whitelist_ext,
				'allowMime': whitelist_mime
			})
			file_input.ace_file_input('reset_input');
			
			file_input
			.off('file.error.ace')
			.on('file.error.ace', function(e, info) {
				//console.log(info.file_count);//number of selected files
				//console.log(info.invalid_count);//number of invalid files
				//console.log(info.error_list);//a list of errors in the following format
				
				//info.error_count['ext']
				//info.error_count['mime']
				//info.error_count['size']
				
				//info.error_list['ext']  = [list of file names with invalid extension]
				//info.error_list['mime'] = [list of file names with invalid mimetype]
				//info.error_list['size'] = [list of file names with invalid size]
				
				
				/**
				if( !info.dropped ) {
					//perhapse reset file field if files have been selected, and there are invalid files among them
					//when files are dropped, only valid files will be added to our file array
					e.preventDefault();//it will rest input
				}
				*/
				
				
				//if files have been selected (not dropped), you can choose to reset input
				//because browser keeps all selected files anyway and this cannot be changed
				//we can only reset file field to become empty again
				//on any case you still should check files with your server side script
				//because any arbitrary file can be uploaded by user and it's not safe to rely on browser-side measures
			});
			
			
			/**
			file_input
			.off('file.preview.ace')
			.on('file.preview.ace', function(e, info) {
				console.log(info.file.width);
				console.log(info.file.height);
				e.preventDefault();//to prevent preview
			});
			*/
		
		});
	
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
		
		
	
		
		if(!ace.vars['old_ie']) $('#date-timepicker1').datetimepicker({
		 //format: 'MM/DD/YYYY h:mm:ss A',//use this option to display seconds
		 format: 'DD/MM/YYYY h:mm A',//use this option to display seconds
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
		
		//$("#date-timepicker1").val('<?php if(isset($booking)): echo $newDateTime = date('d/m/Y h:i A', strtotime($booking[0]->booking_date)); endif; ?>');
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
