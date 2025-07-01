<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
header("Access-Control-Allow-Origin: *"); // or specify exact origin instead of *
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

if($_SERVER["REQUEST_METHOD"] == "POST") 
{



require 'vendor/autoload.php';


$mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = 'smtpout.secureserver.net';
        $mail->SMTPAuth = true;
        $mail->Username = 'mail@sterlingpublishers.in';
        $mail->Password = 'Ps@sppl13gn#';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom('dev@weblabz.in', 'Sterling');
        $mail->addAddress('dev@weblabz.in', $_POST['contactPerson']);
        $mail->isHTML(true);
        $mail->Subject = 'New  Inquiry';

        $body = '
        <html><head><style>
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #ddd; padding: 8px; }
        th { background-color: #f2f2f2; }
        </style></head><body>
        <h3>New  Inquiry</h3>
        <table>';
        $fields = [
            'Company Name' => $_POST['companyName'] ?? '',
            'Contact Person' => $_POST['contactPerson'] ?? '',
            'Email' => $_POST['email'] ?? '',
            'Phone' => $_POST['phone'] ?? '',
            'Address' => $_POST['address'] ?? '',
            'Type Of Inquiry' => $_POST['typeInquiry'] ?? '',
            'Book Title' => $_POST['bookTitle'] ?? '',
            'Quantity' => $_POST['quantity'] ?? '',
            'ISBN' => $_POST['isbn'] ?? '',
            'Delivery Address' => $_POST['deliveryAddress'] ?? '',
            'Description' => $_POST['description'] ?? '',
            'Packaging Services' => $_POST['packaging'] ?? '',
            'Printing Services' => $_POST['printing'] ?? '',
            'Publishing Services' => $_POST['publishing'] ?? '',
            'General Quantity' => $_POST['generalQuantity'] ?? '',
            'Dimensions' => $_POST['dimensions'] ?? '',
            'Materials' => $_POST['materials'] ?? '',
            'Deadline' => $_POST['deadline'] ?? '',
            'Preferred Contact Method' => $_POST['preferredContact'] ?? '',
            'Preferred Contact Time' => $_POST['preferredContactTime'] ?? '',
            'Submission Time' => date('Y-m-d H:i:s'),
        ];
        
        foreach ($fields as $key => $value) {
            $body .= "<tr><th>$key</th><td>" . htmlspecialchars($value) . "</td></tr>";
        }

        $body .= '</table><p>Please follow up with this Inquiry as soon as possible.</p></body></html>';
        $mail->Body = $body;
            // Attach file if uploaded
            if (isset($_FILES['uploadedFile']) && $_FILES['uploadedFile']['error'] == UPLOAD_ERR_OK) {
                $uploadTmpPath = $_FILES['uploadedFile']['tmp_name'];
                $uploadFileName = $_FILES['uploadedFile']['name'];
                $mail->addAttachment($uploadTmpPath, $uploadFileName);
            }

        $mail->send();
        $emailStatus = 'Email sent successfully';
    } catch (Exception $e) {
        $emailStatus = 'Email failed: ' . $mail->ErrorInfo;
       
    }
}
else
{
    echo json_encode(['status'=>'404','error'=>' Methods Issues']);
}
?>