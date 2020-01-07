@extends('layouts.master')

{{-- ES LA VERSION 3 DE LA PLANTILLA DASHBOARD --}}
@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper ">
  <!-- Content Header (Page header) -->
  <title>@yield('titulo', 'Logistica') | Parte Semanal</title>
  <!-- /.content-header -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.9/css/select2.min.css" rel="stylesheet" />

  <!-- Main content -->
  <div class="content ">
    @if(strpos(Auth::User()->roles,'Suspendido'))
      Su usuario se encuentra suspendido!
    @else
    <div class="container-fluid">
      <div class="row" style="padding-top: 5px;">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <div class="row ">
                <div class="col-md-3">
                  @can('vehiculos.nuevoParte')
                    <button type="button" class="btn btn-success left" data-toggle="modal" data-target="#idModalNuevoParte"> <i class="fa fa-plus"> Nuevo Parte</i> </button> 
                  @endcan
                </div>
              </div>
            </div>
          {{-- extiendo los modales --}}
          @extends('logistica/modales/modal_nuevo_parte')
          @extends('logistica/modales/modal_editar_parte')
          @extends('logistica/modales/modal_baja_parte')
          @extends('vehiculos/modales/modal_detalle')
{{--           @extends('vehiculos/altas/modales/modal_baja_vehiculo')
          @extends('vehiculos/altas/modales/modal_editar_vehiculo') --}}

            </div>

              <hr>
              <div class="card">
                <div class="card-header">
                  <strong><u>Novedades</u></strong>
                </div>

                <div class="card-body">
                  <div class="row col-md-12">
                    <form model="" class="navbar-form navbar-left pull-right" role="search">
                      <div class="row">
                        
                        <div class="form-group">
                          <input type="text" name="vehiculoBuscado" id="numero_de_identificacion" class="form-control" placeholder="numero de identificacion">
                          <label>Dominio | Iden. Interna</label>
                        </div>
                        <div class="form-group">
                          <input type="date" name="desde" id="desde" class="form-control" placeholder="Desde">
                          <label>Desde</label>
                        </div>
                        <div class="form-group">
                          <input type="date" name="hasta" id="hasta" class="form-control" placeholder="Hasta">
                          <label>Hasta</label>
                        </div>
                        <div class="form-group">
        
                          <button type="submit" id="btnBuscar" class="btn btn-info left"> <i class="fa fa-search-plus"></i>Buscar  </button> 
                          @can('vehiculos.parteSemanalImprimir')
                            <button type="button" id="btnImprimirParte" class="btn btn-danger left"> <i class="fa fa-file-pdf"></i> Imprimir</button> 
                          @endcan
                        </div>
                      </div>

                    </form>
                  </div>
                  <div class="row table-responsive">
                    <table tableStyle="width:auto" class="table table-striped table-hover table-sm table-condensed table-bordered responsive">
                      <thead>
                        <tr>

                          <th>Numero de identificacion</th>
                          <th>Marca</th>
                          <th>Afectado</th>
                          <th>Trabajo</th>
                          <th>Responsable</th>
                          <th>fecha</th>
                          <th>Acciones</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($parteSemanal as $item)
                        
                          <tr>
                            <td>{{ $item->numero_de_identificacion }}</td>
                            <td>{{ $item->marca }}</td>
                            <td>{{ $item->nombre_dependencia }}</td>
                            <td>{{ substr($item->observaciones_parte ,0,10) }}...<a href="" onclick="detalle('{{ $item->observaciones_parte }}')" data-toggle="modal" data-target="#modalDetalleLugar">ver mas</a>
                           
                            </td>
                            <td>{{ $item->nombre }}</td>
                            <td>{{ date('d-m-Y H:i', strtotime($item->created_at )) }}</td>
                           
                            <td>
                              @can('vehiculos.informacion')
                                <a class="btn btn-info btn-sm" href="{{ route('detalleVehiculo',$item->id_vehiculo) }}"><i class="fa fa-info"></i></a>
                              @endcan
                              @can('vehiculos.editarParte') 
                                <button onclick="editarParte({{ $item }})" title="Editar vehiculo"   class="btn btn-warning btn-sm"><i class="fa fa-edit"></i></button>
                              @endcan
                              @can('vehiculos.parteIndividualEliminar') 
                                <button  onclick="eliminarParte({{ $item }});" title="Eliminar vehiculo"  class=" btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
                              @endcan
                            </td>
                          
                          </tr>
                        @endforeach
                      </tbody>
                    </table>

                      <div class="row">
                          {{ $parteSemanal->appends(Request::all())->links() }}
                      </div>
                  </div>
                </div>
              </div>
                          </div>
          {{-- card --}}
          </div>
        {{-- col 12 --}}
        </div>
      {{-- row --}}
      </div>
    {{-- fluid --}}
    </div>
  @endif
  <!-- /.content -->
  </div>
  {{-- final --}}
</div>

@endsection

@section('javascript')
<!-- jQuery -->


<script src="/dist/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap -->
<script src="/dist/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE -->
<script src="/dist/js/adminlte.js"></script>

<!-- OPTIONAL SCRIPTS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.9/js/select2.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/i18n/es.js"></script> 
<script src="/dist/js/demo.js"></script>

<script type="text/javascript">

  $("#id_vehiculo_select2").select2({
    dropdownParent: $("#select"),
    placeholder:"Ingrese numero de identificacion - Ej: 3-730 | Ingrese dominio - Ej: AB123AA",
    allowClear: true,
    minimumInputLength: 2,

    type: "GET",
    ajax: {
      dataType: 'json',
      url: '{{ route("getAllVehiculosDisponiblesRepuestos") }}',
      delay: 250,
      data: function (params) {

       /* console.log(params)*/
        return {
          termino: $.trim(params.term),
          page: params.page
        };
      },
      processResults: function (data) {
        return {
            results:  $.map(data, function (item) {
                return {
                    text: item.dominio+' - N Identificacion '+item.numero_de_identificacion,
                    id: item.id_vehiculo,
                }
            })
        };
    },
    cache: true,

      },
  });  

  function detalle(item){
    var asdasd = $('#idDetalle').val(item);
    $('#modalDetalleLugar').modal('show');
  }
  function eliminarParte(item){
    var numero_de_identificacion = $('#id_numero_de_identificacion_eliminar_parte').val(item.numero_de_identificacion),
        dominio = $('#id_dominio_modificacion_baja').val(item.dominio),
        id_parte_semana = $('#id_parte_semanal_baja').val(item.id_parte_semanal);
    $('#modalEliminarParte').modal('show');
  }

  function editarParte(item){
    var numero_de_identificacion = $('#id_numero_de_identificacion_parte_modificar').val(item.numero_de_identificacion),
        dominio = $('#id_dominio_modificacion').val(item.dominio),
        id_parte_semana = $('#id_parte_semanal').val(item.id_parte_semanal),
        obs_parte = $('#id_observaciones_modificacion').val(item.observaciones_parte);
        $('#modalEdicionParte').modal('show');
  }



</script>
<script type="text/javascript">
  
$(document).ready(function() {
    $("#btnImprimirParte").click(function() {
      var desde = $("#desde").val();
      var hasta = $("#hasta").val();
      var numero_de_identificacion = $("#numero_de_identificacion").val();



      if ((desde && hasta) != '' && numero_de_identificacion === ''){
        numero_de_identificacion = 0;
         window.location.href = 'parte-semanal-descargar-pdf/'+desde+'/'+hasta+'/'+numero_de_identificacion;
      }else if(numero_de_identificacion != '' && (desde && hasta) == ''){
        desde =0;
        hasta = 0;
        window.location.href = 'parte-semanal-descargar-pdf/'+desde+'/'+hasta+'/'+numero_de_identificacion;
      }else if((numero_de_identificacion && desde && hasta) != ''){
        window.location.href = 'parte-semanal-descargar-pdf/'+desde+'/'+hasta+'/'+numero_de_identificacion;
      }else{
        desde =0;
        hasta = 0;
        numero_de_identificacion = 0;
        window.location.href = 'parte-semanal-descargar-pdf/'+desde+'/'+hasta+'/'+numero_de_identificacion;
      }

      
        
    });
});
</script>

@stop

