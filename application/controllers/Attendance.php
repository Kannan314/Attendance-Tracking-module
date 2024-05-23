<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Attendance extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    is_weekends();
    is_logged_in();
    is_checked_in();
    is_checked_out();
    $this->load->library('form_validation');
    $this->load->model('Public_model');
    $this->load->model('Admin_model');
  }
  public function index()
  {
    // Attendance Form
    $d['title'] = 'Attendance Form';
    $d['account'] = $this->Public_model->getAccount($this->session->userdata['username']);
    $d['location'] = $this->db->get('location')->result_array();

    // If Weekends
    if (is_weekends() == true) {
      $d['weekends'] = true;
      $this->load->view('templates/header', $d);
      $this->load->view('templates/sidebar');
      $this->load->view('templates/topbar');
      $this->load->view('attendance/index', $d); // Attendance Form Page
      $this->load->view('templates/footer');
    } else {
      $d['in'] = true;
      $d['weekends'] = false;
      // If haven't Time In Today
      if (is_checked_in() == false) {
        $d['in'] = false;

        $this->form_validation->set_rules('work_shift', 'Work Shift', 'required|trim');
        $this->form_validation->set_rules('location', 'Location', 'required|trim');

        if ($this->form_validation->run() == false) {
          $shift = $d['account']['shift'];
          $queryShift = "SELECT * FROM `shift` WHERE `id` = $shift";
          $resultShift = $this->db->query($queryShift)->row_array();
          $startTime = $resultShift['start'];
          $endTime = $resultShift['end'];
          $d['startTime'] = $startTime;
          $d['endTime'] = $endTime;

          $this->load->view('templates/header', $d);
          $this->load->view('templates/sidebar');
          $this->load->view('templates/topbar');
          $this->load->view('attendance/index', $d); // Attendance Form Page
          $this->load->view('templates/footer');
        } else {
          date_default_timezone_set('Asia/Manila');
          $shift = $d['account']['shift'];
          $queryShift = "SELECT * FROM `shift` WHERE `id` = $shift";
          $resultShift = $this->db->query($queryShift)->row_array();
          $startTime = $resultShift['start'];

          $username = $this->session->userdata['username'];
          $employee_id = $d['account']['id'];
          $department_id = $d['account']['department_id'];
          $shift_id = $this->input->post('work_shift');
          $location_id = $this->input->post('location');
          $iTime = time();
          $notes = $this->input->post('notes');
          $lack = 'None';

          // Time In Time
          if (date('H:i:s', $iTime) <= $startTime) {
            $inStatus = 'On Time';
          } else {
            $inStatus = 'Late';
          };

          // Check Notes
          if (!$notes) {
            $lack = 'Notes';
          }

          // Config Upload
          $config['upload_path'] = './images/attendance/';
          $config['allowed_types'] = 'jpg|png|jpeg';
          $config['max_size'] = '2048';
          $config['file_name'] = 'item-' . date('ymd') . '-' . substr(md5(rand()), 0, 10);

          // Load Upload Library and Pass Config
          $this->load->library('upload', $config);

          if ($_FILES['image']['name']) {
            if ($this->upload->do_upload('image')) {
              $image = $this->upload->data('file_name');
              $value = [
                'username' => $username,
                'employee_id' => $employee_id,
                'department_id' => $department_id,
                'shift_id' => $shift_id,
                'location_id' => $location_id,
                'in_time' => $iTime,
                'notes' => $notes,
                'image' => $image,
                'lack_of' => $lack,
                'in_status' => $inStatus
              ];
            } else {
              $this->upload->display_errors();
            }
          } else {
            if ($lack != '') {
              $lack .= ',image';
            } else {
              $lack = 'image';
            }
            $value = [
              'username' => $username,
              'employee_id' => $employee_id,
              'department_id' => $department_id,
              'shift_id' => $shift_id,
              'location_id' => $location_id,
              'in_time' => $iTime,
              'notes' => $notes,
              'lack_of' => $lack,
              'in_status' => $inStatus
            ];
          }
          $this->_checkIn($value);
        }
      }
      // End of Today Time In
      // If Checked In
      else {
        if (is_checked_out() == true) {
          $d['disable'] = true;
        } else {
          $d['disable'] = false;
        };
        $this->load->view('templates/header', $d);
        $this->load->view('templates/sidebar');
        $this->load->view('templates/topbar');
        $this->load->view('attendance/index', $d); // Attendance Form Page
        $this->load->view('templates/footer');
      }
    }
  }
  // Check Time In
  private function _checkIn($value)
  {
    $this->db->insert('attendance', $value);
    $rows = $this->db->affected_rows();
    if ($rows > 0) {
      $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
                                     Stamped attendance for today</div>');
    } else {
      $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
                                     Failed to stamp your attendance!</div>');
    }
    redirect('attendance');
  }

  // Check Time Out
  public function checkOut()
  {
    $username = $this->session->userdata['username'];
    $today = date('Y-m-d', time());
    $querySelect = "SELECT  attendance.username AS `username`,
                            attendance.employee_id AS `employee_id`,
                            attendance.shift_id AS `shift_id`,
                            attendance.in_time AS `in_time`,
                            shift.start AS `start`,
                            shift.end AS `end`
                      FROM  `attendance`
                INNER JOIN  `shift`
                        ON  attendance.shift_id = shift.id
                     WHERE  `username` = '$username'
                       AND  FROM_UNIXTIME(`in_time`, '%Y-%m-%d') = '$today'";
    $checkOut = $this->db->query($querySelect)->row_array();

    $oTime = time();

    // Time Out Time
    if (date('H:i:s', $oTime) >= $checkOut['end']) {
      $outStatus = 'Over Time';
    } else {
      $outStatus = 'Early';
    };

    $value = [
      'out_time' => $oTime,
      'out_status' => $outStatus
    ];

    $queryUpdate = "UPDATE `attendance`
                       SET `out_time` ='" . $value['out_time'] . "', `out_status` ='" . $value['out_status'] . "' WHERE  `username` = '$username' AND  FROM_UNIXTIME(`in_time`, '%Y-%m-%d') = '$today'";
    $this->db->query($queryUpdate);
    redirect('attendance');
  }

  public function history()
  {
    $d['title'] = 'Attendance History';
    $d['account'] = $this->Public_model->getAccount($this->session->userdata['username']);
    $d['e_id'] = $d['account']['id'];
    $d['data'] = $this->attendance_details_data($d['e_id']);

    $this->load->view('templates/table_header', $d);
    $this->load->view('templates/sidebar');
    $this->load->view('templates/topbar');
    $this->load->view('attendance/history', $d);
    $this->load->view('templates/table_footer');
  }
  
  private function attendance_details_data($e_id)
  {
    $start = $this->input->get('start');
    $end = $this->input->get('end');

    $d['attendance'] = $this->Public_model->get_emp_attendance($e_id, $start, $end);

    $d['start'] = $start;
    $d['end'] = $end;

    return $d;
  }
}
