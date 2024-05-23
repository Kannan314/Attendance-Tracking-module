        <!-- Begin Page Content -->
        <div class="container-fluid py-3">

          <!-- Page Heading -->
          <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

          <a href="<?= base_url('master/users'); ?>" class="btn btn-light bg-gradient-light border btn-icon-split mb-4 rounded-0">
            <span class="icon text-white">
              <i class="fas fa-chevron-left"></i>
            </span>
            <span class="text">Back</span>
          </a>
          <div class="row justify-content-center">
            <div class="col-lg-5 p-0">
              <form action="<?= base_url('master/a_users/') . $e_id; ?>" method="POST">
                <div class="card rouded-0">
                  <h5 class="card-header">Users Master Data</h5>
                  <div class="card-body">
                    <h5 class="card-title">Add New Users</h5>
                    <p class="card-text">Form to add new users to system</p>
                    <input type="hidden" name="e_id" value="<?= $e_id; ?>">
                    <div class="form-group row">
                      <label for="u_username" class="col-form-label col-lg-4">Username</label>
                      <div class="col p-0">
                        <input type="text" readonly class="form-control-plaintext col-lg" name="u_username" id="u_username" value="<?= $username; ?>">
                        <?= form_error('u_username', '<small class="text-danger">', '</small>') ?>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="u_password" class="col-form-label col-lg-4">Password</label>
                      <div class="col p-0">
                        <input type="password" class="form-control col-lg" name="u_password" id="u_password">
                        <?= form_error('u_password', '<small class="text-danger">', '</small>') ?>
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
        </div>
        <!-- /.container-fluid -->

        </div>
        <!-- End of Main Content -->