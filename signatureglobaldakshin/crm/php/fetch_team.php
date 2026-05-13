<?php
include 'config.php'; // DB connection

$sql = "SELECT * FROM team_login ORDER BY name ASC";
$result = $conn->query($sql);

$rows = '';

while ($row = $result->fetch_assoc()) {
  $rows .= '<tr>';
  $rows .= '<td>' . htmlspecialchars($row['name']) . '</td>';
  $rows .= '<td>' . htmlspecialchars($row['employ_id']) . '</td>';
  $rows .= '<td>' . htmlspecialchars($row['contact']) . '</td>';
  $rows .= '<td>' . htmlspecialchars($row['email']) . '</td>';
  $rows .= '<td>' . htmlspecialchars($row['team_name']) . '</td>';
  $rows .= '<td>' . htmlspecialchars($row['rights']) . '</td>';
  $rows .= '<td>
  <div class="action">
    <a href="#" class="btn edit-member"
       data-id="' . $row['id'] . '"
       data-name="' . htmlspecialchars($row['name']) . '"
       data-employid="' . htmlspecialchars($row['employ_id']) . '"
       data-email="' . htmlspecialchars($row['email']) . '"
       data-contact="' . htmlspecialchars($row['contact']) . '"
       data-team_name="' . htmlspecialchars($row['team_name']) . '"
       data-rights="' . htmlspecialchars($row['rights']) . '"
    >
      <ion-icon name="create"></ion-icon>
    </a>
        <a href="php/delete/delete_team.php?id=' . $row['id'] . '" class="btn delete-member" data-id="' . $row['id'] . '" onclick="return confirm(\'Are you sure you want to delete this member?\')"><ion-icon name="trash"></ion-icon></a>

  </div>
</td>';

  $rows .= '</tr>';
}

echo $rows;
$conn->close();
