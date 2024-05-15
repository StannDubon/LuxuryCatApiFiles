<?php
require_once('../../helpers/database.php');
class CategoriaHandler
{
    protected $id = null;
    protected $nombre = null;
    protected $descripcion = null;
    protected $estado = null;

    const RUTA_IMAGEN = '../../images/categorias/';

    public function searchRows()
    {
        $value = '%' . Validator::getSearchValue() . '%';
        $sql = 'SELECT c.comentario_id AS id_comentario,
                CONCAT(u.usuario_nombre, ' ', u.usuario_apellido) AS cliente, p.producto_nombre AS producto, c.comentario_fecha AS fecha_del_comentario, c.comentario_texto AS comentario
                FROM tb_comentarios c
                INNER JOIN tb_detalles_pedidos dp ON c.detalle_pedido_id = dp.detalle_pedido_id
                INNER JOIN tb_productos p ON dp.producto_id = p.producto_id
                INNER JOIN tb_pedidos ped ON dp.pedido_id = ped.pedido_id
                INNER JOIN tb_usuarios u ON ped.usuario_id = u.usuario_id;
                WHERE c.comentario_id LIKE ? AND
                CONCAT(u.usuario_nombre, ' ', u.usuario_apellido) LIKE ? AND
                p.producto_nombre LIKE ? AND
                c.comentario_fecha LIKE ? AND
                c.comentario_texto LIKE ?";
                ORDER BY id_comentario';
        $params = array($value, $value);
        return Database::getRows($sql, $params);
    }

    public function readAll()
    {
        $sql = 'SELECT c.comentario_id AS id_comentario,
                CONCAT(u.usuario_nombre, ' ', u.usuario_apellido) AS cliente, p.producto_nombre AS producto, c.comentario_fecha AS fecha_del_comentario, c.comentario_texto AS comentario
                FROM tb_comentarios c
                INNER JOIN tb_detalles_pedidos dp ON c.detalle_pedido_id = dp.detalle_pedido_id
                INNER JOIN tb_productos p ON dp.producto_id = p.producto_id
                INNER JOIN tb_pedidos ped ON dp.pedido_id = ped.pedido_id
                INNER JOIN tb_usuarios u ON ped.usuario_id = u.usuario_id;';
        return Database::getRows($sql);
    }

    public function readOne()
    {
        $sql = 'SELECT categoria_id, categoria_nombre, categoria_descripcion, categoria_estado
                FROM tb_categorias
                WHERE categoria_id = ?';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }
}
?>