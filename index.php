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

    <link href="https://fonts.googleapis.com/css?family=Roboto+Condensed" rel="stylesheet">
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

<?php
# Aplican para IRS los que ganen mas de $11,0000 anuales incluyendo decimo, osea $846 mensuales.
$limite_ISR = 11000;

if (isset($_GET['seducativo']) && !empty($_GET['seducativo']))
$seducativo = $_GET['seducativo'];
else
$seducativo = 1.25;

if (isset($_GET['ssocial']) && !empty($_GET['ssocial']))
$ssocial = $_GET['ssocial'];
else
$ssocial = 9.75;


# incremento - valores por defecto
if (isset($_GET['incremento']) && !empty($_GET['incremento']))
$incremento = $_GET['incremento'];
else
$incremento = 100;

# pago - valores por defecto
if (isset($_GET['pago']) && !empty($_GET['pago'])) {
    $pago = $_GET['pago'];
}
else {
    $pago = 'mensual';
}

# salario 1 - valores por defecto
if (isset($_GET['salario1']) && !empty($_GET['salario1']))
$salario1 = $_GET['salario1'];
else
$salario1 = 600;
# salario 2 - valores por defecto
if (isset($_GET['salario2']) && !empty($_GET['salario2']))
$salario2 = $_GET['salario2'];
else
$salario2 = 2000;

if ($salario2 >= 10000 && $incremento == 1) {
    $salario2 = 10000;
}

# empmleador - valor por defecto
if(isset($_GET['empleador']) && !empty($_GET['empleador']) && $_GET['empleador'] == 'gobierno') {
    $empleador = $_GET['empleador'];
}
else {
    $empleador = 'privada';
}
?>


<body>
    <div class="container">

        <div class="page-header">
            <h1><a href="?">Calculadora de impuestos de Panamá</a></h1>
            <p>Calcula cuantos impuestos debes de pagar incluyendo Impuesto Sobre la Renta (ISR), Seguro Social y Seguro Educativo.</p>
        </div>

        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="http://foros.slot-1.net">#slot-1</a></li>
                <li class="breadcrumb-item">labs</li>
                <li class="breadcrumb-item active" aria-current="page">calculadora de impuestos</li>
            </ol>
        </nav>

        <h3>Introduce dos rangos salariales  <span></span></h3>
        <form action="index.php" method="get">
            <div class="form-group">

                <!-- Container - Rango salarial, Incremento, Quincenal o mensual -->
                <div class="row">
                    <!-- Rango salarial -->
                    <div class="form-group col col-sm-12 col-lg-4">
                        <label for="salario1">Rango de salarios (mensual)</label>
                        <div class="row">
                            <div class="col col-lg-6">
                                <div class="input-group mb-0">
                                  <div class="input-group-prepend">
                                    <span class="input-group-text">$</span>
                                  </div>
                                  <input type="text" name="salario1" id="salario1" class="form-control rango" value="<?php echo $salario1; ?>" onchange="check_cantidad(this);" placeholder="600" />
                                </div>
                            </div>
                            <div class="col col-lg-6">
                                <div class="input-group mb-0">
                                  <div class="input-group-prepend">
                                    <span class="input-group-text">$</span>
                                  </div>
                                  <input type="text" name="salario2" id="salario2" class="form-control rango" value="<?php echo $salario2; ?>" onchange="check_cantidad(this);" placeholder="2000" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Incremento -->
                    <div class="form-group col-sm">
                        <label for="incremento">Incremento</label>
                        <select name="incremento" class="form-control rango" id="incremento">
                            <?php
                            $incremento_salarial = array(1, 5, 10, 25, 50, 100, 1000, 10000);

                            foreach($incremento_salarial as $key => $val) {
                                echo '<option value="'. $val .'"';
                                if ($val == $incremento) {
                                    echo ' selected="selected" style="font-weight: bold;"';
                                }
                                echo '>$'. $val .'</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <!-- Quincenal / mensual -->
                    <div class="form-group col-sm">
                        <label for="pago">Mostrar salario quincenal o mensual</label>
                        <select name="pago" id="pago" class="form-control">
                            <option <?php if($pago=='quincenal') echo 'selected' ?>>quincenal</option>
                            <option <?php if($pago=='mensual') echo 'selected' ?>>mensual</option>
                        </select>
                    </div>
                </div>

                <br /><br />

                <!-- Container - Seguro Social, Seguro Educativo -->
                <div class="row">
                    <div class="col-sm col-sm-12 col-md-6 col-lg-4">
                        <!-- Container - Seguro Social, Seguro Educativo -->
                        <div class="row">
                            <!-- Seguro Social -->
                            <div class="form-group col col-sm-6">
                                <label for="ssocial">Seguro Social</label>
                                <div class="input-group mb-0">
                                  <input type="text" name="ssocial" class="form-control seguro" id="ssocial" value="<?php echo $ssocial; ?>" onchange="check_cantidad(this);" />
                                  <div class="input-group-prepend">
                                    <span class="input-group-text">%</span>
                                  </div>
                                </div>
                            </div>
                            <!-- Seguro Educativo -->
                            <div class="form-group  col col-sm-6">
                                <label for="seducativo">Seguro Educativo</label>
                                <div class="input-group mb-0">
                                  <input type="text" name="seducativo" class="form-control seguro" id="seducativo" value="<?php echo $seducativo; ?>" onchange="check_cantidad(this);" />
                                  <div class="input-group-prepend">
                                    <span class="input-group-text">%</span>
                                  </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--  Empresa privada / gobierno -->
                    <div class="form-group col-sm col-md-6 col-lg-4">
                        <label for="empleador">Empresa privada o gobierno?</label>
                        <select name="empleador" id="empleador" class="form-control">
                            <option <?php if($empleador=='privada') echo 'selected' ?>>privada</option>
                            <option <?php if($empleador=='gobierno') echo 'selected' ?>>gobierno</option>
                        </select>
                    </div>
                </div>

                <br /><br />
                <div>
                    <input class="btn btn-primary btn-block calcular" type="submit" value="CALCULAR" />
                    <input type="hidden" id="resultados" name="resultados" value="si" />
                </div>
            </div>
        </form>
        <?php
        if (isset($_GET['resultados']) && !empty($_GET['resultados']) && $_GET['resultados'] == 'si')
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


            function renta_2010($valor, $empleador)
            {
                $sal_limite_gob = 1500;

                if ($empleador == 'gobierno') { # Salario anual en gobierno, decimo tiene un cap en $1,500
                    if ($valor <= $sal_limite_gob)
                        $valor = $valor*13;
                    else
                        $valor = $valor*12 + $sal_limite_gob;
                }
                else # Salario anual en empresa privada
                    $valor = $valor * 13;

                if($valor > 50000) { # paga $5,850 por los primeros $50k + 25% sobre el excedente del 50k
                    $valor = (($valor - 50000) * 0.25) + 5850;
                    $valor = $valor / 13;
                }
                else  if ($valor > 11000){
                    $valor = ($valor - 11000) * 0.15;
                    $valor = $valor / 13;
                }
                else {
                    $valor = 0;
                }

                return $valor;
            }

            if($salario1 >= $salario2)
            echo '<div class="alert alert-danger" role="alert">Hazte el payaso...o payasa.';
            else
            {
                ?>
                <div id="contenido" class="table-responsive">
                    <table class="table table-hover table-striped fixed-headers impuestos">
                        <thead class="thead-light">
                            <th scope="col sticky"><strong style="color: #009900;">Salario <?php echo '('. $pago .')'?> </strong> </th>
                            <th scope="col">Con descuento</th>
                            <th scope="col">Impuestos totales</th>
                            <th scope="col" title="Impuesto Sobre la Renta">ISR</th>
                            <th scope="col">Seguro Social</th>
                            <th scope="col">Seguro Educativo</th>
                        </thead>
                        <?php


                        echo '<tbody>';

                        for($x=$salario1; $x<=$salario2; $x=$x+$incremento)
                        {

                            $isr = 0;
                            $hit = 0;

                            $seguros = round(($x * 0.01 * $ssocial),2);
                            $seguros_anual = $seguros * 13;
                            $seguroe = round(($x * 0.01 * $seducativo),2);
                            $seguroe_anual = $seguroe * 13;

                            // no cambiar orden - ISR y HIT deben estar antes que salario con descuentos
                            # Salario base
                            $salario_base = $x;
                            $salario_base_anual = $x * 13;
                            # IRS
                            $isr = renta_2010($x, $empleador);
                            $isr_anual = $isr * 13;
                            # Impuestos totales
                            $hit = $seguros + $seguroe + $isr;
                            $hit_anual = $hit * 13;
                            # Salario con descuentos
                            $salario = $x - $hit;
                            $salario_anual = $salario * 13;



                            // calcular porcentaje de impuestos descontados
                            $porcentaje_impuestos = number_format($hit / $salario_base * 100, 2, '.', ',') . '%';

                            if ($pago == 'quincenal') {
                                $salario_base = $salario_base / 2;
                                $salario = $salario / 2;
                                $hit = $hit / 2;
                                $isr = $isr / 2;
                                $seguros = $seguros / 2;
                                $seguroe = $seguroe / 2;
                            }

                            // decimales y comas
                            $salario_base = number_format($salario_base, 2, '.', ',');
                            $salario_base_anual = number_format($salario_base_anual, 2, '.', ',');
                            $salario = number_format($salario, 2, '.', ',');
                            $salario_anual = number_format($salario_anual, 2, '.', ',');
                            $hit = number_format($hit, 2, '.', ',');
                            $hit_anual = number_format($hit_anual, 2, '.', ',');
                            $isr = number_format($isr, 2, '.', ',');
                            $isr_anual = number_format($isr_anual, 2, '.', ',');
                            $seguros = number_format($seguros, 2, '.', ',');
                            $seguros_anual = number_format($seguros_anual, 2, '.', ',');
                            $seguroe = number_format($seguroe, 2, '.', ',');
                            $seguroe_anual = number_format($seguroe_anual, 2, '.', ',');


                            // mostrar -- si la persona gana menos del limite en el ISR
                            if ($isr == 0.00) {
                                $isr = '--';
                            }
                            else {
                                $isr = '-$' . $isr;
                            }


                            echo '<tr scope="row">';
                            echo '<td '; if ($empleador == 'privada') { echo 'title="Salario anual: $'.$salario_base_anual.'"'; } echo '><span class="badge badge-success">$'.$salario_base.'</span> </td>';
                            echo '<td title="Salario anual con descuentos: $'.$salario_anual.'">$'.$salario.' </td>';
                            echo '<td title="Impuestos anuales: $'.$hit_anual.' ('.$porcentaje_impuestos.') "><span class="badge badge-danger">-$'.$hit.'</span></td>';
                            echo '<td title="ISR anual: $'.$isr_anual.'">'.$isr.' </td>';
                            echo '<td title="Seguro Social anual: $'.$seguros_anual.'">-$'.$seguros.'</td>';
                            echo '<td title="Seguro Educativo anual: $'.$seguroe_anual.'">-$'.$seguroe.'</td>';
                            echo '</tr>';
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <footer>
                <h3>Como se calcula?</h3>
                <p class="info">
                    Segun la última reforma tributaria: Salario final = Salario* - Seguro Social (<?php echo $ssocial; ?>%) - Seguro educativo (<?php echo $seducativo; ?>%) - Impuesto sobre la renta**
                    <br /> <br />

                    <ul>
                        <li> * El salario anual equivale a todos lo que cobraste en el año, incluyendo bonos y el Decimo Tercer Mes (XIII).</li>
                        <li> El <i>Decimo</i> de los empleados de Gobierno tienen un <a href="http://www.critica.com.pa/nacional/elevaran-el-tope-del-xiii-mes-305313">tope maximo de $1,500.</a> (2013)</li>
                        <li> ** El impuesto sobre la renta de 15% se aplica a los que ganen entre de $11,000 y $50,000 anuales incluyendo bonos (ej. decimo).</li>
                        <li> Esta aplicación no toma en cuenta dependientes.</li>
                    </ul>
                    <br />
                    <p><a href="#">^ Volver arriba</a></p>
                    <br />
                    <hr />
                    <p>Diseñado por mi, osea <a href="http://twitter.com/ecwpa">@ecwpa</a> | Si tienes sugerencias para mejorar esta aplicación, chotea en twitter.</p>
                    <br /><br />
                </p>
            </footer>

                <?php
            }

        }
        ?>


    </div>
</body>
</html>
