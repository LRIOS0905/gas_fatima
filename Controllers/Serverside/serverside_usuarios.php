<?php

require 'serverside.php';

$table_data->getObtenerListado('view_listar_usuario', 'idpersona', array('idpersona', 'identificacion', 'nombres', 'apellidos', 'telefono', 'email_user', 'nombrerol', 'status','rolid'));
