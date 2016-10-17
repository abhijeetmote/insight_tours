<div class="main-content">
  <div class="main-content-inner">
    <div class="breadcrumbs ace-save-state" id="breadcrumbs">
      <ul class="breadcrumb">
        <li>
          <i class="ace-icon fa fa-home home-icon"></i>
          <a href="#">Home</a>
        </li>

        <li>
          <a href="#">Transaction</a>
        </li>
        <li class="active">Transaction Lists</li>
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
          Transaction List
        </h1>
      </div><!-- /.page-header -->

      <div class="row">
        <div class="col-xs-12">
          <div class="alert-box"></div>
          <!-- PAGE CONTENT BEGINS -->
          <div class="row">
            <div class="col-xs-12">
              <h3 class="header smaller lighter blue"></h3>

              <div class="clearfix">
                <div class="pull-right tableTools-container"></div>
              </div>
              <div class="table-header">
                Results for "Latest Transaction First"
              </div>
               <div class="clearfix"></div> 
                <?php if (isset($_SESSION['succ_remove'])) {?>
                <div data-alert="" class="alert-box success">              
                <?php echo $_SESSION["succ_remove"]; $_SESSION["succ_remove"] = "";?>        
                
                    <a href="#" class="successclose">                  
                      <i class="fa fa-times"></i>
                    </a>
                </div>
               <div class="clearfix"></div>
              <br>
                <?php }?>
              
                <?php if (isset($_SESSION['succ_msg_ledger'])){
                      ?>
                      <div data-alert="" class="alert-box success">
                          <a href="#" class="successclose">                  
                            <i class="fa fa-times"></i>
                          </a>
                              <?php  echo $_SESSION['succ_msg_ledger']; 
                              $_SESSION['succ_msg_ledger'] = "";?>
                      </div>
                      <?php } ?> 

              <?php if (isset($_SESSION['err_msg'])) {?>
              <div data-alert="" class="alert-box alert">              
              <?php echo $_SESSION['err_msg']; $_SESSION['err_msg']="";?>        
                    <a href="#" class="alertclose">                  
                      <i class="fa fa-times"></i>
                    </a>
              </div>
              <div class="clearfix"></div>
              <br>
              <?php }?>
              <!-- div.table-responsive -->

              <!-- div.dataTables_borderWrap -->
              <form class="form" id="transactionList"></form>

              <?php
                $previous_transaction_total = array('transaction_type' => $ledger['nature_of_account'], 'debit_total' => 0.00, 'credit_total' => 0.00);
                if( isset($translist['prev_transaction_total']) && !empty($translist['prev_transaction_total']) ) {
                    foreach($translist['prev_transaction_total'] as $pttr => $prev_transaction_total) {
                        $previous_transaction_total['credit_total'] = $previous_transaction_total['credit_total'] + $prev_transaction_total['credit_amount'];
                        $previous_transaction_total['debit_total'] = $previous_transaction_total['debit_total'] + $prev_transaction_total['debit_amount'];
                        //decide nature of the transaction total
                        if( $previous_transaction_total['credit_total'] > $previous_transaction_total['debit_total'] ) {
                            $previous_transaction_total['transaction_type'] = 'cr';
                        }
                        elseif( $previous_transaction_total['credit_total'] < $previous_transaction_total['debit_total'] ) {
                            $previous_transaction_total['transaction_type'] = 'dr';
                        }
                        else {
                            $previous_transaction_total['transaction_type'] = $ledger['nature_of_account'];
                        }
                    }//end of foreach
                }//print_r($previous_transaction_total);

                $transaction_total_amount = array('transaction_type' => $ledger['nature_of_account'], 'debit_total' => 0.00, 'credit_total' => 0.00);
                if(isset($translist['transaction_array']) && !empty($translist['transaction_array'])) {
                    
                    foreach($translist['transaction_array'] as $tar => $transaction_total) {
                        if($transaction_total['transaction_type'] == 'cr') {
                            $transaction_total_amount['credit_total'] = $transaction_total_amount['credit_total'] + $transaction_total['transaction_amount'];
                        }
                        elseif($transaction_total['transaction_type'] == 'dr') {
                            $transaction_total_amount['debit_total'] = $transaction_total_amount['debit_total'] + $transaction_total['transaction_amount'];
                        }

                        //decide nature of the transaction total
                        if( $transaction_total_amount['credit_total'] > $transaction_total_amount['debit_total'] ) {
                            $transaction_total_amount['transaction_type'] = 'cr';
                        }
                        elseif( $transaction_total_amount['credit_total'] < $transaction_total_amount['debit_total'] ) {
                            $transaction_total_amount['transaction_type'] = 'dr';
                        }
                        else {
                            $transaction_total_amount['transaction_type'] = $ledger['nature_of_account'];
                        }
                         
                    }

                }//print_r($transaction_total_amount);

                $transaction_total_array = array();
                $transaction_total_array['credit_total'] = $transaction_total_amount['credit_total'] + $previous_transaction_total['credit_total'];
                $transaction_total_array['debit_total'] = $transaction_total_amount['debit_total'] + $previous_transaction_total['debit_total'];
                ?>
              <div>
                <table id="dynamic-table" class="table table-striped table-bordered table-hover">
                  <thead>
                    <tr>
                       
                      <th>Date</th>
                        <th>Ledger Account</th>
                        <th>Narration</th>
                        <th>Debit</th>
                        <th>Credit</th>
                        <th>Balance</th>
                        <th>Action</th>

                    </tr>
                  </thead>

                  <tbody>
                         <?php
                    if( isset($page) && !empty($page) ) {
                      if( isset($ledger) && !empty($ledger) ){?> 
                        <tr data-depth="0" class="collapse bgrow">
                          <td  class="subtHeader noborder"> <span class="toggle collapse"><?php echo $ledger['ledger_account_name']; ?></span></td>    
                             <td class="noborder">&nbsp;</td>
                          <td class="noborder">&nbsp;</td>
                          <td class="noborder">&nbsp;</td>
                          <td class="noborder">&nbsp;</td>
                          <td><b><?php
                            $overall_balance=0.00;
                            $overall_nature = $ledger['nature_of_account'];
                            if(!empty($translist['transaction_total'])) {
                                if( $translist['transaction_total'][0]['credit_amount'] > $translist['transaction_total'][0]['debit_amount'] ) {
                                    $overall_nature = 'cr';
                                    $overall_balance = $translist['transaction_total'][0]['credit_amount'] - $translist['transaction_total'][0]['debit_amount'];
                                }
                                elseif( $translist['transaction_total'][0]['credit_amount'] < $translist['transaction_total'][0]['debit_amount'] ) {
                                    $overall_nature = 'dr';
                                    $overall_balance = $translist['transaction_total'][0]['debit_amount'] - $translist['transaction_total'][0]['credit_amount'];
                                }
                            }
                            $overall_balance = ($overall_nature != $ledger['nature_of_account']) ? (-1) * $overall_balance : $overall_balance;
                            echo number_format($overall_balance, 2);
                            ?></b></td>
                          <td class="noborder">&nbsp;</td>
                        </tr> 
                      <?php 
                        }
                         
                        $amount = 0;
                        //echo "<pre>";print_r($page);exit;
                        foreach ($page as $k => $translist ) {
        //print_r($translist);
                      ?>
                            <tr  >
                                <td><?php echo $translist['transaction_date'];?></td>
                                <td><?php echo $ledger_names[$k]; ?></td>
                                <td><?php echo $translist['memo_desc'];//print_r($transaction_total_array);  ?></td>
                                <td>
                                   <?php 
                                       if ($translist['transaction_type'] == "dr") {
                                          echo number_format($translist['transaction_amount'], 2);  
                                          //$amount = $amount -  $translist['transaction_amount']; 
                                       }  
                                      
                                   ?>
                                </td>
                                <td>
                                <?php 
                                
                                    if ($translist['transaction_type'] == "cr") {
                                       echo number_format($translist['transaction_amount'], 2);
                                       //$amount = $amount + $translist['transaction_amount']; 
                                    }

                                 ?>
                                </td>
                                <td><?php
                                $transaction_total_nature = $ledger['transaction_type'];
                                if($transaction_total_array['credit_total'] > $transaction_total_array['debit_total']) {
                                    $amount = $transaction_total_array['credit_total'] - $transaction_total_array['debit_total'];
                                    $transaction_total_nature = 'cr';
                                }
                                elseif($transaction_total_array['credit_total'] < $transaction_total_array['debit_total']) {
                                    $amount = $transaction_total_array['debit_total'] - $transaction_total_array['credit_total'];
                                    $transaction_total_nature = 'dr';
                                }
                                else {
                                    $amount = 0.00;
                                }
                                if($ledger['nature_of_account'] != $transaction_total_nature) {
                                    $amount = (-1) * $amount;
                                }
                                if ($translist['transaction_type'] == "cr") {
                                    $transaction_total_array['credit_total'] = $transaction_total_array['credit_total'] - $translist['transaction_amount'];
                                }
                                elseif ($translist['transaction_type'] == "dr") {
                                    $transaction_total_array['debit_total'] = $transaction_total_array['debit_total'] - $translist['transaction_amount'];
                                }
                                echo number_format($amount,2);
                                ?></td>
                                <td>
                                  <div class="hidden-sm hidden-xs action-buttons">
                                <?php   if( ($translist['is_opening_balance']==1 || $translist['is_opening_balance']==0)) {  ?>
                                <a class="green" href="<?php echo base_url() . "account/transactionupdate/" . $translist['txn_id']; ?>"   title="Edit"><i class="ace-icon fa fa-pencil bigger-130"></i></a>|
                                <a class="red delete" href="<?php echo base_url() . "account/delete/" . $translist['txn_id']; ?>" title="Delete" id='<?php echo $translist["txn_id"];?>' ><i class="ace-icon fa fa-trash-o bigger-130"></i></a>
                                <?php } ?>
                              </div>
                                </td>
                             </tr>  
                      <?php }  ?>
                             <?php  if(isset($previous_transaction_total['debit_total']) && isset($previous_transaction_total['credit_total'])) {  ?>
                             <tr class="">
                                 
                                  <td>
                                      
                                      Brought forward
                                  
                                  </td>
                                    
                                  <td></td>
                                  <td></td>
                                    <td ><b>
                                    <?php
                                        if($previous_transaction_total['debit_total'] > $previous_transaction_total['credit_total']) {
                                        echo number_format(($previous_transaction_total['debit_total'] - $previous_transaction_total['credit_total']),2);
                                        }
                                    ?>
                                  </b></td>
                                  <td ><b>
                                  <?php
                                  if($previous_transaction_total['credit_total'] > $previous_transaction_total['debit_total']) {
                                    echo number_format(($previous_transaction_total['credit_total'] - $previous_transaction_total['debit_total']),2);
                                  }
                                  ?></b></td>
                                  <td></td>
                                  <td></td>
                                </tr>
                            <?php }?>    
                         
                            <?php } else { ?>
                                   
                      <?php } ?>
                  </tbody>
                </table>


                  <?php
         
         //$url = $ledger_id."/";
                $url = base_url()."account/listTransaction/".$ledger_id."/";
         $end = $total_records - $no_of_records."/";
         $prev = $offset - $no_of_records;
         $next = $offset + $no_of_records;
         //echo "test".$prev."/".$no_of_records;
         ?>       
        <div class="pull-right">
            <ul class="pagination custom-pagination clearfix">
                    <?php if($prev >= 0) {?>
                    <li class="arrow unavailable">
                            <a href="<?php echo $url."0/".$no_of_records;?>"><i class="fa fa-angle-double-left"></i></a>
                    </li>
                    <li>
                            <a href="<?php echo $url.$prev."/".$no_of_records;?>"><i class="fa fa-angle-left"></i></a>
                    </li>
                    <?php }
                                    $start = 0;
                                    for ($i=1; $i<=$total_pages; $i++) {
                                    $start = $start + 0;
                                    $demo = $demo + $length;
                                    if($offset == $start) {
                                    ?>
                                <li class="current">
                                    <a href="<?php echo $url.$start."/".$no_of_records;?>" > <?php echo $i;?> </a>
                                </li>
                                    <?php } else { ?>
                                <li class="">
                                    <a href="<?php echo $url.$start."/".$no_of_records;?>" > <?php echo $i;?> </a>
                                </li>        
                                    <?php } $start = $start + $no_of_records; }
                                    
                    if($next < $total_records) {
                    ?>    
                    <li>
                            <a href="<?php echo $url.$next."/".$no_of_records;?>"><i class="fa fa-angle-right"></i></a>
                    </li>             
                    <li class="arrow">
                        <a href="<?php echo  $url.$end.$total_records;?>"><i class="fa fa-angle-double-right"></i></a>
                    </li> <?php }?>
            </ul>
        </div>     

              </div>
            </div>
          </div>
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

<!-- inline scripts related to this page -->
<script type="text/javascript">
      jQuery(function($) {
        //initiate dataTables plugin
        var myTable = 
        $('#dynamic-table')
        //.wrap("<div class='dataTables_borderWrap' />")   //if you are applying horizontal scrolling (sScrollX)
        .DataTable( {
         "bSortable": false ,
          "bPaginate": false,
          "bSort": false,
       
          } );
      
        
        
        $.fn.dataTable.Buttons.swfPath = "<?php echo base_url(); ?>components/datatables.net-buttons-swf/index.html"; //in Ace demo ./components will be replaced by correct assets path
        $.fn.dataTable.Buttons.defaults.dom.container.className = 'dt-buttons btn-overlap btn-group btn-overlap';
        
        new $.fn.dataTable.Buttons( myTable, {
          buttons: [
            {
            "extend": "colvis",
            "text": "<i class='fa fa-search bigger-110 blue'></i> <span class='hidden'>Show/hide columns</span>",
            "className": "btn btn-white btn-primary btn-bold",
            columns: ':not(:first):not(:last)'
            },
            {
            "extend": "copy",
            "text": "<i class='fa fa-copy bigger-110 pink'></i> <span class='hidden'>Copy to clipboard</span>",
            "className": "btn btn-white btn-primary btn-bold"
            },
            {
            "extend": "csv",
            "text": "<i class='fa fa-database bigger-110 orange'></i> <span class='hidden'>Export to CSV</span>",
            "className": "btn btn-white btn-primary btn-bold"
            },
            {
            "extend": "print",
            "text": "<i class='fa fa-print bigger-110 grey'></i> <span class='hidden'>Print</span>",
            "className": "btn btn-white btn-primary btn-bold",
            autoPrint: false,
            message: 'This print was produced using the Print button for DataTables'
            }     
          ]
        } );
        myTable.buttons().container().appendTo( $('.tableTools-container') );
        
        //style the message box
        var defaultCopyAction = myTable.button(1).action();
        myTable.button(1).action(function (e, dt, button, config) {
          defaultCopyAction(e, dt, button, config);
          $('.dt-button-info').addClass('gritter-item-wrapper gritter-info gritter-center white');
        });
        
        
        var defaultColvisAction = myTable.button(0).action();
        myTable.button(0).action(function (e, dt, button, config) {
          
          defaultColvisAction(e, dt, button, config);
          
          
          if($('.dt-button-collection > .dropdown-menu').length == 0) {
            $('.dt-button-collection')
            .wrapInner('<ul class="dropdown-menu dropdown-light dropdown-caret dropdown-caret" />')
            .find('a').attr('href', '#').wrap("<li />")
          }
          $('.dt-button-collection').appendTo('.tableTools-container .dt-buttons')
        });
      
        ////
      
        setTimeout(function() {
          $($('.tableTools-container')).find('a.dt-button').each(function() {
            var div = $(this).find(' > div').first();
            if(div.length == 1) div.tooltip({container: 'body', title: div.parent().text()});
            else $(this).tooltip({container: 'body', title: $(this).text()});
          });
        }, 500);
        
        
        
        
        
        myTable.on( 'select', function ( e, dt, type, index ) {
          if ( type === 'row' ) {
            $( myTable.row( index ).node() ).find('input:checkbox').prop('checked', true);
          }
        } );
        myTable.on( 'deselect', function ( e, dt, type, index ) {
          if ( type === 'row' ) {
            $( myTable.row( index ).node() ).find('input:checkbox').prop('checked', false);
          }
        } );
      
      
      
      
        /////////////////////////////////
        //table checkboxes
        $('th input[type=checkbox], td input[type=checkbox]').prop('checked', false);
        
        //select/deselect all rows according to table header checkbox
        $('#dynamic-table > thead > tr > th input[type=checkbox], #dynamic-table_wrapper input[type=checkbox]').eq(0).on('click', function(){
          var th_checked = this.checked;//checkbox inside "TH" table header
          
          $('#dynamic-table').find('tbody > tr').each(function(){
            var row = this;
            if(th_checked) myTable.row(row).select();
            else  myTable.row(row).deselect();
          });
        });
        
        //select/deselect a row when the checkbox is checked/unchecked
        $('#dynamic-table').on('click', 'td input[type=checkbox]' , function(){
          var row = $(this).closest('tr').get(0);
          if(this.checked) myTable.row(row).deselect();
          else myTable.row(row).select();
        });
      
      
      
        $(document).on('click', '#dynamic-table .dropdown-toggle', function(e) {
          e.stopImmediatePropagation();
          e.stopPropagation();
          e.preventDefault();
        });
        
        
        
        //And for the first simple table, which doesn't have TableTools or dataTables
        //select/deselect all rows according to table header checkbox
        var active_class = 'active';
        $('#simple-table > thead > tr > th input[type=checkbox]').eq(0).on('click', function(){
          var th_checked = this.checked;//checkbox inside "TH" table header
          
          $(this).closest('table').find('tbody > tr').each(function(){
            var row = this;
            if(th_checked) $(row).addClass(active_class).find('input[type=checkbox]').eq(0).prop('checked', true);
            else $(row).removeClass(active_class).find('input[type=checkbox]').eq(0).prop('checked', false);
          });
        });
        
        //select/deselect a row when the checkbox is checked/unchecked
        $('#simple-table').on('click', 'td input[type=checkbox]' , function(){
          var $row = $(this).closest('tr');
          if($row.is('.detail-row ')) return;
          if(this.checked) $row.addClass(active_class);
          else $row.removeClass(active_class);
        });
      
        
      
        /********************************/
        //add tooltip for small view action buttons in dropdown menu
        $('[data-rel="tooltip"]').tooltip({placement: tooltip_placement});
        
        //tooltip placement on right or left
        function tooltip_placement(context, source) {
          var $source = $(source);
          var $parent = $source.closest('table')
          var off1 = $parent.offset();
          var w1 = $parent.width();
      
          var off2 = $source.offset();
          //var w2 = $source.width();
      
          if( parseInt(off2.left) < parseInt(off1.left) + parseInt(w1 / 2) ) return 'right';
          return 'left';
        }
        
        
        
        
        /***************/
        $('.show-details-btn').on('click', function(e) {
          e.preventDefault();
          $(this).closest('tr').next().toggleClass('open');
          $(this).find(ace.vars['.icon']).toggleClass('fa-angle-double-down').toggleClass('fa-angle-double-up');
        });
        /***************/
        
        
        
        
        
        /**
        //add horizontal scrollbars to a simple table
        $('#simple-table').css({'width':'2000px', 'max-width': 'none'}).wrap('<div style="width: 1000px;" />').parent().ace_scroll(
          {
          horizontal: true,
          styleClass: 'scroll-top scroll-dark scroll-visible',//show the scrollbars on top(default is bottom)
          size: 2000,
          mouseWheelLock: true
          }
        ).css('padding-top', '12px');
        */
      
      
      })
    </script>