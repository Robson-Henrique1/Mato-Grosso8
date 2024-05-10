<?php


namespace App\Models;

use CodeIgniter\Model;

class Grid_Model extends Model {

    protected $table = 'protocolosrecebidos';
    protected $primaryKey = 'protocol_id'; // Se seu id for diferente, ajuste aqui
    protected $allowedFields = ['protocol_situacaoprofissional', 'protocol_nome', 'protocol_cpf','protocol_matricula','autor_statusdocumentos'];

    public function getAllProtocolos() {
        return $this->select('protocolosrecebidos.*, autores.autor_statusdocumentos')
                    ->join('autores', 'autores.autor_nome = protocolosrecebidos.protocol_nome')
                    ->findAll();
     }

    // public function deleteProtocolo($id)
    // {
        
    //     return $this->delete($id);
    // }


    public function updateStatus($authorName, $newStatus)
    {
        // Atualiza a tabela autores onde o autor_nome corresponde ao $authorName
        $data = [
            'autor_statusdocumentos' => $newStatus
        ];

        $this->db->table('autores')
            ->where('autor_nome', $authorName)
            ->update($data);

        return $this->db->affectedRows() > 0;
    }

}
