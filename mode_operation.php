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
    <form method="post" onsubmit="return false;" action="functions.php" class="form-submit" style="border-radius: 6px;margin-top:4rem;" id="form_sair">
      

      <p>Modo online ativado com sucesso.</p>

      <input type="hidden" name="action_form" value="logout">
  
      <input type="submit" class="send" data-button-action="Saindo..." value="Sair">
    </form>

    <form method="post" onsubmit="return false;" action="functions.php" class="form-submit" style="width: 100%;border-radius: 6px;margin-top:2rem;" id="form_online">
      <input type="hidden" name="action_form" value="set_configurations">
      <input type="hidden" name="session" value="<?= $_GET['session']; ?>">
      <h1>Alterar servidor</h1>
      <div class="icon">
        <i class="fas fa-server"></i>
      </div>
      <div class="formcontainer">
      <div class="container">
        <label for="server_id"><strong>ID do servidor</strong></label>
        <input type="text" placeholder="Digite ID do servidor" name="server_id"  value="<?= $_GET['ids']; ?>" required>
      </div>
      
      <input type="submit" class="send" data-button-action="Enviando..." value="Enviar">

    </form>

   

    


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="/js/jquery.validate.js" type="text/javascript"></script>
<script src="/js/main.js"></script>
</body>
</html>