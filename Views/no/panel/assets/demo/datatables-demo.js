/* // Call the dataTables jQuery plugin
$(document).ready(function() {
  $('#dataTable').DataTable();
});
 */

/* $(document).ready(function() {
  $('#dataTable').DataTable({
    "language": {
      "url": "//cdn.datatables.net/plug-ins/1.13.4/i18n/es-ES.json"
    },
    "columnDefs": [
      { "type": "num", "targets": 0 }]
  });
}); */

$(document).ready(function() {
  $('#dataTable').DataTable({
    "language": {
      "url": "//cdn.datatables.net/plug-ins/1.13.4/i18n/es-ES.json"
    },
    "pagingType": "full_numbers",
    "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "Todos"]],
    "columnDefs": [
      { "type": "num", "targets": 0 }],
    "responsive": true,
    "dom": '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>' +
               '<"row"<"col-sm-12"tr>>' +
               '<"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>',
  });
});
