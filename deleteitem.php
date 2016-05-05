<?php
//Used to Delete Gym Data. Uses UserId to make sure only the user can delete their own gym data.

include 'includes/connect.php';

//Retrieves Rows ID From Table
$delete = mysqli_real_escape_string($conn, trim($_GET['delete']));
$userid = $_SESSION['userid'];
//Matches Whether Gym ID is Owned By Player Requesting Delete (Security Feature)
$sql = "SELECT * FROM gymtime WHERE userid = '$userid' AND gymtimeid = '$delete'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
					$deletesql = "DELETE FROM gymtime WHERE userid = '$userid' AND gymtimeid = '$delete'";
						if($conn->query($deletesql) == TRUE){
						//Deleted From Data
						$_SESSION['message'] = "That ID has been deleted.";
						} else {
						$_SESSION['message'] = "That ID has not been deleted.";
						//Not Deleted (Error)
						}
					} else {
					//Doesn't Belong To Them Or Isn't A Valid ID.
					}
header("Location: ../InteractiveAppsProject/enterprogress.php");		
$conn->close();
?>