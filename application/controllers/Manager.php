<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Manager extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */

	public function __construct(){
		parent::__construct();
		$this->load->model('request_model');
		$this->load->model('receipt_model');
		$this->load->model('manager_model');
		$this->load->library('Excel');
	}
	private function change_status($id){
		$this->db->where('id', $id);
		$this->db->update('notification', array('status'=>'read'));
	}

	public function index()
	{
		$filter_data=array(
			'r.nik_receipt'=>$this->input->get('nik_receipt'),
			'r.id_request'=>$this->input->get('id_request'),
			't.title'=>$this->input->get('title'),
			't.deadline'=>$this->input->get('deadline'),
			'r.status_user'=>$this->input->get('status_user'),
			'r.status_pic'=>$this->input->get('status_pic')
		);

		if($this->input->get('notif')!=''){
			$this->change_status($this->input->get('notif'));
		}


		$nik=$this->session->userdata('nik'); //get nik from session
		$da=$this->manager_model->get_all_request($this->session->userdata('nik'), $filter_data, $this->session->userdata('division'));

		if($this->input->get('export')=='yes')
		{
			$this->exportXlsx($da, $nik, "Request");
		}else{
		$new_data=array();
		foreach ($da as $key ) {
			array_push($new_data, array(
				'nik'=>$key['nik_request'],
				'full_name'=>$key['first_name'].' '.$key['last_name'],
				'div'=>$key['location'].'-'.$key['division'].'-'.$key['department'],
				'nik_receipt'=>$key['nik_receipt'],
				'name_pic'=>$this->request_model->get_name($key['nik_receipt']),
				'div_pic'=>$this->request_model->get_dept($key['nik_receipt']),
				'id_task'=>$key['id_task'],
				'title'=>$key['title'],
				'doc_type'=>$key['doc_type'],
				'order_date'=>$key['order_date'],
				'deadline'=>$key['deadline'],
				'status_pic'=>$key['status_pic'],
				'start_date'=>date("d/m/Y", strtotime($key['start_date'])),
				'finish_date'=>$key['finish_date'],
				'status_user'=>$key['status_user'],
				'close_date'=>date("d/m/Y", strtotime($key['close_date'])),
				'transfer_from'=>$key['transfer_from'],
				'id_request'=>$key['id_request'],
				));
		}
		$pic=$this->request_model->getpic();
		$data['pic']=$pic;

		$data['list']=$new_data;
		$data['filter']=$filter_data;
		$this->load->view('manager/request_view',$data);
		}
	}

	private function exportXlsx($list, $nik, $jenis){
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
 		            ->setCellValue('A1', 'REPORT '.strtoupper($jenis).' LIST : '.$this->request_model->get_name($nik).'-'.$this->request_model->get_dept($nik))
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
 		header('Content-Disposition: attachment;filename="'.$jenis.'-'.$nik.'_'.date('Y-m-d H:m:s').'.xlsx"');
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

	//show page add request
	public function add_request(){
		$pic=$this->request_model->getpic();
		$data['pic']=$pic;
		$this->load->view('manager/add_request_', $data);
	}

	public function receipt(){
		$filter_data=array(
			'r.nik_receipt'=>$this->input->get('nik_receipt'),
			'r.id_request'=>$this->input->get('id_request'),
			't.title'=>$this->input->get('title'),
			't.deadline'=>$this->input->get('deadline'),
			'r.status_user'=>$this->input->get('status_user'),
			'r.status_pic'=>$this->input->get('status_pic')
		);

		if($this->input->get('notif')!=''){
			$this->change_status($this->input->get('notif'));
		}

		$nik=$this->session->userdata('nik'); //get nik from session
		$da=$this->manager_model->get_all_receipt($this->session->userdata('nik'), $filter_data,$this->session->userdata('division'));

		if($this->input->get('export')=='yes')
		{
			$this->exportXlsx($da, $nik, "Receipt");
		}else{
		$new_data=array();
		foreach ($da as $key ) {
			array_push($new_data, array(
				'nik'=>$key['nik_request'],
				'full_name'=>$this->request_model->get_name($key['nik_request']),
				'div'=>$this->request_model->get_dept($key['nik_request']),
				'nik_receipt'=>$key['nik_receipt'],
				'name_pic'=>$key['first_name'].' '.$key['last_name'],
				'div_pic'=>$key['location'].'-'.$key['division'].'-'.$key['department'],
				'id_task'=>$key['id_task'],
				'title'=>$key['title'],
				'doc_type'=>$key['doc_type'],
				'order_date'=>$key['order_date'],
				'deadline'=>$key['deadline'],
				'status_pic'=>$key['status_pic'],
				'start_date'=>date("d/m/Y", strtotime($key['start_date'])),
				'finish_date'=>$key['finish_date'],
				'status_user'=>$key['status_user'],
				'close_date'=>date("d/m/Y", strtotime($key['close_date'])),
				'transfer_from'=>$key['transfer_from'],
				'id_request'=>$key['id_request'],
				));
		}

		$pic=$this->request_model->getpic();
		$data['pic']=$pic;

		$pic_div=$this->manager_model->getpic_div($this->session->userdata('division'));
		$data['pic_div']=$pic_div;

		$data['list']=$new_data;
		$data['filter']=$filter_data;
		$this->load->view('manager/receipt_view',$data);
		echo json_encode(array('nik'=>$this->session->userdata('nik')));
	}
}

public function statistic(){
	$this->load->view('manager/statistic');
}

public function get_nik_same()
{
	$niks=$this->manager_model->get_nik_same(); //get niks
	$table=array(); //save to TokyoTyrantTable

	foreach ($niks as $key ) {
		array_push($table, array(
			// 'nik'=>$key['nik_receipt'],
			// 'name'=>$this->request_model->get_name($key['nik_receipt']),
			// 'div'=>$this->request_model->get_dept($key['nik_receipt']),
			// 'solved'=>$this->manager_model->get_num($key['nik_receipt'], 'solved'),
			// 'unsolved'=>$this->manager_model->get_num($key['nik_receipt'], 'unsolved'),
			// 'onprogress'=>$this->manager_model->get_num($key['nik_receipt'], 'onprogress'),
			// 'unread'=>$this->manager_model->get_num($key['nik_receipt'], 'unread'),
			$key['nik_receipt'],
			$this->request_model->get_name($key['nik_receipt']),
			$this->request_model->get_dept($key['nik_receipt']),
			'<a href="'.site_url().'/manager/receipt?export=&nik_receipt='.$key['nik_receipt'].'&id_request=&title=&deadline=&status_user=&status_pic=solved">'.$this->manager_model->get_num($key['nik_receipt'], 'solved').'</a>',
			'<a href="'.site_url().'/manager/receipt?export=&nik_receipt='.$key['nik_receipt'].'&id_request=&title=&deadline=&status_user=&status_pic=unsolved">'.$this->manager_model->get_num($key['nik_receipt'], 'unsolved').'</a>',
			'<a href="'.site_url().'/manager/receipt?export=&nik_receipt='.$key['nik_receipt'].'&id_request=&title=&deadline=&status_user=&status_pic=onprogress">'.$this->manager_model->get_num($key['nik_receipt'], 'onprogress').'</a>',
			'<a href="'.site_url().'/manager/receipt?export=&nik_receipt='.$key['nik_receipt'].'&id_request=&title=&deadline=&status_user=&status_pic=unread">'.$this->manager_model->get_num($key['nik_receipt'], 'unread').'</a>',
		));
	}
	echo json_encode(array('data'=>$table));
}


}
