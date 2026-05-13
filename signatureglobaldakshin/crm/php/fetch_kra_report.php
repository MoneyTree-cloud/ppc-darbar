<?php
include 'config.php';

$date = $_GET['date'] ?? date('Y-m-d');

// Ensure employees is treated as an array
// $employeeFilter = $_GET['employees'] ?? '';
// if (!is_array($employeeFilter)) {
//     $employeeFilter = explode(',', $employeeFilter);
// }


$sql = "SELECT * FROM kra_report WHERE DATE(date_time) = ?";
$params = [$date];
$types = 's';

$employeeFilter = $_GET['employees'] ?? '';
if (!empty($employeeFilter)) {
    // Convert comma-separated string to array
    $employeeNames = explode(',', $employeeFilter);
    $placeholders = implode(',', array_fill(0, count($employeeNames), '?'));
    $sql .= " AND name IN ($placeholders)";
    $params = array_merge($params, $employeeNames);
    $types .= str_repeat('s', count($employeeNames));
}


$sql .= " ORDER BY date_time DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param($types, ...$params);
$stmt->execute();
$result = $stmt->get_result();

$rows = '';
$index = 1;

$totalTarget = 0;
$totalCallyzer = 0;
$totalAchieved = 0;
$totalProspects = 0;
$totalMeetings = 0;

while ($row = $result->fetch_assoc()) {
    $total_calls = $row['callyzer_2pm'] + $row['callyzer_5pm'] + $row['callyzer_8pm'];

    $color = $total_calls > $row['calling_target'] ? "#0dcb75" :
            ($total_calls == $row['calling_target'] ? "black" : "#f43636");
    $prospect_color = $row['prospects'] < 5 ? "#f43636" : "#0dcb75";
    if($row['no_of_meetings'] >= 1){
        $meeting_color = "#0dcb75";
    }
    else{
        $meeting_color = "#111";
    }

    $rows .= '<tr>';
    $rows .= '<td><input type="checkbox" class="rowCheckbox" data-name="' . htmlspecialchars($row['name']) . '" checked /></td>';
    $rows .= '<td>' . $index++ . '</td>';
    $rows .= '<td style="text-align: left;">' . htmlspecialchars($row['name']) . '</td>';
    $rows .= '<td style="color:' . $color . ';">' . $row['calling_target'] . '/' . $total_calls . '</td>';
    $rows .= '<td>' . $row['callyzer_2pm'] . '</td>';
    $rows .= '<td>' . $row['callyzer_5pm'] . '</td>';
    $rows .= '<td>' . $row['callyzer_8pm'] . '</td>';
    $rows .= '<td>' . $row['target_achieved'] . '%</td>';
    $rows .= '<td style="color:' . $prospect_color . ';">' . $row['prospects'] . '</td>';
    $rows .= '<td style="color:' . $meeting_color . ';">' . $row['no_of_meetings'] . '</td>';
    // $rows .= '<td>' . $row['not_sale'] . '</td>';
    $rows .= '</tr>';

    $totalCallyzer += $total_calls;
    $totalTarget += $row['calling_target'];
    $totalAchieved += $row['target_achieved'];
    $totalProspects += $row['prospects'];
    $totalMeetings += $row['no_of_meetings'];
}

// Summary row injected via script
$rows .= "<script>
    document.getElementById('summaryFooter').innerHTML = `
        <tr style='text-align: center; font-weight: bold;'>
            <td colspan='3'>Total</td>
            <td id='totalTarget'>$totalTarget</td>
            <td colspan='3'>$totalCallyzer</td>
            <td>" . round(($totalTarget ? ($totalCallyzer / $totalTarget) * 100 : 0), 2) . "%</td>
            <td>$totalProspects</td>
            <td id='totalMeetings'>$totalMeetings</td>
            
        </tr>
    `;
</script>";

echo $rows;
$stmt->close();
$conn->close();
