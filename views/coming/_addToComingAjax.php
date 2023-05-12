<div class="col-lg-12">
    <div class="card">
        <div class="card-header">
            <strong class="card-title">Приход товаров</strong>
        </div>
        <div class="card-body">
            <form action="coming/comingSave" method="post">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">ID</th>
                    <th scope="col">Называние</th>
                    <th scope="col">Количество</th>
                    <th scope="col">Цена</th>
                </tr>
                </thead>
                <tbody>
                <?php
                foreach ($comings as $k => $coming): $k++;?>

                <tr>
                    <th scope="row"><?= $k ?></th>
                    <td><?= $coming['product']['id'] ?></td>
                    <td><?= $coming['product']['name'] ?></td>
                    <td>
                        <input type="number" name="coming[<?=$coming['product']['id'] ?>][quantity]" value="<?= $coming['quantity'] ?>" class="form-control" style="display: inline; width: 20%;">
                        <?= $measures[$coming['product']['measure']] ?>
                    </td>
                    <td>
                        <input name="coming[<?=$coming['product']['id']?>][price]" type="text" class="form-control" style="display: inline; width: 40%;" value="<?= $coming['product']['price'] ?>">
                    </td>
                </tr>

                <?php endforeach; ?>
                </tbody>
            </table>
                <div class="d-flex justify-content-end">
                <button class="btn btn-success">Сделать приход</button>
                </div>
            </form>
        </div>
    </div>
</div>