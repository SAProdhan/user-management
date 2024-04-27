<?php require_once __DIR__ . '/../header.php' ?>
<div class="container">
    <h2>User List</h2>
    <div class="search-container">
        <form action="/users" method="GET">
            <input type="text" id="search" name="term" value="<?php echo $term ?>" class="search-input" placeholder="Search...">
            <button type="submit" class="search-button" title="<?php echo empty($term) ? "Click to search" :"Empty serch input and clik it to reset or just click to search again." ?>">Search<?php echo empty($term) ? "" :"/Reset" ?></button>
        </form>
        <a class="primary-button" href="users/create">Create User</a>
    </div>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <!-- User rows will be loaded here -->
            <?php foreach ($users as $user) : ?>
                <tr>
                    <td><?php echo $user['id']; ?></td>
                    <td><?php echo $user['username']; ?></td>
                    <td><?php echo $user['email']; ?></td>
                    <td>
                        <button onclick="window.location.href = '/users/edit?id=<?php echo $user['id']; ?>'">Edit</button>
                        <button onclick="confirmDelete(<?php echo $user['id']; ?>)">Delete</button>
                        <form id="deleteForm_<?php echo $user['id']; ?>" method="POST" action="/users/delete">
                            <input type="hidden" name="_method" value="DELETE">
                            <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
            <!-- Additional user rows will be loaded dynamically -->
        </tbody>
    </table>
    <div class="pagination">
        <a href="<?php echo $prevLink; ?>" class="pagination-button" <?php echo $prevPage ? "" : 'disabled="disabled"' ?>>Previous</a>
        <a href="<?php echo $nextLink; ?>" class="pagination-button" <?php echo $nextPage ? "" : 'disabled="disabled"' ?>>Next</a>
    </div>

</div>
<script>
    function confirmDelete(userId) {
        if (confirm('Are you sure you want to delete this user?')) {
            document.getElementById('deleteForm_' + userId).submit();
        }
    }

    function editUser(userId) {
        // Redirect to edit user action with user ID
        window.location.href = '/users/edit?id=' + userId;
    }
</script>
</body>

</html>