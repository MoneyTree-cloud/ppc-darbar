<?php
include 'config.php';

$statusLabels = [
  'interested', 'not_interested', 'hot', 'very_hot',
  'meeting_booked', 'site_visited', 'dumped', 'call_not_picked', 'broker', 'closed'
];

$counts = [];
foreach ($statusLabels as $status) {
  $stmt = $conn->prepare("SELECT COUNT(*) FROM all_leads WHERE status = ?");
  $stmt->bind_param("s", $status);
  $stmt->execute();
  $stmt->bind_result($count);
  $stmt->fetch();
  $stmt->close();
  $counts[] = $count;
}

echo json_encode([
  'labels' => array_map(fn($s) => ucwords(str_replace("_", " ", $s)), $statusLabels),
  'counts' => $counts
]);
?>
