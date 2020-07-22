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

    <form method="post" onsubmit="return false;" action="functions.php" class="form-submit" style="width: 50%;border-radius: 6px;margin-top:2rem;">
      <input type="hidden" name="action_form" value="devices">
      <input type="hidden" name="session" value="<?= $_GET['session']; ?>">
      <h1>Criar dispositivo</h1>
      <div class="icon">
        <i class="fas fa-cog"></i>
      </div>
      <div class="formcontainer">
      <div class="container">
        <label for="server"><strong>Nome do servidor</strong></label>
        <input type="text" placeholder="ex.: Meu servidor de teste" name="server" required>
        <label for="ip"><strong>IP</strong></label>
        <input type="text" placeholder="ex.: http://192.168.1.1:8080" name="ip" required>
        <label for="public_key"><strong>Chave Pública</strong></label>
        <input type="text" placeholder="Digite a chave pública" name="public_key">
      </div>
      
      <input type="submit" class="send" data-button-action="Enviando..." value="Enviar">

    </form>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="/js/jquery.validate.js" type="text/javascript"></script>
<script src="/js/main.js"></script>
</body>
</html>