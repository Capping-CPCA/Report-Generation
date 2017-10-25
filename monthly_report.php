<?php 
   authorizedPage();
   global $params, $route, $view;
   include('header.php'); 
   
   $db2 = new Database('localhost', '5432',
		'postgres', 'admin', 
		'EvanDB');
	$db2->connect();
	
	$month = "";
	$year = "";	
	
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		$year = $_POST["year"];
		$month = $_POST["month"];
		$monthWhere = "(date_part('month', date) = $month)";
		$yearWhere = "(date_part('year', date) = $year)";
		$pNewWhere = "(firstclass = TRUE)";
		
		#Total Participant Queries
		$pBaseQuery = "SELECT COUNT(DISTINCT(participantid)) FROM participantsenrolled ";
		
		$pMonthQuery = $pBaseQuery . "WHERE " . $monthWhere . " AND " . $yearWhere;
		$pMonthRes = pg_fetch_result($db2->query($pMonthQuery ,[]), 0, 0);
		$pNewQuery = $pBaseQuery . "WHERE " . $monthWhere . " AND " . $yearWhere . " AND " . $pNewWhere;
		$pNewRes = pg_fetch_result($db2->query($pNewQuery ,[]), 0, 0);
		$pDupRes = $pMonthRes - $pNewRes;
		$pYearQuery = $pBaseQuery . "WHERE " . $yearWhere;
		$pYearRes = pg_fetch_result($db2->query($pYearQuery ,[]), 0, 0);
		
		#Gender Where clauses
		$femaleWhere = "(sex = 'Female')";
		$maleWhere = "(sex = 'Male')";
		
		#Male Queries
		$query = $pMonthQuery . " AND $maleWhere ";
		$mMonthRes = pg_fetch_result($db2->query($query ,[]), 0, 0);
		$query = $pNewQuery . " AND $maleWhere ";
		$mNewRes = pg_fetch_result($db2->query($query ,[]), 0, 0);
		$mDupRes = $mMonthRes - $mNewRes;
		$query = $pYearQuery . " AND $maleWhere ";
		$mYearRes = pg_fetch_result($db2->query($query ,[]), 0, 0);
		
		#Female Queries
		$query = $pMonthQuery . " AND $femaleWhere ";
		$fMonthRes = pg_fetch_result($db2->query($query ,[]), 0, 0);
		$query = $pNewQuery . " AND $femaleWhere ";
		$fNewRes = pg_fetch_result($db2->query($query ,[]), 0, 0);
		$fDupRes = $fMonthRes - $fNewRes;
		$query = $pYearQuery . " AND $femaleWhere ";
		$fYearRes = pg_fetch_result($db2->query($query ,[]), 0, 0);
		
		#Age Where clauses
		$_20Where = "(date_part('year', AGE(dateofbirth)) <= 20)
				AND (date_part('year', AGE(dateofbirth)) <= 40)";
		$_41Where = "(date_part('year', AGE(dateofbirth)) <= 41)
				AND (date_part('year', AGE(dateofbirth)) <= 64)";
		$_65Where = "(date_part('year', AGE(dateofbirth)) >= 65)";
		
		#20-41 Queries
		$query = $pMonthQuery . " AND $_20Where ";
		$_20MonthRes = pg_fetch_result($db2->query($query ,[]), 0, 0);
		$query = $pNewQuery . " AND $_20Where ";
		$_20NewRes = pg_fetch_result($db2->query($query ,[]), 0, 0);
		$_20DupRes = $_20MonthRes - $_20NewRes;
		$query = $pYearQuery . " AND $_20Where ";
		$_20YearRes = pg_fetch_result($db2->query($query ,[]), 0, 0);
		
		#41-64 Queries
		$query = $pMonthQuery . " AND $_41Where ";
		$_41MonthRes = pg_fetch_result($db2->query($query ,[]), 0, 0);
		$query = $pNewQuery . " AND $_41Where ";
		$_41NewRes = pg_fetch_result($db2->query($query ,[]), 0, 0);
		$_41DupRes = $_41MonthRes - $_41NewRes;
		$query = $pYearQuery . " AND $_41Where ";
		$_41YearRes = pg_fetch_result($db2->query($query ,[]), 0, 0);
		
		#65+ Queries
		$query = $pMonthQuery . " AND $_65Where ";
		$_65MonthRes = pg_fetch_result($db2->query($query ,[]), 0, 0);
		$query = $pNewQuery . " AND $_65Where ";
		$_65NewRes = pg_fetch_result($db2->query($query ,[]), 0, 0);
		$_65DupRes = $_65MonthRes - $_65NewRes;
		$query = $pYearQuery . " AND $_65Where ";
		$_65YearRes = pg_fetch_result($db2->query($query ,[]), 0, 0);
		
		#Ethnicity Where clauses
		$afrAmWhere = " race = 'African American' ";
		$natAmWhere = " race = 'Native American' ";
		$pacIslWhere = " race = 'Pacific Islander' ";
		$caucWhere = " race = 'Caucasian' ";
		$multRacWhere = " race = 'Multi-Racial' ";
		$latWhere = " race = 'Latino' ";
		$otherRacWhere = " race = 'Other' ";
		
		#Caucasian Queries
		$query = $pMonthQuery . " AND $caucWhere ";
		$caucMonthRes = pg_fetch_result($db2->query($query ,[]), 0, 0);
		$query = $pNewQuery . " AND $caucWhere ";
		$caucNewRes = pg_fetch_result($db2->query($query ,[]), 0, 0);
		$caucDupRes = $caucMonthRes - $caucNewRes;
		$query = $pYearQuery . " AND $caucWhere ";
		$caucYearRes = pg_fetch_result($db2->query($query ,[]), 0, 0);
		
		#African American Queries
		$query = $pMonthQuery . " AND $afrAmWhere ";
		$afAmMonthRes = pg_fetch_result($db2->query($query ,[]), 0, 0);
		$query = $pNewQuery . " AND $afrAmWhere ";
		$afAmNewRes = pg_fetch_result($db2->query($query ,[]), 0, 0);
		$afAmDupRes = $afAmMonthRes - $afAmNewRes;
		$query = $pYearQuery . " AND $afrAmWhere ";
		$afAmYearRes = pg_fetch_result($db2->query($query ,[]), 0, 0);
		
		#Multi-Racial
		$query = $pMonthQuery . " AND $multRacWhere ";
		$multRacMonthRes = pg_fetch_result($db2->query($query ,[]), 0, 0);
		$query = $pNewQuery . " AND $multRacWhere ";
		$multRacNewRes = pg_fetch_result($db2->query($query ,[]), 0, 0);
		$multRacDupRes = $multRacMonthRes - $multRacNewRes;
		$query = $pYearQuery . " AND $multRacWhere ";
		$multRacYearRes = pg_fetch_result($db2->query($query ,[]), 0, 0);
		
		#Latino
		$query = $pMonthQuery . " AND $latWhere ";
		$latMonthRes = pg_fetch_result($db2->query($query ,[]), 0, 0);
		$query = $pNewQuery . " AND $latWhere ";
		$latNewRes = pg_fetch_result($db2->query($query ,[]), 0, 0);
		$latDupRes = $latMonthRes - $latNewRes;
		$query = $pYearQuery . " AND $latWhere ";
		$latYearRes = pg_fetch_result($db2->query($query ,[]), 0, 0);
		
		#Pacific Islander
		$query = $pMonthQuery . " AND $pacIslWhere ";
		$pacIslMonthRes = pg_fetch_result($db2->query($query ,[]), 0, 0);
		$query = $pNewQuery . " AND $pacIslWhere ";
		$pacIslNewRes = pg_fetch_result($db2->query($query ,[]), 0, 0);
		$pacIslDupRes = $pacIslMonthRes - $pacIslNewRes;
		$query = $pYearQuery . " AND $pacIslWhere ";
		$pacIslYearRes = pg_fetch_result($db2->query($query ,[]), 0, 0);

		#Native American
		$query = $pMonthQuery . " AND $natAmWhere ";
		$natAmMonthRes = pg_fetch_result($db2->query($query ,[]), 0, 0);
		$query = $pNewQuery . " AND $natAmWhere ";
		$natAmNewRes = pg_fetch_result($db2->query($query ,[]), 0, 0);
		$natAmDupRes = $natAmMonthRes - $natAmNewRes;
		$query = $pYearQuery . " AND $natAmWhere ";
		$natAmYearRes = pg_fetch_result($db2->query($query ,[]), 0, 0);	

		#Other Races
		$query = $pMonthQuery . " AND $otherRacWhere ";
		$otherRacMonthRes = pg_fetch_result($db2->query($query ,[]), 0, 0);
		$query = $pNewQuery . " AND $otherRacWhere ";
		$otherRacNewRes = pg_fetch_result($db2->query($query ,[]), 0, 0);
		$otherRacDupRes = $otherRacMonthRes - $otherRacNewRes;
		$query = $pYearQuery . " AND $otherRacWhere ";
		$otherRacYearRes = pg_fetch_result($db2->query($query ,[]), 0, 0);
		
		#Zip Codes
		$query = $pMonthQuery . " AND zipcode = 12501 ";
		$_12501MonthRes = pg_fetch_result($db2->query($query ,[]), 0, 0);
		$query = $pNewQuery . " AND zipcode = 12501 ";
		$_12501NewRes = pg_fetch_result($db2->query($query ,[]), 0, 0);
		$_12501DupRes = $_12501MonthRes - $_12501NewRes;
		$query = $pYearQuery . " AND zipcode = 12501 ";
		$_12501YearRes = pg_fetch_result($db2->query($query ,[]), 0, 0);
		
		$query = $pMonthQuery . " AND zipcode = 12504 ";
		$_12504MonthRes = pg_fetch_result($db2->query($query ,[]), 0, 0);
		$query = $pNewQuery . " AND zipcode = 12504 ";
		$_12504NewRes = pg_fetch_result($db2->query($query ,[]), 0, 0);
		$_12504DupRes = $_12504MonthRes - $_12504NewRes;
		$query = $pYearQuery . " AND zipcode = 12504 ";
		$_12504YearRes = pg_fetch_result($db2->query($query ,[]), 0, 0);
		
		$query = $pMonthQuery . " AND zipcode = 12506 ";
		$_12506MonthRes = pg_fetch_result($db2->query($query ,[]), 0, 0);
		$query = $pNewQuery . " AND zipcode = 12506 ";
		$_12506NewRes = pg_fetch_result($db2->query($query ,[]), 0, 0);
		$_12506DupRes = $_12506MonthRes - $_12506NewRes;
		$query = $pYearQuery . " AND zipcode = 12506 ";
		$_12506YearRes = pg_fetch_result($db2->query($query ,[]), 0, 0);
		
		$query = $pMonthQuery . " AND zipcode = 12507 ";
		$_12507MonthRes = pg_fetch_result($db2->query($query ,[]), 0, 0);
		$query = $pNewQuery . " AND zipcode = 12507 ";
		$_12507NewRes = pg_fetch_result($db2->query($query ,[]), 0, 0);
		$_12507DupRes = $_12507MonthRes - $_12507NewRes;
		$query = $pYearQuery . " AND zipcode = 12507 ";
		$_12507YearRes = pg_fetch_result($db2->query($query ,[]), 0, 0);
		
		$query = $pMonthQuery . " AND zipcode = 12508 ";
		$_12508MonthRes = pg_fetch_result($db2->query($query ,[]), 0, 0);
		$query = $pNewQuery . " AND zipcode = 12508 ";
		$_12508NewRes = pg_fetch_result($db2->query($query ,[]), 0, 0);
		$_12508DupRes = $_12508MonthRes - $_12508NewRes;
		$query = $pYearQuery . " AND zipcode = 12508 ";
		$_12508YearRes = pg_fetch_result($db2->query($query ,[]), 0, 0);
		
		$query = $pMonthQuery . " AND zipcode = 12514 ";
		$_12514MonthRes = pg_fetch_result($db2->query($query ,[]), 0, 0);
		$query = $pNewQuery . " AND zipcode = 12514 ";
		$_12514NewRes = pg_fetch_result($db2->query($query ,[]), 0, 0);
		$_12514DupRes = $_12514MonthRes - $_12514NewRes;
		$query = $pYearQuery . " AND zipcode = 12514 ";
		$_12514YearRes = pg_fetch_result($db2->query($query ,[]), 0, 0);
		
		$query = $pMonthQuery . " AND zipcode = 12522 ";
		$_12522MonthRes = pg_fetch_result($db2->query($query ,[]), 0, 0);
		$query = $pNewQuery . " AND zipcode = 12522 ";
		$_12522NewRes = pg_fetch_result($db2->query($query ,[]), 0, 0);
		$_12522DupRes = $_12522MonthRes - $_12522NewRes;
		$query = $pYearQuery . " AND zipcode = 12522 ";
		$_12522YearRes = pg_fetch_result($db2->query($query ,[]), 0, 0);
		
		$query = $pMonthQuery . " AND zipcode = 12524 ";
		$_12524MonthRes = pg_fetch_result($db2->query($query ,[]), 0, 0);
		$query = $pNewQuery . " AND zipcode = 12524 ";
		$_12524NewRes = pg_fetch_result($db2->query($query ,[]), 0, 0);
		$_12524DupRes = $_12524MonthRes - $_12524NewRes;
		$query = $pYearQuery . " AND zipcode = 12524 ";
		$_12524YearRes = pg_fetch_result($db2->query($query ,[]), 0, 0);
		
		$query = $pMonthQuery . " AND zipcode = 12531 ";
		$_12531MonthRes = pg_fetch_result($db2->query($query ,[]), 0, 0);
		$query = $pNewQuery . " AND zipcode = 12531 ";
		$_12531NewRes = pg_fetch_result($db2->query($query ,[]), 0, 0);
		$_12531DupRes = $_12531MonthRes - $_12531NewRes;
		$query = $pYearQuery . " AND zipcode = 12531 ";
		$_12531YearRes = pg_fetch_result($db2->query($query ,[]), 0, 0);
		
		$query = $pMonthQuery . " AND zipcode = 12533 ";
		$_12533MonthRes = pg_fetch_result($db2->query($query ,[]), 0, 0);
		$query = $pNewQuery . " AND zipcode = 12533 ";
		$_12533NewRes = pg_fetch_result($db2->query($query ,[]), 0, 0);
		$_12533DupRes = $_12533MonthRes - $_12533NewRes;
		$query = $pYearQuery . " AND zipcode = 12533 ";
		$_12533YearRes = pg_fetch_result($db2->query($query ,[]), 0, 0);
		
		$query = $pMonthQuery . " AND zipcode = 12537 ";
		$_12537MonthRes = pg_fetch_result($db2->query($query ,[]), 0, 0);
		$query = $pNewQuery . " AND zipcode = 12537 ";
		$_12537NewRes = pg_fetch_result($db2->query($query ,[]), 0, 0);
		$_12537DupRes = $_12537MonthRes - $_12537NewRes;
		$query = $pYearQuery . " AND zipcode = 12537 ";
		$_12537YearRes = pg_fetch_result($db2->query($query ,[]), 0, 0);
		
		$query = $pMonthQuery . " AND zipcode = 12538 ";
		$_12538MonthRes = pg_fetch_result($db2->query($query ,[]), 0, 0);
		$query = $pNewQuery . " AND zipcode = 12538 ";
		$_12538NewRes = pg_fetch_result($db2->query($query ,[]), 0, 0);
		$_12538DupRes = $_12538MonthRes - $_12538NewRes;
		$query = $pYearQuery . " AND zipcode = 12538 ";
		$_12538YearRes = pg_fetch_result($db2->query($query ,[]), 0, 0);
		
		$query = $pMonthQuery . " AND zipcode = 12540 ";
		$_12540MonthRes = pg_fetch_result($db2->query($query ,[]), 0, 0);
		$query = $pNewQuery . " AND zipcode = 12540 ";
		$_12540NewRes = pg_fetch_result($db2->query($query ,[]), 0, 0);
		$_12540DupRes = $_12540MonthRes - $_12540NewRes;
		$query = $pYearQuery . " AND zipcode = 12540 ";
		$_12540YearRes = pg_fetch_result($db2->query($query ,[]), 0, 0);
		
		$query = $pMonthQuery . " AND zipcode = 12545 ";
		$_12545MonthRes = pg_fetch_result($db2->query($query ,[]), 0, 0);
		$query = $pNewQuery . " AND zipcode = 12545 ";
		$_12545NewRes = pg_fetch_result($db2->query($query ,[]), 0, 0);
		$_12545DupRes = $_12545MonthRes - $_12545NewRes;
		$query = $pYearQuery . " AND zipcode = 12545 ";
		$_12545YearRes = pg_fetch_result($db2->query($query ,[]), 0, 0);
		
		$query = $pMonthQuery . " AND zipcode = 12546 ";
		$_12546MonthRes = pg_fetch_result($db2->query($query ,[]), 0, 0);
		$query = $pNewQuery . " AND zipcode = 12546 ";
		$_12546NewRes = pg_fetch_result($db2->query($query ,[]), 0, 0);
		$_12546DupRes = $_12546MonthRes - $_12546NewRes;
		$query = $pYearQuery . " AND zipcode = 12546 ";
		$_12546YearRes = pg_fetch_result($db2->query($query ,[]), 0, 0);
		
		$query = $pMonthQuery . " AND zipcode = 12564 ";
		$_12564MonthRes = pg_fetch_result($db2->query($query ,[]), 0, 0);
		$query = $pNewQuery . " AND zipcode = 12564 ";
		$_12564NewRes = pg_fetch_result($db2->query($query ,[]), 0, 0);
		$_12564DupRes = $_12564MonthRes - $_12564NewRes;
		$query = $pYearQuery . " AND zipcode = 12564 ";
		$_12564YearRes = pg_fetch_result($db2->query($query ,[]), 0, 0);
		
		$query = $pMonthQuery . " AND zipcode = 12567 ";
		$_12567MonthRes = pg_fetch_result($db2->query($query ,[]), 0, 0);
		$query = $pNewQuery . " AND zipcode = 12567 ";
		$_12567NewRes = pg_fetch_result($db2->query($query ,[]), 0, 0);
		$_12567DupRes = $_12567MonthRes - $_12567NewRes;
		$query = $pYearQuery . " AND zipcode = 12567 ";
		$_12567YearRes = pg_fetch_result($db2->query($query ,[]), 0, 0);
		
		$query = $pMonthQuery . " AND zipcode = 12569 ";
		$_12569MonthRes = pg_fetch_result($db2->query($query ,[]), 0, 0);
		$query = $pNewQuery . " AND zipcode = 12569 ";
		$_12569NewRes = pg_fetch_result($db2->query($query ,[]), 0, 0);
		$_12569DupRes = $_12569MonthRes - $_12569NewRes;
		$query = $pYearQuery . " AND zipcode = 12569 ";
		$_12569YearRes = pg_fetch_result($db2->query($query ,[]), 0, 0);
		
		$query = $pMonthQuery . " AND zipcode = 12570 ";
		$_12570MonthRes = pg_fetch_result($db2->query($query ,[]), 0, 0);
		$query = $pNewQuery . " AND zipcode = 12570 ";
		$_12570NewRes = pg_fetch_result($db2->query($query ,[]), 0, 0);
		$_12570DupRes = $_12570MonthRes - $_12570NewRes;
		$query = $pYearQuery . " AND zipcode = 12570 ";
		$_12570YearRes = pg_fetch_result($db2->query($query ,[]), 0, 0);
		
		$query = $pMonthQuery . " AND zipcode = 12571 ";
		$_12571MonthRes = pg_fetch_result($db2->query($query ,[]), 0, 0);
		$query = $pNewQuery . " AND zipcode = 12571 ";
		$_12571NewRes = pg_fetch_result($db2->query($query ,[]), 0, 0);
		$_12571DupRes = $_12571MonthRes - $_12571NewRes;
		$query = $pYearQuery . " AND zipcode = 12571 ";
		$_12571YearRes = pg_fetch_result($db2->query($query ,[]), 0, 0);
		
		$query = $pMonthQuery . " AND zipcode = 12572 ";
		$_12572MonthRes = pg_fetch_result($db2->query($query ,[]), 0, 0);
		$query = $pNewQuery . " AND zipcode = 12572 ";
		$_12572NewRes = pg_fetch_result($db2->query($query ,[]), 0, 0);
		$_12572DupRes = $_12572MonthRes - $_12572NewRes;
		$query = $pYearQuery . " AND zipcode = 12572 ";
		$_12572YearRes = pg_fetch_result($db2->query($query ,[]), 0, 0);
		
		$query = $pMonthQuery . " AND zipcode = 12574 ";
		$_12574MonthRes = pg_fetch_result($db2->query($query ,[]), 0, 0);
		$query = $pNewQuery . " AND zipcode = 12574 ";
		$_12574NewRes = pg_fetch_result($db2->query($query ,[]), 0, 0);
		$_12574DupRes = $_12574MonthRes - $_12574NewRes;
		$query = $pYearQuery . " AND zipcode = 12574 ";
		$_12574YearRes = pg_fetch_result($db2->query($query ,[]), 0, 0);
		
		$query = $pMonthQuery . " AND zipcode = 12578 ";
		$_12578MonthRes = pg_fetch_result($db2->query($query ,[]), 0, 0);
		$query = $pNewQuery . " AND zipcode = 12578 ";
		$_12578NewRes = pg_fetch_result($db2->query($query ,[]), 0, 0);
		$_12578DupRes = $_12578MonthRes - $_12578NewRes;
		$query = $pYearQuery . " AND zipcode = 12578 ";
		$_12578YearRes = pg_fetch_result($db2->query($query ,[]), 0, 0);
		
		$query = $pMonthQuery . " AND zipcode = 12580 ";
		$_12580MonthRes = pg_fetch_result($db2->query($query ,[]), 0, 0);
		$query = $pNewQuery . " AND zipcode = 12580 ";
		$_12580NewRes = pg_fetch_result($db2->query($query ,[]), 0, 0);
		$_12580DupRes = $_12580MonthRes - $_12580NewRes;
		$query = $pYearQuery . " AND zipcode = 12580 ";
		$_12580YearRes = pg_fetch_result($db2->query($query ,[]), 0, 0);
		
		$query = $pMonthQuery . " AND zipcode = 12581 ";
		$_12581MonthRes = pg_fetch_result($db2->query($query ,[]), 0, 0);
		$query = $pNewQuery . " AND zipcode = 12581 ";
		$_12581NewRes = pg_fetch_result($db2->query($query ,[]), 0, 0);
		$_12581DupRes = $_12581MonthRes - $_12581NewRes;
		$query = $pYearQuery . " AND zipcode = 12581 ";
		$_12581YearRes = pg_fetch_result($db2->query($query ,[]), 0, 0);
		
		$query = $pMonthQuery . " AND zipcode = 12582 ";
		$_12582MonthRes = pg_fetch_result($db2->query($query ,[]), 0, 0);
		$query = $pNewQuery . " AND zipcode = 12582 ";
		$_12582NewRes = pg_fetch_result($db2->query($query ,[]), 0, 0);
		$_12582DupRes = $_12582MonthRes - $_12582NewRes;
		$query = $pYearQuery . " AND zipcode = 12582 ";
		$_12582YearRes = pg_fetch_result($db2->query($query ,[]), 0, 0);
		
		$query = $pMonthQuery . " AND zipcode = 12583 ";
		$_12583MonthRes = pg_fetch_result($db2->query($query ,[]), 0, 0);
		$query = $pNewQuery . " AND zipcode = 12583 ";
		$_12583NewRes = pg_fetch_result($db2->query($query ,[]), 0, 0);
		$_12583DupRes = $_12583MonthRes - $_12583NewRes;
		$query = $pYearQuery . " AND zipcode = 12583 ";
		$_12583YearRes = pg_fetch_result($db2->query($query ,[]), 0, 0);
		
		$query = $pMonthQuery . " AND zipcode = 12585 ";
		$_12585MonthRes = pg_fetch_result($db2->query($query ,[]), 0, 0);
		$query = $pNewQuery . " AND zipcode = 12585 ";
		$_12585NewRes = pg_fetch_result($db2->query($query ,[]), 0, 0);
		$_12585DupRes = $_12585MonthRes - $_12585NewRes;
		$query = $pYearQuery . " AND zipcode = 12585 ";
		$_12585YearRes = pg_fetch_result($db2->query($query ,[]), 0, 0);
		
		$query = $pMonthQuery . " AND zipcode = 12590 ";
		$_12590MonthRes = pg_fetch_result($db2->query($query ,[]), 0, 0);
		$query = $pNewQuery . " AND zipcode = 12590 ";
		$_12590NewRes = pg_fetch_result($db2->query($query ,[]), 0, 0);
		$_12590DupRes = $_12590MonthRes - $_12590NewRes;
		$query = $pYearQuery . " AND zipcode = 12590 ";
		$_12590YearRes = pg_fetch_result($db2->query($query ,[]), 0, 0);
		
		$query = $pMonthQuery . " AND zipcode = 12592 ";
		$_12592MonthRes = pg_fetch_result($db2->query($query ,[]), 0, 0);
		$query = $pNewQuery . " AND zipcode = 12592 ";
		$_12592NewRes = pg_fetch_result($db2->query($query ,[]), 0, 0);
		$_12592DupRes = $_12592MonthRes - $_12592NewRes;
		$query = $pYearQuery . " AND zipcode = 12592 ";
		$_12592YearRes = pg_fetch_result($db2->query($query ,[]), 0, 0);
		
		$query = $pMonthQuery . " AND zipcode = 12594 ";
		$_12594MonthRes = pg_fetch_result($db2->query($query ,[]), 0, 0);
		$query = $pNewQuery . " AND zipcode = 12594 ";
		$_12594NewRes = pg_fetch_result($db2->query($query ,[]), 0, 0);
		$_12594DupRes = $_12594MonthRes - $_12594NewRes;
		$query = $pYearQuery . " AND zipcode = 12594 ";
		$_12594YearRes = pg_fetch_result($db2->query($query ,[]), 0, 0);
		
		$query = $pMonthQuery . " AND zipcode = 12601 ";
		$_12601MonthRes = pg_fetch_result($db2->query($query ,[]), 0, 0);
		$query = $pNewQuery . " AND zipcode = 12601 ";
		$_12601NewRes = pg_fetch_result($db2->query($query ,[]), 0, 0);
		$_12601DupRes = $_12601MonthRes - $_12601NewRes;
		$query = $pYearQuery . " AND zipcode = 12601 ";
		$_12601YearRes = pg_fetch_result($db2->query($query ,[]), 0, 0);
		
		$query = $pMonthQuery . " AND zipcode = 12602 ";
		$_12602MonthRes = pg_fetch_result($db2->query($query ,[]), 0, 0);
		$query = $pNewQuery . " AND zipcode = 12602 ";
		$_12602NewRes = pg_fetch_result($db2->query($query ,[]), 0, 0);
		$_12602DupRes = $_12602MonthRes - $_12602NewRes;
		$query = $pYearQuery . " AND zipcode = 12602 ";
		$_12602YearRes = pg_fetch_result($db2->query($query ,[]), 0, 0);
		
		$query = $pMonthQuery . " AND zipcode = 12603 ";
		$_12603MonthRes = pg_fetch_result($db2->query($query ,[]), 0, 0);
		$query = $pNewQuery . " AND zipcode = 12603 ";
		$_12603NewRes = pg_fetch_result($db2->query($query ,[]), 0, 0);
		$_12603DupRes = $_12603MonthRes - $_12603NewRes;
		$query = $pYearQuery . " AND zipcode = 12603 ";
		$_12603YearRes = pg_fetch_result($db2->query($query ,[]), 0, 0);
		
		$query = $pMonthQuery . " AND zipcode = 12604 ";
		$_12604MonthRes = pg_fetch_result($db2->query($query ,[]), 0, 0);
		$query = $pNewQuery . " AND zipcode = 12604 ";
		$_12604NewRes = pg_fetch_result($db2->query($query ,[]), 0, 0);
		$_12604DupRes = $_12604MonthRes - $_12604NewRes;
		$query = $pYearQuery . " AND zipcode = 12604 ";
		$_12604YearRes = pg_fetch_result($db2->query($query ,[]), 0, 0);
		
		$otherZipWhere = "(zipcode <> 12501
							AND zipcode <> 12504
							AND zipcode <> 12506
							AND zipcode <> 12507
							AND zipcode <> 12508
							AND zipcode <> 12514
							AND zipcode <> 12522
							AND zipcode <> 12524
							AND zipcode <> 12531
							AND zipcode <> 12533
							AND zipcode <> 12537
							AND zipcode <> 12538
							AND zipcode <> 12540
							AND zipcode <> 12545
							AND zipcode <> 12546
							AND zipcode <> 12564
							AND zipcode <> 12567
							AND zipcode <> 12569
							AND zipcode <> 12570
							AND zipcode <> 12571
							AND zipcode <> 12572
							AND zipcode <> 12574
							AND zipcode <> 12578
							AND zipcode <> 12580
							AND zipcode <> 12581
							AND zipcode <> 12582
							AND zipcode <> 12583
							AND zipcode <> 12585
							AND zipcode <> 12590
							AND zipcode <> 12592
							AND zipcode <> 12594
							AND zipcode <> 12601
							AND zipcode <> 12602
							AND zipcode <> 12603
							AND zipcode <> 12604)";
		$query = $pMonthQuery . " AND $otherZipWhere";
		$otherMonthRes = pg_fetch_result($db2->query($query ,[]), 0, 0);
		$query = $pNewQuery . " AND $otherZipWhere";
		$otherNewRes = pg_fetch_result($db2->query($query ,[]), 0, 0);
		$otherDupRes = $otherMonthRes - $otherNewRes;
		$query = $pYearQuery . " AND $otherZipWhere";
		$otherYearRes = pg_fetch_result($db2->query($query ,[]), 0, 0);
		
		#Children Served Indirectly
		$baseQuery = "SELECT SUM(numchildren) FROM participantsenrolled
						WHERE participantid IN (
							SELECT DISTINCT(participantid) FROM participantsenrolled
							WHERE $yearWhere ";
		$query = $baseQuery . " AND $monthWhere); ";
		$numChildMonthRes = pg_fetch_result($db2->query($query ,[]), 0, 0);
		$query = $baseQuery . ");";
		$numChildYearRes = pg_fetch_result($db2->query($query ,[]), 0, 0);
		$query = $baseQuery . " AND $monthWhere AND $pNewWhere); ";
		$numChildNewRes = pg_fetch_result($db2->query($query ,[]), 0, 0);
		$numChildDupRes = $numChildMonthRes - $numChildNewRes;
		
	}
   ?>
<div class="container">
	<div class="container pt-5">
		<form action="" method="POST" autocomplete="on">
			<div class="row" style="margin-bottom: 1%">
				<div class="col">
					<div class="form-group">
						<select class="form-control" name="month" id="month">
							<option value="1">January</option>
							<option value="2">February</option>
							<option value="3">March</option>
							<option value="4">April</option>
							<option value="5">May</option>
							<option value="6">June</option>
							<option value="7">July</option>
							<option value="8">August</option>
							<option value="9">September</option>
							<option value="10">October</option>
							<option value="11">November</option>
							<option value="12">December</option>
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
	<div class="page-header">
		<div align="center">
			<h2><?php
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
				?> <?=$year?></h2>
		</div>
	</div>
	<br />
	<h5 class="text-center">
		Number Served
	</h5>
	<br />
	<table class="table table-hover">
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
					<?php if (isset($pMonthRes)) echo $pMonthRes; else echo "";?>
				</td>
				<td>
					<?php if (isset($pNewRes)) echo $pNewRes; else echo "";?>
				</td>
				<td>
					<?php if (isset($pDupRes)) echo $pDupRes; else echo "";?>
				</td>
				<td>
					<?php if (isset($pYearRes)) echo $pDupRes; else echo "";?>
				</td>
			</tr>
		</tbody>
	</table>
	<br />
	<h5 class="text-center">
		Demographics of Adults
	</h5>
	<br />
	<h6 class="text-center">
		Gender
	</h6>
	<table class="table table-hover">
		<thead>
			<tr>
				<th>
				</th>
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
					<b>
               Male
               </b>
				</td>
				<td>
					<?php if (isset($mMonthRes)) echo $mMonthRes; else echo "";?>
				</td>
				<td>
					<?php if (isset($mNewRes)) echo $mNewRes; else echo "";?>
				</td>
				<td>
					<?php if (isset($mDupRes)) echo $mDupRes; else echo "";?>
				</td>
				<td>
					<?php if (isset($mYearRes)) echo $mYearRes; else echo "";?>
				</td>
			</tr>
			<tr>
				<td>
					<b>
               Female
               </b>
				</td>
				<td>
					<?php if (isset($fMonthRes)) echo $fMonthRes; else echo "";?>
				</td>
				<td>
					<?php if (isset($fNewRes)) echo $fNewRes; else echo "";?>
				</td>
				<td>
					<?php if (isset($fDupRes)) echo $fDupRes; else echo "";?>
				</td>
				<td>
					<?php if (isset($fYearRes)) echo $fYearRes; else echo "";?>
				</td>
			</tr>
		</tbody>
	</table>
	<br />
	<h6 class="text-center">
		Age
	</h6>
	<table class="table table-hover">
		<thead>
			<tr>
				<th>
				</th>
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
					<b>
               20-40
               </b>
				</td>
				<td>
					<?php if (isset($_20MonthRes)) echo $_20MonthRes; else echo "";?>
				</td>
				<td>
					<?php if (isset($_20NewRes)) echo $_20NewRes; else echo "";?>
				</td>
				<td>
					<?php if (isset($_20DupRes)) echo $_20DupRes; else echo "";?>
				</td>
				<td>
					<?php if (isset($_20YearRes)) echo $_20YearRes; else echo "";?>
				</td>
			</tr>
			<tr>
				<td>
					<b>
               41-64
               </b>
				</td>
				<td>
					<?php if (isset($_41MonthRes)) echo $_41MonthRes; else echo "";?>
				</td>
				<td>
					<?php if (isset($_41NewRes)) echo $_41NewRes; else echo "";?>
				</td>
				<td>
					<?php if (isset($_41DupRes)) echo $_41DupRes; else echo "";?>
				</td>
				<td>
					<?php if (isset($_41YearRes)) echo $_41YearRes; else echo "";?>
				</td>
				</td>
			</tr>
			<tr>
				<td>
					<b>
               65+
               </b>
				</td>
				<td>
					<?php if (isset($_65MonthRes)) echo $_65MonthRes; else echo "";?>
				</td>
				<td>
					<?php if (isset($_65NewRes)) echo $_65NewRes; else echo "";?>
				</td>
				<td>
					<?php if (isset($_65DupRes)) echo $_65DupRes; else echo "";?>
				</td>
				<td>
					<?php if (isset($_65YearRes)) echo $_65YearRes; else echo "";?>
				</td>
			</tr>
		</tbody>
	</table>
	<br />
	<h6 class="text-center">
		Ethnicity
	</h6>
	<table class="table table-hover">
		<thead>
			<tr>
				<th>
				</th>
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
					<b>
               Caucasian
               </b>
				</td>
				<td>
					<?php if (isset($caucMonthRes)) echo $caucMonthRes; else echo "";?>
				</td>
				<td>
					<?php if (isset($caucNewRes)) echo $caucNewRes; else echo "";?>
				</td>
				<td>
					<?php if (isset($caucDupRes)) echo $caucDupRes; else echo "";?>
				</td>
				<td>
					<?php if (isset($caucYearRes)) echo $caucYearRes; else echo "";?>
				</td>
			</tr>
			<tr>
				<td>
					<b>
               African American
               </b>
				</td>
					<td>
					<?php if (isset($afAmMonthRes)) echo $afAmMonthRes; else echo "";?>
				</td>
				<td>
					<?php if (isset($afAmNewRes)) echo $afAmNewRes; else echo "";?>
				</td>
				<td>
					<?php if (isset($afAmDupRes)) echo $afAmDupRes; else echo "";?>
				</td>
				<td>
					<?php if (isset($afAmYearRes)) echo $afAmYearRes; else echo "";?>
				</td>
			</tr>
			<tr>
				<td>
					<b>
               Multi Racial
               </b>
				</td>
					<td>
					<?php if (isset($multRacMonthRes)) echo $multRacMonthRes; else echo "";?>
				</td>
				<td>
					<?php if (isset($multRacNewRes)) echo $multRacNewRes; else echo "";?>
				</td>
				<td>
					<?php if (isset($multRacDupRes)) echo $multRacDupRes; else echo "";?>
				</td>
				<td>
					<?php if (isset($multRacYearRes)) echo $multRacYearRes; else echo "";?>
				</td>
			</tr>
			<tr>
				<td>
					<b>
               Latino
               </b>
				</td>
				<td>
					<?php if (isset($latMonthRes)) echo $latMonthRes; else echo "";?>
				</td>
				<td>
					<?php if (isset($latNewRes)) echo $latNewRes; else echo "";?>
				</td>
				<td>
					<?php if (isset($latDupRes)) echo $latDupRes; else echo "";?>
				</td>
				<td>
					<?php if (isset($latYearRes)) echo $latYearRes; else echo "";?>
				</td>
			</tr>
			<tr>
				<td>
					<b>
               Pacific Islander
               </b>
				</td>
				<td>
					<?php if (isset($pacIslMonthRes)) echo $pacIslMonthRes; else echo "";?>
				</td>
				<td>
					<?php if (isset($pacIslNewRes)) echo $pacIslNewRes; else echo "";?>
				</td>
				<td>
					<?php if (isset($pacIslDupRes)) echo $pacIslDupRes; else echo "";?>
				</td>
				<td>
					<?php if (isset($pacIslYearRes)) echo $pacIslYearRes; else echo "";?>
				</td>
			</tr>
			<tr>
				<td>
					<b>
               Native American
               </b>
				</td>
				<td>
					<?php if (isset($natAmMonthRes)) echo $natAmMonthRes; else echo "";?>
				</td>
				<td>
					<?php if (isset($natAmNewRes)) echo $natAmNewRes; else echo "";?>
				</td>
				<td>
					<?php if (isset($natAmDupRes)) echo $natAmDupRes; else echo "";?>
				</td>
				<td>
					<?php if (isset($natAmYearRes)) echo $natAmYearRes; else echo "";?>
				</td>
			</tr>
			<tr>
				<td>
					<b>
               Other
               </b>
				</td>
				<td>
					<?php if (isset($otherRacMonthRes)) echo $otherRacMonthRes; else echo "";?>
				</td>
				<td>
					<?php if (isset($otherRacNewRes)) echo $otherRacNewRes; else echo "";?>
				</td>
				<td>
					<?php if (isset($otherRacDupRes)) echo $otherRacDupRes; else echo "";?>
				</td>
				<td>
					<?php if (isset($otherRacYearRes)) echo $otherRacYearRes; else echo "";?>
				</td>
			</tr>
		</tbody>
	</table>
	<br />
	<h5 class="text-center">
		Zip Code Data
	</h5>
	<h6 class="text-center">
		For use by PSP, ISP, TLC, & CAC only
	</h6>
	<table class="table table-hover">
		<thead>
			<tr>
				<th>
					Zip
				</th>
				<th>
					Town
				</th>
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
					<b>
               12501 
               </b>
				</td>
				<td>
					<b>
               Amenia
               </b>
				</td>
				<td>
					<?php if (isset($_12501MonthRes)) echo $_12501MonthRes; else echo "";?>
				</td>
				<td>
					<?php if (isset($_12501NewRes)) echo $_12501NewRes; else echo "";?>
				</td>
				<td>
					<?php if (isset($_12501DupRes)) echo $_12501DupRes; else echo "";?>
				</td>
				<td>
					<?php if (isset($_12501YearRes)) echo $_12501YearRes; else echo "";?>
				</td>
			</tr>
			<tr>
				<td>
					<b>
               12504
               </b>
				</td>
				<td>
					<b>
               Annandale
               </b>
				</td>
				<td>
					<?php if (isset($_12504MonthRes)) echo $_12504MonthRes; else echo "";?>
				</td>
				<td>
					<?php if (isset($_12504NewRes)) echo $_12504NewRes; else echo "";?>
				</td>
				<td>
					<?php if (isset($_12504DupRes)) echo $_12504DupRes; else echo "";?>
				</td>
				<td>
					<?php if (isset($_12504YearRes)) echo $_12504YearRes; else echo "";?>
				</td>
			</tr>
			<tr>
				<td>
					<b>
               12506
               </b>
				</td>
				<td>
					<b>
               Bangall
               </b>
				</td>
				<td>
					<?php if (isset($_12506MonthRes)) echo $_12506MonthRes; else echo "";?>
				</td>
				<td>
					<?php if (isset($_12506NewRes)) echo $_12506NewRes; else echo "";?>
				</td>
				<td>
					<?php if (isset($_12506DupRes)) echo $_12506DupRes; else echo "";?>
				</td>
				<td>
					<?php if (isset($_12506YearRes)) echo $_12506YearRes; else echo "";?>
				</td>
			</tr>
			<tr>
				<td>
					<b>
               12507
               </b>
				</td>
				<td>
					<b>
               Barrytown
               </b>
				</td>
				<td>
					<?php if (isset($_12507MonthRes)) echo $_12507MonthRes; else echo "";?>
				</td>
				<td>
					<?php if (isset($_12507NewRes)) echo $_12507NewRes; else echo "";?>
				</td>
				<td>
					<?php if (isset($_12507DupRes)) echo $_12507DupRes; else echo "";?>
				</td>
				<td>
					<?php if (isset($_12507YearRes)) echo $_12507YearRes; else echo "";?>
				</td>
			</tr>
			<tr>
				<td>
					<b>
               12508
               </b>
				</td>
				<td>
					<b>
               Beacon
               </b>
				</td>
				<td>
					<?php if (isset($_12508MonthRes)) echo $_12508MonthRes; else echo "";?>
				</td>
				<td>
					<?php if (isset($_12508NewRes)) echo $_12508NewRes; else echo "";?>
				</td>
				<td>
					<?php if (isset($_12508DupRes)) echo $_12508DupRes; else echo "";?>
				</td>
				<td>
					<?php if (isset($_12508YearRes)) echo $_12508YearRes; else echo "";?>
				</td>
			</tr>
			<tr>
				<td>
					<b>
               12514
               </b>
				</td>
				<td>
					<b>
               Clinton Corners
               </b>
				</td>
				<td>
					<?php if (isset($_12514MonthRes)) echo $_12514MonthRes; else echo "";?>
				</td>
				<td>
					<?php if (isset($_12514NewRes)) echo $_12514NewRes; else echo "";?>
				</td>
				<td>
					<?php if (isset($_12514DupRes)) echo $_12514DupRes; else echo "";?>
				</td>
				<td>
					<?php if (isset($_12514YearRes)) echo $_12514YearRes; else echo "";?>
				</td>
			</tr>
			<tr>
				<td>
					<b>
               12522
               </b>
				</td>
				<td>
					<b>
               Dover Plains
               </b>
				</td>
				<td>
					<?php if (isset($_12522MonthRes)) echo $_12522MonthRes; else echo "";?>
				</td>
				<td>
					<?php if (isset($_12522NewRes)) echo $_12522NewRes; else echo "";?>
				</td>
				<td>
					<?php if (isset($_12522DupRes)) echo $_12522DupRes; else echo "";?>
				</td>
				<td>
					<?php if (isset($_12522YearRes)) echo $_12522YearRes; else echo "";?>
				</td>
			</tr>
			<tr>
				<td>
					<b>
               12524
               </b>
				</td>
				<td>
					<b>
               Fishkill
               </b>
				</td>
				<td>
					<?php if (isset($_12524MonthRes)) echo $_12524MonthRes; else echo "";?>
				</td>
				<td>
					<?php if (isset($_12524NewRes)) echo $_12524NewRes; else echo "";?>
				</td>
				<td>
					<?php if (isset($_12524DupRes)) echo $_12524DupRes; else echo "";?>
				</td>
				<td>
					<?php if (isset($_12524YearRes)) echo $_12524YearRes; else echo "";?>
				</td>
			</tr>
			<tr>
				<td>
					<b>
               12531
               </b>
				</td>
				<td>
					<b>
               Holmes
               </b>
				</td>
				<td>
					<?php if (isset($_12531MonthRes)) echo $_12531MonthRes; else echo "";?>
				</td>
				<td>
					<?php if (isset($_12531NewRes)) echo $_12531NewRes; else echo "";?>
				</td>
				<td>
					<?php if (isset($_12531DupRes)) echo $_12531DupRes; else echo "";?>
				</td>
				<td>
					<?php if (isset($_12531YearRes)) echo $_12531YearRes; else echo "";?>
				</td>
			</tr>
			<tr>
				<td>
					<b>
               12533
               </b>
				</td>
				<td>
					<b>
               Hopewell Junction
               </b>
				</td>
				<td>
					<?php if (isset($_12533MonthRes)) echo $_12533MonthRes; else echo "";?>
				</td>
				<td>
					<?php if (isset($_12533NewRes)) echo $_12533NewRes; else echo "";?>
				</td>
				<td>
					<?php if (isset($_12533DupRes)) echo $_12533DupRes; else echo "";?>
				</td>
				<td>
					<?php if (isset($_12533YearRes)) echo $_12533YearRes; else echo "";?>
				</td>
			</tr>
			<tr>
				<td>
					<b>
               12537
               </b>
				</td>
				<td>
					<b>
               Hughsonville
               </b>
				</td>
				<td>
					<?php if (isset($_12537MonthRes)) echo $_12537MonthRes; else echo "";?>
				</td>
				<td>
					<?php if (isset($_12537NewRes)) echo $_12537NewRes; else echo "";?>
				</td>
				<td>
					<?php if (isset($_12537DupRes)) echo $_12537DupRes; else echo "";?>
				</td>
				<td>
					<?php if (isset($_12537YearRes)) echo $_12537YearRes; else echo "";?>
				</td>
			</tr>
			<tr>
				<td>
					<b>
               12538
               </b>
				</td>
				<td>
					<b>
               Hyde Park
               </b>
				</td>
				<td>
					<?php if (isset($_12538MonthRes)) echo $_12538MonthRes; else echo "";?>
				</td>
				<td>
					<?php if (isset($_12538NewRes)) echo $_12538NewRes; else echo "";?>
				</td>
				<td>
					<?php if (isset($_12538DupRes)) echo $_12538DupRes; else echo "";?>
				</td>
				<td>
					<?php if (isset($_12538YearRes)) echo $_12538YearRes; else echo "";?>
				</td>
			</tr>
			<tr>
				<td>
					<b>
               12540
               </b>
				</td>
				<td>
					<b>
               LaGrangeville
               </b>
				</td>
				<td>
					<?php if (isset($_12540MonthRes)) echo $_12540MonthRes; else echo "";?>
				</td>
				<td>
					<?php if (isset($_12540NewRes)) echo $_12540NewRes; else echo "";?>
				</td>
				<td>
					<?php if (isset($_12540DupRes)) echo $_12540DupRes; else echo "";?>
				</td>
				<td>
					<?php if (isset($_12540YearRes)) echo $_12540YearRes; else echo "";?>
				</td>
			</tr>
			<tr>
				<td>
					<b>
               12545
               </b>
				</td>
				<td>
					<b>
               Millbrook
               </b>
				</td>
				<td>
					<?php if (isset($_12545MonthRes)) echo $_12545MonthRes; else echo "";?>
				</td>
				<td>
					<?php if (isset($_12545NewRes)) echo $_12545NewRes; else echo "";?>
				</td>
				<td>
					<?php if (isset($_12545DupRes)) echo $_12545DupRes; else echo "";?>
				</td>
				<td>
					<?php if (isset($_12545YearRes)) echo $_12545YearRes; else echo "";?>
				</td>
			</tr>
			<tr>
				<td>
					<b>
               12546
               </b>
				</td>
				<td>
					<b>
               Millerton
               </b>
				</td>
				<td>
					<?php if (isset($_12546MonthRes)) echo $_12546MonthRes; else echo "";?>
				</td>
				<td>
					<?php if (isset($_12546NewRes)) echo $_12546NewRes; else echo "";?>
				</td>
				<td>
					<?php if (isset($_12546DupRes)) echo $_12546DupRes; else echo "";?>
				</td>
				<td>
					<?php if (isset($_12546YearRes)) echo $_12546YearRes; else echo "";?>
				</td>
			</tr>
			<tr>
				<td>
					<b>
               12564
               </b>
				</td>
				<td>
					<b>
               Pawling
               </b>
				</td>
				<td>
					<?php if (isset($_12564MonthRes)) echo $_12564MonthRes; else echo "";?>
				</td>
				<td>
					<?php if (isset($_12564NewRes)) echo $_12564NewRes; else echo "";?>
				</td>
				<td>
					<?php if (isset($_12564DupRes)) echo $_12564DupRes; else echo "";?>
				</td>
				<td>
					<?php if (isset($_12564YearRes)) echo $_12564YearRes; else echo "";?>
				</td>
			</tr>
			<tr>
				<td>
					<b>
               12567
               </b>
				</td>
				<td>
					<b>
               Pine Plains
               </b>
				</td>
				<td>
					<?php if (isset($_12567MonthRes)) echo $_12567MonthRes; else echo "";?>
				</td>
				<td>
					<?php if (isset($_12567NewRes)) echo $_12567NewRes; else echo "";?>
				</td>
				<td>
					<?php if (isset($_12567DupRes)) echo $_12567DupRes; else echo "";?>
				</td>
				<td>
					<?php if (isset($_12567YearRes)) echo $_12567YearRes; else echo "";?>
				</td>
			</tr>
			<tr>
				<td>
					<b>
               12569
               </b>
				</td>
				<td>
					<b>
               Pleasant Valley
               </b>
				</td>
				<td>
					<?php if (isset($_12569MonthRes)) echo $_12569MonthRes; else echo "";?>
				</td>
				<td>
					<?php if (isset($_12569NewRes)) echo $_12569NewRes; else echo "";?>
				</td>
				<td>
					<?php if (isset($_12569DupRes)) echo $_12569DupRes; else echo "";?>
				</td>
				<td>
					<?php if (isset($_12569YearRes)) echo $_12569YearRes; else echo "";?>
				</td>
			</tr>
			<tr>
				<td>
					<b>
               12570
               </b>
				</td>
				<td>
					<b>
               Poughquag
               </b>
				</td>
				<td>
					<?php if (isset($_12570MonthRes)) echo $_12570MonthRes; else echo "";?>
				</td>
				<td>
					<?php if (isset($_12570NewRes)) echo $_12570NewRes; else echo "";?>
				</td>
				<td>
					<?php if (isset($_12570DupRes)) echo $_12570DupRes; else echo "";?>
				</td>
				<td>
					<?php if (isset($_12570YearRes)) echo $_12570YearRes; else echo "";?>
				</td>
			</tr>
			<tr>
				<td>
					<b>
               12571
               </b>
				</td>
				<td>
					<b>
               Red Hook
               </b>
				</td>
				<td>
					<?php if (isset($_12571MonthRes)) echo $_12571MonthRes; else echo "";?>
				</td>
				<td>
					<?php if (isset($_12571NewRes)) echo $_12571NewRes; else echo "";?>
				</td>
				<td>
					<?php if (isset($_12571DupRes)) echo $_12571DupRes; else echo "";?>
				</td>
				<td>
					<?php if (isset($_12571YearRes)) echo $_12571YearRes; else echo "";?>
				</td>
			</tr>
			<tr>
				<td>
					<b>
               12572
               </b>
				</td>
				<td>
					<b>
               Rhinebeck
               </b>
				</td>
				<td>
					<?php if (isset($_12572MonthRes)) echo $_12572MonthRes; else echo "";?>
				</td>
				<td>
					<?php if (isset($_12572NewRes)) echo $_12572NewRes; else echo "";?>
				</td>
				<td>
					<?php if (isset($_12572DupRes)) echo $_12572DupRes; else echo "";?>
				</td>
				<td>
					<?php if (isset($_12572YearRes)) echo $_12572YearRes; else echo "";?>
				</td>
			</tr>
			<tr>
				<td>
					<b>
               12574
               </b>
				</td>
				<td>
					<b>
               Rhinecliff
               </b>
				</td>
				<td>
					<?php if (isset($_12574MonthRes)) echo $_12574MonthRes; else echo "";?>
				</td>
				<td>
					<?php if (isset($_12574NewRes)) echo $_12574NewRes; else echo "";?>
				</td>
				<td>
					<?php if (isset($_12574DupRes)) echo $_12574DupRes; else echo "";?>
				</td>
				<td>
					<?php if (isset($_12574YearRes)) echo $_12574YearRes; else echo "";?>
				</td>
			</tr>
			<tr>
				<td>
					<b>
               12578
               </b>
				</td>
				<td>
					<b>
               Salt Point
               </b>
				</td>
				<td>
					<?php if (isset($_12578MonthRes)) echo $_12578MonthRes; else echo "";?>
				</td>
				<td>
					<?php if (isset($_12578NewRes)) echo $_12578NewRes; else echo "";?>
				</td>
				<td>
					<?php if (isset($_12578DupRes)) echo $_12578DupRes; else echo "";?>
				</td>
				<td>
					<?php if (isset($_12578YearRes)) echo $_12578YearRes; else echo "";?>
				</td>
			</tr>
			<tr>
				<td>
					<b>
               12580
               </b>
				</td>
				<td>
					<b>
               Staatsburg
               </b>
				</td>
				<td>
					<?php if (isset($_12580MonthRes)) echo $_12580MonthRes; else echo "";?>
				</td>
				<td>
					<?php if (isset($_12580NewRes)) echo $_12580NewRes; else echo "";?>
				</td>
				<td>
					<?php if (isset($_12580DupRes)) echo $_12580DupRes; else echo "";?>
				</td>
				<td>
					<?php if (isset($_12580YearRes)) echo $_12580YearRes; else echo "";?>
				</td>
			</tr>
			<tr>
				<td>
					<b>
               12581
               </b>
				</td>
				<td>
					<b>
               Standfordville
               </b>
				</td>
				<td>
					<?php if (isset($_12581MonthRes)) echo $_12581MonthRes; else echo "";?>
				</td>
				<td>
					<?php if (isset($_12581NewRes)) echo $_12581NewRes; else echo "";?>
				</td>
				<td>
					<?php if (isset($_12581DupRes)) echo $_12581DupRes; else echo "";?>
				</td>
				<td>
					<?php if (isset($_12581YearRes)) echo $_12581YearRes; else echo "";?>
				</td>
			</tr>
			<tr>
				<td>
					<b>
               12582
               </b>
				</td>
				<td>
					<b>
               Stormville
               </b>
				</td>
				<td>
					<?php if (isset($_12582MonthRes)) echo $_12582MonthRes; else echo "";?>
				</td>
				<td>
					<?php if (isset($_12582NewRes)) echo $_12582NewRes; else echo "";?>
				</td>
				<td>
					<?php if (isset($_12582DupRes)) echo $_12582DupRes; else echo "";?>
				</td>
				<td>
					<?php if (isset($_12582YearRes)) echo $_12582YearRes; else echo "";?>
				</td>
			</tr>
			<tr>
				<td>
					<b>
               12583
               </b>
				</td>
				<td>
					<b>
               Tivoli
               </b>
				</td>
				<td>
					<?php if (isset($_12583MonthRes)) echo $_12583MonthRes; else echo "";?>
				</td>
				<td>
					<?php if (isset($_12583NewRes)) echo $_12583NewRes; else echo "";?>
				</td>
				<td>
					<?php if (isset($_12583DupRes)) echo $_12583DupRes; else echo "";?>
				</td>
				<td>
					<?php if (isset($_12583YearRes)) echo $_12583YearRes; else echo "";?>
				</td>
			</tr>
			<tr>
				<td>
					<b>
               12585
               </b>
				</td>
				<td>
					<b>
               Verbank
               </b>
				</td>
				<td>
					<?php if (isset($_12585MonthRes)) echo $_12585MonthRes; else echo "";?>
				</td>
				<td>
					<?php if (isset($_12585NewRes)) echo $_12585NewRes; else echo "";?>
				</td>
				<td>
					<?php if (isset($_12585DupRes)) echo $_12585DupRes; else echo "";?>
				</td>
				<td>
					<?php if (isset($_12585YearRes)) echo $_12585YearRes; else echo "";?>
				</td>
			</tr>
			<tr>
				<td>
					<b>
               12590
               </b>
				</td>
				<td>
					<b>
               Wappingers Falls
               </b>
				</td>
				<td>
					<?php if (isset($_12590MonthRes)) echo $_12590MonthRes; else echo "";?>
				</td>
				<td>
					<?php if (isset($_12590NewRes)) echo $_12590NewRes; else echo "";?>
				</td>
				<td>
					<?php if (isset($_12590DupRes)) echo $_12590DupRes; else echo "";?>
				</td>
				<td>
					<?php if (isset($_12590YearRes)) echo $_12590YearRes; else echo "";?>
				</td>
			</tr>
			<tr>
				<td>
					<b>
               12592
               </b>
				</td>
				<td>
					<b>
               Wassaic
               </b>
				</td>
				<td>
					<?php if (isset($_12592MonthRes)) echo $_12592MonthRes; else echo "";?>
				</td>
				<td>
					<?php if (isset($_12592NewRes)) echo $_12592NewRes; else echo "";?>
				</td>
				<td>
					<?php if (isset($_12592DupRes)) echo $_12592DupRes; else echo "";?>
				</td>
				<td>
					<?php if (isset($_12592YearRes)) echo $_12592YearRes; else echo "";?>
				</td>
			</tr>
			<tr>
				<td>
					<b>
               12594
               </b>
				</td>
				<td>
					<b>
               Wingdale
               </b>
				</td>
				<td>
					<?php if (isset($_12594MonthRes)) echo $_12594MonthRes; else echo "";?>
				</td>
				<td>
					<?php if (isset($_12594NewRes)) echo $_12594NewRes; else echo "";?>
				</td>
				<td>
					<?php if (isset($_12594DupRes)) echo $_12594DupRes; else echo "";?>
				</td>
				<td>
					<?php if (isset($_12594YearRes)) echo $_12594YearRes; else echo "";?>
				</td>
			</tr>
			<tr>
				<td>
					<b>
               12601
               </b>
				</td>
				<td>
					<b>
               City of Pok.
               </b>
				</td>
				<td>
					<?php if (isset($_12601MonthRes)) echo $_12601MonthRes; else echo "";?>
				</td>
				<td>
					<?php if (isset($_12601NewRes)) echo $_12601NewRes; else echo "";?>
				</td>
				<td>
					<?php if (isset($_12601DupRes)) echo $_12601DupRes; else echo "";?>
				</td>
				<td>
					<?php if (isset($_12601YearRes)) echo $_12601YearRes; else echo "";?>
				</td>
			</tr>
			<tr>
				<td>
					<b>
               12602
               </b>
				</td>
				<td>
					<b>
               Pok. P.O. Boxes
               </b>
				</td>
				<td>
					<?php if (isset($_12602MonthRes)) echo $_12602MonthRes; else echo "";?>
				</td>
				<td>
					<?php if (isset($_12602NewRes)) echo $_12602NewRes; else echo "";?>
				</td>
				<td>
					<?php if (isset($_12602DupRes)) echo $_12602DupRes; else echo "";?>
				</td>
				<td>
					<?php if (isset($_12602YearRes)) echo $_12602YearRes; else echo "";?>
				</td>
			</tr>
			<tr>
				<td>
					<b>
               12603
               </b>
				</td>
				<td>
					<b>
               Town of Pok.
               </b>
				</td>
				<td>
					<?php if (isset($_12603MonthRes)) echo $_12603MonthRes; else echo "";?>
				</td>
				<td>
					<?php if (isset($_12603NewRes)) echo $_12603NewRes; else echo "";?>
				</td>
				<td>
					<?php if (isset($_12603DupRes)) echo $_12603DupRes; else echo "";?>
				</td>
				<td>
					<?php if (isset($_12603YearRes)) echo $_12603YearRes; else echo "";?>
				</td>
			</tr>
			<tr>
				<td>
					<b>
               12604
               </b>
				</td>
				<td>
					<b>
               Town of Pok.
               </b>
				</td>
				<td>
					<?php if (isset($_12604MonthRes)) echo $_12604MonthRes; else echo "";?>
				</td>
				<td>
					<?php if (isset($_12604NewRes)) echo $_12604NewRes; else echo "";?>
				</td>
				<td>
					<?php if (isset($_12604DupRes)) echo $_12604DupRes; else echo "";?>
				</td>
				<td>
					<?php if (isset($_12604YearRes)) echo $_12604YearRes; else echo "";?>
				</td>
			</tr>
			<tr>
				<td>
					<b>
               </b>
				</td>
				<td>
					<b>
               Other
               </b>
				</td>
				<td>
					<?php if (isset($otherMonthRes)) echo $otherMonthRes; else echo "";?>
				</td>
				<td>
					<?php if (isset($otherNewRes)) echo $otherNewRes; else echo "";?>
				</td>
				<td>
					<?php if (isset($otherDupRes)) echo $otherDupRes; else echo "";?>
				</td>
				<td>
					<?php if (isset($otherYearRes)) echo $otherYearRes; else echo "";?>
				</td>	
			</tr>
		</tbody>
	</table>
	<h5 class="text-center pt-4 pb-2">
		Parenting Services
	</h5>
	<table class="table table-hover">
		<thead>
			<tr>
				<th>
				</th>
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
					<b>Children Served Indirectly</b>
				</td>
				<td>
					<?php if (isset($numChildMonthRes)) echo $numChildMonthRes; else echo "";?>
				</td>
				<td>
					<?php if (isset($numChildNewRes)) echo $numChildNewRes; else echo "";?>
				</td>
				<td>
					<?php if (isset($numChildDupRes)) echo $numChildDupRes; else echo "";?>
				</td>
				<td>
					<?php if (isset($numChildYearRes)) echo $numChildYearRes; else echo "";?>
				</td>
			</tr>
		</tbody>
	</table>
</div>
<script>
	const MIN_YEAR = 2010;

	window.onload = initPage;

	function initPage() {
		var d = new Date();
		var monthElem = document.getElementById("month");
		monthElem.selectedIndex = d.getMonth();
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