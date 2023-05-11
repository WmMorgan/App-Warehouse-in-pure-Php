<?php

namespace func\actions;

use func\Core;

class Coming extends Core
{
    const CO_LOAD = 1;
    const CO_SUCCESS = 2;

    public function __invoke()
    {
        $comings = $this->getProcessComing() ? $this->getProductById($this->getProcessComing()) : false;
        $measures = (new Product)->measures;

        $this->render('index', [
            'comings' => $comings,
            'measures' => $measures
        ]);

    }

    public function searchAjax()
    {
        $measures = (new Product)->measures;

        if (strtolower($_SERVER['HTTP_X_REQUESTED_WITH'] ?? '') == 'xmlhttprequest' &&
            !empty($_POST['word'])) {
            $pattern = '%' . $_POST['word'] . '%';
            $sql = 'SELECT * FROM `' . DBPREFIX . 'product` WHERE name LIKE :pattern ';
            $statement = $this->db->prepare($sql);
            $statement->execute([':pattern' => $pattern]);
            $products = $statement->fetchAll(\PDO::FETCH_ASSOC);

            $this->renderPart('_searchAjax', [
                'products' => $products,
                'measures' => $measures
            ]);
        }
    }

    public function addToComingAjax()
    {
        if (strtolower($_SERVER['HTTP_X_REQUESTED_WITH'] ?? '') == 'xmlhttprequest') {
            $this->createComing($_POST['id']);
            $comings = $this->getProductById($this->getProcessComing(true));
            $measures = (new Product)->measures;

            $this->renderPart('_addToComingAjax', [
                'comings' => $comings,
                'measures' => $measures
            ]);
        }
    }

    public $processComing;

    /**
     * @param false $after
     * @return mixed
     */
    private function getProcessComing($after = false): mixed
    {
        if (empty($this->processComing) || $after) {
            $sql = 'SELECT * FROM `' . DBPREFIX . 'product_coming` WHERE status = :sts';
            $stmt = $this->db->prepare($sql);
            $stmt->execute([':sts' => self::CO_LOAD]);
            $this->processComing = $stmt->fetch(\PDO::FETCH_ASSOC);
        }

        return $this->processComing;
    }

    /**
     * @param $id
     * @return bool
     */
    private function createComing($id): bool
    {

        if (empty($this->getProcessComing())) {

            $sql = "INSERT INTO `" . DBPREFIX . "product_coming`
        (`comings`, created_at, status) VALUES 
        (?, ?, ?)";
            $stmt = $this->db->prepare($sql);
            $array = serialize([$id => ['quantity' => 1]]);

            return $stmt->execute([$array, time(), self::CO_LOAD]);
        } else {
            $sql = 'UPDATE `' . DBPREFIX . 'product_coming`
        SET comings = :comings WHERE status = :sts';
            $stmt = $this->db->prepare($sql);
            $comings = unserialize($this->processComing['comings']);
            $count = isset($comings[$id]) ? $comings[$id]['quantity']+1 : 1;
            $comings[$id] = ['quantity' => $count];

            return $stmt->execute([':comings' => serialize($comings), ':sts' => self::CO_LOAD]);
        }
    }

    /**
     * @param array $data
     * @return array
     */
    private function getProductById(array $data = []):array {
        $array = [];
        foreach (unserialize($data['comings']) as $k => $coming) {
            $array[] = [
              'product' => $this->getOneProduct($k),
              'quantity' => $coming['quantity']
            ];
        }

        return $array;
    }

    private function getOneProduct($id) {
     $sql = 'SELECT * FROm `'.DBPREFIX.'product` WHERE id = :id';
     $stmt = $this->db->prepare($sql);
     $stmt->execute([':id' => $id]);
     return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

}