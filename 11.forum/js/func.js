<script src='js/jquerys/jquery.min.js'></script>
		<script>
				$(document).ready(function(){
					$('#sedit').click(function(){
						$('#ed').toggle();
					});
				});
				function checkDelete(){
					return confirm('Are you sure to delete?');
				};
				/*
				$(document).ready(function(){
					$('p').click(function(){
						alert('The paragraph was clicked.');
					});
				
				});
				*/
</script>