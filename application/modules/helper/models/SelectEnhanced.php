<?php
error_reporting(0);
/**
    * This class file is a form for select module. All SelectEnhanced related field are define here.
    *
    * PHP versions 5.5.9
    *
    * Project name CHSONE
    * @version 1: Forms/SelectEnhanced 2015-08-19 $
    * @copyright Copyright (C) 2015 Futurescape Technologies (P) Ltd
    * @license Copyright (C) 2015 Futurescape Technology
    * @license http://www.futurescapetech.com
    * @link http://www.futurescapetech.com
    * @category SelectEnhanced Form
    * @author Author <Futurescape Technologies>
    * @since File available since Release 1.0  
 */

/**
 * @package ChsOne\Forms
 */

/**
 * SelectEnhanced Form for initialize fields
 */
class SelectEnhanced {

	/**
	 * 
	 * @var array $optionsElement DEFAULT array()
	 * @access protected
	 */
    protected $optionsElement = array();
    /**
     * 
     * @var array $optopen DEFAULT zero
     * @access public
     */
    public $optopen = 0;
    
    /**
     * @method __construct
     * @access public
     * @param string $elementName
     * @param array $elementValues DEFAULT NULL
     * @param string $parameters DEFAULT NULL
     * @param string $group DEFAULT NULL
     */
    public function __construct($elementName, $elementValues = NULL, $parameters = NULL, $group = NULL) {

        //$this->setName($elementName);

        //adding empty option
        if($parameters['useEmpty']) {

            if(!isset($parameters['emptyText'])) {

                $parameters['emptyText'] = 'Choose...';
            }

            $this->addOption(array('value' => '', 'content' => $parameters['emptyText']));
        }


        if(!empty($parameters['options'])){
            $haveOptions = true;
        }
        else {
            $haveOptions = false;
        }


        // If we got data to generate optionElements
        if(!empty($elementValues)) {
           $spc = '&nbsp;&nbsp;';


            foreach($elementValues as $elementValue) {

                // Initialize optionElement parameters
                $optionParameters   =   array('value' => $elementValue['ledger_account_id'], 'content' => $spc . ucwords($elementValue['name']),'group' => $group);

                $child = array(); 
                $created = 0;
                $attributes = array();
                // If somes options are defined to set attributes on optionElements
                if($haveOptions) {

                    foreach($parameters['options'] as $attribute => $condition) {
                       
                        // If condition is string assign it to result
                        if (is_string($condition)) {
                            $result =   $condition;
                            
                        }
                        // Otherwise execute condition to get result
                        else if ( !is_array($condition)) {
                            $result    =   $condition($elementValue);
                            
                        }
                        else if ( isset($condition['type']) && $condition['type'] == GROUP_CHILDREN_OPTION_DIS) {
                                                        
                           // $optionParameters[$attribute] = $result;
                            $result = GROUP_CHILDREN_OPTION_DIS;
                            $attributes = $condition['options'];
                        }
                         

                        // if condition is passed we had attribute with his value
                        if($result) {
                            if ( $result != GROUP_CHILDREN_OPTION_DIS) {
                                 $optionParameters[$attribute] = $result;
                            } else {
                               $flgs = 0;
                               $this->_groupChildrenOptns($optionParameters, $elementValue['children'], $attributes, $group);                               
                               $created = 1;
                               
                            }

                            
                        }
                    }
                }
                 
                if($created == 0) {
                    // add optionElement with parameters
                    $this->addOption($optionParameters);
                 }
            }


        }
        //echo "tt";exit;

    }

    /**
     * Forming select box
     * @method render
     * @access public
     * @param array $attributes DEFAULT NULL
     * @return string
     */
    public function render($attributes = null,$name,$id,$class) {

        // Set new attributes passed in parameter
        //$attributes = $this->prepareAttributes($attributes);
        
       /* if(!empty($attributes)) {
            foreach($attributes as $attrName => $attrValue) {
                if ($attrName != 0) {   
                    $this->setAttribute($attrName, $attrValue);
                }
            }
        }*/


        $html = '<select name="'.$name.'" '. 'id="'.$id.'"' . 'class="'.$class.'"';
        $selected = '';
        
        
        // write every attributes of select element in DOM
       // $attributes = $this->getAttributes();
        
        if(!empty($attributes)) {
            foreach($attributes as $attrName => $attrValue) {
                if ( $attrName == 'selected') { 
                     $selected = $attrValue;
                } else { 
                    $html .= ' '.$attrName.'="'.$attrValue.'"';
                }
                
               
            }
        }

        $html .= '>';

        if(!empty($this->optionsElement)) {

            foreach($this->optionsElement as $optionElement) {

                // extract value an content from optionElement
                $value  =  $optionElement['value'];                
                unset($optionElement['value']);
                $content = $optionElement['content'];
                unset($optionElement['content']);

                if (isset($optionElement['group']) && $optionElement['group'] == 'head') {
                                        
                    if ($optionElement['group'] == 'head') {
                        if($this->optopen == 1) {
                           $html .= '</optgroup>';
                           $this->optopen = 0;
                           
                        } else {
                            
                            $this->optopen = 1;
                            
                        }
                        
                         $html .= '<optgroup label="'.$content.'" parent_id="' . $value . '">';
                       
                        
                    }
                    
                    unset($optionElement['group']);
                    
                    
                } else {
                    
                    $html .= '<option value="'.$value.'"' ;

                    // write every attributes of optionElement in DOM
                    if(!empty($optionElement)) {

                       foreach($optionElement as $attrName => $attrValue) {
                           $html .= ' '.$attrName.'="'.$attrValue.'"';
                        }
                    }

                    /*if ($selected == $value) {
                        $html .= ' selected="selected" ';
                        unset($selected);
                    }*/
                    $html .= '>';

                    $html .= ucwords($content).'</option>'; 
                
                }
                
                
                
            }
        }

        $html .=  '</select>';
        //var_dump($html);
        return $html;

    }

    /**
     * adding options in select
     * @method addOption
     * @access public
     * @param array $parameters
     */
    public function addOption($parameters) {
         
        if (isset($parameters['value']) == '0') {
            $needle = current($this->optionsElement);
            if( $needle['value'] == '') { 
                $arr = array_shift($this->optionsElement);
            }
            
            array_unshift($this->optionsElement, $parameters);
            array_unshift($this->optionsElement, $needle);
        } else {
            array_push($this->optionsElement, $parameters);
        }        
        
    }

    /**
     * Recursive function to form default structure
     * @method _groupChildrenOptns
     * @access public
     * @global integer $flgs
     * @param string $optionParameters
     * @param array $elemnts
     * @param array $attributes
     * @param string $group
     * @param string $space
     * @param integer $level DEFAULT 1
     * @see _groupChildrenOptns(),addOption()
     */
    private function _groupChildrenOptns($optionParameters, $elemnts, $attributes = array(), $group, $space= ' &nbsp;', $level=1)
    {
        global $flgs;
        if ($group == 'optgroup') {
           $optionParameters['group'] = "head";  
        }
        $child = array();
        if($optionParameters !=''){
            $this->addOption($optionParameters);
        }
        $parent = isset($optionParameters['value']) ? $optionParameters['value'] : "";
        if (!empty($elemnts)) {//echo "<pre>";print_r($elemnts);exit;
            foreach($elemnts as $children){
                /*if (isset($children['children']) && !empty($children['children'])) {
                    $arr['parent_id']['space'] = $arr['parent_id']['space']+1;
                    
                } else if ($parent == $children['parent_id']) {
                    $arr['parent_id']['space'] = 0;
                    $space = " &nbsp; --";
                } else {
                    
                }
                $arr['parent_id']['cnt']   = count($children['children']);
                $arr['parent_id']['child'] = $arr['parent_id']['child']+1;  */
                
                if ($children['status'] == 1) {
                    $levels = "&nbsp;" . str_repeat ( '&nbsp;', ($level-1) );
                    
                    $optionParameters2   =   array('value' => $children['ledger_account_id'], 'content' => '&nbsp;   &nbsp;'. $levels. $children['name']);
                    if ($group == 'optgroup') {
                            $optionParameters2['group'] = "child";  
                    }

                    foreach($attributes as $attribute => $condition) {
                             //print_r($condition); 
                            // If condition is string assign it to result
                            if (is_string($condition)) { 
                                $result =   $condition;                            
                            }
                            // Otherwise execute condition to get result
                            else if ( !is_array($condition)) {
                                $result    =   $condition($children);

                            } else if ( isset($condition['type']) && isset($condition['type']) == GROUP_CHILDREN_OPTION_DIS) {
                                $result = GROUP_CHILDREN_OPTION_DIS;
                                $attributes = $condition['options'];
                            }

                            // if condition is passed we had attribute with his value
                            if($result) {
                                if ( $result != GROUP_CHILDREN_OPTION_DIS) { 
                                    $optionParameters2[$attribute] = $result;
                                } else {
                                  // $flags = 0;
                                   // $this->_groupChildrenOptns($optionParameters, $elementValue['children'], $attributes, $group);                               
                                  //  $created = 1;

                                }


                                }
                            }

                    if(isset($children['children']) && $group == 'optgroup'){//echo "<pre>";print_r($optionParameters2);exit;
                        $optionParameters2['group'] = "head";

                    } 
                    if ($children['entity_type'] == "group" && $group == 'optgroup') {
                         $optionParameters2['group'] = "head";
                         $space = " &nbsp;";
                    } 
                    $this->addOption($optionParameters2);
                    if(isset($children['children'])){//echo "<pre>";print_r($optionParameters2);exit;
                     
                        $this->_groupChildrenOptns('', $children['children'], $attributes, $group, $space, $level + 1); 
                    } 
                }   
                
                //$flgs = 0;

            }
        }
         
    }
    
    
    
    /**
     * Recursive function to form default structure
     * @method _groupChildrenOptnsOld
     * @access public
     * @global integer $flgs
     * @param string $optionParameters
     * @param array $elemnts
     * @param array $attributes
     * @param string $group
     * @param string $space
     * @see _groupChildrenOptns(),addOption()
     */
    private function _groupChildrenOptnsOld($optionParameters, $elemnts, $attributes = array(), $group, $space= ' -')
    {
        global $flgs;
        if ($group == 'optgroup') {
           $optionParameters['group'] = "head";  
        }
        
        if ($flgs == 0) {
            $flgs = 1;
        } else {
            $space = '&nbsp;--';
        }
        $child = array();
        if($optionParameters !=''){
        $this->addOption($optionParameters);
        }
        $pages['children'] = $elemnts;
        //$space = ' -';
        $spc = '&nbsp;&nbsp;&nbsp;';
        do {
            $i = 0;
            $childrens = $pages['children'];
            if (isset($childrens)){
                
                
                foreach($childrens as $children) {
              
               // Initialize optionElement parameters
                $optionParameters2   =   array('value' => $children['ledger_account_id'], 'content' => $children['ledger_account_id'].$spc . $space . '&nbsp' . $children['name'].'--'.$children['parent']);
                if ($group == 'optgroup') {
                    $optionParameters2['group'] = "child";  
                }
                foreach($attributes as $attribute => $condition) {
                     //print_r($condition); 
                    // If condition is string assign it to result
                    if (is_string($condition)) { 
                        $result =   $condition;                            
                    }
                    // Otherwise execute condition to get result
                    else if ( !is_array($condition)) {
                        $result    =   $condition($children);
                            
                    } else if ( isset($condition['type']) && isset($condition['type']) == GROUP_CHILDREN_OPTION_DIS) {
                        $result = GROUP_CHILDREN_OPTION_DIS;
                        $attributes = $condition['options'];
                    }

                    // if condition is passed we had attribute with his value
                    if($result) {
                        if ( $result != GROUP_CHILDREN_OPTION_DIS) { 
                            $optionParameters2[$attribute] = $result;
                        } else {
                          // $flags = 0;
                           // $this->_groupChildrenOptns($optionParameters, $elementValue['children'], $attributes, $group);                               
                          //  $created = 1;
                               
                        }

                            
                        }
                    }
                // add optionElement with parameters
                $this->addOption($optionParameters2);
                if(isset($children['children'])){
                   //$i++;
                   //$space .= '-';
                    $flags = 0;
                   $pages['children'] = $children['children'];
                   $this->_groupChildrenOptns('', $children['children'], $attributes, $group);                               
                           
                   //break;
                }
            }
                
            } 
            

        } while ($i>0);
        
        return $child;

    }
}