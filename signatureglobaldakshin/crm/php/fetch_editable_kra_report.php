<?php
include 'config.php';

$date = $_GET['date'] ?? date('Y-m-d');

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
    $rows .= '<td>
    <div class="action">
        <button class="btn edit-btn"
            data-id="' . $row['id'] . '"
            data-name="' . htmlspecialchars($row['name']) . '"
            data-target="' . $row['calling_target'] . '"
            data-2pm="' . $row['callyzer_2pm'] . '"
            data-5pm="' . $row['callyzer_5pm'] . '"
            data-8pm="' . $row['callyzer_8pm'] . '"
            data-achieved="' . $row['target_achieved'] . '"
            data-prospect="' . $row['prospects'] . '"
            data-meetings="' . $row['no_of_meetings'] . '"
            data-date="' . date('Y-m-d', strtotime($row['date_time'])) . '"
        ><ion-icon name="create"></ion-icon></button>
        <a href="php/delete/delete_kra_report_data.php?id=' . $row['id'] . '" class="btn" onclick="return confirm(\'Are you sure you want to delete this member kra data?\')"><ion-icon name="trash"></ion-icon></a>

    </div>
</td>';

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
            <td colspan='2'>Total</td>
            <td id='totalTarget'>$totalTarget</td>
            <td colspan='3'>$totalCallyzer</td>
            <td>" . round(($totalTarget ? ($totalCallyzer / $totalTarget) * 100 : 0), 2) . "%</td>
            <td>$totalProspects</td>
            <td id='totalMeetings'>$totalMeetings</td>
            <td></td>
        </tr>
    `;
</script>";

echo $rows;

// echo "<script>
// const ctx = document.getElementById('kraSummaryChart').getContext('2d');
// new Chart(ctx, {
//     type: 'pie',
//     data: {
//         labels: ['Total Target', 'Total Callyzer'],
//         datasets: [{
//             data: [$totalTarget, $totalCallyzer],
//             backgroundColor: ['rgba(0, 88, 79, 1)', '#f8c200'],
//             borderWidth: 3,
//             borderColor: '#ffffff'
//         }]
//     },
//     options: {
//         responsive: true,
//         plugins: {
//             title: {
//                 display: true,
//                 text: 'Target vs Callyzer Summary',
//                 font: {
//                     size: 18
//                 }
//             },
//             tooltip: {
//                 callbacks: {
//                     label: function(context) {
//                         return context.label + ': ' + context.parsed + ' (' + 
//                                Math.round(context.parsed / context.chart._metasets[0].total * 100) + '%)';
//                     }
//                 }
//             }
//         }
//     }
// });
// </script>";
$stmt->close();
$conn->close();
