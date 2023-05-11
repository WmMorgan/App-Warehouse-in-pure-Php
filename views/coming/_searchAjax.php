<div class="col-lg-12">
    <div class="card">

        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Называние</th>
                    <th scope="col">Остатка</th>
                    <th scope="col">*</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($products as $k => $product): $k++;?>
                <tr>
                    <th scope="row"><?= $k ?></th>
                    <td><?= $product['name'] ?></td>
                    <td><?= $product['quantity'].' ('.$measures[$product['measure']].')' ?></td>
                    <td><button onclick="addToComing(<?= $product['id'] ?>)" class="btn btn-success" style="font-weight: 700">+</button></td>
                </tr>

                <?php endforeach; ?>

                </tbody>
            </table>
        </div>
    </div>
</div>