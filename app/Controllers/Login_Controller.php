<?php

namespace App\Controllers;

use App\Models\Usuario_Model;
use CodeIgniter\Controller;

class Login_Controller extends Controller
{

    public function index()
    {
        // Carregar a view do menu e passar a mensagem de logout, se existir
        return view('Login');
    }

    public function verificarCredenciais()
    {
        // Carregar o modelo
        $nomeUsuario = $this->request->getPost('username');
        $senha = $this->request->getPost('password');

        $usuarioModel = new Usuario_Model();

        // Verificar as credenciais
        $usuario_id = $usuarioModel->verificarCredenciais($nomeUsuario, $senha);
        
        if ($usuario_id !== null) {
            // Se as credenciais estão corretas, definir a sessão de login com o ID do usuário
            $session = \Config\Services::session();
            $session->set('usuario_id', $usuario_id[0]);
            $session->set('usuario_nome', $usuario_id[1]);
            // Redirecionar para a página de sucesso
            return redirect()->to(base_url('login/sucesso'));
        } else {
            // Se as credenciais estiverem incorretas, exibir uma mensagem de erro
            $data['error_message'] = 'Credenciais incorretas!';
            return view('Login', $data);
        }
    }
    public function logout()
    {
        // Carrega o helper de sessão
        helper('session');
    
        // Destrói a sessão atual do usuário
        session()->destroy();
    
        // Define a mensagem de logout
        $data['logout_message'] = 'Você foi desconectado com sucesso.';
    
        // Carrega a view de login e passa a mensagem de logout
        return view('Login', $data);
    }
    
}
