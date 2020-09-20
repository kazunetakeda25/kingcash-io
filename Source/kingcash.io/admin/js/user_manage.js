var ajax_url_get_user_list =  'include/ajax_get_user_list.php';
var datatable_users = $('#datatable_users').DataTable( {
    "ajax": ajax_url_get_user_list
});
datatable_users
    .order( [ 0, 'asc' ] )
    .draw();