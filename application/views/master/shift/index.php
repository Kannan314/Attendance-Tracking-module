        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <div class="row align-items-center">
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 d-flex align-items-center">
              <h1 class="h3 text-gray-800 mb-0"><?= $title; ?></h1>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 justify-content-end d-flex align-items-center">
              <a href="<?= base_url('master/a_shift'); ?>" class="btn btn-primary btn-sm bg-gradient-primary rounded-0 btn-icon-split">
                <span class="icon text-white">
                  <i class="fas fa-plus-circle"></i>
                </span>
                <span class="text">Add New Shift</span>
              </a>
            </div>
          </div>
          <hr>
          <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
              <?= $this->session->flashdata('message'); ?>
            </div>
          </div>
          <!-- Data Table Shift-->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">DataTables Shift</h6>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Shift Start Time</th>
                      <th>Shift End Time</th>
                      <th>Actions</th>
                    </tr>
                  </thead>
                  
                  <tbody>
                    <?php
                    $i = 1;
                    foreach ($shift as $sft) :
                    ?>
                      <tr>
                        <td class="align-middle"><?= $i++; ?></td>
                        <td class="align-middle"><?= $sft['start']; ?></td>
                        <td class="align-middle"><?= $sft['end']; ?></td>
                        <td class="align-middle text-center">
                          <a href="<?= base_url('master/e_shift/') . $sft['id'] ?>" class="btn btn-primary rounded-0 btn-sm text-xs">
                            <span class="icon text-white" title="Edit">
                              <i class="fas fa-edit"></i>
                            </span>
                          </a> |
                          <a href="<?= base_url('master/d_shift/') . $sft['id'] ?>" class="btn btn-danger rounded-0 btn-sm text-xs" onclick="return confirm('Deleted Shift will lost forever. Still want to delete?')">
                            <span class="icon text-white" title="Delete">
                              <i class="fas fa-trash-alt"></i>
                            </span>
                          </a>
                        </td>
                      </tr>
                    <?php endforeach; ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>

        </div>
        <!-- /.container-fluid -->

        </div>
        <!-- End of Main Content -->