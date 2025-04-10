<script>
// Alert message if record updated
<?php if (isset($_SESSION['update']) && isset($_SESSION['message'])) : ?>
window.onload = function() {
    alert("<?php echo $_SESSION['message'] ?>");
}
<?php
        unset($_SESSION['update']);
        unset($_SESSION['message']);
    endif;
    ?>

// Alert message if record added
<?php if (isset($_SESSION['add']) && isset($_SESSION['message'])) : ?>
window.onload = function() {
    alert("<?php echo $_SESSION['message'] ?>");
}
<?php
        unset($_SESSION['add']);
        unset($_SESSION['message']);
    endif;
    ?>

// Alert message if record deleted
<?php if (isset($_SESSION['delete']) && isset($_SESSION['message'])) : ?>
window.onload = function() {
    alert("<?php echo $_SESSION['message'] ?>")
};
<?php
        unset($_SESSION['delete']);
        unset($_SESSION['message']);
    endif;
    ?>

// Alert message if club registered
<?php if (isset($_SESSION['register']) && isset($_SESSION['message'])) : ?>
window.onload = function() {
    alert("<?php echo $_SESSION['message'] ?>")
};
<?php
        unset($_SESSION['register']);
        unset($_SESSION['message']);
    endif;
    ?>
</script>