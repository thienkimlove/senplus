@if ($message = session()->get('general_message'))
   <div class="alert alert-info alert-block">
        <div class="alert-overlay"></div>
        <div class="content">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <strong>{{ $message }}</strong>
        </div>
    </div>
@endif