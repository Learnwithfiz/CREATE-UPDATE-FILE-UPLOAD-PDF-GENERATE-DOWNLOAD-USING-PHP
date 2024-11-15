<?php
include 'db.php';
require('pdf/fpdf.php'); 


if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // Retrieve the user data from the database
    // Assuming you already have a database connection
    $query = "SELECT * FROM user_info WHERE id = $id"; // Adjust table name as needed
    $result = mysqli_query($con, $query);
    $row = mysqli_fetch_assoc($result);

    // Create a new PDF document
    $pdf = new FPDF();
    $pdf->AddPage();

    // Set font and add title
    $pdf->SetFont('Arial', 'B', 16);
    $pdf->Cell(0, 10, 'User Details', 1, 1, 'C');

    // Add user details
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(0, 10, 'Name: ' . $row['name'], 0, 1);
    $imagePath = 'img/' . $row['img'];

    // Check if the image file exists to avoid errors
    if (file_exists($imagePath)) {
        // Add the image to the PDF
        // Parameters: (file, x position, y position, width, height)
        $pdf->Image($imagePath, 10, $pdf->GetY(), 30, 30); // Adjust position and size as needed
        $pdf->Ln(35); // Move to the next line after image (adjust as needed)
    } else {
        // If image not found, display a placeholder or message
        $pdf->Cell(0, 10, 'Image not found', 0, 1);
    }
    $pdf->Cell(0, 10, 'Email: ' . $row['email'], 0, 1);
   
    // Output the PDF
    $pdf->Output('D', 'info.pdf'); // D: download, I: inline view
} else {
    echo "Invalid request.";
}
