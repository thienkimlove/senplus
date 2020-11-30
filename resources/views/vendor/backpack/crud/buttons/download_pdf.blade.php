@if (\App\Helpers::checkIfSurveyHaveAnyResult($entry))
<a  href="{{ url($crud->route.'/'.$entry->getKey().'/downloadPdf') }}" class="btn btn-xs btn-foursquare">
    <i class="fa fa-balance-scale"></i> Download PDF
</a>
@endif