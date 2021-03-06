<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>PHP</title>
	<link rel="stylesheet" type="text/css" href="css/main.css">
</head>
<body>
	<a class="menu menu1"  href="../">Ir a Ejercicios</a>
    <a class="menu menu2"  href="19-bd_crear_cursos.php">Crear Curso</a>
    <a class="menu menu3 font12"  href="27-bd-estudiantes_inner_join.php">Listado de Registros</a>

	<div class="container c50">
	<h1 class="tcenter"><u>Listado de Estudiantes por Curso (General)</u></h1>
	<p><b>Problema:</b>Confeccionar un programa que muestre por pantalla los nombres de todos los cursos y el total de estudiantes por cursos.</p>
<?php
    require_once"partials/helper.php";
    require_once"partials/conexion.php";

	$con = conexion();
?>

	<table class="c80 center" border=1>
	<thead>
		<tr>
			<th class='tcenter c20'>Codigo</th>
			<th class='pl5'>Curso</th>
			<th class='c20'>Estudiantes</th>
            <th>Opciones</th>
		</tr>
	</thead>
	<tbody>
		<?php
            //Array para guardar totales
            $total_students = array();

            $students = $con->query("
            SELECT cou.description AS curso, COUNT(std.id) AS estudiantes
            FROM students AS std
            LEFT JOIN courses AS cou ON cou.id=std.id_course
            GROUP BY cou.id");
            while($student = $students->fetch_array()){
                $total_students[$student['curso']] = $student['estudiantes'];
            }    

			$courses = $con->query("SELECT * FROM courses");
            $total_cou = $courses->num_rows;
            if($total_cou > 0){
                while($course = $courses->fetch_array()){
                    echo" 
                    <tr>   
                    <td class='tcenter c20'>$course[id]</td>
                    <td class='pl5'>$course[description]</td>
                    <td class='tcenter'> ";
                        if(!empty($total_students[$course['description']]))
                            echo $total_students[$course['description']];
                        else
                            echo "0";
                    echo"</td>";
                    echo"<td class='tcenter'>";
                    if(!empty($total_students[$course['description']]))
                    {
                        echo"<a href='30-bd-estudiantes_count_detail.php?id_course=$course[id]'><button>Ver Detalle</button></a>";
                    }else{
                        echo " - ";
                    }
                    echo"</td>";

                echo"</tr>";
            
                }
            }else{
                echo"<th colspan='4' class='tcenter'> No se encontraron registros </th>";
            }
		?>
	</tbody>
	<tfooter>
		<tr>
			<th class='tright pr10' colspan='4'>Total Cursos: <?php echo $total_cou; ?></th>
		</tr>
	</tfooter>
</table>

	</div><!--container-->
</body>
</html>