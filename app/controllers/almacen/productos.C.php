<?php
class ControllerProductos{
#=====================	select deposito===============#
    static public function ctrSelecDepositos(){
        $select=array(
            "*"=>"*",
        );
        $tables=array(
            "infraestructura"=>"",
        ); 
        $where="";
        $deposito=ControllerQueryes::SELECT($select, $tables, $where);
        return $deposito;
    }

/*=============================================
	SELECT PRODUCTOS
=============================================*/
    static public function SELECTPRODS($idAlmac){
        $select = array(
            "P.id" => "",
            "P.nombre" => "Pnom",
            "P.descripcion" => "Pdesc",
            "P.fecha_ingreso" => "Pfini",
            "P.fecha_end" => "Pfend",
            "P.cantidad" => "Pcant",
            "P.estado" => "Pest",
            "P.idCategoria" => "",
            "C.nombre" => "Cnom",
            "P.idUmedida" => "",
            "U.nombre" => "Unom",
            "U.abrev_sunat" => "Uasun",
            "P.idAlmacen" => "",
            "A.nombre" => "Anom",
            "P.idInfraestructura" => "",
            "I.deposito" => "Inom",
            "F.imgUrl"=>"Fimg",
        );

        $tables = array(
            "productos P" => "almacen A", #0-0
            "P.idAlmacen" => "A.id", #1-1
            "categorias C" => "",#2-0
            "P.idCategoria" => "C.id", #3-1
            "unidadmedida U" => "",#4-0
            "P.idUmedida" => "U.id", #5-1
            "infraestructura I" => "",#6-0
            "P.idInfraestructura" => "I.id", #7-1
            "images F" => "",#8-0
            "P.id" => "F.idProducto", /**/   # 9-1
        );

        $where = array(
            "P.idAlmacen" => "='" . $idAlmac . "'",
        );
        $products = ControllerQueryes::SELECT($select, $tables, $where);
        return $products;
    }
/*=============================================
	CREAR PRODUCTOS
=============================================*/
    static public function CtrAddProducts($produc, $depo, $imagen){

        if ($depo == "" || $depo[0] == 0 and $depo[1] == "") {
            $lastIdDepo = "";
        } else {
            if ($depo[0] == "" || $depo[0] == 0 and $depo[1] != "") {
                $insert = array(
                    "table" => "infraestructura",
                    "deposito" => $depo[1],
                    "tipo" => $depo[2],
                    "catidad_actual" => $depo[3],
                    "catidad_max" => $depo[4],
                    "descripcion" => $depo[5],
                    "idAlmacen" => $produc[0],
                    "LASTID" => "TRUE",
                );
                $deposito = ControllerQueryes::INSERT($insert);
                if ($deposito != "error") {
                    $lastIdDepo = $deposito;
                }
            } else {
                if ($depo[0] > 0 and $depo[1] != "") {

                    $update = array(
                        "table" => "infraestructura",
                        "deposito" => $depo[1],
                        "tipo" => $depo[2],
                        "catidad_actual" => $depo[3],
                        "catidad_max" => $depo[4],
                        "descripcion" => $depo[5],
                    );
                    $where = array(
                        "id" => $depo[0], #condifion columna y valor
                    );
                    $depoUpdate = ControllerQueryes::UPDATE($update, $where);
                    if ($depoUpdate == "ok") {
                        $lastIdDepo = $depo[0];
                    }
                }
            }
        }
        $insert = "";
        $insert = array(
            "table" => "unidadmedida",
            "nombre" => $produc[4],
            "abrev_sunat" => strtoupper($produc[5]),
            "LASTID" => "TRUE",
        );
        $umedida = ControllerQueryes::INSERT($insert);
        if ($umedida != "error") {
            $lastidUm = $umedida;
        } else {
            $lastidUm = "";
        }
        if ($produc[0] != "" and $produc[0] > 0 and $produc[1] != "") {
            $insert = "";
            $insert = array(
                "table" => "productos",
                "nombre" => $produc[1],
                "descripcion" => $produc[8],
                "idCategoria" => $produc[2],
                "idUmedida" => $lastidUm,
                "fecha_ingreso" => "".$produc[6],
                "fecha_end" => $produc[7],
                "cantidad" => $produc[3],
                "idAlmacen" => $produc[0],
                "idInfraestructura" => $lastIdDepo,
                "recordad" => $produc[9],
                "LASTID" => "TRUE",
            );
            $product = ControllerQueryes::INSERT($insert);
            if ($product == "error") {
                return  "error";
            }else{
                if (isset($imagen["noimg"]) AND isset($imagen["imgemty"])) {
                    return  "ok";
                }else{
                    $Name = "";
                    $host = URL_HOST_WEB;
                    $folder = "public/img/" . $produc[10] . "/";
                    $TmpName = $_FILES['imageFile']['tmp_name'];
                    $Name = $_FILES['imageFile']['name'];
                    $urlfile = $folder . $Name;
                    $url = $host . '/' . $urlfile;
                    if (move_uploaded_file($TmpName, "../../../../" . $urlfile)) {

                        $insert = "";
                        $insert = array(
                            "table" => "images",
                            "nombre" =>  $Name,
                            "imgFile" => $urlfile,
                            "imgUrl" => $url,
                            "idProducto" => $product,
                        );
                        $image = ControllerQueryes::INSERT($insert);
                        if ($image=="ok") {
                            return  "ok";
                        }else{
                            return  "ok";
                        } 
                        
                    }
                }
            }
        }

    }    
}