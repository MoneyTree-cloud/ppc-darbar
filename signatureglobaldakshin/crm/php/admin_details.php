<?php 
$sql_admin = "SELECT * FROM master_login WHERE `id` = '{$_SESSION['admin_id']}'";
$result_admin = mysqli_query($conn, $sql_admin);
$count_admin = mysqli_num_rows($result_admin);
if($count_admin>0){
  while($row_admin = mysqli_fetch_assoc($result_admin)){
    $admin_name = $row_admin['adminName'];
    $admin_profile = $row_admin['profile_img'];
  }
}
?>