<?php


namespace App\Models;

use CodeIgniter\Model;

class Grid_Model extends Model {

    protected $table = 'protocolosrecebidos';
    protected $primaryKey = 'protocol_id'; // Se seu id for diferente, ajuste aqui
    protected $allowedFields = ['protocol_situacaoprofissional', 'protocol_nome', 'protocol_cpf','protocol_matricula','autor_statusdocumentos'];

    public function getAllProtocolos() {
        return $this->select('protocolosrecebidos.*, autores.autor_statusdocumentos')
                    ->join('autores', 'autores.autor_matricula = protocolosrecebidos.protocol_matricula')
                    ->findAll();
     }

    // public function deleteProtocolo($id)
    // {
        
    //     return $this->delete($id);
    // }


    public function updateStatus($authorMatricula, $newStatus)
    {
        // Atualiza a tabela autores onde o autor_nome corresponde ao $authorName
        $data = [
            'autor_statusdocumentos' => $newStatus
        ];

        $this->db->table('autores')
            ->where('autor_matricula', $authorMatricula)
            ->update($data);
        return $this->db->affectedRows() > 0;
    }

    public function updateStatusByMatricula($matricula, $newStatus)
    {
        $data = [
            'autor_statusdocumentos' => $newStatus
        ];

        $this->db->table('autores')
            ->where('autor_matricula', $matricula)
            ->update($data);
    }

}
