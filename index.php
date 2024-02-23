<?php
session_start();

// Verifica si se ha enviado el formulario para intentar adivinar el número
if (isset($_POST['adivinar'])) {
    // Obtiene el número proporcionado por el usuario
    if (isset($_POST['num_usuario'])) {
        $numUsuario = $_POST['num_usuario'];
        
        // Incrementa el contador de intentos almacenado en la sesión
        $_SESSION['intentos']++;
        
        // Compara el número proporcionado por el usuario con el número secreto almacenado en la sesión
        if ($numUsuario == $_SESSION['num_secreto']) {
            // Si los números son iguales, el usuario adivinó correctamente
            $resultadoMensaje = "¡Felicidades! Adivinaste el número en " . $_SESSION['intentos'] . " intentos.";
            // Habilita la variable para mostrar el botón de reinicio
            $mostrarReinicio = true;
        } elseif ($numUsuario < $_SESSION['num_secreto']) {
            // Si el número del usuario es menor que el número secreto
            $resultadoMensaje = "El número es mayor. Sigue intentando.";
            // Deshabilita la variable para mostrar el botón de reinicio
            $mostrarReinicio = false;
        } else {
            // Si el número del usuario es mayor que el número secreto
            $resultadoMensaje = "El número es menor. Sigue intentando.";
            // Deshabilita la variable para mostrar el botón de reinicio
            $mostrarReinicio = false;
        }
    }
}
// Verificar si se ha solicitado reiniciar el juego
if (isset($_POST['reiniciar'])) {
    unset($_SESSION['num_secreto']);
    unset($_SESSION['intentos']);
    header("Location: ".$_SERVER['PHP_SELF']);
    exit();
}

// Verificar si no se ha generado aún el número secreto en la sesión
if (!isset($_SESSION['num_secreto'])) {
    $_SESSION['num_secreto'] = rand(1, 10);
    $_SESSION['intentos'] = 0;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Juego de Adivinanza</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <style>
        /* Estilos CSS */
        body {
            font-family: "Poppins", sans-serif;
            background: rgb(74,195,34);
            background: -moz-linear-gradient(83deg, rgba(74,195,34,1) 0%, rgba(253,187,45,1) 100%);
            background: -webkit-linear-gradient(83deg, rgba(74,195,34,1) 0%, rgba(253,187,45,1) 100%);
            background: linear-gradient(83deg, rgba(74,195,34,1) 0%, rgba(253,187,45,1) 100%);
            filter: progid:DXImageTransform.Microsoft.gradient(startColorstr="#4ac322",endColorstr="#fdbb2d",GradientType=1);
            text-align: center;
            margin: 50px;
        }

        .contenedor {
            max-width: 800px;
            margin: 0 auto;
            background: rgba(255, 255, 255, 0.8); /* Fondo transparente */
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 0 30px rgba(0,0,0,0.1);
        }

        h1 {
            color: #333;
            margin-top: 0;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /*icono de luz*/
        i {
            margin-right: 10px;
            color: #fdbb2d;
        }
        
        /*Formulario*/
        form {
            margin-top: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
            input::-webkit-outer-spin-button,
            input::-webkit-inner-spin-button {
              -webkit-appearance: none;
              margin: 0;
            }   
        }

        label {
            font-size: 18px;
            color: #555;
            margin-bottom: 10px;
        }

        input {
            padding: 12px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 6px;
            width: 200px;
            margin-bottom: 20px;
            box-sizing: border-box;
        }

        button {
            padding: 12px 24px;
            font-size: 18px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            box-shadow: 0 2px 4px rgba(0,0,0,0.2);
        }

        button.adivinar {
            background-color: #3498DB;
            color: white;
        }

        button.reiniciar {
            background-color: #4CAF50;
            color: white;
        }

        button:hover {
            background-color: #555;
        }

        p {
            font-size: 20px;
            color: #333;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="contenedor">
        <h1><i class="fas fa-lightbulb"></i> ADIVINA EL NÚMERO SECRETO</h1>

        <?php if (isset($resultadoMensaje)) : ?>
            <p><?php echo $resultadoMensaje; ?></p>
        <?php endif; ?>

        <form method="post" action="">
            <?php if (isset($mostrarReinicio) && $mostrarReinicio) : ?>
                <button type="submit" name="reiniciar" class="reiniciar">Reiniciar Juego</button>
            <?php else : ?>
                <label for="num_usuario">Ingresa un número del 1 al 10</label>
                <input type="number" name="num_usuario" required>
                <button type="submit" name="adivinar" class="adivinar">Adivinar</button>
            <?php endif; ?>
        </form>
    </div>
</body>
</html>