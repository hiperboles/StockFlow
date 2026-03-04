function consulta(botao) {
    const id = botao.id.trim();

    fetch('PHP/consultaFuncionario.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'botaoId=' + encodeURIComponent(id)
    })
    .then(response => response.json())
    .then(funcionario => {
        document.getElementById('consulta_id_funcionario').value = funcionario.id_funcionario;
        document.getElementById('consulta_email').value = funcionario.email;
        document.getElementById('consulta_nome').value = funcionario.nome;
        document.getElementById('consulta_telefone').value = funcionario.telefone;
        document.getElementById('consulta_cpf').value = funcionario.cpf;
        
    })
    .catch(error => {
        console.error('Erro ao buscar dados do funcionário:', error);
    });
}

function empresa() {
    $('#consulta_telefone').mask('(00) 00000-0000');

    function validarCampo(id) {
        const campo = document.getElementById(id);
        const valor = campo.value.trim();
        let errorElement = $('#error-' + id);

        
        if (errorElement.length === 0) {
            errorElement = $('<span id="error-' + id + '" style="color:red; display:block; font-size:0.9em;"></span>');
            $('#' + id).after(errorElement);
        }

        errorElement.text('');

        
        switch(id) {
            case 'consulta_cpf':
                if (!/^\d{11}$/.test(valor)) {
                    errorElement.text('CPF inválido (11 dígitos numéricos)');
                    return false;
                }
                break;

            case 'consulta_telefone':
                const telefoneNumeros = valor.replace(/\D/g, '');
                if (telefoneNumeros.length < 10 || telefoneNumeros.length > 11) {
                    errorElement.text('Telefone inválido (10 ou 11 dígitos)');
                    return false;
                }
                break;

            case 'consulta_email':
                if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(valor)) {
                    errorElement.text('Email inválido');
                    return false;
                }
                break;

            case 'consulta_nome':
                if (valor.length < 3) {
                    errorElement.text('Nome muito curto');
                    return false;
                }
                break;
        }

        return true;
    }

    function validarFormulario() {
        const campos = ['consulta_cpf', 'consulta_nome', 'consulta_telefone', 'consulta_email'];
        let valido = true;

        campos.forEach(function(id) {
            if (!validarCampo(id)) {
                valido = false;
            }
        });

        return valido;
    }

    
    $('#btnAtualizar').off().click(function(e) {
        e.preventDefault();

        if (validarFormulario()) {
            $('#loginForm2').attr('action', 'PHP/atualizaFuncionario.php');
            $('#loginForm2').submit();
        } else {
            alert('Por favor, corrija os erros no formulário antes de atualizar.');
        }
    });

    
    $('#btnExcluir').off().click(function(e) {
        e.preventDefault();

        if (confirm('Tem certeza que deseja excluir o funcionário? Esta ação não pode ser desfeita.')) {
            $('#loginForm2').attr('action', 'PHP/excluirFuncionario.php');
            $('#loginForm2').submit();
        }
    });
}

document.addEventListener('DOMContentLoaded', function () {
    empresa();
});
