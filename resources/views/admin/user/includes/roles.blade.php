<select name="role" id="role" class="form-control kt-selectpicker" required="required" id="kt_select2_1">
    @foreach ($roles as $role)
        <option value="{{ $role->id }}" <?= (old('roles') == $role->id) ? 'selected' : '' ?>>{{ ucwords(str_replace('_', ' ', $role->name)) }}</option>
    @endforeach
</select>