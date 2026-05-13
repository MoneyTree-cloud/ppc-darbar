<?php
include 'config.php';

$sql = "SELECT k.*, t.employ_id 
        FROM kra k
        LEFT JOIN team_login t ON k.name = t.name
        ORDER BY k.id ASC";

$result = $conn->query($sql);

$rows = '';
$index = 1;

$totalTarget = 0;
$totalCallyzer = 0;
$totalAchieved = 0;
$totalProspects = 0;
$totalMeetings = 0;
$rowCount = 0;

while ($row = $result->fetch_assoc()) {
    $rowCount++;
    $rowCallyzer = $row['callyzer_2pm'] + $row['callyzer_5pm'] + $row['callyzer_8pm'];

    $color = $rowCallyzer < $row['calling_target'] ? "#f43636" : "#0dcb75";
    $prospect_color = $row['prospects'] < 5 ? "#f43636" : "#0dcb75";
    if($row['no_of_meetings'] >= 1){
        $meeting_color = "#0dcb75";
    }
    else{
        $meeting_color = "#111";
    }


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
    $rows .= '<td style="color:' . $prospect_color . ';">' . $row['prospects'] . '</td>';
    $rows .= '<td style="color:' . $meeting_color . ';">' . $row['no_of_meetings'] . '</td>';
    // $rows .= '<td>' . $row['not_sale'] . ' days</td>';
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
        <a href="php/delete/delete_kra.php?id=' . $row['id'] . '" class="btn"><ion-icon name="trash"></ion-icon></a>
      </div></td>';
    $rows .= '</tr>';

    // Totals
    $totalCallyzer += $rowCallyzer;
    $totalTarget += $row['calling_target'];
    $totalAchieved += $row['target_achieved'];
    $totalProspects += $row['prospects'];
    $totalMeetings += $row['no_of_meetings'];
}

// Add footer row with JavaScript
$rows .= "<script>
document.getElementById('summaryFooter').innerHTML = `
    <tr style='text-align: center; font-weight: bold;'>
        <td colspan='2'>Total</td>
        <td id='totalTarget'>$totalTarget</td>
        <td colspan='3' style='text-align: center;'>$totalCallyzer</td>
        <td>" . round(($totalTarget ? ($totalCallyzer / $totalTarget) * 100 : 0), 2) . "%</td>
        <td>$totalProspects</td>
        <td id='totalMeetings'>$totalMeetings</td>
        <td></td>
    
    </tr>
`;
</script>
";

echo $rows;

echo "<script>
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
                        return context.label + ': ' + context.parsed + ' (' + 
                               Math.round(context.parsed / context.chart._metasets[0].total * 100) + '%)';
                    }
                }
            }
        }
    }
});
</script>";
$conn->close();
