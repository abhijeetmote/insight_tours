

<div class="main-content">
    <div class="main-content-inner">
        <div class="breadcrumbs ace-save-state" id="breadcrumbs">
            <ul class="breadcrumb">
                <li>
                    <i class="ace-icon fa fa-home home-icon"></i>
                    <a href="#">Home</a>
                </li>

                <li>
                    <a href="#">Add Group</a>
                </li>
                <li class="active">Add Group</li>
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
                    Add Group
                </h1>
            </div><!-- /.page-header -->

            <div class="row">
                <div class="col-xs-12">
                    <div class="alert-box"></div>
                    <!-- PAGE CONTENT BEGINS -->
                    <form class="form-horizontal" role="form"  id="<?php if(isset($entity_name)): echo "editgroup"; else: echo "addgroup"; endif; ?>">                       
                         

                     
                    <div class="form-group">

                            <input type="hidden" id="behaviour" name="behaviour" value="">
                            <input type="hidden" id="nature" name="nature" value="">
                            <input type="hidden" id="context" name="context" value="">
                            <input type="hidden" id="led_id" name="led_id" value="<?php if(isset($entity_type)) : echo $led_id; endif;?>">
                            
                            <label class="col-sm-2 no-padding-right" for="form-field-2"><b class="red"> * </b>Entity Type</label>

                            <div class="col-sm-3">
                                <select data-placeholder="Ledger Type" name="ledger_type" id="ledger_type" class="chosen-select form-control" style="display: none;">
                                    <option value="group" <?php if(isset($entity_type) && $entity_type == 'group')  : echo "selected"; endif;?>>group</option>
                                    <option value="ledger" <?php if(isset($entity_type) && $entity_type == 'ledger')  : echo "selected"; endif;?>>ledger</option>
                                    
                                </select>
                                <span class="help-inline col-xs-12 col-sm-12">
                                    <span class="middle input-text-error" id="ledger_type_errorlabel"></span>
                                </span>
                            </div>

                             <label class="col-sm-2 no-padding-right" for="form-field-2"><b class="red"> * </b>Entity Name</label>

                            <div class="col-sm-3">
                                <input type="text" id="entity_name" name="entity_name" placeholder="Enter Entity Name" class="col-xs-10 col-sm-12 mandatory-field" value="<?php if(isset($entity_name)): echo $entity_name; endif; ?>" onKeyUp="javascript:return check_isalphanumeric(event,this);" />
                                <span class="help-inline col-xs-12 col-sm-12">
                                    <span class="middle input-text-error" id="entity_name_errorlabel"></span>
                                </span>
                            </div>
                             
       
                    </div>    



                    <div class="form-group">


                           
                            <label class="col-sm-2 no-padding-right" for="form-field-2"><b class="red"> * </b>Parent</label>

                            <div class="col-sm-3">
                                <?php 
                                    echo $lstParentAccount;
                                ?>
                                <span class="help-inline col-xs-12 col-sm-12">
                                    <span class="middle input-text-error" id="lstParentAccount_errorlabel"></span>
                                </span>
                            </div>

                            <label class="col-sm-2 no-padding-right" for="form-field-2"><b class="red"> * </b>Nature of Account </label>
                              <div class="col-sm-3">
                                  <input type="text" id="textNatureofaccount" name="textNatureofaccount" disabled value="<?php if(isset($ledger_type)): echo $ledger_type; endif; ?>" class="col-xs-10 col-sm-12 mandatory-field" placeholder="You should select a parent"/>
                                <span class="help-inline col-xs-12 col-sm-12">
                                    <span class="middle input-text-error" id="textNatureofaccount_errorlabel"></span>
                                </span>
                            </div>
       
                    </div>

                    <div class="form-group">


                           
                             

                            <label class="col-sm-2 no-padding-right" for="form-field-2"><b class="red"> * </b>Income/Expense Type</label>
                              <div class="col-sm-3">
                                 <select data-placeholder="Operating Type" name="op_type" id="op_type" class="chosen-select form-control" style="display: none;">
                                    <option value="direct" <?php if(isset($op_type) && $op_type == 'direct')  : echo "selected"; endif;?>>Direct</option>
                                    <option value="indirect" <?php if(isset($op_type) && $op_type == 'indirect')  : echo "selected"; endif;?>>Indirect</option>
                                    
                                </select>
                                <span class="help-inline col-xs-12 col-sm-7">
                                    <span class="middle input-text-error" id="op_type_errorlabel"></span>
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
     
    #lstParentAccount{
        height:15%;
        width: 100% !important;
    }
    option {
    padding: 3px 2px 1px 15px !important;
    color: black !important;
    font-size: 15px !important;
    font-weight: bold !important;
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
        <script>
            $( document ).ready(function() {    
                 var parent_id = <?php echo isset($parent_id) ? $parent_id : "0"?>;
                $("#lstParentAccount").find("option[value=" + parent_id +"]").attr('selected', true);

               }); 
  
        </script> 
<script type="text/javascript">
    
    $( document ).ready(function() {
        $("#lstParentAccount").change(function() {

            var behaviour =  $('option:selected', this).attr('behaviour');
            var nature =  $('option:selected', this).attr('nature');
            var context  = $("#lstParentAccount option:selected").text();


            //alert(behaviour);
           // alert(nature);
            $("#behaviour").val(behaviour);
            $("#textNatureofaccount").val(nature);
            $("#nature").val(nature);
            $("#context").val(context);
            


         });     
      });   
</script>        
<script type="text/javascript">
jQuery(function($) {
        
    
    
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