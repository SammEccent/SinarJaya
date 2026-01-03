<?php if (isset($_SESSION['success'])): ?>
    <div class="alert alert-success" style="background: #d1fae5; color: #065f46; padding: 15px 20px; border-radius: 8px; margin-bottom: 20px; border-left: 4px solid #10b981; display: flex; align-items: center; gap: 10px; animation: slideDown 0.3s ease-out;">
        <i class="fas fa-check-circle" style="font-size: 1.2rem;"></i>
        <span><?php echo htmlspecialchars($_SESSION['success']); ?></span>
        <button onclick="this.parentElement.style.display='none'" style="margin-left: auto; background: none; border: none; color: #065f46; cursor: pointer; font-size: 1.2rem; padding: 0; line-height: 1;">&times;</button>
    </div>
    <?php unset($_SESSION['success']); ?>
<?php endif; ?>

<?php if (isset($_SESSION['error'])): ?>
    <div class="alert alert-error" style="background: #fee2e2; color: #991b1b; padding: 15px 20px; border-radius: 8px; margin-bottom: 20px; border-left: 4px solid #ef4444; display: flex; align-items: center; gap: 10px; animation: slideDown 0.3s ease-out;">
        <i class="fas fa-exclamation-circle" style="font-size: 1.2rem;"></i>
        <span><?php echo htmlspecialchars($_SESSION['error']); ?></span>
        <button onclick="this.parentElement.style.display='none'" style="margin-left: auto; background: none; border: none; color: #991b1b; cursor: pointer; font-size: 1.2rem; padding: 0; line-height: 1;">&times;</button>
    </div>
    <?php unset($_SESSION['error']); ?>
<?php endif; ?>

<?php if (isset($_SESSION['warning'])): ?>
    <div class="alert alert-warning" style="background: #fef3c7; color: #92400e; padding: 15px 20px; border-radius: 8px; margin-bottom: 20px; border-left: 4px solid #f59e0b; display: flex; align-items: center; gap: 10px; animation: slideDown 0.3s ease-out;">
        <i class="fas fa-exclamation-triangle" style="font-size: 1.2rem;"></i>
        <span><?php echo htmlspecialchars($_SESSION['warning']); ?></span>
        <button onclick="this.parentElement.style.display='none'" style="margin-left: auto; background: none; border: none; color: #92400e; cursor: pointer; font-size: 1.2rem; padding: 0; line-height: 1;">&times;</button>
    </div>
    <?php unset($_SESSION['warning']); ?>
<?php endif; ?>

<style>
    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .alert {
        font-weight: 500;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .alert button:hover {
        opacity: 0.7;
    }
</style>