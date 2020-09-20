<script src="//code.jquery.com/jquery-1.12.4.js"></script>
<!-- <script src="assets/js/jquery.min.js"></script>  -->
<script src="assets/js/jquery.ui.custom.js"></script> 
<script src="assets/js/bootstrap.min.js"></script> 
<script src="js/jquery.dataTables.min.js"></script> 
<!-- <script src="assets/js/jquery.flot.min.js"></script>  -->
<!-- <script src="assets/js/jquery.flot.resize.min.js"></script>  -->
<script src="assets/js/jquery.peity.min.js"></script> 
<script src="assets/js/fullcalendar.min.js"></script> 
<!-- <script src="assets/js/matrix.js"></script>  -->
<!-- <script src="assets/js/matrix.dashboard.js"></script>  -->
<script src="assets/js/jquery.gritter.min.js"></script> 
<script src="assets/js/matrix.interface.js"></script> 
<script src="assets/js/matrix.chat.js"></script> 
<script src="assets/js/jquery.validate.js"></script> 
<!-- <script src="assets/js/matrix.form_validation.js"></script>  -->
<!-- <script src="assets/js/jquery.wizard.js"></script> 
<script src="assets/js/matrix.popover.js"></script>  -->
<script src="js/jquery.number.js"></script>
<script src="assets/plugin/phone/build/js/intlTelInput.js"></script>
<script type="text/javascript">
	$.ajax({
        url: 'include/ajax_get_summary.php',
        type: 'GET',
        dataType: 'json',
        success: function(data) {
        	console.log(data);
            $("#kcpusd").html(data['last_usd']);
        }
    });
</script>
