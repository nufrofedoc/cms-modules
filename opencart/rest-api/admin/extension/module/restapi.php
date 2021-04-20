<?php

class ControllerExtensionModuleRestapi extends Controller {
    
    private $error = array();
    private $request;
    
    public function index() {		
        $this->load->model('user/user');

        $data['users'] = array();      

        $user_total = $this->model_user_user->getTotalUsers();

        $results = $this->model_user_user->getUsers();

        foreach ($results as $result) {
            $data['users'][] = array(
                'user_id'    => $result['user_id'],
                'username'   => $result['username'],
                'status'     => $result['status']          
            );
        }

        $this->response->setOutput(json_encode($data));
    }

    public function checkMethod() {
        switch($_SERVER['REQUEST_METHOD']) {
        case 'GET':
            $this->request = $_GET;
            break;
        case 'POST':
            $this->request = $_POST;
            break;
        default:
            $this->request = $_POST;
        }
    }
    
    public function uninstall()
    {
        $this->load->model('setting/setting');
        $this->model_setting_setting->deleteSetting('module_apirest');
    }

    public function install()
    {
        $this->load->model('setting/setting');
        $this->model_setting_setting->editSetting('module_apirest', ['module_apirest_status' => 1]);   
    }
}
