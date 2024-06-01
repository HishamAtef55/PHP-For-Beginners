<?php
require base_path('views/partials/head.blade.php');
require base_path('views/partials/nav.blade.php');
require base_path('views/partials/banner.blade.php');
?>

<main>
    <a href="/post/create" class="text-red-500 hover:underline">
        Create Post
    </a>
    <div class="mx-auto max-w-7xl py-6 sm:px-6 lg:px-8">
        <?php foreach ($posts as $key => $post): ?>
            <li>

                <a href="/post?id=<?= $post['id'] ?>" class="text-blue-500 hover:underline">
                    <?= $post['title'] ?>
                </a>

            </li>
            <a href="/post/edit?id=<?= $post['id'] ?>" class="text-blue-500 hover:underline">
                edit
            </a>
            <form action="" method="post">
                <input type="hidden" name="id" value="<?= $post['id'] ?>">
                <button class="text-sm text-red-500">Delete</button>
            </form>
        <?php endforeach; ?>


    </div>

</main>

<?php
require base_path('views/partials/footer.blade.php');
?>
