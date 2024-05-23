<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Master extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    is_logged_in();
    $this->load->library('form_validation');
    $this->load->model('Public_model');
    $this->load->model('Admin_model');
  }
  public function index()
  {
    // Department Data
    $d['title'] = 'Department';
    $d['department'] = $this->db->get('department')->result_array();
    $d['account'] = $this->Admin_model->getAdmin($this->session->userdata['username']);

    $this->load->view('templates/table_header', $d);
    $this->load->view('templates/sidebar');
    $this->load->view('templates/topbar');
    $this->load->view('master/department/index', $d); // Department Page
    $this->load->view('templates/table_footer');
  }
  public function a_dept()
  {
    // Add Department
    $d['title'] = 'Department';
    $d['account'] = $this->Admin_model->getAdmin($this->session->userdata['username']);
    // Form Validation
    $this->form_validation->set_rules('d_id', 'Department ID', 'required|trim|exact_length[3]|alpha');
    $this->form_validation->set_rules('d_name', 'Department Name', 'required|trim');

    if ($this->form_validation->run() == true) {
      $this->_addDept();
    }
    $this->load->view('templates/header', $d);
    $this->load->view('templates/sidebar');
    $this->load->view('templates/topbar');
    $this->load->view('master/department/a_dept', $d); // Add Department Page
    $this->load->view('templates/footer');
  }

  private function _addDept()
  {
    $data = [
      'id' => $this->input->post('d_id'),
      'name' => $this->input->post('d_name')
    ];

    $checkId = $this->db->get_where('department', ['id' => $data['id']])->num_rows();
    if ($checkId > 0) {
      $this->session->set_flashdata('message', '<div class="alert alert-danger rounded-0 mb-2" role="alert">
      Failed to add, ID used!</div>');
    } else {
      $this->db->insert('department', $data);
      $this->session->set_flashdata('message', '<div class="alert alert-success rounded-0 mb-2" role="alert">
        Successfully added a new department!</div>');
      redirect('master/e_dept/'.$this->input->post('d_id'));
    }
  }

  public function e_dept($d_id)
  {
    // Edit Department
    $d['title'] = 'Department';
    $d['d_old'] = $this->db->get_where('department', ['id' => $d_id])->row_array();
    $d['account'] = $this->Admin_model->getAdmin($this->session->userdata['username']);
    // Form Validation
    $this->form_validation->set_rules('d_name', 'Department Name', 'required|trim');

    if ($this->form_validation->run() == false) {
      $this->load->view('templates/header', $d);
      $this->load->view('templates/sidebar');
      $this->load->view('templates/topbar');
      $this->load->view('master/department/e_dept', $d); // Edit Department Page
      $this->load->view('templates/footer');
    } else {
      $name = $this->input->post('d_name');
      $this->_editDept($d_id, $name);
    }
  }
  private function _editDept($d_id, $name)
  {
    $data = ['name' => $name];
    $this->db->update('department', $data, ['id' => $d_id]);
    $this->session->set_flashdata('message', '<div class="alert alert-success rounded-0 mb-2" role="alert">
        Successfully edited a department!</div>');
    redirect('master/e_dept/'.$d_id);
  }
  public function d_dept($d_id)
  {
    $this->db->delete('department', ['id' => $d_id]);
    $this->session->set_flashdata('message', '<div class="alert alert-success rounded-0 mb-2" role="alert">
        Successfully deleted a department!</div>');
    redirect('master');
  }
  // End of department
  public function shift()
  {
    // Shift Data
    $d['title'] = 'Shift';
    $d['shift'] = $this->db->get('shift')->result_array();
    $d['account'] = $this->Admin_model->getAdmin($this->session->userdata['username']);

    $this->load->view('templates/table_header', $d);
    $this->load->view('templates/sidebar');
    $this->load->view('templates/topbar');
    $this->load->view('master/shift/index', $d); // shift Page
    $this->load->view('templates/table_footer');
  }
  public function a_shift()
  {
    $generateID = $this->db->get('shift')->num_rows();
    $d['account'] = $this->Admin_model->getAdmin($this->session->userdata['username']);
    // Add shift
    $d['title'] = 'Shift';
    $d['s_id'] = $generateID + 1;

    // Form Validation
    $this->form_validation->set_rules('s_start_h', 'Hour', 'required|trim');
    $this->form_validation->set_rules('s_start_m', 'Minutes', 'required|trim');
    $this->form_validation->set_rules('s_start_s', 'Seconds', 'required|trim');
    $this->form_validation->set_rules('s_end_h', 'Hour', 'required|trim');
    $this->form_validation->set_rules('s_end_m', 'Minutes', 'required|trim');
    $this->form_validation->set_rules('s_end_s', 'Seconds', 'required|trim');

    if ($this->form_validation->run() == true) {
      $this->_addShift();
    }
    
    $this->load->view('templates/header', $d);
    $this->load->view('templates/sidebar');
    $this->load->view('templates/topbar');
    $this->load->view('master/shift/a_shift', $d); // Add shift Page
    $this->load->view('templates/footer');
  }
  private function _addShift()
  {
    // Start Time
    $sHour = $this->input->post('s_start_h');
    $sMinutes = $this->input->post('s_start_m');
    $sSeconds = $this->input->post('s_start_s');

    // End Time
    $eHour = $this->input->post('s_end_h');
    $eMinutes = $this->input->post('s_end_m');
    $eSeconds = $this->input->post('s_end_s');

    $data = [
      'start' => $sHour . ':' . $sMinutes . ':' . $sSeconds,
      'end' => $eHour . ':' . $eMinutes . ':' . $eSeconds,
    ];

    $this->db->insert('shift', $data);
    $id = $this->db->insert_id();
    $affectedRow = $this->db->affected_rows();
    if ($affectedRow > 0) {
      $this->session->set_flashdata('message', '<div class="alert alert-success rounded-0 mb-2" role="alert">
        Successfully added a new shift!</div>');
      redirect('master/e_shift/'.$id);
    } else {
      $this->session->set_flashdata('message', '<div class="alert alert-danger rounded-0 mb-2" role="alert">
      Failed to add new shift!</div>');
    }
  }

  public function e_shift($s_id)
  {
    $d['account'] = $this->Admin_model->getAdmin($this->session->userdata['username']);

    $data = $this->db->get_where('shift', ['id' => $s_id])->row_array();
    $start = explode(':', $data['start']);
    $end = explode(':', $data['end']);

    // Edit shift
    $d['title'] = 'Shift';
    $d['s_id'] = $data['id'];
    $d['s_sh'] = $start[0];
    $d['s_sm'] = $start[1];
    $d['s_ss'] = $start[2];
    $d['s_eh'] = $end[0];
    $d['s_em'] = $end[1];
    $d['s_es'] = $end[2];

    // Form Validation
    $this->form_validation->set_rules('s_start_h', 'Shift Start Hour', 'required|trim');
    $this->form_validation->set_rules('s_start_m', 'Shift Start Minutes', 'required|trim');
    $this->form_validation->set_rules('s_start_s', 'Shift Start Seconds', 'required|trim');
    $this->form_validation->set_rules('s_end_h', 'Shift End Hour', 'required|trim');
    $this->form_validation->set_rules('s_end_m', 'Shift End Minutes', 'required|trim');
    $this->form_validation->set_rules('s_end_s', 'Shift End Seconds', 'required|trim');

    if ($this->form_validation->run() == true) {
      // Start Time
      $sHour = $this->input->post('s_start_h');
      $sMinutes = $this->input->post('s_start_m');
      $sSeconds = $this->input->post('s_start_s');

      // End Time
      $eHour = $this->input->post('s_end_h');
      $eMinutes = $this->input->post('s_end_m');
      $eSeconds = $this->input->post('s_end_s');

      $set = [
        'start' => $sHour . ':' . $sMinutes . ':' . $sSeconds,
        'end' => $eHour . ':' . $eMinutes . ':' . $eSeconds,
      ];
      $this->_editShift($s_id, $set);
    }
    $this->load->view('templates/header', $d);
    $this->load->view('templates/sidebar');
    $this->load->view('templates/topbar');
    $this->load->view('master/shift/e_shift', $d); // Edit shift Page
    $this->load->view('templates/footer');
  }
  private function _editShift($s_id, $set)
  {
    $this->db->where('id', $s_id);
    $this->db->update('shift', $set, ['id' => $s_id]);
    $this->session->set_flashdata('message', '<div class="alert alert-success rounded-0 mb-2" role="alert">
        Successfully edited a shift!</div>');
    redirect('master/e_shift/'.$s_id);
  }

  public function d_shift($s_id)
  {
    $query = 'ALTER TABLE `shift` AUTO_INCREMENT = 1';
    $this->db->delete('shift', ['id' => $s_id]);
    $this->db->query($query);
    $this->session->set_flashdata('message', '<div class="alert alert-success rounded-0 mb-2" role="alert">
        Successfully deleted a shift!</div>');
    redirect('master/shift');
  }
  // End of Shift

  public function employee()
  {
    // Employee Data
    $d['title'] = 'Employee';
    $d['employee'] = $this->db->query("SELECT e.*,s.start, s.end FROM `employee` e inner join `shift` s on e.shift_id = s.id order by `name` asc")->result_array();
    $d['account'] = $this->Admin_model->getAdmin($this->session->userdata['username']);

    $this->load->view('templates/table_header', $d);
    $this->load->view('templates/sidebar');
    $this->load->view('templates/topbar');
    $this->load->view('master/employee/index', $d); // Employee Page
    $this->load->view('templates/table_footer');
  }

  public function a_employee()
  {
    // Add Employee
    $d['title'] = 'Employee';
    $d['department'] = $this->db->get('department')->result_array();
    $d['shift'] = $this->db->get('shift')->result_array();
    $d['account'] = $this->Admin_model->getAdmin($this->session->userdata['username']);

    // Form Validation
    $this->form_validation->set_rules('e_name', 'Employee Name', 'required|trim');
    $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email');
    $this->form_validation->set_rules('s_id', 'Shift', 'required|trim');
    $this->form_validation->set_rules('e_gender', 'Gender', 'required');
    $this->form_validation->set_rules('e_birth_date', 'Birth Date', 'required|trim');
    $this->form_validation->set_rules('e_hire_date', 'Hire Date', 'required|trim');

    if ($this->form_validation->run() == true) {
      $this->_addEmployee();
    }
    $this->load->view('templates/header', $d);
    $this->load->view('templates/sidebar');
    $this->load->view('templates/topbar');
    $this->load->view('master/employee/a_employee', $d); // Add Employee Page
    $this->load->view('templates/footer');
  }

  private function _addEmployee()
  {
    $name = $this->input->post('e_name');
    $department = $this->input->post('d_id');
    $email = $this->input->post('email');
    $gender = $this->input->post('e_gender');
    $birth_date = $this->input->post('e_birth_date');
    $hire_date = $this->input->post('e_hire_date');
    $shift_id = $this->input->post('s_id');

    // Check Email
    $query = "SELECT * FROM employee WHERE email = '$email'";
    $checkEmail = $this->db->query($query)->num_rows();

    if ($checkEmail > 0) {
      $this->session->set_flashdata('message', '<div class="alert alert-danger rounded-0 mb-2" role="alert">
      Email already used!</div>');
    }else{
      // Config Upload Image
      $config['upload_path'] = './images/pp/';
      $config['allowed_types'] = 'jpg|png|jpeg';
      $config['max_size'] = '2048';
      $config['file_name'] = 'item-' . date('ymd') . '-' . substr(md5(rand()), 0, 10);

      // load library upload and pass config
      $this->load->library('upload', $config);

      if ($_FILES['image']['name']) {
        if ($this->upload->do_upload('image')) {
          $image = $this->upload->data('file_name');
        }
      } else {
        $image = 'default.png';
      }

      $data = [
        'name' => $name,
        'email' => $email,
        'gender' => $gender,
        'image' => $image,
        'birth_date' => $birth_date,
        'hire_date' => $hire_date,
        'shift_id' => $shift_id
      ];

      $this->db->insert('employee', $data);
      $getEmp = $this->db->get_where('employee', ['email' => $data['email']])->row_array();
      // var_dump($getEmp);
      // die;
      $e_id = $getEmp['id'];
      $d = [
        'department_id' => $department,
        'employee_id' => $e_id
      ];

      $this->db->insert('employee_department', $d);
      $rows = $this->db->affected_rows();
      if ($rows > 0) {
        $this->session->set_flashdata('message', '<div class="alert alert-success rounded-0 mb-2" role="alert">
          Successfully added a new employee!</div>');
      } else {
        $this->session->set_flashdata('message', '<div class="alert alert-danger rounded-0 mb-2" role="alert">
          Failed to add data!</div>');
      }
      redirect('master/e_employee/'.$e_id);
    }

  }

  public function e_employee($e_id)
  {
    $d['title'] = 'Employee';
    $d['employee'] = $this->db->get_where('employee', ['id' => $e_id])->row_array();
    $d['department_current'] = $this->db->get_where('employee_department', ['employee_id' => $e_id])->row_array();
    $d['department'] = $this->db->get('department')->result_array();
    $d['shift'] = $this->db->get('shift')->result_array();
    $d['account'] = $this->Admin_model->getAdmin($this->session->userdata['username']);

    $this->form_validation->set_rules('e_name', 'Name', 'required|trim');
    $this->form_validation->set_rules('e_gender', 'Gender', 'required');
    $this->form_validation->set_rules('e_birth_date', 'Birth Date', 'required|trim');
    $this->form_validation->set_rules('e_hire_date', 'Hire Date', 'required|trim');
    $this->form_validation->set_rules('s_id', 'Shift', 'required|trim');
    $this->form_validation->set_rules('d_id', 'Department', 'required|trim');

    if ($this->form_validation->run() == true) {
      $name = $this->input->post('e_name');
      $gender = $this->input->post('e_gender');
      $birth_date = $this->input->post('e_birth_date');
      $hire_date = $this->input->post('e_hire_date');
      $d_id = $this->input->post('d_id');
      $s_id = $this->input->post('s_id');
      if (!empty($_FILES['image']['tmp_name'])) {
        // Config Upload Image
        $config['upload_path'] = './images/pp/';
        $config['allowed_types'] = 'jpg|png|jpeg';
        $config['max_size'] = '2048';
        $config['file_name'] = 'item-' . date('ymd') . '-' . substr(md5(rand()), 0, 10);

        // load library upload and pass config
        $this->load->library('upload', $config);

        if ($this->upload->do_upload('image')) {
          $image = $this->upload->data('file_name');
          $old_image = $d['employee']['image'];
          if ($old_image != 'default.png') {
            unlink('./images/pp/' . $old_image);
          }
        }
      } else {
        $image = $d['employee']['image'];
      }

      $data = [
        'name' => $name,
        'gender' => $gender,
        'image' => $image,
        'birth_date' => $birth_date,
        'hire_date' => $hire_date,
        'shift_id' => $s_id
      ];
      $department = [
        'department_id' => $d_id
      ];
      $this->_editEmployee($e_id, $data, $department);
    }
    $this->load->view('templates/header', $d);
    $this->load->view('templates/sidebar');
    $this->load->view('templates/topbar');
    $this->load->view('master/employee/e_employee', $d); // Edit Employee Page
    $this->load->view('templates/footer');
}
  private function _editEmployee($e_id, $data, $department)
  {
    $this->db->update('employee', $data, ['id' => $e_id]);
    $upd1 = $this->db->affected_rows();
    $this->db->update('employee_department', $department, ['employee_id' => $e_id]);
    $upd2 = $this->db->affected_rows();
    if ($upd1 > 0 && $upd2 > 0) {
      $this->session->set_flashdata('message', '<div class="alert alert-success rounded-0 mb-2" role="alert">
      Successfully updated an employee!</div>');
      redirect('master/e_employee/'.$e_id);
    } else if ($upd1 > 0 && $upd2 <= 0) {
      $this->session->set_flashdata('message', '<div class="alert alert-success rounded-0 mb-2" role="alert">
      Successfully updated an employee!</div>');
      redirect('master/e_employee/'.$e_id);
    } else if ($upd1  <= 0 && $upd2 > 0) {
      $this->session->set_flashdata('message', '<div class="alert alert-success rounded-0 mb-2" role="alert">
      Successfully updated an employee!</div>');
      redirect('master/e_employee/'.$e_id);
    } else {
      if(!empty($this->db->error()['message']))
        $this->session->set_flashdata('message', '<div class="alert alert-danger rounded-0 mb-2" role="alert">
        Failed to update employee\'s data!</div>');
      else
       $this->session->set_flashdata('message', '<div class="alert alert-warning rounded-0 mb-2" role="alert">
        There\'s no field has changed.</div>');
      redirect('master/e_employee/'.$e_id);
    }
  }
  public function d_employee($e_id)
  {
    $this->db->delete('employee', ['id' => $e_id]);
    $this->session->set_flashdata('message', '<div class="alert alert-success rounded-0 mb-2" role="alert">
        Successfully deleted an employee!</div>');
    redirect('master/employee');
  }
  public function location()
  {
    $d['title'] = 'Location';
    $d['location'] = $this->db->get('location')->result_array();
    $d['account'] = $this->Admin_model->getAdmin($this->session->userdata['username']);

    $this->load->view('templates/table_header', $d);
    $this->load->view('templates/sidebar');
    $this->load->view('templates/topbar');
    $this->load->view('master/location/index', $d);
    $this->load->view('templates/table_footer');
  }
  public function a_location()
  {
    $d['title'] = 'Location';
    $d['account'] = $this->Admin_model->getAdmin($this->session->userdata['username']);
    $this->form_validation->set_rules('l_name', 'Location Name', 'required|trim');
    if ($this->form_validation->run() == true) {
      $data['name'] = $this->input->post('l_name');
      $this->_addLocation($data);
    }
    $this->load->view('templates/header', $d);
    $this->load->view('templates/sidebar');
    $this->load->view('templates/topbar');
    $this->load->view('master/location/a_location', $d);
    $this->load->view('templates/footer');
  }
  private function _addLocation($data)
  {
    $this->db->insert('location', $data);
    $rows = $this->db->affected_rows();

    if ($rows > 0) {
      $id=$this->db->insert_id();
      $this->session->set_flashdata('message', '<div class="alert alert-success rounded-0 mb-2" role="alert">
        Successfully added a new location!</div>');
      redirect('master/e_location/'.$id);
  } else {
      $this->session->set_flashdata('message', '<div class="alert alert-danger rounded-0 mb-2" role="alert">
        Failed to add data!</div>');
    }
  }
  public function e_location($l_id)
  {
    // Edit Location
    $d['title'] = 'Location';
    $d['l_old'] = $this->db->get_where('location', ['id' => $l_id])->row_array();
    $d['account'] = $this->Admin_model->getAdmin($this->session->userdata['username']);

    // Form Validation
    $this->form_validation->set_rules('l_name', 'Location Name', 'required|trim');

    if ($this->form_validation->run() == true) {
      $name = $this->input->post('l_name');
      $this->_editLocation($l_id, $name);
    }
    $this->load->view('templates/header', $d);
    $this->load->view('templates/sidebar');
    $this->load->view('templates/topbar');
    $this->load->view('master/Location/e_location', $d); // Edit Location Page
    $this->load->view('templates/footer');
  }
  private function _editLocation($l_id, $name)
  {
    $data = ['name' => $name];
    $this->db->update('location', $data, ['id' => $l_id]);
    $rows = $this->db->affected_rows();

    if ($rows > 0) {
      $this->session->set_flashdata('message', '<div class="alert alert-success rounded-0 mb-2" role="alert">
          Successfully edited a location!</div>');
    redirect('master/e_location/'.$l_id);
    } else {
      if(!empty($this->db->error()['message']))
        $this->session->set_flashdata('message', '<div class="alert alert-danger rounded-0 mb-2" role="alert">
        Failed to edit data!</div>');
      else
        $this->session->set_flashdata('message', '<div class="alert alert-warning rounded-0 mb-2" role="alert">
        No Changes!</div>');
    }

  }
  public function d_location($l_id)
  {
    $query = 'ALTER TABLE `location` AUTO_INCREMENT = 1';
    $this->db->query($query);
    $this->db->delete('location', ['id' => $l_id]);
    $rows = $this->db->affected_rows();

    if ($rows > 0) {
      $this->session->set_flashdata('message', '<div class="alert alert-success rounded-0 mb-2" role="alert">
        Successfully deleted a location!</div>');
    } else {
      $this->session->set_flashdata('message', '<div class="alert alert-danger rounded-0 mb-2" role="alert">
        Failed to delete a data!</div>');
    }

    redirect('master/location');
  }
  // end of location

  public function users()
  {
    $query = "SELECT employee_department.employee_id AS e_id,
                     employee_department.department_id AS d_id,
                     users.username AS u_username,
                     employee.name AS e_name
                FROM employee_department
           LEFT JOIN users
                  ON employee_department.employee_id = users.employee_id
          INNER JOIN employee
                  ON employee_department.employee_id = employee.id
          ";
    $d['title'] = 'Users';
    $d['data'] = $this->db->query($query)->result_array();
    $d['account'] = $this->Admin_model->getAdmin($this->session->userdata['username']);

    $this->load->view('templates/table_header', $d);
    $this->load->view('templates/sidebar');
    $this->load->view('templates/topbar');
    $this->load->view('master/users/index', $d);
    $this->load->view('templates/table_footer');
  }

  public function a_users($e_id)
  {
    $empDep = $this->db->get_where('employee_department', ['employee_id' => $e_id])->row_array();
    $d['title'] = 'Users';
    $d['username'] = $empDep['department_id'] . $empDep['employee_id'];
    $d['e_id'] = $empDep['employee_id'];
    $d['account'] = $this->Admin_model->getAdmin($this->session->userdata['username']);

    $this->form_validation->set_rules('u_username', 'Username', 'required|trim|min_length[6]');
    $this->form_validation->set_rules('u_password', 'Password', 'required|trim|min_length[6]');

    if ($this->form_validation->run() == false) {
      $this->load->view('templates/header', $d);
      $this->load->view('templates/sidebar');
      $this->load->view('templates/topbar');
      $this->load->view('master/users/a_users', $d);
      $this->load->view('templates/footer');
    } else {
      $username = $this->input->post('u_username');
      if ($empDep['department_id'] != 'ADM') {
        $role_id = 2;
      } else {
        $role_id = 1;
      }
      $data = [
        'username' => $username,
        'password' => password_hash($this->input->post('u_password'), PASSWORD_DEFAULT),
        'employee_id' => $this->input->post('e_id'),
        'role_id' => $role_id
      ];
      $this->_addUsers($data);
    }
  }
  private function _addUsers($data)
  {
    $this->db->insert('users', $data);
    $rows = $this->db->affected_rows();
    if ($rows > 0) {
      $this->session->set_flashdata('message', '<div class="alert alert-success rounded-0 mb-2" role="alert">
          Successfully created an account!</div>');
    } else {
      $this->session->set_flashdata('message', '<div class="alert alert-danger rounded-0 mb-2" role="alert">
        Failed to create account!</div>');
    }
    redirect('master/users');
  }

  public function e_users($username)
  {
    $d['title'] = 'Users';
    $d['users'] = $this->db->get_where('users', ['username' => $username])->row_array();
    $d['account'] = $this->Admin_model->getAdmin($this->session->userdata['username']);

    $this->form_validation->set_rules('password', 'Password', 'required|trim|min_length[6]');

    if ($this->form_validation->run() == false) {
      $this->load->view('templates/header', $d);
      $this->load->view('templates/sidebar');
      $this->load->view('templates/topbar');
      $this->load->view('master/users/e_users', $d);
      $this->load->view('templates/footer');
    } else {
      $data = ['password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT)];
      $this->_editUsers($data, $username);
    }
  }
  private function _editUsers($data, $username)
  {
    $this->db->update('users', $data, ['username' => $username]);
    $rows = $this->db->affected_rows();
    if ($rows > 0) {
      $this->session->set_flashdata('message', '<div class="alert alert-success rounded-0 mb-2" role="alert">
          Successfully edited an account!</div>');
    } else {
      $this->session->set_flashdata('message', '<div class="alert alert-danger rounded-0 mb-2" role="alert">
        Failed to edit account!</div>');
    }
    redirect('master/users');
  }

  public function d_users($username)
  {
    $this->db->delete('users', ['username' => $username]);
    $rows = $this->db->affected_rows();
    if ($rows > 0) {
      $this->session->set_flashdata('message', '<div class="alert alert-success rounded-0 mb-2" role="alert">
          Successfully deleted an account!</div>');
    } else {
      $this->session->set_flashdata('message', '<div class="alert alert-danger rounded-0 mb-2" role="alert">
        Failed to delete account!</div>');
    }
    redirect('master/users');
  }
}
