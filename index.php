<?php include 'header.php' ?>
<!-- Main Content -->
<div class="container-fluid px-4 px-lg-5 bg-custom-black">
	<div class="row gx-4 gx-lg-6 justify-content-center">
		<div class="col-md-10 col-lg-8 col-xl-6">
			<!-- Post preview -->

			<!-- Display 5 poems here -->
			<?php
			// Include the database connection configuration
			include 'config.php';

			// Define the number of posts per page
			$postsPerPage = 5;

			// Get the current page number from the URL
			$page = isset($_GET['page']) ? intval($_GET['page']) : 1;

			// Calculate the offset for the SQL query
			$offset = ($page - 1) * $postsPerPage;

			// Query to fetch the posts for the current page
			$sql = "SELECT *, DATE_FORMAT(writing_date, '%Y-%m-%d') AS formatted_date FROM poems ORDER BY writing_date DESC LIMIT $offset, $postsPerPage";

			$result = $conn->query($sql);

			// Check if there are any poems
			if ($result && $result->num_rows > 0) {
				// Output data of each row
				while ($row = $result->fetch_assoc()) {
					echo "<div class='post-preview text-white-80'>";
					echo "<h2 class='post-title'>" . $row["text"] . "</h2>";
					echo "<p class='post-meta'>Posted by " . $row["writer"] . " on " . $row["formatted_date"] . "</p>";
					echo "</div>";
					echo "<hr class='my-4' />";
				}

				// Pager for older posts
				echo "<div class='d-flex justify-content-center mb-4'>";

				if ($page > 1) {
					echo "<a class='btn btn-white text-uppercase me-2' href='?page=" . ($page - 1) . "'>Previous Page</a>";
				}

				// Check if there are more poems for the next page
				$nextPageOffset = $offset + $postsPerPage;
				$sqlNextPageCheck = "SELECT poem_id FROM poems LIMIT $nextPageOffset, 1";
				$resultNextPageCheck = $conn->query($sqlNextPageCheck);

				if ($resultNextPageCheck->num_rows > 0) {
					echo "<a class='btn btn-white text-uppercase' href='?page=" . ($page + 1) . "'>Next Page</a>";
				}

				echo "</div>";
			} else {
				echo "No poems found in the database.";
			}

			// Close the database connection
			$conn->close();
			?>

			<!-- Pager -->
		</div>
	</div>
</div>
<?php include 'footer.php' ?>