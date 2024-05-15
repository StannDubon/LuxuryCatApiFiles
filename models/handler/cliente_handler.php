<?php

require_once('../../helpers/database.php');

class UsuarioHandler {

    protected $usuario_id = null;
    protected $usuario_nombre = null;
    protected $usuario_apellido = null;
    protected $usuario_usuario = null;
    protected $usuario_contraseña = null;
    protected $usuario_correo = null;
    protected $usuario_estado = null;

    public function checkUser($username, $password)
    {
        $sql = 'SELECT usuario_id, usuario_usuario, usuario_contraseña
                FROM tb_usuarios
                WHERE usuario_usuario = ?';
        $params = array($username);
        if (!($data = Database::getRow($sql, $params))) {
            return false;
        } elseif (password_verify($password, $data['usuario_contraseña'])) {
            $_SESSION['usuario_id'] = $data['usuario_id'];
            $_SESSION['usuario_usuario'] = $data['usuario_usuario'];
            return true;
        } else {
            return false;
        }
    }

    public function checkPassword($password)
    {
        $sql = 'SELECT usuario_contraseña
                FROM tb_usuarios
                WHERE usuario_id = ?';
        $params = array($_SESSION['usuario_id']);
        $data = Database::getRow($sql, $params);
        if (password_verify($password, $data['usuario_contraseña'])) {
            return true;
        } else {
            return false;
        }
    }

    public function changePassword()
    {
        $sql = 'UPDATE tb_usuarios
                SET usuario_contraseña = ?
                WHERE usuario_id = ?';
        $params = array($this->usuario_contraseña, $_SESSION['usuario_id']);
        return Database::executeRow($sql, $params);
    }

    public function readProfile()
    {
        $sql = 'SELECT usuario_id, usuario_nombre, usuario_apellido, usuario_correo, usuario_usuario, usuario_estado
                FROM tb_usuarios
                WHERE usuario_id = ?';
        $params = array($_SESSION['usuario_id']);
        return Database::getRow($sql, $params);
    }

    public function editProfile()
    {
        $sql = 'UPDATE tb_usuarios
                SET usuario_nombre = ?, usuario_apellido = ?, usuario_correo = ?, usuario_usuario = ?, usuario_estado = ?
                WHERE usuario_id = ?';
        $params = array($this->usuario_nombre, $this->usuario_apellido, $this->usuario_correo, $this->usuario_usuario, $this->usuario_estado, $_SESSION['usuario_id']);
        return Database::executeRow($sql, $params);
    }

    public function searchRows()
    {
        $value = '%' . Validator::getSearchValue() . '%';
        $sql = 'SELECT usuario_id, usuario_nombre, usuario_apellido, usuario_correo, usuario_usuario, usuario_estado
                FROM tb_usuarios
                WHERE usuario_apellido LIKE ? OR usuario_nombre LIKE ?
                ORDER BY usuario_apellido';
        $params = array($value, $value);
        return Database::getRows($sql, $params);
    }

    public function createRow()
    {
        $sql = 'INSERT INTO tb_usuarios(usuario_nombre, usuario_apellido, usuario_correo, usuario_usuario, usuario_contraseña, usuario_estado)
                VALUES(?, ?, ?, ?, ?, ?)';
        $params = array($this->usuario_nombre, $this->usuario_apellido, $this->usuario_correo, $this->usuario_usuario, $this->usuario_contraseña, $this->usuario_estado);
        return Database::executeRow($sql, $params);
    }

    public function readAll()
    {
        $sql = 'SELECT usuario_id, usuario_nombre, usuario_apellido, usuario_correo, usuario_usuario, usuario_estado
                FROM tb_usuarios
                ORDER BY usuario_apellido';
        return Database::getRows($sql);
    }

    public function readOne()
    {
        $sql = 'SELECT usuario_id, usuario_nombre, usuario_apellido, usuario_correo, usuario_usuario, usuario_estado
                FROM tb_usuarios
                WHERE usuario_id = ?';
        $params = array($this->usuario_id);
        return Database::getRow($sql, $params);
    }

    public function updateRow()
    {
        $sql = 'UPDATE tb_usuarios
                SET usuario_nombre = ?, usuario_apellido = ?, usuario_correo = ?, usuario_usuario = ?, usuario_estado = ?
                WHERE usuario_id = ?';
        $params = array($this->usuario_nombre, $this->usuario_apellido, $this->usuario_correo, $this->usuario_usuario, $this->usuario_estado, $this->usuario_id);
        return Database::executeRow($sql, $params);
    }

    public function deleteRow()
    {
        $sql = 'DELETE FROM tb_usuarios
                WHERE usuario_id = ?';
        $params = array($this->usuario_id);
        return Database::executeRow($sql, $params);
    }
}
