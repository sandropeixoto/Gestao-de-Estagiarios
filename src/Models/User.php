<?php
namespace App\Models;

require_once __DIR__ . '/BaseModel.php';

class User extends BaseModel {
    protected $table = 'users';

    /**
     * Busca um usuário pelo ID SSO ou Email.
     */
    public function findBySSO($ssoId, $email) {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE sso_user_id = :sso_id OR email = :email");
        $stmt->execute([
            ':sso_id' => $ssoId,
            ':email' => $email
        ]);
        return $stmt->fetch();
    }

    /**
     * Cadastro Manual de Usuário (Gestores/Admin).
     */
    public function createManual($data) {
        $sql = "INSERT INTO {$this->table} (sso_user_id, nome, email, nivel_acesso) 
                VALUES (:sso_id, :nome, :email, :nivel)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':sso_id' => $data['sso_user_id'] ?? 0, // 0 se não for JIT
            ':nome' => $data['nome'],
            ':email' => $data['email'],
            ':nivel' => $data['nivel_acesso']
        ]);
    }

    /**
     * Busca configuração global.
     */
    public function getSetting($key) {
        $stmt = $this->db->prepare("SELECT setting_value FROM system_settings WHERE setting_key = :key");
        $stmt->execute([':key' => $key]);
        $row = $stmt->fetch();
        return $row ? $row['setting_value'] : null;
    }

    /**
     * Atualiza configuração global.
     */
    public function updateSetting($key, $value) {
        $stmt = $this->db->prepare("UPDATE system_settings SET setting_value = :value WHERE setting_key = :key");
        return $stmt->execute([':key' => $key, ':value' => $value]);
    }
}
