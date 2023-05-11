<div class="col-lg-12">
    <div class="card">
        <div class="card-header">
            <strong class="card-title">Приход товаров</strong>
        </div>
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">ID</th>
                    <th scope="col">Называние</th>
                    <th scope="col">Количество</th>
                    <th scope="col">*</th>
                </tr>
                </thead>
                <tbody>
                <?php
                foreach ($comings as $k => $coming): $k++;?>

                <tr>
                    <th scope="row"><?= $k ?></th>
                    <td><?= $coming['product']['id'] ?></td>
                    <td><?= $coming['product']['name'] ?></td>
                    <td><?= $coming['quantity'] .' ('.$measures[$coming['product']['measure']].')' ?></td>
                    <td>
                        <button class="btn btn-danger">-</button>
                        <button class="btn btn-success">+</button>
                    </td>
                </tr>

                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>