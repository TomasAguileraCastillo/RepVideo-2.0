<?php

// 2. INCLUIR EL ENCABEZADO (Usamos require_once para dependencia crítica)
require_once 'header.php';

// ==========================================================
?>


<main></main>


<?php  // 4. INCLUIR EL PIE DE PÁGINA
require_once 'footer.php';
// Liberación del buffer al final del archivo
ob_end_flush();
?>