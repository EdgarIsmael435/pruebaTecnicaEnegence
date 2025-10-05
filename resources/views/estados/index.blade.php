@extends('layouts.app')

@section('content')
<div class="card">
  <div class="card-body">
    @if(session('ok'))
      <div class="alert alert-success">{{ session('ok') }}</div>
    @endif

    <h5 class="mb-3">Estados</h5>
    <table id="tabla-estados" class="table table-striped table-bordered">
      <thead>
        <tr>
          <th>#</th>
          <th>Estado</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
        @foreach($estados as $i => $e)
        <tr>
          <td>{{ $i+1 }}</td>
          <td>{{ $e->nombre_estado }}</td>
          <td>
            <button class="btn btn-sm btn-primary ver-municipios"
                    data-id="{{ $e->id_estado }}" data-nombre="{{ $e->nombre_estado }}">
              Ver municipios
            </button>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="municipiosModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Municipios de <span id="estadoNombre"></span></h5>
        <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
      </div>
      <div class="modal-body">
        <ul id="listaMunicipios" class="list-group"></ul>
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
$(function(){
  $('#tabla-estados').DataTable({
    pageLength: 10,
    order: [[1,'asc']],
    language: { url:'https://cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json' }
  });

  $('.ver-municipios').on('click', function(){
    const id = $(this).data('id');
    const nombre = $(this).data('nombre_municipio');
    $('#estadoNombre').text(nombre);
    $('#listaMunicipios').empty().append('<li class="list-group-item">Cargando...</li>');
    $('#municipiosModal').modal('show');

    $.get("{{ url('/estados') }}/"+id+"/municipios", function(resp){
      $('#listaMunicipios').empty();
      resp.municipios.forEach(function(m){
        $('#listaMunicipios').append('<li class="list-group-item">'+m+'</li>');
      });
    }).fail(function(xhr){
      $('#listaMunicipios').html('<li class="list-group-item list-group-item-danger">Error al cargar municipios</li>');
    });
  });
});
</script>
@endpush
