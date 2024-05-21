<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Protocolos Recebidos</title>
    <!-- Inclua o CSS do DataTables e do Bootstrap -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <!-- Adicione os estilos do SweetAlert2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <style>
        /* Estilos personalizados */
        @keyframes fadeOut {
            from {
                opacity: 1;
            }

            to {
                opacity: 0;
                transform: translateY(-20px);
            }
        }

        @keyframes fadeOutAndRemove {
            0% {
                opacity: 1;
            }

            90% {
                opacity: 0;
            }

            100% {
                opacity: 0;
                transform: translateY(-20px);
                display: none;
                /* Remova o elemento da DOM após a animação terminar */
            }




        }

        @keyframes slideInRight {
            from {
                transform: translateX(100%);
            }

            to {
                transform: translateX(0);
            }
        }

        @keyframes fadeOut {
            from {
                opacity: 1;
            }

            to {
                opacity: 0;
                transform: translateY(-20px);
            }
        }

        body {
            background-color: #f0f0f0;
            background-size: cover;
            background-position: center;
            color: #fff;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 20px;
            background-color: rgba(0, 0, 0, 0.7);
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.3);
        }

        .table {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        th,
        td {
            text-align: center;
            color: #000;
        }

        .btn-add {
            background-color: #28a745;
            color: #fff;
            border: none;
            border-radius: 5px;
            padding: 10px 20px;
            font-size: 18px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-add:hover {
            background-color: #218838;
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
        }

        .fade-in {
            animation: fadeIn 1s ease forwards;
        }

        .btn-action {
            padding: 5px;
            margin: 0 5px;
            font-size: 18px;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-view {
            background-color: #007bff;
        }

        .btn-download {
            background-color: #28a745;
        }

        .btn-delete {
            background-color: #dc3545;
        }

        .btn-action:hover {
            transform: translateY(-3px);
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
        }

        #successMessage {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
            width: 300px;
            padding: 15px;
            border-radius: 5px;
            background-color: #4caf50;
            /* Cor verde vibrante */
            color: #fff;
            display: flex;
            align-items: center;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
            animation: slideInRight 0.5s ease forwards, fadeOutAndRemove 0.5s ease 5s forwards;
        }

        #successMessage span {
            margin-right: 10px;
        }

        #errorMessage {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
            width: 300px;
            padding: 15px;
            border-radius: 5px;
            background-color: #4caf50;
            /* Cor verde vibrante */
            color: #fff;
            display: flex;
            align-items: center;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
            animation: slideInRight 0.5s ease forwards, fadeOutAndRemove 0.5s ease 5s forwards;
        }

        #errorMessage span {
            margin-right: 10px;
        }


        .form-select {
            padding: 6px 12px;
            font-size: 14px;
            border-radius: 4px;
            border: 1px solid #ced4da;
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
            width: auto;
            /* Ajuste a largura conforme necessário */
        }

        .form-select:focus {
            border-color: #66afe9;
            outline: 0;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand">Protocolos</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link">Olá, <?= session('usuario_nome') ?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link logout" href="<?= base_url('login/logout') ?>">Deslogar</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <?php if (session()->getFlashdata('status')) : ?>
        <div id="successMessage" class="toast align-items-center text-white bg-success border-0 show" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    <i class="fas fa-check-circle me-2"></i>
                    <strong>Sucesso!</strong> <?= session()->getFlashdata('status') ?>
                </div>
            </div>
        </div>
    <?php endif; ?>


    <div class="container mt-5 fade-in">
        <h1 class="mb-4 text-center">Lista de Protocolos Recebidos</h1>
        <a class="btn btn-add btn-download-all" href="<?= base_url('grid/download_todas_pastas/') ?>">Baixar Tudo</a>
        <a class="btn btn-add btn-download-all" href="<?= base_url('grid/exportar_excel') ?>">Baixar Dados em Excel</a>
        <table id="protocolos_table" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>Matricula</th>
                    <th>Nome</th>
                    <th>CPF</th>
                    <th>Situação</th>
                    <th>Status Documento</th>
                    <th>Ações</th> <!-- Nova coluna para as ações -->
                </tr>
            </thead>
            <tbody>
                <?php foreach ($protocolosrecebidos as $protocolo) : ?>
                    <tr>
                        <td><?= $protocolo['protocol_matricula'] ?></td>
                        <td><?= $protocolo['protocol_nome'] ?></td>
                        <td><?= $protocolo['protocol_cpf'] ?></td>
                        <td><?= $protocolo['protocol_situacaoprofissional'] ?></td>
                        <td>
                            <select class="form-select form-select-sm status-dropdown" data-author-matricula="<?= $protocolo['protocol_matricula'] ?>">
                                <option value="RECEBIDO" <?= $protocolo['autor_statusdocumentos'] == 'RECEBIDO' ? 'selected' : '' ?>>Recebido</option>
                                <option value="PENDENTE" <?= $protocolo['autor_statusdocumentos'] == 'PENDENTE' ? 'selected' : '' ?>>Pendente</option>
                                <option value="BAIXADO" <?= $protocolo['autor_statusdocumentos'] == 'BAIXADO' ? 'selected' : '' ?>>Baixado</option>
                                <option value="CONFERIDO" <?= $protocolo['autor_statusdocumentos'] == 'CONFERIDO' ? 'selected' : '' ?>>Conferido</option>
                            </select>
                        </td>
                        <td>
                            <button class="btn btn-action btn-view" data-id="<?= $protocolo['protocol_id'] ?>"><i class="fas fa-eye"></i></button>
                            <a id="downloadButton" href="<?= base_url('grid/download_pasta/' . $protocolo['protocol_matricula']) ?>" class="btn btn-action btn-download"><i class="fas fa-download"></i></a>
                            <span id="loadingSpinner" class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                            <!-- <a href="<?= base_url('login/delete/' . $protocolo['protocol_id']) ?>" class="btn btn-action btn-delete delete-protocol"><i class="fas fa-trash-alt"></i></a> -->
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <!-- Modal -->
    <div class="modal fade" id="viewModal" tabindex="-1" aria-labelledby="viewModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewModalLabel">Detalhes do Protocolo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table class="table">
                        <tbody id="modalContent">
                            <!-- Os detalhes do protocolo serão carregados aqui via AJAX -->
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>


        <!-- Inclua o JavaScript do jQuery, do DataTables e do Bootstrap -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>
        <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js"></script>
        <!-- Inclua o script do SweetAlert2 -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            $(document).ready(function() {
                $('#protocolos_table').DataTable({
                    "pagingType": "simple_numbers",
                    "ordering": true,
                    "searching": true,
                    "info": false,
                    "lengthChange": false,
                    "pageLength": 50,
                    "language": {
                        "lengthMenu": "Mostrar _MENU_ registros por página",
                        "zeroRecords": "Nenhum registro encontrado",
                        "info": "Página _PAGE_ de _PAGES_",
                        "infoEmpty": "Nenhum registro disponível",
                        "infoFiltered": "(filtrado de _MAX_ registros totais)",
                        "search": "Pesquisar:",
                        "paginate": {
                            "first": "Primeira",
                            "last": "Última",
                            "next": "Próxima",
                            "previous": "Anterior"
                        }
                    }
                });

                // $('.delete-protocol').on('click', function(e) {
                //     e.preventDefault();
                //     Swal.fire({
                //         title: 'Tem certeza?',
                //         text: "Você realmente deseja excluir este protocolo?",
                //         icon: 'warning',
                //         showCancelButton: true,
                //         confirmButtonColor: '#3085d6',
                //         cancelButtonColor: '#d33',
                //         confirmButtonText: 'Sim, excluir!',
                //         cancelButtonText: 'Cancelar'
                //     }).then((result) => {
                //         if (result.isConfirmed) {
                //             window.location.href = $(this).attr('href');
                //         }
                //     });
                // });

                $('.logout').on('click', function(e) {
                    e.preventDefault();
                    Swal.fire({
                        title: 'Tem certeza?',
                        text: "Você realmente deseja sair do sistema?",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Sim',
                        cancelButtonText: 'Cancelar'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Se confirmado, redirecione para a URL de exclusão
                            window.location.href = $(this).attr('href');
                        }
                    });
                });

                // Evento para capturar a mudança no valor do dropdown
                $('.status-dropdown').change(function() {
                    var authorMatricula = $(this).data('author-matricula');
                    var newStatus = $(this).val();

                    $.ajax({
                        type: 'POST',
                        url: '<?= base_url('grid/atualizar_status') ?>',
                        data: {
                            author_matricula: authorMatricula,
                            new_status: newStatus
                        },
                        success: function(response) {
                            if (response.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Status atualizado com sucesso!',
                                    showConfirmButton: false,
                                    timer: 1500
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Algo deu errado. Por favor, tente novamente.',
                                });
                            }
                        },
                        error: function(xhr, status, error) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Algo deu errado. Por favor, tente novamente.',
                            });
                        }
                    });
                });

                $('.btn-download').click(function(event) {
                    event.preventDefault();

                    var downloadButton = $(this);
                    var loadingSpinner = downloadButton.siblings('.spinner-border');
                    var dropdown = $(this).closest('tr').find('.status-dropdown');

                    Swal.fire({
                        title: 'Tem certeza?',
                        text: "Você realmente deseja baixar este arquivo?",
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Sim',
                        cancelButtonText: 'Cancelar'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            loadingSpinner.removeClass('d-none');
                            downloadButton.addClass('disabled');

                            // Faça a solicitação AJAX para baixar o arquivo
                            $.ajax({
                                url: downloadButton.attr('href'),
                                type: 'GET',
                                success: function(response) {
                                    console.log('Response received:', response); // Debugging statement

                                    if (response.success) {
                                        // Atualize a interface do usuário, se necessário
                                        dropdown.val('BAIXADO');
                                        // Inicie o download do arquivo
                                        window.location.href = response.download_url;
                                        // Exiba uma mensagem de sucesso para o usuário
                                        Swal.fire({
                                            icon: 'success',
                                            title: 'Sucesso!',
                                            text: response.message
                                        });
                                    } else {
                                        // Exiba uma mensagem de erro se houver um problema
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'Erro!',
                                            text: response.message
                                        });
                                    }
                                },
                                error: function(xhr, status, error) {
                                    console.log('AJAX Error:', xhr, status, error); // Debugging statement
                                    // Exiba uma mensagem de erro se ocorrer um erro na solicitação AJAX
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Erro!',
                                        text: 'Falha ao enviar a solicitação.'
                                    });
                                },
                                complete: function() {
                                    // Remova a classe 'disabled' do botão de download
                                    downloadButton.removeClass('disabled');
                                    // Oculte o spinner de carregamento
                                    loadingSpinner.addClass('d-none');
                                }
                            });
                        }
                    });
                });

                $('.btn-view').click(function(event) {
                    var id = $(this).data('id');
                    $.ajax({
                        url: '<?= base_url('grid/pegar_protocolo_detalhes') ?>',
                        type: 'POST',
                        data: {
                            id: id
                        },
                        success: function(response) {
                            if (response.success) {
                                var content = '';
                                $.each(response.data, function(key, value) {
                    // Verifica se a chave é 'protocol_id' para não incluir no modal
                    if (key !== 'protocol_id') {
                        // Renomeia as chaves para exibição no modal
                        var displayKey = '';
                        switch (key) {
                            case 'protocol_matricula':
                                displayKey = 'Matrícula';
                                break;
                            case 'protocol_nome':
                                displayKey = 'Nome';
                                break;
                            case 'protocol_cpf':
                                displayKey = 'CPF';
                                break;
                            case 'protocol_situacaoprofissional':
                                displayKey = 'Situação Profissional';
                                break;
                            case 'autor_statusdocumentos':
                                displayKey = 'Status Documentos';
                                break;

                                case 'protocol_anoprotocolo':
                                displayKey = 'Ano do Protocolo';
                                break;
                                case 'protocol_tipocategoria':
                                displayKey = 'Tipo Categoria';
                                break;

                                case 'protocol_valor':
                                displayKey = 'Valor';
                                break;

                                case 'protocol_identidade':
                                displayKey = 'Identidade';
                                break;

                                case 'protocol_orgaoexped':
                                displayKey = 'Órgão emissor';
                                break;

                                case 'protocol_estadocivil':
                                displayKey = 'Estado Civil';
                                break;

                                case 'protocol_endereco':
                                displayKey = 'Endereco';
                                break;

                                case 'protocol_numero':
                                displayKey = 'Numero';
                                break;

                                case 'protocol_bairro':
                                displayKey = 'Bairro';
                                break;

                                case 'protocol_cidade':
                                displayKey = 'Cidade';
                                break;

                                case 'protocol_estado':
                                displayKey = 'Estado';
                                break;

                                case 'protocol_cep':
                                displayKey = 'Cep';
                                break;

                                case 'protocol_telefone':
                                displayKey = 'Telefone';
                                break;

                                case 'protocol_celular':
                                displayKey = 'Celular';
                                break;

                                case 'protocol_email':
                                displayKey = 'Email';
                                break;

                                case 'protocol_datahoraenvio':
                                displayKey = 'Data e Hora de envio';
                                break;

                                case 'protocol_ipmaquina':
                                displayKey = 'IP';
                                break;

                                case 'protocol_complemento':
                                displayKey = 'Complemento';
                                break;

                                case 'protocol_codigo':
                                displayKey = 'Codigo';
                                break;

                                case 'protocol_banco':
                                displayKey = 'Banco';
                                break;

                                case 'protocol_agencia':
                                displayKey = 'Agência';
                                break;

                                case 'protocol_operacao':
                                displayKey = 'Operação';
                                break;

                                case 'protocol_contadigito':
                                displayKey = 'Conta com dígito';
                                break;

                            default:
                                displayKey = key;
                                break;
                        }
                        if(!value){
                            value = 'Vazio'
                        }
                        content += '<tr><th>' + displayKey + '</th><td>' + value + '</td></tr>';
                    }
                });
                                $('#modalContent').html(content);
                                $('#viewModal').modal('show');
                                console.log(response.success);
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Erro!',
                                    text: response.message
                                });
                            }
                        },
                        error: function(xhr, status, error) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Erro!',
                                text: 'Falha ao enviar a solicitação.'
                            });
                        }
                        
                    });
                    $('.btn-close, .btn-secondary').on('click', function () {
                $('#viewModal').modal('hide');
            });
                });



            });
        </script>
</body>

</html>