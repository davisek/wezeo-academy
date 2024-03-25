<?php //Block::put('breadcrumb') ?>
<!--    <ol class="breadcrumb">-->
<!--        <li class="breadcrumb-item"><a href="--><?php //= Backend::url('applogger/logger/logs') ?><!--">Logs</a></li>-->
<!--        <li class="breadcrumb-item active" aria-current="page">--><?php //= e($this->pageTitle) ?><!--</li>-->
<!--    </ol>-->
<?php //Block::endPut() ?>
<!---->
<?php //if (!$this->fatalError): ?>
<!---->
<!--    --><?php //= Form::open(['class' => 'd-flex flex-column h-100']) ?>
<!---->
<!--        <div class="flex-grow-1">-->
<!--            --><?php //= $this->formRender() ?>
<!--        </div>-->
<!---->
<!--        <div class="form-buttons">-->
<!--            <div data-control="loader-container">-->
<!--                <button-->
<!--                    type="submit"-->
<!--                    data-request="onSave"-->
<!--                    data-request-message="--><?php //= __("Creating :name...", ['name' => $formRecordName]) ?><!--"-->
<!--                    data-hotkey="ctrl+s, cmd+s"-->
<!--                    class="btn btn-primary">-->
<!--                    --><?php //= __("Create") ?>
<!--                </button>-->
<!--                <button-->
<!--                    type="button"-->
<!--                    data-request="onSave"-->
<!--                    data-request-data="{ close: 1 }"-->
<!--                    data-request-message="--><?php //= __("Creating :name...", ['name' => $formRecordName]) ?><!--"-->
<!--                    data-hotkey="ctrl+enter, cmd+enter"-->
<!--                    class="btn btn-default">-->
<!--                    --><?php //= __("Create & Close") ?>
<!--                </button>-->
<!--                <span class="btn-text">-->
<!--                    <span class="button-separator">--><?php //= __("or") ?><!--</span>-->
<!--                    <a-->
<!--                        href="--><?php //= Backend::url('applogger/logger/logs') ?><!--"-->
<!--                        class="btn btn-link p-0">-->
<!--                        --><?php //= __("Cancel") ?>
<!--                    </a>-->
<!--                </span>-->
<!--            </div>-->
<!--        </div>-->
<!---->
<!--    --><?php //= Form::close() ?>
<!---->
<?php //else: ?>
<!---->
<!--    <p class="flash-message static error">-->
<!--        --><?php //= e($this->fatalError) ?>
<!--    </p>-->
<!--    <p>-->
<!--        <a-->
<!--            href="--><?php //= Backend::url('applogger/logger/logs') ?><!--"-->
<!--            class="btn btn-default">-->
<!--            --><?php //= __("Return to List") ?>
<!--        </a>-->
<!--    </p>-->
<!---->
<?php //endif ?>
