<?php
require_once 'config.php';

header('Content-Type: application/json');

try {
    $sql = "SELECT 
                r.room_id,
                r.room_number,
                r.room_type_id,
                r.floor,
                r.status,
                r.is_archived as room_archived,
                rt.type_name,
                rt.description,
                rt.base_price,
                rt.max_occupancy,
                rt.image_path,
                rt.is_archived as type_archived
            FROM rooms r
            INNER JOIN room_types rt ON r.room_type_id = rt.room_type_id
            WHERE r.is_archived = 0 
            AND rt.is_archived = 0 
            AND r.status != 'maintenance'";
    
    $stmt = $pdo->prepare($sql);
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