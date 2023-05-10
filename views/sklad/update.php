<?php
$this->title = "Изменит склад";
?>
<div class="col-lg-6">
    <div class="card">
        <div class="card-header">
            <strong><?= $this->title ?></strong>
        </div>
        <div class="card-body card-block">
            <?= showErrorMessage($this->err) ?>
            <?php include_once '_form.php'; ?>

        </div>

    </div>
</div>