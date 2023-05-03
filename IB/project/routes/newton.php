<!doctype html>
<html lang="en">

<head>
    <title>Bisection Method</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS v5.0.2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <script src="https://unpkg.com/mathjs@10.0.1/lib/browser/math.js"></script>
    <script src="https://cdn.plot.ly/plotly-1.35.2.min.js"></script>

    <link rel="stylesheet" href="../styles/styles.css" media="screen">

</head>

<body>

    <div class="container">
        <div class="row row-eq-height">
            <div class="col-md-3 h-100">
                <br />
                <div class="card" style="height: 38.59rem;">
                    <div class="card-header">
                        Menemukan Akar dengan Newton Raphson
                    </div>
                    <div class="card-body">
                        <form action="newton.php" method="post" id="form">
                            <br /> Persamaan yang dimasukkan harus berupa polinomial maksimum derajat 3, jadi hanya persamaan bentuk yang diterima a*x^3+b*x^2+c*x+d <br /><br />

                            Persamaan: <input required class="form-control" type="text" name="ecuacion" id="eq">
                            <br />
                            X0: <input class="form-control" type="text" name="x0" id="">
                            <br />
                            Toleransi: <input class="form-control" type="text" name="tolerancia" id="">
                            <br />
                            <br />
                            <br />
                            <button class="btn btn-success" type="submit">Hitung</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-4  h-100">
                <br />
                <div class="card" style="height: 38.59rem;">
                    <div class="card-header">
                        Hasil
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Iterasi</th>
                                    <th>Akar</th>
                                    <th>Error</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                </tr>
                            </tbody>
                        </table>
                        <pre>
                        <?php
                        //Llamar a la clase functions
                        require("functions.php");
                        /*Crear una instancia --> Esta parte $obj solo es un 
                            ejemplo revisar functions para entender sintaxis
                            $obj = new functions("x^3+x^2+x+1"); */
                        $n = 1;
                        $p = 0.00;
                        if ($_POST) {
                            $x0 = $_POST['x0'];
                            $x0WM = $x0;
                            $x0 = floatval($x0);
                            $funtion = $_POST['ecuacion'];
                            $tol = $_POST['tolerancia'];
                            if ($x0 != null && $funtion != null && $tol != null) {
                                $tol = floatval($tol);
                                while ($n <= 20) {
                                    $funcion = new functions($funtion);
                                    $f = $funcion->getImage($x0);
                                    $Derivada = $funcion->derive();
                                    $funcionD = new functions($Derivada);
                                    $fprime = $funcionD->getImage($x0);
                                    $p = $x0 - ($f / $fprime);
                                    $f1 = $funcion->getImage($p);
                                    echo "  " . $n . "\t\t" . round($p, 4) . "\t\t" . round(abs($p - $x0), 9) . "<br/>";
                                    if (($f1 == 0) || (abs($p - $x0) < $tol)) {
                                        break;
                                    }
                                    $x0 = $p;
                                    $n += 1;
                                }

                                echo "<br>" . "Akar terletak di x: " . $p . "<br>";
                                echo "x0: " . $x0WM . "<br>";
                                echo "Banyaknya iterasi adalah: " . $n . "<br>";
                            } else {
                                echo "Anda dapat melihat fungsinya" . "<br>" . "Temukan rentang yang tepat";
                            }
                        }


                        ?>
                        </pre>
                    </div>
                </div>
            </div>
            <div class="col-md-5  h-100">
                <br />
                <div class="card" style="height: 38.59rem;">
                    <div class="card-header">
                        Grafik
                    </div>
                    <div class="card-body">
                        <div id="plot"></div>
                    </div>
                </div>
            </div>



        </div>

        <script>
            function draw() {
                try {
                    //Recupear datos guardados en el localStorage
                    const expression = window.localStorage.getItem('expression');
                    const expr = math.compile(expression)

                    // evaluate the expression repeatedly for different values of x
                    const xValues = math.range(-10, 10, 0.5).toArray()
                    const yValues = xValues.map(function(x) {
                        return expr.evaluate({
                            x: x
                        })
                    })

                    // render the plot using plotly
                    const trace1 = {
                        x: xValues,
                        y: yValues,
                        type: 'scatter'
                    }
                    const data = [trace1]
                    Plotly.newPlot('plot', data)
                } catch (err) {
                    console.error(err)
                    alert(err)
                }
            }

            document.getElementById('form').onsubmit = function(event) {
                // Buscar el elemento por su ID
                let expressionM = document.getElementById('eq').value
                // Guardar el elemento en el localStorage 
                window.localStorage.setItem('expression', expressionM)
                draw()
            }
            draw()
        </script>
        <br />
        <br />
        <h1 class="display-3" id="recomen">Anda cukup memasukkan fungsi untuk mencari grafik untuk interval yang sesuai</h3>
            <br />
</body>

</html>