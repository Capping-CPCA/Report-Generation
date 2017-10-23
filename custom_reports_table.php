<?php
	/**
	 * PEP Capping 2017 Algozzine's Class
	 *
	 * Displays the results of a custom report.
	 *
	 * This page will display the information requested in the form
	 * on custom_reports.php page, formatted into a single table.
	 *
	 * @author Daniel Ahl & Rafael Mormol
	 * @copyright 2017 Marist College
	 * @version 0.1
	 * @since 0.1
	 */
	 
	authorizedPage();
	global $params, $route, $view;
	include('header.php');
	
	$db2 = new Database('localhost', '5432',
	'postgres', 'admin', // replace with actual password
	'EvanDB');
	$db2->connect();
	
	if ($_SERVER['REQUEST_METHOD'] !== 'POST') die();

	$month = $_POST['month'];
	$year = $_POST['year'];
	$locs = isset($_POST['location']) ? $_POST['location'] : [];
	$races = isset($_POST['race']) ? $_POST['race'] : [];
	#$ages = isset($_POST['age']) ? $_POST['age'] : [];
	$minAge = $_POST['minAge'];
	$maxAge = $_POST['maxAge'];
	$monthQuery = "(date_part('month', participantclassattendance.date) = $month)";
	$yearQuery = "(date_part('year', participantclassattendance.date) = $year)";
	$locQuery = "";
	/*
	if (count($locs) > 0) {
		$locQuery = "(participantclassattendance.siteName = '" . $locs[0] . "' ";
		for ($i = 1; $i < count($locs); $i++) {
			$locQuery .= "OR participantclassattendance.siteName = '" . $locs[$i] . "' ";
		}
		$locQuery .= ")";
	}
	*/
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
	/*
	if (count($ages) > 0) {
		if ($ages[0] === '65') {
			$ageQuery = "((date_part('year', AGE(participants.dateOfBirth)) >= 65) ";
		} elseif ($ages[0] === '41-64') {
			$ageQuery = "((date_part('year', AGE(participants.dateOfBirth)) >= 41 AND date_part('year', AGE(participants.dateOfBirth)) <= 64) ";
		} else {
			 $ageQuery = "((date_part('year', AGE(participants.dateOfBirth)) >= 20 AND date_part('year', AGE(participants.dateOfBirth)) <= 40) ";
		}
		for ($i = 1; $i < count($ages); $i++) {
			if ($ages[$i] === '65') {
				$ageQuery .= "OR (date_part('year', AGE(participants.dateOfBirth)) >= 65) ";
			} elseif ($ages[$i] === '41-64') {
				$ageQuery .= "OR (date_part('year', AGE(participants.dateOfBirth)) >= 41 AND date_part('year', AGE(participants.dateOfBirth)) <= 64) ";
			} else {
				$ageQuery .= "OR (date_part('year', AGE(participants.dateOfBirth)) >= 20 AND date_part('year', AGE(participants.dateOfBirth)) <= 40) ";
			}
		}
		$ageQuery .= ")";
	}
	*/
	
	$yearWhereClause = "$yearQuery ";
	if ($locQuery !== "") $yearWhereClause .= "AND $locQuery ";
	if ($raceQuery !== "") $yearWhereClause .= "AND $raceQuery ";
	if ($ageQuery !== "") $yearWhereClause .= "AND $ageQuery ";
	
	$monthWhereClause = $yearWhereClause . "AND $monthQuery ";
	$newWhereClause = $monthWhereClause . "and participantclassattendance.firstclass = TRUE;";
	$duplWhereClause = $monthWhereClause . "and participantclassattendance.firstclass = FALSE;";
	$monthWhereClause .= ";";
	
	$baseQuery = "SELECT COUNT(DISTINCT(participants.participantid)) as Participants
				FROM participants INNER JOIN participantclassattendance
				ON participants.participantid = participantclassattendance.participantid
				WHERE ";
				
	$monthRes = pg_fetch_result($db2->query($baseQuery . $monthWhereClause, []), 0, 0);
	$newRes = pg_fetch_result($db2->query($baseQuery . $newWhereClause, []), 0, 0);
	$duplRes = pg_fetch_result($db2->query($baseQuery . $duplWhereClause, []), 0, 0);
	$yearRes = pg_fetch_result($db2->query($baseQuery . $yearWhereClause, []), 0, 0);
?>
<div class="container">
	<h3 align="center">Custom Report</h3>
	<br />
	<div align="center"><b>Month:</b> <?php
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
		?></div>
	<div align="center"><b>Year:</b> <?=$year?></div>
	<br />
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
			if ($minAge !== 'any' || $maxAge !=='any')
				if ($minAge === 'any') {
					echo "<div><b>Age Range:</b> " . $maxAge . " and below</div>";
				} elseif ($maxAge === 'any') {
					echo "<div><b>Age Range:</b> " . $minAge . " and above</div>";
				} else {
					echo "<div><b>Age Range:</b> " . $minAge . " - " . $maxAge . "</div>";
				}
			/*
			if (count($ages) > 0) {
				if ($ages[0] == 65) {
					echo "<div><b>Age Range:</b> " . $ages[0] . "+";
				} else {
					echo "<div><b>Age Range:</b> " . $ages[0];
				}
				for ($i = 1; $i < count($ages); $i++) {
					if ($ages[$i] == 65) {
						echo ", " . $ages[$i] . "+ ";
					} else {
						echo ", " . $ages[$i] . " ";
					}
				}
				echo "</div>";
			}
			*/
			?>
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
						YTD
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
</div>
<?php include('footer.php'); ?>