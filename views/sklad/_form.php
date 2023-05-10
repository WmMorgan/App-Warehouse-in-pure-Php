
<form action="" method="post" class="">
    <div class="form-group">
        <label for="name" class=" form-control-label">Название</label>
        <input type="text" id="name" name="name" placeholder="Напишите.." value="<?= $this->old('name')?>" class="form-control">
    </div>

    <button type="submit" class="btn btn-primary">
        Создать
    </button>
</form>