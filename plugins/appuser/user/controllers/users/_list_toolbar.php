<div data-control="toolbar loader-container">
<!--    <a-->
<!--        href="--><?php //= Backend::url('appuser/user/users/create') ?><!--"-->
<!--        class="btn btn-primary">-->
<!--        <i class="icon-plus"></i>-->
<!--        --><?php //= __("New :name", ['name' => 'User']) ?>
<!--    </a>-->

<!--    <div class="toolbar-divider"></div>-->

    <?php if (BackendAuth::userHasAccess('appuser.user.manage_users')): ?>
    <button
        class="btn btn-secondary"
        data-request="onDelete"
        data-request-message="<?= __("Deleting...") ?>"
        data-request-confirm="<?= __("Are you sure?") ?>"
        data-list-checked-trigger
        data-list-checked-request
        disabled>
        <i class="icon-delete"></i>
        <?= __("Delete") ?>
    </button>
    <?php endif ?>

</div>
