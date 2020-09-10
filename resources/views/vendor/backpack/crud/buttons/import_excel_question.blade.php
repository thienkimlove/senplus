<a  href="javascript:void(0)" onclick="importExcelQuestion(this)" data-url="{{ url($crud->route.'/'.$entry->getKey().'/importExcelQuestion') }}" class="btn btn-xs btn-instagram" data-button-type="import-excel-question"><i class="fa fa-balance-scale"></i>Upload Bộ Câu Hỏi</a>

<script>
    if (typeof importExcelQuestion != 'function') {
        $("[data-button-type=import-excel-question]").unbind('click');
        function importExcelQuestion(ele) {
            let url = $(ele).attr('data-url');
            let message = "bạn có muốn cập nhật bộ câu hỏi cho doanh nghiệp này?";
            // show confirm message
            if (confirm(message) === true) {
                window.location.href = url;
            }
        }
    }
</script>