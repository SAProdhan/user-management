<?php require_once __DIR__ . '/../header.php'; ?>
    <div class="container">
        <h1 class="title">User Profile</h1>
        <form action="/profile" method="POST" class="form-group">
            <input type="hidden" name="csrf_token" value="<?php echo $csrfToken; ?>">
            <label for="username" class="label">Username:</label>
            <input type="text" id="username" name="username" value="<?php echo $user['username'] ?>" class="input-field" required>
            <label for="email" class="label">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo $user['email'] ?>" class="input-field" required>
            <label for="password" class="label">Password:</label>
            <input type="password" id="password" name="password" placeholder="Enter new password" class="input-field">
            <input type="submit" value="Update Profile" class="button">
            <input type="button" class="button delete-button" value="Delete Account" class="button" onclick="confirmDelete()">
        </form>
        <form action="/profile" method="POST" class="form-group" id="deleteForm">
            <input type="hidden" name="_method" value="DELETE">
        </form>
    </div>

    <script>
        function confirmDelete() {
            if (confirm('Are you sure you want to delete this user?')) {
                document.getElementById('deleteForm').submit();
            }
        }
    </script>
</body>

</html>