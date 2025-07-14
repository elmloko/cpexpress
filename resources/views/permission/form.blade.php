<div class="box box-info padding-1">
    <div class="box-body">

        {{-- Nombre --}}
        <div class="form-group">
            <label for="name">Name</label>
            <input
                type="text"
                name="name"
                id="name"
                value="{{ old('name', $permission->name) }}"
                class="form-control @error('name') is-invalid @enderror"
                placeholder="Name"
            >
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Guard Name --}}
        <div class="form-group">
            <label for="guard_name">Guard Name</label>
            <input
                type="text"
                name="guard_name"
                id="guard_name"
                value="web"
                class="form-control @error('guard_name') is-invalid @enderror"
                placeholder="Guard Name"
                readonly
            >
            @error('guard_name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

    </div>
    <div class="box-footer mt20 text-right">
        <button type="submit" class="btn btn-primary">
            {{ __('Guardar') }}
        </button>
    </div>
</div>
