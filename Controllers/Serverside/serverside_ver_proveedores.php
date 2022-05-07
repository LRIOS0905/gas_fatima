<?php

require 'serverside_proveedores.php';

$table_data->getVerListadoProveedores('view_ver_proveedores', 'id_proveedor', array('id_proveedor', 'nombres', 'telefono', 'correo'));
