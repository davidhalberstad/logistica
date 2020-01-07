
<div class="modal fade" id="idModalNuevoParte" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content col-md-12">
              <div class="modal-header">
                  <h4 class="modal-title" id="myModalLabel">Nuevo Parte</h4>
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
                <form action="{{ route('altaParte') }}" class="form-group" method="POST" enctype="multipart/form-data">
                  @csrf
                  <div class="row">
                    <div class="form-group col-md-12">
                        <label>Seleccione Vehiculo</label>
                        <div id="select">
                            <select type="text" class="form-control" id="id_vehiculo_select2" value="{{ old('id_vehiculo') }}" data-width="100%" name="id_vehiculo">
                            </select>
                        </div>
                    </div>
                  </div>
                  <div class="form-group col-md-12">
                      <label for="">Observaciones</label>
                      <textarea type="text" name="observaciones" autocomplete="off" maxlength="200"  placeholder="Observaciones" class="form-control" required value="{{ old('observaciones') }}"></textarea>
                  </div>

                  <div class="col-md-12 modal-footer" style="position:relative;">
                      <button class="btn btn-success col-md-4 d-inline" id="btnSubmitAlta" type="submit">Guardar</button>
                      <button class="btn btn-danger col-md-4 d-inline" data-dismiss="modal">Cancelar</button>  
                  </div>
                              
                </form>

                </div>
              </div>
          </div>
      </div>
    </div>


