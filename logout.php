<?php
session_start();
session_unset();
session_destroy();

// 🔥 HAPUS CACHE HISTORY
echo "<script>
window.location.href='login.php';
window.history.pushState(null, null, 'login.php');
</script>";
exit;
?>