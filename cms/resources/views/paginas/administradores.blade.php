@extends('plantilla')
@section('content')

<div class="content-wrapper" style="min-height: 247px;">

  <section class="content-header">

    <div class="container-fluid">

      <div class="row mb-2">

        <div class="col-sm-6">

          <h1>Administradores</h1>

        </div>

        <div class="col-sm-6">

          <ol class="breadcrumb float-sm-right">

            <li class="breadcrumb-item"><a href="{{url('/')}}">Inicio</a></li>

            <li class="breadcrumb-item active">Administradores</li>

          </ol>

        </div>

      </div>

    </div><!-- /.container-fluid -->

  </section>

  <!-- Main content -->
  <section class="content">

    <div class="container-fluid">

      <div class="row">

        <div class="col-12">

          <!-- Default box -->
          <div class="card">

            <div class="card-header">

              <button class="btn btn-primary btn-small" data-toggle="modal" data-target="#crearAdministrador">Crear nuevo administrador</button>

            </div>

            <div class="card-body">

              <table class="table table-bordered table-striped" width="100%">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Nombre</th>
                    <th>Correo</th>
                    <th width="50px">Foto</th>
                    <th>Rol</th>
                    <th>Acciones</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($administradores as $key => $administrador)
                    <tr>
                      <td>{{$key + 1}}</td>
                      <td>{{$administrador->name}}</td>
                      <td>{{$administrador->email}}</td>
                      @if($administrador->foto == null)
                        <td><img src="{{url('/')}}/img\Administradores\homero.jpg" alt="imagen admin" class="img-fluid rounded-circle"></td>
                      @else 
                        <td><img src="{{url('/')}}/{{$administrador->foto}}" alt="imagen admin" class="img-fluid rounded-circle"></td>
                      @endif
                      @if($administrador["rol"] == "")
                        <td>Administrador</td>
                      @else 
                        <td>{{($administrador["rol"])}}</td>
                      @endif                      
                      <td>
                        <div class="btn-group">
                          <a href="{{url('/')}}/administradores/{{$administrador["id"]}}" class="btn btn-warning btn-sm"><i class="fas fa-pencil-alt text-white"></i></a>

                          <button class="btn btn-danger btn-sm"><i class="fas fa-trash-alt "></i></button>
                        </div>
                      </td>
                    </tr>
                    @endforeach
                </tbody>
              </table>

            </div>

            <!-- /.card-body -->
            <div class="card-footer">

            </div>
            <!-- /.card-footer-->
          </div>
          <!-- /.card -->
        </div>

      </div>

    </div>

  </section>
  <!-- /.content -->
</div>
<!-- =========================
Crear Administrador Modal
========================= -->
<div class="modal" id="crearAdministrador">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <!-- Modal Header -->
      <form method="POST" action="{{ route('register') }}">
        @csrf
        <div class="modal-header bg-info">
          <h4 class="modal-title">Crear administrador</h4>
          <button type="button" class="close "data-dismiss="modal">&times;</button>   
        </div>

        <!-- Modal Body -->
        <div class="modal-body">
              <!-- name -->
          <div class="input-group mb-3">
            <div class="input-group-append input-group-text">
              <i class="fas fa-user"></i>
            </div>
              <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus placeholder="Nombre completo">

                @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
          </div>
          <!-- email -->
          <div class="input-group mb-3">
            <div class="input-group-append input-group-text">
              <i class="fas fa-envelope"></i>
            </div>
              <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="Correo electronico">

              @error('email')
                  <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                  </span>
              @enderror
          </div>
            <!-- password -->
          <div class="input-group mb-3">
            <div class="input-group-append input-group-text">
              <i class="fas fa-key"></i>
            </div>
              <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="Contraseña">

              @error('password')
                  <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                  </span>
              @enderror
          </div>
          <!-- confirm password -->
          <div class="input-group mb-3">
            <div class="input-group-append input-group-text">
              <i class="fas fa-key"></i>
            </div>
            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password" placeholder="Confirmar contraseña">

          </div>
        </div>
              <!-- Modal footer -->

        <div class="modal-footer d-flex justify-content-between">
          <div>
            <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
          </div>
          <div>
            <button type="submit" class="btn btn-primary">Guardar</button>
          </div>
        </div>
      </form>

    </div>
  </div>
</div>
<!-- =========================
Editar Administrador Modal
========================= -->
@if (isset($status)) 
  @if($status == 200)
  
    @foreach($administradores as $key => $value)
    <div class="modal" id="editarAdministrador">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
    
          <!-- Modal Header -->
          <form method="POST" action="{{url('/')}}/administradores/{{$value["id"]}}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="modal-header bg-info">
              <h4 class="modal-title">Editar administrador</h4>
              <button type="button" class="close "data-dismiss="modal">&times;</button>   
            </div>
    
            <!-- Modal Body -->
            <div class="modal-body">
                  <!-- name -->
              <div class="input-group mb-3">
                <div class="input-group-append input-group-text">
                  <i class="fas fa-user"></i>
                </div>
                  <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{$value["name"]}}" required autocomplete="name" autofocus placeholder="Nombre completo">
    
                    @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
              </div>
              <!-- email -->
              <div class="input-group mb-3">
                <div class="input-group-append input-group-text">
                  <i class="fas fa-envelope"></i>
                </div>
                  <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{$value["email"] }}" required autocomplete="email" placeholder="Correo electronico">
    
                  @error('email')
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                  @enderror
              </div>
                <!-- password -->
              <div class="input-group mb-3">
                <div class="input-group-append input-group-text">
                  <i class="fas fa-key"></i>
                </div>
                  <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" autocomplete="new-password" placeholder="Contraseña">
    
                  @error('password')
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                  @enderror
                  <input type="hidden" name="password_actual" value="{{$value["password"]}}">

              </div>
                  <!-- Rol -->
                  <div class="input-group mb-3">
                    <div class="input-group-append input-group-text">
                      <i class="fas fa-list-ul"></i>
                    </div>
                    <select name="rol" required class="form-control">
                      @if($value["rol"]== 'administrador' || $value["rol"]== '')
                        <option value="administrador" selected>administrador</option>
                        <option value="editor">editor</option>
                      @else
                        <option value="administrador">administrador</option>
                        <option value="editor" selected>editor</option>
                      @endif
                    </select>
                  </div>
                  
                  <!-- Subir foto -->
                  <hr class = "pb-2">
                  <div class = "form-group my-2 text-center">
                    <div class = "btn btn-default btn-file">
                      <i class = "fas fa-paperclip"></i> Subir foto
                      <input type="file" name="foto">
                    </div>
                    <br>
                    @if($value["foto"] == "")
                    <img src="{{url('/')}}/img/administradores/homero.jpg" class = "previsualizarImg img-fluid py-2 w-25 rounded-circle" alt="imagen del administrador">
                    @else
                      <img src="{{url('/')}}/{{$value["foto"]}}" class = "previsualizarImg img-fluid py-2 w-25 rounded-circle" alt="imagen del administrador">
                    @endif
                    <input type="hidden" value="{{$value["foto"]}}" name="foto_actual">
                    <p class="help-block small">Dimensiones 200px x 200px | Peso Max 2MB | Formato JPG o PNG</p>
                  </div>
            </div>
                  <!-- Modal footer -->
    
            <div class="modal-footer d-flex justify-content-between">
              <div>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
              </div>
              <div>
                <button type="submit" class="btn btn-primary">Guardar</button>
              </div>
            </div>
          </form>
    
        </div>
      </div>
    </div>
    @endforeach
    <script> 
      $("#editarAdministrador").modal();
    </script>
  
  
  @else
  {{$status}}
  @endif
@endif
@if(Session::has('no-validacion'))
        <script>
          notie.alert({
            type: 2,
            text: 'Hay campos vacios o no validos',
            time: 10
          });
        </script>
    @endif
    @if(Session::has('error'))
        <script>
          notie.alert({
            type: 3,
            text: 'Error al guardar el administrador',
            time: 10
          });
        </script>
    @endif
    @if(Session::has('ok-editar'))
        <script>
          notie.alert({
            type: 1,
            text: 'Administrador editado correctamente',
            time: 10
          });
        </script>
    @endif
@endsection
