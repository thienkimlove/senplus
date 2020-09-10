<a  href="javascript:void(0)"
    onclick="addAdmin(this)"
    data-url="{{ url($crud->route.'/'.$entry->getKey().'/addAdmin') }}"
    class="btn btn-xs btn-tumblr"
    data-button-type="add-admin">
    <i class="fa fa-balance-scale"></i>Thêm Manager
</a>

<script>
    if (typeof addAdmin != 'function') {
        $("[data-button-type=add-admin]").unbind('click');
        function addAdmin(ele) {
            let url = $(ele).attr('data-url');
            let message = "Bạn có muốn thêm manager cho doanh nghiệp này?";
            // show confirm message
            if (confirm(message) === true) {
                window.location.href = url;
            }
        }
    }
</script>