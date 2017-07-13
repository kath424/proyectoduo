<?php

// antes de cargar el contenido
// si no esta logeado, mandar a login
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$titulo = "Preguntas de Seguridad";
$css = ["estilos/estilore.css"];
require('encabezado.php');

?>

<?php


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $error = false;
    // guardar las preguntas de seguridad y mandar a login
    $preguntas_values = [];
    if( (empty($_POST['pregunta1']) && !empty($_POST['respuesta1']))  ){
        $pregunta1_error =" Debe tener pregunta ";
        $error=true;
    }
    else if( (!empty($_POST['pregunta1']) && empty($_POST['respuesta1']))  ){
        $pregunta1_error =" Debe tener respuesta ";
        $error=true;
    }else{
        $preguntas_values[] = "('{$_POST['pregunta1']}', '{$_POST['respuesta1']}' , {$_SESSION['user_id']} )";
    }

    // pregunta2
    if( (empty($_POST['pregunta2']) && !empty($_POST['respuesta2']))  ){
        $pregunta2_error =" Debe tener pregunta ";
        $error=true;
    }
    else if( (!empty($_POST['pregunta2']) && empty($_POST['respuesta2']))  ){
        $pregunta2_error =" Debe tener respuesta ";
        $error=true;
    }else{
        $preguntas_values[] = "('{$_POST['pregunta1']}', '{$_POST['respuesta1']}' , {$_SESSION['user_id']} )";
    }

    // pregunta 3
    if( (empty($_POST['pregunta3']) && !empty($_POST['respuesta3']))  ){
        $pregunta3_error =" Debe tener pregunta ";
        $error=true;
    }
    else if( (!empty($_POST['pregunta3']) && empty($_POST['respuesta3']))  ){
        $pregunta3_error =" Debe tener respuesta ";
        $error=true;
    }else{
        $preguntas_values[] = "('{$_POST['pregunta1']}', '{$_POST['respuesta1']}' , {$_SESSION['user_id']}  )";
    }

    if(!$error){
        $query = "insert into preguntas_de_seguridad "
            ." (pregunta, respuesta, usuarios_id) VALUES"
            . implode(',',$preguntas_values);
            ;
        // connectarse a la base de datos
        // hace disponible el objecto $mysqli  ya conectado a la base de datos
        require('conneccion.php');
        $resultado = $mysqli->query($query);
        if($resultado){
            header('Location: index.php');
            exit;
        }else{
            echo '<div style="color:red;" > Error trying to save questions </div>';
        }


    }

}

?>

<style>
    form label{
        margin: 12px;
    }
    form input{
        margin: 12px;
        width: 90%;
        float:left;
    }
    #banner{
        height: 720px;
    }
    .btn {
        border: none;
        color: white;
        padding: 15px 32px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 16px;
    }

    .btn-grande {font-size: 24px;}

    .btn:hover {background-color: #3e8e41}

    .btn:active {
        background-color: #3e8e41;
        box-shadow: 0 5px #666;
        transform: translateY(4px);
    }

    .btn.btn-verde{
        background-color: #4CAF50; /* verde */
    }
    .izquireda{
        float:left;
    }

    .derecha{
        float:right;
    }

    label{
        font-weight: bolder;
    }




</style>

<form action="registro2.php" method="POST">
    <div id="banner">
        <h3>Estas preguntas se usaran para recuperar usuario o contrasenia</h3>
        <h4>Pregunta 1</h4>
        <div style="width: 100%">
            <label for="pregunta1"> Pregunta</label>
            <input id="pregunta1"  name="pregunta1" value="<?php echo isset($_POST['pregunta1'])?$_POST['pregunta1']:'' ?>" >
            <br />
            <label for="respuesta1"> Respuesta</label>
            <input id="respuesta1" name="respuesta1" value="<?php echo isset($_POST['respuesta1'])?$_POST['respuesta1']:'' ?>" >
            <br />
            <br />
            <br />

            <label style="color:red;"><?php echo isset($pregunta1_error)?$pregunta1_error:'' ?></label>
        </div>
        <hr />
        <h4>Pregunta 2</h4>
        <div style="width: 100%">
            <label for="pregunta2"> Pregunta</label>
            <input id="pregunta2" name="pregunta2" value="<?php echo isset($_POST['pregunta2'])?$_POST['pregunta2']:'' ?>" >
            <br />
            <label for="respuesta2"> Respuesta</label>
            <input id="respuesta2" name="respuesta2" value="<?php echo isset($_POST['respuesta2'])?$_POST['respuesta2']:'' ?>" >
            <br />
            <br />
            <br />
            <div style="color:red;"><?php echo isset($pregunta2_error)?$pregunta2_error:'' ?></div>
        </div>
        <hr />
        <h4>Pregunta 2</h4>
        <div style="width: 100%">
            <label for="pregunta3"> Pregunta</label>
            <input id="pregunta3" name="pregunta3" value="<?php echo isset($_POST['pregunta3'])?$_POST['pregunta3']:'' ?>" >
            <br />
            <label for="respuesta3"> Respuesta</label>
            <input id="respuesta3" name="respuesta3" value="<?php echo isset($_POST['respuesta3'])?$_POST['respuesta3']:'' ?>" >
            <br />
            <br />
            <br />
            <div style="color:red;"><?php echo isset($pregunta3_error)?$pregunta3_error:'' ?></div>
        </div>
    </div>
    <div style="width: 100%;position:relative;">
        <button type="submit" class="btn btn-verde btn-grande derecha ">
            Guardar
        </button>
    </div>
</form>
