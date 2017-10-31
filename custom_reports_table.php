<?php
	/**
	 * PEP Capping 2017 Algozzine's Class
	 *
	 * Displays the results of a custom report.
	 *
	 * This page display the information requested in the form
	 * on custom_reports.php page, formatted into a single table.
	 *
	 * @author Daniel Ahl
	 *		   Rafael Mormol
	 * @copyright 2017 Marist College
	 * @version 0.1.4.2
	 * @since 0.1.4.1
	 */
		
		authorizedPage();
		if ($_SERVER['REQUEST_METHOD'] !== 'POST') header('Location: custom-reports');
		
		global $db;
		
		include('header.php');
	
		$month = $_POST['month'];
		$year = $_POST['year'];
		$locs = isset($_POST['location']) ? $_POST['location'] : [];
		$races = isset($_POST['race']) ? $_POST['race'] : [];
		$minAge = $_POST['minAge'];
		$maxAge = $_POST['maxAge'];
		$monthQuery = "(date_part('month', participantclassattendance.date) = $month)";
		$yearQuery = "(date_part('year', participantclassattendance.date) = $year)";
		$locQuery = "";
		
		if (count($locs) > 0) {
			$locQuery = "(participantclassattendance.siteName = '" . $locs[0] . "' ";
			for ($i = 1; $i < count($locs); $i++) {
				$locQuery .= "OR participantclassattendance.siteName = '" . $locs[$i] . "' ";
			}
			$locQuery .= ")";
		}
		
		$raceQuery = "";
		if (count($races) > 0) {
			$raceQuery = "(participants.race = '" . $races[0] . "' ";
			for ($i = 1; $i < count($races); $i++) {
				$raceQuery .= "OR participants.race = '" . $races[$i] . "' ";
			}
			$raceQuery .= ")";
		}
		$ageQuery = "";
		if ($minAge !== 'any') {
			$ageQuery = "((date_part('year', AGE(participants.dateOfBirth)) >= $minAge) ";
		}
		if ($maxAge !== 'any') {
			if ($minAge === 'any') {
				$ageQuery = "(";
			} else {
				$ageQuery .= "AND ";
			}
			$ageQuery .= "(date_part('year', AGE(participants.dateOfBirth)) <= $maxAge))";
		} else {
			if ($ageQuery !== "") $ageQuery .= ")";
		}
		
		$yearWhereClause = "$yearQuery ";
		if ($locQuery !== "") $yearWhereClause .= "AND $locQuery ";
		if ($raceQuery !== "") $yearWhereClause .= "AND $raceQuery ";
		if ($ageQuery !== "") $yearWhereClause .= "AND $ageQuery ";
		
		$monthWhereClause = $yearWhereClause . "AND $monthQuery ";
		$newWhereClause = $monthWhereClause . "AND participantclassattendance.isnew = TRUE;";
		$monthWhereClause .= ";";
		
		$baseQuery = "SELECT COUNT(DISTINCT(participants.participantid)) as Participants
					FROM participants INNER JOIN participantclassattendance
					ON participants.participantid = participantclassattendance.participantid
					WHERE ";
					
		$monthRes = pg_fetch_result($db->query($baseQuery . $monthWhereClause, []), 0, 0);
		$newRes = pg_fetch_result($db->query($baseQuery . $newWhereClause, []), 0, 0);
		$duplRes = $monthRes - $newRes;
		$yearRes = pg_fetch_result($db->query($baseQuery . $yearWhereClause, []), 0, 0);
?>
<div class="container">
	<div class="container py-2">
		<div align="center">
			<h2>
				<?php
			switch ($month) {
				case 1: echo "January";
						break;
				case 2: echo "February";
						break;
				case 3: echo "March";
						break;
				case 4: echo "April";
						break;
				case 5: echo "May";
						break;
				case 6: echo "June";
						break;
				case 7: echo "July";
						break;
				case 8: echo "August";
						break;
				case 9: echo "September";
						break;
				case 10: echo "October";
						break;
				case 11: echo "November";
						break;
				case 12: echo "December";
						break;
			}
			?>
					<?=$year?>
			</h2>
		</div>
		<div align="center">
			<?php
			#Display the chosen locations
			if (count($locs) > 0) {
				echo "<div><b>Locations:</b> " . $locs[0];
				for ($i = 1; $i < count($locs); $i++) {
					echo ", " . $locs[$i];
				}
				echo "</div>";
			}
			
			#Display the chosen races
			if (count($races) > 0) {
				echo "<div><b>Races:</b> " . $races[0];
				for ($i = 1; $i < count($races); $i++) {
					echo ", " . $races[$i];
				}
				echo "</div>";
			}
			
			#Display the chosen ages
			if ($minAge !== 'any' || $maxAge !=='any') {
				if ($minAge === $maxAge) {
					echo "<div><b>Age Range:</b> " . $maxAge . "</div>";
				} elseif ($minAge === 'any') {
					echo "<div><b>Age Range:</b> " . $maxAge . " and below</div>";
				} elseif ($maxAge === 'any') {
					echo "<div><b>Age Range:</b> " . $minAge . " and above</div>";
				} else {
					echo "<div><b>Age Range:</b> " . $minAge . " - " . $maxAge . "</div>";
				}
			}
			?>
		</div>
	</div>
	<div class="container py-2">
		<table class="table table-hover table-striped table-bordered">
			<thead>
				<tr>
					<th>
						Current Month
					</th>
					<th>
						Newly Served
					</th>
					<th>
						Duplicate Served
					</th>
					<th>
						Year
					</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>
						<?=$monthRes?>
					</td>
					<td>
						<?=$newRes?>
					</td>
					<td>
						<?=$duplRes?>
					</td>
					<td>
						<?=$yearRes?>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
	<div class="container" align="center">
		<form action="custom-reports" method="POST" autocomplete="on">
			<input type="hidden" name="month" value="<?= $_POST['month']?>" />
			<input type="hidden" name="year" value="<?=$_POST['year']?>" />
			<input type="hidden" name="minAge" value="<?= $_POST['minAge']?>" />
			<input type="hidden" name="maxAge" value="<?= $_POST['maxAge']?>" />
			<button type="submit" class="btn cpca">Run Another Report</button>
		</form>
	</div>
</div>
<style>
@media print{
	#main-content {
		overflow: visible;
	}
	body{
		overflow: visible;
	}
	.navbar {
		display: none;
	}
	.side-menu {
		display: none;
	}
	.btn {
		display: none;
	}
	.form-group {
		display: none;
	}
}
</style>
<?php include('footer.php'); ?>