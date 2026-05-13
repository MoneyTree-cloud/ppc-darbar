<?php
session_start();
include 'config.php';

// Ensure session has team_name
if (!isset($_SESSION['team_name'])) {
    echo '<tr><td colspan="10">Access Denied</td></tr>';
    exit;
}

$teamName = $_SESSION['team_name'];

$sql = "SELECT k.*, t.employ_id 
        FROM kra k
        LEFT JOIN team_login t ON k.name = t.name
        WHERE t.team_name = ?
        ORDER BY k.id ASC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $teamName);
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
    $rowCallyzer = $row['callyzer_2pm'] + $row['callyzer_5pm'] + $row['callyzer_8pm'];

    $color = $rowCallyzer > $row['calling_target'] ? "#0dcb75" : ($rowCallyzer == $row['calling_target'] ? "black" : "#f43636");

    $displayName = htmlspecialchars($row['name']);
    if (!empty($row['employ_id'])) {
        $displayName .= ' (' . htmlspecialchars($row['employ_id']) . ')';
    }

    $rows .= '<tr class="kra-row">';
    $rows .= '<td>' . $index++ . '</td>';
    $rows .= '<td style="text-align: left;">' . $displayName . '</td>';
    $rows .= '<td style="color:' . $color . ';">' . $row['calling_target'] . '/' . $rowCallyzer . '</td>';
    $rows .= '<td>' . $row['callyzer_2pm'] . '</td>';
    $rows .= '<td>' . $row['callyzer_5pm'] . '</td>';
    $rows .= '<td>' . $row['callyzer_8pm'] . '</td>';
    $rows .= '<td>' . $row['target_achieved'] . '%</td>';
    $rows .= '<td>' . $row['prospects'] . '</td>';
    $rows .= '<td>' . $row['no_of_meetings'] . '</td>';
    $rows .= '<td><div class="action">
        <a href="#" class="btn edit-btn"
           data-id="' . $row['id'] . '"
           data-name="' . htmlspecialchars($row['name']) . '"
           data-calling="' . $row['calling_target'] . '"
           data-2pm="' . $row['callyzer_2pm'] . '"
           data-5pm="' . $row['callyzer_5pm'] . '"
           data-8pm="' . $row['callyzer_8pm'] . '"
           data-prospect="' . $row['prospects'] . '"
           data-meeting="' . $row['no_of_meetings'] . '"
           data-not_sale="' . $row['not_sale'] . '">
          <ion-icon name="create"></ion-icon>
        </a>
      </div></td>';
    $rows .= '</tr>';

    // Totals
    $totalCallyzer += $rowCallyzer;
    $totalTarget += $row['calling_target'];
    $totalAchieved += $row['target_achieved'];
    $totalProspects += $row['prospects'];
    $totalMeetings += $row['no_of_meetings'];
}

// Add footer row
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

// Add chart JS
$rows .= "<script>
const ctx = document.getElementById('kraSummaryChart').getContext('2d');
new Chart(ctx, {
    type: 'pie',
    data: {
        labels: ['Total Target', 'Total Callyzer'],
        datasets: [{
            data: [$totalTarget, $totalCallyzer],
            backgroundColor: ['rgba(0, 88, 79, 1)', '#f8c200'],
            borderWidth: 3,
            borderColor: '#ffffff'
        }]
    },
    options: {
        responsive: true,
        plugins: {
            title: {
                display: true,
                text: 'Target vs Callyzer Summary',
                font: {
                    size: 18
                }
            },
            tooltip: {
                callbacks: {
                    label: function(context) {
                        const total = context.chart._metasets[0].total || 1;
                        return context.label + ': ' + context.parsed + ' (' + 
                            Math.round(context.parsed / total * 100) + '%)';
                    }
                }
            }
        }
    }
});
</script>";

echo $rows;
$stmt->close();
$conn->close();
