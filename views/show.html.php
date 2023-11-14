<?php require 'partials/header.html.php';
function price($preTaxPrice, $percentage = 0)
{
    $taxPrice = $preTaxPrice * (1 + 20 / 100) * (1 - $percentage / 100); // 45.6
    $taxPrice = number_format($taxPrice, 2, ',', ' '); // 1450.6 devient 1 450,60

    return $taxPrice;

} 
function isbn($numbers)
{
    $result = substr($numbers, 0, 1); // 8

    if (strlen($numbers) === 13) {
        $result = $result . '-' . substr($numbers, 1, 6); // 8-248827
        $result = $result . '-' . substr($numbers, 7, 6); // 8-248827-583739
    } else {
        $result .= '-' . substr($numbers, 1, 4); // 8-2488
        $result .= '-' . substr($numbers, 5, 4); // 8-2488-2758
        $result .= '-' . substr($numbers, -1); // 8-2488-2758-3
    }

    return $result;
}

?>

<div class="max-w-5xl mx-auto px-3">
    <div class="lg:flex items-center">
        <div class="lg:w-1/2">
            <img class="rounded-lg max-w-full mx-auto mb-12" src="/<?= $book['image']; ?>" alt="<?= $book['title']; ?>">
        </div>
        <div class="lg:w-1/2">
            <h1 class="text-center text-2xl font-bold"><?= $book['title']; ?></h1>

            <div class="flex items-center justify-between my-10">
                <div>
                    <p class="text-4xl font-bold"><?= price($book['price'], $book['discount']); ?> €</p>
                    <?php if ($book['discount'] > 0) { ?>
                        <p class="text-lg font-bold">-<?= $book['discount']; ?>% <span class="line-through"><?= price($book['price']); ?> €</span></p>
                    <?php } ?>
                </div>
                <div class="text-lg text-gray-900">
                    <p>
                        Par <strong><?= $book['author']; ?></strong>
                    </p>
                    <p>
                        <?php // strtotime('1991-11-18'); 
                        ?>
                        Publié le <?= date('d/m/Y', strtotime($book['published_at'])); ?>
                    </p>
                </div>
            </div>

            <p class="text-xl text-center text-gray-900">
                ISBN: <strong><?= isbn($book['isbn']); ?></strong>
            </p>

            <div class="text-center mt-12">
                <a class="bg-gray-900 px-4 py-2 text-white inline-block rounded hover:bg-gray-700 duration-200" href="/cart/1/add">
                    Ajouter au panier
                </a>
            </div>
        </div>
    </div>
</div>

<?php require 'partials/footer.html.php'; ?>