<!-- admin.html -->
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard | Cards</title>

  <!-- ======= Styles ====== -->
  <link rel="stylesheet" href="../style.css">
</head>

<body>
    
      <!-- ======================= Cards ================== -->
      <div class="cardBox">
        <a href="leads.php">
          <div class="card">
            <div>
              <div class="numbers">0</div>
              <div class="cardName">Total No. of Leads</div>
              <span class="cardUnread_notification">0</span>
            </div>
            
            <div class="iconBx">
              <ion-icon name="people-outline"></ion-icon>
            </div>
          </div>
        </a>

      <a href="leads.php?status=interested">
        <div class="card">
          <div>
            <div class="numbers">0</div>
            <div class="cardName">Interested</div>
          </div>

          <div class="iconBx">
            <ion-icon name="checkmark-outline"></ion-icon>
          </div>
        </div>
        </a>
      
      <a href="leads.php?status=not_interested">
        <div class="card">
          <div>
            <div class="numbers">0</div>
            <div class="cardName">Not Interested</div>
          </div>

          <div class="iconBx">
            <ion-icon name="close-circle"></ion-icon>
          </div>
        </div>
        </a>

      <a href="leads.php?status=hot">
        <div class="card">
          <div>
            <div class="numbers">0</div>
            <div class="cardName">Hot</div>
          </div>

          <div class="iconBx">
            <ion-icon name="cube"></ion-icon>
          </div>
        </div>
        </a>

      <a href="leads.php?status=very_hot">
        <div class="card">
          <div>
            <div class="numbers">0</div>
            <div class="cardName">Very Hot</div>
          </div>

          <div class="iconBx">
            <ion-icon name="chatbubbles-outline"></ion-icon>
          </div>
        </div>
        </a>

      <a href="leads.php?status=dumped">
        <div class="card">
          <div>
            <div class="numbers">0</div>
            <div class="cardName">Dump</div>
          </div>

          <div class="iconBx">
            <ion-icon name="trash"></ion-icon>
          </div>
        </div>
        </a>
        
      <a href="leads.php?status=meeting_booked">
        <div class="card">
          <div>
            <div class="numbers">0</div>
            <div class="cardName">Meeting Booked</div>
          </div>

          <div class="iconBx">
            <ion-icon name="briefcase"></ion-icon>
          </div>
        </div>
        </a>

      <a href="leads.php?status=site_visited">
        <div class="card">
          <div>
            <div class="numbers">0</div>
            <div class="cardName">Site Visited</div>
          </div>

          <div class="iconBx">
            <ion-icon name="checkmark-circle-outline"></ion-icon>
          </div>
        </div>
       </a> 
       
       <a href="number_leads.php">
        <div class="card">
          <div>
            <div class="numbers">0</div>
            <div class="cardName">Raw Leads</div>
          </div>

          <div class="iconBx">
            <ion-icon name="create"></ion-icon>
          </div>
        </div>
       </a>
       
       <a href="ip_captured.php">
        <div class="card">
          <div>
            <div class="numbers">0</div>
            <div class="cardName">Domain Visited</div>
          </div>

          <div class="iconBx">
            <ion-icon name="globe"></ion-icon>
          </div>
        </div>
       </a>
       
      </div>

</body>
</html>