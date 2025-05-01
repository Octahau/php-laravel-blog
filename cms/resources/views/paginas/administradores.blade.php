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
                          <button class="btn btn-warning btn-sm"><i class="fas fa-pencil-alt text-white"></i></button>
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
@endsection