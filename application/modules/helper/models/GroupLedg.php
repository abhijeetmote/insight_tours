<?php
/**
    * This class file is a library for Accounts module. All Group/Ladger related manipulation define here.
    *
    * PHP versions 5.5.9
    *
    * Project name Tourse
    * @version 1: Components/GroupLedg 2015-08-19 $
    * @copyright Copyright (C) nilesh
    * @license Copyright (C) 2016 NAMO Technology
    * @license ZOMBIII
    * @link ZOMBIII
    * @category GroupLedg Component
    * @author Author <NILESH>
    * @since File available since Release 1.0  
 */

/** 
 *Group Ledger Component for manipulate Group Ledger records
 */
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class GroupLedg extends CI_Model
{
     
    /**
	 * The Component action `initialize` is called to set basic parametrs.
	 * @method initialize.
    */
   function __construct(){
        // Call the Model constructor
        parent::__construct();
    }

    /**
     * The Component action `manipulate` is called to To inserts a group/ledger.
     * To inserts a group/ledger. I $ledg_id is passed it will update that record   
     * @method manipulate.
     * @access public  
     * @param string $name Name of Ledger
     * @param string $entity_type Ledger or Group
     * @param integer $grp_ledg_id id of the Group
     * @param integer $parent_group id of parent group
     * @param string $behaviour {asset, liability, income, expense}
     * @param integer $ledg_id id of ledger
     * @param float $opening_balance for first entry in a ledger
        * @global object $config object for config parameters
        * @global object $di object for Dependency Injector
     * @return string|array|boolean
     * 
     * @see _checkGroupNameDuplication(), getLedger(), _getLedgerProps()
     * @uses \ChsOne\Components\Accounts\Transaction::addTxn add transaction
     */
    public function manipulate($name, $entity_type = ENTITY_TYPE_GROUP, $grp_ledg_id = "", $parent_group = 0, $behaviour = "", $ledg_id = '',$opening_balance = 0, $update_led_id='', $ledger_start_date='' ,$ledger_type = '', $context= '')
    {
        global $config, $di;
        $this->accountclosingevent = new AccountclosingEvent($this->config);
        $this->accountclosingevent->addListener('Accountclosing', '\ChsOne\Components\Accountclosing\Listeners\AccountclosingListener');
        //echo $name.$update_led_id;
        $dup  = $this->_checkGroupNameDuplication($parent_group, $name, $ledg_id ,$update_led_id);
        //echo "test".$dup.$update_led_id."test".$ledg_id;exit;
        $closure_master_details = $this->accountclosingevent->accountClosure('Accountclosing:getfystartdate', array('soc_id' => $this->session->get("auth")["soc_id"],'this'=>$this->modelsManager, 'process' => 'fetch' ));
        $closing_details = $closure_master_details->getQuery()->execute()->toArray();
        //$closing_details = $this->getQuery($closure_master_details);
        //echo "<pre>";print_r($closing_details);exit;
        $ledger_start_date   =  $closing_details[0]['fy_start_date'];
        if ($dup == 0 ) { 
            $this->soc_db_w->begin();        
            $behaviour = trim(strtolower($behaviour));
            
            $soc_id = $this->session->get("auth")["soc_id"];
            $grp_ledg_tree = new GrpLedgTree();        
            //for edit ledger and edit group case,check if ledger id is passed, if yes then get records
            if( $ledg_id ) {

                $grp_ledg_tree = $this->getLedger($ledg_id);

                }
            $grp_ledg_tree->entity_type = $entity_type;
            $grp_ledg_tree->soc_id = $soc_id;
            $grp_ledg_tree->ledger_account_name = $name;
            $grp_ledg_tree->ledger_start_date = $ledger_start_date;
            $grp_ledg_tree->context_ref_id = 0;
            
            if(!empty($ledger_type) && $ledger_type!="NULL" && $ledger_type!='') {
                $grp_ledg_tree->operating_type = $ledger_type;
            } else{
                $grp_ledg_tree->operating_type = '';
            }
            


            if (!empty($grp_ledg_id)) {
                $grp_ledg_tree->ledger_account_id = $grp_ledg_id;
            }
            
            if ($update_led_id!='') {
                //echo $update_led_id;exit;
                $grp_ledg_tree->ledger_account_id = $update_led_id;
            }

            if (!empty($parent_group)) {
                $grp_ledg_tree->parent_id = $parent_group;
                $ledger_props = $this->_getLedgerProps($parent_group);
            } else {
                $grp_ledg_tree->parent_id = HEAD_GROUP_VAL;
            }

            if (!empty($behaviour)) {
                $grp_ledg_tree->behaviour = $behaviour;
                $grp_ledg_tree->nature_of_account = $config->nature_account->$behaviour;
                $grp_ledg_tree->report_head = $config->report_head->$behaviour;
            } else {
                $grp_ledg_tree->behaviour = $ledger_props["behaviour"];
                $grp_ledg_tree->nature_of_account = $ledger_props["nature_account"];
                $grp_ledg_tree->report_head = $ledger_props["report_head"];
            }

            if(!empty($context) && $context!='') {
                $grp_ledg_tree->context = $context;
            } else {
            $grp_ledg_tree->context = $ledger_props["context"];
            }
            $grp_ledg_tree->defined_by = USER;
            $grp_ledg_tree->status = ACTIVE;
            $grp_ledg_tree->added_on = date("Y-m-d H:i:s");
            $grp_ledg_tree->created_by = $this->session->get("auth")["user_id"];

            //for opening balance, enter records in transaction table
            /*if(!empty($opening_balance)){
                $txn = new LedgerTxn();
                $txn->soc_id = $this->_di->getShared("session")->get("auth")["soc_id"];
                $txn->transaction_date = date("Y-m-d H:i:s");
                $txn->ledger_account_id = $grp_ledg_tree->ledger_account_id;
                $txn->transaction_amount = $opening_balance;
                $txn->is_opening_balance = 1;
                $txn->is_reconciled = 0;
                $txn->created_by = $this->_di->getShared("session")->get("auth")["user_id"];
                $txn->added_on = date("Y-m-d H:i:s");            
                //print_r($txn->toArray());exit;
                $txn->save();            
            }*/

            if ($grp_ledg_tree->save()) {
                
                $txn = new \ChsOne\Components\Accounts\Transaction();
                $txn->initialize($di);
                $txn_date=date("Y-m-d H:i:s");
                $narration='entry for opening balance';
                if ($txn->addTxn($grp_ledg_tree->ledger_account_id, $opening_balance,$narration, $txn_date, "", "", "", "", "",$name,$is_opning=1)) {
                   $this->soc_db_w->commit();
                } else {
                    $this->soc_db_w->rollback();
                }

                //Caching check - clear cache.
                //$class_name = get_class();
                //$function_name = "getLedgGroupTree";
                //$this->caching = new Caching();
                //$this->caching->initialize($di);
                //$this->caching->clearCache($class_name, $function_name);
                    
                return $grp_ledg_tree->ledger_account_id;
            } else {
                $this->soc_db_w->rollback();
                return FALSE;
            }
        } else {
            //echo $dup;exit;
            return "DUP".$dup;
        }
        
       
    }

    
    
    
    
    public function update_context_ref($led_id,$context_ref_id)
    {
        global $config, $di;
        
        if ($led_id!='' && $context_ref_id!='') { 
            $this->soc_db_w->begin();        
            //$grp_ledg_tree = NULL;
            $ledger_id = preg_replace("/[^0-9]/", "", $led_id);
            $grp_ledg_tree = $this->getLedger($ledger_id);
            $grp_ledg_tree->context_ref_id = $context_ref_id;
            if ($grp_ledg_tree->save()) {
            $this->soc_db_w->commit();
            return true;
            }
            else {
            print_r($grp_ledg_tree->getMessages());
            $this->soc_db_w->rollback();
            return false;
            }

        }
    }
        
       
    
    
    
    /**
     * The Component action `lists` is called to list a group/ledger.
     * To get all gropus/ledgers based on behaviour and parent   
     * @method lists.
     * @access public
     * @param integer $parent_id db id of parent group
     * @param string $behaviour {asset, liability, income, exense}
     * @param integer $number for pagination
     * @param integer $offset for pagination
     * @var integer $soc_id Society id
     * @see _getLedGrpListRecur()
     * @uses ChsOne\Models\GrpLedgTree::__construct() 
     * @return array
     */
    public function lists($parent_id, $behaviour, $number = "", $offset = "")
    {
        $soc_id = $this->_di->getShared("session")->get("auth")["soc_id"];
        $behaviour = strtolower(trim($behaviour));
        $conditions = "soc_id = ?1";
        $bind = array(1 => $soc_id);

        if (!empty($parent_id) || strval($parent_id) == "0") {
            $conditions .= " AND parent_id = ?2";
            array_push($bind, $parent_id);
        }

        if (!empty($behaviour)) {
            $conditions .= " AND behaviour = ?3";
            array_push($bind, $behaviour);
        }

        $find_arr = array("conditions" => $conditions, "bind" => $bind, "order" => "parent_id ASC, added_on DESC");

        if (!empty($number)) {
            $find_arr["limit"]= array("number" => $number, "offset" => $offset);
        }
            
        $grp_ledgers = GrpLedgTree::find($find_arr);

        $ret_arr = $this->_getLedGrpListRecur($grp_ledgers->toArray());
        return $ret_arr[0];
    }

    /**
     * The Component action `_getLedgerProps` is called to get ledger property like behaviour, nature of account, report head etc.
     * @method _getLedgerProps.
     * @access public
     * @param integer $parent_group parent group id
     * @return array
     * @uses \ChsOne\Models\GrpLedgTree::__construct() 
     */
    private function _getLedgerProps($parent_group)
    {
        $array = array();

        if (is_numeric($parent_group)) {
            $ledger_props = \ChsOne\Models\GrpLedgTree::find(array("columns" => "nature_of_account, behaviour, report_head, context", "conditions" => "ledger_account_id = ?1", "bind" => array(1 => $parent_group)));
        }

        foreach ($ledger_props as $ledger_prop) {
            $array["behaviour"] = $ledger_prop->behaviour;
            $array["nature_account"] = $ledger_prop->nature_of_account;
            $array["report_head"] = $ledger_prop->report_head;
            $array["context"] = $ledger_prop->context;
        }

        return $array;
    }

    /**
     * The Component action `getDefLedgStructure` is called To get default ledger structure from master db to be inserted in the Soc DB.
     * @method getDefLedgStructure.
     * @access public
     * @return array
     */
    public function getDefLedgStructure()
    {
        return DefLedgStru::find(array("order" => "def_parent_id asc"));
    }

    /**
     * The Component action `setDefLedgStructure` is called To Inserts default ledger structure for a society in Soc DB mapped with soc id.
     * @method setDefLedgStructure.
     * @access public
     * @param array $def_ledg_stru 
     * @var integer $soc_id society id
     * @var integer $created_by created by id
     * @uses ChsOne\Models\GrpLedgTree::__construct() 
     */
    public function setDefLedgStructure($def_ledg_stru)
    {
        
        $soc_id     = $def_ledg_stru->soc_id;
        $created_by = $def_ledg_stru->created_by;
        $parent_missing = array();   
        $parent_array   = array();
        
        foreach ($def_ledg_stru as $def_stru) {
            
            $grp_ledg_tree = new GrpLedgTree();
            $grp_ledg_tree->soc_id = $soc_id;
            
            $grp_ledg_tree->ledger_account_name = $def_stru->def_ledger_acc_name;
            
            if ($def_stru->def_parent_id == 0) {
                $grp_ledg_tree->parent_id = $def_stru->def_parent_id;
            } else {
                $grp_ledg_tree->parent_id = $parent_array[$def_stru->def_parent_id];
            }
            
            $grp_ledg_tree->report_head = $def_stru->def_report_head;
            $grp_ledg_tree->context_ref_id = $def_stru->def_context_ref_id;
            $grp_ledg_tree->context = $def_stru->def_context;
            $grp_ledg_tree->created_by = $created_by;
            $grp_ledg_tree->entity_type = $def_stru->def_entity_type;
            $grp_ledg_tree->behaviour = $def_stru->def_behaviour;            
            $grp_ledg_tree->defined_by = $def_stru->def_defined_by;
            $grp_ledg_tree->nature_of_account = $def_stru->def_nature_acc;
            $grp_ledg_tree->added_on = date('Y-m-d h:i:s');
            $grp_ledg_tree->status = 1;            
            $grp_ledg_tree->save();
            
            $parent_array[$def_stru->def_ledger_account_id] = $grp_ledg_tree->ledger_account_id;
            
            
            if ($def_stru->def_parent_id > 0 && $grp_ledg_tree->parent_id == "") {
                $parent_missing[$grp_ledg_tree->ledger_account_id] = $def_stru->def_parent_id;
                
            }
        }
        
            
        if (!empty($parent_missing)) {
            
            foreach ($parent_missing as $key=>$val) {
                
                if (isset($parent_array[$val])) {
                    $ledg_tree = GrpLedgTree::findFirst($key);
                    $ledg_tree->parent_id = $parent_array[$val];
                    $ledg_tree->save();
                }
                               
            }
           
        }
       
    }

    /**
     * The Component action `getLedgGroupTree` is called to get ledger tree structure
     * @method getLedgGroupTree.
     * @access public
     * @param sting $voucher_type contra, income, expense, etc.
     * @param string $mode {TO, FROM}
     * @param string $entity_type {LEDGER, GROUP}
     * @var integer $soc_id society id
     * @see _contextVoucherType(), _getLedGrpListRecur()
     * @uses ChsOne\Models\GrpLedgTree::__construct() 
     * @return array
     */
    public function getLedgGroupTree($voucher_type, $mode, $entity_type = "")
    {
        global $di;
        
        $fin_cnd = "";
        $bind = array();
        $soc_id = $this->session->get("auth")["soc_id"];
        $cnd_arr = $this->_contextVoucherType($voucher_type, $mode);
        $i = 1;

        if (is_array($cnd_arr["context"])) {
            foreach ($cnd_arr["context"] as $cnnd) {
                $conditions[] = " context = ?$i ";
                $bind[$i] = $cnnd;
                $i++;
            }

            $cd = implode(" OR ", $conditions);
        }
        
        if (is_array($cnd_arr["context_not"])) {
            foreach ($cnd_arr["context_not"] as $cnndnt) {
                $conditionsnt[] = " context != ?$i ";
                $bind[$i] = $cnndnt;
                $i++;
            }

            $cdnt = implode(" AND ", $conditionsnt);
        }

        if (is_array($cnd_arr["grp"])) {
            foreach ($cnd_arr["grp"] as $ingrp) {
                $conditionsgrp[] = " ledger_account_id = ?$i ";
                $bind[$i] = $ingrp;
                $i++;
            }

            $cdgrp = implode(" OR ", $conditionsgrp);
        }

        if (!empty($cd) && !empty($cdnt)) {
            $fin_cnd .= "((" . $cd . ") AND (" . $cdnt . "))";
        } else if (!empty($cd)) {
            $fin_cnd .= "(" . $cd . ") ";
        } else if (!empty($cdnt)) {
            $fin_cnd .= "(" . $cdnt . ") ";
        }

        if (!empty($cdgrp) && !empty($fin_cnd)) {
            $fin_cnd .= " OR (" . $cdgrp . ")";
        } else if (empty($fin_cnd) && !empty($cdgrp)) {
            $fin_cnd .= " (" . $cdgrp . ") ";
        }

        if (empty($fin_cnd)) {
            $fin_cnd .= " status = ?$i ";
        } else {
            $fin_cnd .= " AND status = ?$i ";
        }

        $bind[$i] = ACTIVE;
        
        $i++;
        $fin_cnd .= " AND (soc_id = ?$i) ";
        $bind[$i] = $soc_id;
         
        if ($entity_type == ENTITY_TYPE_LEDGER) {
            
        } else if ($entity_type == ACC_TYPE_BANK || $entity_type == ACC_TYPE_CASH) {
            $i++;
            $fin_cnd .= " AND (behaviour = ?$i  ";
            $bind[$i] = "asset";
            
            $i++;
            $fin_cnd .= " OR behaviour = ?$i)  ";
            $bind[$i] = "liability";
            
             $i++;
            $fin_cnd .= " AND (TRIM(LOWER(entity_type)) != ?$i) ";
            $bind[$i] = trim(strtolower(ENTITY_TYPE_LEDGER));
            
        } else if ($entity_type == ENTITY_TYPE_GROUP) {
            $i++;
            $fin_cnd .= " AND (TRIM(LOWER(entity_type)) != ?$i) ";
            $bind[$i] = trim(strtolower(ENTITY_TYPE_LEDGER));
        }
       
      
        $groups_ledgers = GrpLedgTree::find(array("conditions" => $fin_cnd, "bind" => $bind, "order" => "parent_id ASC"));
         /*echo "<pre>"; 
        print_r($groups_ledgers->toarray());
        echo $entity_type;
        exit;*/
        //echo "tets";exit;
        //$groups_ledgers = GrpLedgTree::find();
        
        $ret_arr = $this->_getLedGrpListRecur($groups_ledgers->toArray(), array(), 0, array(), $entity_type);
        
        //$ret_arr = $this->build_tree($groups_ledgers->toArray());
        /*echo "<pre>";
        print_r($ret_arr[0]);exit;
        //krsort($ret_arr[0]);
        /*echo "<pre>";
        print_r($ret_arr[0]);exit;*/
        return $ret_arr[0];
        //return $ret_arr;
        
    }

    /**
     * The Component action `_contextVoucherType` is called to get config values
     * @method _contextVoucherType.
     * @access public
     * @param string $voucher_type contra 
     * @param sting $mode
     * @global array $config global config variable
     * @var integer $soc_id society id
     * @uses ChsOne\Models\GrpLedgTree::__construct()
     * @return array
     */
    private function _contextVoucherType($voucher_type, $mode)
    {
        global $config;
        //$soc_id = $this->session->get("auth")["soc_id"];

        if ($mode == MODE_FROM) {
            if (isset($config->context_from_conf_arr->$voucher_type)) {
                $context = $config->context_from_conf_arr->$voucher_type->toArray();
            } else {
                $context = "";
            }

            if (isset($config->context_from_not_in_conf_arr->$voucher_type)) {
                $context_not = $config->context_from_not_in_conf_arr->$voucher_type->toArray();
            } else {
                $context_not = "";
            }

            if (isset($config->context_from_grp_array->$voucher_type)) {
               
                 $i = 1;
                $bind = array();

                foreach ($config->context_from_grp_array->$voucher_type->toArray() as $tmp) {
                    $conditions[] = " LOWER(ledger_account_name) = ?$i ";
                    $bind[$i] = strtolower($tmp);
                    $i++;
                }

                $conds = implode(" OR ", $conditions);

                //$conds .= " AND (soc_id = ?$i)";
                //$bind[$i] = $soc_id;
            } else {
                $grp = "";
            }
            /*echo "<br>";
        print_r($bind);
        print_r($conds);exit;*/
        }

        if ($mode == MODE_TO) {
            if (isset($config->context_to_conf_arr->$voucher_type)) {
                $context = $config->context_to_conf_arr->$voucher_type->toArray();
            } else {
                $context = "";
            }

            if (isset($config->context_to_not_in_conf_arr->$voucher_type)) {
                $context_not = $config->context_to_not_in_conf_arr->$voucher_type->toArray();
            } else {
                $context_not = "";
            }

            if (isset($config->context_to_grp_array->$voucher_type)) {
                
                $i = 1;
                $bind = array();

                foreach ($config->context_to_grp_array->$voucher_type->toArray() as $tmp) {
                    $conditions[] = " LOWER(ledger_account_name) = ?$i ";
                    $bind[$i] = strtolower($tmp);
                    $i++;
                }

                $conds = implode(" OR ", $conditions);

                $conds .= " AND (soc_id = ?$i)";
                $bind[$i] = $soc_id;

            } else {
                $grp = "";
            }
        }
        /*echo "<br>";
        print_r($bind);
        print_r($conds);*/
        
        $grps = GrpLedgTree::find(array("columns" => "ledger_account_id", "conditions" => $conds, "bind" => $bind));
        //echo "<pre>";
        //print_r($grps->toarray());exit;
        if ($grps) {
            foreach ($grps as $grp) {
                $gp_id[] = $grp->ledger_account_id;
            }

        } else {
            $gp_id = "''";
        }

        return array("context" => $context, "context_not" => $context_not, "grp" => $gp_id);
    }

    /**
     * The Component action `_getLedGrpListRecur` is called to Recursive function to get all children of a group
     * @method _getLedGrpListRecur.
     * @access public
     * @param array $led_grp_objects array of objects of children of same group
     * @param array $master_array
     * @param integer $parent_id DEFAULT 0
     * @param array $array_id
     * @param string $entity_type
     * @see _getGrpChildren(), _getLedGrpListRecur()
     * @return array
     */
   
    private function _getLedGrpListRecur($led_grp_objects, $master_array = array(), $parent_id = 0, $array_id = array(), $entity_type = '')
    {
    	foreach ($led_grp_objects as $led_grp_items) {
            $children = "";
            $children = $this->_getGrpChildren($led_grp_items["ledger_account_id"], $entity_type);


            if (!in_array($led_grp_items["ledger_account_id"], $array_id)) {
                $master_array[$led_grp_items["ledger_account_id"]]["name"] = $led_grp_items["ledger_account_name"];
                $master_array[$led_grp_items["ledger_account_id"]]["nature"] = $led_grp_items["nature_of_account"];
                $master_array[$led_grp_items["ledger_account_id"]]["behaviour"] = $led_grp_items["behaviour"];
                $master_array[$led_grp_items["ledger_account_id"]]["entity_type"] = $led_grp_items["entity_type"];
                $master_array[$led_grp_items["ledger_account_id"]]["ledger_account_id"] = $led_grp_items["ledger_account_id"];
                $master_array[$led_grp_items["ledger_account_id"]]["parent"] = $led_grp_items["parent_id"];
                $master_array[$led_grp_items["ledger_account_id"]]["status"] = $led_grp_items["status"];
                $master_array[$led_grp_items["ledger_account_id"]]["context"] = preg_replace('/[0-9]+/', '', $led_grp_items["context"]);
                $master_array[$led_grp_items["ledger_account_id"]]["is_parent"] = "no";
                $master_array[$led_grp_items["ledger_account_id"]]["operating_type"] = $led_grp_items["operating_type"];
                
                array_push($array_id, $led_grp_items["ledger_account_id"]);
                
            }

            if (!empty($children)) {
            	$final_array = $this->_getLedGrpListRecur($children, $master_array[$parent_id], $led_grp_items["ledger_account_id"], $array_id, $entity_type);
                if (is_array($final_array[0]) && !empty($final_array[0])) {
                    $master_array[$led_grp_items["ledger_account_id"]]["children"] = $final_array[0];
                    $master_array[$led_grp_items["ledger_account_id"]]["is_parent"] = "yes";
                }

                $array_id = $final_array[1];

            }
            
        }
        return array($master_array, $array_id);
    }

    /**
     * The Component action `_getGrpChildren` is called to get children of a group
     * @method _getGrpChildren.
     * @access public
     * @param integer $group id of group of which children to be fetched
     * @param sting $entity_type
     * @var integer $soc_id society id
     * @uses ChsOne\Models\GrpLedgTree::__construct() 
     * @return string
     */
    private function _getGrpChildren($group, $entity_type = '')
    {
        $children = "";
        $soc_id = $this->session->get("auth")["soc_id"];
        
        $conditions = "parent_id = ?1 AND soc_id = ?2";
        $bind       = array(1 => $group, 2 => $soc_id);
        
        if ($entity_type == ENTITY_TYPE_LEDGER) {
            
        } else if ($entity_type == ACC_TYPE_BANK || $entity_type == ACC_TYPE_CASH) {
            
            $conditions .= " AND (behaviour = ?3  ";
            $bind[3] = "asset";
            
            
            $conditions .= " OR behaviour = ?4)  ";
            $bind[4] = "liability";
            
            
            $conditions .= " AND (TRIM(LOWER(entity_type)) != ?5) ";
            $bind[5] = trim(strtolower(ENTITY_TYPE_LEDGER));
            
        } else if ($entity_type == ENTITY_TYPE_GROUP) {
            
            $conditions .= " AND (TRIM(LOWER(entity_type)) != ?3) ";
            $bind[3] = trim(strtolower(ENTITY_TYPE_LEDGER));
        }
        
        $children = GrpLedgTree::find(array("conditions" => $conditions, "bind" => $bind, "order" => "ledger_account_name ASC"))->toArray();
        
        if (count($children) > 0) {
            return $children;
        } else {
            $children = "";
            return $children;
        }
    }
    
    /**
     * The Component action `getLedger` is to Get all ledgers of a group
     * @method getLedger.
     * @access public
     * @param integer $ledger_acct_id
     * @param integer $return_object DEFAULT 1
     * @uses ChsOne\Models\GrpLedgTree::__construct()
     * @return boolean
     */
    public function getLedger($ledger_acct_id, $return_object = 1)
    {           
             $ledger = GrpLedgTree::findFirst(array("conditions" => "ledger_account_id = ?0","bind" => array(0 => $ledger_acct_id)));
            
             if ($ledger) {
                if ($return_object) {
                    return $ledger;
                } else {
                    return $ledger->toArray();
                }
             } else {
                 return FALSE;
             }
            
    }
    
    
    
    /**
     * The Component action `getLedgers` is to Get all ledgers of a group
     * @method getLedgers.
     * @access public
     * @param integer $ledger_acct_id
     * @param integer $return_object DEFAULT 1
     * @uses ChsOne\Models\GrpLedgTree::__construct()
     * @return boolean
     */
    public function getLedgers($ledger_acct_id, $return_object = 1)
    {       
             $ledger = GrpLedgTree::find(array("conditions" => "parent_id = ?0","bind" => array(0 => $ledger_acct_id )));
             if ($ledger) {
                if ($return_object) {
                    return $ledger;
                } else {
                    return $ledger->toArray();
                }
             } else {
                 return FALSE;
             }
            
    }
    
    
    
    
    /**
     * The Component action `receipt_sorted_array` is to sort ladger tree for receipt voucher
     * @method receipt_sorted_array.
     * @access public
     * @param array $elements tree array
     * @param int $parentId DEFAULT 0
     * @param array $filter_param filter parameters
     * @return array
     */
    public function receipt_sorted_array($elements, $parentId = 0,$filter_param) {
            //echo "<pre>";
            //print_r($elements);exit;
	foreach ($elements as $elementKey=>$elementValue) {
		if(!in_array($elementValue['context'],$filter_param)!==false){
			if ($elementValue['is_parent'] == 'yes' && !empty ( $elementValue ['children'] )) {
				$elements[$elementKey]['children'] = $this->receipt_sorted_array($elementValue ['children'], $elementValue ['ledger_account_id'],$filter_param);
			}else {
				continue;
			}
		}
		elseif ($elementValue['is_parent'] == 'yes' && !empty ( $elementValue ['children'] )) {

				$elements[$elementKey]['children'] = $this->receipt_sorted_array ( $elementValue ['children'], $elementValue ['ledger_account_id'],$filter_param);
				if( empty($elements[$elementKey]['children']) ) { unset($elements[$elementKey]); }
		} else{
				unset($elements[$elementKey]);
			}
		}
                //print_r($elements);exit;
		return $elements;
        }
    
    
        /**
     * The Component action `sorted_array` is to sort ladger tree for vouchers
     * @method sorted_array.
     * @access public
     * @param array $elements tree array
     * @param int $parentId DEFAULT 0
     * @param array $filter_param filter parameters
     * @return array
     */
  	public function sorted_array($elements, $parentId = 0,$filter_param) {
            //echo "<pre>";
            //print_r($elements);exit;
	foreach ($elements as $elementKey=>$elementValue) {
		if(in_array($elementValue['context'],$filter_param)!==false){
			if ($elementValue['is_parent'] == 'yes' && !empty ( $elementValue ['children'] )) {
				$elements[$elementKey]['children'] = $this->sorted_array($elementValue ['children'], $elementValue ['ledger_account_id'],$filter_param);
			}else {
				continue;
			}
		}
		elseif ($elementValue['is_parent'] == 'yes' && !empty ( $elementValue ['children'] )) {

				$elements[$elementKey]['children'] = $this->sorted_array ( $elementValue ['children'], $elementValue ['ledger_account_id'],$filter_param);
				if( empty($elements[$elementKey]['children']) ) { unset($elements[$elementKey]); }
		} else{
				unset($elements[$elementKey]);
			}
		}
                //print_r($elements);exit;
		return $elements;
            }
    
    /**
     * The Component action `disableLedger` is to Change status of ledger
     * @method disableLedger.
     * @access public
     * @param INT $ledger_id
     * @var integer $soc_id society id
     * @uses ChsOne\Models\GrpLedgTree::__construct()
     */
    public function disableLedger($ledger_id) {
        
        $soc_id = $this->_di->getShared("session")->get("auth")["soc_id"];
        
        $ledger = GrpLedgTree::findFirst(array("conditions" => "ledger_account_id = ?0 AND soc_id = ?1","bind" => array(0 => $ledger_id, 1 => $soc_id )));
        $data = $ledger->toarray();

        while(!empty($data['parent_id']) && $data['parent_id']!= 0 && $data['parent_id']!= '' & $data['status']==0){
        if(!empty($data['parent_id']) && $data['parent_id']!=1 && $data['status']==0) {
            $leger_parent = GrpLedgTree::findFirst(array("conditions" => "ledger_account_id = ?0 AND soc_id = ?1","bind" => array(0 => $data['parent_id'], 1 => $soc_id )));
            $data['parent_id'] = $leger_parent->parent_id;
        } else {
            $data['parent_id'] = 0;
        }
        
        if ( $leger_parent ) {
            $leger_parent->status = 1;           
            $leger_parent->save();
        }
        }

        if ( $ledger ) {
            if ($ledger->status == 0) {
                $ledger->status = 1;
            } else {            
                $ledger->status = 0;           
            }
            
            $ledger->save();
        }  
        
    }
    
    /**
     * The Component action `disableGroup` is to Change status of group aand its children
     * @method disableGroup.
     * @access public
     * @param INT $group_id
     * @var integer $soc_id
     * @see _getLedgerChildren()
     * @uses ChsOne\Models\GrpLedgTree::__construct()
     */
    public function disableGroup($group_id) {
        
        $soc_id = $this->_di->getShared("session")->get("auth")["soc_id"];
        
        $ledger = GrpLedgTree::findFirst(array("conditions" => "ledger_account_id = ?0 AND soc_id = ?1","bind" => array(0 => $group_id, 1 => $soc_id )));
        $data = $ledger->toarray();

        while(!empty($data['parent_id']) && $data['parent_id']!= 0 && $data['parent_id']!= '' & $data['status']==0) {
        if(!empty($data['parent_id']) && $data['parent_id']!=1 && $data['status']==0) {
            $leger_parent = GrpLedgTree::findFirst(array("conditions" => "ledger_account_id = ?0 AND soc_id = ?1","bind" => array(0 => $data['parent_id'], 1 => $soc_id )));
            $data['parent_id'] = $leger_parent->parent_id;
        } else {
            $data['parent_id'] = 0;
        }
        
        if ( $leger_parent ) {
            $leger_parent->status = 1;           
            $leger_parent->save();
        }
        }

        if ( $ledger ) {
            if ($ledger->status == 0) {
                $ledger->status = 1;
                $flag = 1;
            } else {            
                $ledger->status = 0;           
            }
            
            $ledger->save();
        }  
        if($flag != 1) {
        $this->_getLedgerChildren($group_id, $ledger->status );
        }
       
        
    }
    
    /**
     * The Component action `_getLedgerChildren` is to get children
     * @method _getLedgerChildren.
     * @access public
     * @param integer $id
     * @param string $status
     * @see _getLedgerChildren()
     * @uses ChsOne\Models\GrpLedgTree::__construct()
     */
    private function _getLedgerChildren($id, $status)
    {
        $soc_id = $this->_di->getShared("session")->get("auth")["soc_id"];
        $ledger = GrpLedgTree::find(array("conditions" => "parent_id = ?0 AND soc_id = ?1","bind" => array(0 => $id, 1 => $soc_id )));
        foreach ($ledger as $ldg) {
            
            $ldg->status = $status;
            if ( $ldg->save() ) {
                
            } else {
                
            }
            $this->_getLedgerChildren($ldg->ledger_account_id, $status);
            
        }
    }
    
    /**
     * The Component action `getGroupId` is to get parent array
     * @method getGroupId.
     * @access public
     * @param string $grpname
     * @param boolean $cntxt DEFAULT FALSE
     * @var integer $soc_id society id
     * @uses ChsOne\Models\GrpLedgTree::__construct()
     * @return boolean
     */
    public function getGroupId($grpname, $cntxt = FALSE)
    {
        $soc_id     = $this->session->get("auth")["soc_id"];
        $conditions = "soc_id = ?1";
        $bind[1]    = $soc_id; 
        
        if ($cntxt) {
            $conditions .= " AND LOWER(context) = ?2";
          
        } else {
            $conditions .= " AND LOWER(ledger_account_name) = ?2";
        }
        
          $bind[2]     = strtolower($grpname);
        
        $parent = GrpLedgTree::findFirst(array("conditions" => $conditions,"bind" => $bind));
            
        if ($parent) {
            return $parent;
        } else {
            return FALSE;
        }
        
    }
    
    /**
     * The Component action `getAllLedgers` is to get ledgers
     * @method getAllLedgers.
     * @access public
     * @param string $type
     * @param string $entity_type
     * @uses ChsOne\Models\GrpLedgTree::__construct()
     * @return type
     */
    public function getAllLedgers($type = "", $entity_type = "")
    {
        $i = 1;
        $conditions = "status = ?$i";
        $bind[$i] = 1;
        ++$i;
        
        $soc_id = $this->session->get("auth")["soc_id"];
        $conditions .= " AND soc_id = ?$i ";
        $bind[$i] = $soc_id;
        ++$i;
        
        if ($entity_type == ENTITY_TYPE_GROUP) {
            $conditions .= " AND LOWER(TRIM(entity_type)) = ?$i";
            $bind[$i] = ENTITY_TYPE_GROUP;
        } elseif ($entity_type == ENTITY_TYPE_LEDGER) {
            $conditions .= " AND LOWER(TRIM(entity_type)) = ?$i";
            $bind[$i] = ENTITY_TYPE_LEDGER;
        } elseif ($entity_type == ENTITY_TYPE_MAIN) {
            $conditions .= " AND LOWER(TRIM(entity_type)) = ?$i";
            $bind[$i] = ENTITY_TYPE_MAIN;
        }
          
        ++$i;
        
        switch ($type) {
            case EXPENSES_MODULE:
                $conditions .= " AND LOWER(TRIM(behaviour)) = ?$i";
                $bind[$i] = EXPENSES_MODULE;
                break;
            case LIABILITY:
                $conditions .= " AND LOWER(TRIM(behaviour)) = ?$i";
                $bind[$i] = LIABILITY;
                break;
            case INCOME:
                $conditions .= " AND LOWER(TRIM(behaviour)) = ?$i";
                $bind[$i] = INCOME;
                break;
            case ASSET:
                $conditions .= " AND LOWER(TRIM(behaviour)) = ?$i";
                $bind[$i] = ASSET;
                break;
        }
        
        $ledgers = GrpLedgTree::find(array("conditions" => $conditions, "bind" => $bind));
        return $ledgers->toArray();
    }

    /**
     * The Component action `getLedgFrmContxt` is to get default ledger tree
     * @method getLedgFrmContxt.
     * @access public
     * @param string $context
     * @uses ChsOne\Models\GrpLedgTree::__construct()
     * @see _getGrpChildren()
     * @return boolean
     */
    public function getLedgFrmContxt($context)
    {        
        $soc_id = $this->session->get("auth")["soc_id"];
        $conditions = "soc_id = ?0 AND LOWER(ledger_account_name) = ?1 ";
        $bind[0]    = $soc_id;
        $bind[1]    = strtolower($context);        
        
        $ledgers = GrpLedgTree::findFirst(array("conditions" => $conditions, "bind" => $bind));
        $out =  $ledgers;    
        
        if (!empty($out)) {
            $res = $this->_getGrpChildren($out->ledger_account_id,ENTITY_TYPE_LEDGER);
            return $res;
        } else {
            return FALSE;
        }
    }
    
    /**
     * The Component action `getLedgTree` is to get ledger tree
     * @method getLedgTree.
     * @access public
     * @param string $context
     * @see _getLedGrpListRecur()
     * @uses ChsOne\Models\GrpLedgTree::__construct()
     * @return boolean
     */
    public function getLedgTree($context)
    {
        $soc_id = $this->session->get("auth")["soc_id"];
        $conditions = "soc_id = ?0 AND LOWER(ledger_account_name) = ?1";
        $bind[0]    = $soc_id;
        $bind[1]    = strtolower($context);
            
        $ledgers = GrpLedgTree::find(array("conditions" => $conditions, "bind" => $bind, "orderby" => "parent_id asc"));
        $out =  $ledgers;    
        
        if (!empty($out)) {
            $ret_arr = $this->_getLedGrpListRecur($ledgers->toArray());
            return $res;
        } else {
            return FALSE;
        }
    }
    
    /**
     * The Component action `deleteSocDefLedgStructure` is to delete society ledger structure
     * @method deleteSocDefLedgStructure.
     * @access public
     * @param INT $soc_id
     * @uses ChsOne\Models\GrpLedgTree::__construct()
     */
    public function deleteSocDefLedgStructure($soc_id)
    {
        
        $conditions = "soc_id = ?0";
        $bind[0]    = $soc_id;        
        
        $ledgers = GrpLedgTree::find(array("conditions" => $conditions, "bind" => $bind));
        
        if (!$ledgers->delete())
        {
            foreach ($ledgers->getMessages() as $message)
            {
                echo $message."<br>";
            }
            exit;
        } else {
            echo "deleted old records <br>";
        }
    }
    
    /**
     * 
     * The Component action `getRootLedgers` is to get all parents
     * @method getRootLedgers.
     * @access public
     * @uses ChsOne\Models\GrpLedgTree::__construct()
     * @return type
     */
    public function getRootLedgers()
    {
        $soc_id     = $this->session->get("auth")["soc_id"];
        $ledgers = GrpLedgTree::find(array("conditions"=>"parent_id = ?1 AND soc_id = ?2", "bind"=>array(1=>0, 2=>$soc_id)));
        
        foreach ($ledgers as $ledger) {
            $behaviour = trim(strtolower($ledger->behaviour));
            $main_array[$behaviour]["ledger_account_name"] = $ledger->ledger_account_name;
            $main_array[$behaviour]["soc_id"] = $ledger->soc_id;
            $main_array[$behaviour]["nature_of_account"] = $ledger->nature_of_account;
            $main_array[$behaviour]["report_head"] = $ledger->report_head;
            $main_array[$behaviour]["entity_type"] = $ledger->entity_type;
            $main_array[$behaviour]["defined_by"] = $ledger->defined_by;
            $main_array[$behaviour]["ledger_account_id"] = $ledger->ledger_account_id;
        }
        
        return $main_array;
    }
    
    /**
     * 
     * The Component action `_checkGroupNameDuplication` is to check group name duplication
     * @method _checkGroupNameDuplication.
     * @access public
     * @param type $parent
     * @param type $name
     * @uses ChsOne\Models\GrpLedgTree::__construct()
     */
    private function _checkGroupNameDuplication($parent, $name, $ledg_id = "", $update_led_id = "")
    {
        
        $soc_id    = $this->session->get("auth")["soc_id"];
        $conditions = "soc_id = ?0 AND LOWER(ledger_account_name) = ?1";
        $bind[0]    = $soc_id;
        //$bind[1]    = $parent; 
        $bind[1]    = strtolower(trim($name));            
        
        if ($ledg_id) {
            $conditions .= " AND ledger_account_id != ?2";
            $bind[2]     = $ledg_id;
        }
        if ($update_led_id) {
            $conditions .= " AND ledger_account_id != ?2";
            $bind[2]     = $update_led_id;
        }
        $ledgerscount  = GrpLedgTree::find(array($conditions, "bind" => $bind));
            
        $ledgers_count = count($ledgerscount);
            
        return $ledgers_count;    
    }
    
    /**
     * 
     * The Component action `getLastChild` is to Get Last child of given parent
     * @method getLastChild.
     * @access public
     * @param integer $parent_id group or Main id for which the children are sought
     * @return array|boolean
     * @uses ChsOne\Models\GrpLedgTree::__construct()
     */
    public function getLastChild($parent_id)
    {
        $soc_id     = $this->session->get("auth")["soc_id"];
        $ledgers    = GrpLedgTree::find(array("conditions"=>"parent_id = ?1 AND soc_id = ?2", "bind"=>array(1=>$parent_id, 2=>$soc_id), "order" => "ledger_account_id desc"));
        
        if ($ledgers) {
            $arr     = $ledgers->toArray();
            $last_rc = isset($arr[1]) ? $arr[1] : "";
            
            return is_array($last_rc) ? $last_rc : FALSE;
        } else {
            return FALSE;
        }
        
    }
    
    
    /**
     * The Component action `getBankledger` is to Get bank ledgers 
     * @method getBankledger.
     * @access public
     * @param string $context 
     * @uses ChsOne\Models\GrpLedgTree::__construct()
     * @return array
     */
    public function getBankledger($context = 'bank')
    {
        $soc_id    = $this->session->get("auth")["soc_id"];
        $conditions = "soc_id = ?0 AND context = ?1 AND entity_type = ?2 ";
        $bind[0]    = $soc_id;
        $bind[1]    = $context;
        $bind[2]    = "ledger";
        
        $bankledger  = GrpLedgTree::find(array($conditions, "bind" => $bind));     
             if ($bankledger) {
                    return $bankledger->toArray();
             } else {
                 return FALSE;
             }
            
    }
    
    
}

