<div class="container" style="max-width:420px; padding:40px 20px;">
    <h2 style="text-align:center; margin-bottom:20px;">Admin Login</h2>

    <?php if (!empty($errors)): ?>
        <div style="background:#fff3f2; border:1px solid #f8d7da; color:#842029; padding:12px; border-radius:6px; margin-bottom:16px;">
            <ul style="margin-left:18px;">
                <?php foreach ($errors as $err): ?>
                    <li><?php echo htmlspecialchars($err); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form action="<?php echo BASEURL; ?>auth/login" method="POST" style="background:white; padding:20px; border-radius:8px; box-shadow:0 6px 20px rgba(0,0,0,0.08);">
        <div style="margin-bottom:12px;">
            <label for="email" style="font-weight:600; display:block; margin-bottom:6px;">Email</label>
            <input type="email" id="email" name="email" value="<?php echo isset($old['email']) ? $old['email'] : ''; ?>" required style="width:100%; padding:10px; border:1px solid #e5e7eb; border-radius:6px;">
        </div>
        <div style="margin-bottom:18px;">
            <label for="password" style="font-weight:600; display:block; margin-bottom:6px;">Password</label>
            <input type="password" id="password" name="password" required style="width:100%; padding:10px; border:1px solid #e5e7eb; border-radius:6px;">
        </div>
        <button type="submit" class="btn btn-primary" style="width:100%;">Masuk</button>
    </form>
</div>