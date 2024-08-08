@extends('layouts.master')
@section('css')
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">الفاتورة</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ معلومات الفاتورة</span>
            </div>
        </div>
        <div class="d-flex my-xl-auto right-content">

            <div class="mb-3 mb-xl-0">
                <div class="btn-group dropdown">

                    <div class="dropdown-menu dropdown-menu-left" aria-labelledby="dropdownMenuDate"
                        data-x-placement="bottom-end">
                        <a class="dropdown-item" href="#">2015</a>
                        <a class="dropdown-item" href="#">2016</a>
                        <a class="dropdown-item" href="#">2017</a>
                        <a class="dropdown-item" href="#">2018</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif


    @if (session()->has('delete'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>{{ session()->get('delete') }}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

        @if (session()->has('Add'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>{{ session()->get('Add') }}</strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        <!-- row -->
        <div class="row">
            <div class="row row-sm">

                <div class="col-xl-14">
                    <!-- div -->
                    <div class="card mg-b-20" id="tabs-style2">
                        <div class="card-body">
                            {{-- <div class="text-wrap">
                                <div class="example"> --}}
                                    <div class="panel panel-primary tabs-style-2">
                                        <div class=" tab-menu-heading">

                                        </div>
                                        <div class="panel-body tabs-menu-body main-content-body-right border-top-0 border">
                                            <div class="tab-content">
                                                <div class="tab-pane active" id="tab1">
                                                    <!--div-->

                                                    <div class="card mg-b-20" id="tabs-style2">
                                                        <div class="card-body">
                                                            <div class="text-wrap">
                                                                <div class="example">
                                                                    <div class="panel panel-primary tabs-style-2">
                                                                        <div class=" tab-menu-heading">
                                                                            <div class="tabs-menu1">
                                                                                <!-- Tabs -->
                                                                                <ul class="nav panel-tabs main-nav-line">
                                                                                    <li><a href="#tab4"
                                                                                            class="nav-link active"
                                                                                            data-toggle="tab">معلومات
                                                                                            الفاتورة</a></li>
                                                                                    <li><a href="#tab5" class="nav-link"
                                                                                            data-toggle="tab">حالات
                                                                                            الدفع</a>
                                                                                    </li>
                                                                                </ul>
                                                                            </div>
                                                                        </div>
                                                                        <div
                                                                            class="panel-body tabs-menu-body main-content-body-right border">
                                                                            <div class="tab-content">


                                                                                <div class="tab-pane active" id="tab4">
                                                                                    <div class="table-responsive mt-15">

                                                                                        <table class="table table-striped"
                                                                                            style="text-align:center">
                                                                                            <tbody>
                                                                                                <tr>
                                                                                                    <th scope="row">رقم
                                                                                                        الفاتورة</th>
                                                                                                    <td>{{ $invoices->invoice_number }}
                                                                                                    </td>
                                                                                                    <th scope="row">تاريخ
                                                                                                        الاصدار</th>
                                                                                                    <td>{{ $invoices->invoice_Date }}
                                                                                                    </td>
                                                                                                    <th scope="row">تاريخ
                                                                                                        الاستحقاق</th>
                                                                                                    <td>{{ $invoices->Due_date }}
                                                                                                    </td>
                                                                                                    <th scope="row">القسم
                                                                                                    </th>
                                                                                                    <td>{{ $invoices->Section->section_name }}
                                                                                                    </td>
                                                                                                </tr>

                                                                                                <tr>
                                                                                                    <th scope="row">
                                                                                                        المنتج
                                                                                                    </th>
                                                                                                    <td>{{ $invoices->prodect }}
                                                                                                    </td>
                                                                                                    <th scope="row">مبلغ
                                                                                                        التحصيل</th>
                                                                                                    <td>{{ $invoices->Amount_collection }}
                                                                                                    </td>
                                                                                                    <th scope="row">مبلغ
                                                                                                        العمولة</th>
                                                                                                    <td>{{ $invoices->Amount_Commission }}
                                                                                                    </td>
                                                                                                    <th scope="row">الخصم
                                                                                                    </th>
                                                                                                    <td>{{ $invoices->Discount }}
                                                                                                    </td>
                                                                                                </tr>


                                                                                                <tr>
                                                                                                    <th scope="row">نسبة
                                                                                                        الضريبة</th>
                                                                                                    <td>{{ $invoices->Rate_VAT }}
                                                                                                    </td>
                                                                                                    <th scope="row">قيمة
                                                                                                        الضريبة</th>
                                                                                                    <td>{{ $invoices->Value_VAT }}
                                                                                                    </td>
                                                                                                    <th scope="row">
                                                                                                        الاجمالي
                                                                                                        مع الضريبة</th>
                                                                                                    <td>{{ $invoices->Total }}
                                                                                                    </td>
                                                                                                    <th scope="row">
                                                                                                        الحالة
                                                                                                        الحالية</th>

                                                                                                    @if ($invoices->Value_Status == 1)
                                                                                                        <td><span
                                                                                                                class="badge badge-pill badge-success">{{ $invoices->Status }}</span>
                                                                                                        </td>
                                                                                                    @elseif($invoices->Value_Status == 2)
                                                                                                        <td><span
                                                                                                                class="badge badge-pill badge-danger">{{ $invoices->Status }}</span>
                                                                                                        </td>
                                                                                                    @else
                                                                                                        <td><span
                                                                                                                class="badge badge-pill badge-warning">{{ $invoices->Status }}</span>
                                                                                                        </td>
                                                                                                    @endif
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <th scope="row">
                                                                                                        ملاحظات
                                                                                                    </th>
                                                                                                    <td>{{ $invoices->note }}
                                                                                                    </td>
                                                                                                </tr>
                                                                                            </tbody>
                                                                                        </table>

                                                                                    </div>
                                                                                </div>

                                                                                <div class="tab-pane" id="tab5">
                                                                                    <div class="table-responsive mt-15">
                                                                                        <table
                                                                                            class="table center-aligned-table mb-0 table-hover"
                                                                                            style="text-align:center">
                                                                                            <thead>
                                                                                                <tr class="text-dark">
                                                                                                    <th>#</th>
                                                                                                    <th>رقم الفاتورة</th>
                                                                                                    <th>نوع المنتج</th>
                                                                                                    <th>القسم</th>
                                                                                                    <th>حالة الدفع</th>
                                                                                                    <th>تاريخ الدفع </th>
                                                                                                    <th>ملاحظات</th>
                                                                                                    <th>تاريخ الاضافة </th>
                                                                                                    <th>المستخدم</th>
                                                                                                </tr>
                                                                                            </thead>
                                                                                            <tbody>
                                                                                                <?php $i = 0; ?>
                                                                                                @foreach ($details as $x)
                                                                                                    <?php $i++; ?>
                                                                                                    <tr>
                                                                                                        <td>{{ 1 }}
                                                                                                        </td>
                                                                                                        <td>{{ $x->invoice_number }}
                                                                                                        </td>
                                                                                                        <td>{{ $x->product }}
                                                                                                        </td>
                                                                                                        <td>{{ $invoices->Section->section_name }}
                                                                                                        </td>
                                                                                                        @if ($x->Value_Status == 1)
                                                                                                            <td><span
                                                                                                                    class="badge badge-pill badge-success">{{ $x->Status }}</span>
                                                                                                            </td>
                                                                                                        @elseif($x->Value_Status == 2)
                                                                                                            <td><span
                                                                                                                    class="badge badge-pill badge-danger">{{ $x->Status }}</span>
                                                                                                            </td>
                                                                                                        @else
                                                                                                            <td><span
                                                                                                                    class="badge badge-pill badge-warning">{{ $x->Status }}</span>
                                                                                                            </td>
                                                                                                        @endif
                                                                                                        <td>{{ $x->Payment_Date }}
                                                                                                        </td>
                                                                                                        <td>{{ $x->note }}
                                                                                                        </td>
                                                                                                        <td>{{ $x->created_at }}
                                                                                                        </td>
                                                                                                        <td>{{ $x->user }}
                                                                                                        </td>
                                                                                                    </tr>
                                                                                                @endforeach
                                                                                            </tbody>
                                                                                        </table>


                                                                                    </div>
                                                                                </div>


                                                                                
                        <div class="modal fade" id="delete_file" tabindex="-1" role="dialog"
                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">حذف المرفق</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form action="{{ route('delete') }}" method="post">

                                        @csrf
                                        <div class="modal-body">
                                            <p class="text-center">
                                            <h6 style="color:red"> هل انت متاكد من عملية حذف المرفق ؟</h6>
                                            </p>

                                            <input type="hidden" name="id_file" id="id_file" value="">
                                            <input type="hidden" name="file_name" id="file_name" value="">
                                            <input type="hidden" name="invoice_number" id="invoice_number"
                                                value="">

                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default"
                                                data-dismiss="modal">الغاء</button>
                                            <button type="submit" class="btn btn-danger">تاكيد</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Container closed -->
                </div>
                <!-- main-content closed -->
            @endsection
            @section('js')
                <!--Internal  Datepicker js -->
                <script src="{{ URL::asset('assets/plugins/jquery-ui/ui/widgets/datepicker.js') }}"></script>
                <!-- Internal Select2 js-->
                <script src="{{ URL::asset('assets/plugins/select2/js/select2.min.js') }}"></script>
                <!-- Internal Jquery.mCustomScrollbar js-->
                <script src="{{ URL::asset('assets/plugins/custom-scroll/jquery.mCustomScrollbar.concat.min.js') }}"></script>
                <!-- Internal Input tags js-->
                <script src="{{ URL::asset('assets/plugins/inputtags/inputtags.js') }}"></script>
                <!--- Tabs JS-->
                <script src="{{ URL::asset('assets/plugins/tabs/jquery.multipurpose_tabcontent.js') }}"></script>
                <script src="{{ URL::asset('assets/js/tabs.js') }}"></script>
                <!--Internal  Clipboard js-->
                <script src="{{ URL::asset('assets/plugins/clipboard/clipboard.min.js') }}"></script>
                <script src="{{ URL::asset('assets/plugins/clipboard/clipboard.js') }}"></script>
                <!-- Internal Prism js-->
                <script src="{{ URL::asset('assets/plugins/prism/prism.js') }}"></script>

                <script>
                    $('#delete_file').on('show.bs.modal', function(event) {
                        var button = $(event.relatedTarget)
                        var id_file = button.data('id_file')
                        var file_name = button.data('file_name')
                        var invoice_number = button.data('invoice_number')
                        var modal = $(this)

                        modal.find('.modal-body #id_file').val(id_file);
                        modal.find('.modal-body #file_name').val(file_name);
                        modal.find('.modal-body #invoice_number').val(invoice_number);
                    })
                </script>

                <script>
                    // Add the following code if you want the name of the file appear on select
                    $(".custom-file-input").on("change", function() {
                        var fileName = $(this).val().split("\\").pop();
                        $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
                    });
                </script>
            @endsection
