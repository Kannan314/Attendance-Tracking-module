       <!-- Begin Page Content -->
       <div class="container-fluid">

         <!-- Page Heading -->
         <div class="d-sm-flex align-items-center justify-content-between mb-4">
           <h1 class="h3 mb-0 text-gray-800"><?= $title; ?></h1>
         </div>

         <!-- Content Row -->
         <div class="row">

           <!-- Earnings (Monthly) Card Example -->
           <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-xs-12 mb-4">
             <div class="card border-left-primary shadow h-100 py-2 rounded-0 border-4">
               <div class="card-body py-1">
                 <div class="row no-gutters align-items-center">
                   <div class="col mr-2">
                     <div class="text-lg font-weight-bold mb-1">Departments</div>
                     <div class="h5 mb-0 font-weight-bold text-gray-800 text-right"><?= $display['c_department']; ?></div>
                   </div>
                   <div class="col-auto">
                     <i class="fas fa-building fa-2x text-gray-300"></i>
                   </div>
                 </div>
               </div>
             </div>
           </div>
           <!-- Earnings (Monthly) Card Example -->
           <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-xs-12 mb-4">
             <div class="card border-left-info shadow h-100 py-2 rounded-0 border-4">
               <div class="card-body py-1">
                 <div class="row no-gutters align-items-center">
                   <div class="col mr-2">
                     <div class="text-lg font-weight-bold mb-1">Shifts</div>
                     <div class="h5 mb-0 font-weight-bold text-gray-800 text-right"><?= $display['c_shift']; ?></div>
                   </div>
                   <div class="col-auto">
                     <i class="fas fa-exchange-alt fa-2x text-gray-300"></i>
                   </div>
                 </div>
               </div>
             </div>
           </div>

           <!-- Earnings (Monthly) Card Example -->
           <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-xs-12 mb-4">
             <div class="card border-left-success shadow h-100 py-2 rounded-0 border-4">
               <div class="card-body py-1">
                 <div class="row no-gutters align-items-center">
                   <div class="col mr-2">
                     <div class="text-lg font-weight-bold mb-1">Employees</div>
                     <div class="h5 mb-0 font-weight-bold text-gray-800 text-right"><?= $display['c_employee']; ?></div>
                   </div>
                   <div class="col-auto">
                     <i class="fas fa-id-badge fa-2x text-gray-300"></i>
                   </div>
                 </div>
               </div>
             </div>
           </div>

           <!-- Pending Requests Card Example -->
           <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-xs-12 mb-4">
             <div class="card border-left-danger shadow h-100 py-2 rounded-0 border-4">
               <div class="card-body py-1">
                 <div class="row no-gutters align-items-center">
                   <div class="col mr-2">
                     <div class="text-lg font-weight-bold mb-1">Users</div>
                     <div class="h5 mb-0 font-weight-bold text-gray-800 text-right"><?= $display['c_users']; ?></div>
                   </div>
                   <div class="col-auto">
                     <i class="fas fa-users fa-2x text-gray-300"></i>
                   </div>
                 </div>
               </div>
             </div>
           </div>
         </div>

         <!-- Content Row -->

         <div class="row">

           <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-xs-12">
             <!-- Pie Chart -->
             <div class="col p-0">
               <div class="card shadow mb-4 rounded-0">
                 <!-- Card Header - Dropdown -->
                 <div class="card-header py-3 d-flex flex-rowz align-items-center justify-content-between">
                   <h6 class="m-0 font-weight-bold text-muted">Departments' Employees</h6>
                   <a class="text-reset font-weight-bolder text-muted" title="Go to Department List" href="<?= base_url('admin') ?>"><i class="fa fa-arrow-right"></i></a>
                 </div>
                 <!-- Card Body -->
                 <div class="card-body overflow-auto" style="max-height: 400px;">
                   <table class="table table-bordered table-striped">
                     <thead class="bg-gradient-primary text-white">
                       <tr>
                         <th class="text-center p-1" scope="col">#</th>
                         <th class="p-1" scope="col">Dept Code</th>
                         <th class="p-1" scope="col">Employees</th>
                       </tr>
                     </thead>
                     <tbody>
                       <?php $i = 1;
                        foreach ($d_list as $d) : ?>
                         <tr>
                           <th class="text-center p-1" scope="row"><?= $i++ ?></th>
                           <td class="p-1"><?= $d['d_id'] ?></td>
                           <td class="p-1 text-right"><?= number_format($d['qty']) ?></td>
                         </tr>
                       <?php endforeach; ?>
                     </tbody>
                   </table>
                 </div>
               </div>
             </div>
           </div>
           <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-xs-12">
             <div class="col p-0">
               <div class="card shadow mb-4 rounded-0">
                 <!-- Card Header - Dropdown -->
                 <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                   <h6 class="m-0 font-weight-bold text-muted">Employees per Shift</h6>
                 </div>
                 <!-- Card Body -->
                 <div class="card-body" style="max-height: 370px;">
                   <table class="table table-bordered table-striped">
                     <thead class="bg-gradient-primary text-white">
                       <tr>
                         <th class="text-center p-1" scope="col">#</th>
                         <th class="p-1" scope="col">Shift</th>
                         <th class="p-1" scope="col">Employees</th>
                       </tr>
                     </thead>
                     <tbody>
                       <?php $i = 1;
                        foreach ($s_list as $s) : ?>
                         <?php if ($s['s_id'] == 0) {
                            continue;
                          } 
                          ?>
                         <tr>
                           <th class="text-center p-1" scope="row"><?= $i++ ?></th>
                           <td class="p-1 align-middle">Shift: <?= $s['s_id'] ?> <small>(<?= date('h:i A', strtotime("2022-06-23". $s['start'])) ?> - <?= date('h:i A', strtotime("2022-06-23". $s['end'])) ?>)</small></td>
                           <td class="p-1 text-right"><?= number_format($s['qty']) ?></td>
                         </tr>
                       <?php endforeach; ?>
                     </tbody>
                   </table>
                 </div>
               </div>
             </div>
           </div>
         </div>
       </div>
       <!-- /.container-fluid -->

       </div>
       <!-- End of Main Content -->