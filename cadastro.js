function mask(o, f) {
    setTimeout(function() {
      var v = mphone(o.value);
      if (v != o.value) {
        o.value = v;
      }
    }, 1);
  }
  
  function mphone(v) {
    var r = v.replace(/\D/g, "");
    r = r.replace(/^0/, "");
    if (r.length > 10) {
      r = r.replace(/^(\d\d)(\d{5})(\d{4}).*/, "($1) $2-$3");
    } else if (r.length > 5) {
      r = r.replace(/^(\d\d)(\d{4})(\d{0,4}).*/, "($1) $2-$3");
    } else if (r.length > 2) {
      r = r.replace(/^(\d\d)(\d{0,5})/, "($1) $2");
    } else {
      r = r.replace(/^(\d*)/, "($1");
    }
    return r;
  }
  
  function CheckPassword() 
  { 
    inputtxt = document.getElementById("idade");
    var decimal=  /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[^a-zA-Z0-9])(?!.*\s).{8,15}$/;
    if(inputtxt.value.match(decimal)) 
    { 
    let letra = document.getElementById("letter");

    letra.classList.remove("invalido");
    letra.classList.add("valido");
    }
    else
    { 
    }
  }
  function checkIdade(){
    inputtxt = document.getElementById("psw");
    var decimal=  (1,2,3,4,5,6,7,8,9,10);
    if(inputtxt.value.match(decimal)) 
    { 
    let letra = document.getElementById("letter");

    letra.classList.remove("invalido");
    letra.classList.add("valido");
    }
    else
    { 
    }

  }

  
  function TesteFinal(){
    inputtxt = document.getElementById("psw");
    var numeros = /([0-9])/;
    var alfabeto = /([a-zA-Z])/;
    if(inputtxt.value.match(numeros) && inputtxt.value.match(alfabeto)) 
    {
      return true;


    }else{
      alert('Senha não cumpre os requisitos');
      window.location.href='cadastro.php';
      event.preventDefault();


    }
  }
