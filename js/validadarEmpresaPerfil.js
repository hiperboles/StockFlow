$(document).ready(function() {
    
    $('#telefone').mask('(00) 00000-0000');
    $('#cnpj').mask('00.000.000/0000-00');
    $('#cep').mask('00000-000');

    
    function validarCampo(id) {
        const $campo = $('#' + id);
        const valorBruto = $campo.val().trim();
        let errorElement = $('#error-' + id);

        
        if (errorElement.length === 0) {
            errorElement = $('<small id="error-' + id + '" class="error-message" style="color:red; display:block; font-size:0.9em;"></small>');
            $campo.after(errorElement);
        }
        errorElement.text('');
        $campo.removeClass('valido invalido');

        if (!valorBruto) {
            errorElement.text('Campo obrigatório');
            $campo.addClass('invalido');
            return false;
        }

        switch(id) {
            case 'cnpj':
                const cnpj = valorBruto.replace(/\D/g, '');
                if (!/^\d{14}$/.test(cnpj)) {
                    errorElement.text('CNPJ inválido (14 números)');
                    $campo.addClass('invalido');
                    return false;
                }
                break;

            case 'telefone':
                const telefone = valorBruto.replace(/\D/g, '');
                if (telefone.length < 11 || telefone.length > 11) {
                    errorElement.text('Telefone inválido (11 dígitos)');
                    $campo.addClass('invalido');
                    return false;
                }
                break;

            case 'email':
                const regexEmail = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!regexEmail.test(valorBruto)) {
                    errorElement.text('Email inválido');
                    $campo.addClass('invalido');
                    return false;
                }
                break;

            case 'nome_fantasia':
                if (valorBruto.length < 3) {
                    errorElement.text('Nome Fantasia muito curto');
                    $campo.addClass('invalido');
                    return false;
                }
                break;

            case 'cep':
                const cep = valorBruto.replace(/\D/g, '');
                if (!/^\d{8}$/.test(cep)) {
                    errorElement.text('CEP inválido (8 números)');
                    $campo.addClass('invalido');
                    return false;
                }
                break;

            case 'numero':
                const apenasNumeros = valorBruto.replace(/\D/g, '');
                if (!/^\d{1,7}$/.test(apenasNumeros) || Number(apenasNumeros) <= 0) {
                    errorElement.text('Número inválido (até 7 dígitos)');
                    $campo.addClass('invalido');
                    return false;
                }
                break;

            case 'endereco':
            case 'bairro':
            case 'cidade':
            case 'estado':
                if (valorBruto.length < 2) {
                    errorElement.text('Campo muito curto');
                    $campo.addClass('invalido');
                    return false;
                }
                break;
        }

       
        $campo.addClass('valido');
        errorElement.text('');
        return true;
    }

    
    const campos = ['email', 'cnpj', 'nome_fantasia', 'telefone', 'cep', 'endereco', 'numero', 'bairro', 'cidade', 'estado'];
    campos.forEach(function(id) {
        $('#' + id).on('input blur', function() {
            validarCampo(id);
        });
    });

    
    function validarFormulario() {
        let valido = true;
        campos.forEach(function(id) {
            if (!validarCampo(id)) valido = false;
        });
        return valido;
    }

    
    $('#btnAtualizar').click(function(e) {
        e.preventDefault();
        if (validarFormulario()) {
            $('#Perfil').attr('action', 'PHP/confirmarAtualizarEmpresa.php');
            $('#Perfil').submit();
        } else {
            alert('Corrija os erros antes de atualizar.');
        }
    });

    
    $('#btnDeletar').click(function(e) {
        e.preventDefault();
        if (confirm('Tem certeza que deseja deletar a empresa? Esta ação não pode ser desfeita.')) {
            $('#Perfil').attr('action', 'PHP/confirmarDeletarEmpresa.php');
            $('#Perfil').submit();
        }
    });
});
