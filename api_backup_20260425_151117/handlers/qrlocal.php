<?php
$text = $_GET['text'] ?? $_POST['text'] ?? '';
if (empty($text)) {
    header('Content-Type: application/json');
    echo json_encode(['code' => 400, 'message' => '缺少text参数']);
    exit;
}
require_once('/opt/phpqrcode/qrlib.php');
$level = $_GET['level'] ?? 'L';
$errorCorrection = QR_ECLEVEL_L;
if ($level == 'M') $errorCorrection = QR_ECLEVEL_M;
if ($level == 'Q') $errorCorrection = QR_ECLEVEL_Q;
if ($level == 'H') $errorCorrection = QR_ECLEVEL_H;
$size = (int)($_GET['size'] ?? 6);
$margin = (int)($_GET['margin'] ?? 2);
$fileName = md5($text . $size . $margin . $level) . '.png';
$pngAbsoluteFilePath = '/tmp/' . $fileName;
QRcode::png($text, $pngAbsoluteFilePath, $errorCorrection, $size, $margin);
header('Content-Type: image/png');
readfile($pngAbsoluteFilePath);
unlink($pngAbsoluteFilePath);
exit;
