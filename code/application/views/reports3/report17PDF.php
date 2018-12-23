<?php
//require('fpdf.php');

class PDF extends FPDF
{
    public function __construct($orientation = 'P', $unit = 'mm', $size = 'A4')
    {
        parent::__construct($orientation, $unit, $size);
        $this->AddFont('THSarabunNew','','THSarabunNew.php');
        $this->AddFont('THSarabunNew','B','THSarabunNew_b.php');

    }

    function txtThai($msg) {
        return iconv('UTF-8', 'cp874', $msg);
    }

    private $fontSizeNormal = 14;

    function Title() {
        $title = 'รายงานจำนวนสมาชิกสหกรณ์ทั้งหมด แยกตามจังหวัด';
        $subTitle = 'จำนวนสมาชิกของสหกรณ์ 4,950,494 คน';

//        $this->SetFont('Arial','B',15);
        $w = $this->GetStringWidth($title)+6;
//        $this->SetX((210-$w)/2);

        $this->SetY(12);
//        $this->SetLineWidth(1);
        $this->upfont('B', $this->fontSizeNormal+4);
        $this->SetX(60);
        $this->Cell(1,9,$this->txtThai($title));
        $this->ln();
        $this->upfont('B', $this->fontSizeNormal+2);
        $this->SetX(73);
        $this->Cell(1,9,$this->txtThai($subTitle));

        $this->Ln();
//        $this->Ln();
//
////        $this->SetX(1);
//        $this->Cell(40,5,' ','LTR',0,'L',0);   // empty cell with left,top, and right borders
//        $this->Cell(50,5,'111 Here',1,0,'L',0);
//        $this->Cell(50,5,'222 Here',1,0,'L',0);
//
//        $this->Ln();
//
//        $this->Cell(40,5,'Solid Here','LR',0,'C',0);  // cell with left and right borders
//        $this->Cell(50,5,'[ o ] che1','LR',0,'L',0);
//        $this->Cell(50,5,'[ x ] che2','LR',0,'L',0);
//
//        $this->Ln();
//
//        $this->Cell(40,5,'','LBR',0,'L',0);   // empty cell with left,bottom, and right borders
//        $this->Cell(50,5,'[ x ] def3','LRB',0,'L',0);
//        $this->Cell(50,5,'[ o ] def4','LRB',0,'L',0);
//
//        $this->Ln();
//        $this->Ln();
//        $this->Ln();

//        $w = $this->GetStringWidth($title);
//        $this->SetX((210-$w)/2);
//        $this->SetFont('THSarabunNew','B',16);
//        // Colors of frame, background and text
//
//        // Thickness of frame (1 mm)
//        $this->SetLineWidth(1);
//        // Title
////        $this->Cell($w,9,$title,1,1,'C',true);
////        $this->Cell($w,9, $this->txtThai($title));
//        $this->Cell($w,9, $title);
//        $this->Cell(1,10,$this->txtThai($title),0,1,'C');


        // Line break
//        $this->Ln(10);
    }

    function upfont($style, $size) {
        $this->SetFont('THSarabunNew',$style,$size);
    }

    function DrawTable() {

        $header = array("เขตตรวจราชการ", "จังหวัด", "จำนวนสมาชิกปกติ(คน)", "จำนวนสมาชิกตาย(คน)");
        $w = array(40, 35, 55, 55);
        $this->upfont('B', $this->fontSizeNormal);
        $this->SetX(15);
        $this->SetY($this->GetY() + 5);
        for($i=0;$i<count($header);$i++) {
            $this->Cell($w[$i],7, $this->txtThai($header[$i]),1,0,'C');
        }
        $this->Ln();
//        $this->Cell($w[$i],7, $this->txtThai($header[$i]),1,0,'C');

    }

// Load data
    function LoadData($file)
    {
        // Read file lines
        $lines = file($file);
        $data = array();
        foreach($lines as $line)
            $data[] = explode(';',trim($line));
        return $data;
    }

// Simple table
    function BasicTable($header, $data)
    {
        // Header
        foreach($header as $col)
            $this->Cell(40,7,$col,1);
        $this->Ln();
        // Data
        foreach($data as $row)
        {
            foreach($row as $col)
                $this->Cell(40,6,$col,1);
            $this->Ln();
        }
    }

// Better table
    function ImprovedTable($header, $data)
    {
        // Column widths
        $w = array(40, 35, 40, 45);
        // Header
        for($i=0;$i<count($header);$i++)
            $this->Cell($w[$i],7,$header[$i],1,0,'C');
        $this->Ln();
        // Data
        foreach($data as $row)
        {
            $this->Cell($w[0],6,$row[0],'LR');
            $this->Cell($w[1],6,$row[1],'LR');
            $this->Cell($w[2],6,number_format($row[2]),'LR',0,'R');
            $this->Cell($w[3],6,number_format($row[3]),'LR',0,'R');
            $this->Ln();
        }
        // Closing line
        $this->Cell(array_sum($w),0,'','T');
    }

// Colored table
    function FancyTable($header, $data)
    {
        // Colors, line width and bold font
        $this->SetFillColor(255,0,0);
        $this->SetTextColor(255);
        $this->SetDrawColor(128,0,0);
        $this->SetLineWidth(.3);
        $this->SetFont('','B');
        // Header
        $w = array(40, 35, 40, 45);
        for($i=0;$i<count($header);$i++)
            $this->Cell($w[$i],7,$header[$i],1,0,'C',true);
        $this->Ln();
        // Color and font restoration
        $this->SetFillColor(224,235,255);
        $this->SetTextColor(0);
        $this->SetFont('');
        // Data
        $fill = false;
        foreach($data as $row)
        {
            $this->Cell($w[0],6,$row[0],'LR',0,'L',$fill);
            $this->Cell($w[1],6,$row[1],'LR',0,'L',$fill);
            $this->Cell($w[2],6,number_format($row[2]),'LR',0,'R',$fill);
            $this->Cell($w[3],6,number_format($row[3]),'LR',0,'R',$fill);
            $this->Ln();
            $fill = !$fill;
        }
        // Closing line
        $this->Cell(array_sum($w),0,'','T');
    }
}

$pdf = new PDF();
$pdf->AddPage();
$pdf->Title();
$pdf->DrawTable();


$pdf->Cell(1, 1, json_encode($khet));
echo json_encode($khet);



//$pdf->AddFont('THSarabunNew','','THSarabunNew.php');
//$pdf->AddFont('THSarabunNew','B','THSarabunNew_b.php');

// Column headings


//$header = array('Country', 'Capital', 'Area (sq km)', 'Pop. (thousands)');
//// Data loading
//$data = $pdf->LoadData('countries.txt');
//$pdf->SetFont('Arial','',14);
//$pdf->AddPage();
//$pdf->BasicTable($header,$data);
//$pdf->AddPage();
//$pdf->ImprovedTable($header,$data);
//$pdf->AddPage();
//$pdf->FancyTable($header,$data);
//$pdf->Output();

//$pdf = new FPDF();
//$pdf->AddPage();
//
//$pdf->AddFont('THSarabunNew','','THSarabunNew.php');
//$pdf->AddFont('THSarabunNew','B','THSarabunNew_b.php');
//
//$pdf->SetFont('THSarabunNew','B',16);
////$pdf->SetFont('THSarabunNew','B',16);
//
//$pdf->Cell(40, 10, iconv('UTF-8', 'cp874', 'สวัสดี'));
//
////$pdf->Cell(40,10,'สวัสดีครับ');
//$pdf->Output();
?>


