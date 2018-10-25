<!DOCTYPE html>
<html>
<head>
    <title>AppModel</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
body {font-family: Arial, Helvetica, sans-serif;}

/* Full-width input fields */
input[type=text], input[type=password] {
    width: 96%;
    padding: 12px 20px;
    margin: 8px 0;
    display: inline-block;
    border: 1px solid #ccc;
    box-sizing: border-box;
}

/* Set a style for all buttons */
button {
    background-color: #00ab94;
    color: white;
    padding: 14px 20px;
    margin: 8px 0;
    border: none;
    cursor: pointer;
    width: 96%;
}

button:hover {
    opacity: 0.8;
}

/* Extra styles for the cancel button */
.cancelbtn {
    width: auto;
    padding: 10px 18px;
    background-color: #f44336;
    align-items: center;
}

/* Center the image and position the close button */
.imgcontainer {
    text-align: center;
    margin: 24px 0 12px 0;
    position: relative;

}

.login {
    width: 300px;
    height: 180px;
    background-color: #ffffff99;
    text-align: center;
    position: relative;
    margin-top: 200px;
    padding: 20px;
    margin: 170px auto;
}

.avatar {
    width: 24%;
    border-radius: 50%;
}

.background {

    background-color: #ddf9f7;
    background-image: url(background.jpg);
    background-size: cover;
    background-repeat: no-repeat;


}
.container {
    padding: 5px;
    text-align: -webkit-center;
    color: #5a5959;

}

.span.psw {
    float: right;
    padding-top: 16px;
}

/* The Modal (background) */
.modal {
    display: none; /* Hidden by default */
    position: fixed; /* Stay in place */
    z-index: 1; /* Sit on top */
    left: 0;
    top: 0;
    width: 100%; /* Full width */
    height: 100%; /* Full height */
    overflow: auto; /* Enable scroll if needed */
    background-color: rgb(0,0,0); /* Fallback color */
    background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
    padding-top: 100px;
}

/* Modal Content/Box */
.modal-content {
    background-color: #fefefe96;
    margin: 1% auto 1% auto; /* 5% from the top, 15% from the bottom and centered */
    border: 1px solid #999;
    width: 23%; /* Could be more or less, depending on screen size */
    margin-top: 130px;
}

/* The Close Button (x) */
.close {
    position: absolute;
    right: 25px;
    top: 0;
    color: #000;
    font-size: 35px;
    font-weight: bold;

}

.close:hover,
.close:focus {
    color: red;
    cursor: pointer;
}

/* Add Zoom Animation */
.animate {
    -webkit-animation: animatezoom 0.6s;
    animation: animatezoom 0.6s
}

@-webkit-keyframes animatezoom {
    from {-webkit-transform: scale(0)} 
    to {-webkit-transform: scale(1)}
}
    
@keyframes animatezoom {
    from {transform: scale(0)} 
    to {transform: scale(1)}
}

/* Change styles for span and cancel button on extra small screens */
@media screen and (max-width: 300px) {
    span.psw {
       display: block;
       float: none;
    }
    .cancelbtn {
       width: 100%;
    }
}
</style>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
</head>

<body class="background">
            
<!--<div class="login" font-face="Arial" >
<h2>Seja Bem Vindo!</h2>
<h3>Faça seu login</h3>


<button onclick="document.getElementById('id01').style.display='block'" style="width:auto;">Login</button>
</div>
<div id="id01" class="modal">-->
<div> 
  <form class="modal-content animate" action="valida_usuario.php" method="POST">
    <div class="imgcontainer">
      <!--<span onclick="document.getElementById('id01').style.display='none'" class="close" title="Close Modal">&times;</span>-->
      <img src="app.images/bing.png" alt="Avatar" class="avatar">
    </div>

    <div class="container">
      <label for="uname"><b>Usuário</b></label>
      <input type="text" placeholder="Email ou CPF" name="login" required>

      <label for="psw"><b>Senha</b></label>
      <input type="password" placeholder="Insira sua senha" name="senha" required>
        
      <button type="submit">Entrar</button>
      <!--<label>
        <input type="checkbox" checked="checked" name="remember"> Lembrar-me
      </label>-->
    
    </div>

    <!--<div class="container" style="background-color:#f1f1f1">
      <button type="button" onclick="document.getElementById('id01').style.display='none'" class="cancelbtn">Cancelar</button>
      
    </div>-->
  </form>
</div>

<script>
// Get the modal
var modal = document.getElementById('id01');

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}
</script>

</body>
</html>
