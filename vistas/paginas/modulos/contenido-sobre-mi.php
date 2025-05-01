<div class="container-fluid bg-light text-dark py-5">
    <div class="container">
        <!-- Sección "Sobre Mí" -->
        <div class="row align-items-center">
            <!-- Imagen del Administrador -->
            <div class="col-md-4 text-center mb-4 mb-md-0">
                <img src="vistas/img/admin.jpeg" 
                    alt="Sobre mí" 
                    class="img-fluid rounded-circle shadow-sm" 
                    style="max-width: 200px;">
            </div>
            <!-- Contenido Sobre Mí -->
            <div class="col-md-8">
                <div class="sobre-mi-content p-4 bg-white rounded shadow-sm">
                    <?php echo $blog["sobre_mi_completo"]; ?>
                </div>
            </div>
        </div>

        <!-- Sección Contacto -->
        <div class="row mt-5">
            <div class="col-12 col-lg-6 mx-auto">
                <h4 class="mb-4 text-center">Contáctenos</h4>
                <form method="post">
                    <div class="form-group mb-3">
                        <label for="nombreContacto">Nombre y Apellido</label>
                        <input type="text" 
                            class="form-control" 
                            id="nombreContacto" 
                            name="nombreContacto" 
                            placeholder="Ingrese su nombre y apellido" 
                            required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="emailContacto">Correo Electrónico</label>
                        <input type="email" 
                            class="form-control" 
                            id="emailContacto" 
                            name="emailContacto" 
                            placeholder="Ingrese su correo electrónico" 
                            required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="mensajeContacto">Mensaje</label>
                        <textarea class="form-control" 
                                id="mensajeContacto" 
                                name="mensajeContacto" 
                                rows="5" 
                                placeholder="Escriba su mensaje aquí..." 
                                required></textarea>
                    </div>
                    <div class="text-center">
                        <input type="submit" 
                            class="btn btn-primary" 
                            value="Enviar">

                        <?php
                            $enviarCorreo = ControladorCorreo::ctrEnviarCorreo();

                            if($enviarCorreo != "")
                            {
                                echo '<script>
                                    if(window.history.replaceState)
                                    {
                                        window.history.replaceState(null, null, window.location.href);
                                    }</script>';

                                    if($enviarCorreo === "ok"){
                                        echo 'pis sin caca';
        
                                        echo '<script>
        
        
                                            notie.alert({
                                                type: 1,
                                                text: "El mensaje ha sido enviada correctamente",
                                                time: 10
        
                                            })
        
                                        </script>';
        
                                    }
        
                                    if($enviarCorreo == "error"){
                                        echo 'pis con caca';
        
                                        echo '<script>
        
        
                                            notie.alert({
                                                type: 3,
                                                text: "El mensaje no fue enviado. Error",
                                                time: 10
        
                                            })
        
                                        </script>';
        
                                    }
                                    if($enviarCorreo == "error-sintaxis"){
                                        echo 'pis con caca miau';
        
                                        echo '<script>
        
        
                                            notie.alert({
                                                type: 3,
                                                text: "El mensaje no fue enviado. Error",
                                                time: 10
        
                                            })
        
                                        </script>';
        
                                    }
                            }
                        ?>

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
