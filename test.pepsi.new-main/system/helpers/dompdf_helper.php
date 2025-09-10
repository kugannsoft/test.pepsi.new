<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

function pdf_create($html, $filename = '', $stream = TRUE, $paper = 'A4') {
    require_once("dompdf/dompdf_config.inc.php");

    $dompdf = new DOMPDF();
    $dompdf->set_paper($paper, "portrait");
    $dompdf->load_html($html);
    $dompdf->render();
    if ($stream) {
        $dompdf->stream($filename . ".pdf",array("Attachment" => false));
    } else {
        return $dompdf->output();
    }
}

?>