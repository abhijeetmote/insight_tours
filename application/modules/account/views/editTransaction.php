 
<div class="main-content">
    <div class="main-content-inner">
        <div class="breadcrumbs ace-save-state" id="breadcrumbs">
            <ul class="breadcrumb">
                <li>
                    <i class="ace-icon fa fa-home home-icon"></i>
                    <a href="#">Home</a>
                </li>

                <li>
                    <a href="#"> Booking</a>
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
                    <form class="form-horizontal" role="form" id="editTransaction">                     
                        
                        <input type="hidden" value="<?php echo $from_data[0]->txn_id;?>" name="from_txn_id" id="from_txn_id"/>
                        <input type="hidden" value="<?php echo $to_data[0]->txn_id;?>" name="to_txn_id" id="to_txn_id"/>
                        
                        <div class="form-group">
                            <label class="col-sm-1 no-padding-right" for="form-field-2">Transaction Date*</label>

                            <div class="col-sm-4">
                                <div class="input-group">
                                <input type="text" class="form-control mandatory-field" id="date-timepicker1" name="transaction_date" placeholder="Enter User Transaction Date" value="<?php   echo $newDateTime = date('d/m/Y h:i A', strtotime($from_data[0]->transaction_date)); ?>">
                                <span class="input-group-addon">
                                    <i class="fa fa-clock-o bigger-110"></i>
                                </span>

                                </div>
                                <span class="help-inline col-xs-12 col-sm-7">
                                    <span class="middle input-text-error" id="transaction_date_errorlabel"></span>
                                </span>
                            </div>

                              
                        </div>
                        

                        <fieldset>
                            <legend>
                                    <h4>Initial Entry</h4>
                            </legend>
                        <div class="form-group">
                            <label class="col-sm-1 no-padding-right" for="form-field-2">From/By</label>

                            <div class="col-sm-4">
                                <?php 
                                    echo $from_select;
                                ?>
                                <span class="help-inline col-xs-12 col-sm-7">
                                    <span class="middle input-text-error" id="from_ledger_errorlabel"></span>
                                </span>
                            </div>


                            <label class="col-sm-1 no-padding-right" for="form-field-2">Transaction Type</label>
                            <div class="col-sm-4">
                                <select data-placeholder="CR/DR" name="selection_from_type" id="selection_from" class="chosen-select form-control" style="display: none;">
                                    <option <?php if(isset($from_data) && $from_data[0]->transaction_type == "cr") { echo "selected"; }?> value="cr">CR</option>
                                    <option value="DR" <?php if(isset($from_data) &&  $from_data[0]->transaction_type == "dr") { echo "selected"; }?>>DR</option>
                                     
                                    
                                </select>
                                <span class="help-inline col-xs-12 col-sm-7">
                                    <span class="middle input-text-error" id="selection_from_errorlabel"></span>
                                </span>
                            </div>
                        </div>


                        <div class="form-group">
                             <label class="col-sm-1 no-padding-right" for="form-field-2"><b class="red"> * </b>AMOUNT</label>

                            <div class="col-sm-4">
                                 <input type="text" id="transaction_amount_from" name="transaction_amount_from" value="<?php echo $from_data[0]->transaction_amount;?>" placeholder="Enter Amount" class="col-xs-10 col-sm-9 mandatory-field"  onKeyUp="javascript:return check_isammount(event,this);" onblur="javascript:return check_amount_dup(event,this);"/>
                                <span class="help-inline col-xs-12 col-sm-7">
                                    <span class="middle input-text-error" id="transaction_amount_from_errorlabel"></span>
                                </span>
                            </div>

                             <label class="col-sm-1 no-padding-right" for="form-field-2"><b class="red"> * </b>NARRATION</label>    
                            <div class="col-sm-4">
                           
                                <textarea id="memo_desc_from" name="memo_desc_from"  placeholder="Enter Narration" class="col-xs-10 col-sm-9 mandatory-field" value="<?php echo $from_data[0]->memo_desc;?>"><?php echo $from_data[0]->memo_desc;?></textarea>
                                <span class="help-inline col-xs-12 col-sm-7">
                                    <span class="middle input-text-error" id="memo_desc_from_errorlabel"></span>
                                </span>
                            </div>
                        </div>

                        </fieldset>   


                        <?php if(isset($to_data) && !empty($to_data)) {?> 
                        <fieldset>
                            <legend>
                                    <h4>Counter Entry</h4>
                            </legend>
                        <div class="form-group">
                            <label class="col-sm-1 no-padding-right" for="form-field-2">From/By</label>

                            <div class="col-sm-4">
                                <?php 
                                    echo $to_select;
                                ?>
                                <span class="help-inline col-xs-12 col-sm-7">
                                    <span class="middle input-text-error" id="from_ledger_errorlabel"></span>
                                </span>
                            </div>


                            <label class="col-sm-1 no-padding-right" for="form-field-2">Transaction Type</label>
                            <div class="col-sm-4">
                                <select data-placeholder="CR/DR" name="selection_to_type" id="selection_to" class="chosen-select form-control" style="display: none;">
                                    <option <?php if(isset($to_data) && $to_data[0]->transaction_type == "cr") { echo "selected"; }?> value="cr">CR</option>
                                    <option value="DR" <?php if(isset($to_data) &&  $to_data[0]->transaction_type == "dr") { echo "selected"; }?>>DR</option>
                                     
                                    
                                </select>
                                <span class="help-inline col-xs-12 col-sm-7">
                                    <span class="middle input-text-error" id="selection_to_errorlabel"></span>
                                </span>
                            </div>
                        </div>


                        <div class="form-group">
                             <label class="col-sm-1 no-padding-right" for="form-field-2"><b class="red"> * </b>AMOUNT</label>

                            <div class="col-sm-4">
                                 <input type="text" id="transaction_amount_to" name="transaction_amount_to" value="<?php echo $to_data[0]->transaction_amount;?>" placeholder="Enter Amount" class="col-xs-10 col-sm-9 mandatory-field"  onKeyUp="javascript:return check_isammount(event,this);" onblur="javascript:return check_amount_dup(event,this);"/>
                                <span class="help-inline col-xs-12 col-sm-7">
                                    <span class="middle input-text-error" id="transaction_amount_to_errorlabel"></span>
                                </span>
                            </div>

                             <label class="col-sm-1 no-padding-right" for="form-field-2"><b class="red"> * </b>NARRATION</label>    
                            <div class="col-sm-4">
                           
                                <textarea id="memo_desc_to" name="memo_desc_to"  placeholder="Enter Narration" class="col-xs-10 col-sm-9 mandatory-field" value="<?php echo $to_data[0]->memo_desc;?>"><?php echo $to_data[0]->memo_desc;?></textarea>
                                <span class="help-inline col-xs-12 col-sm-7">
                                    <span class="middle input-text-error" id="memo_desc_to_errorlabel"></span>
                                </span>
                            </div>
                        </div>

                        </fieldset>  
                        <?php }?>
                        <br>
 
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

<script src="<?php echo base_url(); ?>components/datatables/media/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url(); ?>components/_mod/datatables/jquery.dataTables.bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>components/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
<script src="<?php echo base_url(); ?>components/datatables.net-buttons/js/buttons.flash.min.js"></script>
<script src="<?php echo base_url(); ?>components/datatables.net-buttons/js/buttons.html5.min.js"></script>
<script src="<?php echo base_url(); ?>components/datatables.net-buttons/js/buttons.print.min.js"></script>
<script src="<?php echo base_url(); ?>components/datatables.net-buttons/js/buttons.colVis.min.js"></script>
<script src="<?php echo base_url(); ?>components/datatables.net-select/js/dataTables.select.min.js"></script>

<script src="<?php echo base_url(); ?>js/custom.js"></script>
<script src="<?php echo base_url(); ?>js/form-validation.js"></script>


<script type="text/javascript">

    $(document).ready(function(){
         
    
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
              
            });
            
            
        });
    
        $('#spinner1').ace_spinner({value:0,min:0,max:200,step:10, btn_up_class:'btn-info' , btn_down_class:'btn-info'})
        .closest('.ace-spinner')
        .on('changed.fu.spinbox', function(){
            //console.log($('#spinner1').val())
        }); 
        $('#spinner2').ace_spinner({value:0,min:0,max:10000,step:100, touch_spinner: true, icon_up:'ace-icon fa fa-caret-up bigger-110', icon_down:'ace-icon fa fa-caret-down bigger-110'});
        $('#spinner3').ace_spinner({value:0,min:-100,max:100,step:10, on_sides: true, icon_up:'ace-icon fa fa-plus bigger-110', icon_down:'ace-icon fa fa-minus bigger-110', btn_up_class:'btn-success' , btn_down_class:'btn-danger'});
        $('#spinner4').ace_spinner({value:0,min:-100,max:100,step:10, on_sides: true, icon_up:'ace-icon fa fa-plus', icon_down:'ace-icon fa fa-minus', btn_up_class:'btn-purple' , btn_down_class:'btn-purple'});
    
        
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
         maxDate: new Date(),
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
        <script>
            $( document ).ready(function() {    
                 var from_val = <?php echo isset($from_selectd_ledger_id) ? $from_selectd_ledger_id : "0"?>;
                 var to_val = <?php echo isset($to_selected_ledger_id) ? $to_selected_ledger_id : "0"?>;
                $("#to_ledger").find("option[value=" + to_val +"]").attr('selected', true);
                $("#from_ledger").find("option[value=" + from_val +"]").attr('selected', true);

               }); 
  
        </script>    
        <script>
            //This functions checks float value and amount equal or not
            function check_amount_dup(e,obj)
            {      
                var data = $(obj).val();
                if(data == '')
                {
                    data = '0';
                }
                if(data.charAt(parseInt(data.length) - 1) == '.')
                {
                    newdata = data+'00';
                    $(obj).val(newdata);
                }
                else if( (data.indexOf('.') == -1) || parseInt(data) == 0 ) {
                    check_iszero(obj);
                    if(parseFloat(data)>0) {
                    newdata = parseFloat(data).toFixed(2);    
                    } else {
                    newdata = parseFloat('0.00').toFixed(2);
                    }
                    $(obj).val(newdata);
                }

                var id = $(obj).attr("id");
                var tempdata = $(obj).val();

               

                if(id==='transaction_amount_from') {
                        $('#transaction_amount_to').val(tempdata);
                }
                if(id==='transaction_amount_to') {
                        $('#transaction_amount_from').val(tempdata);
                }
                }

        </script>
        
        <script type="text/javascript">
    
            $( document ).ready(function() {    

            
            // To see for later validation  nilesh 10-9-16
            $('#from_ledger').change(function(){
                var accstartdate = $('#from_ledger').val();
                //getstartdate(accstartdate);      
            });

           $('#to_ledger').change(function(){
                var accstartdate = $('#to_ledger').val();
                //getstartdate(accstartdate);      
           });

            function getstartdate(id){

                    jQuery.ajax({
                     url:"<?php echo $config->system->full_base_url_fe?>/admin/transaction/getLedgerstartdate",
                     type: "POST",
                     data : {"ledger_id":id},
                     success:function(result)
                        {
                          if(fy_start_date < result) {
                              $('#transaction_date_errorlabel').html("Date not match");
                              setmindate(result, 1);
                           }
                        }
                     });
              }

            function setmindate(min_date, change) {

                var minumum_date = min_date;

                $('#transaction_date').datepicker('option', 'minDate', minumum_date);

                }
            });
 

    </script>