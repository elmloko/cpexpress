<div class="box box-info padding-1">
    <div class="box-body">
        {{-- Nombre Completo --}}
        <div class="form-group">
            <label for="name">Nombre Completo</label>
            <input
                type="text"
                name="name"
                id="name"
                value="{{ old('name', $user->name) }}"
                class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}"
                placeholder="Nombre Completo"
            >
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Email --}}
        <div class="form-group">
            <label for="email">Email</label>
            <input
                type="email"
                name="email"
                id="email"
                value="{{ old('email', $user->email) }}"
                class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
                placeholder="Email"
            >
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Contraseña --}}
        <div class="form-group">
            <label for="password">Contraseña</label>
            <input
                type="password"
                name="password"
                id="password"
                class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"
                placeholder="Contraseña"
            >
            @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Regional --}}
        <div class="form-group">
            <label for="city">Regional</label>
            <select
                name="city"
                id="city"
                class="form-control{{ $errors->has('city') ? ' is-invalid' : '' }}"
            >
                <option value="">Seleccione la Regional</option>
                @foreach([
                    'LA PAZ','COCHABAMBA','SANTA CRUZ','ORURO',
                    'POTOSI','TARIJA','SUCRE','BENI','PANDO'
                ] as $region)
                    <option value="{{ $region }}"
                        {{ old('city', $user->city) === $region ? 'selected' : '' }}
                    >{{ $region }}</option>
                @endforeach
            </select>
            @error('city')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Carnet de Identidad --}}
        <div class="form-group">
            <label for="ci">Carnet de Identidad</label>
            <input
                type="text"
                name="ci"
                id="ci"
                value="{{ old('ci', $user->ci) }}"
                class="form-control{{ $errors->has('ci') ? ' is-invalid' : '' }}"
                placeholder="Carnet de Identidad"
            >
            @error('ci')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Roles --}}
        <h2 class="h5">Listado de Roles</h2>
        @foreach($roles as $role)
            <div class="form-check">
                <input
                    class="form-check-input"
                    type="checkbox"
                    name="roles[]"
                    id="role_{{ $role->id }}"
                    value="{{ $role->id }}"
                    {{ in_array($role->id, old('roles', $user->roles->pluck('id')->toArray())) ? 'checked' : '' }}
                >
                <label class="form-check-label" for="role_{{ $role->id }}">
                    {{ $role->name }}
                </label>
            </div>
        @endforeach
    </div>

    <div class="box-footer mt20">
        <button type="submit" class="btn btn-primary">{{ __('Listo') }}</button>
    </div>
</div>
