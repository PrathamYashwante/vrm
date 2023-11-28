<?php include_once '../main/header.php'; ?>

<link rel="stylesheet" type="text/css" href="../main/compiled_links.css">

<div class="container">
    <div class="card">
        <a href="summ.php" class="card-link">
            <h4 class="card-title">Calculate Summary</h4>
            <p class="card-description">Calculate the summary for a specific day.</p>
        </a>
    </div>
    <div class="card">
        <a href="summary.php" class="card-link">
            <h4 class="card-title">Download Summary for a Day (PDF)</h4>
            <p class="card-description">Download the summary for a specific day in PDF format.</p>
        </a>
    </div>
    <div class="card">
        <a href="summary_excel.php" class="card-link">
            <h4 class="card-title">Download Summary for a Day (Excel)</h4>
            <p class="card-description">Download the summary for a specific day in Excel format.</p>
        </a>
    </div>
    <div class="card">
        <a href="summary_m.php" class="card-link">
            <h4 class="card-title">View Summary for a Month</h4>
            <p class="card-description">View the summary for a specific month.</p>
        </a>
    </div>
</div>

<?php include_once '../main/footer.php'; ?>
