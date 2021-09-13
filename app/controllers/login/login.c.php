<?php
class ControllerLogin
{   
    static public function listaAdmins() {
        $select = array(
            '*' => '*'
        );
        $tables = array(
            'admin' => ''
        );
        $where = '';

        $validad = ModelQueryes::SELECT($select, $tables, $where);
        return $validad;
    }

    static public function REGISTRO($data){

        if ($data[1] != $data[2]) {
            return 'Las contraseñas no son iguales';
        } else {
            $select =array(
                '*'=>'*'
            );
            $tables =array(
                'admin'=>''
            );
            $where = array(
                "usuario"=>"='". $data[0]."'"
            );

            $validad=ModelQueryes::SELECT($select, $tables, $where);

            if (count($validad)==0) {
                $password = password_hash($data[1], PASSWORD_DEFAULT);
                $insert = array(
                    "table" => "admin",
                    "nombres" => $data[0],
                    "usuario" => $data[0],
                    "password" => $password,
                );

                $registro = ModelQueryes::INSERT($insert);
                if ($registro == "ok") {
                    return 'Usuario Registrado';
                } else {
                    return 'Usuario No Registrado';
                }
            } else {
                return 'Este Usuario ya esta Registrado';
            }
        }
    }

    static public function LOGIN($data)
    {
        if ($data[0] == ""|| $data[1] == "") {
            return 'Complete todos los campos.';
        } else {

            $select = array(
                "*" => "*"
            );
            $tables = array(
                "admin" => ""
            );
            $where = array(
                "usuario" => "='" . $data[0] . "'"
            );

            $res = ModelQueryes::SELECT($select, $tables, $where);
            //
            if (isset($res[0]['usuario'])) {
                if ($res[0]['usuario'] == $data[0] || $res[0]['email'] == $data[0]) {
                    if (password_verify($data[1], $res[0]['password'])) {
                        if ($res[0]['estado'] == '1') {
                            session_start();
                            $_SESSION["logSession"] = "ok";
                            $_SESSION['log'] = array(
                                'id' => $res[0]['id'],
                                'name' => $res[0]['nombres'],
                                'last' => $res[0]['apellidos'],
                                'user' => $res[0]['usuario'],
                                'email' => $res[0]['email'],
                            );

                            return '<script>window.location.replace("' . URL_HOST_WEB . '");</script>';
                        } else {
                            return 'usuario inactivo.';
                        }
                    } else {
                        return 'password incorrecto.';
                    }
                } else {
                    return 'usuario o email incorrecto.';
                }
            } else {
                return 'usuario o password incorrecto.';
            }
        }

        //return $res[0]['usuario']. $data[0];
    }
}
