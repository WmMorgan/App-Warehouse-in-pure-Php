<?php

namespace func\actions;

use func\Session;

class Category extends \func\Core
{

    public function __invoke()
    {
        $categories = $this->getAll();

        $this->render('index', [
            'categories' => $categories
        ]);
    }

    public function create()
    {

        if ($this->validate() && $this->save()) {
            $this->session()->setFlash(Session::SUCCESS, "Категория успешно создан");
            $this->redirect('category');
            exit;
        }

        $this->render('create');

    }

    public function update() {
        if (!isset($_GET['id']) || !is_numeric($_GET['id']))
            $this->redirect('category');

        $category = $this->getOne($_GET['id']);
        $_POST['name'] = $_POST['name'] ?? $category['name'];
        $_POST['description'] = $_POST['description'] ?? $category['description'];

        if ($this->validate() && $this->updateOne($_GET['id'])) {
            $this->session()->setFlash(Session::SUCCESS, "Категория успешно сохранено");
        }

        $this->render('update');
    }

    public function delete()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || empty($_POST['id'])) {
            $this->redirect('category');
            exit;
        }

        $delete = $this->db->prepare("DELETE FROM `" . DBPREFIX . "category` WHERE id=?");
        if ($delete->execute([$_POST['id']])) {
            $this->session()->setFlash(Session::SUCCESS, 'Категория удалена');
            $this->redirect('category');
        }

    }

    private $nameLength = 255;

    private function validate(): bool
    {

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            if (empty($_POST['name']))
                $this->err[] = 'Поле Название не может быть пустым!';
            else {
                if (strlen($_POST['name']) > $this->nameLength)
                    $this->err[] = 'Длина Называния не должна превышать ' . $this->nameLength . ' символов.' . "\n";
            }
            if (count($this->err) > 0)
                return false;

            // успешний валидации
            return true;
        }
        return false;
    }

    private function save()
    {
        $sql = "INSERT INTO `" . DBPREFIX . "category` (`name`, description, created_at) VALUES (?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            $_POST['name'],
            $_POST['description'],
            time()]);
    }

    private function updateOne($id) {

        $sql = 'UPDATE `'.DBPREFIX.'category`
        SET name = :name, description = :description
        WHERE id = :id';
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([':name' => $_POST['name'], ':description' => $_POST['description'], ':id' => $id]);
    }

    private function getAll() {
        $sql = 'SELECT *
        FROM `'.DBPREFIX.'category`';
        $stmt = $this->db->query($sql);
        $all = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        return $all;
    }

    private function getOne($id) {
        $sql = 'SELECT *
        FROM `'.DBPREFIX.'category` WHERE id = :id';
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);

    }

}