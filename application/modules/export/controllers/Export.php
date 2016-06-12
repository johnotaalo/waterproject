<?php

class Export extends MY_Controller
{
	function __construct()
	{
		parent::__construct();
	}

	function pdf($data = array())
	{
		$this->load->library('Pdf');
		$pdf = $this->pdf->load();
		$data['orientation'] = 'portait';
		$data['css'] = '1';
		$html = "<h1>Testing Email</h1>";
$pdf->SetFooter($_SERVER['HTTP_HOST'].'|{PAGENO}|'.date(DATE_RFC822)); // Add a footer for good measure <img class="emoji" draggable="false" alt="😉" src="https://s.w.org/images/core/emoji/72x72/1f609.png">
					
					if($data["orientation"] == "landscape"){$pdf->AddPage("L");}
					if(isset($data["css"]))
					{
						$stylesheet = file_get_contents('assets/custom/pdf.css');
					}else{
						$stylesheet = file_get_contents('assets/custom/pdf.css');
					}
					$pdf->WriteHTML($stylesheet,1);
					$pdf->WriteHTML($html, 2); // write the HTML into the PDF
					$content = $pdf->Output($pdfFilePath, 'S'); // save to file because we can
					// $content = chunk_split(base64_encode($content));

					$this->load->library('Mailer');
					$mail = new PHPMailer();

					$mail->IsSMTP(); // Use SMTP
					$mail->IsHTML();
					$mail->Host        = "smtp.gmail.com"; // Sets SMTP server
					$mail->SMTPDebug   = 2; // 2 to enable SMTP debug information
					$mail->SMTPAuth    = TRUE; // enable SMTP authentication
					//$mail->SMTPSecure  = "tls"; //Secure conection
					$mail->Port        = 25; // set the SMTP port
					$mail->Username    = 'chrizota@gmail.com'; // SMTP account username
					$mail->Password    = 'Chrispine2015'; // SMTP account password
					$mail->Priority    = 1; // Highest priority - Email priority (1 = High, 3 = Normal, 5 = low)
					$mail->CharSet     = 'UTF-8';
					$mail->Subject     = "Testing";
					$mail->ContentType = 'text/html; charset=utf-8\r\n';
					$mail->From        = 'chrispinethesim@gmail.com';
					$mail->FromName    = 'Quavatel App';
					$mail->AddAddress("john.otaalo@strathmore.edu", "Chrispine Otaalo");
					$mail->AddStringAttachment($content,'chrispine.pdf','base64','application/pdf');
					$mail->isHTML( TRUE );
					$mail->Body = '<h1>Testing</h1>';
					if(!$mail->Send()) {
						$end_data["message"] = "Error: " . $mail->ErrorInfo;
						$end_data["status"] = FALSE;
					} else {
						$end_data["message"] = "Message sent correctly!";
						$end_data["status"] = TRUE;
					}
					$mail->SmtpClose();
					echo $content;die;
	}
}