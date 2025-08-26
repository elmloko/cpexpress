<div class="modal fade" id="editarPaquete{{ $paquete->id }}" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <form action="{{ route('paquetes.update', $paquete->id) }}" method="POST">
      @csrf
      @method('PUT')
      <div class="modal-content">
        <div class="modal-header"><h5 class="modal-title">Editar Paquete</h5></div>
        <div class="modal-body">
          <div class="form-group">
            <label>Código</label>
            <input type="text" name="codigo" value="{{ $paquete->codigo }}" class="form-control" required>
          </div>
          <div class="form-group">
            <label>Destinatario</label>
            <input type="text" name="destinatario" value="{{ $paquete->destinatario }}" class="form-control" required>
          </div>
          <div class="form-group">
            <label>Departamento</label>
            <select name="departamento" class="form-control" required>
              @foreach(['La Paz','Cochabamba','Santa Cruz','Oruro','Potosí','Tarija','Chuquisaca','Beni','Pando'] as $dep)
                <option @if($paquete->departamento == $dep) selected @endif>{{ $dep }}</option>
              @endforeach
            </select>
          </div>
          <div class="form-group">
            <label>Destino</label>
            <select name="destino" class="form-control" required>
              @foreach(['La Paz','Cochabamba','Santa Cruz','Oruro','Potosí','Tarija','Chuquisaca','Beni','Pando'] as $dep)
                <option @if($paquete->destino == $dep) selected @endif>{{ $dep }}</option>
              @endforeach
            </select>
          </div>
          <div class="form-group">
            <label>Peso (kg)</label>
            <input type="number" step="0.01" name="peso" value="{{ $paquete->peso }}" class="form-control" required>
          </div>
          <div class="form-group">
            <label>Observación</label>
            <textarea name="observacion" class="form-control">{{ $paquete->observacion }}</textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Actualizar</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        </div>
      </div>
    </form>
  </div>
</div>
