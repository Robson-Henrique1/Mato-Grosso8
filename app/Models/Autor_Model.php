<?php


namespace App\Models;

use CodeIgniter\Model;

class Autor_Model extends Model
{
    public $table = 'autores';

    public function verificarUsuario($nome)
    {
        return $this->db->table($this->table)
            ->where('autor_nome', $nome)
            ->get()->getRow();
    }

    public function getProtocolo($nome)
    {
        return $this->db->table('protocolosrecebidos')
            ->where('protocol_nome', $nome)
            ->get()->getRow();
    }

    public function getProtocoloMatricula($matricula)
    {
        return $this->db->table('protocolosrecebidos')
            ->where('protocol_matricula', $matricula)
            ->get()->getRow();
    }
    public function getMatricula($nome)
    {
        $usuario = $this->db->table($this->table)
            ->where('autor_nome', $nome)
            ->get()->getRow();
        return $usuario->autor_matricula;
    }
    public function getValor($nome)
    {
        $usuario = $this->db->table($this->table)
            ->where('autor_nome', $nome)
            ->get()->getRow();
        return $usuario->autor_valor;
    }

    public function checkCodigoExists($cod)
    {
        $query = $this->db->table('protocolosrecebidos')
            ->where('protocol_codigo', $cod)
            ->get();

        if ($query->getRow()) {
            return true;
        } else {
            return false;
        }
    }

    public function setCodigo($matricula, $cod)
    {
        $this->db->table('protocolosrecebidos')
            ->where('protocol_matricula', $matricula)
            ->update(['protocol_codigo' => $cod]);
    }

    public function atualizarProtocolo($nome, $email, $telefone, $cpf, $cep, $logradouro, $cidade, $bairro, $estado, $complemento, $ip, $rg, $exp, $civil, $numero)
    {
        $updateId = $this->db->table('protocolosrecebidos')
            ->where('protocol_nome', $nome)
            ->update([
                'protocol_email' => $email,
                'protocol_telefone' => $telefone,
                'protocol_cpf' => $cpf,
                'protocol_cep' => $cep,
                'protocol_endereco' => $logradouro . ' ' . $complemento,
                'protocol_cidade' => $cidade,
                'protocol_bairro' => $bairro,
                'protocol_estado' => $estado,
                'protocol_identidade' => $rg,
                'protocol_orgaoexped' => $exp,
                'protocol_estadocivil' => $civil,
                'protocol_numero' => $numero,
                'protocol_ipmaquina' => $ip,
            ]);

            if ($updateId) {
                $this->db->table($this->table)
                    ->set('autor_statusdocumentos', 'RECEBIDO')
                    ->where('autor_matricula', $this->getMatricula($nome))
                    ->update();
            }
    }


    public function criarProtocolo($nome, $email, $telefone, $cpf, $cep, $logradouro, $cidade, $bairro, $estado, $complemento, $ip, $rg, $exp, $civil, $numero)
    {
        $insertId = $this->db->table('protocolosrecebidos')->insert([
            'protocol_anoprotocolo' => date('Y'),
            'protocol_nome' => $nome,
            'protocol_cpf' => $cpf,
            'protocol_matricula' => $this->getMatricula($nome),
            'protocol_tipocategoria' => 'Profissionais do magistério',
            'protocol_situacaoprofissional' => 'Efetivo',
            'protocol_valor' => $this->getValor($nome),
            'protocol_identidade' => $rg,
            'protocol_orgaoexped' => $exp,
            'protocol_estadocivil' => $civil,
            'protocol_endereco' => $logradouro . ' ' . $complemento,
            'protocol_numero' => $numero,
            'protocol_bairro' => $bairro,
            'protocol_cidade' => $cidade,
            'protocol_estado' => $estado,
            'protocol_cep' => $cep,
            'protocol_telefone' => $telefone,
            'protocol_email' => $email,
            'protocol_ipmaquina' => $ip,
        ]);


        if ($insertId) {
            $this->db->table($this->table)
                ->set('autor_statusdocumentos', 'RECEBIDO')
                ->where('autor_matricula', $this->getMatricula($nome))
                ->update();
        }
    }
}
