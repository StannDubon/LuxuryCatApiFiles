<?php
require_once('../../helpers/validator.php');
require_once('../../models/handler/pedido_handler.php');

class PedidoData extends PedidoHandler
{
    private $data_error = null;

    public function setId($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->id = $value;
            return true;
        } else {
            $this->data_error = 'El identificador del pedido es incorrecto';
            return false;
        }
    }

    public function setEstado($value)
    {
        if (is_bool($value)) {
            $this->pedido_estado = $value ? 1 : 0;
            return true;
        } elseif (is_numeric($value) && ($value == 0 || $value == 1)) {
            $this->pedido_estado = intval($value); // Convertimos a entero por seguridad.
            return true;
        } else {
            $this->data_error = 'El estado debe ser un valor booleano o un número (0 o 1)';
            return false;
        }
    }

    public function getDataError()
    {
        return $this->data_error;
    }
}
