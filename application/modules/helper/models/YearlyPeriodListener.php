<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class YearlyPeriodListener extends CI_Model{
    
   /**
     * function set default values
     * @method __construct
     * @access public 
     */
    public function __construct()
    {
        parent::__construct();
        /*global $constants, $di,$config;
        //echo VARLOGS."AccountMainSetting_".date("Y-m-d").".log";exit;
         $this->di = $di;
        $this->logger = new Logger(VARLOGS."Accountreporting_".date("Y-m-d").".log");
        
        $inserting_data = date("Y-m-d H:i:s")."|New Hit to Account Reporting Listener ";
        $this->logger->log($inserting_data);*/
        
    }
    
    /**
     * this function returns prepare array for selected date range
     * @method calYearlyPeriod
     * @access public
     * @param type $event
     * @param type $component
     * @param type $data
     * @return array;
     * 
     */
    public function calYearlyPeriod( $data=array()){

        /*echo "<pre>";
        print_r($data);*/
        //echo "twets".$data['lstYear'];
        $lstYear = isset($data['lstYear']) ? $data['lstYear']: date("Y");
        //echo $lstYear;exit;
        $uptoYear = ($data['uptoYear'] != 0 && !empty($data['uptoYear']) && $data['uptoYear'] != '' )? $data['uptoYear']: 1;
        
        //if(strstr($lstYear,'-')){
            $arrYears = explode("-",$lstYear);
        //}

        $currentfyStartYear = $arrYears[0]."-".$data['fyyears']['arraccountStartMaster'][0]['fy_start_from'];
         
        $uptoYear;//exit;
        for($i = $uptoYear-1 ; $i >= 0; $i--){   
            //$data['fyyears']['arraccountStartMaster']['fy_start_from'] = '01-01';
            if($data['fyyears']['arraccountStartMaster'][0]['fy_start_from'] == '01-01'){
                $fyYear = date("Y",strtotime($currentfyStartYear."-".$i." year"));
                $fyStartDate = date("Y-m-d",strtotime($currentfyStartYear."-".$i." years"));
                $fyEndDate = date("Y-m-d",strtotime($fyStartDate."+1 year -1 day"));
                $start_month[$fyYear] = $fyYear;
            }else{
                $fystartDate = date("Y-m-d",strtotime($currentfyStartYear."-".$i." years"));
                $fyendDate = date("Y-m-d",strtotime($fystartDate."+1 year -1 day"));
                $fystartYear = date("Y",strtotime($fystartDate));
                $fyendYear = date("Y",strtotime($fyendDate));
                
                $fyyear = $fystartYear."-".$fyendYear;
                $start_month[$fyyear] = $fystartDate."-to-".$fyendDate;
            }
        }
        //echo "<pre>";print_r($start_month);exit();
        return $start_month;
    } 
    
    public function getTransactionDetails(  array $data=array())
    {
       // echo "<pre>";print_r($data);
        $conditions = "";
        $fystartfrom = '';
        //$soc_id = isset($data['soc_id']) ? $data['soc_id'] : '';
        if(!empty($data['fyyears']) && is_array($data['fyyears'])){
            $fystartfrom = $data['fyyears']['arraccountStartMaster'][0]['fy_start_from'];
        }
        
        if(!empty($data['ledgerID']) && is_array($data['ledgerID'])){
            $strledgerIds= implode(",",$data['ledgerID']);
            $conditions.= " AND ( b.`ledger_account_id` IN (".$strledgerIds.") OR b.`parent_id` IN (".$strledgerIds.") ) ";
        }

        if(!empty($data['transdate']) && is_array($data['transdate'])){
            //$strtransdate= implode("','",$data['transdate']);
            $arrfydates = explode("-to-", current($data['transdate']));
            $startyear = $arrfydates[0]; 
            
            $arrfyenddates = explode("-to-", end($data['transdate']));
            $endtyear = $arrfyenddates[1];
            
            $conditions.= " AND a.transaction_date between DATE('".$startyear."') and DATE('".$endtyear."')";
        }
        $get_start_month  = date("m",strtotime($startyear));
        $get_start_day  = date("d",strtotime($startyear));
        if( isset($data['behaviour']) && !empty($data['behaviour']) ){
            $conditions.= " AND b.behaviour = '".$data['behaviour']."' ";
        }
        if( isset($data['operating_type']) && !empty($data['operating_type']) ){
            $conditions.= " AND b.operating_type = '".$data['operating_type']."' ";
        }
        
        $strQuery = "SELECT 
                        CASE WHEN ".$get_start_month."=01 AND ".$get_start_day."=01 THEN
                        YEAR(a.transaction_date)
                                
                                WHEN MONTH(a.transaction_date)>=".$get_start_month." THEN
                        concat(YEAR(a.transaction_date), '-',YEAR(a.transaction_date)+1)
                                ELSE concat(YEAR(a.transaction_date)-1,'-', YEAR(a.transaction_date)) END AS financial_year,
                            a.ledger_account_id,
                            a.ledger_account_name,
                            b.nature_of_account,
                            b.context,
                            b.behaviour,
                            b.entity_type,
                            b.parent_id,
                            SUM(IF(a.transaction_type = 'dr',
                                a.transaction_amount,
                                0)) AS debit_amt,
                            SUM(IF(a.transaction_type = 'cr',
                                a.transaction_amount,
                                0)) AS credit_amt,
                            (SUM(IF(a.transaction_type = 'dr',
                                a.transaction_amount,
                                0)) - SUM(IF(a.transaction_type = 'cr',
                                a.transaction_amount,
                                0))) AS transaction_amount
                        FROM
                            `ledger_transactions` a,
                            `ledger_master` b
                        where
                            a.`ledger_account_id` = b.`ledger_account_id`
                            ".$conditions."
                                group by ledger_account_id,financial_year";
        
        //$arrTransactionDetails = $this->di->getShared("soc_db_w")->fetchAll($strQuery);
                                
        $result = $this->db->query($strQuery);
        return $result->result_array();                    
        //return $arrTransactionDetails;
        
    }
}
