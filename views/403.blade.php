<?php require 'partials/head.blade.php'; ?>
<?php require 'partials/nav.blade.php'; ?>

<main>
    <div class="mx-auto max-w-7xl py-6 sm:px-6 lg:px-8">
        <h1 class="text-2xl font-bold">You are not authorize to access this page</h1>

        <p class="mt-4">
            <a href="/posts" class="text-blue-500 underline">Go back ..</a>
        </p>
    </div>
</main>

<?php
require base_path('views/partials/footer.blade.php');
?>