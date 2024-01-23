<!DOCTYPE html>
<html>

<head>
    <title>Carimbar PDF</title>
</head>

<body>
    <h2>Carimbar PDF</h2>

    <form action="" method="post">
        <button type="submit" name="carimbar">Carimbar PDFs</button>
    </form>

    <?php
    if (isset($_POST['carimbar'])) {
        // Executar o código Python
        $command = escapeshellcmd('python main.py');
        $output = shell_exec($command);

        // Exibir o resultado da execução
        echo "<pre>$output</pre>";
    }
    ?>
</body>

</html>