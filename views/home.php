<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../views/img/logoEmpresa.png" type="image/x-icon">
    <title>Sistemas de Ventas - Home</title>
</head>
<body>
    <?php include("menu.php") ?>
    <section class="container_section">
        <h1 class="welcome_title">
            Bienvenido <?= $data['employee'] ?>
        </h1>
        <p class="welcome_text">
            <span>Cargo: </span><?= $data['jobTitle'] ?>    
        </p>
        <p class="welcome_text">
            <span>Oficina: </span><?= $data['infoaddress'] ?>    
        </p>
        <p class="welcome_text">
            <span>Teléfono: </span><?= $data['phone'] ?>
        </p>
        <p class="welcome_text">
            <span>Encargado: </span><?= $data['reportPerson'] ?>
        </p>
    </section>
</body>
</html>