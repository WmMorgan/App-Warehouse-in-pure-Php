<?php
$this->title = "Приход товар";
?>

<div class="col-lg-12">

    <div class="form-group">
        <label class=" form-control-label">Введите называние товара:</label>
        <div class="input-group">
            <div class="input-group-addon"><i class="fa fa-search"></i></div>
            <input id="search" class="form-control" placeholder="красовка..">
        </div>
        <small class="form-text text-muted">напр. Красовка найк</small>
    </div>

    <div id="result"></div>

    <div id="resultComing">

        <?php
        if (!empty($comings)) {
        $this->renderPart('_addToComingAjax', [
            'comings' => $comings,
            'measures' => $measures
        ]);
        }
        ?>

    </div>
</div>

<script>


</script>