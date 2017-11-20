<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Request extends CI_Controller {

	/**
	 * This controller use for access to application like
	 * view login
	 */

	public function __construct()
	{
		parent::__construct();
		$this->load->model('request_model');
		$this->load->model('receipt_model');
		$this->load->library('excel');
		// $this->load->library('upload');

	}

  public function index(){
		$nik=$this->session->userdata('nik'); //get nik from session
		$filter_data=array(
			'r.nik_receipt'=>$this->input->post('nik_receipt'),
			'r.id_request'=>$this->input->post('id_request'),
			't.title'=>$this->input->post('title'),
			't.deadline'=>$this->input->post('deadline'),
			'r.status_user'=>$this->input->post('status_user'),
			'r.status_pic'=>$this->input->post('status_pic')
		);


		if($this->input->post('export')=='yes')
		{
				$this->exportXlsx($filter_data, $nik);
		}
		else
		{
				$da=$this->request_model->get_all_request($this->session->userdata('nik'), $filter_data);
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
		    $this->load->view('request/request_view',$data);
		} //else
  }

	private function exportXlsx($filter_data, $nik){
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


	//show page add request
	public function add_request(){
		$pic=$this->request_model->getpic();
		$data['pic']=$pic;
		$this->load->view('request/add_request', $data);
	}
	// retrive data form from add request
	public function add(){
		$status_upload='';
		$this->_validate();
		$request=array(
			'nik_request'=>$this->input->post('nik_request'),
			'nik_receipt'=>$this->input->post('nik_receipt'),
			'order_date'=>date("Y-m-d"),
			'status_user'=>'OPEN'
		);
		$task=array(
			'title'=>$this->input->post('title'),
			'task_detail'=>$this->input->post('task_detail'),
			'create_date'=>date("Y-m-d"),
			'deadline'=>$this->input->post('deadline'),
			'doc_type'=>$this->input->post('doc_type')
		);
		$result=$this->request_model->save_request($request, $task);
		$status_upload=$this->upload_file($result);
		$asdadd=$this->request_model->createNotif($result, $this->input->post('nik_receipt'), $this->input->post('nik_request'));
		echo json_encode(array('status'=>true, 'result'=>$result, 'upload'=>$status_upload));
	}

	private function upload_file($request){
		$data = array();
		$data['error_string'] = array();
		$data['inputerror'] = array();
		$data['status'] = TRUE;
		$filesCount = count($_FILES['file']['name']);
		// var_dump($_FILES);
		if($filesCount!=0&&$_FILES['file']['name'][0]!=''){
					 for($i = 0; $i < $filesCount; $i++){
							 $_FILES['userFile']['name'] = $_FILES['file']['name'][$i];
							 $_FILES['userFile']['type'] = $_FILES['file']['type'][$i];
							 $_FILES['userFile']['tmp_name'] = $_FILES['file']['tmp_name'][$i];
							 $_FILES['userFile']['error'] = $_FILES['file']['error'][$i];
							 $_FILES['userFile']['size'] = $_FILES['file']['size'][$i];

							 chmod("uploads", 0755);  // octal; correct value of mode
							 $uploadPath = 'uploads/request/'.$this->session->userdata('nik').'/'.$request;
							 if (!is_dir($uploadPath)) {
										mkdir($uploadPath, 0777, TRUE);
								}
							 $config['upload_path'] = $uploadPath;
							//  var_dump($_FILES['userFile']);
							 $config['allowed_types'] = '*';
							 $this->load->library('upload', $config);
							 $this->upload->initialize($config);
							 if ( ! $this->upload->do_upload('userFile'))
							 {
								$data['inputerror'][] = 'file[]';
								$data['error_string'][] = 'Upload file gagal';
								$data['status'] = FALSE;
							 }
					 }
		}else{
			// $data['inputerror'][] = 'file[]';
			// $data['error_string'][] = 'File Tidak Boleh kosong';
			// $data['status'] = FALSE;
		}

		if($data['status'] === FALSE)
		{
				echo json_encode($data);
				exit();
		}else{
			return 'success';
		}
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
			if($key['status_user']=='OPEN'){
				$status_u='<p class="text-green">OPEN</p>';
			}
			if($key['status_user']=='CLOSE'){
				$status_u='<p class="text-danger">CLOSE</p>';
			}
			if($key['status_user']=='CANCEL'){
				$status_u='<p class="text-warning">CANCEL</p>';
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
				// '<a class="btn btn-sm btn-primary" title="Edit" onclick="edit('."'".$id_request."'".')"><i class="glyphicon glyphicon-pencil"></i> Edit</a>
				// <a class="btn btn-sm btn-info" title="Edit" onclick="show('."'".$id_request."'".')"><i class="glyphicon glyphicon-pencil"></i> Show More</a>',
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
			if($key['status_user']=='OPEN'){
				$status_u='<p class="text-green">OPEN</p>';
			}
			elseif($key['status_user']=='CLOSE'){
				$status_u='<p class="text-danger">CLOSE</p>';
				$button='<a class="btn btn-sm btn-info" title="Edit" onclick="show('."'".$key['id_request']."'".')"><i class="fa fa-info-circle"></i> Show More</a>';
			}
			elseif($key['status_user']=='CANCEL'){
				$status_u='<p class="text-warning">CANCEL</p>';
				$button='<a class="btn btn-sm btn-info" title="Edit" onclick="show('."'".$key['id_request']."'".')"><i class="fa fa-info-circle"></i> Show More</a>';

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
		$dat=$this->request_model->get_data_byid($id_request);
		$dep=$this->request_model->get_dept($dat->nik_receipt);
		$name=$this->request_model->get_name($dat->nik_receipt);
		$full=$name."-".$dep;
		$this->data_tempel($dat, $full);
		// echo json_encode(array('d'=>$data, 'name'=>$full));
	}

	public function get_link($request, $nik){
		// $nik=$this->session->userdata('nik');
		$dir='uploads/request/'.$nik.'/'.$request;
		$files=scandir($dir);
		$link='';
		for($i=2;$i<count($files);$i++){
			$link.='<a href="'.base_url().'/'.$dir.'/'.$files[$i].'" download>'.$files[$i].'</a> <br>';
		}
		return $link;

	}

	private function data_tempel($data, $full){
		// was create
		$name_req=$data->first_name.' '.$data->last_name.'-'.$data->location.'-'.$data->division.'-'.$data->department;
		$time=strtotime($data->create_time);
		// echo date('h:i:s', $time);

		$time_line='
		<li class="time-label">
					<span class="order_date bg-red">';
		$time_line.=$data->order_date;
		$time_line.='</span>
		</li>
		<!-- ./end order -->
		<!-- deatil request -->
		<li>
			<i class="fa fa-pencil bg-blue"></i>
			<div class="timeline-item">
				<span id="create_time" class="time"><i class="fa fa-clock-o"></i>';
		$time_line.=date('h:i:s', $time);
		$time_line.='</span>
				<h3 class="timeline-header"><a class="request_name" href="#">';
		$time_line.=$name_req;
		$time_line.='</a> create a request</h3>
				<div id="detail_task" class="timeline-body">
					<h4>Detail Request :</h4>';
		$time_line.=$data->task_detail;
		$time_line.=' <h4>File:  </h4>'.$this->get_link($data->id_request, $data->nik_request).'
		</div>
				<div class="timeline-footer">
				</div>
			</div>
		</li>
		<!-- end detail request-->
		<!-- status user -->
		<li>
			<i class="fa fa-bell bg-aqua"></i>
			<div class="timeline-item">
				<!-- <span class="time"><i class="fa fa-clock-o"></i> 5 mins ago</span> -->
				<h3 class="timeline-header no-border">Status User is <a class="text-green" href="#">OPEN</a></h3>
			</div>
		</li>
		<!-- END timeline item -->
		<!-- timeline item -->
		<li>
			<i class="fa fa-send-o bg-yellow"></i>
			<div class="timeline-item">
				<!-- <span class="time"><i class="fa fa-clock-o"></i> 5 mins ago</span> -->
				<h3 class="timeline-header no-border">Request is Send to  <a class="receipt_name" class="text-green" href="#">';
		$time_line.=$full;
		$time_line.='</a></h3>
			</div>
		</li>
		';
		// var_dump($data);
			if($data->start_time!="0000-00-00 00:00:00"){

				$time_line.='
				<!-- recipient accept ________________________________________________________________________________________ -->
				<li class="time-label">
							<span id="start_date" class="bg-green">';
				$time_line.=date('Y-m-d', strtotime($data->start_time));
				$time_line.='
							</span>
				</li>
				<!-- /.timeline-label -->
				<!-- timeline item -->
				<li class="acc">
					<i class="fa fa-check-circle-o bg-purple"></i>
					<div class="timeline-item">
						<span id="respon" class="time"><i class="fa fa-clock-o"></i>';
				$time_line.=date('h:i:s', strtotime($data->start_time));
				$time_line.='</span>
<h3 class="timeline-header"><a class="receipt_name" href="#">';
				$time_line.=$full;
				$time_line.='</a> Change Status PIC to On Process</h3>
						<div id="start_detail" class="timeline-body"> This task will start at '.$data->start_date.'<p>PIC note :</p>';
				$time_line.=$data->pic_note;
				$time_line.='
						</div>
					</div>
				</li>
				<!-- END timeline item -->
				<!-- timeline item -->
				<li >
					<i class="fa fa-bell bg-aqua"></i>
					<div class="timeline-item">
						<!-- <span class="time"><i class="fa fa-clock-o"></i> 5 mins ago</span> -->
						<h3 class="timeline-header no-border">Status PIC is ';
				$time_line.='<a class="text-green">ONPROCESS</a>';
				$time_line.='</h3>
					</div>
				</li>
				<!-- END timeline item -->';
		}

		if($data->solved_time!="0000-00-00 00:00:00"){
			$time_line.='
			<li class=" time-label">
			       <span id="finish_time" class="bg-green">
			              '.date('Y-m-d',strtotime($data->solved_time)).'
			                </span>
			          </li>
			          <!-- /.timeline-label -->
			          <!-- timeline item -->
			          <li class=" solved">
			            <i class="fa fa-check-circle-o bg-purple"></i>

			            <div class="timeline-item">
			              <span id="finish_time_jam" class="time"><i class="fa fa-clock-o"></i>'.date('h:i:s',strtotime($data->solved_time)).	'</span>
			              <h3 class="timeline-header"><a class="receipt_name" href="#">'.$full.'</a> Change Status PIC to Solved</h3>
			              <div id="finish-detail" class="timeline-body">
										<p>PIC Note :</p>
										'.$data->pic_note.'
			              </div>
			            </div>
			          </li>
			          <!-- END timeline item -->
			          <!-- timeline item -->
			          <li>
			            <i class="fa fa-bell bg-aqua"></i>

			            <div class="timeline-item">
			              <!-- <span class="time"><i class="fa fa-clock-o"></i> 5 mins ago</span> -->
			              <h3 class="timeline-header no-border">Status User is <a class="text-green">SOLVED </a> </h3>
			            </div>
			          </li>
			          <!-- END timeline item -->';
		}

		//if un solved
		if($data->unsoved_time!="0000-00-00 00:00:00"){
			$time_line.='
						<li class=" time-label">
						       <span id="finish_time" class="bg-green">
						              '.date('Y-m-d',strtotime($data->unsoved_time)).'
						                </span>
						          </li>
						          <!-- /.timeline-label -->
						          <!-- timeline item -->
						          <li class=" solved">
						            <i class="fa fa-times-circle bg-red"></i>

						            <div class="timeline-item">
						              <span id="finish_time_jam" class="time"><i class="fa fa-clock-o"></i>'.date('h:i:s',strtotime($data->unsoved_time)).	'</span>
						              <h3 class="timeline-header"><a class="receipt_name" href="#">'.$full.'</a> Change Status PIC to Unsolved</h3>
						              <div id="finish-detail" class="timeline-body">
													<p>PIC Note :</p>
													'.$data->pic_note.'
						              </div>
						            </div>
						          </li>
						          <!-- END timeline item -->
						          <!-- timeline item -->
						          <li>
						            <i class="fa fa-bell bg-aqua"></i>

						            <div class="timeline-item">
						              <!-- <span class="time"><i class="fa fa-clock-o"></i> 5 mins ago</span> -->
						              <h3 class="timeline-header no-border">Status User is <a class="text-danger">UNSOLVED </a> </h3>
						            </div>
						          </li>
						          <!-- END timeline item -->';
		}
		//if cancel
		if($data->cancel_time!="0000-00-00 00:00:00"){
			$time_line.='
						<li class=" time-label">
						       <span id="finish_time" class="bg-green">
						              '.date('Y-m-d',strtotime($data->cancel_time)).'
						                </span>
						          </li>
						          <!-- /.timeline-label -->
						          <!-- timeline item -->
						          <li class=" solved">
						            <i class="fa fa-times-circle bg-red"></i>

						            <div class="timeline-item">
						              <span id="finish_time_jam" class="time"><i class="fa fa-clock-o"></i>'.date('h:i:s',strtotime($data->cancel_time)).	'</span>
						              <h3 class="timeline-header"><a class="receipt_name" href="#">'.$name_req.'</a> Change Status PIC to CANCEL</h3>
						              <div id="finish-detail" class="timeline-body">
													<p>Detail Task :</p>
													'.$data->task_detail.'
						              <h4>File:  </h4>'.$this->get_link($data->id_request, $data->id_request).'
						            </div>
						          </li>
						          <!-- END timeline item -->
						          <!-- timeline item -->
						          <li>
						            <i class="fa fa-bell bg-aqua"></i>

						            <div class="timeline-item">
						              <!-- <span class="time"><i class="fa fa-clock-o"></i> 5 mins ago</span> -->
						              <h3 class="timeline-header no-border">Status User is <a class="text-danger">CANCEL </a> </h3>
						            </div>
						          </li>
						          <!-- END timeline item -->';
		}
		//close condition

		if($data->close_time!="0000-00-00 00:00:00"){
			$time_line.='
						<li class=" time-label">
						       <span id="finish_time" class="bg-green">
						              '.date('Y-m-d',strtotime($data->close_time)).'
						                </span>
						          </li>
						          <!-- /.timeline-label -->
						          <!-- timeline item -->
						          <li class=" solved">
						            <i class="fa fa-minus-circle bg-red"></i>

						            <div class="timeline-item">
						              <span id="finish_time_jam" class="time"><i class="fa fa-clock-o"></i>'.date('h:i:s',strtotime($data->close_time)).	'</span>
						              <h3 class="timeline-header"><a class="receipt_name" href="#">'.$name_req.'</a> Change Status PIC to CLOSE</h3>
						              <div id="finish-detail" class="timeline-body">
													<p>Detail Task :</p>
													'.$data->task_detail.'
						              <h4>File:  </h4>'.$this->get_link($data->id_request).'
						            </div>
						          </li>
						          <!-- END timeline item -->
						          <!-- timeline item -->
						          <li>
						            <i class="fa fa-bell bg-aqua"></i>

						            <div class="timeline-item">
						              <!-- <span class="time"><i class="fa fa-clock-o"></i> 5 mins ago</span> -->
						              <h3 class="timeline-header no-border">Status User is <a class="text-green">CLOSE </a> </h3>
						            </div>
						          </li>
						          <!-- END timeline item -->';
		}
		$time_line.=' <li >
		            <i class="fa fa-clock-o bg-gray"></i>
		          </li>';

		echo json_encode(array('history'=>$time_line));
	}

	public function save_edit(){
		$id_request=$this->input->post('id_request');
		$status=$this->input->post('status_user');
		$task_detail=$this->input->post('task_detail');
		$close_date=Date('Y-m-d');
		$deadline=$this->input->post('deadline');
		if($status=='OPEN'){
			$update=$this->request_model->update_deadline(array('deadline'=>$deadline),array('id_task'=>$this->input->post('id_task')));
			// echo json_encode(array('status'=>false, 'request_id'=>$id_request, 'hasil'=>$update, array('status_user'=>$status, 'close_date'=>$close_date, 'id_request')));
			// exit();
		}
		elseif($status=='CLOSE'){
			$log=$this->receipt_model->save_log(array('request_id'=>$id_request), array('close_time'=>date('Y-m-d H:i:s')));
			$update=$this->request_model->update_request(array('id_request'=>$id_request), array('status_user'=>$status, 'close_date'=>$close_date));

		}
		elseif($status=='CANCEL'){
			$log=$this->receipt_model->save_log(array('request_id'=>$id_request), array('cancel_time'=>date('Y-m-d H:i:s')));
			$update=$this->request_model->update_request(array('id_request'=>$id_request), array('status_user'=>$status, 'close_date'=>$close_date));
		}
		echo json_encode(array('status'=>false, 'request_id'=>$id_request, 'hasil'=>$update, array('status_user'=>$status, 'close_date'=>$close_date, 'id_request')));
	}

}
