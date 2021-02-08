               <!-- Begin Page Content -->
               <div class="container-fluid">

                   <!-- Page Heading -->
                   <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>
                   <div class="row">
                       <div-col-lg-6>
                           <?= $this->session->flashdata('message'); ?>
                       </div-col-lg-6>
                   </div>
                   <div class="card" style="width: 18rem;">
                       <img src="<?= base_url('assets/img/profile/') . $user['image']; ?>">
                       <div class="card-body">
                           <h5 class="card-title"><?= $user['name']; ?></h5>
                           <p class="card-text"><?= $user['email']; ?></p>
                           <p class="card-text"><small class="text-muted">Registered since <?= date('D F Y') ?></small></p>
                       </div>
                   </div>

               </div>
               <!-- /.container-fluid -->

               </div>
               <!-- End of Main Content -->