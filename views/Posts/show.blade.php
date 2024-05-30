<?php
require base_path('views/partials/head.blade.php');
require base_path('views/partials/nav.blade.php');
require base_path('views/partials/banner.blade.php');
?>

<main>
    <div class="mx-auto max-w-7xl py-6 sm:px-6 lg:px-8">
        <li>

            <?= $post['title'] ?>

        </li>
        <li>
            <a href="/posts" class="text-blue-500 underline">All Posts</a>
        </li>
    </div>

</main>

<?php
require base_path('views/partials/footer.blade.php');
?>