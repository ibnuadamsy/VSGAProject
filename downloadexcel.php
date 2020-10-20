<?php
include ('functions.php');
require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$sheet->setCellValue('A1', 'no');
$sheet->setCellValue('B1', 'Nim');
$sheet->setCellValue('C1', 'Nama');
$sheet->setCellValue('D1', 'Jurusan');
$sheet->setCellValue('E1', 'Email');

$query = mysqli_query($conn, "SELECT * FROM mahasiswa");
$i = 2;
$no= 1;
while ($row = mysqli_fetch_array($query)) 
{
    $sheet->setCellValue('A'.$i, $no++);
    $sheet->setCellValue('B'.$i, $row['nim']);
    $sheet->setCellValue('C'.$i, $row['nama']);
    $sheet->setCellValue('D'.$i, $row['jurusan']);
    $sheet->setCellValue('E'.$i, $row['email']);
    $i++;
}

$styleArray = [
            'border' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
        ];
$i = $i-1;
$sheet->getStyle('A1:D'.$i)->applyFromArray($styleArray);

$writer = new Xlsx($spreadsheet);
$writer->save('Report Data Mahasiswa.xlsx');
header("location:Report Data Mahasiswa.xlsx");

//echo '<h1>Data telah Berhasil di Download</h1>';
//echo '<a href="index.php">Kembali</a>';
?>
