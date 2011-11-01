<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pages extends CI_Controller {
    
    public function index(){
        $this->load->library('Caret');
        $this->load->helper('directory');
        $this->load->helper('html');
        
        $map = directory_map('pages/');

        $map = ul($map);
        
        $filename_to_page = "index";
        $body = file_get_contents('pages/' . $filename_to_page . '.yaml');
        
        $template_name = 'pages';

        echo $this->caret->render_admin_page(
            $template_name,
            $page = array(
                'title'         => 'Home',
                'map'           => $map,
                'body'          => $body
            )
        );
    }

    public function save(){
        
    }

    public function edit(){

    }
}
