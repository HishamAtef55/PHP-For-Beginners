<?php
require base_path('views/partials/head.blade.php');
require base_path('views/partials/nav.blade.php');
require base_path('views/partials/banner.blade.php');
?>
<main>
    <a href="/post/create" class="text-red-500 hover:underline">
        Create Post
    </a>
    <table class="table-fixed" style="padding: 15px">
        <thead>
            <tr>
                <th>ID</th>
                <th>title</th>
                <th>Show</th>
                <th>Edit</th>
                <th>Delete</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($posts as $key => $post): ?>
            <tr>
                <td><?= $post['id'] ?></td>
                <td><?= $post['title'] ?></td>
                <td>
                    <a href="/post?id=<?= $post['id'] ?>" class="text-blue-500 hover:underline">
                        show
                    </a>
                </td>
                <td><a href="/post/edit?id=<?= $post['id'] ?>" class="text-blue-500 hover:underline">
                        edit
                    </a></td>
                <td>
                    <form action="/post/delete" method="post">
                        <input type="hidden" name="_method" value="DELETE">
                        <input type="hidden" name="id" value="<?= $post['id'] ?>">
                        <button class="text-sm text-red-500">Delete</button>
                    </form>

                </td>
            </tr>
        </tbody>

        <?php endforeach; ?>
    </table>

</main>


<?php
require base_path('views/partials/footer.blade.php');
?>
