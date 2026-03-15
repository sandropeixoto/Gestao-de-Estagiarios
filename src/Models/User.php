<?php
namespace App\Models;

require_once __DIR__ . '/BaseModel.php';

class User extends BaseModel {
    protected $table = 'users';

    /**
     * Busca ou cria um usuário vindo do SSO (Just-in-Time Provisioning).
     */
    public function findOrCreateFromSSO($ssoData) {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE sso_user_id = :sso_id OR email = :email");
        $stmt->execute([
            ':sso_id' => $ssoData['user_id'],
            ':email' => $ssoData['user_email']
        ]);
        $user = $stmt->fetch();

        if (!$user) {
            // Cria usuário se não existir
            $sql = "INSERT INTO {$this->table} (sso_user_id, nome, email, nivel_acesso) 
                    VALUES (:sso_id, :nome, :email, :nivel)";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                ':sso_id' => $ssoData['user_id'],
                ':nome' => $ssoData['user_name'],
                ':email' => $ssoData['user_email'],
                ':nivel' => $ssoData['user_level'] ?? 2
            ]);
            $user = $this->find($this->db->lastInsertId());
        } else {
            // Atualiza último acesso e possivelmente outros dados
            $this->update($user['id'], [
                'sso_user_id' => $ssoData['user_id'],
                'nome' => $ssoData['user_name'],
                'nivel_acesso' => $ssoData['user_level'] ?? $user['nivel_acesso']
            ]);
        }

        return $user;
    }
}
