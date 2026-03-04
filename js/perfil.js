document.addEventListener("DOMContentLoaded", () => {
    const empresa = window.empresa || {};

    if (empresa) {
        document.getElementById("id_empresa").value = empresa.id_empresa || "";
        document.getElementById("email").value = empresa.email || "";
        document.getElementById("cnpj").value = empresa.cnpj || "";
        document.getElementById("nome_fantasia").value = empresa.nome_fantasia || "";
        document.getElementById("telefone").value = empresa.telefone || "";
        document.getElementById("cep").value = empresa.cep || "";
        document.getElementById("endereco").value = empresa.endereco || "";
        document.getElementById("numero").value = empresa.numero || "";
        document.getElementById("bairro").value = empresa.bairro || "";
        document.getElementById("cidade").value = empresa.cidade || "";
        document.getElementById("estado").value = empresa.estado || "";
    }
});
