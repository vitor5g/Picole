<?php

include_once "../model/Historico_Venda.php";
include_once "../model/Historico_VendaDAO.php";
include_once "./fpdf/fpdf.php";
date_default_timezone_set('America/Bahia');


try {

    $data_inicio = $_POST['data_inicio'];
    $data_fim = $_POST['data_fim'];
    $nome_cliente = trim($_POST['nome_cliente']);
    $sabor_picole = trim($_POST['sabor_picole']);
    $tipo = trim($_POST['radiobtn']);
    $pdf = new FPDF();

    
    if($tipo == 'cliente'){
        $dtos = Historico_VendaDAO::read(" data_venda between ". "'" .$data_inicio. " 00:00:00". "'" ." AND ". "'" .$data_fim. " 23:59:59 "."'". " AND nome_cliente = "."'".$nome_cliente."'",'nome_cliente');
        $pdf->AddPage();
        $pdf->SetFont('Arial','B', 18);
        $pdf->Cell(80);
        $pdf->Cell(30,10,'Relatório por Cliente',0, 0, 'C');
        $pdf->Ln(15);
        $pdf->SetFont("Arial", 'B', 8);
        //$pdf->Cell(40);
        $pdf->Cell(30,7,"Nome",1,0,"C");
        $pdf->Cell(18,7,"Apelido",1,0,"C");
        $pdf->Cell(28,7,"Setor",1,0,"C");
        $pdf->Cell(25,7,"Picolé",1,0,"C");
        $pdf->Cell(18,7,"Preço",1,0,"C");
        $pdf->Cell(18,7,"Quantidade",1,0,"C");
        $pdf->Cell(18,7,"Total",1,0,"C");
        $pdf->Cell(35,7,"Data da Venda",1,0,"C");
        $pdf->SetFont("Arial", '', 8);
        $pdf->Ln();
        foreach($dtos as $key => $value){
            $pdf->Cell(30,7,utf8_decode($value->nome_cliente),1,0,"C");
            $pdf->Cell(18,7,utf8_decode($value->apelido_cliente),1,0,"C");
            $pdf->Cell(28,7,utf8_decode($value->setor_cliente),1,0,"C");
            $pdf->Cell(25,7,utf8_decode($value->sabor_picole),1,0,"C");
            $pdf->Cell(18,7,"R$ ".$value->preco_picole,1,0,"C");
            $pdf->Cell(18,7,$value->quantidade_picole,1,0,"C");
            $pdf->Cell(18,7,"R$ ".$value->total,1,0,"C");
            $pdf->Cell(35,7,date('d/m/Y H:i:s',strtotime($value->data_venda)),1,0,"C");
            $pdf->Ln();
            
        }
        $pdf->Footer();
        $pdf->SetFont('Arial', 'I', 10);
        $pdf->Cell(0, 10, 'Data de Emissão: '. date("d/m/Y H:i:s"), 0, 0, 'L');
        $pdf->Cell(0, 10, 'Pagina: ' . $pdf->PageNo(), 0, 0, 'R');
        $pdf->Output();

    }else if($tipo == 'picole'){
        $dtos = Historico_VendaDAO::read(" data_venda between ". "'" .$data_inicio. " 00:00:00". "'" ." AND ". "'" .$data_fim. " 23:59:59 "."'". " AND sabor_picole = "."'".$sabor_picole."'",'sabor_picole');
        $pdf->AddPage();
        $pdf->SetFont('Arial','B', 18);
        $pdf->Cell(80);
        $pdf->Cell(30,10,'Relatório por Picolé',0, 0, 'C');
        $pdf->Ln(15);
        $pdf->SetFont("Arial", 'B', 8);
        //$pdf->Cell(40);
        $pdf->Cell(30,7,"Nome",1,0,"C");
        $pdf->Cell(18,7,"Apelido",1,0,"C");
        $pdf->Cell(28,7,"Setor",1,0,"C");
        $pdf->Cell(25,7,"Picolé",1,0,"C");
        $pdf->Cell(18,7,"Preço",1,0,"C");
        $pdf->Cell(18,7,"Quantidade",1,0,"C");
        $pdf->Cell(18,7,"Total",1,0,"C");
        $pdf->Cell(35,7,"Data da Venda",1,0,"C");
        $pdf->SetFont("Arial", '', 8);
        $pdf->Ln();
        foreach($dtos as $key => $value){
            $pdf->Cell(30,7,utf8_decode($value->nome_cliente),1,0,"C");
            $pdf->Cell(18,7,utf8_decode($value->apelido_cliente),1,0,"C");
            $pdf->Cell(28,7,utf8_decode($value->setor_cliente),1,0,"C");
            $pdf->Cell(25,7,utf8_decode($value->sabor_picole),1,0,"C");
            $pdf->Cell(18,7,"R$ ".$value->preco_picole,1,0,"C");
            $pdf->Cell(18,7,$value->quantidade_picole,1,0,"C");
            $pdf->Cell(18,7,"R$ ".$value->total,1,0,"C");
            $pdf->Cell(35,7,date('d/m/Y H:i:s',strtotime($value->data_venda)),1,0,"C");
            $pdf->Ln();
            
        }
        $pdf->Footer();
        $pdf->SetFont('Arial', 'I', 10);
        $pdf->Cell(0, 10, 'Data de Emissão: '. date("d/m/Y H:i:s"), 0, 0, 'L');
        $pdf->Cell(0, 10, 'Pagina: ' . $pdf->PageNo(), 0, 0, 'R');
        $pdf->Output();
    }else{
        $dtos = Historico_VendaDAO::read(" data_venda between ". "'" .$data_inicio. " 00:00:00". "'" ." AND ". "'" .$data_fim. " 23:59:59 "."'",'nome_cliente');
        $pdf->AddPage();
        $pdf->SetFont('Arial','B', 18);
        $pdf->Cell(80);
        $pdf->Cell(30,10,'Relatório Completo',0, 0, 'C');
        $pdf->Ln(15);
        $pdf->SetFont("Arial", 'B', 8);
        //$pdf->Cell(40);
        $pdf->Cell(30,7,"Nome e Sobrenome",1,0,"C");
        $pdf->Cell(18,7,"Apelido",1,0,"C");
        $pdf->Cell(25,7,"Setor",1,0,"C");
        $pdf->Cell(25,7,"Picolé",1,0,"C");
        $pdf->Cell(18,7,"Preço",1,0,"C");
        $pdf->Cell(18,7,"Quantidade",1,0,"C");
        $pdf->Cell(18,7,"Total",1,0,"C");
        $pdf->Cell(35,7,"Data da Venda",1,0,"C");
        $pdf->SetFont("Arial", '', 8);
        $pdf->Ln();
        foreach($dtos as $key => $value){
            $pdf->Cell(30,7,utf8_decode($value->nome_cliente),1,0,"C");
            $pdf->Cell(18,7,utf8_decode($value->apelido_cliente),1,0,"C");
            $pdf->Cell(25,7,utf8_decode($value->setor_cliente),1,0,"C");
            $pdf->Cell(25,7,utf8_decode($value->sabor_picole),1,0,"C");
            $pdf->Cell(18,7,"R$ ".$value->preco_picole,1,0,"C");
            $pdf->Cell(18,7,$value->quantidade_picole,1,0,"C");
            $pdf->Cell(18,7,"R$ ".$value->total,1,0,"C");
            $pdf->Cell(35,7,date('d/m/Y H:i:s',strtotime($value->data_venda)),1,0,"C");
            $pdf->Ln();
            
        }
        $pdf->Footer();
        $pdf->SetFont('Arial', 'I', 10);
        $pdf->Cell(0, 10, 'Data de Emissão: '. date("d/m/Y H:i:s"), 0, 0, 'L');
        $pdf->Cell(0, 10, 'Pagina: ' . $pdf->PageNo(), 0, 0, 'R');
        $pdf->Output();
    }

  



    
      
        
} catch (\Throwable $th) {
    http_response_code(500);
    echo $th->getMessage();
}