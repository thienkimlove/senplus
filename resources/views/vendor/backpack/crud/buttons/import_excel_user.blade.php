<a  href="javascript:void(0)" onclick="importExcelUser(this)" data-url="{{ url($crud->route.'/'.$entry->getKey().'/importExcelUser') }}" class="btn btn-xs btn-default" data-button-type="import-excel-user"><i class="fa fa-balance-scale"></i>Upload Dữ Liệu Nhân Viên</a>

<script>
    if (typeof importExcelUser != 'function') {
        $("[data-button-type=import-excel-user]").unbind('click');
        function importExcelUser(ele) {
            let url = $(ele).attr('data-url');
            let message = "bạn có muốn cập nhật dữ liệu nhân viên cho doanh nghiệp này?";
            // show confirm message
            if (confirm(message) === true) {
                window.location.href = url;
            }
        }
    }
</script>