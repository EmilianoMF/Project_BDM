<?php
session_start();
header('Content-Type: application/json');

// Verificar sesión
if (!isset($_SESSION['id_usuario'])) {
    echo json_encode(['error' => 'No autorizado']);
    exit;
}

require_once "Conexion.php";

$tipo_usuario   = $_SESSION['tipo_usuario'] ?? '';
$id_usuario     = $_SESSION['id_usuario'];
$correo_usuario = $_SESSION['correo'] ?? '';

// ── Parámetros de búsqueda (limpios) ──────────────────────────────────────
$id_siniestro = trim($_GET['id_siniestro'] ?? '');
$placas       = trim($_GET['placas']       ?? '');
$poliza       = trim($_GET['poliza']       ?? '');

// Si no se proporcionó ningún parámetro, devolver vacío
if ($id_siniestro === '' && $placas === '' && $poliza === '') {
    echo json_encode(['resultados' => [], 'mensaje' => 'Ingresa al menos un parámetro de búsqueda.']);
    exit;
}

// ── Construir la consulta base según el tipo de usuario ────────────────────
// La vista ya tiene los joins necesarios; se asume que expone al menos:
//   id_siniestro, fecha_siniestro, nombre_cliente, estado,
//   placas (o num_placas), num_poliza, id_ajustador, correo_cliente

$where   = [];
$params  = [];
$types   = '';

// Restricción por tipo de usuario
if ($tipo_usuario === 'Ajustador') {
    $where[]  = 'id_ajustador = ?';
    $params[] = $id_usuario;
    $types   .= 'i';
} elseif ($tipo_usuario !== 'Supervisor') {
    // Cliente / asegurado
    $where[]  = 'correo_cliente = ?';
    $params[] = $correo_usuario;
    $types   .= 's';
}

// Filtros opcionales (búsqueda parcial con LIKE)
if ($id_siniestro !== '') {
    $where[]  = 'id_siniestro LIKE ?';
    $params[] = '%' . $id_siniestro . '%';
    $types   .= 's';
}
if ($placas !== '') {
    $where[]  = 'placas LIKE ?';       // ajusta el nombre de columna si difiere
    $params[] = '%' . $placas . '%';
    $types   .= 's';
}
if ($poliza !== '') {
    $where[]  = 'numero_poliza LIKE ?';   // ajusta el nombre de columna si difiere
    $params[] = '%' . $poliza . '%';
    $types   .= 's';
}

$sql = "SELECT * FROM vista_siniestros";
if (!empty($where)) {
    $sql .= ' WHERE ' . implode(' AND ', $where);
}

$bd   = new Conexion();
$stmt = $bd->conexion->prepare($sql);

if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}

$stmt->execute();
$result = $stmt->get_result();

$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

$bd->cerrar();

echo json_encode([
    'resultados' => $data,
    'mensaje'    => count($data) === 0 ? 'No se encontraron siniestros con esos criterios.' : ''
]);