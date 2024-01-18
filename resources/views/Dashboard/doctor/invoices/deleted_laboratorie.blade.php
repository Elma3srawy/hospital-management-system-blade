<!-- Deleted insurance -->
<div class="modal fade" id="deleted_laboratorie{{$patient_laboratory->laboratory_id}}" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">حذف تفاصيل مختبر</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('doctor.laboratory.destroy') }}" method="post">
                    @method('DELETE')
                    @csrf
                    <div class="row">
                        <div class="col">
                            <input type="hidden" name="laboratorie_id" value="{{$patient_laboratory->laboratory_id}}">
                            <p class="h5 text-danger"> هل انت متاكد من حذف بيانات الاشعة ؟ </p>
                            <input type="text" class="form-control" readonly value="{{ $patient_laboratory->laboratory_description }}">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"
                            data-dismiss="modal">{{ trans('insurance.close') }}</button>
                        <button class="btn btn-success">{{ trans('insurance.save') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
