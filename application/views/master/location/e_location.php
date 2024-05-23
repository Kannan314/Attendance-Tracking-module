        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

          <a href="<?= base_url('master/location'); ?>" class="btn btn-light bg-gradient-light border btn-icon-split mb-4 rounded-0">
            <span class="icon text-white">
              <i class="fas fa-chevron-left"></i>
            </span>
            <span class="text">Back</span>
          </a>
          <div class="row justify-content-center">
            <form action="" method="POST" class="col-lg-5 col-md-6 col-sm-12 col-xs-12 p-0">
              <div class="card rounded-0">
                <h5 class="card-header">Location Master Data</h5>
                <div class="card-body">
                  <?= $this->session->flashdata('message') ?>
                  <h5 class="card-title">Edit Location</h5>
                  <p class="card-text">Form to edit location in system</p>
                  <div class="form-group">
                    <label class="col-form-label-lg">Location ID</label>
                    <input type="text" readonly class="form-control-plaintext form-control-lg" name="l_id" value="<?= $l_old['id']; ?>">
                  </div>
                  <div class="form-group">
                    <label for="l_name" class="col-form-label-lg">Location Name</label>
                    <input type="text" class="form-control form-control-lg" name="l_name" id="l_name" value="<?= $l_old['name']; ?>">
                    <?= form_error('l_name', '<small class="text-danger">', '</small>') ?>
                  </div>
                  <button type="submit" class="btn btn-sm btn-primary bg-gradient-primary btn-icon-split mt-4 float-right rounded-0">
                    <span class="icon text-white">
                      <i class="fas fa-check"></i>
                    </span>
                    <span class="text">Save Change</span>
                  </button>
                </div>
              </div>
            </form>
          </div>
        </div>
        <!-- /.container-fluid -->

        </div>
        <!-- End of Main Content -->