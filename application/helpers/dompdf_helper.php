<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
function pdf_create($html, $filename, $stream=TRUE) 
{
	require_once(APPPATH."/third_party/dompdf/dompdf_config.inc.php");    
    
    $dompdf = new DOMPDF();
    $dompdf->load_html($html);
    $dompdf->render();
    if ($stream) {
        
        
        $dompdf->stream($filename.".pdf", $stream);
    } else {
        //return $dompdf->output();
        $output = $dompdf->output();
        file_put_contents('assets/pdf/'.$filename.".pdf", $output);
    }
}
?>
