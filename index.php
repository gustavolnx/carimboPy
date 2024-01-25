<!DOCTYPE html>
<html>

<head>
    <title>Carimbar PDF</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

</head>

<body>

    <div class="scene-1">

        <form action="" method="post" enctype="multipart/form-data" class="formCarimbo">
            <div class="img-carimbo"></div>
            <div id="addCarimbo">
                <label for="fileToUpload">Adicionar Carimbo</label>
                <br>
                <input type="file" name="fileToUpload" class="addCarimbo">
            </div>


            <div id="addPDF">
                <label for="fileToUpload">Adicionar PDF</label>
                <br>
                <input type="file" name="fileToUpload2" class="addPDF">
            </div>
            <button type="submit" name="carimbar" class="btn btn-outline-primary" id="btnCarimbar">Carimbar PDFs</button>

        </form>


    </div>



    <?php
    if (isset($_POST['carimbar'])) {
        // Verificar se os arquivos foram enviados
        if ($_FILES['fileToUpload']['error'] == UPLOAD_ERR_OK && $_FILES['fileToUpload2']['error'] == UPLOAD_ERR_OK) {
            // Caminhos para salvar os arquivos
            $carimbo_dir = __DIR__ . '/carimbos/';
            $pdf_dir = __DIR__ . '/pdfs/';

            // Nome dos arquivos
            $carimbo_file = $carimbo_dir . 'carimbo.png';
            $pdf_file = $pdf_dir . basename($_FILES['fileToUpload2']['name']);

            // Substituir o arquivo de carimbo se já existir
            if (file_exists($carimbo_file)) {
                unlink($carimbo_file);
            }

            // Substituir o arquivo PDF se já existir
            if (file_exists($pdf_file)) {
                unlink($pdf_file);
            }

            // Mover os arquivos para os diretórios correspondentes
            if (
                move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $carimbo_file) &&
                move_uploaded_file($_FILES['fileToUpload2']['tmp_name'], $pdf_file)
            ) {
                // Executar o código Python e passar os caminhos dos arquivos como argumentos
                $command = escapeshellcmd('python main.py ' . escapeshellarg($carimbo_file) . ' ' . escapeshellarg($pdf_file));
                $output = shell_exec($command);

                // Exibir o resultado da execução
                echo "Sucesso";
            } else {
                echo "Erro ao mover os arquivos.";
            }
        } else {
            echo "Erro no upload dos arquivos.";
        }
    }
    ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

</html>