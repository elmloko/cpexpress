<div class="box box-info padding-1">
    <div class="box-body">
        {{-- Selector de Permiso --}}
        <div class="form-group">
            <label for="permission_id">Permiso</label>
            <select
                name="permission_id"
                id="permission_id"
                class="form-control @error('permission_id') is-invalid @enderror"
            >
                <option value="">{{ __('Selecciona un permiso') }}</option>
                @foreach(\App\Models\Permission::pluck('name', 'id') as $id => $name)
                    <option
                        value="{{ $id }}"
                        {{ old('permission_id', $roleHasPermission->permission_id) == $id ? 'selected' : '' }}
                    >
                        {{ $name }}
                    </option>
                @endforeach
            </select>
            @error('permission_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Selector de Rol --}}
        <div class="form-group">
            <label for="role_id">Rol</label>
            <select
                name="role_id"
                id="role_id"
                class="form-control @error('role_id') is-invalid @enderror"
            >
                <option value="">{{ __('Selecciona un rol') }}</option>
                @foreach(\App\Models\Role::pluck('name', 'id') as $id => $name)
                    <option
                        value="{{ $id }}"
                        {{ old('role_id', $roleHasPermission->role_id) == $id ? 'selected' : '' }}
                    >
                        {{ $name }}
                    </option>
                @endforeach
            </select>
            @error('role_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="box-footer mt20 text-right">
        <button type="submit" class="btn btn-primary">
            {{ __('Submit') }}
        </button>
    </div>
</div>
