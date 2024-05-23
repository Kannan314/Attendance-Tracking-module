// Call the dataTables jQuery plugin
$(document).ready(function() {
    $('#dataTable').DataTable();
    $('#dataTable').find('td').addClass('p-1 align-middle')
    $('#dataTable').find('td:nth-child(1)').addClass('text-center')
});