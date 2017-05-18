<?php
//require_once('conecta.php');
require_once('conexao.php');
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        $start = 0;
        while ($start < 10) {
            // Iniciamos o "contador"
            list($usec, $sec) = explode(' ', microtime());
            $script_start = (float) $sec + (float) $usec;

            $para = 0;
            while ($para < 10) {

                $nome = 'Ronaldo Sabino';
                $numero = 123456789012;
                /* $sql = "INSERT INTO tabelateste(nome,numero) VALUES('$nome','$numero')";
                  mysqli_query($config, $sql);
                  $para++; */

                $sql_cadastro = "INSERT INTO tabelateste(nome,numero) VALUES(:nome,:numero)";
                try {
                    $insere = $conexao->prepare($sql_cadastro);
                    $insere->bindValue(':nome', $nome, PDO::PARAM_STR);
                    $insere->bindValue('numero', $numero, PDO::PARAM_STR);

                    if ($insere->execute()) {
                        $para++;
                    } else {
                        echo 'não cadastrado';
                    }
                } catch (Exception $ex) {
                    
                }
                list($usec, $sec) = explode(' ', microtime());
                $script_end = (float) $sec + (float) $usec;
                $elapsed_time_insert = round($script_end - $script_start, 5);
                $mb_insert = round(((memory_get_peak_usage(true) / 1024) / 1024), 2);


                /*

                 */
            }
            $sql_insert = "INSERT INTO insercao(time_insert,mb_insert) VALUES(:elapsed_time_insert,:mb_insert)";
            try {
                $insere = $conexao->prepare($sql_insert);
                $insere->bindValue(':elapsed_time_insert', $elapsed_time_insert, PDO::PARAM_STR);
                $insere->bindValue(':mb_insert', $mb_insert, PDO::PARAM_STR);

                if ($insere->execute()) {
                    
                } else {
                    echo 'nÃ£o cadastrado';
                }
            } catch (Exception $ex) {
                
            }

            echo 'INSERT => Tempo Gasto: ', $elapsed_time_insert, ' secs. Memória Utilizada: ', round(((memory_get_peak_usage(true) / 1024) / 1024), 2), 'Mb <br/><br/>';

            $start++;
        }


        // Terminamos o "contador" e exibimos


        list($usec, $sec) = explode(' ', microtime());
        $script_start = (float) $sec + (float) $usec;
        $sql = ('SELECT * FROM tabelateste');
        try {
            $logar = $conexao->prepare($sql);
            $logar->execute();
            $resultado = $logar->fetchAll(PDO::FETCH_ASSOC);
            $contagem = $logar->rowCount(PDO::FETCH_ASSOC);
        } catch (PDOException $error_conecta) {
            echo 'Erro ao selecionar dados ' . $error_conecta->getMessage();
        }
        if ($contagem == 0) {

            echo'Não há dados';
        } else {
            list($usec, $sec) = explode(' ', microtime());
            $script_end = (float) $sec + (float) $usec;
            $elapsed_time = round($script_end - $script_start, 5);
            $mb = round(((memory_get_peak_usage(true) / 1024) / 1024), 2);

            echo ' SELECT => Tempo Gasto: ', $elapsed_time, ' secs. Memória Utilizada: ', round(((memory_get_peak_usage(true) / 1024) / 1024), 2), 'Mb <br />';
        }

        $sql = ('SELECT * FROM insercao');
        try {
            $logar = $conexao->prepare($sql);
            $logar->execute();
            $resultado = $logar->fetchAll(PDO::FETCH_ASSOC);
            $contagem = $logar->rowCount(PDO::FETCH_ASSOC);
        } catch (PDOException $error_conecta) {
            echo 'Erro ao selecionar dados ' . $error_conecta->getMessage();
        }
        if ($contagem == 0) {

            echo'Não há dados';
        } else {
            $a = "";
            $m = "";
            foreach ($resultado as $dado) {
                $id = $dado['id_insert'];
                $time = $dado['time_insert'];
                $mb_banco = $dado['mb_insert'];


                $a += $time;
                $m += $mb_banco;
            }
        }
        ?> 
        <div>
        <?php
        $media = $a / $contagem;
        $mediaM = $m / $contagem;
        echo $media;
        echo '<br/>';
        echo $contagem;
        echo '<br/>';
        echo $a;
        echo '<br/>';
        echo $m . '<br/>' . $mediaM;
        ?>
        </div>
        <div>
            <?php
            $porc = $contagem / 100;
            echo $porc;
            ?>
        </div>
    </body>
</html>
