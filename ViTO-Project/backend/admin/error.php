<?php if (isset($_SESSION['error'])): ?>
    <div class="red-text"><?php echo $_SESSION['error']; ?></div>
    <?php unset($_SESSION['error']); ?>
<?php endif; ?>