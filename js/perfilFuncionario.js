document.addEventListener("DOMContentLoaded", () => {
    const funcionario = window.funcionario || {};

    if (funcionario) {
        document.getElementById("id_funcionario").value = funcionario.id_funcionario || "";
        document.getElementById("email").value = funcionario.email || "";
        document.getElementById("cpf").value = funcionario.cpf || "";
        document.getElementById("nome").value = funcionario.nome || "";
        document.getElementById("telefone").value = funcionario.telefone || "";
    }
});
