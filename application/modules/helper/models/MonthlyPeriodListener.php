<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MonthlyPeriodListener extends CI_Model {
    
    /**
     * function set default values
     * @method __construct
     * @access public 
     */
    public function __construct()
    {

        // Call the Model constructor
        parent::__construct();
        /*global $constants, $di,$config;
        $this->di = $di;
        //echo VARLOGS."AccountMainSetting_".date("Y-m-d").".log";exit;
        $this->logger = new Logger(VARLOGS."Accountreporting_".date("Y-m-d").".log");
        
        $inserting_data = date("Y-m-d H:i:s")."|New Hit to Account Reporting Listener ";
        $this->logger->log($inserting_data);*/
        
    }
    
    /**
     * this function returns prepare array for selected date range
     * @method calMonthlyPeriod
     * @access public
     * @param type $event
     * @param type $component
     * @param type $data
     * @return array;
     * 
     */
    public function calMonthlyPeriod(  array $data=array()){
        //Array ( [soc_id] => 623 [fystart] => 4 [lstYear] => 2015-2016 [lstMonth] => 8 [uptoMonth] => 4 )
         $intfystart = $data['fystart'];
        $lstYear = $data['lstYear'];
        $lstMonth = !empty($data['lstMonth']) ? $data['lstMonth'] : date('m');
        $uptoMonth = !empty($data['uptoMonth'])? $data['uptoMonth'] : 3;
        $endMonthYear = '';
        
        // calulate start / end month-year 
        $arryears = (strstr($lstYear,"-"))? explode("-",$lstYear): array($lstYear); 
        $endYear = ($lstMonth < $intfystart) ? $arryears[1]: $arryears[0];
        if($lstYear == $data['lastyearstart']){
            //$endYear = date("Y");
            
            if($lstMonth > 0){
                $endMonth = $lstMonth;
            }else{
                $endMonth = date("m");
            }
            $endMonthYear = $endYear."-".$endMonth;
            if($uptoMonth == 0 ){
                $upto = (date("m") < $intfystart) ? date("m") + 12 : date("m") ;
                $uptoMonth = $upto - $intfystart;
            }
            $startMonthYear = date("Y-m",strtotime("-".$uptoMonth." months",strtotime($endMonthYear."-01") ));
        }else{
            //$arryears = (strstr($lstYear,"-"))? explode("-",$lstYear): array($lstYear); 
            //$endYear = ($lstMonth < $intfystart) ? $arryears[1]: $arryears[0];
            
            if($lstMonth > 0){
                $endMonth = (strlen($lstMonth) == 1) ? '0'. $lstMonth: $lstMonth;
            }else{
                $endMonth = (strlen($intfystart) == 1) ? '0'. $intfystart: $intfystart;
                //calculate the end month using start month
                if($endMonth != '01') {
                    $endMonth = date('m', strtotime($endYear."-".$endMonth."-01 -1 day") );
                }
            }
            $endMonthYear = $endYear."-".$endMonth;
            if($uptoMonth == 0 ){
                $upto = ($lstMonth - 12);
                $uptoMonth = $upto - $intfystart;
            }
            $startMonthYear = date("Y-m",strtotime("-".$uptoMonth." months",strtotime($endMonthYear."-01") ));
        }
        
        // create array for monthly period
        for($i = 0; $i<= $uptoMonth ; $i++)
        {
            //check if the monthly period exceeds current month. If yes then, restrict the monthly periods upto current month.
            if( date("Y-m", strtotime("+".$i." months",strtotime($startMonthYear."-01") )) <= $endMonthYear ) {
                $start_month[]=  date("Y-m",strtotime("+".$i." months",strtotime($startMonthYear."-01") ));
            }
        }
        return $start_month;
    }   
    
    public function getTransactionDetails(  array $data=array())
    {
        //echo "<pre>";print_r($data);exit;
        $conditions = "";

        if(!empty($data['ledgerID']) && is_array($data['ledgerID'])){
            $strledgerIds= implode(",",$data['ledgerID']);
            $conditions.= " AND ( b.`ledger_account_id` IN (".$strledgerIds.") OR b.`parent_id` IN (".$strledgerIds.") ) ";
        }

        if(!empty($data['transdate']) && is_array($data['transdate'])){
            $strtransdate= implode("','",$data['transdate']);
            $conditions.= " AND DATE_FORMAT(a.transaction_date, '%Y-%m') IN ('".$strtransdate."')  ";
        }

        if( isset($data['behaviour']) && !empty($data['behaviour']) ){
            $conditions.= " AND b.behaviour = '".$data['behaviour']."' ";
        }
        if( isset($data['operating_type']) && !empty($data['operating_type']) ){
            $conditions.= " AND b.operating_type = '".$data['operating_type']."' ";
        }

        $strQuery = "SELECT DATE_FORMAT(`transaction_date`, '%m-%Y') AS transaction_date,
                                a.ledger_account_id, a.ledger_account_name, b.operating_type, b.nature_of_account,
                                b.context, b.behaviour, b.entity_type, b.parent_id,
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
                                `ledger_transactions` a, `ledger_master` b
                            WHERE
                                a.`ledger_account_id` = b.`ledger_account_id` ".$conditions."
                            GROUP BY a.ledger_account_id , DATE_FORMAT(`transaction_date`, '%m-%Y')
                            ORDER BY a.ledger_account_id , `transaction_date`";
        //$arrTransactionDetails = $this->di->getShared("soc_db_w")->fetchAll($strQuery);
                           // echo $strQuery;
        $result = $this->db->query($strQuery);
        return $result->result_array();                    
        //return $arrTransactionDetails;
        
    }
}
