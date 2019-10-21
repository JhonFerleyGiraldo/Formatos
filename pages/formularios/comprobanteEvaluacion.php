<?php
     session_start();
     if(!isset($_SESSION["usuario"])){
        header("location:../login/index.php");
    }

    if(!isset($_GET["id"]) && !isset($_GET["documento"]) && !isset($_GET["periodo"]) && !isset($_GET["esDirectivo"])){
        echo "Error en la consulta de datos, los parametros no pueden ser vacios";
        die;
    }

    //recibimos los valores de la url
    $idEvaluacion=$_GET["id"];
    $documentoEmpleado=$_GET["documento"];
    $periodo=$_GET["periodo"];
    $esDirectivo=$_GET["esDirectivo"];

    $resultadoEvaluacion=0; //guardara el valor del resultado de la evaluacion

    require_once("../funciones/funciones.php");

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Comprobante Evaluación</title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="../../vendors/iconfonts/mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="../../vendors/css/vendor.bundle.base.css">
  <link rel="stylesheet" href="../../vendors/css/vendor.bundle.addons.css">
  <!-- endinject -->
  <!-- plugin css for this page -->
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <!-- endinject -->
  <link rel="icon" type="image/x-icon" href="../../images/iconos/IconPage.ico">
 
</head>
<style>
    .tabla{
        width:900px;
        margin:auto;
        border-collapse: collapse;
    }
</style>
<body>
    <?php
    //Preguntamos si la persona es directivo
        if($esDirectivo): 
    ?>


    <?php 
        //traemos los datos de encabezado de la evaluacion segun el id
        $datosEncabezado=GetEncabezadoEvaluacion($idEvaluacion);
        //recorremos el array asociativo para imprimir valores
		while ($valores = mysqli_fetch_array($datosEncabezado)):
	?>
    <!-- inicio tabla encabezados-->
    <table border="1"  class="tabla" >
            <tr>
                <td rowspan="3" height="50px" width="50px"><img src="../../images/uci.png"  width="220px"/></td>
                <td rowspan="3" colspan="2"><p style="text-align:center;">EVALUACIÓN DEL DESEMPEÑO CARGOS <br> NO DIRECTIVOS</p></td>
                <td>Código: F300-016</td>
            </tr>
            <tr>
                <td>Versión: 2</td>
            </tr>
            <tr>
                <td>Página: 1-2 </td>
            </tr>
            <tr>
                <td colspan="4">Nombre completo del trabajador: <?php echo $valores["empleado"]; ?></td>
            </tr>
            <tr>
                <td colspan="4">Nombre completo del evaluador y/o jefe inmediato: <?php echo $valores["jefe"]; ?></td>
            </tr>
            <tr>
                <td colspan="2">Fecha de evaluación: <?php echo $valores["fechaEva"]; ?></td>
                <td colspan="2">Periodo evaluado: <?php echo $valores["periodo"]; ?></td>
            </tr>
            <tr>
                <td colspan="4">Fecha última evaluación: 
                <?php 
                    
                    if($valores["fechaUltima"==NULL]){
                        echo "N/A";
                    }else{
                        echo $valores["fechaUltima"];
                    } 
                ?>
                </td>
            </tr>
        </table>
        <!-- fin tabla encabezado-->
        <?php endwhile; ?>
		
		
		<br>
        <!-- inicio tabla resultados-->
        <table border="1"  class="tabla" >
			<tr>
				<td rowspan="2">N</td>
				<td rowspan="2">Grupo competencia</td>
				<td rowspan="2">Competencia</td>
				<td rowspan="2">Descriptor</td>
				<td>Autoevaluación</td>
				<td>Jefe inmediato</td>
			</tr>
			<tr>
				<td>Valor</td>
				<td>Valor</td>
			</tr>
			<!-- Directivas-->
			<tr>
				<td rowspan="16">1</td>
				<td rowspan="16">Directivas 30%</td>
				<td rowspan="4">Liderazgo y empoderamiento 18%</td>
				<td>Motiva permanentemente a sus colaboradores. Emprende acciones para mejorar el talento y las capacidades de su equipo de trabajo</td>
				<td><?php echo GetValorCalificadoDescriptor($idEvaluacion,46,1); ?></td>
				<td><?php echo GetValorCalificadoDescriptor($idEvaluacion,46,2); ?></td>
			</tr>
			<tr>
				<td> Mantiene los grupos de trabajo con un desarrollo conforme a los estandares establecidos y comparte las consecuencias y resultados con todos los involucrados.</td>
				<td><?php echo GetValorCalificadoDescriptor($idEvaluacion,47,1); ?></td>
				<td><?php echo GetValorCalificadoDescriptor($idEvaluacion,47,2); ?></td>
			</tr>
			<tr>
				<td>Promueve la eficacia del equipo. Fija claramente objetivos de desempeño y responsabilidades, proporcionando dirección y capacitación.</td>
				<td><?php echo GetValorCalificadoDescriptor($idEvaluacion,48,1); ?></td>
				<td><?php echo GetValorCalificadoDescriptor($idEvaluacion,48,2); ?></td>
			</tr>
			<tr>
				<td>Aprovecha la diversidad (heterogeneidad) del equipo para lograr un valor agregado a la Institución. Combina adecuadamente situación-persona y tiempo.</td>
				<td><?php echo GetValorCalificadoDescriptor($idEvaluacion,49,1); ?></td>
				<td><?php echo GetValorCalificadoDescriptor($idEvaluacion,49,2); ?></td>
			</tr>
			<?php $resultadoEvaluacion=$resultadoEvaluacion+GetPorcentajeCalificadoPorCompetencia($idEvaluacion,10); ?>
			<tr>
				<td rowspan="4">Poder de negociación 4%</td>
				<td>Se pone en el lugar del otro y anticipa sus necesidades e intereses ante una negociación</td>
				<td><?php echo GetValorCalificadoDescriptor($idEvaluacion,50,1); ?></td>
				<td><?php echo GetValorCalificadoDescriptor($idEvaluacion,50,2); ?></td>
			</tr>
			<tr>
				<td>Logra convencer a la contra parte y vende sus ideas en beneficio de los interereses de la organización .</td>
				<td><?php echo GetValorCalificadoDescriptor($idEvaluacion,51,1); ?></td>
				<td><?php echo GetValorCalificadoDescriptor($idEvaluacion,51,2); ?></td>
			</tr>
			<tr>
				<td>Logra acuerdos satisfactorios para ambas partes, basándose en criterios objetivos.</td>
				<td><?php echo GetValorCalificadoDescriptor($idEvaluacion,52,1); ?></td>
				<td><?php echo GetValorCalificadoDescriptor($idEvaluacion,52,2); ?></td>
			</tr>
			<tr>
				<td>Dirige y controla una discusión utilizando técnicas ganar-ganar, planifica opciones para negociar los mejores acuerdos.</td>
				<td><?php echo GetValorCalificadoDescriptor($idEvaluacion,53,1); ?></td>
				<td><?php echo GetValorCalificadoDescriptor($idEvaluacion,53,2); ?></td>
			</tr>
			<?php $resultadoEvaluacion=$resultadoEvaluacion+GetPorcentajeCalificadoPorCompetencia($idEvaluacion,11); ?>
			<tr>
				<td rowspan="5">Planeación y control 4%</td>
				<td>Anticipa situaciones y escenarios futuros con acierto, establece objetivos  claros y  concisos, estructurados y coherentes  con  las  metas organizacionales</td>
				<td><?php echo GetValorCalificadoDescriptor($idEvaluacion,54,1); ?></td>
				<td><?php echo GetValorCalificadoDescriptor($idEvaluacion,54,2); ?></td>
			</tr>
			<tr>
				<td>Busca solución a los problemas, distribuye el tiempo con eficiencia, establece planes alternativos de acción y se centra en el problema y no en la persona.</td>
				<td><?php echo GetValorCalificadoDescriptor($idEvaluacion,55,1); ?></td>
				<td><?php echo GetValorCalificadoDescriptor($idEvaluacion,55,2); ?></td>
			</tr>
			<tr>
				<td>Conoce y maneja la ejecución de los procesos y sus resultados. </td>
				<td><?php echo GetValorCalificadoDescriptor($idEvaluacion,56,1); ?></td>
				<td><?php echo GetValorCalificadoDescriptor($idEvaluacion,56,2); ?></td>
			</tr>
			<tr>
				<td>Define Indicadores Que le permiten realizar seguimiento a la gestion y a los palnes de accion establecidos.</td>
				<td><?php echo GetValorCalificadoDescriptor($idEvaluacion,57,1); ?></td>
				<td><?php echo GetValorCalificadoDescriptor($idEvaluacion,57,2); ?></td>
			</tr>
			<tr>
				<td>Establece medidas correctivas y de mejora a los procesos con desviaciones.</td>
				<td><?php echo GetValorCalificadoDescriptor($idEvaluacion,58,1); ?></td>
				<td><?php echo GetValorCalificadoDescriptor($idEvaluacion,58,2); ?></td>
			</tr>
			<?php $resultadoEvaluacion=$resultadoEvaluacion+GetPorcentajeCalificadoPorCompetencia($idEvaluacion,12); ?>
			<tr>
				<td rowspan="2">Juicio analitico 4%</td>
				<td>Analiza las partes de un problema o situacion paso a paso, interpretando las situaciones , hechos o datos.</td>
				<td><?php echo GetValorCalificadoDescriptor($idEvaluacion,59,1); ?></td>
				<td><?php echo GetValorCalificadoDescriptor($idEvaluacion,59,2); ?></td>
			</tr>
			<tr>
				<td>Realiza comparaciones continuamente, saca concluiones y actua conforme a lo aprendido.</td>
				<td><?php echo GetValorCalificadoDescriptor($idEvaluacion,60,1); ?></td>
				<td><?php echo GetValorCalificadoDescriptor($idEvaluacion,60,2); ?></td>
			</tr>
			<tr>
				<td colspan="3">Total factor</td>
				<td><?php echo GetPorcentajeCalificadoPorCompetencia($idEvaluacion,13)+GetPorcentajeCalificadoPorCompetencia($idEvaluacion,10)+GetPorcentajeCalificadoPorCompetencia($idEvaluacion,11)+GetPorcentajeCalificadoPorCompetencia($idEvaluacion,12); $resultadoEvaluacion=$resultadoEvaluacion+GetPorcentajeCalificadoPorCompetencia($idEvaluacion,13); ?></td>
			</tr>
			<!--Organizacionales-->
			<tr>
				<td rowspan="13">2</td>
				<td rowspan="13">Organizacionales 25%</td>
				<td rowspan="6">Trabajo en equipo 10%</td>
				<td>Reconoce e identifica las habilidades y fortalezas de los miembros del equipo, optimizando resultados y logrando un rendimiento excepcional con compromiso y confianza mutua.</td>
				<td><?php echo GetValorCalificadoDescriptor($idEvaluacion,61,1); ?></td>
				<td><?php echo GetValorCalificadoDescriptor($idEvaluacion,61,2); ?></td>
			</tr>
			<tr>
				<td>Valora y promueve el trabajo en equipo,  aprovecha  ventajas y beneficios del mismo para la consecución de objetivos Organizacionales,  prioriza las tareas que afectan el trabajo de otros.</td>
				<td><?php echo GetValorCalificadoDescriptor($idEvaluacion,62,1); ?></td>
				<td><?php echo GetValorCalificadoDescriptor($idEvaluacion,62,2); ?></td>
			</tr>
			<tr>
				<td>Lidera y participa en las reuniones establecidas por la Organización.</td>
				<td><?php echo GetValorCalificadoDescriptor($idEvaluacion,63,1); ?></td>
				<td><?php echo GetValorCalificadoDescriptor($idEvaluacion,63,2); ?></td>
			</tr>
			<tr>
				<td>Reconoce la interdependencia entre su trabajo y el de otros.</td>
				<td><?php echo GetValorCalificadoDescriptor($idEvaluacion,64,1); ?></td>
				<td><?php echo GetValorCalificadoDescriptor($idEvaluacion,64,2); ?></td>
			</tr>
			<tr>
				<td>Respeta  criterios dispares y distintas opiniones.</td>
				<td><?php echo GetValorCalificadoDescriptor($idEvaluacion,65,1); ?></td>
				<td><?php echo GetValorCalificadoDescriptor($idEvaluacion,65,2); ?></td>
			</tr>
			<tr>
				<td>Establece dialogo directo con los miembros del equipo, comparte conocimientos, información, recursos y medios de trabajo</td>
				<td><?php echo GetValorCalificadoDescriptor($idEvaluacion,66,1); ?></td>
				<td><?php echo GetValorCalificadoDescriptor($idEvaluacion,66,2); ?></td>
			</tr>
			<tr>
				<td colspan="3">Total factor</td>
				<td><?php echo GetPorcentajeCalificadoPorCompetencia($idEvaluacion,14); $resultadoEvaluacion=$resultadoEvaluacion+GetPorcentajeCalificadoPorCompetencia($idEvaluacion,14); ?></td>
			</tr>
			<tr>
				<td rowspan="5">Orientación al usuario 15%</td>
				<td>Atiende y valora las necesidades y peticiones de los usuarios internos y externos.</td>
				<td><?php echo GetValorCalificadoDescriptor($idEvaluacion,67,1); ?></td>
				<td><?php echo GetValorCalificadoDescriptor($idEvaluacion,67,2); ?></td>
			</tr>
			<tr>
				<td>Considera las necesidades de los usuarios al diseñar sus servicios.</td>
				<td><?php echo GetValorCalificadoDescriptor($idEvaluacion,68,1); ?></td>
				<td><?php echo GetValorCalificadoDescriptor($idEvaluacion,68,2); ?></td>
			</tr>
			<tr>
				<td>Establece diferentes canales de comunicación con el usuario para conocer sus necesidades y propuestas y responde a las mismas.</td>
				<td><?php echo GetValorCalificadoDescriptor($idEvaluacion,69,1); ?></td>
				<td><?php echo GetValorCalificadoDescriptor($idEvaluacion,69,2); ?></td>
			</tr>
			<tr>
				<td>Brinda respuesta oportuna a las necesidades de los usuarios deacuerdo al servicio que presta</td>
				<td><?php echo GetValorCalificadoDescriptor($idEvaluacion,70,1); ?></td>
				<td><?php echo GetValorCalificadoDescriptor($idEvaluacion,70,2); ?></td>
			</tr>
			<tr>
				<td>Conoce los deberes y derechos de los usuarios.</td>
				<td><?php echo GetValorCalificadoDescriptor($idEvaluacion,71,1); ?></td>
				<td><?php echo GetValorCalificadoDescriptor($idEvaluacion,71,2); ?></td>
			</tr>
			<tr>
				<td colspan="3">Total factor</td>
				<td><?php echo GetPorcentajeCalificadoPorCompetencia($idEvaluacion,15); $resultadoEvaluacion=$resultadoEvaluacion+GetPorcentajeCalificadoPorCompetencia($idEvaluacion,15); ?></td>
			</tr>
			
        </table>
        <!-- fin tabla de resultados-->
		<br>
		<?php 
        //traemos los datos de encabezado de la evaluacion segun el id
        $datosEncabezado=GetEncabezadoEvaluacion($idEvaluacion);
        //recorremos el array asociativo para imprimir valores
		while ($valores = mysqli_fetch_array($datosEncabezado)):
	?>
    <!-- inicio tabla encabezados-->
    <table border="1"  class="tabla" >
            <tr>
                <td rowspan="3" height="50px" width="50px"><img src="../../images/uci.png"  width="220px"/></td>
                <td rowspan="3" colspan="2"><p style="text-align:center;">EVALUACIÓN DEL DESEMPEÑO CARGOS <br> NO DIRECTIVOS</p></td>
                <td>Código: F300-016</td>
            </tr>
            <tr>
                <td>Versión: 2</td>
            </tr>
            <tr>
                <td>Página: 2-2 </td>
            </tr>
            <tr>
                <td colspan="4">Nombre completo del trabajador: <?php echo $valores["empleado"]; ?></td>
            </tr>
            <tr>
                <td colspan="4">Nombre completo del evaluador y/o jefe inmediato: <?php echo $valores["jefe"]; ?></td>
            </tr>
            <tr>
                <td colspan="2">Fecha de evaluación: <?php echo $valores["fechaEva"]; ?></td>
                <td colspan="2">Periodo evaluado: <?php echo $valores["periodo"]; ?></td>
            </tr>
            <tr>
                <td colspan="4">Fecha última evaluación: 
                <?php 
                    
                    if($valores["fechaUltima"==NULL]){
                        echo "N/A";
                    }else{
                        echo $valores["fechaUltima"];
                    } 
                ?>
                </td>
            </tr>
        </table>
        <!-- fin tabla encabezado-->
        <?php endwhile; ?>

		<br>
		
		<!-- inicio tabla resultados-->
        <table border="1"  class="tabla" >
			<tr>
				<td rowspan="2">N</td>
				<td rowspan="2">Grupo competencia</td>
				<td rowspan="2">Competencia</td>
				<td rowspan="2">Descriptor</td>
				<td>Autoevaluación</td>
				<td>Jefe inmediato</td>
			</tr>
			<tr>
				<td>Valor</td>
				<td>Valor</td>
			</tr>
			<!-- tecnicas o profesionales-->
			<tr>
				<td rowspan="19">3</td>
				<td rowspan="19">Tecnicas o profesionales 20%</td>
				<td rowspan="5">Orientación a los resultados 5%</td>
				<td>Se preocupa por enriquecer su trabajo, es objetivo y atinado en la autoevaluación de su trabajo.</td>
				<td><?php echo GetValorCalificadoDescriptor($idEvaluacion,72,1); ?></td>
				<td><?php echo GetValorCalificadoDescriptor($idEvaluacion,72,2); ?></td>
			</tr>
			<tr>
				<td>Asume la responsabilidad de sus resultados.</td>
				<td><?php echo GetValorCalificadoDescriptor($idEvaluacion,73,1); ?></td>
				<td><?php echo GetValorCalificadoDescriptor($idEvaluacion,73,2); ?></td>
			</tr>
			<tr>
				<td>Asume las tareas con exigencia y rigurosidad, logrando estándares de calidad superiores a los establecidos.</td>
				<td><?php echo GetValorCalificadoDescriptor($idEvaluacion,74,1); ?></td>
				<td><?php echo GetValorCalificadoDescriptor($idEvaluacion,74,2); ?></td>
			</tr>
			<tr>
				<td>Administra los procesos establecidos para que no inter- fiera con la consecución de los resultados esperados.</td>
				<td><?php echo GetValorCalificadoDescriptor($idEvaluacion,75,1); ?></td>
				<td><?php echo GetValorCalificadoDescriptor($idEvaluacion,75,2); ?></td>
			</tr>
			<tr>
				<td>Actua con diligencia y sentido de urgencia ante desciones importantes necesarias para la organización.</td>
				<td><?php echo GetValorCalificadoDescriptor($idEvaluacion,76,1); ?></td>
				<td><?php echo GetValorCalificadoDescriptor($idEvaluacion,76,2); ?></td>
			</tr>
			<tr>
				<td colspan="3">Total factor</td>
				<td><?php echo GetPorcentajeCalificadoPorCompetencia($idEvaluacion,16); $resultadoEvaluacion=$resultadoEvaluacion+GetPorcentajeCalificadoPorCompetencia($idEvaluacion,16); ?></td>
			</tr>
			<tr>
				<td rowspan="6">Dominio profesional o técnico 10%</td>
				<td>Demuestra conocimiento amplio y suficiente respecto a su especialidad  y lo aplica efectivamente en el desempeño de su trabajo</td>
				<td><?php echo GetValorCalificadoDescriptor($idEvaluacion,77,1); ?></td>
				<td><?php echo GetValorCalificadoDescriptor($idEvaluacion,77,2); ?></td>
			</tr>
			<tr>
				<td>Se actualiza permanentemente y aporta valor a la Organización.</td>
				<td><?php echo GetValorCalificadoDescriptor($idEvaluacion,78,1); ?></td>
				<td><?php echo GetValorCalificadoDescriptor($idEvaluacion,78,2); ?></td>
			</tr>
			<tr>
				<td>Se comunica de manera clara, efectiva, lógica y segura.  </td>
				<td><?php echo GetValorCalificadoDescriptor($idEvaluacion,79,1); ?></td>
				<td><?php echo GetValorCalificadoDescriptor($idEvaluacion,79,2); ?></td>
			</tr>
			<tr>
				<td>Aplica reglas básicas y conceptos aprendidos.</td>
				<td><?php echo GetValorCalificadoDescriptor($idEvaluacion,80,1); ?></td>
				<td><?php echo GetValorCalificadoDescriptor($idEvaluacion,80,2); ?></td>
			</tr>
			<tr>
				<td> Asesora en su campo de conocimiento, emitiendo conceptos, juicios o propuestas ajustadas a lineamientos teóricos y técnicos.</td>
				<td><?php echo GetValorCalificadoDescriptor($idEvaluacion,81,1); ?></td>
				<td><?php echo GetValorCalificadoDescriptor($idEvaluacion,81,2); ?></td>
			</tr>
			<tr>
				<td>Identifica y reconoce con facilidad las causas de los problemas y sus posibes soluciones</td>
				<td><?php echo GetValorCalificadoDescriptor($idEvaluacion,82,1); ?></td>
				<td><?php echo GetValorCalificadoDescriptor($idEvaluacion,82,2); ?></td>
			</tr>
			<tr>
				<td colspan="3">Total factor</td>
				<td><?php echo GetPorcentajeCalificadoPorCompetencia($idEvaluacion,17); $resultadoEvaluacion=$resultadoEvaluacion+GetPorcentajeCalificadoPorCompetencia($idEvaluacion,17); ?></td>
			</tr>
			<tr>
				<td rowspan="5">Trabajo seguro 5%</td>
				<td>Ejecuta las actividades en orden lógico para asegurar el logro de los resultados en un tiempo determinado.</td>
				<td><?php echo GetValorCalificadoDescriptor($idEvaluacion,83,1); ?></td>
				<td><?php echo GetValorCalificadoDescriptor($idEvaluacion,83,2); ?></td>
			</tr>
			<tr>
				<td>Realiza los procedimientos de acuerdo con lo establecido y atendiendo las normas de seguridad.</td>
				<td><?php echo GetValorCalificadoDescriptor($idEvaluacion,84,1); ?></td>
				<td><?php echo GetValorCalificadoDescriptor($idEvaluacion,84,2); ?></td>
			</tr>
			<tr>
				<td>Cumple con las normas de higiene y seguridad industrial, bioseguridad, seguridad y salud en el trabajo, manejo de residuos hospitalarios y seguridad del paciente.</td>
				<td><?php echo GetValorCalificadoDescriptor($idEvaluacion,85,1); ?></td>
				<td><?php echo GetValorCalificadoDescriptor($idEvaluacion,85,2); ?></td>
			</tr>
			<tr>
				<td>Identifica situaciones de riesgo potencial y sugiere acciones de prevención y mejoramiento.</td>
				<td><?php echo GetValorCalificadoDescriptor($idEvaluacion,86,1); ?></td>
				<td><?php echo GetValorCalificadoDescriptor($idEvaluacion,86,2); ?></td>
			</tr>
			<tr>
				<td>Realiza seguimiento a la información, detecta datos erróneos o ausentes y busca la información  que le permita mantener métodos de trabajo seguros y efectivos.</td>
				<td><?php echo GetValorCalificadoDescriptor($idEvaluacion,87,1); ?></td>
				<td><?php echo GetValorCalificadoDescriptor($idEvaluacion,87,1); ?></td>
			</tr>
			<tr>
				<td colspan="3">Total factor</td>
				<td><?php echo GetPorcentajeCalificadoPorCompetencia($idEvaluacion,18); $resultadoEvaluacion=$resultadoEvaluacion+GetPorcentajeCalificadoPorCompetencia($idEvaluacion,18); ?></td>
			</tr>
			<!-- personales -->
			<tr>
				<td rowspan="22">4</td>
				<td rowspan="22">Personales 25%</td>
				<td rowspan="4">Asertividad 10%</td>
				<td>Motiva en forma positiva y constructiva, resalta lo potenciable y anima a las demás personas a lograr sus metas.</td>
				<td><?php echo GetValorCalificadoDescriptor($idEvaluacion,88,1); ?></td>
				<td><?php echo GetValorCalificadoDescriptor($idEvaluacion,88,2); ?></td>
			</tr>
			<tr>
				<td>Expresa lo que quiere y necesita decir,  en el momento, lugar, forma y persona adecuada, con el propósito de que se entienda que está sucediendo, su impacto y consecuencias.</td>
				<td><?php echo GetValorCalificadoDescriptor($idEvaluacion,89,1); ?></td>
				<td><?php echo GetValorCalificadoDescriptor($idEvaluacion,89,2); ?></td>
			</tr>
			<tr>
				<td>Es capaz de decir no sin ser agresivo ni asumir posiciones pasivas.</td>
				<td><?php echo GetValorCalificadoDescriptor($idEvaluacion,90,1); ?></td>
				<td><?php echo GetValorCalificadoDescriptor($idEvaluacion,90,2); ?></td>
			</tr>
			<tr>
				<td>Conoce sus derechos y reconoce el hecho que llegan hasta donde empiezan los derechos de los demás.</td>
				<td><?php echo GetValorCalificadoDescriptor($idEvaluacion,91,1); ?></td>
				<td><?php echo GetValorCalificadoDescriptor($idEvaluacion,91,2); ?></td>
			</tr>
			<tr>
				<td colspan="3">Total factor</td>
				<td><?php echo GetPorcentajeCalificadoPorCompetencia($idEvaluacion,22); $resultadoEvaluacion=$resultadoEvaluacion+GetPorcentajeCalificadoPorCompetencia($idEvaluacion,22); ?></td>
			</tr>
			<tr>
				<td rowspan="5">Proyección institucional 5%</td>
				<td>Fortalece la imagen institucional a través de su presentación personal.</td>
				<td><?php echo GetValorCalificadoDescriptor($idEvaluacion,92,1); ?></td>
				<td><?php echo GetValorCalificadoDescriptor($idEvaluacion,92,2); ?></td>
			</tr>
			<tr>
				<td>Tiene un impacto positivo en los usuarios.</td>
				<td><?php echo GetValorCalificadoDescriptor($idEvaluacion,93,1); ?></td>
				<td><?php echo GetValorCalificadoDescriptor($idEvaluacion,93,2); ?></td>
			</tr>
			<tr>
				<td>Establece relaciones satisfactorias con los clientes internos y externos.</td>
				<td><?php echo GetValorCalificadoDescriptor($idEvaluacion,94,1); ?></td>
				<td><?php echo GetValorCalificadoDescriptor($idEvaluacion,94,2); ?></td>
			</tr>
			<tr>
				<td>Es cordial en el trato, educado y abierto a escuchar a otros.</td>
				<td><?php echo GetValorCalificadoDescriptor($idEvaluacion,95,1); ?></td>
				<td><?php echo GetValorCalificadoDescriptor($idEvaluacion,95,2); ?></td>
			</tr>
			<tr>
				<td>Es puntual a la hora de ingreso a la institución.</td>
				<td><?php echo GetValorCalificadoDescriptor($idEvaluacion,96,1); ?></td>
				<td><?php echo GetValorCalificadoDescriptor($idEvaluacion,96,2); ?></td>
			</tr>
			<tr>				
				<td colspan="3">Total factor</td>
				<td><?php echo GetPorcentajeCalificadoPorCompetencia($idEvaluacion,19); $resultadoEvaluacion=$resultadoEvaluacion+GetPorcentajeCalificadoPorCompetencia($idEvaluacion,19); ?></td>
			</tr>
			<tr>
				<td rowspan="3">Confidencialidad 5%</td>
				<td>Evita que personas no autorizadas puedan acceder a la información que está  bajo su responsabilidad , y utiliza técnicas de control de acceso a la información.</td>
				<td><?php echo GetValorCalificadoDescriptor($idEvaluacion,97,1); ?></td>
				<td><?php echo GetValorCalificadoDescriptor($idEvaluacion,97,2); ?></td>
			</tr>
			<tr>
				<td>Asegura la protección de la información, con base en disposiciones legales o criterios estratégicos, de información privada, tal como datos de la nómina de los empleados, documentos internos sobre estrategias, situaciones inusuales en el estado de salud de los usuarios, guías y protocolos  que son requeridos en la toma de decisiones.  </td>
				<td><?php echo GetValorCalificadoDescriptor($idEvaluacion,98,1); ?></td>
				<td><?php echo GetValorCalificadoDescriptor($idEvaluacion,98,2); ?></td>
			</tr>
			<tr>
				<td>Es capaz de diferenciar o identificar que hace público y que no.  </td>
				<td><?php echo GetValorCalificadoDescriptor($idEvaluacion,99,1); ?></td>
				<td><?php echo GetValorCalificadoDescriptor($idEvaluacion,99,2); ?></td>
			</tr>
			<tr>
				<td colspan="3">Total factor</td>
				<td><?php echo GetPorcentajeCalificadoPorCompetencia($idEvaluacion,20); $resultadoEvaluacion=$resultadoEvaluacion+GetPorcentajeCalificadoPorCompetencia($idEvaluacion,20); ?></td>
			</tr>
			<tr>
				<td rowspan="6">Racionalidad en el uso de los recursos</td>
				<td>Utiliza en forma óptima los recursos humanos, físicos, tecnológicos y financieros.</td>
				<td><?php echo GetValorCalificadoDescriptor($idEvaluacion,100,1); ?></td>
				<td><?php echo GetValorCalificadoDescriptor($idEvaluacion,100,2); ?></td>
			</tr>
			<tr>
				<td>Utiliza racionalmente los servicios públicos en la institución.</td>
				<td><?php echo GetValorCalificadoDescriptor($idEvaluacion,101,1); ?></td>
				<td><?php echo GetValorCalificadoDescriptor($idEvaluacion,101,2); ?></td>
			</tr>
			<tr>
				<td>Recicla los insumos y demás elementos, de acuerdo a las políticas institucionales.</td>
				<td><?php echo GetValorCalificadoDescriptor($idEvaluacion,102,1); ?></td>
				<td><?php echo GetValorCalificadoDescriptor($idEvaluacion,102,2); ?></td>
			</tr>
			<tr>
				<td>Realiza las cosas bien desde el principio, evitando reprocesos y costos de no calidad.</td>
				<td><?php echo GetValorCalificadoDescriptor($idEvaluacion,103,1); ?></td>
				<td><?php echo GetValorCalificadoDescriptor($idEvaluacion,103,1); ?></td>
			</tr>
			<tr>
				<td>Solicita los insumos realmente necesarios para cumplir con sus tareas.</td>
				<td><?php echo GetValorCalificadoDescriptor($idEvaluacion,104,1); ?></td>
				<td><?php echo GetValorCalificadoDescriptor($idEvaluacion,104,2); ?></td>
			</tr>
			<tr>
				<td>Cumple con sus compromisos en el tiempo señalado.</td>
				<td><?php echo GetValorCalificadoDescriptor($idEvaluacion,105,1); ?></td>
				<td><?php echo GetValorCalificadoDescriptor($idEvaluacion,105,2); ?></td>
			</tr>
			<tr>
				<td colspan="3">Total factor</td>
				<td><?php echo GetPorcentajeCalificadoPorCompetencia($idEvaluacion,21); $resultadoEvaluacion=$resultadoEvaluacion+GetPorcentajeCalificadoPorCompetencia($idEvaluacion,21); ?></td>
			</tr>
			<tr>
                <td colspan="5">Resultado final : </td>
                <td><?php echo "<b>" . $resultadoEvaluacion . "</b>"; ?></td>
            </tr>
		</table>
		<!-- fin tabla de resultados-->
		<br>

    <?php
        //validamos si no es un directivo
        else: 
    ?>


    <?php 
		//traemos los datos de encabezado de la evaluacion segun el id
        $datosEncabezado=GetEncabezadoEvaluacion($idEvaluacion);
        //recorremos el array asociativo para imprimir valores
		while ($valores = mysqli_fetch_array($datosEncabezado)):
	?>
    <!-- inicio tabla encabezados-->
    <table border="1"  class="tabla" >
            <tr>
                <td rowspan="3" height="50px" width="50px"><img src="../../images/uci.png"  width="220px"/></td>
                <td rowspan="3" colspan="2"><p style="text-align:center;">EVALUACIÓN DEL DESEMPEÑO CARGOS <br> NO DIRECTIVOS</p></td>
                <td>Código: F300-016</td>
            </tr>
            <tr>
                <td>Versión: 2</td>
            </tr>
            <tr>
                <td>Página: 1-2 </td>
            </tr>
            <tr>
                <td colspan="4">Nombre completo del trabajador: <?php echo $valores["empleado"]; ?></td>
            </tr>
            <tr>
                <td colspan="4">Nombre completo del evaluador y/o jefe inmediato: <?php echo $valores["jefe"]; ?></td>
            </tr>
            <tr>
                <td colspan="2">Fecha de evaluación: <?php echo $valores["fechaEva"]; ?></td>
                <td colspan="2">Periodo evaluado: <?php echo $valores["periodo"]; ?></td>
            </tr>
            <tr>
                <td colspan="4">Fecha última evaluación: 
                <?php 
                    
                    if($valores["fechaUltima"==NULL]){
                        echo "N/A";
                    }else{
                        echo $valores["fechaUltima"];
                    } 
                ?>
                </td>
            </tr>
        </table>
        <!-- fin tabla encabezado-->
        <?php endwhile; ?>


        <br>
        <!-- inicio tabla resultados-->
        <table border="1"  class="tabla" >
            <tr>
                <td rowspan="2">N</td>
                <td rowspan="2">Grupo</td>
                <td rowspan="2">Competencia</td>
                <td rowspan="2">Descriptor</td>
                <td colspan="5">Autoevaluación</td>
                <td colspan="5">Jefe Inmediato</td>
            </tr>
            <tr>
                <td colspan="5">Valor</td>
                <td colspan="5">Valor</td>
            </tr>

            <!-- ORGANIZACIONALES -->
            <tr>
                <td rowspan="13">1</td>
                <td rowspan="13">Organizacionales 15%</td>
                <td rowspan="5">Trabajo En Equipo 5%</td>
                <td>Coopera en distintas situaciones y comparte información. Aporta sugerencias, ideas y opiniones.</td>
                <td colspan="5"><?php echo GetValorCalificadoDescriptor($idEvaluacion,1,1); ?></td>
                <td colspan="5"><?php echo GetValorCalificadoDescriptor($idEvaluacion,1,2); ?></td> 
            </tr>
            <tr>
                <td>Planifica las propias acciones teniendo en cuenta la repercusión de las mismas para la consecución de los objetivos grupales.</td>
                <td colspan="5"><?php echo GetValorCalificadoDescriptor($idEvaluacion,2,1); ?></td>
                <td colspan="5"><?php echo GetValorCalificadoDescriptor($idEvaluacion,2,2); ?></td> 
            </tr>
            <tr>
                <td>Establece diálogo directo con los miembros del equipo, lo que permite compartir información e ideas en condiciones de respeto y cordialidad.</td>
                <td colspan="5"><?php echo GetValorCalificadoDescriptor($idEvaluacion,3,1); ?></td>
                <td colspan="5"><?php echo GetValorCalificadoDescriptor($idEvaluacion,3,2); ?></td> 
            </tr>
            <tr>
                <td>Respeta  criterios dispares y distintas opiniones del equipo.</td>
                <td colspan="5"><?php echo GetValorCalificadoDescriptor($idEvaluacion,4,1); ?></td>
                <td colspan="5"><?php echo GetValorCalificadoDescriptor($idEvaluacion,4,2); ?></td> 
            </tr>
            <tr>
                <td>Reconoce la interdependencia entre su trabajo y el de otros.</td>
                <td colspan="5"><?php echo GetValorCalificadoDescriptor($idEvaluacion,5,1); ?></td>
                <td colspan="5"><?php echo GetValorCalificadoDescriptor($idEvaluacion,5,2); ?></td> 
            </tr>
            <tr>
                <td colspan="7">Total Factor</td>
                <td colspan="5"><?php echo GetPorcentajeCalificadoPorCompetencia($idEvaluacion,1); $resultadoEvaluacion=$resultadoEvaluacion+GetPorcentajeCalificadoPorCompetencia($idEvaluacion,1); ?></td>
            </tr>
            <tr>
                <td rowspan="5">Orientación Al Usuario 10%</td>
                <td>Atiende y valora las necesidades y peticiones de los usuarios internos y externos.</td>
                <td colspan="5"><?php echo GetValorCalificadoDescriptor($idEvaluacion,6,1); ?></td>
                <td colspan="5"><?php echo GetValorCalificadoDescriptor($idEvaluacion,6,2); ?></td> 
            </tr>
            <tr>
                <td>Considera las necesidades de los usuarios al diseñar sus servicios.</td>
                <td colspan="5"><?php echo GetValorCalificadoDescriptor($idEvaluacion,7,1); ?></td>
                <td colspan="5"><?php echo GetValorCalificadoDescriptor($idEvaluacion,7,2); ?></td> 
            </tr>
            <tr>
                <td>Da respuesta oportuna a las necesidades de los usuarios de acuerdo al servicio que presta.</td>
                <td colspan="5"><?php echo GetValorCalificadoDescriptor($idEvaluacion,8,1); ?></td>
                <td colspan="5"><?php echo GetValorCalificadoDescriptor($idEvaluacion,8,2); ?></td> 
            </tr>
            <tr>
                <td>Establece diferentes canales de comunicación con el usuario para conocer sus necesidades y propuestas y responde a las mismas.</td>
                <td colspan="5"><?php echo GetValorCalificadoDescriptor($idEvaluacion,9,1); ?></td>
                <td colspan="5"><?php echo GetValorCalificadoDescriptor($idEvaluacion,9,2); ?></td> 
            </tr>
            <tr>
                <td>Conoce los deberes y derechos de los usuarios.</td>
                <td colspan="5"><?php echo GetValorCalificadoDescriptor($idEvaluacion,10,1); ?></td>
                <td colspan="5"><?php echo GetValorCalificadoDescriptor($idEvaluacion,10,2); ?></td> 
            </tr>
            <tr>
                <td colspan="7">Total Factor</td>
                <td colspan="5"><?php echo GetPorcentajeCalificadoPorCompetencia($idEvaluacion,2); $resultadoEvaluacion=$resultadoEvaluacion+GetPorcentajeCalificadoPorCompetencia($idEvaluacion,2); ?></td>
            </tr>


            <!-- TECNICAS O PROFESIONALES  -->
           
            <tr>
            </tr>
            <tr>
                <td rowspan="20">2</td>
                <td rowspan="20">Técnicas o Profesionales 45%</td>
                <td rowspan="5">Orientación a los resultados 10%</td>
                <td>Cumple las funciones que le han sido asignadas con oportunidad, en función de estándares, objetivos y metas establecidas por la Institución.</td>
                <td colspan="5"><?php echo GetValorCalificadoDescriptor($idEvaluacion,11,1); ?></td>
                <td colspan="5"><?php echo GetValorCalificadoDescriptor($idEvaluacion,11,2); ?></td> 
            </tr>
            <tr>
                <td>Asume la responsabilidad por sus resultados.</td>
                <td colspan="5"><?php echo GetValorCalificadoDescriptor($idEvaluacion,12,1); ?></td>
                <td colspan="5"><?php echo GetValorCalificadoDescriptor($idEvaluacion,12,2); ?></td> 
            </tr>
            <tr>
                <td>Actúa con diligencia y sentido de urgencia ante decisiones importantes, necesarias para la organización.</td>
                <td colspan="5"><?php echo GetValorCalificadoDescriptor($idEvaluacion,13,1); ?></td>
                <td colspan="5"><?php echo GetValorCalificadoDescriptor($idEvaluacion,13,2); ?></td> 
            </tr>
            <tr>
                <td>Administra los procesos establecidos para que no interfieran con la consecución de los resultados esperados. </td>
                <td colspan="5"><?php echo GetValorCalificadoDescriptor($idEvaluacion,14,1); ?></td>
                <td colspan="5"><?php echo GetValorCalificadoDescriptor($idEvaluacion,14,2); ?></td> 
            </tr>
            <tr>
                <td>Realiza todas las acciones necesarias para alcanzar los objetivos propuestos, enfrentando los obstáculos que se presenten.</td>
                <td colspan="5"><?php echo GetValorCalificadoDescriptor($idEvaluacion,15,1); ?></td>
                <td colspan="5"><?php echo GetValorCalificadoDescriptor($idEvaluacion,15,2); ?></td> 
            </tr>
            <tr>
                <td colspan="7">Total Factor</td>
                <td colspan="5"><?php echo GetPorcentajeCalificadoPorCompetencia($idEvaluacion,3); $resultadoEvaluacion=$resultadoEvaluacion+GetPorcentajeCalificadoPorCompetencia($idEvaluacion,3); ?></td>
            </tr>
            <tr>
                <td rowspan="5">Dominio profesional o técnico 20%</td>
                <td>Asesora en su campo de conocimiento, emitiendo conceptos, juicios o propuestas ajustados a lineamientos teóricos y técnicos.</td>
                <td colspan="5"><?php echo GetValorCalificadoDescriptor($idEvaluacion,16,1); ?></td>
                <td colspan="5"><?php echo GetValorCalificadoDescriptor($idEvaluacion,16,2); ?></td> 
            </tr>
            <tr>
                <td>Se comunica de manera clara, efectiva, lógica y segura.</td>
                <td colspan="5"><?php echo GetValorCalificadoDescriptor($idEvaluacion,17,1); ?></td>
                <td colspan="5"><?php echo GetValorCalificadoDescriptor($idEvaluacion,17,2); ?></td> 
            </tr>
            <tr>
                <td>Analiza de un modo sistemático y racional los aspectos de trabajo, basándose en la información relevante.</td>
                <td colspan="5"><?php echo GetValorCalificadoDescriptor($idEvaluacion,18,1); ?></td>
                <td colspan="5"><?php echo GetValorCalificadoDescriptor($idEvaluacion,18,2); ?></td> 
            </tr>
            <tr>
                <td>Aplica reglas básicas y conceptos aprendidos.</td>
                <td colspan="5"><?php echo GetValorCalificadoDescriptor($idEvaluacion,19,1); ?></td>
                <td colspan="5"><?php echo GetValorCalificadoDescriptor($idEvaluacion,19,2); ?></td> 
            </tr>
            <tr>
                <td>Identifica y reconoce con facilidad las causas de los problemas y sus posibles soluciones.</td>
                <td colspan="5"><?php echo GetValorCalificadoDescriptor($idEvaluacion,20,1); ?></td>
                <td colspan="5"><?php echo GetValorCalificadoDescriptor($idEvaluacion,20,2); ?></td> 
            </tr>
            <tr>
                <td colspan="7">Total Factor</td>
                <td colspan="5"><?php echo GetPorcentajeCalificadoPorCompetencia($idEvaluacion,4); $resultadoEvaluacion=$resultadoEvaluacion+GetPorcentajeCalificadoPorCompetencia($idEvaluacion,4); ?></td>
            </tr>
            <tr>
                <td rowspan="6">Trabajo seguro 15%</td>
                <td>Establece prioridades, optimiza los recursos disponibles y administra adecuadamente la información.</td>
                <td colspan="5"><?php echo GetValorCalificadoDescriptor($idEvaluacion,21,1); ?></td>
                <td colspan="5"><?php echo GetValorCalificadoDescriptor($idEvaluacion,21,2); ?></td> 
            </tr>
            <tr>
                <td>Ejecuta las actividades en orden lógico para asegurar el logro de los resultados en un tiempo determinado.</td>
                <td colspan="5"><?php echo GetValorCalificadoDescriptor($idEvaluacion,22,1); ?></td>
                <td colspan="5"><?php echo GetValorCalificadoDescriptor($idEvaluacion,22,2); ?></td> 
            </tr>
            <tr>
                <td>Realiza los procedimientos de acuerdo con lo establecido y atendiendo las normas de seguridad.</td>
                <td colspan="5"><?php echo GetValorCalificadoDescriptor($idEvaluacion,23,1); ?></td>
                <td colspan="5"><?php echo GetValorCalificadoDescriptor($idEvaluacion,23,2); ?></td> 
            </tr>
            <tr>
                <td>Cumple con las normas de higiene y seguridad industrial, bioseguridad, seguridad y salud en el trabajo, manejo de residuos hospitalarios y seguridad del paciente.</td>
                <td colspan="5"><?php echo GetValorCalificadoDescriptor($idEvaluacion,24,1); ?></td>
                <td colspan="5"><?php echo GetValorCalificadoDescriptor($idEvaluacion,24,2); ?></td> 
            </tr>
            <tr>
                <td>Identifica situaciones de riesgo potencial y sugiere acciones de prevención y mejoramiento.</td>
                <td colspan="5"><?php echo GetValorCalificadoDescriptor($idEvaluacion,25,1); ?></td>
                <td colspan="5"><?php echo GetValorCalificadoDescriptor($idEvaluacion,25,2); ?></td> 
            </tr>
            <tr>
                <td>Realiza seguimiento a la información, detecta datos erróneos o ausentes y busca la información  que le permita mantener métodos de trabajo seguros y efectivos.</td>
                <td colspan="5"><?php echo GetValorCalificadoDescriptor($idEvaluacion,26,1); ?></td>
                <td colspan="5"><?php echo GetValorCalificadoDescriptor($idEvaluacion,26,2); ?></td> 
            </tr>
            <tr>
                <td colspan="7">Total Factor</td>
                <td colspan="5"><?php echo GetPorcentajeCalificadoPorCompetencia($idEvaluacion,5); $resultadoEvaluacion=$resultadoEvaluacion+GetPorcentajeCalificadoPorCompetencia($idEvaluacion,5); ?></td>
            </tr>
         
            
            
        </table>
        <!-- fin tabla de resultados-->

        <br>
   
        <br>
        <br>
        <?php 
			//traemos los datos de encabezado de la evaluacion segun el id
            $datosEncabezado=GetEncabezadoEvaluacion($idEvaluacion);
            //recorremos el array asociativo para imprimir valores
            while ($valores = mysqli_fetch_array($datosEncabezado)):
		?>
		<!-- inicio tabla encabezados-->
		<table border="1"  class="tabla" >
				<tr>
					<td rowspan="3" height="50px" width="50px"><img src="../../images/uci.png"  width="220px"/></td>
					<td rowspan="3" colspan="2"><p style="text-align:center;">EVALUACIÓN DEL DESEMPEÑO CARGOS <br> NO DIRECTIVOS</p></td>
					<td>Código: F300-016</td>
				</tr>
				<tr>
					<td>Versión: 2</td>
				</tr>
				<tr>
					<td>Página: 1-2 </td>
				</tr>
				<tr>
					<td colspan="4">Nombre completo del trabajador: <?php echo $valores["empleado"]; ?></td>
				</tr>
				<tr>
					<td colspan="4">Nombre completo del evaluador y/o jefe inmediato: <?php echo $valores["jefe"]; ?></td>
				</tr>
				<tr>
					<td colspan="2">Fecha de evaluación: <?php echo $valores["fechaEva"]; ?></td>
					<td colspan="2">Periodo evaluado: <?php echo $valores["periodo"]; ?></td>
				</tr>
				<tr>
                <td colspan="4">Fecha última evaluación: 
                <?php 
                    
                    if($valores["fechaUltima"==NULL]){
                        echo "N/A";
                    }else{
                        echo $valores["fechaUltima"];
                    } 
                ?>
                </td>
            </tr>
			</table>
			<!-- fin tabla encabezado-->
			<?php endwhile; ?>
        <br>
        <!-- inicio tabla resultados-->
        <table border="1"  class="tabla" >
            <tr>
                <td rowspan="2">N</td>
                <td rowspan="2">Grupo</td>
                <td rowspan="2">Competencia</td>
                <td rowspan="2">Descriptor</td>
                <td colspan="5">Autoevaluación</td>
                <td colspan="5">Jefe Inmediato</td>
            </tr>
            <tr>
                <td colspan="5">Valor</td>
                <td colspan="5">Valor</td>
            </tr>

            <!-- ORGANIZACIONALES -->
            <tr>
                <td rowspan="23">3</td>
                <td rowspan="23">Personales 40%</td>
                <td rowspan="5">Asertividad 15%</td>
                <td>Motiva en forma positiva y constructiva, resalta lo potenciable y anima a las demás personas a lograr sus metas.</td>
                <td colspan="5"><?php echo GetValorCalificadoDescriptor($idEvaluacion,27,1); ?></td>
                <td colspan="5"><?php echo GetValorCalificadoDescriptor($idEvaluacion,27,2); ?></td> 
            </tr>
            <tr>
                <td>Pensamiento orientado hacia el autorespeto para influir positivamente en los demás. </td>
                <td colspan="5"><?php echo GetValorCalificadoDescriptor($idEvaluacion,28,1); ?></td>
                <td colspan="5"><?php echo GetValorCalificadoDescriptor($idEvaluacion,28,2); ?></td> 
            </tr>
            <tr>
                <td>Expresa lo que quiere y necesita decir,  en el momento, lugar, forma y persona adecuada, con el propósito de que se entienda que está sucediendo, su impacto y consecuencias.</td>
                <td colspan="5"><?php echo GetValorCalificadoDescriptor($idEvaluacion,29,1); ?></td>
                <td colspan="5"><?php echo GetValorCalificadoDescriptor($idEvaluacion,29,2); ?></td> 
            </tr>
            <tr>
                <td>Es capaz de decir no sin ser agresivo ni asumir posiciones pasivas.</td>
                <td colspan="5"><?php echo GetValorCalificadoDescriptor($idEvaluacion,30,1); ?></td>
                <td colspan="5"><?php echo GetValorCalificadoDescriptor($idEvaluacion,30,2); ?></td> 
            </tr>
            <tr>
                <td>Conoce sus derechos y reconoce el hecho que llegan hasta donde empiezan los derechos de los demás.</td>
                <td colspan="5"><?php echo GetValorCalificadoDescriptor($idEvaluacion,31,1); ?></td>
                <td colspan="5"><?php echo GetValorCalificadoDescriptor($idEvaluacion,31,2); ?></td> 
            </tr>
            <tr>
                <td colspan="7">Total Factor</td>
                <td colspan="5"><?php echo GetPorcentajeCalificadoPorCompetencia($idEvaluacion,6); $resultadoEvaluacion=$resultadoEvaluacion+GetPorcentajeCalificadoPorCompetencia($idEvaluacion,6); ?></td>
            </tr>
            <tr>
                <td rowspan="5">Proyección Institucional 5%</td>
                <td>Fortalece la imagen institucional a través de su presentación personal.</td>
                <td colspan="5"><?php echo GetValorCalificadoDescriptor($idEvaluacion,32,1); ?></td>
                <td colspan="5"><?php echo GetValorCalificadoDescriptor($idEvaluacion,32,2); ?></td> 
            </tr>
            <tr>
                <td>Tiene un impacto positivo en los usuarios.</td>
                <td colspan="5"><?php echo GetValorCalificadoDescriptor($idEvaluacion,33,1); ?></td>
                <td colspan="5"><?php echo GetValorCalificadoDescriptor($idEvaluacion,33,2); ?></td> 
            </tr>
            <tr>
                <td>Establece relaciones satisfactorias con los clientes internos y externos.</td>
                <td colspan="5"><?php echo GetValorCalificadoDescriptor($idEvaluacion,34,1); ?></td>
                <td colspan="5"><?php echo GetValorCalificadoDescriptor($idEvaluacion,34,2); ?></td> 
            </tr>
            <tr>
                <td>Es cordial en el trato, educado y abierto a escuchar a otros.</td>
                <td colspan="5"><?php echo GetValorCalificadoDescriptor($idEvaluacion,35,1); ?></td>
                <td colspan="5"><?php echo GetValorCalificadoDescriptor($idEvaluacion,35,2); ?></td> 
            </tr>
            <tr>
                <td>Es puntual a la hora de ingreso a la institución.</td>
                <td colspan="5"><?php echo GetValorCalificadoDescriptor($idEvaluacion,36,1); ?></td>
                <td colspan="5"><?php echo GetValorCalificadoDescriptor($idEvaluacion,36,2); ?></td> 
            </tr>
            <tr>
                <td colspan="7">Total Factor</td>
                <td colspan="5"><?php echo GetPorcentajeCalificadoPorCompetencia($idEvaluacion,7); $resultadoEvaluacion=$resultadoEvaluacion+GetPorcentajeCalificadoPorCompetencia($idEvaluacion,7); ?></td>
            </tr>
            <tr>
                <td rowspan="3">Confidencialidad 10%</td>
                <td>Evita que personas no autorizadas puedan acceder a la información que está  bajo su responsabilidad , y utiliza técnicas de control de acceso a la información.</td>
                <td colspan="5"><?php echo GetValorCalificadoDescriptor($idEvaluacion,37,1); ?></td>
                <td colspan="5"><?php echo GetValorCalificadoDescriptor($idEvaluacion,37,2); ?></td> 
            </tr>
            <tr>
                <td>Asegura la protección de la información, con base en disposiciones legales o criterios estratégicos, de información privada, tal como datos de la nómina de los empleados, documentos internos sobre estrategias, situaciones inusuales en el estado de salud de los usuarios, guías y protocolos  que son requeridos en la toma de decisiones.  </td>
                <td colspan="5"><?php echo GetValorCalificadoDescriptor($idEvaluacion,38,1); ?></td>
                <td colspan="5"><?php echo GetValorCalificadoDescriptor($idEvaluacion,38,2); ?></td> 
            </tr>
            <tr>
                <td>Es capaz de diferenciar o identificar que hace público y que no.  </td>
                <td colspan="5"><?php echo GetValorCalificadoDescriptor($idEvaluacion,39,1); ?></td>
                <td colspan="5"><?php echo GetValorCalificadoDescriptor($idEvaluacion,39,2); ?></td> 
            </tr>
            
            <tr>
                <td colspan="7">Total Factor</td>
                <td colspan="5"><?php echo GetPorcentajeCalificadoPorCompetencia($idEvaluacion,8); $resultadoEvaluacion=$resultadoEvaluacion+GetPorcentajeCalificadoPorCompetencia($idEvaluacion,8); ?></td>
            </tr>
            <tr>
                <td rowspan="6">Racionalidad en el uso de los recursos 10%</td>
                <td>Utiliza en forma óptima los recursos humanos, físicos, tecnológicos y financieros.</td>
                <td colspan="5"><?php echo GetValorCalificadoDescriptor($idEvaluacion,40,1); ?></td>
                <td colspan="5"><?php echo GetValorCalificadoDescriptor($idEvaluacion,40,2); ?></td> 
            </tr>
            <tr>
                <td>Utiliza racionalmente los servicios públicos en la institución.</td>
                <td colspan="5"><?php echo GetValorCalificadoDescriptor($idEvaluacion,41,1); ?></td>
                <td colspan="5"><?php echo GetValorCalificadoDescriptor($idEvaluacion,41,2); ?></td> 
            </tr>
            <tr>
                <td>Recicla los insumos y demás elementos, de acuerdo a las políticas institucionales.</td>
                <td colspan="5"><?php echo GetValorCalificadoDescriptor($idEvaluacion,42,1); ?></td>
                <td colspan="5"><?php echo GetValorCalificadoDescriptor($idEvaluacion,42,2); ?></td> 
            </tr>
            <tr>
                <td>Realiza las cosas bien desde el principio, evitando reprocesos y costos de no calidad.</td>
                <td colspan="5"><?php echo GetValorCalificadoDescriptor($idEvaluacion,43,1); ?></td>
                <td colspan="5"><?php echo GetValorCalificadoDescriptor($idEvaluacion,43,2); ?></td> 
            </tr>
            <tr>
                <td>Solicita los insumos realmente necesarios para cumplir con sus tareas.</td>
                <td colspan="5"><?php echo GetValorCalificadoDescriptor($idEvaluacion,44,1); ?></td>
                <td colspan="5"><?php echo GetValorCalificadoDescriptor($idEvaluacion,44,2); ?></td> 
            </tr>
            <tr>
                <td>Cumple con sus compromisos en el tiempo señalado.</td>
                <td colspan="5"><?php echo GetValorCalificadoDescriptor($idEvaluacion,45,1); ?></td>
                <td colspan="5"><?php echo GetValorCalificadoDescriptor($idEvaluacion,45,2); ?></td> 
            </tr>
            <tr>
                <td colspan="7">Total Factor</td>
                <td colspan="5"><?php echo GetPorcentajeCalificadoPorCompetencia($idEvaluacion,9); $resultadoEvaluacion=$resultadoEvaluacion+GetPorcentajeCalificadoPorCompetencia($idEvaluacion,9); ?></td>
            </tr>
            <tr>
                <td colspan="9">Resultado final : </td>
                <td colspan="5"><?php echo "<b>" . $resultadoEvaluacion . "</b>"; ?></td>
            </tr>
  
         
            
            
        </table>
        <!-- fin tabla de resultados-->
        
    <?php endif; ?>
	<br>
        <br>
        <!-- firma-->
        <table border="0"  class="tabla">
            <tr>
                <td colspan="2">Firma trabajador &nbsp;&nbsp;   ________________________________</td>
                <td colspan="2">Firma evaluador  &nbsp;&nbsp;   _____________________________</td>
            </tr> 
        </table>
        <!--fin tabla firma-->
        <br>
        <br>
        <!-- tabla de datos de resultado-->
        <table border="1"  class="tabla">
            <tr>
                <td>N</td>
                <td>Puntaje</td>
                <td>Resultado</td>
                <td>Plan de mejora</td>
                <td>Seguimiento</td>
            </tr>
            <tr>
                <td>1</td>
                <td>5</td>
                <td>Excelente</td>
                <td>No</td>
                <td>Anual</td>
            </tr>
            <tr>
                <td>2</td>
                <td>4-4.9</td>
                <td>Bueno</td>
                <td>Si</td>
                <td>Anual</td>
            </tr>
            <tr>
                <td>3</td>
                <td>3-3.9</td>
                <td>Aceptable</td>
                <td>Si</td>
                <td>Semestral</td>
            </tr>
            <tr>
                <td>4</td>
                <td>0-2.9</td>
                <td>Insuficiente</td>
                <td>Si</td>
                <td>Trimestral</td>
            </tr>
        </table>
        <!-- fin tabla datos resultado -->
        
        <br>
        <center><h3>******************************** FIN EVALUACIÓN ************************************</h3></center>
</body>
</html>