<?php include_once '../main/header.php'; ?>

<style>
    .container {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 500px;
    }

    .card {
        width: 100%;
        max-width: 1000px;
        max-height: 1000px;
        /* Adjust the width as per your preference */
        background-color: #ffffff;
        border-radius: 10px;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        margin: 10px;
        flex-grow: 1;
        /* Distribute the available space equally among the cards */
        padding: 20px;
        /* Add padding to the card */
        box-sizing: border-box;
        /* Include padding in the total width of the card */
        display: flex;
        /* Display flex to align items left */
        flex-direction: column;
        /* Arrange items vertically */
        justify-content: flex-start;
        /* Align items from the start */
    }

    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
    }

    .card-link {
        display: block;
        text-decoration: none;
        color: #333333;
        transition: background-color 0.3s ease, color 0.3s ease;
        border-radius: 10px;
        height: 100%;
        /* Make the card link take up the entire height of the card */
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .card-title {
        font-size: 20px;
        margin-bottom: 10px;
        text-align: left;
        /* Add text-align left to align the title from the left */
    }

    .card-description {
        font-size: 20px;
        margin-bottom: 10px;
        margin-left: 50px;
        text-align: left;
        /* Add text-align left to align the description from the left */
    }

    .card-description-h1 {
        font-size: 30px;
        margin-bottom: 20px;
        margin-left: 0;

        /* Add text-align left to align the description heading from the left */
    }

    .card-description-p {
        font-size: 20px;
        margin-bottom: 10px;
        margin-left: 0;

        /* Add text-align left to align the description heading from the left */
    }
    h1 {
        margin: 0;
    }
</style>



<!-- Content -->
<div class="container">
    <div class="card">
        <?php
        if (isset($_SESSION["username"])) {
            echo '<p class="card-description-p">Hello, ' . $_SESSION["username"] . '</p>
            
            <h1 class="card-description-h1">Welcome to VRM Data Management</h1>
            <h3 class="card-description-p">Instructions</h3>
            <p class="card-description">1. Enter all the meter readings for a particular date.
                <a href="../admin/add_daily_details.php">Add Meter Readings</a>
            </p>
            <p class="card-description">2. Calculate power consumption for a particular date.
                <a href="../admin/pc.php">Power Consumption</a>
            </p>
            <p class="card-description">3. Calculate the summary for a particular date.
                <a href="../admin/summ.php">Summary</a>
            </p>
            <p class="card-description-red" style="color: red;">Please Note: If you update/change any reading for a particular date or add any new table or alter a table then please calculate the power consumption for that date. If the reading is for a summary table, please calculate the summary as well.</p>';
        } else {
            echo '<p class="card-description-p" >Hello, guest</p>
            
            <h1 class="card-description-h1">Welcome to VRM Data Management</h1>
            '; // Display a default message if $_SESSION['username'] is undefined
        }
        ?>

    </div>
</div>

<?php include_once '../main/footer.php'; ?>