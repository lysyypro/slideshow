<?php
try {
    $conn = new mysqli("localhost", "root", "", "slideshow");
    
    if ($conn->connect_error) {
        throw new Exception("Błąd połączenia: " . $conn->connect_error);
    }
    
    $id = (int) $_GET['id'];
    $result = $conn->query("SELECT dane, typ FROM zdjecia WHERE id = $id");
    
    if (!$result) {
        throw new Exception("Błąd zapytania: " . $conn->error);
    }
    
    $row = $result->fetch_assoc();
    
    if (!$row) {
        throw new Exception("Nie znaleziono zdjęcia o id: " . $id);
    }
    
    header("Content-Type: " . $row['typ']);
    echo $row['dane'];
    
} catch (Exception $e) {
    http_response_code(500);
    echo "Błąd: " . $e->getMessage();
}
?>