document.addEventListener('DOMContentLoaded', () => {
    const inputImagens = document.getElementById('imagens');
    const previewContainer = document.createElement('div');
    previewContainer.style.display = 'flex';
    previewContainer.style.flexWrap = 'wrap';
    previewContainer.style.gap = '10px';
    previewContainer.style.marginTop = '10px';
  
 
    inputImagens.parentNode.insertBefore(previewContainer, inputImagens.nextSibling);
  
    inputImagens.addEventListener('change', () => {
      previewContainer.innerHTML = '';
  
      const files = inputImagens.files;
      if (!files.length) return;
  
      Array.from(files).forEach(file => {
        if (!file.type.startsWith('image/')) return;
  
        const reader = new FileReader();
        reader.onload = (e) => {
          const img = document.createElement('img');
          img.src = e.target.result;
          img.style.width = '100px';
          img.style.height = 'auto';
          img.style.borderRadius = '8px';
          img.style.boxShadow = '0 0 5px rgba(0,0,0,0.2)';
          previewContainer.appendChild(img);
        };
        reader.readAsDataURL(file);
      });
    });
  });