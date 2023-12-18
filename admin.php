<?php
include('config.php');
// Set the correct password
$correctPassword = "farok"; // Change this to your actual password

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {
    // Check if the password is correct
    $enteredPassword = $_POST["password"];

    if ($enteredPassword == $correctPassword) {
        // Password is correct, proceed with poem upload
        $stmt = $conn->prepare("INSERT INTO poems (text) VALUES (?)");
        $stmt->bind_param("s", $poemText);
        $poemText = $_POST["poemText"];

        if ($stmt->execute()) {
            echo "Poem uploaded successfully.";
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    } else {
        // Password is incorrect
        echo "Incorrect password. Poem upload not allowed.";
    }
}

include 'header.php';
?>

<div class="container">
    <h2 class="text-center text-white">Admin oldal - Vers feltöltés</h2>

    <div class="row justify-content-center">
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" class="col-10 col-md-8 col-lg-6 mt-4">

            <label for="poemText" class="form-label text-white mt-3">Ide írd a verset:</label>
            <textarea name="poemText" rows="4" class="form-control" style="resize: none;" required></textarea>

            <label for="password" class="form-label text-white">Jelszó:</label>
            <input type="password" name="password" class="form-control" required>


            <div class="text-center">
                <button type="submit" name="submit" class="btn btn-white mt-3">Vers feltöltése</button>
            </div>
        </form>
    </div>
</div>
<br>

<?php include 'footer.php' ?>