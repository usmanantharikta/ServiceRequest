<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Export to XLSX and PDF
 */
class Export extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->library('Excel');

	}

	private function exportXlsx($list){
		// $nik=$this->session->userdata('nik'); //get nik from session
		//get list data from database
		$list=$this->request_model->get_all_request($nik, $filter_data);

		// print_r($list);
		// Create new PHPExcel object
		$objPHPExcel = new Excel();

		// Set document properties
		$objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
									 ->setLastModifiedBy("Maarten Balliauw")
									 ->setTitle("Office 2007 XLSX Test Document")
									 ->setSubject("Office 2007 XLSX Test Document")
									 ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
									 ->setKeywords("office 2007 openxml php")
									 ->setCategory("Test result file");

		 // Add some data
 		$objPHPExcel->setActiveSheetIndex(0)
 		            ->setCellValue('A1', 'REPORT REQUEST LIST : '.$this->request_model->get_name($nik).'-'.$this->request_model->get_dept($nik))
								->setCellValue('A3', 'NO')
 		            ->setCellValue('B3', 'USER')
 		            ->setCellValue('E3', 'PIC')
 		            ->setCellValue('H3', 'TASK DETAIL')
								->setCellValue('B4', 'NIK' )
								->setCellValue('C4', 'Name User')
								->setCellValue('D4', 'Division User')
								->setCellValue('E4', 'NIK')
								->setCellValue('F4', 'Name PIC')
								->setCellValue('G4', 'Division PIC')
								->setCellValue('H4', 'Request ID')
								->setCellValue('I4', 'Title')
								->setCellValue('J4', 'Doc Type')
								->setCellValue('K4', 'Order Date')
								->setCellValue('L4', 'Deadline')
								->setCellValue('M4', 'Status PIC')
								->setCellValue('N4', 'Start Date')
								->setCellValue('O4', 'Finish Date')
								->setCellValue('P4', 'Status User')
								->setCellValue('Q4', 'Close Date')
								->setCellValue('R4', 'Transfer From');

		// Merge cells
		// echo date('H:i:s') , " Merge cells" , EOL;
		$objPHPExcel->getActiveSheet()->mergeCells('A1:R1');
		$objPHPExcel->getActiveSheet()->mergeCells('A3:A4');
		$objPHPExcel->getActiveSheet()->mergeCells('B3:D3');
		$objPHPExcel->getActiveSheet()->mergeCells('E3:G3');
		$objPHPExcel->getActiveSheet()->mergeCells('H3:R3');


		// Set alignments
		// echo date('H:i:s') , " Set alignments" , EOL;
		$objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('B3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('E3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('H3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('H3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::VERTICAL_CENTER);

		 // Miscellaneous glyphs, UTF-8
 	// 	$objPHPExcel->setActiveSheetIndex(0)
 		           //  ->setCellValue('A4', 'Miscellaneous glyphs')
 		           //  ->setCellValue('A5', 'éàèùâêîôûëïüÿäöüç');
		//insert data
		$i=1;
		$row=5;
		$transfer=0;
		if(count($list>0))
		{
			foreach ($list as $key) {
				$transfer=$key['transfer_from'];
				$objPHPExcel->setActiveSheetIndex(0)
										->setCellValue('A'.$row, $i)
										->setCellValue('B'.$row, $key['nik_request'])
										->setCellValue('C'.$row, $key['first_name'].' '.$key['last_name'])
										->setCellValue('D'.$row, $key['location'].'-'.$key['division'].'-'.$key['department'])
										->setCellValue('E'.$row, $key['nik_receipt'] )
										->setCellValue('F'.$row, $this->request_model->get_name($key['nik_receipt']))
										->setCellValue('G'.$row, $this->request_model->get_dept($key['nik_receipt']))
										->setCellValue('H'.$row, $key['id_request'])
										->setCellValue('I'.$row, $key['title'])
										->setCellValue('J'.$row, $key['doc_type'])
										->setCellValue('K'.$row, $key['order_date'])
										->setCellValue('L'.$row, $key['deadline'])
										->setCellValue('M'.$row, $key['status_pic'])
										->setCellValue('N'.$row, $key['start_date'])
										->setCellValue('O'.$row, $key['finish_date'])
										->setCellValue('P'.$row, $key['status_user'])
										->setCellValue('Q'.$row, $key['close_date'])
										->setCellValue('R'.$row, $this->request_model->get_name($transfer).'-'.$this->request_model->get_dept($key['transfer_from']));
				$i++;
				$row++;
			} //oeforch
		}

 		// Rename worksheet
 		$objPHPExcel->getActiveSheet()->setTitle('Simple');

 		// Set active sheet index to the first sheet, so Excel opens this as the first sheet
 		$objPHPExcel->setActiveSheetIndex(0);

 		// Redirect output to a client’s web browser (Excel2007)
 		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
 		header('Content-Disposition: attachment;filename="request_'.$nik.'_'.date('Y-m-d H:m:s').'.xlsx"');
 		header('Cache-Control: max-age=0');
 		// If you're serving to IE 9, then the following may be needed
 		header('Cache-Control: max-age=1');

 		// If you're serving to IE over SSL, then the following may be needed
 		header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
 		header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
 		header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
 		header ('Pragma: public'); // HTTP/1.0

 		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
 		$objWriter->save('php://output');
 		exit;

	}

	function exportXlsxxx($list){
		// $nik=$this->session->userdata('nik'); //get nik from session
		//get list data from database
		// $list=$this->request_model->get_all_request($nik, $filter_data);

		// print_r($list);
		// Create new PHPExcel object
		$objPHPExcel = new Excel();

		// Set document properties
		$objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
									 ->setLastModifiedBy("Maarten Balliauw")
									 ->setTitle("Office 2007 XLSX Test Document")
									 ->setSubject("Office 2007 XLSX Test Document")
									 ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
									 ->setKeywords("office 2007 openxml php")
									 ->setCategory("Test result file");

		 // Add some data
 		$objPHPExcel->setActiveSheetIndex(0)
 		            ->setCellValue('A1', 'REPORT REQUEST LIST : '.$this->request_model->get_name($nik).'-'.$this->request_model->get_dept($nik))
								->setCellValue('A3', 'NO')
 		            ->setCellValue('B3', 'USER')
 		            ->setCellValue('E3', 'PIC')
 		            ->setCellValue('H3', 'TASK DETAIL')
								->setCellValue('B4', 'NIK' )
								->setCellValue('C4', 'Name User')
								->setCellValue('D4', 'Division User')
								->setCellValue('E4', 'NIK')
								->setCellValue('F4', 'Name PIC')
								->setCellValue('G4', 'Division PIC')
								->setCellValue('H4', 'Request ID')
								->setCellValue('I4', 'Title')
								->setCellValue('J4', 'Doc Type')
								->setCellValue('K4', 'Order Date')
								->setCellValue('L4', 'Deadline')
								->setCellValue('M4', 'Status PIC')
								->setCellValue('N4', 'Start Date')
								->setCellValue('O4', 'Finish Date')
								->setCellValue('P4', 'Status User')
								->setCellValue('Q4', 'Close Date')
								->setCellValue('R4', 'Transfer From');

		// Merge cells
		// echo date('H:i:s') , " Merge cells" , EOL;
		$objPHPExcel->getActiveSheet()->mergeCells('A1:R1');
		$objPHPExcel->getActiveSheet()->mergeCells('A3:A4');
		$objPHPExcel->getActiveSheet()->mergeCells('B3:D3');
		$objPHPExcel->getActiveSheet()->mergeCells('E3:G3');
		$objPHPExcel->getActiveSheet()->mergeCells('H3:R3');


		// Set alignments
		// echo date('H:i:s') , " Set alignments" , EOL;
		$objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('B3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('E3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('H3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('H3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::VERTICAL_CENTER);

		 // Miscellaneous glyphs, UTF-8
 	// 	$objPHPExcel->setActiveSheetIndex(0)
 		           //  ->setCellValue('A4', 'Miscellaneous glyphs')
 		           //  ->setCellValue('A5', 'éàèùâêîôûëïüÿäöüç');
		//insert data
		$i=1;
		$row=5;
		$transfer=0;
		if(count($list>0))
		{
			foreach ($list as $key) {
				$transfer=$key['transfer_from'];
				$objPHPExcel->setActiveSheetIndex(0)
										->setCellValue('A'.$row, $i)
										->setCellValue('B'.$row, $key['nik_request'])
										->setCellValue('C'.$row, $key['first_name'].' '.$key['last_name'])
										->setCellValue('D'.$row, $key['location'].'-'.$key['division'].'-'.$key['department'])
										->setCellValue('E'.$row, $key['nik_receipt'] )
										->setCellValue('F'.$row, $this->request_model->get_name($key['nik_receipt']))
										->setCellValue('G'.$row, $this->request_model->get_dept($key['nik_receipt']))
										->setCellValue('H'.$row, $key['id_request'])
										->setCellValue('I'.$row, $key['title'])
										->setCellValue('J'.$row, $key['doc_type'])
										->setCellValue('K'.$row, $key['order_date'])
										->setCellValue('L'.$row, $key['deadline'])
										->setCellValue('M'.$row, $key['status_pic'])
										->setCellValue('N'.$row, $key['start_date'])
										->setCellValue('O'.$row, $key['finish_date'])
										->setCellValue('P'.$row, $key['status_user'])
										->setCellValue('Q'.$row, $key['close_date'])
										->setCellValue('R'.$row, $this->request_model->get_name($transfer).'-'.$this->request_model->get_dept($key['transfer_from']));
				$i++;
				$row++;
			} //oeforch
		}

 		// Rename worksheet
 		$objPHPExcel->getActiveSheet()->setTitle('Simple');

 		// Set active sheet index to the first sheet, so Excel opens this as the first sheet
 		$objPHPExcel->setActiveSheetIndex(0);

 		// Redirect output to a client’s web browser (Excel2007)
 		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
 		header('Content-Disposition: attachment;filename="request_'.$nik.'_'.date('Y-m-d H:m:s').'.xlsx"');
 		header('Cache-Control: max-age=0');
 		// If you're serving to IE 9, then the following may be needed
 		header('Cache-Control: max-age=1');

 		// If you're serving to IE over SSL, then the following may be needed
 		header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
 		header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
 		header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
 		header ('Pragma: public'); // HTTP/1.0

 		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
 		$objWriter->save('php://output');
 		exit;

	}



}
