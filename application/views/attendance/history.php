<!-- Begin Page Content -->
<div class="container-fluid">
  <!-- Page Heading -->
  <div class="d-flex w-100 align-items-center">
    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
      <h1 class="h3 mb-0 text-gray-800"><?= $title; ?></h1>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 text-right">
    </div>
  </div>
  <hr>
  <div class="card rounded-0 shadow mb-3">
    <div class="card-body">
      <fieldset class="border rounded-0 px-2 pb-2">
        <legend class="ml-3 px-3 w-auto">Filter Report</legend>
        <form action="" method="GET">
          <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-12">
              <input type="date" name="start" class="form-control form-control-sm rounded-0" value="<?= !empty($this->input->get('start')) ? $this->input->get('start') : '' ?>">
              <?= form_error('start', '<small class="text-danger pl-3">', '</small>') ?>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12">
              <input type="date" name="end" class="form-control form-control-sm rounded-0" value="<?= !empty($this->input->get('end')) ? $this->input->get('end') : '' ?>">
              <?= form_error('end', '<small class="text-danger pl-3">', '</small>') ?>
            </div>
            <div class="col-2">
              <button type="submit" class="btn btn-primary btn-sm rounded-0 bg-gradient-primary "><i class="fa fa-file"></i> Show Attendance</button>
            </div>
          </div>
        </form>
      </fieldset>
    </div>
  </div>

  <?php if ($data['attendance']) : ?>
    <div class="card shadow mb-4 rounded-0">
      <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-dark">Data Attendance</h6>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
            <thead class="bg-gradient-primary text-white">
              <tr>
                <th>#</th>
                <th>Date</th>
                <th>Shift</th>
                <th>Time In</th>
                <th>Notes</th>
                <th>Image</th>
                <th>Lack Of</th>
                <th>In Status</th>
                <th>Time Out</th>
                <th>Out Status</th>
              </tr>
            </thead>
            <tbody>
              <?php
              // looping attendance list
              $i = 1;
              foreach ($data['attendance'] as $atd) :
              ?>
                <tr <?php if (date('l', $atd['date']) == 'Saturday' || date('l', $atd['date']) == 'Sunday') {
                      echo "class ='bg-secondary text-white'";
                    } ?>>

                  <!-- Column 1 -->
                  <td><?= $i++; ?></td>
                  <?php

                  // if WEEKENDS
                  if (date('l', $atd['date']) == 'Saturday' || date('l', $atd['date']) == 'Sunday') : ?>
                    <!-- Column 2 -->
                    <td colspan="6" class="text-center">OFF</td>
                  <?php

                  // if WEEKDAYS
                  else : ?>
                    <!-- Column 2 (Date) -->
                    <td><?= date('l, d F Y', $atd['date']); ?></td>

                    <!-- Column 3 (Shift) -->
                    <td>
                     <div style="line-height:1em">
                        <div class="text-xs"><?= date("h:i A", strtotime('2022-06-23 '.$atd['start'])) ?></div>
                        <div class="text-xs"><?= date("h:i A", strtotime('2022-06-23 '.$atd['end'])) ?></div>
                      </div>  
                    </td>

                    <!-- Column 4 (Time In) -->
                    <td><?= date('h:i:s A', $atd['date']); ?></td>

                    <!-- Column 5 (Notes) -->
                    <td><?= $atd['notes']; ?></td>

                    <!-- Column 6 (Image) -->
                    <td><?php if ($atd['image']) : ?>
                        <img src="<?= base_url('images/attendance/') . $atd['image']; ?>" style="height: 70px">
                      <?php else : ?>
                        Image Not Found
                      <?php endif; ?>
                    </td>

                    <!-- Column 7 (Lack Of) -->
                    <td><?= $atd['lack_of']; ?></td>


                    <!-- Column 8 (In Status) -->
                    <td><?= $atd['in_status']; ?></td>

                    <!-- Column 9 (Time Out) -->
                    <td><?php if ($atd['out_time'] == 0) {
                          echo "Haven't Checked Out";
                        } else {
                          echo date('h:i:s A', $atd['out_time']);
                        }
                        ?>
                    </td>

                    <!-- Column 10 (Out Status) -->
                    <td><?= $atd['out_status']; ?></td>

                  <?php endif; ?>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  <?php else : ?>
    <h1 class="text-center">Please Pick Your Date</h1>
  <?php endif; ?>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->