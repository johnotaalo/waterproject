<?php

class Export extends MY_Controller
{
	function __construct()
	{
		parent::__construct();
	}

	function pdf($html, $data, $email_data)
	{
		$this->load->library('Pdf');
		$pdf = $this->pdf->load();
		$data['orientation'] = 'portait';
		$data['css'] = '1';					
		if($data["orientation"] == "landscape"){$pdf->AddPage("L");}
		if(isset($data["css"]))
		{
			$stylesheet = file_get_contents('assets/custom/invoice.css');
		}else{
			$stylesheet = file_get_contents('assets/custom/pdf.css');
		}
		$pdf->WriteHTML($stylesheet,1);
		$pdf->WriteHTML($html, 2); // write the HTML into the PDF
		$content = $pdf->Output($pdfFilePath); // save to file because we can
		// $content = chunk_split(base64_encode($content));
		return;
		$this->load->library('Mailer');
		$mail = new PHPMailer();

		$mail->IsSMTP(); // Use SMTP
		$mail->IsHTML(true);
		$mail->Host        = "smtp.gmail.com"; // Sets SMTP server
		$mail->SMTPDebug   = 2; // 2 to enable SMTP debug information
		$mail->SMTPAuth    = TRUE; // enable SMTP authentication
		$mail->SMTPSecure  = "tls"; //Secure conection
		$mail->Port        = 25; // set the SMTP port
		$mail->Username    = 'chrizota@gmail.com'; // SMTP account username
		$mail->Password    = 'Chrispine2015'; // SMTP account password
		$mail->Priority    = 1; // Highest priority - Email priority (1 = High, 3 = Normal, 5 = low)
		$mail->CharSet     = 'UTF-8';
		$mail->Subject     = "Billing";
		$mail->ContentType = 'text/html; charset=utf-8\r\n';
		$mail->From        = 'billing@enkonguwater.com';
		$mail->FromName    = 'Enkongu Water';
		$mail->Sender      = 'billing@enkonguwater.com';
		$mail->AddAddress($email_data['email'], $email_data['name']);
		$mail->AddStringAttachment($content,'billing.pdf','base64','application/pdf');
		$mail->isHTML( TRUE );
		$mail->Body = $this->load->view('template/email/billing', $data, TRUE);
		if(!$mail->Send()) {
			$end_data["message"] = "Error: " . $mail->ErrorInfo;
			$end_data["status"] = FALSE;
		} else {
			$end_data["message"] = "Message sent correctly!";
			$end_data["status"] = TRUE;
		}
		$mail->SmtpClose();
	}

	function import_excel($path = NULL)
	{
		$file_path = "";

		$header = $main_data = $final_data = [];

		$this->load->library('Excel');

		if ($this->input->post()) {
			
		}
		else if ($path != NULL) {
			$file_path = $path;
		}
		else
		{
			die("Could not find the file to import");
		}

		// read file from path
		$objPHPExcel = PHPExcel_IOFactory::load($file_path);

		// Get only the cell collection
		$cell_collection = $objPHPExcel->getActiveSheet()->getCellCollection();

		// Extracting to a PHP readable format
		foreach ($cell_collection as $cell) {
			$column = $objPHPExcel->getActiveSheet()->getCell($cell)->getColumn();
			$row = $objPHPExcel->getActiveSheet()->getCell($cell)->getRow();
			$data_value = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();

			// Get the headers from the first row
			if ($row == 1):
				$header[$row][$column] = $data_value;
			else:
				$main_data[$row][$column] = $data_value;
			endif;
		}

		$final_data['header'] = $header;
		$final_data['values'] = $main_data;

		return $final_data;
	}
}