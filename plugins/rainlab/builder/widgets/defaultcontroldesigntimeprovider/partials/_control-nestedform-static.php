<div class="builder-form-container builder-blueprint-control-repeater control-static-contents" data-control-container data-container-name="form">
    <?php
        $controls = [];

        if (isset($controlConfiguration['form']['fields'])) {
            $controls = $controlConfiguration['form']['fields'];
        }
    ?>

    <?= $formBuilder->renderControlList($controls) ?>
</div>
