<?= $this->section('styles') ?>
    <style>
        #operatorSelection, #partnerSelection {
            display: none;
        }
    </style>
<?= $this->endSection() ?>
<?= $this->extend('common/default-nav') ?>
<?= $this->section('content') ?>
<?php
$errors = session()->getFlashdata('errors');
?>

    <div class="row mt-4">
        <div class="col-md-12 col-sm-12 ">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title">Create User</h4>
                    <hr/>


                    <form method="post" action="<?= route_to('admin.users.save') ?>">
                        <?= csrf_field() ?>
                        <div class="row">
                            <div class="mb-2 col-md-6">
                                <label for="name" class="form-label"> <strong class="text-danger">*</strong> Name</label>
                                <input type="text" class="form-control" id="name" placeholder="Name" name="name" value="<?=old('name')?>">
                                <?php if (isset($errors['name']) && !empty($errors['name'])): ?>
                                    <div class="alert alert-danger alert-dismissible bg-transparent text-danger fade show mt-2 input-field-alert"
                                         role="alert">
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                aria-label="Close"></button>
                                        <?= $errors['name'] ?>
                                    </div>
                                <?php endif; ?>

                            </div>
                            <div class="mb-2 col-md-6">
                                <label for="username" class="form-label"> <strong class="text-danger">*</strong> Username</label>
                                <input type="text" class="form-control" id="username" placeholder="Username" value="<?=old('username')?>"
                                       name="username">
                                <?php if (isset($errors['username']) && !empty($errors['username'])): ?>
                                    <div class="alert alert-danger alert-dismissible bg-transparent text-danger fade show mt-2 input-field-alert"
                                         role="alert">
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                aria-label="Close"></button>
                                        <?= $errors['username'] ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="mb-2 col-md-6">
                                <label for="email" class="form-label"> <strong class="text-danger">*</strong> Email</label>
                                <input type="email" class="form-control" id="email" placeholder="Email" name="email" value="<?=old('email')?>">
                                <?php if (isset($errors['email']) && !empty($errors['email'])): ?>
                                    <div class="alert alert-danger alert-dismissible bg-transparent text-danger fade show mt-2 input-field-alert"
                                         role="alert">
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                aria-label="Close"></button>
                                        <?= $errors['email'] ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="mb-2 col-md-6">
                                <label for="password" class="form-label"> <strong class="text-danger">*</strong> Password</label>
                                <input type="password" class="form-control" id="password" placeholder="Password"
                                       name="password">
                                <?php if (isset($errors['password']) && !empty($errors['password'])): ?>
                                    <div class="alert alert-danger alert-dismissible bg-transparent text-danger fade show mt-2 input-field-alert"
                                         role="alert">
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                aria-label="Close"></button>
                                        <?= $errors['password'] ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                            
                            <div class="mb-2 col-md-6">
                                <label for="role" class="form-label"> <strong class="text-danger">*</strong> Role</label>
                                <select id="role" class="form-select" name="role">
                                    <?php if (isset($roles)): ?>
                                        <?php foreach ($roles as $role): ?>
                                            <option <?= old('role') == $role['id'] ? 'selected' : '' ?>
                                                    value="<?= $role['id'] ?>"><?= $role['role_name'] ?></option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>

                                </select>
                            </div>
                            
                            
                            <div class="mb-2 col-md-6">
                                <label for="userStatus" class="form-label"> <strong class="text-danger">*</strong> Status</label>
                                <select id="userStatus" class="form-select" name="status">
                                    <?php foreach (['active' => 'Active', 'inactive' => 'Inactive'] as $key => $value): ?>
                                        <option <?= old('status') == $key ? 'selected' : '' ?>
                                                value="<?= $key ?>"><?= $value ?></option>
                                    <?php endforeach; ?>

                                </select>
                            </div>


                        </div>

                        <button type="submit" class="btn btn-primary float-right">Create</button>
                    </form>
                </div>
            </div>
        </div>
        <!-- end col -->


    </div>
<?= $this->endSection() ?>


<?= $this->section('scripts') ?>
    <script>
        $(document).ready(function () {
            

         
              
        })
    </script>
<?= $this->endSection() ?>