<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class AuthMiddleware implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // Carregar a biblioteca de sessão
        $session = \Config\Services::session();
        
        // Verificar se o usuário está logado
        if (!$session->get('usuario_id')) {
            // Se não estiver logado, redirecione para a página inicial ou página de login
            return redirect()->to(base_url('/'));
        }

        // Se estiver logado, permitir acesso à rota
        return $request;
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Não é necessário fazer nada após o processamento do middleware
    }

    public function logout()
    {
        // Carrega o helper de sessão
        helper('session');

        // Destrói a sessão atual do usuário
        session()->destroy();

        // Redireciona o usuário para a página de login ou qualquer outra página desejada
        return redirect()->to(base_url('/'));
    }
}
