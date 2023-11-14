<?php require 'partials/header.html.php';

$title = 'Ajouter un livre';

//récupérer les données 1ère étape à réaliser, de tous les champs du formulaire
$btitle = $_POST['title'] ?? null;
$price = $_POST['price'] ?? null;
$discount = $_POST['discount'] ?? null;
$isbn = $_POST['isbn'] ?? null;
$author = $_POST['author'] ?? null;
$publishedAt = $_POST['published_at'] ?? null;
$errors = [];

//vérifier les champs

if (!empty($_POST)) {
    if (empty($btitle)) {
        $errors['title'] = 'Le titre est invalide.';
    }
}

// Vérifier les autres champs
if ($price < 1 || $price > 100) {
    $errors['price'] = 'Le prix est invalide.';
}

// attention aux conditions les "()" sont importantes, car elles font comprendre au code comment traiter lesdites conditions
if (!empty($discount) && ($discount < 1 || $discount > 100)) {
    $errors['discount'] = 'La promotion est invalide.';
}

// prendre le temps de repréciser à chaque fois la condition ()
if (strlen($isbn) != 10 && strlen($isbn) != 13) {
    $errors['isbn'] = 'L\'isbn est invalide.';
}

if (empty($author)) {
    $errors['author'] = 'L\'auteur est invalide.';
}

$checked = explode('-', $publishedAt); // permet de créer les 3 paramètres de la date 
if (!checkdate($checked[1] ?? 0, $checked[2] ?? 0, (int) $checked[0])) {
    $errors['published_at'] = 'La date est invalide.';
}


if (empty($errors)) {
    insert('INSERT INTO m2i (title,price,discount,isbn,author,published_at,image)
    VALUES (?,?,?,?,?,?,?)', [
        htmlspecialchars($btitle),
        $price,
        $discount,
        $isbn,
        htmlspecialchars($author),
        $publishedAt,
        'uploads/05.jpg',
    ]);
    addMessage('Votre livre a bien été ajouté !');

    // redirige vers la bonne page après la requête
    redirect('livres.php');
}

?>

<div class="max-w-5xl mx-auto px-3">

    <?php if (!empty($errors)) { ?>


        <div class="bg-red-300 p-5 rounded border border-red-800 text-red-800 my-4">
            <?php foreach ($errors as $error) { ?>
                <p><?= $error; ?></p>
            <?php } ?>
        </div>
    <?php } ?>
    <form action="" method="post" class="w-1/2 mx-auto" enctype="multipart/form-data">
        <div class="mb-4">
            <label for="title" class="block">Titre *</label>
            <input type="text" name="title" id="title" class="border-0 border-b focus:ring-0 w-full" value="<?= $btitle; ?>">
        </div>
        <div class="mb-4">
            <label for="price" class="block">Prix *</label>
            <input type="text" name="price" id="price" class="border-0 border-b focus:ring-0 w-full" value="<?= $price; ?>">
        </div>
        <div class="mb-4">
            <label for="discount" class="block">Promotion</label>
            <input type="text" name="discount" id="discount" class="border-0 border-b focus:ring-0 w-full" value="<?= $discount; ?>">
        </div>
        <div class="mb-4">
            <label for="isbn" class="block">ISBN *</label>
            <input type="text" name="isbn" id="isbn" class="border-0 border-b focus:ring-0 w-full" value="<?= $isbn; ?>">
        </div>
        <div class="mb-4">
            <label for="author" class="block">Auteur *</label>
            <input type="text" name="author" id="author" class="border-0 border-b focus:ring-0 w-full" value="<?= $author; ?>">
        </div>
        <div class="mb-4">
            <label for="published_at" class="block">Publié le *</label>
            <input type="date" name="published_at" id="published_at" class="border-0 border-b focus:ring-0 w-full" value="<?= $publishedAt; ?>">
        </div>
        <div class="mb-4">
            <label for="image" class="block mb-2">Image *</label>
            <input type="file" name="image" id="image" class="cursor-pointer w-full
                    file:rounded-full file:border-0 file:cursor-pointer
                    file:bg-blue-50 hover:file:bg-blue-100
                    file:font-semibold file:py-2 file:px-4 file:mr-4
                ">
        </div>

        <div class="text-center">
            <button class="bg-gray-900 px-4 py-2 text-white inline-block rounded hover:bg-gray-700 duration-200">Créer</button>
        </div>
    </form>
</div>

<?php
require 'partials/footer.php'
?>