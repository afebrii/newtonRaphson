<?php

    class functions{

        public $function;
        public $valueFx;
        public $derivative;

        public function __construct($funcion){
            $this->function = $funcion;
        }

        private function getValues(){
            //Crear una copia de la funcion
            $funcion = $this->function;
            
            /*Declarar las constantes de la funcion como cero para
            hacer una funcion dinamica entre lineal, cuadrada y cubica*/
            $a=0; $b=0; $c=0; $d=0;

            //Encontrar las constantes ingresadas por el usuario
            //Agregar comas
            $funcion = str_replace("x^3", "x^3,",$funcion);
            $funcion = str_replace("x^2", "x^2,",$funcion);
            $funcion = str_replace("x+", "x,+",$funcion);
            $funcion = str_replace("x-", "x,-",$funcion);
            $funcion = str_replace("*", "", $funcion);

            //Quitar signos
            $funcion = str_replace("+", "",$funcion);

            //Separar las constantes
            $separados = explode(",", $funcion);

            /*Encuentra coincidencias con cubica, cuadrada, lineal y constante 
            para sacar sus constantes respectivas*/
            foreach($separados as $indice=>$valor){
                if(stristr($valor, "x^3")==="x^3"){	
                    $valor=str_replace("x^3", "", $valor);
                    if($valor=="" || $valor=="+" || $valor=="-"){
                        $valor=$valor."1";
                    }
                    $a=$valor;
                }
                if(stristr($valor, "x^2")==="x^2"){
                    $valor=str_replace("x^2", "", $valor);
                    if($valor=="" || $valor=="+" || $valor=="-"){
                        $valor=$valor."1";
                    }
                    $b=floatval($valor);
                }
                if(stristr($valor, "x")==="x"){
                    $valor=str_replace("x", "", $valor);
                    if($valor=="" || $valor=="+" || $valor=="-"){
                        $valor=$valor."1";
                    }
                    $c=floatval($valor);
                }
                if(is_numeric($separados[$indice])){
                    $d=floatval($separados[$indice]);
                }
            }

            //Imprimir valores
            //echo $a." ".$b." ".$c." ".$d."<br>";

            //Arreglo a retornar
            $valores = array($a, $b, $c, $d);
            return $valores;
        }

        public function getImage($x){
            
            //Obtener valores de la funcion
            $valores = $this->getValues();

            //Formato de la funcion a seguir
            $functionR = floatval($valores[0])*pow($x,3) + floatval($valores[1])*pow($x,2) + floatval($valores[2])*pow($x,1) + floatval($valores[3]);

            //Evaluar la funcion
            $this->valueFx = $functionR;
            return $this->valueFx;
        }

        public function derive(){
            //Obtener valores de la funcion
            $valores = $this->getValues();
            $derivada = array();

            //Formato de la funcion a seguir
            $valores[0] = floatval($valores[0])*3;
            $valores[1] = floatval($valores[1])*2;
            $valores[2] = floatval($valores[2])*1;
            $valores[3] = floatval($valores[3])*0;

            //Crear la derivada
            if(floatval($valores[0])!=0){
                $derivada[0] = $valores[0]."x^2";
            }
            if(floatval($valores[1])!=0){
                $derivada[1] = $valores[1]."x";
            }
            if(floatval($valores[2])!=0){
                $derivada[2] = $valores[2];
            }
            if(floatval($valores[0])==0 && floatval($valores[1])==0 && floatval($valores[2])==0){
                $derivada[3] = "0";
            }

            //Unir los elementos
            $derivadaF = implode("+", $derivada); 

            //Reemplazar signos demás como "+-" o "-+"
            $derivadaF = str_replace("+-", "-", $derivadaF);
            $derivadaF = str_replace("-+", "-", $derivadaF);

            $this->derivative = $derivadaF;
            return $this->derivative;
        }

    }

    /* Sintaxis a usar

    //Creamos la instancia para la funcion que ingresa el usuario
    $funcionPrueba = new functions("4*x^3-3*x^2+2*x+1");

    //Obtenemos el valor de la funcion en un punto
    $valor1 = $funcionPrueba->getImage($a);
    
    //Obtenemos la derivada de la funcion y la guardamos; string
    $derivada = $funcionPrueba->derive();

    echo "<br>";

    //Creamos otra instancia functions para la derivada

    //Mandar la derivada anterior como argumento
    $funcionDerivada = new functions($derivada);

    $valor2 = $funcionDerivada->getImage($b);

    */
?>

