<div class="form-group row">
    <label class="col-sm-3 col-form-label">廠商名稱</label>
    <div class="col-sm-6">
        <input type="text" name="name" class="form-control" value="{{ old('name', $printer?->name) }}" required>
    </div>
</div>
<div class="form-group row">
    <label class="col-sm-3 col-form-label">聯絡人 <small class="text-muted">（選填）</small></label>
    <div class="col-sm-6">
        <input type="text" name="contact_name" class="form-control" value="{{ old('contact_name', $printer?->contact_name) }}">
    </div>
</div>
<div class="form-group row">
    <label class="col-sm-3 col-form-label">電話 <small class="text-muted">（選填）</small></label>
    <div class="col-sm-6">
        <input type="tel" name="phone" class="form-control" value="{{ old('phone', $printer?->phone) }}">
    </div>
</div>
<div class="form-group row">
    <label class="col-sm-3 col-form-label">Email</label>
    <div class="col-sm-6">
        <input type="email" name="email" class="form-control"
               value="{{ old('email', $printer?->email) }}"
               {{ $printer ? 'readonly' : 'required' }}>
        @if($printer)<small class="text-muted">Email 建立後不可修改</small>@endif
    </div>
</div>
<div class="form-group row">
    <label class="col-sm-3 col-form-label">密碼 {{ $printer ? '<small class="text-muted">（選填，不填則不變更）</small>' : '' }}</label>
    <div class="col-sm-6">
        <input type="password" name="password" class="form-control" {{ $printer ? '' : 'required' }}>
    </div>
</div>
<div class="form-group row">
    <label class="col-sm-3 col-form-label">LINE User ID <small class="text-muted">（選填）</small></label>
    <div class="col-sm-6">
        <input type="text" name="line_user_id" class="form-control"
               value="{{ old('line_user_id', $printer?->line_user_id) }}"
               placeholder="Uxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx">
        <small class="text-muted">廠商的 LINE userId，用於自動通知</small>
    </div>
</div>
<div class="form-group row">
    <label class="col-sm-3 col-form-label">工作天數</label>
    <div class="col-sm-3">
        <input type="number" name="working_days" class="form-control"
               value="{{ old('working_days', $printer?->working_days ?? 3) }}"
               min="1" max="30" required>
    </div>
</div>

<div class="form-group row" style="position:sticky;bottom:0;background:#fff;padding:1rem 0;border-top:1px solid #dee2e6;margin-top:1rem">
    <div class="col-sm-9 offset-sm-3">
        <button type="submit" class="btn btn-primary">儲存</button>
        <a href="{{ route('admin.printers.index') }}" class="btn btn-link">取消</a>
    </div>
</div>
