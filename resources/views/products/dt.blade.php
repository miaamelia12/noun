@extends('layout.app')
@section('subheader')
<div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
    <!--begin::Info-->
    <div class="d-flex align-items-center flex-wrap mr-2">
        <!--begin::Page Title-->
        <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">&nbsp;</h5>
        <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
            <li class="breadcrumb-item text-muted">
                <a href="" class="text-muted">&nbsp;</a>
            </li>
        </ul>
        <!--end::Page Title-->
    </div>
    <!--end::Info-->
</div>
@endsection
@section('content')
    <style>
    .width-200{
        width:150px;
    }
    .dataTables_scroll {
        overflow: auto;
    }
    .button-container{
        display: flex;
        justify-content: flex-end;
        align-items: center;
    }
    </style>
<div class="card card-custom gutter-b">
    <!--begin::Header-->
    <div class="card-header">
        <div class="card-title">
            <h3 class="card-label">Products
            <span class="d-block text-muted pt-2 font-size-sm">List Products</span></h3>
        </div>
        <div class="card-toolbar">
            <a href="{{ url('products/create') }}" class="btn btn-success font-weight-bolder font-size-sm">
                <span class="svg-icon svg-icon-md svg-icon-white">
                    <i class="flaticon2-plus "></i>
                </span>New Product</a>
        </div>
    </div>
    <!--end::Header-->
    <!--begin::Body-->
    <div class="card-body pt-0 pb-3">
        &nbsp;
        <div class="tab-content">
            <!--begin::Table-->
            <div class="table-responsive">
                <table class="table table-bordered dataTable no-footer dataTables_scroll" id="datatable">
                    <thead class="thead-light">
                        <tr>
                            <th class="text-center">Name</th>
                            <th class="text-center">Description</th>
                            <th class="text-center">Price</th>
                            <th class="text-center">Qty</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
            <!--end::Table-->
        </div>

        &nbsp;
    </div>

    <!--end::Body-->
    <div class="card-footer">
    </div>
</div>
@endsection

@section('contentjs')

<script type="text/javascript">
jQuery(document).ready(function() {
    // init plugins
    var oTable = $('#datatable').DataTable({
        processing      : true,
        serverSide      : true,
        lengthChange    : false,
        responsive      : true,
        scrollY         : 500,
        ajax            : {
            url: '{{ url("products/dt") }}'
        },
        columns         : [
            { data: 'name', name: 'name'},
            { data: 'description', name: 'description'},
            { data: 'price', name: 'price'},
            { data: 'qty', name: 'qty'},
        ],
        columnDefs: [
            {
                render: function (data, type, full, meta) {
                    return "<div class='text-wrap'>" + data + "</div>";
                },
                targets: [ 0,1,2,3,4 ]
            }
        ],
        sDom            : 'ltipr',
        pageLength      : 25,
        order           : [],
        drawCallback    : function(settings) {
            $('a[data-toggle="tooltip"]', this.api().table().container()).tooltip({ container : 'body' });
        }
    });
    oTable = $('#datatable').DataTable();
});
</script>
@endsection
