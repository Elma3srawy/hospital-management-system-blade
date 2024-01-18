<div>

    {{-- @if ($catchError)
        <div class="alert alert-danger" id="success-danger">
            <button type="button" class="close" data-dismiss="alert">x</button>
            {{ $catchError }}
        </div>
    @endif --}}

    @if ($InvoiceSaved)
        <div class="alert alert-info">تم حفظ البيانات بنجاح.</div>
    @endif

    @if ($InvoiceUpdated)
        <div class="alert alert-info">تم تعديل البيانات بنجاح.</div>
    @endif

    @if($show_table)

        @include('livewire.SingleInvoice.Table')

    @endif

    @if($editMode)

        @include('livewire.singleInvoice.Update')

    @endif

    @if ($storeMode)

    <form wire:submit.prevent="store" autocomplete="off">
                @csrf
                <div class="row">
                    <div class="col">
                        <label>اسم المريض</label>
                        <select wire:model.live="patient_id" class="form-control" required>
                            <option value=""  >-- اختار من القائمة --</option>
                            @foreach($Patients as $Patient)
                                <option value="{{$Patient->id}}">{{$Patient->name}}</option>
                            @endforeach
                        </select>
                    </div>


                    <div class="col">
                        <label>اسم الدكتور</label>
                        <select wire:model.live="doctor_id"  wire:change="get_section" class="form-control"  id="exampleFormControlSelect1" required>
                            <option value="" >-- اختار من القائمة --</option>
                            @foreach($Doctors as $Doctor)
                                <option value="{{$Doctor->id}}">{{$Doctor->name}}</option>
                            @endforeach
                        </select>
                    </div>


                    <div class="col">
                        <label>القسم</label>
                        <input type="text" class="form-control" readonly value="{{ $sections->name ?? "" }}">
                    </div>

                    <div class="col">
                        <label>نوع الفاتورة</label>
                        <select wire:model.live="type" class="form-control">
                            <option value="" >-- اختار من القائمة --</option>
                            <option value="1">نقدي</option>
                            <option value="2">اجل</option>
                        </select>
                    </div>


                </div><br>

                <div class="row row-sm">
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-header pb-0">
                                <div class="d-flex justify-content-between">
                                    <h4 class="card-title mg-b-0"></h4>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped mg-b-0 text-md-nowrap" style="text-align: center">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>اسم الخدمة</th>
                                            <th>سعر الخدمة</th>
                                            <th>قيمة الخصم</th>
                                            <th>نسبة الضريبة</th>
                                            <th>قيمة الضريبة</th>
                                            <th>الاجمالي مع الضريبة</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <th scope="row">1</th>
                                            <td>
                                                <select wire:model.live="service_id" class="form-control" wire:change="get_price" id="exampleFormControlSelect1">
                                                    <option value="">-- اختار الخدمة --</option>
                                                    @foreach($Services as $Service)
                                                        <option value="{{$Service->id}}">{{$Service->name}}</option>
                                                    @endforeach
                                                </select>

                                            </td>
                                            <td><input value="{{ $price }}" type="text" class="form-control" readonly></td>
                                            <td><input wire:model.live="discount_value" type="text" class="form-control"></td>
                                            <th><input wire:model.live="tax_rate" type="text" class="form-control"></th>
                                            <td><input type="text" class="form-control" value="{{$tax_value}}" readonly ></td>
                                            <td><input type="text" class="form-control" readonly value="{{$total_with_tax }}"></td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div><!-- bd -->
                            </div><!-- bd -->
                        </div><!-- bd -->
                    </div>
                </div>

                <input class="btn btn-outline-success" wire:loading.attr="disabled" type="submit" value="تاكيد البيانات">
                <input class="btn btn-outline-success" x-on:click="$wire.changeTableMode()"  wire:loading.attr="disabled" value='عرض الفواتير'>
            </form>


            @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

    @endif


</div>
