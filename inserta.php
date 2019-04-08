<?php
	define('CHARSET','ISO-8859-1');
	define('REPLACE_FLAGS', ENT_COMPAT | ENT_XHTML);
	$fecha = $_POST['fecha'];
	//$image1 = $_FILES['imagen1'];
	//$image2 = $_FILES['imagen2'];
	
	require_once("DBManager.php");


//INSERTAMOS IMAGENES
if (!isset($_FILES["imagen1"]) || !isset($_FILES["imagen2"]) || $_FILES["imagen1"]["error"] > 0 || $_FILES["imagen2"]["error"])
{
    echo "Ha ocurrido un error.";
}
else
{
    $permitidos = array("image/jpg", "image/jpeg", "image/gif", "image/png");
    $limite_kb = 16384;


    if ((in_array($_FILES['imagen1']['type'], $permitidos) || in_array($_FILES['imagen2']['type'], $permitidos)) && ($_FILES['imagen1']['size'] <= $limite_kb * 1024) || $_FILES['imagen1']['size'] <= $limite_kb * 1024))
    {
        // Archivo temporal
        $imagen_temporal1 = $_FILES['imagen1']['tmp_name'];
        $imagen_temporal2 = $_FILES['imagen2']['tmp_name'];

        $tipo1 = $_FILES['imagen1']['type'];
        $tipo2 = $_FILES['imagen2']['type'];

        $fp = fopen($imagen_temporal1, 'r+b');
        $img1 = fread($fp, filesize($imagen_temporal1));
        fclose($fp);
        
        $image1 = mysql_escape_string($img1);


        $fp = fopen($imagen_temporal2, 'r+b');
        $img2 = fread($fp, filesize($imagen_temporal2));
        fclose($fp);

        $image2 = mysql_escape_string($img2);

        // Insertamos en la base de datos.


		$query = "INSERT INTO insert_datos(fecha, image1, image2) VALUES (:fecha, :image1, :image2, :tipoimagen1, :tipoimagen2)";
		$result = insertsql($query, array(':fecha'=> $fecha,':image1'=> $image1, ':image2'=>$image2, ':tipoimagen'=>$tipo1, ':tipoimagen2'=>$tipo2));
		if (!$result)
		{
			echo "0";return;
		}
		else	{echo "1"; return;}
	}
    else
    {
        echo {echo "2"; return;} 
    }
}
?>
