<?php
$this->title = "Посмотреть продукт";
?>

<div class="col-lg-8">
    <div class="card">
        <div class="card-header">
            <strong class="card-title"><?= $this->title ?></strong>
        </div>
        <div class="card-body">

            <table class="table table-bordered">

                <tbody>
                <tr>
                    <th scope="row">Называние</th>
                    <td><?= $product['name'] ?></td>
                </tr>
                <tr>
                    <th scope="row">Категория</th>
                    <td><?= $product['category_id'] ?></td>
                </tr>
                <tr>
                    <th scope="row">Количество</th>
                    <td><?= $product['quantity'] ?></td>
                </tr>
                <tr>
                    <th scope="row">Мера</th>
                    <td><?= $this->measures[$product['measure']] ?></td>
                </tr>
                <tr>
                    <th scope="row">Создано в</th>
                    <td><?= date('d.m.Y / H:i', $product['created_at']) ?></td>
                </tr>
                </tbody>
            </table>

            <?php if ($product['image']): ?>
            <img src="<?=FILES.'/'.$product['image'] ?>"/>
            <?php endif; ?>
        </div>
    </div>
</div>
