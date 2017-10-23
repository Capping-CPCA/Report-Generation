<?php
/**
 * PEP Capping 2017 Algozzine's Class
 *
 * Allows users to create a custom report.
 *
 * This page has a form that allows users to specify what
 * information they would like to see in a custom report.
 * The 'Generate Report' button will kick off a custom query
 * to the database and display the results in a new page
 * (defined in 'custom_reports_table.php')
 *
 * @author Daniel Ahl & Rafael Mormol
 * @copyright 2017 Marist College
 * @version 0.1.4.1
 * @since 0.1.4.1
 */
    authorizedPage();
    global $params, $route, $view;
    include('header.php');
    ?>
<div class="container py-5" >
    <form action="custom-reports-table" method="POST" style="margin-left: 30%" >
        <fieldset>
            <!-- Select Basic -->
            <div class="form-group row">
                <label class="col-md-2 col-form-label" for="month"><b>Month</b></label>
                <div class="col-md-4">
                    <select id="month" name="month" class="form-control">
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
            <!-- Select Basic -->
            <div class="form-group row">
                <label class="col-md-2 col-form-label" for="year"><b>Year</b></label>
                <div class="col-md-4">
                    <select id="year" name="year" class="form-control">
                        <option value="2017">2017</option>
                        <option value="2016">2016</option>
                        <option value="2015">2015</option>
                        <option value="2014">2014</option>
                        <option value="2013">2013</option>
                        <option value="2012">2012</option>
                        <option value="2011">2011</option>
                    </select>
                </div>
            </div>
            <!-- Multiple Checkboxes -->
            <div class="form-group row">
                <label class="col-md-2 col-form-label" for="location[]"><b>Location</b></label>
                <div class="col-md-4">
                    <div class="checkbox">
                        <label for="location-0">
                        <input type="checkbox" name="location[]" id="location-0" value="Cornerstone">
                        Cornerstone
                        </label>
                    </div>
                    <div class="checkbox">
                        <label for="location-1">
                        <input type="checkbox" name="location[]" id="location-1" value="Dutches County Jail">
                        Dutches County Jail
                        </label>
                    </div>
                    <div class="checkbox">
                        <label for="location-2">
                        <input type="checkbox" name="location[]" id="location-2" value="Florence Manor">
                        Florence Manor
                        </label>
                    </div>
                    <div class="checkbox">
                        <label for="location-3">
                        <input type="checkbox" name="location[]" id="location-3" value="Fox Run">
                        Fox Run
                        </label>
                    </div>
                    <div class="checkbox">
                        <label for="location-4">
                        <input type="checkbox" name="location[]" id="location-4" value="ITAP Meadow Run">
                        ITAP Meadow Run
                        </label>
                    </div>
                </div>
            </div>
            <!-- Multiple Checkboxes -->
            <div class="form-group row">
                <label class="col-md-2 col-form-label" for="race[]"><b>Race</b></label>
                <div class="col-md-4">
                    <div class="checkbox">
                        <label for="race-0">
                        <input type="checkbox" name="race[]" id="race-0" value="Caucasian">
                        Caucasian
                        </label>
                    </div>
                    <div class="checkbox">
                        <label for="race-1">
                        <input type="checkbox" name="race[]" id="race-1" value="African American">
                        African American
                        </label>
                    </div>
                    <div class="checkbox">
                        <label for="race-2">
                        <input type="checkbox" name="race[]" id="race-2" value="Multi-Racial">
                        Multi Racial
                        </label>
                    </div>
                    <div class="checkbox">
                        <label for="race-3">
                        <input type="checkbox" name="race[]" id="race-3" value="Latino">
                        Latino
                        </label>
                    </div>
                    <div class="checkbox">
                        <label for="race-4">
                        <input type="checkbox" name="race[]" id="race-4" value="Pacific Islander">
                        Pacific Islander
                        </label>
                    </div>
                    <div class="checkbox">
                        <label for="race-5">
                        <input type="checkbox" name="race[]" id="race-5" value="Native American">
                        Native American
                        </label>
                    </div>
                    <div class="checkbox">
                        <label for="race-6">
                        <input type="checkbox" name="race[]" id="race-6" value="Other">
                        Other
                        </label>
                    </div>
                </div>
            </div>
            <!-- Multiple Checkboxes -->
            <div class="form-group row">
                <label class="col-md-2 col-form-label"><b>Age</b></label>
					<div class="col-2">
						<select id="minAge" name="minAge" class="form-control" onchange="minAgeChange()">
							<option value="any">Any</option>
							<?php
								for ($i = 65; $i >= 18; $i--) {
									echo "<option value='$i'>$i</option>";
								}
							?>
						</select>
					</div>
					<div>
						<p>To</p>
					</div>
					<div class="col-2">
						<select id="maxAge" name="maxAge" class="form-control" onchange="maxAgeChange()">
							<option value="any">Any</option>
							<?php
								for ($i = 65; $i >= 18; $i--) {
									echo "<option value='$i'>$i</option>";
								}
							?>
						</select>
					</div>
				<!--
                <div class="col-md-4">
                    <div class="checkbox">
                        <label for="age-0">
                        <input type="checkbox" name="age[]" id="age-0" value="20-40">
                        20-40
                        </label>
                    </div>
                    <div class="checkbox">
                        <label for="age-1">
                        <input type="checkbox" name="age[]" id="age-1" value="41-64">
                        41-64
                        </label>
                    </div>
                    <div class="checkbox">
                        <label for="age-2">
                        <input type="checkbox" name="age[]" id="age-2" value="65">
                        65+
                        </label>
                    </div>
                </div>
				-->
            </div>
            <!-- Submit -->
            <div class="form-group">
                <div class="col-md-4">
                    <button type="submit" class="btn cpca">Generate Report</button>
                </div>
            </div>
        </fieldset>
    </form>
</div>
<script>
	function minAgeChange() {
		minIndex = document.getElementById("minAge").selectedIndex;
		maxList = document.getElementById("maxAge").options;
		if (minIndex === 0) {
			for (i = 1; i < maxList.length; i++) {
				maxList[i].disabled = false;
			}
		} else {
			for (i = 1; i < maxList.length; i++) {
				maxList[i].disabled = i >= minIndex;
			}
		}
	}
	function maxAgeChange() {
		maxIndex = document.getElementById("maxAge").selectedIndex;
		minList = document.getElementById("minAge").options;
		for (i = 1; i < minList.length; i++) {
			minList[i].disabled = i <= maxIndex;
		}
	}
</script>
<?php include('footer.php'); ?>