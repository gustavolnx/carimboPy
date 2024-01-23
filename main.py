import os
import fitz


def get_next_filename(base_filename):
    index = 1
    while True:
        new_filename = f"{base_filename}_{index}.pdf"
        if not os.path.exists(new_filename):
            return new_filename
        index += 1


# pasta dos pdf para carimbar
input_folder = "./pdfs"

# pasta de onde vão qnd carimbar
output_folder = "./carimbados"

# procura todos arquvios pdf na pasta
input_files = [f for f in os.listdir(input_folder) if f.endswith(".pdf")]

for input_file in input_files:
    input_filepath = os.path.join(input_folder, input_file)

    doc = fitz.open(input_filepath)

    # Iterar sobre as páginas do documento
    for page_index in range(len(doc)):
        page = doc[page_index]

        if not (page.is_wrapped):
            page.wrap_contents()
            page_width = page.rect.width

            x = page_width
            y = 0

            image_rect = fitz.Rect(50, y, x - 460, y + 170)
            page.insert_image(
                image_rect, filename="./assets/carimbo.png", keep_proportion=True
            )

    # Nome do arquivo carimbado
    base_output_filename = os.path.join(
        output_folder, f"{os.path.splitext(input_file)[0]}_carimbado"
    )

    # Obter o próximo nome de arquivo disponível
    output_filename = get_next_filename(base_output_filename)

    # Salvar PDF carimbado
    doc.save(output_filename)

    doc.close()
