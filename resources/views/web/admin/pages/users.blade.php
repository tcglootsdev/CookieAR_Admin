@extends('web.admin.parts.layout')

@push('styles')
    <link href="{{ URL::asset('assets/web/admin/plugins/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
@endpush

@section('content')
    <div class="toolbar" id="kt_toolbar">
        <div class="container-fluid d-flex flex-stack flex-wrap flex-sm-nowrap">
            <div class="d-flex flex-column align-items-start justify-content-center flex-wrap me-2">
                <h1 class="text-gray-900 fw-bold my-1 fs-2">Users</h1>
            </div>
        </div>
    </div>
    <div class="post fs-6 d-flex flex-column-fluid" id="kt_post">
        <div class="container-xxl">
            <div class="row g-xl-8">
                <div class="card">
                    <div class="card-body">
                        <table class="table table-bordered gy-5 gs-7 pg-users-table"></table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('modals')
    @include('web.admin.parts.modals.purchase-history', ['assignedId' => 'pg-users-modal-purchase-history'])
@endpush

@push('scripts')
    <script type="text/javascript" src="{{ URL::asset('assets/web/admin/plugins/datatables/datatables.bundle.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('assets/web/admin/js/pages/users.js') }}"></script>
@endpush
