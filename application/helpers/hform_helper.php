<?php
function text($name,$placeholder,$class,$value=null,$tags=null)
{
    return "<input type='text' name='$name' class='span$class' value='$value' placeholder='$placeholder' />";
}

function dropdown($name,$table,$field,$pk,$kondisi,$selected=null,$data=null,$tags=null)
{
    $CI =& get_instance();
   echo"<select name='".$name."' class='form-control'>";
        if(!empty($data))
        {
            foreach ($data as $data_value => $id)
            {
                echo "<option value='$id'>$data_value</option>";
            }
        }
        if(empty($kondisi))
        {
            $record=$CI->db->get($table)->result();
        }
        else
        {
            $record=$CI->db->get_where($table,$kondisi)->result();
        }
        foreach ($record as $r)
        {
            echo " <option value='".$r->$pk."' ";
            echo $r->$pk==$selected?'selected':'';
            echo ">".strtoupper($r->$field)."</option>";
        }
            echo"</select>";
}