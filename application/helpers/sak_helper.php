<?php

function is_logged_in()
{
  $ci = get_instance();
  if (!$ci->session->userdata['username']) {
    redirect('auth');
  } else {
    $role_id = $ci->session->userdata['role_id'];
    $menu = $ci->uri->segment(1);

    $queryMenu = $ci->db->get_where('user_menu', ['menu' => $menu])->row_array();
    $menu_id = $queryMenu['id'];
    $userAccess = $ci->db->get_where('user_access', ['role_id' => $role_id, 'menu_id' => $menu_id]);

    if ($userAccess->num_rows() < 1) {
      redirect('auth/blocked');
    }
  }
}

function is_weekends()
{
  date_default_timezone_set('Asia/Manila');
  $today = date('l', time());
  $weekends = ['Saturday', 'Sunday'];
  if (in_array($today, $weekends)) {
    return true;
  } else {
    return false;
  }
}

function is_checked_in()
{
  date_default_timezone_set('Asia/Manila');
  $ci = get_instance();
  $username = $ci->session->userdata('username');
  $today = date('Y-m-d', time());
  $query = "SELECT FROM_UNIXTIME(`in_time`, '%Y-%m-%d') AS `date`
              FROM `attendance`
             WHERE `username` = '$username'
               AND FROM_UNIXTIME(`in_time`, '%Y-%m-%d') = '$today'
  ";
  $ci->db->query($query)->result_array();
  $rows = $ci->db->affected_rows();
  if ($rows > 0) {
    return true;
  } else {
    false;
  }
}

function is_checked_out()
{
  date_default_timezone_set('Asia/Manila');
  $ci = get_instance();
  $username = $ci->session->userdata('username');
  $today = date('Y-m-d', time());
  $query = "SELECT * 
                FROM `attendance`
               WHERE (`out_time` != 0)
                 AND (`out_status` IS NOT NULL OR `out_status` != '')
                 AND (`username` = '$username')
                 AND (FROM_UNIXTIME(`in_time`, '%Y-%m-%d') = '$today');";
  $ci->db->query($query)->result_array();
  $rows = $ci->db->affected_rows();
  if ($rows > 0) {
    return true;
  } else {
    return false;
  }
}
