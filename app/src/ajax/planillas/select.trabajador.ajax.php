<?php
include('./../../../php/functions.php');
include('./../../../controllers/query/querys.C.php');
include('./../../../models/query/querys.M.php');

class ajaxSelectEmpleo
{
    /*=============================================
    SELECT 
    =============================================*/
    public $searchs;
    public $selects;
    public $idedit;
    public function ajaxSelectEmployes()
    {
        $search = $this->searchs;
        $order = $this->selects;
        $id = $this->idedit;
        $select = array(
            "T.id" => "id_emp",
            "T.nombre" => "",
            "T.apellidos" =>"",
            "T.dni" => "",
            "T.fecha_nacimiento" => "birthday",
            "T.fecha_ingreso" => "f_star",
            "T.telefonos" => "telf",
            "T.email" => "",
            "T.direccion" => "direcc",
            "T.id_ubigeo" => "ubigeo",
            "T.id_sucursal" => "",
            "T.id_departamento" => "",
            "T.id_empleo" => "",
            "T.salario" => "",
            "T.sal_hora" => "",
            "U.Departamento" => "depa",
            "U.Provincia" => "provi",
            "U.Distrito" => "dist",
            "S.nombre" => "sucursal",
            "D.nombre" => "area",
            "E.nombre" => "empleo",
            "ORDER_BY" => " ORDER BY T.id ASC LIMIT ". $order['star'].",". $order['nitem'],
        );

        $tables = array(
            "trabajador T" => " ubigeo U", #0-0
            "T.id_ubigeo" => "U.id_ubigeo", #1-1
            "sucursales S" => "", #0-0
            "T.id_sucursal" => "S.id", #1-1
            "departamento D" => "", #0-0
            "T.id_departamento" => "D.id", #1-1
            "empleo E" => "", #0-0
            "T.id_empleo" => "E.id", #1-1
        );

        if ($id == false) {
            if ($search == " " || $search == "  " || $search == "   " || $search == NULL) {
                $where = '';
            } else {
                $where = array(
                    "T.apellidos" => " LIKE CONCAT('%" . $search . "%') OR T.nombre LIKE CONCAT('%" . $search . "%')",
                );
            }
        } else {
            $where = array(
                "T.id" => '=' . $id
            );
        }


        $respuesta = ControllerQueryes::SELECT($select, $tables, $where);
        //print_r($respuesta);
        if ($id == false) {
            $key = $order['star'];
            foreach ($respuesta as  $value) {
                
                echo '<tr class="bordered border-primary" >
                   <td>' . $key = ($key + 1).'</td>
                   <td>' . $value["nombre"] . '</td>
                   <td>' . $value["apellidos"] . '</td>
                   <td>' . $value["dni"] . '</td>
                   <td>' . $value["birthday"] . '</td>
                   <td>' . $value["telf"] . '</td>
                   <td>' . $value["email"] . '</td>
                   <td>' . $value["depa"] . ' - ' . $value["provi"] . ' - ' . $value["dist"] . '</td>
                   <td>' . $value["direcc"] . '</td>
                   <td>' . $value["sucursal"] . '</td>
                   <td>' . $value["area"] . '</td>
                   <td>' . $value["empleo"] . '</td>
                   <td>' . $value["salario"] . '</td>
                   <td>' . $value["sal_hora"] . '</td>
                   ';

                echo '<td class="text-right" >
                        <div class="dropdown dropdown-action">
                            <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="bi bi-pen-fill"></i></a>
                            <div class="dropdown-menu dropdown-menu-right border border-secondary">
                                <a class="dropdown-item" onclick="editarEmploye(' . $value["id_emp"] . ')"><i class="bi bi-pen-fill text-success"></i> Edit</a>
                                <a class="dropdown-item"onclick="eliminarEmploye(' . $value["id_emp"] . ')"><i class="bi bi-trash m-r-5 text-danger"></i> Delete</a>
                            </div>
                        </div>
                    </td>
                </tr>';
            }
        } else {
            echo json_encode($respuesta[0]);
            //echo 'aqui?';
        }
    }
}

/*=============================================
    OBJETO SELECT 
    =============================================*/
if (isset($_POST['selectEmployes'])) {
    $select = new ajaxSelectEmpleo();
    $select->selects = $_POST['selectEmployes'];
    $select->searchs = $_POST['search'];
    $select->idedit = false;
    $select->ajaxSelectEmployes();
}
/*=============================================
    OBJETO SELECT-edit 
    =============================================*/
if (isset($_POST['idSelectEmploys'])) {
    // $arr = $_POST['selectEmployes'];
    $select = new ajaxSelectEmpleo();
    $select->selects = array(
        "star" => 0,
        "nitem" => $_POST['editSelectEmploy']
    );
    $select->searchs = '';
    $select->idedit = $_POST['idSelectEmploys'];
    $select->ajaxSelectEmployes();
}