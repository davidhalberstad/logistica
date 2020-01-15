
<div class="modal fade" id="modalEliminarParte" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content col-md-12">
              <div class="modal-header">
                  <h4 class="modal-title" id="myModalLabel">Estas seguro que desea eliminar este parte?</h4>
              </div>
              @if(!$errors->isEmpty())
              <div class="alert alert-danger">
                <ul>
                @foreach($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach()
                </ul>
              </div>
              @endif
              <div class="modal-body ">
                <form action="{{ route('eliminarParte') }}" class="form-group" method="POST" enctype="multipart/form-data">

                  @csrf
                  <input type="text" name="id_parte_semanal_baja" hidden="" id="id_parte_semanal_baja" >
                  <div class="row">
                    <div class="form-group col-md-6">
                        <label>Nº de Identificación</label>
                        <input type="text" id="id_numero_de_identificacion_eliminar_parte" readonly="" autocomplete="off" maxlength="6" placeholder="Numero de identificacion" required class="form-control md-2" value="{{ old('numero_de_identificacion') }}"> 
                    </div>
                    <div class="form-group col-md-6">
                        <label>Dominio</label>
                        <input type="text" id="id_dominio_modificacion_baja" readonly="" autocomplete="off" maxlength="6" placeholder="Dominio" required class="form-control md-2" value="{{ old('dominio') }}"> 
                    </div>
                  </div>
         
                  <div class="col-md-12 modal-footer" style="position:relative;">
                      <button class="btn btn-success col-md-4 d-inline" id="btnSubmitEdit" type="submit">Guardar</button>
                      <button class="btn btn-danger col-md-4 d-inline" data-dismiss="modal">Cancelar</button>  
                  </div>
                              
                </form>
                </div>
              </div>
          </div>
      </div>
    </div>


