// js/filtroMarca.js

document.addEventListener("DOMContentLoaded", () => {
  const params = new URLSearchParams(window.location.search);
  const marca = params.get("marca");

  if (!marca) return;

  const titulo = document.querySelector("#tituloMarca");
  if (titulo) titulo.textContent = `Carros da marca: ${marca}`;

  // Simula o cadastro pré-existente (ou use localStorage / backend real)
  const carrosCadastrados = JSON.parse(localStorage.getItem("carros")) || [];

  const carrosFiltrados = carrosCadastrados.filter(
    (carro) => carro.marca.toLowerCase() === marca.toLowerCase()
  );

  const container = document.querySelector("#listaCarros");
  container.innerHTML = "";

  if (carrosFiltrados.length === 0) {
    container.innerHTML = "<p>Nenhum carro encontrado para esta marca.</p>";
    return;
  }

  carrosFiltrados.forEach((carro) => {
    const card = document.createElement("div");
    card.classList.add("carro-card");
    card.innerHTML = `
      <img src="${carro.imagem || 'imagens/placeholder-carro.jpg'}" alt="${carro.modelo}" class="carro-imagem">
      <h3>${carro.modelo}</h3>
      <p><strong>Ano:</strong> ${carro.ano}</p>
      <p><strong>Preço:</strong> R$ ${carro.preco}</p>
    `;
    container.appendChild(card);
  });
});
