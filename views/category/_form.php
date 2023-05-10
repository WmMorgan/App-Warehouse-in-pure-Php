
<form action="" method="post" class="">
    <div class="form-group">
        <label for="name" class=" form-control-label">Название</label>
        <input type="text" id="name" name="name" placeholder="Напишите.." value="<?= $this->old('name')?>" class="form-control">
        <label for="description" class=" form-control-label">описание</label>
        <textarea id="description" name="description" placeholder="описание..." class="form-control" rows="4" cols="50"><?= $this->old('description')?></textarea>
    </div>

    <button type="submit" class="btn btn-primary">
        Создать
    </button>
</form>