<?php if (isset($_SESSION['success'])): ?>
    <div class="green-text"><?php echo $_SESSION['success']; ?></div>
    <?php unset($_SESSION['success']); ?>
<?php endif; ?>