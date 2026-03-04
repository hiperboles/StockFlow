// js/carrossel.js
function scrollCarrossel(direction) {
    const carrossel = document.getElementById("carrossel");
    if (!carrossel) return;

    const scrollAmount = carrossel.clientWidth * 0.8; // scroll 80% da largura
    const delta = direction === "left" ? -scrollAmount : scrollAmount;

    carrossel.scrollBy({ left: delta, behavior: "smooth" });
}

// Redirecionamento ao clicar no card
document.addEventListener("DOMContentLoaded", () => {
    const cards = document.querySelectorAll(".marca-card");
    cards.forEach(card => {
        card.addEventListener("click", () => {
            const marca = card.dataset.marca;
            if (!marca) return;
            window.location.href = `PHP/veiculos.php?marca=${encodeURIComponent(marca)}`;
        });
    });
});
