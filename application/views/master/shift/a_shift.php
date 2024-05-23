        <!-- Begin Page Content -->
        <div class="container-fluid mb-3">

          <!-- Page Heading -->
          <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

          <a href="<?= base_url('master/shift'); ?>" class="btn btn-light bg-gradient-light border rounded-0 btn-icon-split mb-4">
            <span class="icon text-white">
              <i class="fas fa-chevron-left"></i>
            </span>
            <span class="text">Back</span>
          </a>
          <div class="row justify-content-center">
            <form action="" method="POST" class="col-lg-5 col-md-6 col-sm-12 col-xs-12 p-0">
              <div class="card rounded-0">
                <h5 class="card-header">Shift Master Data</h5>
                <div class="card-body">
                  <?= $this->session->flashdata('message') ?>
                  <h5 class="card-title">Add New shift</h5>
                  <p class="card-text">Form to add new shift to system</p>
                  <div class="form-group row">
                    <label class="col-sm-4 col-form-label col-form-label-lg">Shift Number</label>
                    <div class="col-sm-4">
                      <input type="text" readonly class="form-control-plaintext form-control-lg" value="<?= $s_id; ?>">
                    </div>
                  </div>
                  <?= form_error('s_id', '<small class="text-danger">', '</small>') ?>
                  <div class="form-group">
                    <label for="s_start_h" class="col-form-label-lg">Shift Start Time</label>
                    <div class="row">
                      <div class="col-sm-4">
                        <input type="number" class="form-control form-control-lg" name="s_start_h" id="s_start_h" max="23" min="0" placeholder="Hour" value="<?= !empty($this->input->post('s_start_h')) ? $this->input->post('s_start_h') : '' ?>">
                        <?= form_error('s_start_h', '<small class="text-danger">', '</small>') ?>
                      </div>
                      <div class="col-sm-4">
                        <input type="number" class="form-control form-control-lg" name="s_start_m" id="s_start_m" max="59" min="0" placeholder="Minutes" value="<?= !empty($this->input->post('s_start_m')) ? $this->input->post('s_start_m') : '' ?>">
                        <?= form_error('s_start_m', '<small class="text-danger">', '</small>') ?>
                      </div>
                      <div class="col-sm-4">
                        <input type="number" class="form-control form-control-lg" name="s_start_s" id="s_start_s" max="59" min="0" placeholder="Seconds" value="<?= !empty($this->input->post('s_start_s')) ? $this->input->post('s_start_s') : '' ?>">
                        <?= form_error('s_start_s', '<small class="text-danger">', '</small>') ?>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="s_end_h" class="col-form-label-lg">Shift End Time</label>
                    <div class="row">
                      <div class="col-sm-4">
                        <input type="number" class="form-control form-control-lg" name="s_end_h" id="s_end_h" max="23" min="0" placeholder="Hour" value="<?= !empty($this->input->post('s_end_h')) ? $this->input->post('s_end_h') : '' ?>">
                        <?= form_error('s_end_h', '<small class="text-danger">', '</small>') ?>
                      </div>
                      <div class="col-sm-4">
                        <input type="number" class="form-control form-control-lg" name="s_end_m" id="s_end_m" max="59" min="0" placeholder="Minutes" value="<?= !empty($this->input->post('s_end_m')) ? $this->input->post('s_end_m') : '' ?>">
                        <?= form_error('s_end_m', '<small class="text-danger">', '</small>') ?>
                      </div>
                      <div class="col-sm-4">
                        <input type="number" class="form-control form-control-lg" name="s_end_s" id="s_end_s" max="59" min="0" placeholder="Seconds" value="<?= !empty($this->input->post('s_end_s')) ? $this->input->post('s_end_s') : '' ?>">
                        <?= form_error('s_end_s', '<small class="text-danger">', '</small>') ?>
                      </div>
                    </div>
                  </div>
                  <button type="submit" class="btn btn-sm btn-primary bg-gradient-primary btn-icon-split mt-4 float-right rounded-0">
                    <span class="icon text-white">
                      <i class="fas fa-plus-circle"></i>
                    </span>
                    <span class="text">Save</span>
                  </button>
                </div>
              </div>
            </form>
          </div>
        </div>
        <!-- /.container-fluid -->

        </div>
        <!-- End of Main Content -->