@php
    $emailLogin = $_COOKIE['email_login'] ?? null;
@endphp
@foreach ($administradores as $admin)
    @if ($emailLogin === $admin->email)
        @if ($admin->rol === 'administrador')
            @extends('plantilla')
            @section('content')
                <div class="content-wrapper" style="min-height: 247px;">

                    <section class="content-header">
                        <div class="container-fluid">
                            <div class="row mb-2">
                                <div class="col-sm-6">
                                    <h1>Blog</h1>
                                </div>
                                <div class="col-sm-6">
                                    <ol class="breadcrumb float-sm-right">
                                        <li class="breadcrumb-item"><a href="{{ url('/') }}">Inicio</a></li>
                                        <li class="breadcrumb-item active">Blog</li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </section>

                    <!-- Main content -->
                    <section class="content">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-12">

                                    @foreach ($blog as $item)
                                    @endforeach
                                    <form action="{{ url('/blog/' . $item->id) }}" method="POST"
                                        enctype="multipart/form-data">
                                        @method('PUT') <!-- Esto convierte la solicitud POST en PUT -->
                                        @csrf <!-- Token CSRF para proteger el formulario -->

                                        <div class="card">
                                            <div class="card-header">
                                                <button type="submit" class="btn btn-primary float-right">Guardar
                                                    cambios</button>
                                            </div>

                                            <div class="card-body">
                                                @foreach ($blog as $item)
                                                @endforeach
                                                <div class="row">
                                                    <!-- Sección izquierda -->
                                                    <div class="col-lg-6">
                                                        <div class="card">
                                                            <div class="card-body">
                                                                <div class="input-group mb-3">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text">Dominio</span>
                                                                    </div>
                                                                    <input type="text" class="form-control"
                                                                        name="dominio" value="{{ $item->dominio }}"
                                                                        required>
                                                                </div>
                                                                <div class="input-group mb-3">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text">Servidor</span>
                                                                    </div>
                                                                    <input type="text" class="form-control"
                                                                        name="servidor" value="{{ $item->servidor }}"
                                                                        required>
                                                                </div>
                                                                <div class="input-group mb-3">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text">Titulo</span>
                                                                    </div>
                                                                    <input type="text" class="form-control"
                                                                        name="titulo" value="{{ $item->titulo }}" required>
                                                                </div>
                                                                <div class="input-group mb-3">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text">Descripcion</span>
                                                                    </div>
                                                                    <textarea class="form-control" name="descripcion" rows="4" required>{{ $item->descripcion }}</textarea>
                                                                </div>
                                                                <hr class="pb-2">
                                                                <div class="form-group mb-3">
                                                                    <label>Palabras claves</label>
                                                                    @php
                                                                        $tags = json_decode(
                                                                            $item->palabras_claves,
                                                                            true,
                                                                        );
                                                                        $palabras_claves = '';
                                                                        foreach ($tags as $key => $value) {
                                                                            $palabras_claves .= $value . ', ';
                                                                        }
                                                                    @endphp
                                                                    <input type="text" class="form-control"
                                                                        name="palabras_claves"
                                                                        value="{{ $palabras_claves }}" data-role="tagsinput"
                                                                        required>
                                                                </div>
                                                                <hr class="pb-2">
                                                                <label>Redes sociales</label>
                                                                <div class="row">
                                                                    <div class="col-5">
                                                                        <div class="input-group mb-3">
                                                                            <div class="input-group-prepend">
                                                                                <span class="input-group-text">Icono</span>
                                                                            </div>
                                                                            <select class="form-control" id="icono_red">
                                                                                <option value="fab fa-facebook-f, #1475E0">
                                                                                    Facebook
                                                                                </option>
                                                                                <option value="fab fa-instagram, #B18768">
                                                                                    Instagram
                                                                                </option>
                                                                                <option value="fab fa-twitter, #00A6FF">
                                                                                    Twitter</option>
                                                                                <option value="fab fa-youtube, #F95F62">
                                                                                    YouTube</option>
                                                                                <option
                                                                                    value="fab fa-snapchat-ghost, #FF9052">
                                                                                    Snapchat
                                                                                </option>
                                                                                <option value="fab fa-linkedin-in, #0E76A8">
                                                                                    LinkedIn
                                                                                </option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-5">
                                                                        <div class="input-group mb-3">
                                                                            <div class="input-group-prepend">
                                                                                <span class="input-group-text">Enlace</span>
                                                                            </div>
                                                                            <input type="text" class="form-control"
                                                                                id="url_red">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-2">
                                                                        <button type="button"
                                                                            class="btn btn-primary w-100 agregarRed"
                                                                            id="agregar_red">Agregar</button>
                                                                    </div>
                                                                </div>
                                                                <div class="row listadoRed">
                                                                    @php

                                                                        echo "<input type='hidden' name='redes_sociales' id='listaRed' value='" .
                                                                            $item->redes_sociales .
                                                                            "'>";

                                                                        $redes = json_decode(
                                                                            $item->redes_sociales,
                                                                            true,
                                                                        );
                                                                        foreach ($redes as $key => $value) {
                                                                            echo '
                              <div class="col-lg-12">
                                <div class="input-group mb-3">
                                  <div class="input-group-prepend">
                                    <div class="input-group-text" style="background:' .
                                                                                $value['background'] .
                                                                                ';">
                                      <i class="' .
                                                                                $value['icono'] .
                                                                                '"></i>
                                    </div>
                                  </div>
                                  <input type="text" class="form-control" value="' .
                                                                                $value['url'] .
                                                                                '">
                                  <div class="input-group-append">
                                    <div class="input-group-text" style="cursor:pointer; background:#313847;">
                                      <span class="bg-danger px-2 rounded-circle text-white eliminarRed" red="' .
                                                                                $value['icono'] .
                                                                                '" url="' .
                                                                                $value['url'] .
                                                                                '" >&times;</span>
                                    </div>
                                  </div>
                                </div>
                              </div>';
                                                                        }
                                                                    @endphp
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>Sobre mí <span
                                                                            class="small">(Introduccion)</span></label>
                                                                    <textarea name="sobre_mi" class="form-control summernote-sm" rows="6">{{ $item->sobre_mi }}</textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Sección derecha -->
                                                    <div class="col-lg-6">
                                                        <div class="card">
                                                            <div class="card-body text-center">
                                                                <div class="form-group my-2">
                                                                    <div class="btn btn-default btn-file mb-3">
                                                                        <i class="fas fa-paperclip"></i> Adjuntar imagen del
                                                                        logo
                                                                        <input type="file" name="logo">
                                                                        <input type="hidden" name="logo_actual"
                                                                            value="{{ $item->logo }}">
                                                                    </div>
                                                                    <img src="{{ url('/') }}/{{ $blog[0]['logo'] }}"
                                                                        class="img-fluid py-2 bg-secondary previsualizarImg_logo">
                                                                    <p class="help-block small">Dimensiones: 700px x 200px
                                                                        | Peso Max:
                                                                        2MB | Formato: JPG o PNG</p>
                                                                </div>

                                                                <div class="form-group my-2">
                                                                    <div class="btn btn-default btn-file mb-3">
                                                                        <i class="fas fa-paperclip"></i> Adjuntar imagen
                                                                        del icono
                                                                        <input type="file" name="icono">
                                                                        <input type="hidden" name="icono_actual"
                                                                            value="{{ $item->icono }}">
                                                                    </div>
                                                                    <img src="{{ url('/') }}/{{ $blog[0]['icono'] }}"
                                                                        class="img-fluid py-2 bg-secondary previsualizarImg_icono">
                                                                    <p class="help-block small">Dimensiones: 144px x 144px
                                                                        | Peso Max:
                                                                        2MB | Formato: JPG o PNG</p>
                                                                </div>

                                                                <hr class="pb-2">
                                                                <div class="form-group my-2">
                                                                    <div class="btn btn-default btn-file mb-3">
                                                                        <i class="fas fa-paperclip"></i> Adjuntar imagen de
                                                                        portada
                                                                        <input type="file" name="portada">
                                                                        <input type="hidden" name="portada_actual"
                                                                            value="{{ $item->portada }}">
                                                                    </div>
                                                                    <img src="{{ url('/') }}/{{ $blog[0]['portada'] }}"
                                                                        class="img-fluid py-2 bg-secondary previsualizarImg_portada">
                                                                    <p class="help-block small">Dimensiones: 700px x 420px
                                                                        | Peso Max:
                                                                        2MB | Formato: JPG o PNG</p>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>Sobre mí <span
                                                                            class="small">(completo)</span></label>
                                                                    <textarea name="sobre_mi_completo" class="form-control summernote-smc" rows="10">{{ $item->sobre_mi_completo }}</textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="card-footer">
                                                    <button type="submit" class="btn btn-primary float-right">Guardar
                                                        cambios</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>

                @if (Session::has('no-validacion'))
                    <script>
                        notie.alert({

                            type: 2,
                            text: '¡Hay campos no válidos en el formulario!',
                            time: 7

                        })
                    </script>
                @endif
                @if (Session::has('no-validacion-img'))
                    <script>
                        notie.alert({

                            type: 2,
                            text: 'Alguna de las imagenes esta en formato incorrecto o excede el peso permitido',
                            time: 7

                        })
                    </script>
                @endif
                @if (Session::has('ok-editar'))
                    <script>
                        notie.alert({

                            type: 1,
                            text: '¡El blog ha sido actualizado correctamente!',
                            time: 7

                        })
                    </script>
                @endif
            @endsection
        @else
            <script>
                window.location = "{{ url('/categorias') }}";
            </script>
        @endif
    @endif
@endforeach
