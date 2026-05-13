<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Todays EOD</title>
    <link rel="stylesheet" href="style.css?v=<?= filemtime('style.css') ?>">
     <!-- font-icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
  <?php include('../resource.php'); ?>

</head>
<body>


    <h1 id="eodTitle">Today Team EOD (<span id="todayDate"></span>)</h1>
    <p>Please Fill the today End Of Day (EOD) report.</p>
    <form class="eodForm" action="php/submit_eod.php" method="post" id="eodForm">
        <div class="input-group">
            <label>Employ ID<span style="color: red;">*</span></label>
            <input type="number" name="employ_id">
        </div>
        <div class="input-group">
            <label>Total Calls<span style="color: red;">*</span></label>
            <input type="number" name="calls">
        </div>
        <div class="input-group">
            <label>Total Prospects<span style="color: red;">*</span></label>
            <input type="number" name="prospects">
        </div>
        <div class="input-group">
            <label>Total Meetings<span style="color: red;">*</span></label>
            <input type="number" name="meetings">
        </div>
  <h2>Expected Sales</h2>
  <div class="sales-wrapper" id="salesWrapper">
    <div class="sale">
      <div class="sale-header">
      <span class="sale-number">1.</span>
      <div class="input-group">
            <label>Client Name<span style="color: red;">*</span></label>
            <input type="text" name="client_name[]" class="client-name">
            <i class="fa-solid fa-pen-to-square"></i>
      </div>
            <!--<span class="remove-sale" title="Remove">❌</span>-->
      </div>
      <div class="details">
        <div class="input-group">
            <label>Mobile No.<span style="color: red;">*</span></label>
            <input type="tel" name="mobile[]" pattern="[0-9]{10}" maxlength="10" minlength="10" required placeholder="Enter 10 digit mobile number">
        </div>
        <div class="input-group">
            <label>Project Name<span style="color: red;">*</span></label>
            <input type="text" name="project[]">
        </div>
        <div class="input-group">
            <label>Unit Number<span style="color: red;">*</span></label>
            <input type="text" name="unit[]">
        </div>
        <div class="input-group">
            <label>Unit Size<span style="color: red;">*</span></label>
            <input type="text" name="size[]">
        </div>
        <div class="input-group">
            <label>Total Cost<span style="color: red;">*</span></label>
            <input type="text" name="total_cost[]">
        </div>
            <label>Inventory Hold on SAP:
          <input type="radio" name="inventory_status[]" value="yes" style="margin-left: 30px;"> <span>Yes</span>
          <input type="radio" name="inventory_status[]" value="no" style="margin-left: 30px;"> <span>No</span>
        <span style="color: red;">*</span></label>
      </div>
    </div>
    </div>


  <button type="button" class="btn" id="addSaleBtn">Add more exp. sale</button>
  <input type="submit" value="Submit EOD">
</form>

<div id="notificationContainer"></div>

<script src="script.js?v=<?= filemtime('script.js') ?>"></script>

</body>
</html>