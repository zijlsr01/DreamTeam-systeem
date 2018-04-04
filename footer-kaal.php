<script type="text/javascript" src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
		<script type="text/javascript" src="http://code.jquery.com/ui/1.11.0/jquery-ui.min.js"></script>
		<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/jquery-ui-timepicker-addon.js"></script>
		<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/jquery-ui-timepicker-addon-i18n.min.js"></script>
		<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/jquery-ui-sliderAccess.js"></script>
		<script>
		function myFunction() {
			confirm("Weet je zeker dat je deze activiteit wilt verwijderen?");
		}

		function myFunction2() {
			confirm("Weet je zeker dat je deze persoon uit de aanmeldlijst wilt verwijderen?");
		}
		</script>

		<script type="text/javascript">
			
			$(function(){

					$('#startTijd').timepicker({
					timeOnlyTitle: 'Kies een starttijd',
					timeText: 'Tijd',
					hourText: 'Uren',
					minuteText: 'Minuten',
					secondText: 'Seconden',
					currentText: 'Huidige tijd',
					closeText: 'Bevestig'
				});

				$('#eindTijd').timepicker({
					timeOnlyTitle: 'Kies een eindtijd',
					timeText: 'Tijd',
					hourText: 'Uren',
					minuteText: 'Minuten',
					secondText: 'Seconden',
					currentText: 'Huidige tijd',
					closeText: 'Bevestig'
				});

				$('#datum').datepicker({
					timeOnlyTitle: 'Kies een starttijd',
					dateFormat: 'dd-mm-yy',
					timeText: 'Tijd',
					hourText: 'Uren',
					minuteText: 'Minuten',
					secondText: 'Seconden',
					currentText: 'Huidige tijd',
					closeText: 'Bevestig'
				});

	
				$('#deadline').datetimepicker({
					timeOnlyTitle: 'hh',
					dateFormat: 'dd-mm-yy',
					timeText: 'Tijd',
					hourText: 'Uren',
					minuteText: 'Minuten',
					secondText: 'Seconden',
					currentText: 'Huidige tijd',
					closeText: 'Bevestig'
				});




			var startDateTextBox = $('#range_example_1_start');
			var endDateTextBox = $('#range_example_1_end');



			startDateTextBox.datepicker({ 
				dateFormat: 'dd-mm-yy',
				onClose: function(dateText, inst) {
					if (endDateTextBox.val() != '') {
						var testStartDate = startDateTextBox.datetimepicker('getDate');
						var testEndDate = endDateTextBox.datetimepicker('getDate');
						if (testStartDate > testEndDate)
							endDateTextBox.datetimepicker('setDate', testStartDate);
					}
					else {
						endDateTextBox.val(dateText);
					}
				},
				onSelect: function (selectedDateTime){
					endDateTextBox.datetimepicker('option', 'minDate', startDateTextBox.datetimepicker('getDate') );
				}
			});
			endDateTextBox.datepicker({ 
				dateFormat: 'dd-mm-yy',
				onClose: function(dateText, inst) {
					if (startDateTextBox.val() != '') {
						var testStartDate = startDateTextBox.datetimepicker('getDate');
						var testEndDate = endDateTextBox.datetimepicker('getDate');
						if (testStartDate > testEndDate)
							startDateTextBox.datetimepicker('setDate', testEndDate);
					}
					else {
						startDateTextBox.val(dateText);
					}
				},
				onSelect: function (selectedDateTime){
					startDateTextBox.datetimepicker('option', 'maxDate', endDateTextBox.datetimepicker('getDate') );
				}
			});


			var startDateTextBox2 = $('#range_example_1_start2');
			var endDateTextBox2 = $('#range_example_1_end2');



			startDateTextBox2.datepicker({ 
				dateFormat: 'dd-mm-yy',
				onClose: function(dateText, inst) {
					if (endDateTextBox2.val() != '') {
						var testStartDate = startDateTextBox2.datetimepicker('getDate');
						var testEndDate = endDateTextBox2.datetimepicker('getDate');
						if (testStartDate > testEndDate)
							endDateTextBox2.datetimepicker('setDate', testStartDate);
					}
					else {
						endDateTextBox2.val(dateText);
					}
				},
				onSelect: function (selectedDateTime){
					endDateTextBox2.datetimepicker('option', 'minDate', startDateTextBox2.datetimepicker('getDate') );
				}
			});
			endDateTextBox2.datepicker({ 
				dateFormat: 'dd-mm-yy',
				onClose: function(dateText, inst) {
					if (startDateTextBox2.val() != '') {
						var testStartDate = startDateTextBox2.datetimepicker('getDate');
						var testEndDate = endDateTextBox2.datetimepicker('getDate');
						if (testStartDate > testEndDate)
							startDateTextBox2.datetimepicker('setDate', testEndDate);
					}
					else {
						startDateTextBox2.val(dateText);
					}
				},
				onSelect: function (selectedDateTime){
					startDateTextBox2.datetimepicker('option', 'maxDate', endDateTextBox2.datetimepicker('getDate') );
				}
			});




			$(window).load(function(){
			  setTimeout(function(){ $('#s6').fadeOut('slow') }, 4000);
			});

			});
			
			$( "#refresh" ).click(function() {
			$( "#layer" ).show( 10, function() {
			
			});
			});
			
		</script>		
</body>
</html>