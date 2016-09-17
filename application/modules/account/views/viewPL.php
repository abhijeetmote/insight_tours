
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
				<li class="active">P&L</li>
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
					Profit and Loss
				</h1>
			</div><!-- /.page-header -->
            <?php
            $type =  !isset($type) ? 'monthly' : $type ;
            $jsonyears = json_encode($unit_start_date_year);
            
            //$this->partial("partials/account_reporting_filter", array("type"=>$type,"lstMonth"=>$lstMonth,"displayMonthDiv"=>$displayMonthDiv));
        ?>
			<div class="row">
				 <form action="profit_and_loss" autocomplete="on" method="POST" role="form" class="defaultform" id="frmprofitandloss" target='_self'>
    <div class="col-sm-1">
            <?php 
               /* $export_url = $config->system->full_base_url."accountsreporting/profit_and_loss/";
                $this->partial("partials/exportlinks", array("exporturl" => $export_url,'exportfuntype'=>"javascript" , 'exportfunname'=>"Download",'profit_and_Loss'=> "1"));*/
            ?>
        <?php 
             

            switch($type)
            {
                case 'yearly':
                    $displayMonthDiv = "style='display:none;'";
                    break;
                case 'monthly':
                default : 
                    $displayMonthDiv = "";
                break;
            }
            ?>
     </div>
      <div class="col-sm-1">
        <button class="btn btn-export bg-blue pull-right mr0" onClick="javascript:window.location.href='<?php echo "account/profit_and_loss"?>'"><i class="fa fa-refresh"></i> Refresh</button>
      </div>
       <div class="col-sm-1">
        <button type="submit"  onClick="javascript: document.getElementById('frmprofitandloss').submit(); "  class="btn btn-export bg-blue pull-right mr0" >
            <i class="fa fa-eye"></i><span class="bigbuttonlabel">Show </span><!-- <i class="fa fa-search"></i> --> 
        </button>
        </div>
      <div class="clearfix"></div>
       <div class="form-group">
       </div>
            <div class="form-group">
                <div class="col-sm-3">
                    <select class="chosen-select form-control" name="type" class="chossen" id="type" required>
                        <option value = "yearly" <?php if(isset($type) && $type=='yearly') echo "selected";?>>Yearly</option>
                        <option value = "monthly" <?php if(isset($type) && $type=='monthly') echo "selected";?>>Monthly</option>
                    </select>
                </div>
            <div class="col-sm-3">
                
                <select class="chosen-select form-control"  name="lstYear" id="lstYear" required>
                        <option value="">Select Year</option>
                        <?php

                                $lstYear = (isset($lstYear) && $lstYear!= '') ? $lstYear: end($unit_start_date_year);
                                foreach($unit_start_date_year as $kfyyears => $fyyears){
                                    $selected = ($lstYear == $fyyears) ? 'selected' : "";
                                    echo "<option value='".$fyyears."' ".$selected.">".$fyyears."</option>";
                                }
                        ?>
                </select>
            </div>
                
            <div id ="divlstMonth"  <?php echo $displayMonthDiv; ?> class="col-sm-3">
            
            <select class="chosen-select form-control" name="lstMonth" id="lstMonth">
                <option value="0" <?php echo $defSelected; ?>>All Months</option>
                <?php

                    $jto=12;
                    $arrlstYear  = explode("-",$lstYear);
                    $jto= ($lstYear == end($unit_start_date_year) ) ? date("n")-$fymonthstart: 12;
                    $jto = ($jto < 0) ? $jto *  -1 : $jto ; 
                    $selected = "";
                    for($j=$intfystart;$j<=($jto+$intfystart);$j++)
                    {
                        $i = ( ($j+$fymonthstart)>12)? $j-12 : $j;
                            $selected = ($lstMonth == ($i+$fymonthstart) ) ? 'selected="selected"': '';
                        echo "<option value='".($i+$fymonthstart)."' ".$selected."> ";
                            echo date("M Y", strtotime($arrlstYear[0].'-'.$fymonthstart.'-01'." +".$j." months")); 
                            
                    echo " </option>";
                ?>
                                
                <?php
                    }
                ?>
            </select>
            </div>
                    

                     
            <div class="col-sm-3">
            <?php //echo $uptoMonth;exit();?>
            <select class="chosen-select form-control" name="uptoMonth" id="uptoMonth" style = "margin-left:5px;">
            <option value="">Select No. Months</option>
            <?php
                $jto=11;
                $lastid = ($type == 'monthly')? $jto: count($unit_start_date_year); 

                $uptoMonth = (isset($uptoMonth) && $uptoMonth > 0 ) ? $uptoMonth : ''  ;
                for($j=1;$j<=$lastid;$j++)
                {
                    $selected = (($uptoMonth == $j)) ? 'selected' : "";
                    echo "<option value='".$j."' ".$selected.">".$j."</option>";
                }
            ?>
      		</select>
     
			</div>
                
           
                
        </form>
    </div>
         <div class="form-group">
        <div class="col-sm-12"> 
        <!-- Afterwards, include the div panels representing the panels of our slider -->
            
            <div class="clearfix"></div>
            <div>
     <div class="row">
            <div class="col-xs-12">
              <h3 class="header smaller lighter blue"></h3>

              <div class="clearfix">
                <div class="pull-right tableTools-container"></div>
              </div>
              <div class="table-header">
                Profit and Loss Statement
              </div>
               <div class="clearfix"></div> 
                
              <br>           
        <table  id="dynamic-table" class="table table-striped table-bordered table-hover">
            <thead>
                <th width="30%" style="width:288px;">Account Name</th>
                <?php
                    //echo "<pre>".$type;print_r($arrPreparePeriodDetails);
                    if( !empty($arrPreparePeriodDetails) && count($arrPreparePeriodDetails) > 0 ){
                        switch (strtolower($type)){
                            case 'yearly':
                                $arrdateMonth = array();
                                
                                foreach($arrPreparePeriodDetails as $kYear => $fullyear){
                                    $arrdateMonth[$kYear] = $kYear;
                                    echo "<th>".$kYear."</th>";
                                }
                            break;
                            case 'monthly':
                            default:
                                $arrdateMonth = array();
                                
                                foreach($arrPreparePeriodDetails as $k => $yearMonth){
                                    $arryearMonth = array();
                                    $arryearMonth = explode("-",$yearMonth);
                                    $arrdateMonth[$arryearMonth["1"]."-".$arryearMonth["0"]] = $arryearMonth["1"]."-".$arryearMonth["0"];
                                    echo "<th>".date("M Y",strtotime($yearMonth.'-01'))."</th>";
                                }
                            break;
                        }
                    }
                ?>
                <th class="width100">Total</th>
            </thead>
            <tbody>
                <?php
                $iteration = 0; 
                $parent_iteration = 0;
                /*echo "<pre>";
                print_r($hierarchyLedgerDetails);*/
                foreach($arrbehaviour as $operatingType => $valarrbehaviour) {
                	//print_r($hierarchyLedgerDetails[$operatingType]);
                    if(isset($hierarchyLedgerDetails[$operatingType] ) && !empty($hierarchyLedgerDetails[$operatingType])){
                        if($valarrbehaviour['operating_type'] == 'direct'){
                            $html = "";
                            $iteration = ($iteration === 0) ? $iteration+1 : $iteration;
                            echo  build_statement_view($hierarchyLedgerDetails[$operatingType], $arrdateMonth,0,$iteration,0,$html,'ledger',true);
                        }
                    }
                }
                
                echo  grossProfitHTML($arrdateMonth,$arrgrossProfitTotal);


                foreach($arrbehaviour as $operatingType => $valarrbehaviour) {
                    if(isset($hierarchyLedgerDetails[$operatingType] ) && !empty($hierarchyLedgerDetails[$operatingType])){
                        if($valarrbehaviour['operating_type'] == 'indirect'){
                            $html = "";
                            $iteration = ($iteration === 0) ? $iteration+1 : $iteration;
                           // echo  build_statement_view($hierarchyLedgerDetails[$operatingType], $arrdateMonth,0,$iteration,0,$html,'ledger',true);
                        }
                    }
                }
                echo  netProfitHTML($arrdateMonth, $arrNetProfit);
                ?>
            </tbody>
        </table>

   </div>
</div>        
    </div>
        </div>
		</div>	 
		 
			</div><!-- /.row -->
		</div><!-- /.page-content -->
	</div>
</div><!-- /.main-content -->

<!-- basic scripts -->
 

 <?php

     function build_statement_view($element, &$datewise_array, $parent_iteration=0, &$iteration=0, $level=0, &$html='', $entity_type='ledger', $show_row_wise_total = false, $ytd = false ){

        if(is_array($element) && !empty($element)) {
            //$iteration = $iteration+1;

            if( is_array($element) && !isset($element['ledger_account_id']) ) {

            foreach($element as $itr => $element_child) {
                    build_statement_view($element_child, $datewise_array, $parent_iteration, (++$iteration), ($level), $html, $entity_type, $show_row_wise_total, $ytd);
            }//end of foreach
        }
        elseif( isset($element['ledger_account_id']) ) {
        	 
            $child_to_parent_attributes = '';
            if( !empty($parent_iteration) ) {//
                $child_to_parent_attributes = ' data-tt-parent-id="'.($parent_iteration).'" class="collapsed"';
            }
            $identify_main = ($level == 0) ? ' style="font-weight:bold;"' : '';
            $rows='';
            if( is_array($datewise_array) && !empty($datewise_array) && !empty($element['total_array']) ) {
                foreach( $datewise_array as $ixd => $date ) {
                    $rows.= '<td>';
                    if( isset($element['total_array'][$date]) ) {
                        $rows.=$element['total_array'][$date];
                    }
                    else {$rows.='0.00';}
                    $rows.= '</td>';
                }
                 
            }
            elseif( is_array($datewise_array) && !empty($datewise_array) && !isset($element['total_array']) ) {
                if($ytd === false) {
                    foreach( $datewise_array as $ixd => $date ) {
                        $rows.= '<td>';
                        $rows.='0.00';
                        $rows.= '</td>';
                    }
                }
                else {
                    $rows.= '<td>';
                    $rows.='0.00';
                    $rows.= '</td>';
                }
                 
            }
            $empty_columns='';
            if($ytd === false) {
                foreach( $datewise_array as $ixd => $date ) {
                    $empty_columns.= '<td>';
                    $empty_columns.='&nbsp;';
                    $empty_columns.= '</td>';
                }
                 
            }
            else {
                $empty_columns.= '<td>&nbsp;</td>';
            }
            $row_wise_total_column = '';
            if( $show_row_wise_total == true || $ytd === true ) {
                $row_wise_total_column = '<td><b>'.( (isset($element['total_array']) && !empty($element['total_array']) ) ? array_sum($element['total_array']) : '0.00' ).'</b></td>';
                $empty_columns.= '<td>&nbsp;</td>';
                 
            }
             
            switch($element['entity_type']) {//$entity_type
                case "main":
                $html.= <<<HereDoc
<tr data-tt-id="{$iteration}" {$identify_main}>
	<td>{$element['ledger_account_name']} </td>
	{$empty_columns}
</tr>
HereDoc;
                    break;

                case "group":
                    $html.= <<<HereDoc
<tr data-tt-id="{$iteration}" {$child_to_parent_attributes} {$identify_main}>
	<td>{$element['ledger_account_name']}</td>
	{$empty_columns}
</tr>
HereDoc;
                    break;

                case "ledger":
                    $html.= <<<HereDoc
<tr data-tt-id="{$iteration}" {$child_to_parent_attributes} {$identify_main}>
	<td>{$element['ledger_account_name']} </td>
	{$rows}
	{$row_wise_total_column}
</tr>
HereDoc;
                    break;
                }//end of switch
                
                if( isset($element['children']) && !empty($element['children']) ) {
                $parent_iteration = $iteration;
                 build_statement_view($element['children'], $datewise_array, $parent_iteration, ($iteration), (++$level), $html, $entity_type, $show_row_wise_total, $ytd);

                $identify_main = ' style = "font-weight:bold;"';
                $html.= <<<HereDoc
<tr data-tt-id="{$iteration}" {$child_to_parent_attributes} {$identify_main}>
<td>Total {$element['ledger_account_name']}</td>
{$rows}
{$row_wise_total_column}
</tr>
HereDoc;
                }
            }
        }
        //echo $html;
        return $html;

    }
    /**
     * generate html for Gross Salary 
     * @method grossProfitHTML
     * @access public
     * @param array $arrdateMonth
     * @param array $gross_profit_array
     * @return string
     */
      function grossProfitHTML($arrdateMonth,$gross_profit_array)
    {
        
        //echo "<pre>";print_r($net_total_array);print_r($arrdateMonth);//exit();
        $strgrossTotalHTML = '';
        $grosstotalhtml = '';
        $totgrossamount = 0;
        $arrOutput = array();
        if(isset($arrdateMonth) && is_array($arrdateMonth) && !empty($arrdateMonth) ) {
            foreach($arrdateMonth as $key=>$val) {
                if( isset($gross_profit_array[$val]) && !empty($gross_profit_array[$val]) ) {
                    $grosstotalhtml .= '<td>'.($gross_profit_array[$val]).'</td>';
                }
                elseif( ( isset($gross_profit_array[$val]) && empty($gross_profit_array[$val]) ) || !isset($gross_profit_array[$val]) ) {
                    $grosstotalhtml .= '<td>0.00</td>';
                }
            }
            
            if(array_sum($gross_profit_array) != 0){
                $strgrossTotalHTML = '<tr style = "font-weight:bold;"><td>GROSS PROFIT</td>';
                $strgrossTotalHTML .= $grosstotalhtml;
                $strgrossTotalHTML .= '<td><b>'.array_sum($gross_profit_array).'</b></td>';
                $strgrossTotalHTML .= '</tr>';
            }
        }
        return $strgrossTotalHTML;
    }
    
    /**
     * This function generate HTML for Net Profit
     * @param array $arrdateMonth
     * @param array $net_total_array
     * @return string
     */
     function netProfitHTML($arrdateMonth,$net_total_array)
    {
        
        $net_profit = array();
        $nettotalhtml = '';
        $highlight_class = '';
        $strnetTotalHTML = '';
        if(isset($arrdateMonth) && is_array($arrdateMonth) && !empty($arrdateMonth) ) {
            foreach($arrdateMonth as $key=>$val) {
                $highlight_class_td = (array_sum($net_total_array) < 0)? ' class = "red" ': ' class = "green" ';// style="color:#359052;" class = "red"
                if( isset($net_total_array[$val]) && !empty($net_total_array[$val]) ) {
                    $nettotalhtml .= '<td '.$highlight_class_td. '><b>'.($net_total_array[$val]).'</b></td>';
                }
                elseif( ( isset($net_total_array[$val]) && empty($net_total_array[$val]) ) || !isset($net_total_array[$val]) ) {
                    $nettotalhtml .= '<td><b>0.00</b></td>';
                }
            }
                
            if(array_sum($net_total_array) != 0){
                $strnetTotalHTML .=  '<tr ><td ><b>NET PROFIT</b></td>';
                $strnetTotalHTML .=  $nettotalhtml;
                $highlight_class = (array_sum($net_total_array) < 0)? ' class = "red" ': ' class = "green" ';// style="color:#359052;" class = "red"
                 $strnetTotalHTML .= '<td '.$highlight_class.'> <b>'.(round(array_sum($net_total_array), 2)).' </b> </td>';
                $strnetTotalHTML .= '</tr>';
            }
        }
        
        return $strnetTotalHTML;
    }
    
    
    /**
     * This function generate HTML for assets and laibility diffrance
     * @param array $arrPreparePeriodDetails
     * @param array $diff_array
     * @param int $flag 
     * @return string
     */
     function diffrance_cal($arrPreparePeriodDetails,$diff_array,$flag) {
        
        $diff_data .= '<tr><td><i>Difference in opening balance</i></td>';
            
            if(!empty($arrPreparePeriodDetails) && is_array($arrPreparePeriodDetails)) {
                
                foreach($arrPreparePeriodDetails as $key=>$val) { 
                    if($flag == 1) {
                        $arr = explode("-", $val);
                        $arr1 = explode("to", $val);
                        $arr2 = explode("-", $arr1[1]);
                        $val = $arr[0]."-".$arr2[1];
                        }else {
                        $arr = explode("-", $val);
                        $val = $arr[1]."-".$arr[0];
                        }

                        if(isset($diff_array[$val]))
                        {
                                $diff_data .= '<td>'.round($diff_array[$val],2).'</td>';
                        }else{
                                $diff_data .= '<td>0.00</td>';
                        }

                        }

                    if($flag == 1) {
                        $diff_data .= '</tr>';
                    } else {
                        $diff_data .= '<td>'.round(array_sum($diff_array),2).'</td></tr>';
                    }    

            }
            
            return $diff_data;
    
        }



  ?> 

<style>
#lstMonth {
    width: 95% !important;
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
<link rel="stylesheet" href="<?php echo base_url(); ?>css/ledgerlist.css" />
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
 <!-- slidertabs script -->
<script src="<?php echo base_url(); ?>js/src/jquery.treetable-ajax-persist.js"></script> 
<script src="<?php echo base_url(); ?>js/src/jquery.treetable-3.0.0.js"></script>
<script src="<?php echo base_url(); ?>js/src/persist-min.js"></script> 
 
<script>
$(document).ready(function(){
	$("table").agikiTreeTable({persist: true, persistStoreName: "files"});
	
    Month_ajaxCall();
 $("#type").change(function(){
        var lstYear = $("#lstYear").val();
        var Type = $("#type").val();
        //alert(Type);
        if(Type == 'monthly'){
                $("#divlstMonth").show();
                Month_ajaxCall();
                changeUptoValuesYears(Type);
        }else{
            $("#divlstMonth").hide();
            changeUptoValuesYears(Type);
        }
    });

  $("#lstYear").change(function(){
        var Type = $("#type").val();
        //alert(Type);
        if(Type == 'monthly' ){
            Month_ajaxCall();
            changeUptoValuesYears(Type);
        }else{
            changeUptoValuesYears(Type);
        }
    });


  function changeUptoValuesYears(type)
    {
        var arrUpto = '<?php echo $jsonyears; ?>';
        var fyyears = jQuery.parseJSON(arrUpto);
        var upto;
        var promptOption = '';
        if(type == 'monthly' ){
            upto = 11;
            promptOption = 'Months';
        }else{
           upto = fyyears.length;
           promptOption = 'Years';
        }
        var selected_uptoMonth = "<?php echo $_POST['uptoMonth']; ?>";
        var selectOption = '<select name="uptoMonth" id="uptoMonth"><option value="0" <?php echo ( !$_POST['uptoMonth'] ) ? ' selected="selected"' : ''; ?>>Select No. '+promptOption+'</option>';
        for(var i = 1 ; i<= upto; i++) {
            var select_option = (selected_uptoMonth == i) ? ' selected="selected"' : '';
            selectOption += '<option value="'+i+'" '+select_option+'>'+i+"</option>";
        }
        selectOption += '</select>';
        $("#uptoMonth").html(selectOption);
    }
  function Month_ajaxCall(){
        //alert("abc");
        var id = 'frmprofitandloss';
        var lstYear = $("#lstYear").val();
        var url = 'account/calulateMonthsAction';
        var postData  = [];
        postData = {"lstYear":lstYear};
        var method = 'post';
        var sucessCallBack = function (response) { 
            var selectOption = change_Month(response);
            //console.log(selectOption);

            $("#divlstMonth").html(selectOption);
        };
        var failCallBack = null;
        var res = commanajaxCall(id, url, postData, method, sucessCallBack, failCallBack);
        
  }
  function change_Month(response){
      var res = jQuery.parseJSON(response);
     var selectOption = '<select class="chosen-select form-control" name="lstMonth" id="lstMonth"><option value="0" <?php echo ( !$_Post['lstMonth'] ) ? ' selected="selected"' : ''; ?>>All Months</option>';
        var arrMonth = res.Months;
        var selected_month = "<?php echo $_POST['lstMonth']; ?>";
        for(var i = 0; i< arrMonth.length; i++){
            var MonthKey = (jQuery.type(arrMonth[i]['Monthkey']) == 'undefined' ) ? '': arrMonth[i]['Monthkey'] ;
            var select_option = (selected_month == MonthKey) ? ' selected="selected"' : '';
            if(MonthKey != ''){
                selectOption += '<option value="'+MonthKey+'" '+select_option+'>'+arrMonth[i]['Monthvalue']+"</option>";
            }
        }
        selectOption += '</select>';
        //console.log(selectOption);
        return selectOption;
    }
  
    });
</script>
<!-- inline scripts related to this page -->
 

<!-- inline scripts related to this page -->
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
		 
	
	});
</script>
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
            "extend": "excel",
            "text": "<i class='fa fa-file-excel-o bigger-110 green'></i> <span class='hidden'>Export to Excel</span>",
            "className": "btn btn-white btn-primary btn-bold"
            },
            {
            "extend": "pdf",
            "text": "<i class='fa fa-file-pdf-o bigger-110 red'></i> <span class='hidden'>Export to PDF</span>",
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