<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Calcular impuestos de Panamá, ISR, Seguro social, Seguro educativo">
    <meta name="author" content="@ecwpa">
	<title>Calculadora de impuesto sobre la renta de Panamá | Slot-1 Labs</title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css" />
	<link rel="stylesheet" type="text/css" href="css/bootstrap-responsive.min" />
	
	
	<link rel="stylesheet" type="text/css" href="css/impuestos.css" />

	
    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
	
<script type="text/javascript">
function check_cantidad(element)
{
var cant = element.value;
var cant_es_flotante = isFloat(cant);
// alert('Valor introducido: '+cant+' \n\n ID: '+element.id+' | Es flotante? '+cant_es_flotante);
// descomentar si quieres revisar los valores del id, value y si es flotante
 
if (isNaN(cant))
{
alert('Valor introducido:       '+cant+' \n\n Introduce solo valores numericos');
document.getElementById(element.id).value = "1";
}
else if (cant < 1 )
{
alert('Valor introducido:       '+cant+' \n\n Introduce numeros enteros mayores que 0.');
document.getElementById(element.id).value = "1";
}
// else if (cant_es_flotante == true)	
// {
// alert('Valor introducido:       '+cant+' \n\n El valor es decimal.  Sera convertido a entero.');
// cant = parseInt(cant);
// document.getElementById(element.id).value = cant;
// }
}
function isFloat(myNum) 
{
// es true si es 1, osea si es flotante
var myMod = myNum % 1;
 
if (myMod == 0) 
{ return false; } 
else { return true; }
}
</script>
</head>

<?
# Aplican para IRS los que ganen mas de 11,0000 anuales incluyendo decimo, osea 846$ mensuales.
$limite_ISR = 11000;

if ($_GET['seducativo'])
	$seducativo = $_GET['seducativo'];
else
	$seducativo = 1.25;
	
if ($_GET['ssocial'])
	$ssocial = $_GET['ssocial'];
else
	$ssocial = 9.75;

	
# incremento - valores por defecto
if ($_GET['incremento'])
	$incremento = $_GET['incremento'];
else
	$incremento = 50;		
	
# salario 1 - valores por defecto
if ($_GET['salario1'])
	$salario1 = $_GET['salario1'];
else
	$salario1 = 700;	
# salario 2 - valores por defecto
if ($_GET['salario2'])
	$salario2 = $_GET['salario2'];
else
	$salario2 = 1200;	
?>


<body>
<div class="container">

<div class="page-header">
  <h1><a href="?">Calculadora de impuestos en Panama</a></h1>
  <p>Hace algunos años programé una calculadora para saber exactamente cuantos impuestos debo rendir al gobierno de Panamá.  Al parecer le fue util a muchas personas asi que he decido actualizarlo un poco, si tienen sugerencias pueden contactarnos en <a href="http://twitter.com/slto">twitter</a> o el <a href="http://foros.slot-1.net/viewtopic.php?f=5&t=4097&p=109185#p102628">foro</a>.</p>
</div>

<ul class="breadcrumb">
  <li><a href="http://foros.slot-1.net">#slot-1</a> <span class="divider">/</span></li>
  <li>labs<span class="divider">/</span></li>
  <li class="active">calculadora de impuestos</li>
</ul>

<?

?>
<h3>Introduce datos</h2>
<p></p>
<form action="index.php" method="get">
<div class="row-fluid">
	<div class="span3">
		<label for="salario1">Rango salarial</label>
		<input type="text" name="salario1" id="salario1" class="rango" value="<? echo $salario1; ?>" onchange="check_cantidad(this);" />
		<input type="text" name="salario2" id="salario2" class="rango" value="<? echo $salario2; ?>" onchange="check_cantidad(this);" />
	</div>
	<div class="span3">
		<label for="incremento">Incremento</label>
		<select name="incremento" class="rango" id="incremento">
		  <option value="1">1</option>
		  <option value="5">5</option>
		  <option value="10">10</option>
		  <option value="25">25</option>
		  <option value="50">50</option>
		  <option value="100">100</option>
		  <option value="1000">1000</option>
		  <option value="10000">10000</option>
		  <option value="<? echo $incremento; ?>" selected="selected"><? echo $incremento; ?></option>
		</select>
	</div>	
</div>

<br /><br />

	<div class="row-fluid">
		<div class="span2">
			<label for="ssocial">Seguro Social (%)</label>
			<input type="text" name="ssocial" class="seguro" id="ssocial" value="<? echo $ssocial; ?>" onchange="check_cantidad(this);" />
		</div>
		<div class="span2">
			<label for="ssocial">Seguro Educativo (%)</label>
			<input type="text" name="seducativo" class="seguro" id="seducativo" value="<? echo $seducativo; ?>" onchange="check_cantidad(this);" />
		</div>
		<div class="span3">
			<label for="empleador">Empresa privada o Gobierno?</label>
			<select name="empleador" id="empleador">
				<option <?php if($_GET['empleador']=='privada') echo 'selected' ?>>privada</option>
				<option <?php if($_GET['empleador']=='gobierno') echo 'selected' ?>>gobierno</option>
			</select>
		</div>
	</div>

<br /><br />
<div>
<input class="btn btn-large btn-primary" type="submit" value="Calcular" />
<input type="hidden" id="resultados" name="resultados" value="si" />
</div>
</form> 
<?
if ($_GET['resultados'] == 'si')
{

$salario = 0;

$salario1 = $_GET['salario1'];
$salario2 = $_GET['salario2'];
$incremento = $_GET['incremento'];

$salariox = array( 
				"numbers" => array(),
				"numbers" => array(),
				"numbers" => array()
				);

				

function renta_2010($valor)
{
	if ($_GET['empleador'] == 'gobierno') { # Salario anual en gobierno
		if ($valor < 600)
			$valor = $valor*13;
		else
			$valor = $valor*12 + 600;
	}	
	else # Salario anual en empresa privada	
		$valor = $valor * 13; 
	
	if($valor > 50000)
		$valor = (($valor - 50000) * 0.25) + 5850;
	else
		$valor = ($valor - 11000) * 0.15;	
	
	$valor = $valor / 13;
	$valor = number_format($valor, 2, '.', ',');	

	return $valor;
}

			
if($salario1 >= $salario2)
	echo "Hazte el payaso...";
else
{
?>
<div id="contenido">
	<table class="table table-hover table-striped impuestos">
		<thead>
			<th><strong style="color: #009900;">Salario</strong> </th>
			<th>Con descuento</th>
			<th>Impuestos totales</th>
			<th>ISR</th>
			<th>Seguro Social</th>
			<th>Seguro Educativo</th>
			</tr>
		  </thead>
<?php



for($x=$salario1; $x<=$salario2; $x=$x+$incremento)
{
	$isr = 0;
	$hit = 0;

	$seguros = round(($x * 0.01 * $ssocial),2);
	$seguroe = round(($x * 0.01 * $seducativo),2);
	
	# Ese limite es 11,000 al año o 13 meses ganando $846 
	
	# IRS para Empresa privada
	if($_GET['empleador'] == 'privada') {
		if($x*13 > $limite_ISR)
			$isr = round(renta_2010($x),2);
	}
	else { # IRS para el Gobierno
		if($x > 600) { # Salario de 600 en adelante
			if(($x*12+600) > $limite_ISR) 
			{	
				$isr = round(renta_2010($x),2);
				echo ($x*12+600). " ";
				}
				
			}
	}
	
	$hit = $seguros + $seguroe + $isr;	
	$salario = $x - $hit;
	
	
	
	echo '<tbody><tr><td><span class="badge badge-success">$'.$x.'</span> </td>';

	echo '<td>$'.$salario.' </td><td><span class="badge badge-important">-$'.$hit.'</span></td>';
		
	echo "<td>$$isr</td>";
	echo "<td>$$seguros</td>";
	echo "<td>$$seguroe</td>";
	
}
?>
		</tbody>
	</table> 
</div>

<footer>

<h3>Como se calcula?</h3>
<p class="info">
Segun la última <a href="http://www.presidencia.gob.pa/noticia-presidente-numero-940.html">reforma tributaria</a>:  Salario final = Salario* - Seguro Social (<?php echo $ssocial; ?>%) - Seguro educativo (<?php echo $seducativo; ?>%) - Impuesto sobre la renta** 
<br /> <br />

<ul>
	<li>* El salario equivale a todos lo que cobraste en el año, incluyendo bonos y el Decimo Tercer Mes (XIII).</li>
	<li>El <i>Decimo</i> de los empleados de Gobierno que ganen $600 o mas <a href="http://www.elsiglo.com/mensual/2012/08/11/contenido/547165.asp">se congela</a> en esa cantidad.</li>
	<li>** El impuesto sobre la renta de 15% se aplica a los que ganen entre de $11,000 y $50,000 anuales incluyendo bonos (ej. decimo).  Esta aplicación no toma en cuenta dependientes.  Ahora si calcula bien el Decimo de sector publico.  Los que ganan mas de $50,000 al año pagan 27% de ISR, gocen su enyucado estimados amigos adinerados.</li>
</ul>

<br />
<p><a href="#">^ Volver arriba</a></p>
<br />
<hr />

<p>Diseñado por mi, osea <a href="http://twitter.com/ecwpa">@ecwpa</a></p>

<br /><br />


</footer>

<?php
}

}
?>


</div>
</body>
</html>