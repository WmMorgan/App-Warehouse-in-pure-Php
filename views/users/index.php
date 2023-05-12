<?php

use func\actions\Users;

$this->title = "Список пользователей";
?>

<div class="col-lg-8">
    <div class="card">
        <div class="card-header">
            <strong class="card-title"><?= $this->title ?></strong>
        </div>
        <div class="table-stats order-table ov-h">
            <table class="table ">
                <thead>
                <tr>
                    <th class="serial">#</th>
                    <th>ID</th>
                    <th>Email</th>
                    <th>Статус</th>
                    <th>Позиция</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($users as $k => $user): $k++;?>
                <tr>
                    <td class="serial"><?=$k?>.</td>
                    <td> #<?= $user['id'] ?> </td>
                    <td>  <span class="email"><?=$user['login'] ?></span> </td>
                    <td>  <span class="sts"><?=$this->status[$user['status']] ?></span> </td>
                    <td> <?=$user['role'] == Users::ROLE_ADMIN ?
                            "<b class='badge badge-complete'>Админ</b>" : "<b class='badge badge-warning'>Пользователь</b>" ?> </td>
                </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>