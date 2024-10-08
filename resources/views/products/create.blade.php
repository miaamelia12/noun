@extends('layout.app')
@section('subheader')
<div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
    <div class="d-flex align-items-center flex-wrap mr-2">
        <!--begin::Page Title-->
        <h4 class="text-dark font-weight-bold mt-2 mb-2 mr-5">Add New Product</h5>
        <!--end::Page Title-->
    </div>
    <div class="d-flex align-items-center flex-wrap mr-2">
        <div class="card-toolbar">
            <button class="btn btn-success mr-2 " type="button" id="btn-submit"><i class="fas fa-save"></i>Submit</button>
        </div>
    </div>
</div>

@endsection
@section('content')
<style>
    .text-area{
        overflow: hidden;
        overflow-wrap: break-word;
        resize: none;
        box-sizing: border-box;
        border-radius: 6px;
        background-color: white;
        box-shadow: 1px 1px #f5f5f5;
    }
    .form-group{
        justify-content: center;
        margin-bottom: 20px !important;
    }
    .text{
        display: inline-block;
        margin-bottom: 3px !important;
        font-size: 14px bold !important;
        font-weight: bold;
    }
    .form-text{
       font-size: 13px !important;
    }
</style>
<form class="form" role="form" action="javascript:" id="form-input">
        {{ csrf_field() }}
    <div class="card card-custom gutter-b">
        <!--begin::Header-->
        <div class="card-header">
            <h3 class="card-title">
                <i class="flaticon2-line-chart text-success mr-2 bold"></i>
                <span class="card-label font-weight-bolder text-dark">Product</span>
            </h3>
        </div>
        <!--end::Header-->
        <!--begin::Card Body-->
        <div class="card-body">
            <input type="hidden" id="id" name="id" value=""/>
            <div class="form-group row">
                <div class="col-lg-6">
                    <label class="text">Name</label>
                    <input type="text" id="name" name="name" class="form-control required"/>
                    <span class="form-text text-muted">Please enter name of product</span>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-lg-6">
                    <label class="text">Description</label>
                    <textarea class="form-control text-area required" id="description" name="description" rows="3" ></textarea>
                    <span class="form-text text-muted">Please enter description of product</span>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-lg-6">
                    <label class="text">Price</label>
                    <input type="text" id="price" name="price" class="form-control required"/>
                    <span class="form-text text-muted">Please enter price of product</span>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-lg-6">
                <label class="text">Qty</label>
                        <input type="text" id="qty" class="form-control " name="qty" placeholder="0"/>
                    <span class="form-text text-muted">Please enter quantity of product</span>

                </div>
            </div>
        </div>
        <!--end::Card Body-->
    </div>
</form>
@endsection

@section('contentjs')
<script type="text/javascript">
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

jQuery(document).ready(function() {
    // init val after plugins
    @if(isset($data))
    $('#id').val('{{  $data->id }}');
    $('#name').val('{{ $data->name }}').trigger('change');
    $('#description').val('{{ $data->description }}');
    $('#price').val(`{{ $data->price }}`);
    $('#qty').val('{{ $data->qty }}');
    @endif
    @if(old('name'))
    $('#id').val('{{ old('id') }}');
    $('#name').val('{{ old('name') }}');
    $('#description').val('{{ old('description') }}');
    $('#price').val('{{ old('price') }}');
    $('#qty').val('{{ old('qty') }}');
    @endif

    $('#price').inputmask({
        alias: 'numeric',
        groupSeparator: ',',
        autoGroup: true,
        digits: 0,
        rightAlign: false
    });

    $('#btn-submit').click(function() {
        var isValid = true;
        $.each($('.required'), function() {
            isValid &= $(this).val() !== '';
        });
        if (isValid) {
            $.ajax({
                url: '{{ url('products/save') }}',
                type: 'POST',
                data: $('#form-input').serialize(),
                success: function(response) {
                    console.log(response);

                    swal.fire({
                        title: "Success",
                        text: "Product saved successfully!",
                        icon: "success",
                        confirmButtonText: "OK"
                    }).then(() => {
                        window.location.href = '{{ url("products") }}';
                    });
                },
                error: function(xhr, status, error) {
                    console.error(error);

                    swal.fire({
                        title: "Error",
                        text: xhr.responseJSON.message || "Something went wrong!",
                        icon: "error",
                        confirmButtonText: "OK"
                    });
                }
            });
        } else {
            swal.fire({
                title: "Warning",
                text: "Please check your input..!",
                icon: "warning",
                confirmButtonText: "OK"
            });
        }
    });
});
</script>
@endsection
