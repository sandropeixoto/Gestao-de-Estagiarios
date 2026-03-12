<?php
namespace App\Models;

require_once __DIR__ . '/../../config/database.php';

abstract class BaseModel {
    protected $db;
    protected $table;

    public function __construct() {
        $this->db = \Database::getConnection();
    }

    public function all() {
        $stmt = $this->db->query("SELECT * FROM {$this->table}");
        return $stmt->fetchAll();
    }

    public function find($id) {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM {$this->table} WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public function update($id, $data) {
        $fields = "";
        foreach ($data as $key => $value) {
            $fields .= "{$key} = :{$key}, ";
        }
        $fields = rtrim($fields, ", ");
        
        $sql = "UPDATE {$this->table} SET {$fields} WHERE id = :id";
        $data['id'] = $id;
        
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($data);
    }
}
