<label class="form-label" for="reservedNotification">Bind Name</label>
<div class="form-group mt-2 mb-2">
    <?php foreach($bindNames as $bindName): ?>
        <div class="row mb-2">
            <div class="col-md-10">
                <input type="text" class="form-control" readonly value="<?= $bindName['name'] ?>"  name="name"/>
            </div>


        </div>
    <?php endforeach; ?>
</div>
<div class="repeater" data-repeater="bindName">
    <div class="row">
        <div class="col-md-10">
            <div data-repeater-list="bindName">

                <div data-repeater-item class="row mb-2">
                    <div class="col-md-10">
                        <input type="text" class="form-control"
                               name="name"/>
                    </div>

                    <div class="col-md-2 col-auto  d-flex align-items-start align-items-center">
                        <button data-repeater-delete type="button"
                                class="btn btn-danger btn-xs"><i
                                    class="mdi mdi-trash-can"></i></button>
                    </div>
                </div>
            </div>


        </div>
        <div class="col-md-2 d-flex align-items-start align-items-center">
            <button data-repeater-create type="button"
                    class="btn btn-success btn-xs"><i class="mdi mdi-plus"></i>
            </button>
        </div>
    </div>
</div>