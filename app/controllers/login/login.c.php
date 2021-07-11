<?php
class ControllerLogin
{
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
