<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//    if (isset($_POST['service_type'])) {
//        $service_type = $_POST['service_type'];
//        if ($service_type == "traf_inc") {
//            echo json_encode(array(
//                "status" => "success",
//                "content" => json_encode(fetchTrafficIncidents())
//            ));
//        } else {
//            echo json_encode(array(
//                "status" => "error",
//                "text" => "Invalid service type request!"
//            ));
//        }
//    }
    exit;
} else {
    if (isset($_GET["called_by_timer"]) && $_GET["called_by_timer"] == "yes") {
        require_once EXTLIB_PATH . "mPDF/mpdf.php";
        require_once EXTLIB_PATH . "PHPMailer/PHPMailerAutoload.php";
        $get_traffic_api = true;
        include_once CONTROL_PATH . "get_traffic_api.php";
        generateReport();
        echo "Generate Report OK";
        exit;
    } else {
        error_404();
    }
}

function generateReport() {
    $stylesheet = file_get_contents('css/pdf.css'); // Get css content
//    $html = '<div id="pdf-content">
//              Your PDF Content goes here (Text/HTML)
//         </div>';
// Setup PDF
    $mpdf = new mPDF('utf-8', 'A4-L'); // New PDF object with encoding & page size
    $mpdf->setAutoTopMargin = 'stretch'; // Set pdf top margin to stretch to avoid content overlapping
    $mpdf->setAutoBottomMargin = 'stretch'; // Set pdf bottom margin to stretch to avoid content overlapping
// PDF header content
    $html = '
        <div id="pdf-content">
            <table>
                <tr>
                    <th colspan="4">Traffic Incidents</th>
                </tr>
                <tr>
                    <th>Incident Type</th>
                    <th>Latitude</th>
                    <th>Longtitude</th>
                    <th>Message</th>
                </tr>
                ';
    $allIncidents = fetchTrafficIncidents();
    if (count($allIncidents) > 0) {
        foreach ($allIncidents as $incident) {
            $html .= '
                <tr>
                    <td>' . $incident["Type"] . '</td>
                    <td>' . $incident["Latitude"] . '</td>
                    <td>' . $incident["Longitude"] . '</td>
                    <td>' . $incident["Message"] . '</td>
                </tr>
            ';
        }
    }
    $html .= ' 
            </table>
        </div>
    ';
    $mpdf->SetHTMLHeader('<div class="pdf-header">
                          <img class="left" src="image/cms-logo.png"/>                      
                      </div>');
// PDF footer content
    $mpdf->SetHTMLFooter('<div class="pdf-footer">
                      </div>');

    $mpdf->WriteHTML($stylesheet,1); // Writing style to pdf
    $mpdf->WriteHTML($html); // Writing html to pdf
// FOR EMAIL
    $content = $mpdf->Output('', 'S'); // Saving pdf to attach to email
//    $content = base64_encode($content);


    $mail = new PHPMailer;
//$mail->SMTPDebug = 3;                               // Enable verbose debug output
    $mail->isSMTP();                                      // Set mailer to use SMTP
//    $mail->SMTPDebug = 1; // debugging: 1 = errors and messages, 2 = messages only
    $mail->SMTPAuth = true;                               // Enable SMTP authentication
    $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
    $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
    $mail->Port = 587;                                    // TCP port to connect to - TLS (587)
    $mail->Username = 'testingonlineshop@gmail.com';                 // SMTP username
    $mail->Password = 'ilovetosleep@9';                           // SMTP password

    $mail->setFrom('testingonlineshop@gmail.com', 'Crisis Management System');
    $mail->addAddress('junhao0913@hotmail.com', 'PM Office');     // Add a recipient
//    $mail->addAddress('ellen@example.com');               // Name is optional
//    $mail->addReplyTo('info@example.com', 'Information');
//    $mail->addCC('cc@example.com');
//    $mail->addBCC('bcc@example.com');
    $mail->AddStringAttachment($content, "test.pdf", "base64", "application/pdf");

//    $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
//    $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
    $mail->isHTML(true);                                  // Set email format to HTML

    $mail->Subject = 'Latest Traffic Incidents Update';
    $mail->Body    = 'Dear Sir/Madam,<br/><br/>A copy of the report containing the <b>latest</b> updates 
                        for Traffic Incidents has been attached. Thank you.<br/><br/>
                        <span style="font-style: italic">This is an auto generated email, please 
                        do not reply to this email.</span>';
    $mail->AltBody = 'Dear Sir/Madam,\n\nA copy of the report containing the latest updates 
                        for Traffic Incidents has been attached. Thank you.\n\n
                        This is an auto generated email, please 
                        do not reply to this email.';

    if(!$mail->send()) {
        error_log("Message could not be sent.\nMailer Error: " . $mail->ErrorInfo);
    } else {
//        echo 'Message has been sent';
    }
}

?>