<?php
// Include the main TCPDF library (search for installation path).
require_once('../TCPDF-main/tcpdf.php');

class MYPDF extends TCPDF
{
    // Load table data from database
    public function LoadData()
    {
        // Include and establish database connection
        include '../koneksi.php';
        $select = "SELECT * FROM orders";
        $result = mysqli_query($conn, $select);

        $data = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = $row;
        }
        mysqli_free_result($result);
        mysqli_close($conn);
        return $data;
    }

    // Colored table
    public function ColoredTable($header, $data)
    {
        // Colors, line width and bold font
        $this->SetFillColor(255, 0, 0);
        $this->SetTextColor(255);
        $this->SetDrawColor(128, 0, 0);
        $this->SetLineWidth(0.3);
        $this->SetFont('', 'B');

        // Header
        $w = array(12, 15, 30, 27, 25, 35, 25, 20); // Adjusted width for 'Customer Name' to 30
        $num_headers = count($header);
        for ($i = 0; $i < $num_headers; ++$i) {
            $this->MultiCell($w[$i], 10, $header[$i], 1, 'C', true, 0, '', '', true, 0, false, true, 10, 'M');
        }
        $this->Ln();

        // Color and font restoration
        $this->SetFillColor(200, 235, 255);
        $this->SetTextColor(0);
        $this->SetFont('');

        // Data
        $fill = 0;
        foreach ($data as $row) {
            $this->Cell($w[0], 15, $row["id"], 'LR', 0, 'L', $fill);
            $this->Cell($w[1], 15, $row["table_number"], 'LR', 0, 'L', $fill);
            $this->Cell($w[2], 15, $row["customer_name"], 'LR', 0, 'L', $fill);
            $this->Cell($w[3], 15, $row["customer_number"], 'LR', 0, 'L', $fill);
            $this->MultiCell($w[4], 15, $row["timestamp"], 'LR', 0, 'L', $fill);
            $this->MultiCell($w[5], 15, $row["pesanan"], 'LR', 0, 'L', $fill);
            $this->Cell($w[6], 15, $row["Total_Price"], 'LR', 0, 'L', $fill);
            $this->Cell($w[7], 15, $row["status"], 'LR', 0, 'L', $fill);
            $this->Ln();
            $fill = !$fill;
        }
        $this->Cell(array_sum($w), 0, '', 'T');
    }
}

// create new PDF document
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Warung Boboko');
$pdf->SetTitle('Tabel Pesanan Warung Boboko');

// set default header data
$pdf->SetHeaderData(
    "../img/logo.png",
    20,
    'Tabel Pesanan Warung Boboko'
);

// set header and footer fonts
$pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
    require_once(dirname(__FILE__) . '/lang/eng.php');
    $pdf->setLanguageArray($l);
}

// set font
$pdf->SetFont('helvetica', '', 12);

// add a page
$pdf->AddPage();

// column titles
$header = array(
    'ID',
    'Table',
    'Customer',
    'Phone',
    'Timestamp',
    'Pesanan',
    'Total',
    'Status'
);

// data loading
$data = $pdf->LoadData();

// print colored table
$pdf->ColoredTable($header, $data);

// close and output PDF document
$pdf->Output('RekapPenjualan.pdf', 'I');
