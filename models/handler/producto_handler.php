<?php
require_once('../../helpers/database.php');

class ProductoHandler
{
    protected $id = null;
    protected $categoria_id = null;
    protected $marca_id = null;
    protected $descripcion = null;
    protected $nombre = null;
    protected $precio = null;
    protected $imagen = null;
    protected $cantidad = null;
    protected $estado = null;

    const RUTA_IMAGEN = '../../images/productos/';

    public function searchRows()
    {
        $value = '%' . Validator::getSearchValue() . '%';
        $sql = 'SELECT producto_id, categoria_id, marca_id, producto_descripcion, producto_nombre, producto_precio, producto_imagen, producto_cantidad, producto_estado
                FROM tb_productos
                WHERE producto_nombre LIKE ? OR producto_descripcion LIKE ?
                ORDER BY producto_nombre';
        $params = array($value, $value);
        return Database::getRows($sql, $params);
    }

    public function createRow()
    {
        $sql = 'INSERT INTO tb_productos(categoria_id, marca_id, producto_descripcion, producto_nombre, producto_precio, producto_imagen, producto_cantidad, producto_estado)
                VALUES(?, ?, ?, ?, ?, ?, ?, ?)';
        $params = array($this->categoria_id, $this->marca_id, $this->descripcion, $this->nombre, $this->precio, $this->imagen, $this->cantidad, $this->estado);
        return Database::executeRow($sql, $params);
    }

    public function readAll()
    {
        $sql = 'SELECT producto_id, categoria_id, marca_id, producto_descripcion, producto_nombre, producto_precio, producto_imagen, producto_cantidad, producto_estado
                FROM tb_productos
                ORDER BY producto_nombre';
        return Database::getRows($sql);
    }

    public function readOne()
    {
        $sql = 'SELECT producto_id, categoria_id, marca_id, producto_descripcion, producto_nombre, producto_precio, producto_imagen, producto_cantidad, producto_estado
                FROM tb_productos
                WHERE producto_id = ?';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }

    public function updateRow()
    {
        $sql = 'UPDATE tb_productos
                SET categoria_id = ?, marca_id = ?, producto_descripcion = ?, producto_nombre = ?, producto_precio = ?, producto_imagen = ?, producto_cantidad = ?, producto_estado = ?
                WHERE producto_id = ?';
        $params = array($this->categoria_id, $this->marca_id, $this->descripcion, $this->nombre, $this->precio, $this->imagen, $this->cantidad, $this->estado, $this->id);
        return Database::executeRow($sql, $params);
    }

    public function deleteRow()
    {
        $sql = 'DELETE FROM tb_productos WHERE producto_id = ?';
        $params = array($this->id);
        return Database::executeRow($sql, $params);
    }

    public function readFilename()
    {
        $sql = 'SELECT producto_imagen
                FROM tb_productos
                WHERE producto_id = ?';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }
}
