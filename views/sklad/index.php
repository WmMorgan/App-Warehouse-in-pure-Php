<?php
$this->title = "Список складов"
?>

<div class="col-lg-8">
    <div class="card">
        <div class="card-header">
            <strong class="card-title">Список складов</strong>
            <div class="d-flex justify-content-end">
            <a href="/sklad/create" class="btn btn-success">Создать склад</a>
            </div>
        </div>
        <div class="card-body">
            <table class="table">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Называние</th>
                    <th scope="col">Создано в</th>
                    <th scope="col">*</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($skladi as $i => $sklad): $i++;?>
                <tr>
                    <th scope="row"><?= $i ?></th>
                    <td><?= $sklad['name'] ?></td>
                    <td><?= date('d.m.Y / H:i', $sklad['created_at']) ?></td>
                    <td>
                        <a href="/sklad/update?id=<?=$sklad['id']?>" class="btn btn-primary"><i class="fa fa-pencil"></i></a>
                        <button type="button" class="btn btn-danger mb-1" data-toggle="modal" onclick="dSklad(<?=$sklad['id'] ?>)" data-target="#staticModal">
                            <i class="fa fa-trash"></i>
                        </button>
                    </td>
                </tr>
                <?php endforeach; ?>

                </tbody>
            </table>
        </div>
    </div>
</div>


<div class="modal fade" id="staticModal" tabindex="-1" role="dialog" aria-labelledby="staticModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticModalLabel">Удалить склад</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>
                    Вы уверены, что хотите удалить этот склад?
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
                <form action="/sklad/delete" method="post">
                    <input name="id" value="0" hidden>
                <button type="submit" class="btn btn-danger">Да</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>

        function dSklad(id) {

            document.querySelector('input[name="id"]').setAttribute('value',id);

        }

</script>