<?php
require_once('../../helpers/database.php');
class CategoriaHandler
{
    protected $id = null;
    protected $nombre = null;
    protected $descripcion = null;
    protected $imagen = null;
    protected $estado = null;

    const RUTA_IMAGEN = '../../images/categorias/';

    public function searchRows()
    {
        $value = '%' . Validator::getSearchValue() . '%';
        $sql = 'SELECT categoria_id, categoria_nombre, categoria_imagen, categoria_descripcion, categoria_estado
                FROM tb_categorias
                WHERE categoria_nombre LIKE ? OR categoria_descripcion LIKE ?
                ORDER BY categoria_nombre';
        $params = array($value, $value);
        return Database::getRows($sql, $params);
    }

    public function createRow()
    {
        $sql = 'INSERT INTO tb_categorias(categoria_nombre, categoria_imagen, categoria_descripcion, categoria_estado)
                VALUES(?, ?, ?, ?)';
        $params = array($this->nombre, $this->imagen, $this->descripcion, $this->estado);
        return Database::executeRow($sql, $params);
    }

    public function readAll()
    {
        $sql = 'SELECT categoria_id, categoria_nombre, categoria_imagen, categoria_descripcion, categoria_estado
                FROM tb_categorias
                ORDER BY categoria_nombre';
        return Database::getRows($sql);
    }

    public function readOne()
    {
        $sql = 'SELECT categoria_id, categoria_nombre, categoria_imagen, categoria_descripcion, categoria_estado
                FROM tb_categorias
                WHERE categoria_id = ?';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }

    public function readFilename()
    {
        $sql = 'SELECT categoria_imagen
                FROM tb_categorias
                WHERE categoria_id = ?';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }

    public function updateRow()
    {
        $sql = 'UPDATE tb_categorias
                SET categoria_imagen = ?, categoria_nombre = ?, categoria_descripcion = ?, categoria_estado = ?
                WHERE categoria_id = ?';
        $params = array($this->imagen, $this->nombre, $this->descripcion, $this->estado, $this->id);
        return Database::executeRow($sql, $params);
    }

    public function deleteRow()
    {
        $sql = 'DELETE FROM tb_categorias
                WHERE categoria_id = ?;';
        $params = array($this->id);
        return Database::executeRow($sql, $params);
    }
}