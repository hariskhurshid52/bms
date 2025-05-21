<?= $this->section('styles') ?>
<?= $this->endSection() ?>
<?= $this->extend('common/default-nav') ?> <?= $this->section('content') ?>


<?php
$errors = session()->getFlashdata('errors');
?>

<div class="row mt-4">
    <div class="col-md-12 col-sm-12 ">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title">Edit User Details</h4>
                <hr/>


                <form method="post" action="<?= route_to('admin.users.update') ?>">
                    <?= csrf_field() ?>
                    <?=form_hidden(['userId' => $user['id']])?>
                    <div class="row">
                        <div class="mb-2 col-md-6">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" placeholder="Name" name="name" value="<?= $user['name'] ?>">
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
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control" id="username" placeholder="Username" name="username" value="<?= $user['username'] ?>">
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
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" placeholder="Email" name="email" value="<?= $user['email'] ?>">
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
                            <label for="password" class="form-label">Password</label>
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
                            <label for="role" class="form-label">Role</label>
                            <select id="role" class="form-select" name="role">
                                <?php if (isset($roles)): ?>
                                    <?php foreach ($roles as $role): ?>
                                        <option <?= $user['role_id'] == $role['id'] ? 'selected' : '' ?>  value="<?= $role['id'] ?>"><?= $role['role_name'] ?></option>
                                    <?php endforeach; ?>
                                <?php endif; ?>

                            </select>
                            <?php if (isset($errors['role']) && !empty($errors['role'])): ?>
                                <div class="alert alert-danger alert-dismissible bg-transparent text-danger fade show mt-2 input-field-alert"
                                     role="alert">
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                            aria-label="Close"></button>
                                    <?= $errors['role'] ?>
                                </div>
                            <?php endif; ?>
                        </div>


                        <div class="mb-2 col-md-6">
                            <label for="userStatus" class="form-label">Status</label>
                            <select id="userStatus" class="form-select" name="status">
                                <?php foreach (['active' => 'Active', 'inactive' => 'Inactive'] as $key => $value): ?>
                                    <option <?= $user['status'] == $key ? 'selected' : '' ?>  value="<?= $key ?>"><?= $value ?></option>
                                <?php endforeach; ?>

                            </select>
                            <?php if (isset($errors['status']) && !empty($errors['status'])): ?>
                                <div class="alert alert-danger alert-dismissible bg-transparent text-danger fade show mt-2 input-field-alert"
                                     role="alert">
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                            aria-label="Close"></button>
                                    <?= $errors['status'] ?>
                                </div>
                            <?php endif; ?>
                        </div>


                    </div>

                    <button type="submit" class="btn btn-primary float-right">Update</button>
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
        $('#role').change(() => {
            let role = $('#role').val();
            // if (role != 1) {
            //     $('#operatorSelection').removeClass('d-none');
            // } else {
            //     $('#operatorSelection').addClass('d-none');
            // }

            if (role === '3') {
                $('#partnerSelection').show();
                $('#operatorSelection').show();
            }else if (role != 1) {
                $('#operatorSelection').show();
                $('#partnerSelection').hide();
            } else {
                $('#operatorSelection').hide();
                $('#partnerSelection').hide();
            }
        })

    })
</script>
<?= $this->endSection() ?>

