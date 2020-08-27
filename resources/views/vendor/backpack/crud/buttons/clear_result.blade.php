<a  href="javascript:void(0)" onclick="clearResult(this)" data-url="{{ url($crud->route.'/'.$entry->getKey().'/clear') }}" class="btn btn-xs btn-default" data-button-type="clear"><i class="fa fa-balance-scale"></i>Xóa kết quả</a>

<script>
    if (typeof clearResult != 'function') {
        $("[data-button-type=clear]").unbind('click');
        function clearResult(ele) {
            let clear_url = $(ele).attr('data-url');
            let message = "bạn có muốn Xóa kết quả cho tài khoản này?";
            // show confirm message
            if (confirm(message) === true) {
                window.location.href = clear_url;
            }
        }
    }
</script>
