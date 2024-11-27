<?php
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 16);

// En-tête
$pdf->Cell(0, 10, 'Devis Automatique', 0, 1, 'C');
$pdf->Ln(10);

// Corps
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 10, "Nom : $nom", 0, 1);
$pdf->Cell(0, 10, "Email : $email", 0, 1);
$pdf->Cell(0, 10, "Service : $service", 0, 1);
$pdf->MultiCell(0, 10, "Détails : $details");
$pdf->Cell(0, 10, "Prix : $prix EUR", 0, 1);

// Sauvegarder le PDF
$upload_dir = wp_upload_dir();
$file_path = $upload_dir['basedir'] . "/devis-$nom.pdf";
$pdf->Output('F', $file_path);
?>
