$(document).ready(function() {

   
    $('#telefone').mask('(00) 00000-0000');
    $('#cpf').mask('000.000.000-00');

    
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
            case 'nome':
                if (valorBruto.length < 3) {
                    errorElement.text('Nome muito curto');
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

            case 'telefone':
                const telefone = valorBruto.replace(/\D/g, '');
                if (telefone.length !== 11) {
                    errorElement.text('Telefone inválido (11 dígitos)');
                    $campo.addClass('invalido');
                    return false;
                }
                break;

            case 'cpf':
                const cpf = valorBruto.replace(/\D/g, '');
                if (!/^\d{11}$/.test(cpf)) {
                    errorElement.text('CPF inválido (11 dígitos)');
                    $campo.addClass('invalido');
                    return false;
                }
                break;
        }

        $campo.addClass('valido');
        errorElement.text('');
        return true;
    }

    
    const campos = ['nome', 'email', 'telefone', 'cpf'];

    
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

    // Botão Atualizar
    $('#btnAtualizar').click(function(e) {
        e.preventDefault();
        if (validarFormulario()) {
            $('#Perfil').attr('action', 'autorizarFuncionario.php');
            $('#Perfil').submit();
        } else {
            alert('Corrija os erros antes de enviar a solicitação.');
        }
    });

});
