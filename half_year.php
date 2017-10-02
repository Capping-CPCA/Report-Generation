<?php 
authorizedPage();

global $params, $route, $view;


include('header.php'); 
?>
		
<div class="container">
	<div class="container pt-5">
		<h1 class="text-center">6-Month Reports</h1>
	</div>
	<div class="container pt-5 pb-4">
		<div class="row">
			<div class="col" align="right">
				<div class="dropdown">
					<button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					Half
					</button>
					<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
					<a class="dropdown-item" href="#">First 6 Months</a>
					<a class="dropdown-item" href="#">Second 6 Months</a>
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
		
	<div class="container py-3">
		<table class="table table-active">
			<thead>
				
			</thead>
			<tbody>
			<tr>
				<th scope="row">Total # of clients served during the year (unduplicated)</td>
				<td>2100</td>
			</tr>
			</tbody>
		</table>
	</div>
		
	<div class="container pb-2">
		<h3 class="text-center">Survey Results</h3>
	</div>
	
	<div class="container">
		<table class="table ">
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
				<td>95%</td>
				<td>945</td>
				<td>996</td>
			</tr>
			<tr>
				<td scope="row">Plan on using specific techniques discussed in class</td>
				<td>98%</td>
				<td>965</td>
				<td>996</td>
			</tr>
			<tr>
				<td scope="row">Realized other parents share the same concerns</td>
				<td>97%</td>
				<td>974</td>
				<td>996</td>
			</tr>
			<tr>
				<td scope="row">Understand children have different perspectives than they do</td>
				<td>96%</td>
				<td>955</td>
				<td>996</td>
			</tr>
			</tbody>
		</table>
	</div>
	
		<div class="container py-3">
		<h3 class="text-center">Target Outcome</h3>
	</div>
	
	<div class="container">
		<table class="table">
			<thead>
			<tr>
				<th>Questions</th>
				<th>Projected % in Favor</th>
				<th>Projected # in Favor</th>
			</tr>
			</thead>
			<tbody>
			<tr>
				<td scope="row">Have an increased knowledge of the topics</td>
				<td>90%</td>
				<td>1890</td>
			</tr>
			<tr>
				<td scope="row">Plan on using specific techniques discussed in class</td>
				<td>80%</td>
				<td>1680</td>
			</tr>
			<tr>
				<td scope="row">Realized other parents share the same concerns</td>
				<td>70%</td>
				<td>1470</td>
			</tr>
			<tr>
				<td scope="row">Understand children have different perspectives than they do</td>
				<td>90%</td>
				<td>1890</td>
			</tr>
			</tbody>
		</table>
	</div>
</div>

<?php include('footer.php'); ?>