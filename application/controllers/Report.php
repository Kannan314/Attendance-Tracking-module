<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Report extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->library('form_validation');
    $this->load->model('Public_model');
    $this->load->model('Admin_model');
  }
  public function index()
  {
    $d['title'] = 'Report';
    $d['account'] = $this->Admin_model->getAdmin($this->session->userdata['username']);
    $d['department'] = $this->db->get('department')->result_array();
    $d['start'] = $this->input->get('start');
    $d['end'] = $this->input->get('end');
    $d['dept_code'] = $this->input->get('dept');
    $d['attendance'] = $this->_attendanceDetails($d['start'], $d['end'], $d['dept_code']);

    $this->load->view('templates/table_header', $d);
    $this->load->view('templates/sidebar');
    $this->load->view('templates/topbar');
    $this->load->view('report/index', $d);
    $this->load->view('templates/table_footer');
  }
  private function _attendanceDetails($start, $end, $dept)
  {
    if ($start == '' || $end == '') {
      return false;
    } else {
      return $this->Public_model->get_attendance($start, $end, $dept);
    }
  }
  public function print($start, $end, $dept)
  {
    $d['start'] = $start;
    $d['end'] = $end;
    $d['attendance'] = $this->Public_model->get_attendance($start, $end, $dept);
    $d['dept'] = $dept;

    $this->load->view('report/print', $d);
  }
}
