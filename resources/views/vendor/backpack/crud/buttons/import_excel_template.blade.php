<a  href="javascript:void(0)" onclick="importExcelTemplate(this)" data-url="{{ url($crud->route.'/'.$entry->getKey().'/importExcelTemplate') }}" class="btn btn-xs btn-foursquare" data-button-type="import-excel-temlate"><i class="fa fa-balance-scale"></i>Upload Câu Hỏi</a>

<script>
    if (typeof importExcelTemplate != 'function') {
        $("[data-button-type=import-excel-temlate]").unbind('click');
        function importExcelTemplate(ele) {
            let url = $(ele).attr('data-url');
            let message = "bạn có muốn cập nhật dữ liệu câu hỏi cho bộ mẫu này?";
            // show confirm message
            if (confirm(message) === true) {
                window.location.href = url;
            }
        }
    }
</script>