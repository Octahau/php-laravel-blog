<!--=====================================
REDES SOCIALES PARA MÓVIL
======================================-->

<div class="d-block d-md-none redes redesMovil p-0 bg-white w-100 pt-2">
				
	<ul class="d-flex justify-content-center p-0">
		<?php
			$redesSociales = json_decode($blog["redes_sociales"], true);
			foreach ($redesSociales as $value) {
				echo '
				<li>
					<a href="' . htmlspecialchars($value['url']) . '" target="_blank">
						<i class="' . htmlspecialchars($value['icono']) . ' lead rounded-circle text-white mr-3 mr-sm-4"></i>
					</a>
				</li>';
			}
		?>
	</ul>

</div>