<?php
require_once __DIR__ . '/../conexion.php';

class AdministradorModel {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }
    
    public function getAll() {
        $stmt = $this->db->query("SELECT * FROM ADMINISTRADOR ORDER BY admin_nombre");
        return $stmt->fetchAll();
    }
    
    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM ADMINISTRADOR WHERE admin_id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
    
    public function getByEmail($email) {
        $stmt = $this->db->prepare("SELECT * FROM ADMINISTRADOR WHERE admin_correo = ?");
        $stmt->execute([$email]);
        return $stmt->fetch();
    }
    
    public function create($data) {
        $stmt = $this->db->prepare("
            INSERT INTO ADMINISTRADOR (admin_nombre, admin_correo, admin_password, admin_estado) 
            VALUES (?, ?, ?, ?)
        ");
        return $stmt->execute([
            $data['admin_nombre'],
            $data['admin_correo'],
            password_hash($data['admin_password'], PASSWORD_DEFAULT),
            $data['admin_estado'] ?? 'Activo'
        ]);
    }
    
    public function update($id, $data) {
        $sql = "UPDATE ADMINISTRADOR SET admin_nombre = ?, admin_correo = ?, admin_estado = ?";
        $params = [
            $data['admin_nombre'],
            $data['admin_correo'],
            $data['admin_estado']
        ];
        
        if (isset($data['admin_password']) && !empty($data['admin_password'])) {
            $sql .= ", admin_password = ?";
            $params[] = password_hash($data['admin_password'], PASSWORD_DEFAULT);
        }
        
        $sql .= " WHERE admin_id = ?";
        $params[] = $id;
        
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($params);
    }
    
    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM ADMINISTRADOR WHERE admin_id = ?");
        return $stmt->execute([$id]);
    }
    
    public function updateUltimoAcceso($id) {
        $stmt = $this->db->prepare("UPDATE ADMINISTRADOR SET admin_ultimo_acceso = NOW() WHERE admin_id = ?");
        return $stmt->execute([$id]);
    }
}
?>
