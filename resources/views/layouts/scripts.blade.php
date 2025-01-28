{{--  Adding JS  --}}
<script type="text/javascript" charset="utf8" src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
<script>
    $(document).ready(function() {
        $('#datatable').DataTable({
            paging: false,
            searching: true,
            info: false,
            ordering: true,
            lengthChange: false,
            language: {
                paginate: {
                    next: '&raquo; Next', // Next arrow
                    previous: 'Previous &laquo;' // Previous arrow
                }
            }
        });
    });
</script>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script>
    function copyToClipboard(id) {
        const copyText = document.getElementById(id);
        navigator.clipboard.writeText(copyText.value).then(() => {
            alert('Copied to clipboard!');
        });
    }
</script>

<script src="{{ URL::asset('Web/Dashboard/assets/js/bootstrap-datatables/en/jquery.dataTables.min.js') }}"></script>
<script src="{{ URL::asset('Web/Dashboard/assets/js/bootstrap-datatables/en/dataTables.bootstrap4.min.js') }}"></script>



<script src="{{ URL::asset('Web/Dashboard/assets/js/jquery-3.3.1.min.js') }}"></script>
<script src="{{ URL::asset('Web/Dashboard/assets/js/plugins-jquery.js') }}"></script>
<script type="text/javascript">
    var plugin_path = "{{ asset('Web/Dashboard/assets/js') }}/";
</script>
<script src="{{ URL::asset('Web/Dashboard/assets/js/chart-init.js') }}"></script>
<script src="{{ URL::asset('Web/Dashboard/assets/js/calendar.init.js') }}"></script>
<script src="{{ URL::asset('Web/Dashboard/assets/js/sparkline.init.js') }}"></script>
<script src="{{ URL::asset('Web/Dashboard/assets/js/morris.init.js') }}"></script>
<script src="{{ URL::asset('Web/Dashboard/assets/js/datepicker.js') }}"></script>
<script src="{{ URL::asset('Web/Dashboard/assets/js/sweetalert2.js') }}"></script>
<script src="{{ URL::asset('Web/Dashboard/assets/js/toastr.js') }}"></script>
<script src="{{ URL::asset('Web/Dashboard/assets/js/validation.js') }}"></script>
<script src="{{ URL::asset('Web/Dashboard/assets/js/lobilist.js') }}"></script>
<script src="{{ URL::asset('Web/Dashboard/assets/js/custom.js') }}"></script>
<script>
    $(document).ready(function() {
        $('#datatable').DataTable();
    });
</script>
<script src="{{ URL::asset('Web/Dashboard/assets/js/bootstrap-datatables/en/jquery.dataTables.min.js') }}"></script>
<script src="{{ URL::asset('Web/Dashboard/assets/js/bootstrap-datatables/en/dataTables.bootstrap4.min.js') }}">
@if (Session::has('message'))
    <script>
        toastr.options = {
                "closeButton": true,
                "progressBar": true
            }
        toastr.success("{{ session('message') }}");
    </script>
@endif

@if (Session::has('error'))
    <script>
        toastr.options = {
            "closeButton": true,
            "progressBar": true
        }
        toastr.error("{{ session('error') }}");
    </script>
@endif

@if (Session::has('info'))
    <script>
        toastr.options = {
            "closeButton": true,
            "progressBar": true
        }
        toastr.info("{{ session('info') }}");
    </script>
@endif

@if (Session::has('warning'))
    <script>
        toastr.options = {
            "closeButton": true,
            "progressBar": true
        }
        toastr.warning("{{ session('warning') }}");
    </script>
@endif


<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
