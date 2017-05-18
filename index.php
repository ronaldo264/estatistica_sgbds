<!DOCTYPE html>
<html>

    <head>
        <meta charset="UTF-8">
        <title>Teste SGBD Polstgre</title>
    </head>
    <body>
        <div id="cont">
            <div id="resul">
                <p>*****************************************************************************</p>
            <?php
            $conexao = "host = 'localhost' port = '5432' dbname = 'estatistica' user = 'ronaldo' password = '180997'";
            $con = pg_connect($conexao)or die("Erro de Conexão" . pg_last_error());
            $start = 0;
            while ($start < 20) {
                list($usec, $sec) = explode(' ', microtime());
                $script_start = (float) $sec + (float) $usec;
                $para = 0;
                while ($para < 1000) {
                    $sql = "INSERT INTO tabela(nome,numero) VALUES ('Ronaldo Sabino', '123456789012')";
                    $resultado = pg_query($con, $sql)or die("Erro ao inserir dados " . pg_last_error());
                    
                    list($usec, $sec) = explode(' ', microtime());
                    $script_end = (float) $sec + (float) $usec;
                    $elapsed_time_insert = round($script_end - $script_start, 5);
                    $mb_insert = round(((memory_get_peak_usage(true) / 1024) / 1024), 2);
                    $para++;
                    if (!$resultado) {
                        echo"Não deu Certo";
                    }
                }
                $time = (float)$elapsed_time_insert;
                $mega = (float)$mb_insert;
                //var_dump($time);
                $sql_insert = "INSERT INTO insercao(time_insert,mb_insert) VALUES($time,$mega)";
                $resul      = pg_query($con, $sql_insert)or die("Erro ao inserir dados " . pg_last_error());
                if (!$resul) {
                    echo"Não deu Certo";
                }
                //echo 'INSERT => Tempo Gasto: ', $time, ' secs. Memória Utilizada: ', round(((memory_get_peak_usage(true) / 1024) / 1024), 2), 'Mb <br/><br/>';

                $start++;
            }
            $linhas = $para*20;
            echo "<p> Foi inserido um conjunto de ".$para." linhas por vez totalizando  ".$linhas."  linhas inseridas </p>";
            $sql_select = "SELECT * FROM insercao";
            $resul_select = pg_query($con,$sql_select);
            $num = 0;
            while($dados = pg_fetch_array($resul_select)){
                
                
                $tempo = $dados['time_insert'];
                $mb    = $dados['mb_insert'];
                $num++;

            ?>

                <p> <?php echo $num;?>º - O tempo gasto para inserir <?php echo $para;?> linhas foi : <?php echo $tempo;?> e o custo foi de <?php echo $mb;?>MB</p>
                
                <?php }
                $sql_soma = "SELECT SUM(time_insert)as total FROM insercao";
                $resul_soma = pg_query($con,$sql_soma);
                while($dado = pg_fetch_array($resul_soma)){
                
                $soma = $dado['total'];
               
                }
                $sql_max = "SELECT MAX(time_insert) as max FROM insercao";
                $resul_max = pg_query($con,$sql_max);
                while($dado_max = pg_fetch_array($resul_max)){
                
                $max = $dado_max['max'];
               
                }
                
                $sql_min = "SELECT MIN(time_insert) as min FROM insercao";
                $resul_min = pg_query($con,$sql_min);
                while($dado_min = pg_fetch_array($resul_min)){
                
                $min = $dado_min['min'];
               
                }
                echo $min."<br/>";
                echo $max."<br/>";
                
                $amplitude = $max - $min;
                echo "A Amplitude é de : ".$amplitude."<br/>";
                echo "O total da inserção de ".$linhas." linhas é de: ".$soma;
                $media = $soma/10;
                echo "<br/>A Média da inserção para.".$para." linhas é : ".$media;
                
                echo "<p>*****************************************************************************</p>";
                $sql_delete = "DELETE FROM insercao";
                pg_query($con,$sql_delete);
                $sql_del = "DELETE FROM tabela";
                pg_query($con,$sql_del);
                
                ?>
                
            </div>
        </div>
    </body>
</html>
