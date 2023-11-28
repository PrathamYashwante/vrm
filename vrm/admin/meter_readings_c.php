<?php include_once '../main/header.php'; ?>
<style>
    .container {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 500px;
    }

    .card {
        flex: 0 0 280px;
        height: 50%;
        /* Set a fixed height for the cards */
        background-color: #ffffff;
        border-radius: 10px;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        margin: 10px;
        display: flex;
        /* Add display flex to enable flex properties on card-link */
        flex-direction: column;
        /* Stack the card-link content vertically */
    }

    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
    }

    .card-link {
        flex: 1;
        /* Expand the card-link to fill the available space */
        display: flex;
        flex-direction: column;
        text-decoration: none;
        padding: 20px;
        color: #333333;
        transition: background-color 0.3s ease, color 0.3s ease;
        border-radius: 10px;
    }

    .card-link:hover {
        background-color: #f5f5f5;
        color: #000000;
    }

    .card-title {
        font-size: 25px;
        font-weight: bold;
        margin-bottom: 10px;
    }

    .card-description {
        font-size: 17px;
        margin-bottom: 20px;
    }
</style>

<div class="container">
    <div class="card">
        <a href="../admin/add_daily_details.php" class="card-link">
            <h4 class="card-title">Add Meter Readings</h4>
            <p class="card-description">Add meter readings for a specific day.</p>
        </a>
    </div>

    <div class="card">
        <a href="../admin/two_days.php" class="card-link">
            <h4 class="card-title">View Records for two consecutive days</h4>
            <p class="card-description">View meter reading records for two days.</p>
        </a>
    </div>
    <div class="card">
        <a href="../admin/viewrecords.php" class="card-link">
            <h4 class="card-title">Update and View Records for a Day</h4>
            <p class="card-description">Update meter reading records for a specific day.</p>
        </a>
    </div>
    <div class="card">
        <a href="../admin/view_records_m.php" class="card-link">
            <h4 class="card-title">View Records for a Month</h4>
            <p class="card-description">View meter reading records for a specific month.</p>
        </a>
    </div>
    <div class="card">
        <a href="../admin/delete_records.php" class="card-link">
            <h4 class="card-title">Delete Records for a Day</h4>
            <p class="card-description">Delete meter reading records for a specific day.</p>
        </a>
    </div>
</div>

<?php include_once '../main/footer.php'; ?>