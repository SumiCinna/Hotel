<?php
require_once 'config.php';

header('Content-Type: application/json');

try {
    $stmt = $pdo->prepare("CALL sp_get_all_active_rooms()");
    $stmt->execute();
    
    $rooms = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo json_encode([
        'success' => true,
        'rooms' => $rooms,
        'count' => count($rooms),
        'debug' => 'Filters applied: r.is_archived=0, rt.is_archived=0, status!=maintenance'
    ]);
    
} catch(PDOException $e) {
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
}
?>