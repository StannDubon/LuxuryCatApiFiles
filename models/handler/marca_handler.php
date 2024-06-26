
<?php
require_once('../../helpers/database.php');

class MarcaHandler
{
    protected $marca_id = null;
    protected $marca_nombre = null;
    protected $marca_estado = null;

    /* BUSQUEDA */
    public function searchRows()
    {
        $value = '%' . Validator::getSearchValue() . '%';
        $sql = 'SELECT * FROM tb_marca where marca_nombre LIKE ?';
        $params = array($value);
        return Database::getRows($sql, $params);
    }

    /* INSERTAR */
    public function createRow()
    {
        $sql = 'CALL InsertarMarca(?, ?);';

        $params = array($this->marca_nombre, $this->marca_estado);
        return Database::executeRow($sql, $params);
    }

    /* LEER TABLA */
    public function readAll()
    {
        $sql = 'SELECT * FROM tb_marca';
        return Database::getRows($sql);
    }

    /* LEER ELEMENTO */
    public function readOne()
    {
        $sql = 'SELECT * FROM tb_marca WHERE marca_id= ?';
        $params = array($this->marca_id);
        return Database::getRow($sql, $params);
    }

    /* ACTUALIZAR */
    public function updateRow()
    {
        $sql = 'UPDATE tb_marca
                SET marca_nombre = ?, marca_estado = ?
                WHERE marca_id = ?';
        $params = array($this->marca_nombre, $this->marca_estado, $this->marca_id);
        return Database::executeRow($sql, $params);
    }

    /* ELIMINAR */
    public function deleteRow()
    {
        $sql = 'DELETE FROM tb_marca
                WHERE marca_id = ?';
        $params = array($this->marca_id);
        return Database::executeRow($sql, $params);
    }
}
