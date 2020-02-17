@if(Auth::User()->primer_logeo == null)
@else
<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <div class="sidebar-header">
        <!-- Brand Logo -->
        <a href="{{ route('inicio') }}" class="brand-link">
            <img src="/img/logo.png" alt="Laravel Starter" class="brand-image img-circle elevation-3"
           style="opacity: .8">
            <span class="brand-text font-weight-light">Logistica</span>
        </a>

    </div>

    <!-- Sidebar -->
    <section class="sidebar" >
        <!-- Sidebar user panel (optional) -->
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="/img/profile.png" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <p class="textoBlanco">{{Auth::User()->nombre}}</p>
                <a href="#" id="id_jerarquia" class="d-block"> </a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills  nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item has-treeview">
                    <a href="{{ route('inicio') }}" class="nav-link">
                        <i class="nav-icon fa fa-home"></i>
                        <p>
                          Inicio
                        </p>
                    </a>
                </li>
                @can('usuarios.listaUsuarios')
                <li class="nav-item has-treeview {{ request()->is('permisos*') ? 'menu-open' : '' }}  {{ request()->is('usuarios*') ? 'menu-open' : '' }} {{ request()->is('roles*') ? 'menu-open' : '' }} {{ request()->is('users*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fa fa-user"></i>
                        <p>
                          Usuarios y Permisos
                          <i class="fa fa-angle-left right"></i>
                        </p>
                    </a>
                    
                    <ul class="nav nav-treeview">
                        <ul>
                            
                            <li class="nav-item noPuntos">
                                <a href="{{ route('listaUsuarios') }}" class="nav-link">
                                    <i class="fa fa-plus nav-icon"></i>
                                    <p>Usuarios</p>
                                </a>
                            </li>
                        </ul>
                    </ul>
                    <ul class="nav nav-treeview">
                        <ul>
                            
                            <li class="nav-item noPuntos">
                                <a href="{{ route('listaRoles') }}" class="nav-link">
                                    <i class="fa fa-plus nav-icon"></i>
                                    <p>Roles</p>
                                </a>
                            </li>
                        </ul>
                    </ul>
                    <ul class="nav nav-treeview">
                        <ul>
                            
                            <li class="nav-item noPuntos">
                                <a href="{{ route('listaPermisos') }}" class="nav-link">
                                    <i class="fa fa-plus nav-icon"></i>
                                    <p>Permisos</p>
                                </a>
                            </li>
                        </ul>
                    </ul>
                    @endcan
                    @can('usuarios.asignarPermisosARoles')
                    <ul class="nav nav-treeview">
                        <ul>
                            <li class="nav-item noPuntos">
                                <a href="{{ route('rolPermisos') }}" class="nav-link">
                                    <i class="fa fa-plus nav-icon"></i>
                                    <p>Roles Permisos</p>
                                </a>
                            </li>
                        </ul>
                    </ul>
                    @endcan
                </li>
                @can('vehiculos.parteSemanal')
                <li class="nav-item has-treeview">
                    <a href="{{route('idexParteSemanal')}}" class="nav-link">
                        <i class="fa fa-align-right nav-icon"></i>
                        <p>Parte Semanal</p>
                    </a>
                </li>
                @endcan
                @can('vehiculos.index')
                {{-- con el request->is nos sirve para mantener abierto el menu si es que estamos en el menu propiamente dicho --}}
                <li class="nav-item has-treeview   {{ request()->is('detalleVehiculo*') ? 'menu-open' : '' }}   {{ request()->is('asignacion*') ? 'menu-open' : '' }} {{ request()->is('historial-completo*') ? 'menu-open' : '' }}  {{ request()->is('baja-definitiva*') ? 'menu-open' : '' }}  {{ request()->is('fuera-de-servicio*') ? 'menu-open' : '' }}  {{ request()->is('alta-vehiculos*') ? 'menu-open' : '' }} {{ request()->is('tipo-vehiculos*') ? 'menu-open' : '' }}  ">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fa fa-car"></i>
                        <p>
                          Vehiculos
                          <i class="fa fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <ul>
                            <li class="nav-item noPuntos" id="pie">
                                <a href="{{ route('listaVehiculos') }}" class="nav-link">
                                    <i class="fa fa-plus nav-icon"></i>
                                    <p>Alta</p>
                                </a>
                            </li>
                        </ul>
                    @endcan
                    @can('vehiculos.eliminar')
                    <li class="nav-item has-treeview {{ request()->is('historial-completo*') ? 'menu-open' : '' }}  {{ request()->is('baja-definitiva*') ? 'menu-open' : '' }}  {{ request()->is('fuera-de-servicio*') ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fa fa-times"></i>
                            <p>
                              Estados
                              <i class="fa fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <ul>
                                
                                <li class="nav-item noPuntos" id="pie">
                                    <a href="{{ route('listadoEstadoVehiculo') }}" class="nav-link">
                                        <i class="fa fa-list nav-icon"></i>
                                        <p>Fuera de servicio</p>
                                    </a>
                                </li>
                            </ul>
                        </ul>
                        <ul class="nav nav-treeview">
                            <ul>
                                
                                <li class="nav-item noPuntos" id="pie">
                                    <a href="{{ route('listadoEstadoBajaDefinitiva') }}" class="nav-link">
                                        <i class="fa fa-list nav-icon"></i>
                                        <p>Baja definitiva</p>
                                    </a>
                                </li>
                            </ul>
                        </ul>
                        <ul class="nav nav-treeview">
                            <ul>
                                
                                <li class="nav-item noPuntos">
                                    <a href="{{ route('historialCompleto') }}" class="nav-link">
                                        <i class="fa fa-list nav-icon"></i>
                                        <p>Historial completo</p>
                                    </a>
                                </li>
                            </ul>
                        </ul>
                    </li>
                    @endcan
                    @can('vehiculos.listaAsignacion')
                    <li class="nav-item has-treeview" id="pie">
                        <a href="{{ route('listaAsignacion') }}" class="nav-link">
                            <i class="nav-icon fa fa-share"></i>
                            <p>
                              Asignar
                            
                            </p>
                        </a>
                    </li> 
                    @endcan
                    @can('vehiculos.informacion')
                    <li class="nav-item has-treeview" id="pie">
                        <a href="{{ route('detalleVehiculo') }}" class="nav-link">
                            <i class="nav-icon fa fa-edit"></i>
                            <p>
                              Detalles
                        
                            </p>
                        </a>
                    </li>
                    @endcan
                    @can('vehiculos.repuestos')
                    <li class="nav-item has-treeview" id="pie">
                         <a href="{{ route('listaRepuestos') }}" class="nav-link">
                            <i class="nav-icon fa fa-cogs"></i>
                            <p>
                              Repuestos
                   
                            </p>
                        </a>
                    </li>
                    @endcan
                    @can('vehiculos.graficos')
                    <li class="nav-item has-treeview" id="pie">
                         <a href="{{ route('ListaGraficos') }}" class="nav-link">
                            <i class="nav-icon fa fa-paste"></i>
                            <p>
                              Gráficos
                  
                            </p>
                        </a>
                    </li>
                    @endcan 
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>
@endif
<style type="text/css">
    .noPuntos{
        list-style:none;
    } 

    .sidebar {
      position: fixed;
      bottom: 0;

      width: 250px;

    }
    .sidebar_item:last-child {
      overflow-y:auto;
      height: calc( 100% - 215px);
    }
    .sidebar::-webkit-scrollbar {
        width: 5px;
    }

    .sidebar::-webkit-scrollbar-thumb {
        background: #ff9d00;
        border-radius: 5px;
    }
    .textoBlanco{
        color:#FFF;
    }
</style>


<script src="/dist/plugins/jquery/jquery.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        var csrftoken = $('meta[name=csrf-token]').attr('content');
        $.ajax({
          type:"post",
          url:'{{route('jerarquia')}}',

          data:{
            '_token':csrftoken,
            'Revista':{{substr(Auth::User()->usuario,3)}} },

          success: function(data){
        
            $("#id_jerarquia").text(data[0])
            
          },error:function(data){
            console.log( 'Error al agregar el articulo', data );
          }
        });
    });
</script>