<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Receipt extends CI_Controller {

	/**
	 * This controller use for access to application like
	 * view login
	 */

	public function __construct()
	{
		parent::__construct();
		$this->load->model('receipt_model');
		$this->load->model('request_model');
		$this->load->model('manager_model');
		$this->load->library('excel');
	}


  public function index(){
		$filter_data=array(
			'r.nik_request'=>$this->input->post('nik_request'),
			'r.id_request'=>$this->input->post('id_request'),
			't.title'=>$this->input->post('title'),
			't.deadline'=>$this->input->post('deadline'),
			'r.status_user'=>$this->input->post('status_user'),
			'r.status_pic'=>$this->input->post('status_pic')
		);

		$nik=$this->session->userdata('nik'); //get nik from session
		$da=$this->receipt_model->get_all($this->session->userdata('nik'), $filter_data);
		if($this->input->post('export')=='yes')
		{
				$this->exportXlsx($da, $nik);
		}
		else
		{
		// $da=$this->receipt_model->get_all($this->session->userdata('nik'), $filter_data);
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
				'start_date'=>$key['start_date'],
				'finish_date'=>$key['finish_date'],
				'status_user'=>$key['status_user'],
				'close_date'=>$key['close_date'],
				'transfer_from'=>$key['transfer_from'],
				'id_request'=>$key['id_request'],
				));
		}

		$pic=$this->request_model->getpic();
		$data['pic']=$pic;

		$data['list']=$new_data;
		$data['filter']=$filter_data;
    $this->load->view('request/receipt_view',$data);
		echo json_encode(array('nik'=>$this->session->userdata('nik')));
		}
  }


	public function save_edit(){
		$id_request=$this->input->post('id_request');
		$status=$this->input->post('status_pic');
		$close_date=date('Y-m-d');
		$pic_note=$this->input->post('pic_note');
		$start_date=$this->input->post('start_date');
		$finish_date=$this->input->post('finish_date');
		$update='';
		//cek apakah itu manager atau bukan
		$transfer_to=$this->input->post('transfer_to');
		$nik_from=$this->input->post('nik_from');
		if($transfer_to!=''){
			$update=$this->manager_model->change_receipt(array('nik_receipt'=>$transfer_to,'transfer_from'=>$nik_from, 'pic_note'=>$pic_note,'status_pic'=>'', 'start_date'=>'0000-00-00', 'finish_date'=>'0000-00-00 00:00:00'),array('id_request'=>$id_request));
			$log=$this->receipt_model->save_log(array('request_id'=>$id_request), array('transfer-time'=>date('Y-m-d H:i:s'),'start_time'=>'0000-00-00 00:00:00', 'unsoved_time'=>'0000-00-00 00:00:00'));
		}else{
			if($status=='solved'){
				// $update=$this->request_model->update_request(array('id_request'=>$id_request), array('status_pic'=>$status, 'finish_date'=>$close_date, 'pic_note'=>$pic_note));
				$log=$this->receipt_model->save_log(array('request_id'=>$id_request), array('solved_time'=>date('Y-m-d H:i:s')));
			}elseif ($status=='onprogress') {
				// $update=$this->request_model->update_request(array('id_request'=>$id_request), array('status_pic'=>$status, 'start_date'=>$close_date, 'pic_note'=>$pic_note));
				$log=$this->receipt_model->save_log(array('request_id'=>$id_request), array('start_time'=>date('Y-m-d H:i:s')));
			}elseif ($status=='unsolved') {
				// $update=$this->request_model->update_request(array('id_request'=>$id_request), array('status_pic'=>$status, 'finish_date'=>$close_date, 'pic_note'=>$pic_note));
				$log=$this->receipt_model->save_log(array('request_id'=>$id_request), array('unsoved_time'=>date('Y-m-d H:i:s')));
			}

			$update=$this->request_model->update_request(array('id_request'=>$id_request), array('status_pic'=>$status,'start_date'=>$start_date, 'finish_date'=>$finish_date, 'pic_note'=>$pic_note));
		}
		echo json_encode(array('status'=>true));
	}








	//show page add request
	public function add_request(){
		$pic=$this->request_model->getpic();
		$data['pic']=$pic;
		$this->load->view('request/add_request', $data);
	}
	//retrive data form from add request
	public function add(){
		$this->_validate();
		$request=array(
			'nik_request'=>$this->input->post('nik_request'),
			'nik_receipt'=>$this->input->post('nik_receipt'),
			'order_date'=>date("Y-m-d"),
			'status_user'=>'open'
		);
		$task=array(
			'title'=>$this->input->post('title'),
			'task_detail'=>$this->input->post('task_detail'),
			'create_date'=>date("Y-m-d"),
			'deadline'=>$this->input->post('deadline'),
			'doc_type'=>$this->input->post('doc_type')
		);
		$result=$this->request_model->save_request($request, $task);
		echo json_encode(array('status'=>true, 'result'=>$result));
	}

	private function _validate()
    {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;

        if($this->input->post('nik_receipt') == '')
        {
            $data['inputerror'][] = 'nik_receipt';
            $data['error_string'][] = 'Recipient is required !!!';
            $data['status'] = FALSE;
        }
				if($this->input->post('title') == '')
				{
						$data['inputerror'][] = 'title';
						$data['error_string'][] = 'Title is required !!!';
						$data['status'] = FALSE;
				}
				if($this->input->post('deadline') == '')
				{
						$data['inputerror'][] = 'deadline';
						$data['error_string'][] = 'Deadline is required !!!';
						$data['status'] = FALSE;
				}

        if($data['status'] === FALSE)
        {
            echo json_encode($data);
            exit();
        }
    }

	public function get_last_request($id_request){
		$data=$this->request_model->get_last($id_request);
		$new_data=array();
		$status_u="";
		foreach ($data as $key) {
			if($key['status_user']=='open'){
				$status_u='<p class="text-green">OPEN</p>';
			}
			if($key['status_user']=='CLOSE'){
				$status_u='<p class="text-danger">CLOSE</p>';
			}
			array_push($new_data, array(
//        '<input type="checkbox" id="check-all" class="flat">',
				$key['nik_request'],
				$key['first_name'].' '.$key['last_name'],
				$key['location'].'-'.$key['division'].'-'.$key['department'],
				$key['nik_receipt'],
				$this->request_model->get_name($key['nik_receipt']),
				$this->request_model->get_dept($key['nik_receipt']),
				$key['id_task'],
				$key['title'],
				$key['doc_type'],
				$key['order_date'],
				$key['deadline'],
				$key['status_pic'],
				$key['start_date'],
				$key['finish_date'],
				$status_u,
				$key['close_date'],
				$key['transfer_from'],
				'<a class="btn btn-sm btn-primary" title="Edit" onclick="edit('."'".$id_request."'".')"><i class="glyphicon glyphicon-pencil"></i> Edit</a>
				<a class="btn btn-sm btn-info" title="Edit" onclick="show('."'".$id_request."'".')"><i class="glyphicon glyphicon-pencil"></i> Show More</a>',
			));
		}

		echo json_encode(array('data'=>$new_data));
	}

	public function get_all_request($id_request){
		$data=$this->request_model->get_all_request($id_request);
		$new_data=array();
		$status_u="";
		foreach ($data as $key) {
			$button='<a class="btn btn-sm btn-primary" title="Edit" onclick="edit('."'".$key['id_request']."'".')"><i class="glyphicon glyphicon-pencil"></i> Edit</a>
			<a class="btn btn-sm btn-info" title="Edit" onclick="show('."'".$key['id_request']."'".')"><i class="fa fa fa-info-circle"></i> Show More</a>';
			if($key['status_user']=='open'){
				$status_u='<p class="text-green">OPEN</p>';
			}
			elseif($key['status_user']=='close'){
				$status_u='<p class="text-danger">CLOSE</p>';
				$button='<a class="btn btn-sm btn-info" title="Edit" onclick="show('."'".$key['id_request']."'".')"><i class="fa fa-info-circle"></i> Show More</a>';
			}else{
				$status_u='';
			}
			array_push($new_data, array(
//        '<input type="checkbox" id="check-all" class="flat">',
				$key['nik_request'],
				$key['first_name'].' '.$key['last_name'],
				$key['location'].'-'.$key['division'].'-'.$key['department'],
				$key['nik_receipt'],
				$this->request_model->get_name($key['nik_receipt']),
				$this->request_model->get_dept($key['nik_receipt']),
				$key['id_task'],
				$key['title'],
				$key['doc_type'],
				$key['order_date'],
				$key['deadline'],
				$key['status_pic'],
				$key['start_date'],
				$key['finish_date'],
				$status_u,
				$key['close_date'],
				$key['transfer_from'],
				$button,
			));
		}

		echo json_encode(array('data'=>$new_data));
	}

	public function ajax_edit($id_request)
	{
		$data=$this->request_model->get_data_byid($id_request);
		echo json_encode($data);
	}

	public function ajax_show($id_request)
	{
		$data=$this->request_model->get_data_byid($id_request);
		$dep=$this->request_model->get_dept($data->nik_receipt);
		$name=$this->request_model->get_name($data->nik_receipt);
		$full=$dep."-".$name;
		echo json_encode(array('d'=>$data, 'name'=>$full));

	}

	// public function save_edit(){
	// 	$id_request=$this->input->post('id_request');
	// 	$status=$this->input->post('status_user');
	// 	$close_date=Date('Y-m-d');
	//
	// 	$update=$this->request_model->update_request(array('id_request'=>$id_request), array('status_user'=>$status, 'close_date'=>$close_date));
	// 	echo json_encode(array('status'=>false, 'hasil'=>$update, array('status_user'=>$status, 'close_date'=>$close_date, 'id_request')));
	// }

	private function exportXlsx($list, $nik){
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
 		            ->setCellValue('A1', 'REPORT RECEIPT LIST : '.$this->request_model->get_name($nik).'-'.$this->request_model->get_dept($nik))
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
 		header('Content-Disposition: attachment;filename="Receipt_'.$nik.'_'.date('Y-m-d H:m:s').'.xlsx"');
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
