<?php require('encabezado.php'); ?>

<?php 
        // connectarse a la base de datos
        require('conneccion.php'); // hace disponible el objecto $mysqli  ya conectado a la base de datos    

        $query_respondidas = "select cur.nombre as curso,  c.nombre as modulo, c.numero,  "
        ." case when p.respuesta = er.respuesta then 'correcto' else 'incorrecto' end as correcto,"
        ." count(*) as conteo"
        ." from estudiante_respuestas er "
        ." left join preguntas p"
        ." on p.id = er.preguntas_id"
        ." left join capitulos c"
        ." on p.capitulos_id = c.id"
        ." left join cursos cur"
        ." on c.cursos_id = cur.id"
        ." where er.usuarios_id = ". $_SESSION['user_id']
        ." group by capitulos_id, correcto"
        ;

        $resultado = $mysqli->query($query_respondidas);

        if($resultado){
            $agrupados = [];
            while($pregunta = $resultado->fetch_array(MYSQLI_ASSOC)){
                if(!isset($agrupados[$pregunta['modulo']])){
                    $agrupados[$pregunta['modulo']] = [
                    'curso'=>$pregunta['curso'], 
                    'numero'=>$pregunta['numero'],
                    'correctas'=>0,
                    'incorrectas'=>0,
                    ];
                }
                if($pregunta['correcto'] == 'correcto'){
                    $agrupados[$pregunta['modulo']]['correctas'] = $pregunta['conteo'];
                }else{
                  $agrupados[$pregunta['modulo']]['incorrectas'] = $pregunta['conteo']; 
              }
          }
      }else{
        $mensaje ="No has tomado ninguna evaluacion";
    }

        // agrupar por capitulo (1 set de preguntas por capitulo)


    ?>


    <section id="banner">
        <h2>Evaluaciones </h2>
        <div>
            <table class="calificaciones">
                <thead>
                    <th >Curso</th>
                    <th >Modulo</th>
                    <th >Correctas</th>
                    <th >Incorrectas</th>
                    <th >#Preguntas</th>
                    <th >Calificacion</th>
                </thead>
                <tbody>
                    <?php foreach ($agrupados as $modulo => $info) { ?> 
                        <tr>
                            <td ><?php echo $info['curso']; ?> </td>
                            <td ><?php echo $modulo; ?> </td>
                            <td ><?php echo $info['correctas']; ?></td>
                            <td ><?php echo $info['incorrectas']; ?></td>
                            <td ><?php echo $info['correctas'] + $info['incorrectas']; ?></td>
                            <td ><?php echo ($info['correctas'] / ($info['correctas'] + $info['incorrectas']) )*100; ?>%</td>

                        </tr>
                    <?php } ?>
                    
                </tbody>
            </table>
        </div>
    </section>

    <section id="noticias">
        <article id="noticia1"></article>
        <article id="noticia2"></article>
        <article id="noticia3"></article>
        <div class="espacio"></div>

    </section>

    <section id="tienda">
        <article id="producto1"></article>
        <article id="producto2"></article>
        <article id="producto3"></article>
        <article id="producto4"></article>
        <div class="espacio"></div>


    </section>
    <section id="marcas">

    </section>

    <?php require('pie.php'); ?>