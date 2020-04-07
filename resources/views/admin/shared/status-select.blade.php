<label for="status">Status </label>
<select name="status" id="status" class="form-control select2">

    <option value="1" @if($status == 1 || ((!is_null(old('status')) && old('status') == 1))) selected="selected" @endif>Habilitado</option>
    <option value="0"
            @if($status == 0 || ((!is_null(old('status')) && old('status') == 0)))
                selected="selected"
            @endif
    >Desabilitado</option>

</select>