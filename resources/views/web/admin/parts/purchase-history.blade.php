@php
    $partId = 'pt-purchase-history';
@endphp

<div class="{{ $partId }} {{ $assignedId }}">
    <table class="table table-bordered pt-purchase-history-table"></table>
</div>

@push('scripts')
    <script type="text/javascript" src="{{ URL::asset('assets/web/admin/js/parts/purchase-history.js') }}"></script>
@endpush

