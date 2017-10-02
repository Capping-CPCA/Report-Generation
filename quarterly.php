<?php 
authorizedPage();

global $params, $route, $view;


include('header.php'); 
?>
		
<div class="container">
	<div class="container pt-5">
		<h1 class="text-center">Quarterly Reports</h1>
	</div>
	<div class="container pt-5 pb-4">
		<div class="row">
			<div class="col" align="right">
				<div class="dropdown">
					<button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					Quarter
					</button>
					<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
					<a class="dropdown-item" href="#">Q1</a>
					<a class="dropdown-item" href="#">Q2</a>
					<a class="dropdown-item" href="#">Q3</a>
					<a class="dropdown-item" href="#">Q4</a>
					</div>
				</div>
			</div>
			<div class="col" align="left">
				<div class="dropdown">
					<button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					Year
					</button>
					<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
					<a class="dropdown-item" href="#">2017</a>
					<a class="dropdown-item" href="#">2016</a>
					<a class="dropdown-item" href="#">2015</a>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	<div class="container py-2">
		<h3 class="text-center">Participant Totals</h3>
	</div>
	
	<div class="container pb-2">
		<table class="table">
			<thead>
			<tr>
				<th></th>
				<th>Quarter</th>
				<th>YTD</th>
			</tr>
			</thead>
			<tbody>
			<tr>
				<th scope="row">Adults Served (unduplicated)</th>
				<td>509</td>
				<td>509</td>
			</tr>
			<tr>
				<th scope="row">Children Represented (unduplicated)</th>
				<td>533</td>
				<td>728</td>
			</tr>
			</tbody>
		</table>
	</div>
	
	<div class="container py-2">
		<h3 class="text-center">Survey Results</h3>
	</div>
	
	<div class="container">
		<table class="table">
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
				<td>92%</td>
				<td>468</td>
				<td>509</td>
			</tr>
			<tr>
				<td scope="row">Plan on using specific techniques discussed in class</td>
				<td>93%</td>
				<td>473</td>
				<td>509</td>
			</tr>
			<tr>
				<td scope="row">Realized other parents share the same concerns</td>
				<td>93%</td>
				<td>473</td>
				<td>509</td>
			</tr>
			<tr>
				<td scope="row">Understand children have different perspectives than they do</td>
				<td>94%</td>
				<td>478</td>
				<td>509</td>
			</tr>
			</tbody>
		</table>
	</div>
</div>
		
		<?php include('footer.php'); ?>