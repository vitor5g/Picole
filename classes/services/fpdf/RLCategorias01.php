<?php

require('fpdf.php');
//Localização
date_default_timezone_set('America/Bahia');

class PDF extends FPDF {

// Page header
    function Header() {
        // Logo
        //$this->Image('Logo_IBP.png', 10, 10, 50);
        //$this->Image('Logo_Invent.png', 152, 10, 50);

        // Arial bold 15
        $this->SetFont('Arial', '', 12);
        // Move to the right
        $this->Cell(80);
        // Title
        $this->Cell(30, 60, 'Lista de Categorias', 0, 0, 'C');
        // Line break
        $this->Ln(40);
    }

    // Simple table
    function FancyTable($header) {
        // Header
        // Colors, line width and bold font
        $this->SetFillColor(0, 175, 240, 1);
        $this->SetTextColor(255);
        $this->SetDrawColor(0, 0, 0, 0);
        $this->SetLineWidth(.1);
        $this->SetFont('Arial', 'B', 10);
        // Header
        $w = array(70, 120);
        for ($i = 0; $i < count($header); $i++)
            $this->Cell($w[$i], 7, $header[$i], 1, 0, 'C', true);
        $this->Ln();
        // Color and font restoration
        $this->SetFillColor(221, 239, 246, 1);
        $this->SetTextColor(0);
        $this->SetFont('');
        // Data
        $fill = false;
        // Data
        /* foreach ($data as $row) {
          foreach ($row as $col)
          $this->Cell(40, 6, $col, 1);
          $this->Ln();
          } */
        //Requiro a conexão com o banco
        //require_once("../../database/config.php");


//Preparo SQL de Busca  
        //$tb = $conn->prepare("SELECT categoria, descricao FROM categoria_patrimonio ORDER BY categoria");


//Executa comando SQL
        //$tb->execute();
        //$quebralinha = 0;
        // while ($l = $tb->fetch(PDO::FETCH_ASSOC)) {
        //     $quebralinha++;
        //     $this->Cell($w[0], 6, $l["categoria"], 'LRBT', 0, 'L', $fill);
        //     $this->Cell($w[1], 6, $l["descricao"], 'LRBT', 0, 'C', $fill);
        //     $this->Ln();
        //     $fill = !$fill;
        // }
        // Closing line
        $this->Cell(array_sum($w), 0, '', 'T');
    }

// Page footer
    function Footer() {
        // Position at 1.5 cm from bottom
        $this->SetY(-20);
        // Arial italic 8
        $this->SetFont('Arial', 'I', 8);
        // Page number
        // Page number
        $this->Cell(0, 10, 'Documento:', 0, 0, 'L');
        $this->Cell(0, 10, 'Data de Emissão:', 0, 0, 'R');
        $this->Ln(3);

        $this->Cell(0, 10, 'Lista de Categorias', 0, 0, 'L');
        $this->Cell(-190, 10, 'Pag ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
        $this->Cell(0, 10, date("j-n-Y H:i:s"), 0, 0, 'R');
    }

}

// Instanciation of inherited class
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();

// Column headings
$header = array('Categorias', 'Descrição');


$pdf->FancyTable($header);

$pdf->SetFont('Times', '', 10);
// Move to the right



$pdf->Output('I', 'Lista de Categorias (Emitido em ' . date("j-n-Y H:i:s") . ').pdf', true);
?>