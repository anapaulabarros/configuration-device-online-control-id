<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ControlID - IDFlex</title>
    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@300&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css" integrity="sha384-5sAR7xN1Nv6T6+dT2mhtzEpVJvfS3NScPQTrOxhwjIuvcA67KV2R5Jz6kr4abQsz" crossorigin="anonymous">
    <link href="./css/style.css" rel="stylesheet">
</head>
<body>

    <form method="post" onsubmit="return false;" action="functions.php" class="form-submit" style="width: 80%;border-radius: 6px;margin-top:2rem;">
      <input type="hidden" name="action_form" value="login">
      <h1>Área de acesso</h1>
      <div class="icon">
        <i class="fas fa-user-circle"></i>
      </div>
      <div class="formcontainer">
      <div class="container">
        <label for="user"><strong>Usuário</strong></label>
        <input type="text" placeholder="Digite seu usuário" name="user" required>
        <label for="psw"><strong>Senha</strong></label>
        <input type="password" placeholder="Digite sua senha" name="psw" required>
      </div>
      
      <input type="submit" class="send" data-button-action="Acessando..." value="Acessar">

    </form>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="/js/jquery.validate.js" type="text/javascript"></script>
<script src="/js/main.js"></script>
</body>
</html>