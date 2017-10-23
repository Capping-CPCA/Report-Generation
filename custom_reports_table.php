<?php
/**
 * PEP Capping 2017 Algozzine's Class
 *
 * Displays the results of a custom report.
 *
 * This page will display the information requested in the form
 * on custom_reports.php page, formatted into a single table.
 *
 * @author Rafael Mormol & Daniel Ahl
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
	
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		#echo print_r($_POST);
		$month = $_POST['month'];
		$year = $_POST['year'];
		$locs = isset($_POST['location']) ? $_POST['location'] : [];
		$races = isset($_POST['race']) ? $_POST['race'] : [];
		$ages = isset($_POST['age']) ? $_POST['age'] : [];
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
		if (count($ages) > 0) {
			if ($ages[0] === '65') {
				$ageQuery = "((date_part('year', AGE(participants.dateOfBirth)) >= 65) ";
			} elseif ($ages[0] === '41_64') {
				$ageQuery = "((date_part('year', AGE(participants.dateOfBirth)) >= 41 AND date_part('year', AGE(participants.dateOfBirth)) <= 64) ";
			} else {
				 $ageQuery = "((date_part('year', AGE(participants.dateOfBirth)) >= 20 AND date_part('year', AGE(participants.dateOfBirth)) <= 40) ";
			}
			for ($i = 1; $i < count($ages); $i++) {
				if ($ages[$i] === '65') {
					$ageQuery .= "OR (date_part('year', AGE(participants.dateOfBirth)) >= 65) ";
				} elseif ($ages[$i] === '41_64') {
					$ageQuery .= "OR (date_part('year', AGE(participants.dateOfBirth)) >= 41 AND date_part('year', AGE(participants.dateOfBirth)) <= 64) ";
				} else {
					$ageQuery .= "OR (date_part('year', AGE(participants.dateOfBirth)) >= 20 AND date_part('year', AGE(participants.dateOfBirth)) <= 40) ";
				}
			}
			$ageQuery .= ")";
		}
		
		$whereClause = "$monthQuery AND $yearQuery ";
		if ($locQuery !== "") $whereClause .= "AND $locQuery ";
		if ($raceQuery !== "") $whereClause .= "AND $raceQuery ";
		if ($ageQuery !== "") $whereClause .= "AND $ageQuery ";
		
		$query = "SELECT COUNT(DISTINCT(participants.participantid)) as Participants
					FROM participants INNER JOIN participantclassattendance
					ON participants.participantid = participantclassattendance.participantid
					WHERE $whereClause;";
					
		$results = pg_fetch_all($db2->query($query, []));
		
		echo "Query: " . $query;
		echo '<br>';
		echo '<br>';
		echo print_r($results);
	}
	?>
<div class="container">
    <h3 align="center">Custom Report</h3>
    <br />
    <h6 align="center">Month: October</h6>
    <h6 align="center">Year: 2016</h6>
    <br />
    <h6 align="center">Location: Cornerstone | Race: African American | Age: 41-64 </h6>
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
                    7
                </td>
                <td>
                    2
                </td>
                <td>
                    0
                </td>
                <td>
                    24
                </td>
            </tr>
        </tbody>
    </table>
</div>
<?php include('footer.php'); ?>