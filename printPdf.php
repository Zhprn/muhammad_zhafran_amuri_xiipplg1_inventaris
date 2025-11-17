<?php
require('fpdf/fpdf.php');
include 'koneksi.php';
session_start();

$query = mysqli_query($koneksi,"
    SELECT items.*, categories.nama_kategori 
    FROM items
    JOIN categories ON items.id_categories = categories.id_categories
    ORDER BY id_items DESC
");

$pdf = new FPDF("L","mm","A4");
$pdf->AddPage();

$pdf->SetFont("Arial","B",16);
$pdf->Cell(0,10,"Data Barang",0,1,"C");
$pdf->Ln(5);

$pdf->SetFont("Arial","B",10);
$pdf->Cell(10,8,"No",1,0,"C");
$pdf->Cell(60,8,"Nama Barang",1,0,"C");
$pdf->Cell(40,8,"Kategori",1,0,"C");
$pdf->Cell(25,8,"Stok",1,0,"C");
$pdf->Cell(50,8,"Harga",1,0,"C");
$pdf->Cell(40,8,"Tanggal",1,1,"C");

$pdf->SetFont("Arial","",10);
$no = 1;

while ($data = mysqli_fetch_assoc($query)) {
    $pdf->Cell(10,10,$no++,1,0,"C");
    $pdf->Cell(60,10,$data['nama_barang'],1,0);
    $pdf->Cell(40,10,$data['nama_kategori'],1,0);
    $pdf->Cell(25,10,$data['stok'],1,0,"C");
    $pdf->Cell(50,10,"Rp " . number_format($data['harga_barang']),1,0);
    $pdf->Cell(40,10,$data['tanggal_masuk'],1,1);
}

$pdf->Output();
?>
