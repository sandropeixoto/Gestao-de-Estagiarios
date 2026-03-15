<?php
/**
 * Logout Handler
 * Orion Orchestrator: Safely ending session and redirecting
 */
session_start();
session_destroy();

// Em produção, aqui poderíamos redirecionar de volta para o Portal GestorGov
header("Location: index.php");
exit();
