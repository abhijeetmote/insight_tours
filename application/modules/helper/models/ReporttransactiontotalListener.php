<?php 



if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ReporttransactiontotalListener extends CI_Model{

    /**
     * function set default values
     * @method __construct
     * @access public 
     */
    
    public function __construct()
    {
        
         parent::__construct();
        
    }
    /**
     * this function returns fy start details 
     * @method get_unit_start_date
     * @access public
     * @param type $event
     * @param type $component
     * @param type $data
     * @return array;
     * 
     */
    public function get_unit_start_date()
    {

        $returnarray = array();


        $strstartaccount = "SELECT * from account_start_master order by account_start_master_id desc limit 0,1";
        $result = $this->db->query($strstartaccount);
        $returnarray['arraccountStartMaster'] = $result->result_array();                    
        


        $strfinyear = "SELECT * from account_financial_year_master order by account_closing_id desc";
        $result = $this->db->query($strfinyear);
        $returnarray['arrAccountFinancialMaster'] =  $result->result_array();                    
         
        

        /*$objaccountStartMaster = AccountStartMaster::findfirst(array('conditions'=>array('soc_id = '.$data['soc_id'])));
        $arraccountStartMaster = $objaccountStartMaster->toArray();
        $returnarray['arraccountStartMaster'] = $arraccountStartMaster;
        
        $objAccountFinancialMaster = AccountFinancialMaster::find(array('conditions'=>array('soc_id = '.$data['soc_id'])));
        $arrAccountFinancialMaster = $objAccountFinancialMaster->toArray();
        $returnarray['arrAccountFinancialMaster'] = $arrAccountFinancialMaster;*/
        
        return $returnarray;
    }
    
    public function getLedgers( array $data=array())
    {
        $select = " * ";
        $ledger_master = 'ledger_master';
        $order_id = 'parent_id';
        $order = "asc";

        if(!isset($data['flaghierarchy'])) { $data['flaghierarchy'] = 0; }
        $objledger = null;
        switch (strtolower($data['operatingtype']))
        {
            case 'directincome':

                    $where =  array('operating_type' => 'direct' , 'behaviour' => 'income', 'status' => 1);
                    $this->db->select($select);
                    $this->db->from($ledger_master);
                    $this->db->where($where);
                    $this->db->order_by($order_id, $order);
                    $query = $this->db->get();
                    $objledger = $query->result_array();
                    //$objledger = GrpLedgTree::find(array("conditions" => " operating_type='direct' and behaviour='income' and status=1","order" => "parent_id ASC"));
                break;
            case 'indirectincome':

                    $where =  array('operating_type' => 'indirect' , 'behaviour' => 'income', 'status' => 1);
                    $this->db->select($select);
                    $this->db->from($ledger_master);
                    $this->db->where($where);
                    $this->db->order_by($order_id, $order);
                    $query = $this->db->get();
                    $objledger = $query->result_array();
                    //$objledger = GrpLedgTree::find(array("conditions" => " operating_type='indirect' and behaviour='income' and status=1","order" => "parent_id ASC"));
                break;
            case 'directexpense':
                    
                    $where =  array('operating_type' => 'direct' , 'behaviour' => 'expense', 'status' => 1);
                    $this->db->select($select);
                    $this->db->from($ledger_master);
                    $this->db->where($where);
                    $this->db->order_by($order_id, $order);
                    $query = $this->db->get();
                    $objledger = $query->result_array();

                    //$objledger = GrpLedgTree::find(array("conditions" => "  operating_type='direct' and behaviour='expense' and status=1","order" => "parent_id ASC"));
                break;
            case 'indirectexpense':

                     $where =  array('operating_type' => 'indirect' , 'behaviour' => 'expense', 'status' => 1);
                    $this->db->select($select);
                    $this->db->from($ledger_master);
                    $this->db->where($where);
                    $this->db->order_by($order_id, $order);
                    $query = $this->db->get();
                    $objledger = $query->result_array();
                    //$objledger = GrpLedgTree::find(array("conditions" => "  operating_type='indirect' and behaviour='expense' and status=1","order" => "parent_id ASC"));
                break;
            case 'asset':

                    $where =  array('behaviour' => 'asset', 'status' => 1);
                    $this->db->select($select);
                    $this->db->from($ledger_master);
                    $this->db->where($where);
                    $this->db->order_by($order_id, $order);
                    $query = $this->db->get();
                    $objledger = $query->result_array();
                    //$objledger = GrpLedgTree::find(array("conditions" => " behaviour='asset' and status=1","order" => "parent_id ASC"));
                break;
            case 'liability':

                    $where =  array('behaviour' => 'liability', 'status' => 1);
                    $this->db->select($select);
                    $this->db->from($ledger_master);
                    $this->db->where($where);
                    $this->db->order_by($order_id, $order);
                    $query = $this->db->get();
                    $objledger = $query->result_array();
                    //$objledger = GrpLedgTree::find(array("conditions" => "  behaviour='liability' and status=1","order" => "parent_id ASC"));
                break;
            default:

                     $where =  array('status' => 1);
                    $this->db->select($select);
                    $this->db->from($ledger_master);
                    $this->db->where($where);
                    $query = $this->db->get();
                    $objledger = $query->result_array();
                    //$objledger = GrpLedgTree::find(array("conditions" => "  status=1"));
                break;
        }
        $arrledger = $objledger;
        //print_r($objledger);
        $finalarr['ledgerIds'] =  $this->getLedgerIds($arrledger);
        $finalarr['ledgers'] =  $arrledger;
        if($data['flaghierarchy'] == 1){
            //echo "<pre>";print_r($arrledger);exit();
            foreach($arrledger as $k => $ledgerIds){
                $arrParentID[] = $ledgerIds['parent_id'];
            }
            if(count($arrParentID) > 1){ $arrParentId = array_unique($arrParentID); } else{$arrParentId = $arrParentID; }
            
            //$parentID= implode(",",$arrParentId);
            $arrIDsSettled = array();
            $finalarr['ledgerhierarchy'] =  $this->buildTree($arrledger,$arrIDsSettled,$arrParentId);
            unset($arrIDsSettled);
            //echo "<pre>";print_r($finalarr['ledgerhierarchy']);
            //exit();
        }#$arrLedgerHierarchy[]
        //echo "<pre>";print_r($finalarr['ledgerheirachy']);exit;
        return $finalarr;
    }
    
    public function getLedgerIds($arrledger)
    {
        $arrLedgerList = array();
        if(is_array($arrledger) && !empty($arrledger)){
            foreach ($arrledger as $alr => $ledgerDetails){
                if(isset($ledgerDetails['ledger_account_id'])){
                    array_push($arrLedgerList, $ledgerDetails['ledger_account_id']);
                }
            }
        }
        return $arrLedgerList;
    }
    
    public function buildLedgerHierarchy( array $data=array()) {
        if( !isset($data['ledger_array']) ) { return array();}
        $this->buildTree($data['ledger_array'], array());
    }
    public function buildTree(array $elements, array &$ids_settled, $parentId = 0, $level = 0) 
    {
        $branch = array ();
        
	if( in_array(gettype($parentId), array('string', 'integer') ) !== false ) {
		$parentId = explode(',', $parentId);
	}
        
        foreach ( $elements as $er => $element ) {
            if ( in_array($element ['parent_id'], $parentId ) !== false) {
                if( in_array($element ['ledger_account_id'], $ids_settled) === false) {
                    $children = $this->buildTree ( $elements, $ids_settled, $element ['ledger_account_id'], $level + 1 );
                    
                    if (!empty($children)) {
                        $element ['is_parent'] = "yes";
                        $element ['children'] = $children;
                    }
                    elseif (empty($children) && $element ['parent_id'] == 0 ) {
                        $element ['is_parent'] = "yes";
                        $element ['children'] = array();//$children;
                    }else {
                        $element ['is_parent'] = "no";
                        $element ['children'] = array ();
                    }
                    
                    $branch [] = $element;
                    array_push($ids_settled, $element ['ledger_account_id']);
                }
            }
	}
        return $branch;
    }
    
    public function getTransactionTotals( array $data) {
        if(empty($data['rs_group_hierarchy']) || !is_array($data['rs_group_hierarchy'])){ return false;}
        if(empty($data['rs_report_data']) || !is_array($data['rs_report_data'])){ return false;}
        return $this->feedInHierarchy( $data['rs_group_hierarchy'],$data['rs_report_data']);//array('ledger_array' => $arrledger)
    }
                                
    
    public function feedInHierarchy($rs_group_hierarchy, &$rs_report_data)
    {
        //echo "<pre>123456789    ";//print_r($rs_group_hierarchy);print_r($rs_report_data);//exit();
        if( !empty($rs_group_hierarchy) && !empty($rs_report_data) ) {
            if( is_array($rs_group_hierarchy) ) {
                //echo "<pre>";print_r($rs_group_hierarchy[2]['children'][5]);
                foreach( $rs_group_hierarchy as $itr => $hierarchy ) {
                    
                    if( isset($hierarchy['entity_type']) && ($hierarchy['entity_type'] == 'group' || $hierarchy['entity_type'] == 'main')  ) {
                        foreach( $rs_report_data as $ind => $data ) {
                            //echo "<pre>";print_r($data);
                            if( $hierarchy['ledger_account_id'] == $data['parent_id'] ) {
                                if( !isset($hierarchy['children']) && !is_array($hierarchy['children'])) {
                                    //echo $hierarchy['ledger_account_id'];exit();    
                                    $hierarchy['children'] = array();
                                }
                                $transaction_amount = 0.00;
                                $data_for = (isset($data['financial_year'])) ? $data['financial_year'] : $data['transaction_date'];
                                $child_already_present = false;$child_position=null;$child_details = array();
                                
                                if( is_array($rs_group_hierarchy[$itr]['children']) ) {
                                    foreach( $rs_group_hierarchy[$itr]['children'] as $cir => $child ) {
                                        if( $child['ledger_account_id'] == $data['ledger_account_id'] ) {
                                            $child_already_present = true;$child_position=$cir;break;
                                        }
                                    }// end of foreach children
                                }
                                
                                if( isset($data['entity_type']) && ($data['entity_type'] === 'ledger') ) {
                                    $transaction_amount = $this->decideTransactionTotalSign($data['transaction_amount'], $hierarchy['nature_of_account']);//echo '<br/>inside if'.$transaction_amount;
                                }
                                else {
                                    $transaction_amount = $data['transaction_amount'];//echo '<br/>inside else'.$transaction_amount;
                                }
                                
                                
                                $child_details['ledger_account_id'] = $data['ledger_account_id'];
                                if( !isset($data['ledger_account_name']) && !empty($data['ledger_account_name']) ) {//ledger_account_name
                                    
                                   /* $conditions = " soc_id = ".$soc_id." and  ledger_account_id = ".$child_details['ledger_account_id'];
                                    $objTransDetails = GrpLedgTree::findfirst(array("columns"=>"ledger_account_names","conditions"=>$conditions));*/
                                   
                                    $strstartaccount = "SELECT ledger_account_name from ledger_master where  ledger_account_id = ".$child_details['ledger_account_id'];
                                    $result = $this->db->query($strstartaccount);
                                    $arrTransDetails =  $result->result_array();  

                                    //$arrTransDetails = $objTransDetails->toArray();

                                    if( count($rs_ledger_array) > 0 ) {
                                        $data['ledger_account_name'] = $arrTransDetails[0]->ledger_account_name;
                                    }
                                }
                                $child_details['ledger_account_name'] = $data['ledger_account_name'];//!empty(self::$ledger_name_array[$data['ledger_account_id']]) ? self::$ledger_name_array[$data['ledger_account_id']] : $data['ledger_account_name'];
                                $child_details['behaviour'] = $data['behaviour'];
                                $child_details['nature_of_account'] = $data['nature_of_account'];
                                $child_details['entity_type'] = $data['entity_type'];

                                if( !isset($child_details['total_array'][$data_for]) ) {$child_details['total_array'][$data_for]=0.00;}
                                $child_details['total_array'][$data_for]+= $transaction_amount;//$data['transaction_amount'];
                                
                                if( $child_already_present === false ) {
                                    $child_details = $rs_group_hierarchy[$itr]['children'];
                                    //if($hierarchy['ledger_account_id'] == 201){echo "<pre>";print_r($rs_group_hierarchy);exit();}
                                    if(isset($child_details)){
                                        array_push($rs_group_hierarchy[$itr]['children'], $child_details);
                                    }
                                }elseif(!is_null($child_position)) {
                                    //if($hierarchy['ledger_account_id'] == 201){echo "123";exit();}
                                    $parent_total_array = array();
                                    if( isset($rs_group_hierarchy[$itr]['children'][$child_position]['total_array']) ) {
                                            $parent_total_array=$rs_group_hierarchy[$itr]['children'][$child_position]['total_array'];
                                    }
                                    if( !isset($parent_total_array[$data_for]) ) {$parent_total_array[$data_for]=0.00;}
                                    $parent_total_array[$data_for]+= $child_details['total_array'][$data_for];
                                    $child_details['total_array'] = $parent_total_array;
                                    $rs_group_hierarchy[$itr]['children'][$child_position]=$child_details;
                                }
                                //echo "<pre>";print_r($child_details);exit();
                                if( !isset($rs_group_hierarchy[$itr]['total_array']) ) {
                                    $rs_group_hierarchy[$itr]['total_array'] = array();
                                }
                                 
                                if( !isset($rs_group_hierarchy[$itr]['total_array'][$data_for]) ) {//$data['transaction_date']
                                    $rs_group_hierarchy[$itr]['total_array'][$data_for] = 0.00;//$data['transaction_date']
                                }
                            }
                       
                        }// end of foreach
                        
                        
                        if( !empty($rs_report_data) && isset($hierarchy['children']) && !empty($hierarchy['children']) && ($hierarchy['is_parent'] == 'yes') ) {
                            //if($hierarchy['ledger_account_id'] == 3){echo "testtest<pre>";print_r($hierarchy);exit();}
                            $recursive_call_on_children = $this->feedInHierarchy($rs_group_hierarchy[$itr]['children'], $rs_report_data);
                            $rs_group_hierarchy[$itr]['children'] = $recursive_call_on_children;//pass added total to parent group
                            foreach ($rs_group_hierarchy[$itr]['children'] as $idx => $child) {
                                    if( !isset($rs_group_hierarchy[$itr]['total_array']) ) { $rs_group_hierarchy[$itr]['total_array'] = array(); }
                                    if( isset($child['total_array']) ) {
                                        $datewise_array = array_keys($child['total_array']);
                                        foreach($datewise_array as $pnt => $date) {
                                            if( !isset($rs_group_hierarchy[$itr]['total_array'][$date]) ) { $rs_group_hierarchy[$itr]['total_array'][$date] = 0.00; }
                                            $rs_group_hierarchy[$itr]['total_array'][$date] = $rs_group_hierarchy[$itr]['total_array'][$date] + $child['total_array'][$date];
                                        }
                                    }//echo 'id='.$child['ledger_account_id'];print_r($child['total_array']);
                                    if( empty($child['total_array']) ) {
                                            unset($rs_group_hierarchy[$itr]['children'][$idx]);
                                    }
                            }
                        }
                        //else {$rs_group_hierarchy[$itr]['children'] = array();}
                    }

                }// end of foreach
            }
        }
        //echo "dsgdfgdf";echo "<pre>";print_r($rs_group_hierarchy);exit;
         return $rs_group_hierarchy;
    }
    
    protected function decideTransactionTotalSign($total_transaction_amount, $parent_nature_of_account) {
		$parent_group_nature = $this->constants['transactiontype'];//->transactiontype;
                //print_r($parent_group_nature);exit;
		if( $total_transaction_amount < 0 && $parent_group_nature[$parent_nature_of_account] == 'credit' ) {
			$total_transaction_amount = (-1) * $total_transaction_amount;
		}
		elseif( $total_transaction_amount < 0 && $parent_group_nature[$parent_nature_of_account] == 'debit' ) {
			$total_transaction_amount = $total_transaction_amount;
		}
		elseif( $total_transaction_amount > 0 && $parent_group_nature[$parent_nature_of_account] == 'credit' ) {
			$total_transaction_amount = (-1) * $total_transaction_amount;
		}
		elseif( $total_transaction_amount > 0 && $parent_group_nature[$parent_nature_of_account] == 'debit' ) {
			$total_transaction_amount = $total_transaction_amount;
		}
		return $total_transaction_amount;
	}
        
        
    public function getNetTotalLedgers( array $data) {
        if(empty($data['arrLedgerHierachyDetails']) || !is_array($data['arrLedgerHierachyDetails'])){ return false;}
        return $this->netTotalLedgers( $data['arrLedgerHierachyDetails']);//array('ledger_array' => $arrledger)
    }
    
    public function netTotalLedgers($arrLedgerHierachyDetails)
    {
        $net_total_array =array();
        $total_pnl_element = 0;
        foreach($arrLedgerHierachyDetails as $rti => $hierarchy)
        {
            if( !isset($hierarchy['total_array']) || empty($hierarchy['total_array']) ) { unset($rs_group_hierarchy[$rti]); continue; }
            else{
                $empty_or_zero_total = true;
                foreach($hierarchy['total_array'] as $dkey=>$dval){
                    if( ($dval < 0) || ($dval > 0) ) { $empty_or_zero_total = false; }
                    switch($hierarchy['behaviour']) {
                        case 'income':
                            $dval = $dval;
                            break;
                        case 'expense':
                            $dval = 0-$dval;
                            break;
                        default:
                            $dval = 0;
                            break;
                    }//switch behaviour totals
                    
                    if( !isset($net_total_array[$total_pnl_element]) ) {
                        $net_total_array[$total_pnl_element] = array();
                    }
                    if(isset($net_total_array[$total_pnl_element][$dkey])) {
                        $net_total_array[$total_pnl_element][$dkey]=$net_total_array[$pnl_element][$total_pnl_element][$dkey]+$dval;
                    }
                    else {
                        $net_total_array[$total_pnl_element][$dkey]=$dval;
                    }
                    if( $empty_or_zero_total === true ) {
                            unset($rs_group_hierarchy[$rti]); continue;
                    }
                }
            }
        }
        return $net_total_array;
    }
    public function grossProfitTotal( $data=array()){
        $arrPreparePeriodDetails = $data['arrPreparePeriodDetails'];
        $type = $data['type'];
        $arrdateMonth = $this->monthHeader($arrPreparePeriodDetails,$type);
        
        $net_total_array = $data['net_total_array'];
        return $this->calculateGrossProfit($arrdateMonth,$net_total_array);
    }
    
    public function netProfitTotal( $data=array()){
        $arrPreparePeriodDetails = $data['arrPreparePeriodDetails'];
        $type = $data['type'];
        $arrdateMonth = $this->monthHeader($arrPreparePeriodDetails,$type);
        $net_total_array = $data['net_total_array'];
        $income_from_operation = $data['income_from_operation'];
        return $this->calculateNetProfit($arrdateMonth,$net_total_array,$income_from_operation);
    }
    
    public function calculateGrossProfit($arrdateMonth,$net_total_array)
    {
        //echo "<pre>";print_r($net_total_array);print_r($arrdateMonth);//exit();
        $strgrossTotalHTML = '';
        $gross_profit_array = array();
        $grosstotalhtml = '';
        $totgrossamount = 0;
        $arrOutput = array();
        if(isset($arrdateMonth) && is_array($arrdateMonth) && !empty($arrdateMonth) ) {
            foreach($arrdateMonth as $key=>$val) {
                $net_total=0.00;
                if( isset($net_total_array['directincome']) && is_array($net_total_array['directincome']) && !empty($net_total_array['directincome']) ) {
                    foreach($net_total_array['directincome'] as $ntdi => $direct_income) {
                        $net_total+= $direct_income[$val];
                    }// end of foreach
                }
                if( isset($net_total_array['directexpense']) && is_array($net_total_array['directexpense']) && !empty($net_total_array['directexpense']) ) {
                    foreach($net_total_array['directexpense'] as $ntdi => $direct_expense) {
                        $net_total+= $direct_expense[$val];
                    }// end of foreach
                }
                $gross_profit_array[$val] = $net_total;
                #$income_from_operation[$val] = $gross_profit_array[$val];
            }

            //AccountReportinghelper::grossProfitHTML($arrdateMonth,$gross_profit_array);
        }
        return $gross_profit_array;
    }
    
    public function calculateNetProfit($arrdateMonth,$net_total_array,$income_from_operation)
    {
        
        $net_profit = array();
        $nettotalhtml = '';
        $netgrossamount = 0;
        $highlight_class = '';
        $strnetTotalHTML = '';
        if(isset($arrdateMonth) && is_array($arrdateMonth) && !empty($arrdateMonth) ) {
            foreach($arrdateMonth as $key=>$val) {
                $net_total = ( isset($income_from_operation[$val]) ) ?  $income_from_operation[$val] :  0.00; 
                
                if( isset($net_total_array['indirectincome']) && !empty($net_total_array['indirectincome'])) {
                    foreach( $net_total_array['indirectincome'] as $iir => $income ) {
                        if( isset($income[$val]) && !empty($income[$val]) ) {//echo '<br/>'.$iir.'='.$net_total.'='.$income[$val];
                            $net_total = ($net_total + ($income[$val]) );//echo '=>'.$net_total;
                        }
                    }
                }

                if( isset($net_total_array['indirectexpense']) && !empty($net_total_array['indirectexpense'])) {
                    
                    foreach( $net_total_array['indirectexpense'] as $eir => $expense ) {
                        if( isset($expense[$val]) && !empty($expense[$val]) ) {
                            $net_total = ($net_total + ($expense[$val]) );
                        }
                    }
                }
                $net_profit[$val] = $net_total;
            }
        }
        
        return $net_profit;
    }
    
    public function monthHeader($arrPreparePeriodDetails,$type)
    {
        if( is_array($arrPreparePeriodDetails) && !empty($arrPreparePeriodDetails) ){
            switch (strtolower($type)){
                case 'yearly':
                    $arrdateMonth = array();
                    foreach($arrPreparePeriodDetails as $kYear => $fullyear){
                        $arrdateMonth[$kYear] = $kYear;
                    }
                break;
                case 'monthly':
                default:
                    $arrdateMonth = array();
                    foreach($arrPreparePeriodDetails as $k => $yearMonth){
                        $arryearMonth = array();
                        $arryearMonth = explode("-",$yearMonth);
                        $arrdateMonth[$arryearMonth["1"]."-".$arryearMonth["0"]] = $arryearMonth["1"]."-".$arryearMonth["0"];
                    }
                break;
            }
        }
        return $arrdateMonth;
    }
}
