@extends('layouts.master')

{{-- ES LA VERSION 3 DE LA PLANTILLA DASHBOARD --}}
@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

  <!-- Main content -->
  <div class="content">
    <div class="container-fluid">
    <title>@yield('titulo', 'Logistica') | Inicio</title>
      <div class="row" style="padding-top: 5px;">
        <div class="col-12">
          <hr>
          <div class="card col-12">
            <div class="card-header">
              <strong><u>Inicio</u></strong>
            </div>

            <div class="card-body">
              <div class="row">
                <form model="" class="navbar-form navbar-left col-12" role="search">
                  <div class="form-group busqueda col-12">
                    <label>Ingrese numero de identificacion interna o dominio</label>
                    <input type="text" name="vehiculoBuscado" class="form-control " placeholder="numero de identificacion o patente">
                  </div>
                  <div class="form-group busqueda col-12">
                    <button type="submit" id="btnBuscar"  style="padding: 5px;" class="btn btn-info  d-inline left"> 
                      <i class="fa fa-search-plus"> Buscar </i>
                    </button> 
                    <button class="btn btn-warning  d-inline" style="padding: 5px;" id="limpiar"> 
                      <i class="fa fa-paint-brush"> Limpiar</i> 
                    </button>
                  </div>
                </form>
              </div>
                  <div class="row table-responsive ">
                    @if(isset($vehiculoBuscado))
                        <table tableStyle="width:auto" id="tablaResultado" class="table table-striped table-hover table-sm table-condensed table-bordered">
                          <thead>
                            <tr>
                                <th>Marca</th>
                                <th>Año</th>
                                <th>Dominio</th>
                                <th>Motor</th>
                                <th>Chasis</th>
                                <th>N de identificacion</th>
                                <th>Acciones</th>
                            </tr>
                          </thead>
                          <tbody>
                                @foreach($vehiculoBuscado as $item)
                            
                                  <tr>
                                    <td>{{ $item->marca }}</td>
                                    <td>{{ $item->anio_de_produccion }}</td>
                                    <td>{{ $item->dominio }}</td>
                                    <td>{{ $item->motor }}</td>
                                    <td>{{ $item->chasis }}</td>
                                    <td>{{ $item->numero_de_identificacion }}</td>
                                   
                                    <td>
                                      @can('vehiculos.informacion')
                                        <a class="btn btn-info btn-sm" href="{{ route('detalleVehiculo',$item->id_vehiculo) }}"><i class="fa fa-info"></i></a>
                                      @endcan
                                    </td>
                                  
                                  </tr>
                                @endforeach
                            @else
                                <div class="row col-md-12">
                                  <div class="card col-md-12">
                                    <div class="card-body">
                                      <h4 class="card-title">Ingrese algun numero de identificación o dominio del vehiculo</h4> 
                                      <br>
                                    </div>
                                  </div>
                                </div>
                          </tbody>
                        </table>
                    @endif
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

<script src="/dist/js/demo.js"></script>

<script type="text/javascript">

    $('#limpiar').click(function() {
      $("#tablaResultado tr").remove(); 
      $("#id_afectado").empty();
      $('#id_afectado').val('');
      $('#id_anio').val('');
      $('#id_marca').val('');
      $('#id_dominio').val('');
      $('#id_identificacion').val('');
    });

</script>
@stop
<style type="text/css">
    .busqueda{
        padding: 5px;
    }
</style>