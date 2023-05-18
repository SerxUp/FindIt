<?php ob_start(); ?>
<!DOCTYPE html>
<html lang="en">


<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <link href="templates/css/404style.css" rel="stylesheet">
    <title>Find It | Account Verification</title>
    <!-- Favicons -->
    <link href="templates/home/assets/img/findit-favicon.png" rel="icon">
    <link href="templates/home/assets/img/findit-favicon.png" rel="apple-touch-icon">
</head>

<body>
    <section class="notFound">
        <div class="img">
            <img class="img-fluid" src="https://assets.codepen.io/5647096/backToTheHomepage.png" alt="Back to the Homepage" />
            <img class="img-fluid" src="https://assets.codepen.io/5647096/Delorean.png" alt="El Delorean, El Doc y Marti McFly" />
        </div>
        <div class="text">
            <h1 class="text-uppercase"><?php echo isset($msg['first']) ? $msg['first'] : 'Whoopsie!'; ?></h1>
            <h2 class="text-uppercase"><?php echo isset($msg['second']) ? $msg['second'] : 'Something weird happened...'; ?></h2>
            <h3>
                <?php if (isset($errores['token'])) {
                    echo $errores['token'];
                }
                ?>
            </h3>
            <h3>BACK TO HOME?</h3>
            <a href="index.php?ctl=home" class="yes">YES</a>
            <a href="https://www.youtube.com/watch?v=G3AfIvJBcGo">NO</a>
        </div>
    </section>
</body>

<?php
$error = true;
$contenido = ob_get_clean();
?>

<?php include 'layout.php' ?>