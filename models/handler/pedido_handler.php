<?php
require_once('../../helpers/database.php');
class PedidoHandler
{
    protected $id = null;
    protected $nombre = null;
    protected $descripcion = null;
    protected $estado = null;

    public function searchRows()
    {
        $searchValue = Validator::getSearchValue();
        $value = '%' . $searchValue . '%';
        $sql = "SELECT 
                    p.pedido_id AS id_pedido,
                    CONCAT(u.usuario_nombre, ' ', u.usuario_apellido) AS nombre_cliente,
                    SUM(dp.detalle_precio * dp.detalle_cantidad) AS precio_total,
                    p.pedido_direccion AS direccion,
                    p.pedido_estado AS estado
                FROM 
                    tb_pedidos p
                INNER JOIN 
                    tb_usuarios u ON p.usuario_id = u.usuario_id
                INNER JOIN 
                    tb_detalles_pedidos dp ON p.pedido_id = dp.pedido_id
                WHERE 
                    p.pedido_id LIKE ? OR
                    CONCAT(u.usuario_nombre, ' ', u.usuario_apellido) LIKE ? OR
                    p.pedido_direccion LIKE ? OR
                    p.pedido_estado LIKE ?";
        $params = array($value, $value, $value, $value);
        return Database::getRows($sql, $params);
    }

    public function readAll()
    {
        $sql = "SELECT p.pedido_id AS 'ID del Pedido',
            CONCAT(u.usuario_nombre, ' ', u.usuario_apellido) AS 'Nombre del Cliente',
            SUM(dp.detalle_precio * dp.detalle_cantidad) AS 'Precio Total',
            p.pedido_direccion AS 'Dirección',
            p.pedido_estado AS 'Estado'
            FROM tb_pedidos p
            INNER JOIN tb_usuarios u ON p.usuario_id = u.usuario_id
            INNER JOIN tb_detalles_pedidos dp ON p.pedido_id = dp.pedido_id
            GROUP BY p.pedido_id, u.usuario_nombre, u.usuario_apellido, p.pedido_direccion, p.pedido_estado;";
        return Database::getRows($sql);
    }

    public function readOne()
    {
        $sql = "SELECT p.pedido_id AS 'ID del Pedido',
            CONCAT(u.usuario_nombre, ' ', u.usuario_apellido) AS 'Nombre del Cliente',
            SUM(dp.detalle_precio * dp.detalle_cantidad) AS 'Precio Total',
            p.pedido_direccion AS 'Dirección',
            p.pedido_estado AS 'Estado'
            FROM tb_pedidos p
            INNER JOIN tb_usuarios u ON p.usuario_id = u.usuario_id
            INNER JOIN tb_detalles_pedidos dp ON p.pedido_id = dp.pedido_id
            WHERE p.pedido_id = ?
            GROUP BY p.pedido_id, u.usuario_nombre, u.usuario_apellido, p.pedido_direccion, p.pedido_estado;";
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }

    public function changeStatus()
    {
        $sql = 'UPDATE tb_pedidos SET pedido_estado = NOT pedido_estado WHERE pedido_id=?';
        $params = array($this->id);
        return Database::executeRow($sql, $params);
    }


}
?>
