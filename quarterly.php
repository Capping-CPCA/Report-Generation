<?php 
    authorizedPage();
   
    global $params, $route, $view;
   
    include('header.php'); 
   
    $db2 = new Database('localhost', '5432',
		'postgres', 'admin', // replace with actual password
		'EvanDB');
	$db2->connect();
	
	$MIN_FAVOR_SCORE = 7;
	
	$pResult = "";
	$year = "";
	$quarter = "";
	$sTotalResults = [];
	$sFavorResults = [];
	
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		$year = $_POST["year"];
		$quarter = $_POST["quarter"];;
		$pWhere = "(date_part('year', participantclassattendance.date) = $year ";
		if ($quarter === "1") {
			$pWhere .= "AND date_part('month', participantclassattendance.date) < 4 "; 
		} elseif ($quarter === "2") {
			$pWhere .= "AND date_part('month', participantclassattendance.date) >= 4 
						AND date_part('month', participantclassattendance.date) < 7 "; 
		} elseif ($quarter === "3") {
			$pWhere .= "AND date_part('month', participantclassattendance.date) >= 7
						AND date_part('month', participantclassattendance.date) < 10 "; 
		} else {
			$pWhere .= "AND date_part('month', participantclassattendance.date) >= 10 "; 
		}
		$pWhere .= "AND participantclassattendance.firstclass = TRUE)";
		$pQuery = "SELECT COUNT(DISTINCT(participantclassattendance.participantid)) FROM participantclassattendance WHERE $pWhere";
		$pResult = pg_fetch_result($db2->query($pQuery, []), 0, 0);
		
		$pIDQuery = "SELECT DISTINCT(participantclassattendance.participantid) FROM participantclassattendance WHERE $pWhere";
		$formIDQuery = "SELECT DISTINCT(formid) FROM participantsformdetails WHERE participantid IN ($pIDQuery)";
		
		$sBaseQuery = "SELECT COUNT(prestopicdiscussedscore) as topic, COUNT(preschildperspectivescore) as perspective,
					COUNT(presotherparentsscore) as otherparents, COUNT(practiceinfoscore) as practice
					FROM surveys ";
		$sInFavor = " prestopicdiscussedscore > $MIN_FAVOR_SCORE AND preschildperspectivescore > $MIN_FAVOR_SCORE AND presotherparentsscore > $MIN_FAVOR_SCORE AND practiceinfoscore > $MIN_FAVOR_SCORE ";
		$sTotalQuery = $sBaseQuery . "WHERE surveyid IN ($formIDQuery) ";
		$sFavorQuery = $sTotalQuery . "AND ($sInFavor)";
					
		$sTotalResults = pg_fetch_all($db2->query($sTotalQuery, []))[0];
		$sFavorResults = pg_fetch_all($db2->query($sFavorQuery, []))[0];
		
		#echo print_r($sTotalResults);
		#echo print_r($sFavorResults);
	}
?>
<div class="container">
	<div class="container pt-5">
		<form action="" method="POST" autocomplete="on">
			<div class="row" style="margin-bottom: 1%">
				<div class="col">
					<div class="form-group">
						<select class="form-control" name="quarter" id="quarter">
                     <option value="1">Q1</option>
                     <option value="2">Q2</option>
					 <option value="3">Q3</option>
					 <option value="4">Q4</option>
                  </select>
					</div>
				</div>
				<div class="col">
					<div class="form-group">
						<select class="form-control" name="year" id="year">
						<!-- Javascript below adds the options based on current year -->
                  </select>
					</div>
				</div>
			</div>
			<div class="row pb-3">
				<div class="col"></div>
				<div class="col-centered">
					<button type="submit" class="btn cpca">Generate Report</button>
				</div>
				<div class="col"></div>
			</div>
		</form>
	</div>
	<div class="container py-3">
		<h1 class="text-center">
			<?php if ($quarter !== "") echo "Q" . $quarter;?>
			<?=$year?>
		</h1>
	</div>
	<div class="container py-3">
		<table class="table table-active">
			<thead>
			</thead>
			<tbody>
				<tr>
					<th scope="row">Total # of clients served (unduplicated):</td>
						<td><b><?=$pResult?></b></td>
				</tr>
			</tbody>
		</table>
	</div>
	<div class="container pb-2">
		<h3 class="text-center">Survey Results</h3>
	</div>
	<div class="container">
		<table class="table table-hover">
			<thead>
				<tr>
					<th>Questions</th>
					<th>% in Favor</th>
					<th># in Favor</th>
					<th>Total Respondents</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td scope="row">Have an increased knowledge of the topics</td>
					<td>
						<?php if (count($sFavorResults) > 0) {
						if ($sTotalResults["topic"] > 0) 
							echo ($sFavorResults["topic"]/$sTotalResults["topic"])*100 . "%";
					}?>
					</td>
					<td>
						<?php if (count($sFavorResults) > 0) echo $sFavorResults["topic"];?>
					</td>
					<td>
						<?php if (count($sTotalResults) > 0) echo $sTotalResults["topic"];?>
					</td>
				</tr>
				<tr>
					<td scope="row">Plan on using specific techniques discussed in class</td>
					<td>
						<?php if (count($sFavorResults) > 0) {
						if ($sTotalResults["practice"] > 0) 
							echo ($sFavorResults["practice"]/$sTotalResults["practice"])*100 . "%";
					}?>
					</td>
					<td>
						<?php if (count($sFavorResults) > 0) echo $sFavorResults["practice"];?>
					</td>
					<td>
						<?php if (count($sTotalResults) > 0) echo $sTotalResults["practice"];?>
					</td>
				</tr>
				<tr>
					<td scope="row">Realized other parents share the same concerns</td>
					<td>
						<?php if (count($sFavorResults) > 0) {
						if ($sTotalResults["otherparents"] > 0) 
							echo ($sFavorResults["otherparents"]/$sTotalResults["otherparents"])*100 . "%";
					}?>
					</td>
					<td>
						<?php if (count($sFavorResults) > 0) echo $sFavorResults["otherparents"];?>
					</td>
					<td>
						<?php if (count($sTotalResults) > 0) echo $sTotalResults["otherparents"];?>
					</td>
				</tr>
				<tr>
					<td scope="row">Understand children have different perspectives than they do</td>
					<td>
						<?php if (count($sFavorResults) > 0) {
						if ($sTotalResults["perspective"] > 0) 
							echo ($sFavorResults["perspective"]/$sTotalResults["perspective"])*100 . "%";
					}?>
					</td>
					<td>
						<?php if (count($sFavorResults) > 0) echo $sFavorResults["perspective"];?>
					</td>
					<td>
						<?php if (count($sTotalResults) > 0) echo $sTotalResults["perspective"];?>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
</div>
<script>
	const MIN_YEAR = 2010;

	window.onload = initPage;

	function initPage() {
		var d = new Date();
		var quartElem = document.getElementById("quarter");
		var month = d.getMonth();
		if (month < 3) {
			quartElem.selectedIndex = 0;
		} else if (month < 6) {
			quartElem.selectedIndex = 1;
		} else if (month < 9) {
			quartElem.selectedIndex = 2;
		} else {
			quartElem.selectedIndex = 3;
		}
		var yearElem = document.getElementById("year");
		var year = d.getFullYear();
		for (y = year; y >= MIN_YEAR; y--) {
			var opt = document.createElement('option');
			opt.value = y;
			opt.innerHTML = y;
			yearElem.appendChild(opt);
		}
	}
</script>
<?php include('footer.php'); ?>