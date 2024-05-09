<?php


namespace App\Models;

use CodeIgniter\Model;

class Grid_model extends Model {

    protected $table = 'protocolosrecebidos';
    protected $primaryKey = 'protocol_id'; // Se seu id for diferente, ajuste aqui
    protected $allowedFields = ['protocol_situacaoprofissional', 'protocol_nome', 'protocol_cpf','protocol_matricula'];

    public function getAllProtocolos() {
       return $this->findAll();
    }

    public function deleteProtocolo($id)
    {
        
        return $this->delete($id);
    }
}
