<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Controller extends CI_Controller {

    protected $DATA = array();
    
    protected $TITLE = '';
    
    protected $LAYOUT = 'application';
    
    public function __construct()
    {
        parent::__construct();
        
        $this->_set_title();
    }
    
    public function render($view = null)
    {
        $layout = "layouts/.$this->LAYOUT";
        //guess view file by convention
        if ($view == null) {
            $class = $this->router->class;
            $method = $this->router->method;
            
            $view = strtolower($class).'/'.strtolower($method);
        }
        
        $this->DATA['yield'] = $this->load->view($view, $this->DATA, true);
        //make data available to all
        $this->load->vars($this->DATA);
        //fly away
        $this->load->view($layout, $this->DATA);
    }
    
    private function _set_title()
    {
        if ($this->TITLE == null) {
            $class = $this->router->class;
            $method = $this->router->method;
            
            $this->TITLE = ucfirst($class).' | '.$method;
        }
        
        $this->DATA['title'] = $this->TITLE;
    }
    
    protected function add_js($js = '')
    {
        if (is_array($js)) {
            foreach ($js as $j) {
                $resource = base_url('assets/js/'.$j);
                $this->DATA['js'][] = '<script src="'.$resource.'"></script>';
            }
        } else {
            $resource = base_url('assets/js/'.$js);
            $this->DATA['js'][] = '<script src="'.$resource.'"></script><br>';
        }
    }
    
    protected function add_css($css = '')
    {
        if (is_array($css)) {
            foreach ($css as $c) {
                $resource = base_url('assets/css/'.$c);
                $this->DATA['css'][] = '<link href="'.$resource.'" rel="stylesheet" type="text/css">';
            }
        } else {
            $resource = base_url('assets/css/'.$css);
            $this->DATA['css'][] = '<link href="'.$resource.'" rel="stylesheet" type="text/css">';
        }
    }
}
