@php
    $partId = 'pt-modal-purchase-history';
@endphp

<div class="modal fade {{ $partId }} {{ $assignedId }}" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Purchase History</h3>
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                    <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                </div>
            </div>
            <div class="modal-body">
                @include('web.admin.parts.purchase-history', ['assignedId' => $partId.'-'.$assignedId.'-purchase-history'])
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script type="text/javascript" src="{{ URL::asset('assets/web/admin/js/parts/modals/purchase-history.js') }}"></script>
@endpush

