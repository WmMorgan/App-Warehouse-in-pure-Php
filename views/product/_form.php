<form action="" method="post" class="" enctype="multipart/form-data">
    <div class="form-group">
        <label for="name" class=" form-control-label">Название</label>
        <input type="text" id="name" name="name" placeholder="Напишите.." value="<?= $this->old('name') ?>"
               class="form-control">
    </div>
    <div class="row form-group">
        <div class="col col-md-4">
            <label for="price" class="pr-1  form-control-label">Цена</label>
            <input name="price" type="text" id="price" placeholder="например: 10000" class="form-control" value="<?= $this->old('price')?>">
        </div>
        <div class="col col-md-8">
        <label for="category_id" class="pr-1  form-control-label">Категория</label>
        <select name="category_id" id="select" class="form-control">
            <?php foreach ($this->getCategories() as $category): ?>
                <option value="<?= $category['id'] ?>"
                    <?=$category['id'] == $this->old('category_id') ? "selected" : false ?>>
                    <?= $category['name']?></option>
            <?php endforeach; ?>
        </select>
        </div>
    </div>
    <div class="row form-group">
        <div class="col col-md-4">
            <label for="quantity" class="pr-1  form-control-label">количество</label>
            <input name="quantity" type="text" id="quantity" placeholder="например: 100" class="form-control" value="<?= $this->old('quantity')?>">
        </div>
        <div class="col col-md-6">
            <label for="category" class="pr-1  form-control-label">Мера</label>
            <select name="measure" class="form-control">
                <?php foreach ($this->measures as $k => $meas):?>
                <option value="<?= $k ?>" <?= $k == $this->old('measure') ? "selected" : false ?>><?=$meas?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>
    <div class="form-group">
        <p><input type="file" accept="image/*" name="image" id="file" onchange="loadFile(event)" style="display: none;"></p>
        <span class="btn btn-outline-secondary"><label for="file" style="cursor: pointer;">Загрузить изображение</label></span>
        <p><img src="<?= FILES.'/'.$this->old('image') ?>" id="output" width="400" /></p>
    </div>

    <button type="submit" class="btn btn-primary">
        Создать
    </button>
</form>

<script>
    var loadFile = function(event) {
        var image = document.getElementById('output');
        image.src = URL.createObjectURL(event.target.files[0]);
    };
</script>