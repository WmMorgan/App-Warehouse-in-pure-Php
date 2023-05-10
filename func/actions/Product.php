<?php

namespace func\actions;

use func\Session;

class Product extends \func\Core
{

    public $oneProduct;
    private $nameLength = 255;
    public array $measures = [
        1 => "кг",
        2 => "метр",
        3 => "литр",
        4 => "шт",
    ];

    public function __invoke()
    {
        $product = $this->getAll();

        $this->render('index', [
            'products' => $product
        ]);
    }

    public function create()
    {

        if ($this->validate() && $this->save()) {
            $this->session()->setFlash(Session::SUCCESS, "Продукт успешно создан");
            $this->redirect('product');
            exit;
        }

        $this->render('create');

    }

    public function update() {
        if (!isset($_GET['id']) || !is_numeric($_GET['id']))
            $this->redirect('product');

        $product = $this->getOne($_GET['id']);
        $_POST['name'] = $_POST['name'] ?? $product['name'];
        $_POST['category_id'] = $_POST['category_id'] ?? $product['category_id'];
        $_POST['quantity'] = $_POST['quantity'] ?? $product['quantity'];
        $_POST['measure'] = $_POST['measure'] ?? $product['measure'];
        $_POST['image'] = $_POST['image'] ?? $product['image'];

        if ($this->validate() && $this->updateOne($_GET['id'])) {
            $this->session()->setFlash(Session::SUCCESS, "Продукт успешно сохранено");
            $this->redirect('product/update?id='.$_GET['id']);
            exit;
        }

        $this->render('update');
    }

    public function delete()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || empty($_POST['id'])) {
            $this->redirect('product');
            exit;
        }
        $product = $this->getOne($_POST['id']);
        if ($product['image'] && file_exists(DIR.FILES.'/'.$product['image'])) {
            unlink(DIR . FILES . '/' . $product['image']);
        }

        $delete = $this->db->prepare("DELETE FROM `" . DBPREFIX . "product` WHERE id=?");
        if ($delete->execute([$_POST['id']])) {
            $this->session()->setFlash(Session::SUCCESS, 'Продукт удалена');
            $this->redirect('product');
        }

    }

    private function validate(): bool
    {

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            if (empty($_POST['name']))
                $this->err[] = 'Поле Название не может быть пустым!';
            else {
                if (strlen($_POST['name']) > $this->nameLength)
                    $this->err[] = 'Длина Называния не должна превышать ' . $this->nameLength . ' символов.' . "\n";
            }
            if (!empty($_POST['quantity']) && $_POST['quantity'] < 0)
                $this->err[] = "Количество товара не должно быть минус";

            $allowed_image_extension = array(
                "png",
                "jpg",
                "jpeg"
            );

            // Get image file extension
            $file_extension = pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION);

            // Validate file input to check if is not empty
            if (file_exists($_FILES["image"]["tmp_name"])) {
                if (!in_array($file_extension, $allowed_image_extension)) {
                    $this->err[] = "Загрузите допустимые изображения. Разрешены только PNG и JPEG.";
                } else if (($_FILES["image"]["size"] > 3000000)) {
                    $this->err[] = "Размер изображения превышает 3MB.";
                }
            }

            if (count($this->err) > 0)
                return false;

            // успешний валидации
            return true;
        }
        return false;
    }

    /**
     * @return mixed
     */
    private function save():bool
    {
        $image = $this->uploadImage();

        $sql = "INSERT INTO `" . DBPREFIX . "product`
        (`name`, category_id, quantity, measure, image, created_at) VALUES 
        (?, ?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            $_POST['name'],
            $_POST['category_id'],
            $_POST['quantity'] ? $_POST['quantity'] : 0,
            $_POST['measure'],
            $image,
            time()
        ]);
    }

    /**
     * @param $id
     * @return bool
     */
    private function updateOne($id):bool {
        $image = $this->uploadImage(true);

        if ($image) {
            $sql = 'UPDATE `' . DBPREFIX . 'product`
        SET name = :name,
        category_id = :category_id,
        quantity = :quantity,
        measure = :measure,
        image = :image
        WHERE id = :id';
        } else {
            $sql = 'UPDATE `' . DBPREFIX . 'product`
        SET name = :name,
        category_id = :category_id,
        quantity = :quantity,
        measure = :measure
        WHERE id = :id';
        }
        $stmt = $this->db->prepare($sql);

        $execute = [
            ':name' => $_POST['name'],
            ':category_id' => $_POST['category_id'],
            ':quantity' => $_POST['quantity'],
            ':measure' => $_POST['measure'] ? $_POST['measure'] : 0,
            ':id' => $id
        ];
        if ($image) $execute[':image'] = $image;

        return $stmt->execute($execute);
    }

    /**
     * @param false $update
     * @return false|string
     */
    private function uploadImage($update = false) {
        if ($update) {
            if ($this->oneProduct['image'] && file_exists(DIR . FILES . '/' . $this->oneProduct['image'])) {
                unlink(DIR . FILES . '/' . $this->oneProduct['image']);
            }
        }

        $target = false;
        if (file_exists($_FILES["image"]["tmp_name"])) {
            $name = str_replace([' ', '_', '(', ')', '*', '?', '|'], '-', strtolower($_POST['name']));
            $uniqueName = uniqid($name . '-');
            $file_ext = pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION);

            $target = "images/" . $uniqueName . '.' . $file_ext;
            if (!move_uploaded_file($_FILES["image"]["tmp_name"], DIR . FILES . '/' . $target)) {
                $this->err[] = "Problem in uploading image files.";
                exit;
            }
            return $target;
        }
        return $target;
    }

    private function getAll() {
        $sql = 'SELECT p.*, c.name as category_id
        FROM `'.DBPREFIX.'product` as p LEFT JOIN `'.DBPREFIX.'category` as c ON 
        p.category_id = c.id ORDER BY created_at DESC';
        $stmt = $this->db->query($sql);
        $all = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        return $all;
    }

    private function getOne($id) {

        if ($this->oneProduct == null) {
            $sql = 'SELECT *
        FROM `'.DBPREFIX.'product` WHERE id = :id';
            $stmt = $this->db->prepare($sql);
            $stmt->execute([':id' => $id]);
            $this->oneProduct = $stmt->fetch(\PDO::FETCH_ASSOC);
        }

        return $this->oneProduct;
    }

    /**
     * @return array
     */
    public function getCategories():array {
        $sql = 'SELECT id, name
        FROM `'.DBPREFIX.'category`';
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

}