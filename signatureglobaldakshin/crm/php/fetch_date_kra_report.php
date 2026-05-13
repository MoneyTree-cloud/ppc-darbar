<?php
include 'config.php';

$from = $_GET['from'] ?? '';
$to = $_GET['to'] ?? '';
$employeeFilter = $_GET['employees'] ?? '';
$employeeArray = !empty($employeeFilter) ? explode(',', $employeeFilter) : [];

// Base query
$sql = "
    SELECT 
        name,
        SUM(calling_target) AS calling_target,
        SUM(callyzer_2pm + callyzer_5pm + callyzer_8pm) AS total_callyzer,
        AVG(target_achieved) AS avg_target,
        SUM(prospects) AS total_prospects,
        SUM(prospect_target) AS targeted_prospect,
        SUM(no_of_meetings) AS total_meetings
    FROM kra_report
    WHERE DATE(date_time) BETWEEN ? AND ?
";

// Add employee filter if provided
if (!empty($employeeArray)) {
    $placeholders = implode(',', array_fill(0, count($employeeArray), '?'));
    $sql .= " AND name IN ($placeholders)";
}

$sql .= " GROUP BY name ORDER BY name ASC";

$stmt = $conn->prepare($sql);

// Bind parameters dynamically
$types = 'ss';
$params = [$from, $to];

if (!empty($employeeArray)) {
    $types .= str_repeat('s', count($employeeArray));
    $params = array_merge($params, $employeeArray);
}

$stmt->bind_param($types, ...$params);
$stmt->execute();
$result = $stmt->get_result();

$rows = '';
$index = 1;

// Summary totals
$totalTarget = 0;
$totalCallyzer = 0;
$totalProspects = 0;
$totalMeetings = 0;

while ($row = $result->fetch_assoc()) {
    $color = ($row['total_callyzer'] > $row['calling_target']) ? "#0dcb75" : (($row['total_callyzer'] == $row['calling_target']) ? "black" : "#f43636");

    $rows .= '<tr>';
    $rows .= '<td><input type="checkbox" class="rowCheckbox" data-name="' . htmlspecialchars($row['name']) . '" checked /></td>';
    $rows .= '<td>' . $index++ . '</td>';
    $rows .= '<td style="text-align: left;">' . htmlspecialchars($row['name']) . '</td>';
    $rows .= '<td style="color:' . $color . ';">' . $row['calling_target'] . '</td>';
    $rows .= '<td>' . $row['total_callyzer'] . '</td>';
    $rows .= '<td>' . ($row['calling_target'] > 0 ? round(($row['total_callyzer'] / $row['calling_target']) * 100, 2) : 0) . '%</td>';
    $rows .= '<td>' . $row['targeted_prospect'] . '/' . $row['total_prospects'] . '</td>';
    $rows .= '<td>' . $row['total_meetings'] . '</td>';
    $rows .= '</tr>';

    // Accumulate totals
    $totalTarget += $row['calling_target'];
    $totalCallyzer += $row['total_callyzer'];
    $totalProspects += $row['total_prospects'];
    $totalMeetings += $row['total_meetings'];
}

// Append footer row using JS to inject into #summaryFooter
$rows .= "<script>
    document.getElementById('summaryFooter').innerHTML = `
        <tr style='font-weight: bold; text-align: center;'>
            <td></td>
            <td colspan='2'>Total</td>
            <td id='totalTarget'>$totalTarget</td>
            <td>$totalCallyzer</td>
            <td>" . ($totalTarget > 0 ? round(($totalCallyzer / $totalTarget) * 100, 2) : 0) . "%</td>
            <td>$totalProspects</td>
            <td id='totalMeetings'>$totalMeetings</td>
        </tr>
    `;
</script>";

echo $rows;
$stmt->close();
$conn->close();
