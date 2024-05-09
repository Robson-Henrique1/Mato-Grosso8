<?php
namespace App\Models;

use CodeIgniter\Model;

class Usuario_model extends Model
{

    protected $table = 'usuario';

    public function verificarCredenciais($nomeUsuario, $senha)
    {

        // Consulta para verificar se as credenciais estão corretas
        $query = $this->where('nome', $nomeUsuario)
            ->where('senha', $senha)
            ->get();
        $row = $query->getRow();
        if ($row) {
            $data['credenciais'] = [$row->id,$row->nome];
            // Se as credenciais estão corretas, retorna o ID do usuário
            return $data['credenciais'];
        } else {
            // Se as credenciais não estão corretas, retorna null
            return null;
        }
    }
}
