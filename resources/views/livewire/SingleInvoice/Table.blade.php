<button wire:loading.attr="disabled" class="btn btn-primary pull-right" x-on:click="$wire.changeStoreMode()" type="button">اضافة فاتورة جديدة </button><br><br>
<div class="table-responsive">
    <table class="table text-md-nowrap" id="example2" data-page-length="50"style="text-align: center">
        <thead>
        <tr>
            <th>#</th>
            <th>اسم الخدمة</th>
            <th>اسم المريض</th>
            <th>تاريخ الفاتورة</th>
            <th>اسم الدكتور</th>
            <th>القسم</th>
            <th>سعر الخدمة</th>
            <th>قيمة الخصم</th>
            <th>نسبة الضريبة</th>
            <th>قيمة الضريبة</th>
            <th>الاجمالي مع الضريبة</th>
            <th>نوع الفاتورة</th>
            <th>العمليات</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($single_invoices as $single_invoice)
            <tr wire:key="{{ $single_invoice->id }}">
                <td>{{ $loop->iteration}}</td>
                <td>{{ $single_invoice->service_name }}</td>
                <td>{{ $single_invoice->patient_name }}</td>
                <td>{{ $single_invoice->invoice_date }}</td>
                <td>{{ $single_invoice->doctor_name }}</td>
                <td>{{ $single_invoice->section_name }}</td>
                <td>{{ number_format($single_invoice->price, 2) }}</td>
                <td>{{ number_format($single_invoice->discount_value, 2) }}</td>
                <td>{{ $single_invoice->tax_rate }}%</td>
                <td>{{ number_format($single_invoice->tax_value, 2) }}</td>
                <td>{{ number_format($single_invoice->total_with_tax, 2) }}</td>
                <td>{{ $single_invoice->type == 1 ? 'نقدي':'اجل' }}</td>
                <td>

                    <button wire:loading.attr="disabled" type="button" wire:click="edit({{ $single_invoice->id }})" class="btn btn-primary btn-sm">
                        <i class="fa fa-edit"></i>
                    </button>

                    <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#delete_invoice" ><i class="fa fa-trash"></i></button>
                    <a href="{{ route('admin.single.invoice.print' , $single_invoice->id) }}" class="btn btn-primary btn-sm" target="_blank">
                        <i class="fas fa-print"></i>
                    </a>

                </td>
            </tr>

        @endforeach
    </table>

    @include('livewire.singleInvoice.delete')

</div>
