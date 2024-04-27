<?php require_once __DIR__.'/../header.php'; ?>
    <div class="container">
        <h2>Create User</h2>
        <form action="/users/store" method="post">
            <input type="hidden" name="csrf_token" value="<?php echo $csrfToken; ?>">
            <input type="text" name="username" placeholder="Username" title="Username" class="form-input" required>
            <input type="email" name="email" placeholder="Email" title="Email" class="form-input" required>
            <input type="password" name="password" placeholder="Password" title="Password" class="form-input" required>
            <select name="role" title="Select Role" class="form-input">
                <option value="">Select Role</option>
                <option value="1">Admin</option>
                <option value="2">User</option>
            </select>
            <button type="submit" class="form-button">Create</button>
        </form>
    </div>
</body>
</html>
