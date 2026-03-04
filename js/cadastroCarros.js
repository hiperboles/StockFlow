const uploadQuadrado = document.getElementById("upload-quadrado");
const inputImagem = document.getElementById("input-imagem");
const previewImagem = document.getElementById("preview-imagem");
const textoUpload = document.getElementById("texto-upload");
const botaoRemover = document.getElementById("remover-imagem");

uploadQuadrado.addEventListener("click", () => {
  inputImagem.click();
});

inputImagem.addEventListener("change", () => {
  const file = inputImagem.files[0];
  if (file) {
    const reader = new FileReader();
    reader.onload = e => {
      previewImagem.src = e.target.result;
      previewImagem.style.display = "block";
      textoUpload.style.display = "none";
      botaoRemover.style.display = "block";
    };
    reader.readAsDataURL(file);
  }
});

botaoRemover.addEventListener("click", (e) => {
  e.stopPropagation();
  inputImagem.value = "";
  previewImagem.src = "";
  previewImagem.style.display = "none";
  textoUpload.style.display = "block";
  botaoRemover.style.display = "none";
});
