<?php

require_once 'dompdf/autoload.inc.php';

use Dompdf\Dompdf;

class Pdf extends Dompdf
{
  public function __construct()
  {
    parent::__construct();
  }
}


if (isset($_POST['report-content']) && $_POST['report-content'] != "") {
  $file_name = "report.pdf";
  $html = '<style>
    * {
        margin: 0;
        padding: 0;
        font-size: 100%;
        vertical-align: baseline;
        border: 0;
    }
    
    table .padding-left {
        text-align: center;
    }
    
    .table-container {
        overflow-y: auto;
        margin: 10px 2%;
        width: 95%;
      }
      
      table {
        width: 100%;
        text-align: left;
        border-spacing: 0;
      }
      
      table th,
      table td {
        border: 0.5px solid black;
      }
      
      table th,
      table td {
        line-height: 50px;
      }
      
      #subject-container {
        padding: 5px 0 24px;
        margin: auto;
        text-align: center;
        width: fit-content;
      }
      
      #subject-container h1 {
        font-size: 25px;
        padding-bottom: 6px;
      }
      
      #subject-container h2 {
        font-size: 21px;
      }

      #piechart {
        display: none;
      }
      
      #chart-container {
        margin: auto;
      }
      
      </style>';
  $html .= $_POST['report-content'];
  $pdf = new Pdf();
  $pdf->loadHtml($html);
  $pdf->render();
  $pdf->stream($file_name, array("Attachment" => false));
}