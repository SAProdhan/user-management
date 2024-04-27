<?php require_once __DIR__.'/../header.php'; ?>
    <div class="container">
        <h2>Edit User</h2>
        <form action="/users/update" method="post">
            <input type="hidden" name="csrf_token" value="<?php echo $csrfToken; ?>">
            <input type="hidden" name="id" required value="<?php echo $user['id'] ?>">
            <input type="text" name="username" placeholder="Username" title="Username" class="form-input" required value="<?php echo $user['username'] ?>">
            <input type="email" name="email" placeholder="Email" title="Email" class="form-input" required value="<?php echo $user['email'] ?>">
            <input type="password" name="password" placeholder="Password" title="Password" class="form-input">
            <select name="roleid" title="Select Role" class="form-input" required>
                <option value="">Select Role</option>
                <option value="1" <?php echo $user['roleid'] == 1 ? "selected" : "" ?> >Admin</option>
                <option value="2" <?php echo $user['roleid'] == 2 ? "selected" : "" ?> >User</option>
            </select>
            <button type="submit" class="form-button">Update</button>
        </form>
    </div>
</body>
</html>
