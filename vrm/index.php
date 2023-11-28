

<style>
    body,
    h1,
    h2,
    h3,
    p,
    label,
    input,
    button {
        margin: 0;
        padding: 0;
    }

    body {
        font-family: "Times New Roman", serif;
        font-size: 16px;
        background-color: #0c4c66;

    }

    .container {
        max-width: 960px;
        margin: 0 auto;
        padding: 20px;
    }

    h1 {
        font-size: 32px;
        font-weight: bold;
        margin-bottom: 10px;
    }

    h2 {
        font-size: 24px;
        font-weight: bold;
        margin-bottom: 10px;
    }

    h3 {
        font-size: 20px;
        font-weight: bold;
        margin-bottom: 10px;
    }

    p {
        font-size: 16px;
        line-height: 1.5;
        margin-bottom: 10px;
    }

    label {
        font-weight: bold;
        display: inline-block;
    }

    input[type="text"],
    input[type="date"],
    input[type="password"],
    input[type="number"] {
        padding: 8px;
        border: 1px solid #ccc;
        border-radius: 4px;
        font-size: 16px;
        width: 70%;
        box-sizing: border-box;
        margin-bottom: 10px;
    }

    input[type="date"] {
        width: auto;
    }

    button {
        background-color: #007bff;
        color: #fff;
        cursor: pointer;
        padding: 8px 16px;
        border: none;
        border-radius: 4px;
    }

    button:hover {
        background-color: #0056b3;
    }

    .card {
        margin: 10px;
        background-color: #f8f9fa;
        border: 1px solid #ccc;
        border-radius: 4px;
        padding: 20px;
        text-align: center;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .card-h3 {
        margin: 10px;
        background-color: #f8f9fa;
        border: 1px solid #ccc;
        border-radius: 4px;
        padding: 20px;
        text-align: center;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    img {
        width: 70px;
        height: 70px;
        padding: 5px;
    }

    .navbar {
        background-color: #0c4c66;
        display: flex;
        align-items: center;
    }

    .navbar .navbar-nav {
        display: flex;
        align-items: center;
        list-style-type: none;
    }

    .navbar .navbar-nav .nav-item {
        margin-right: 10px;
    }

    .navbar .navbar-nav .nav-link {
        color: #fff;
        display: flex;
        align-items: center;
        font-size: 25px;
    }

    .navbar .navbar-nav .nav-link:hover {
        color: #fbc531;
    }

    .navbar .navbar-nav .active>.nav-link {
        color: #fbc531;
    }

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
    }

    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
    }

    .card-link {
        display: block;
        text-decoration: none;
        padding: 20px;
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
    }

    .card-description {
        font-size: 20px;
        margin-bottom: 10px;
    }

    .card-description-h1 {
        font-size: 30px;
        margin-bottom: 20px;
    }

    h1,
    p {
        margin: 0;
    }
</style>

<!-- Content -->
<div class="container">
    <div class="card">
        <h1 class="card-description-h1">Welcome to VRM Data Management</h1>
        <p class="card-description">This system allows you to manage and analyze VRM data for JSW Cement.</p>
        <p class="card-description">Please navigate through the links in the navigation bar to access different features of the system.</p>
        <a class="card-description" href="../vrm/main/home.php">Please click here to access the website</a>
    </div>
</div>

