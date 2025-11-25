<?php
opcache_reset();
apcu_clear_cache();
echo "Cache limpiada correctamente.";
?>