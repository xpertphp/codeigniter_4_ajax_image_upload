<?php 

namespace App\Controllers;
 
use CodeIgniter\Controller;
use App\Models\StudentModel;
 
class Student extends Controller
{
 
	public function __construct()
    {
        helper(['form', 'url']);
    }
    public function index()
    {    
        return view('add');
    }    
 
    public function store()
    { 
		$rules = [
			'txtFname' => 'required',
            'txtLname' => 'required',
            'txtEmail' => 'required|valid_email',
            'txtMobile' => 'required|min_length[10]|numeric',
            'txtAddress' => 'required',
			"image" => [
				'uploaded[image]',
                'mime_in[image,image/jpg,image/jpeg,image/gif,image/png]',
                'max_size[image,4096]',
			],
		];
		
		if (!$this->validate($rules)) {
			$resData = [
			 'success' => false,
			 'data' => '',
			 'msg' => $this->validator
			];
		} else {
			$image = $this->request->getFile('image');
            $image->move(WRITEPATH . 'uploads');
		  
			$data = [
			 'first_name' => $this->request->getVar('txtFname'),
			 'last_name'  => $this->request->getVar('txtLname'),
			 'email'  => $this->request->getVar('txtEmail'),
			 'mobile'  => $this->request->getVar('txtMobile'),
			 'address'  => $this->request->getVar('txtAddress'),
			 'image'  => $image->getClientName(),
			];
			 
			$model = new StudentModel(); 
			$save = $model->insert($data);
			$resData = [
			 'success' => true,
			 'data' => $save,
			 'msg' => "Student has been added successfully"
			];			 
		}
		return $this->response->setJSON($resData);
		
    }
 
}

?>