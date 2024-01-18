<!-- Modal -->
<div class="modal fade" id="edit_xray_conversion{{$patient_ray->ray_id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">تحويل الي قسم الاشعة</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('doctor.ray.update') }}" method="POST">
                @method('PUT')
            @csrf
            <div class="modal-body">
                <input type="hidden" name="ray_id" value="{{ $patient_ray->ray_id }}">
                <div class="form-group">
                    <label for="exampleFormControlTextarea1">المطلوب</label>
                    <textarea class="form-control" name="description" rows="6">{{$patient_ray->ray_description}}</textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">اغلاق</button>
                <button type="submit" class="btn btn-primary">حفظ البيانات</button>
            </div>
            </form>
        </div>
    </div>
</div>
