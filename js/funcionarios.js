const form = document.querySelector(".cadFuncionario");
const plus = document.querySelector(".plus");
const barContainer = document.querySelector(".wid-bar");
const users = document.querySelectorAll(".button-data");
const divConsulta = document.querySelector(".divConsulta");
const trash = document.querySelector(".trash");
const user = document.querySelectorAll(".users");
const edit = document.querySelector(".edit");
const campos = document.querySelectorAll(".inpsData");


plus.addEventListener("click", () => {
  form.classList.toggle("show");
  plus.classList.toggle("mais");
  barContainer.classList.toggle("widd");
});

document.addEventListener("keydown", event => {
  if (event.key === 'Escape') {
  form.classList.remove("show");
  plus.classList.remove("mais");
  barContainer.classList.remove("widd");
  divConsulta.classList.remove("consultaShow");
  }
});

users.forEach(user => {
  user.addEventListener("click", () => {
    divConsulta.classList.add("consultaShow");
    const editAtivo = edit.classList.contains("edit-click");
    const deleteAtivo = trash.classList.contains("trash-click");

    campos.forEach(f => {
      f.readOnly = !(editAtivo && !deleteAtivo);
    });
  });
});




//delete click
document.addEventListener("keydown", event => {
  if ((event.key === "q" || event.key === "Q") && !form.classList.contains("show")) {
    const consulta = document.querySelector(".consultaDados");

    if (consulta && !divConsulta.classList.contains("consultaShow")) {
      // ativa/desativa delete
      trash.classList.toggle("trash-click");
      divConsulta.classList.remove("consultaShow");
      consulta.classList.toggle("consultaDelete");

      user.forEach(useres => {
        useres.classList.toggle("user-delete");
      });

      // DESATIVA EDIT
      edit.classList.remove("edit-click");
      consulta.classList.remove("consultaEdit");
      user.forEach(useres => {
        useres.classList.remove("user-edit");
      });
    }
    campos.forEach(fields => {
    if(trash.classList.contains("trash-click")){ // detectar classe em um elemento
      fields.readOnly = true;
    }else{
      fields.readOnly = false;
    }
    });
  }
});

trash.addEventListener("click", () => {

  const consulta = document.querySelector(".consultaDados");

  if (consulta) {
    // ativa/desativa delete
    trash.classList.toggle("trash-click");
    divConsulta.classList.remove("consultaShow");
    consulta.classList.toggle("consultaDelete");

    user.forEach(useres => {
      useres.classList.toggle("user-delete");
    });

    // DESATIVA EDIT
    edit.classList.remove("edit-click");
    consulta.classList.remove("consultaEdit");
    user.forEach(useres => {
      useres.classList.remove("user-edit");
    });
  }
});




//edit click
document.addEventListener("keydown", event=>{
   if ((event.key === "e" || event.key === "E") && !form.classList.contains("show")) {
    const consulta = document.querySelector(".consultaDados");
    
    if (consulta && !divConsulta.classList.contains("consultaShow")) {
      edit.classList.toggle("edit-click");
      divConsulta.classList.remove("consultaShow");
      consulta.classList.toggle("consultaEdit");

      consulta.classList.remove("consultaDelete");
      trash.classList.remove("trash-click");

      user.forEach(useres => {
      useres.classList.toggle("user-edit");
    });
    user.forEach(useres => {
      useres.classList.remove("user-delete");
    });
    }
    // campo();
    campos.forEach(fields => {
    if(edit.classList.contains("edit-click")){ // detectar classe em um elemento
      fields.readOnly = false;
    }else{
      fields.readOnly = true;
    }
    });
  }
});

edit.addEventListener("click", () => {
  const consulta = document.querySelector(".consultaDados");

  if (consulta) {
    // mesmo comportamento do keydown
    edit.classList.toggle("edit-click");
    divConsulta.classList.remove("consultaShow");

    consulta.classList.toggle("consultaEdit");
    consulta.classList.remove("consultaDelete");

    trash.classList.remove("trash-click");

    user.forEach(useres => {
      useres.classList.toggle("user-edit");
      useres.classList.remove("user-delete");
    });
  }
});

//campos com edit

function campo(){
campos.forEach(fields => {
  if(edit.classList.contains("edit-click")){ // detectar classe em um elemento
    fields.readOnly = true;
  }else{
    fields.readOnly = false;
  }
});
}
