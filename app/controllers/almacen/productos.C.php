<?php
class ControllerProductos
{
    #=====================	select deposito===============#
    static public function ctrSelecDepositos()
    {
        $select = array(
            "*" => "*",
        );
        $tables = array(
            "infraestructura" => "",
        );
        $where = array(
            "estado" => "='1'"
        );
        $deposito = ControllerQueryes::SELECT($select, $tables, $where);
        return $deposito;
    }

    /*=============================================
	SELECT PRODUCTOS
=============================================*/
    static public function SELECTPRODS($idAlmac, $idProd)
    {
        $select = array(
            "P.id" => "",
            "P.nombre" => "Pnom",
            "P.descripcion" => "Pdesc",
            "P.fecha_ingreso" => "Pfini",
            "P.fecha_end" => "Pfend",
            "P.cantidad" => "Pcant",
            "P.estado" => "Pest",
            "P.idCategoria" => "idcat",
            "C.nombre" => "Cnom",
            "P.idUmedida" => "",
            "U.id" => "idunidad",
            "U.nombre" => "Unom",
            "U.abrev_sunat" => "Uasun",
            "P.idAlmacen" => "",
            "A.id" => "Aid",
            "A.nombre" => "Anom",
            "P.idInfraestructura" => "iddepo",
            "I.deposito" => "Inom",
            "I.tipo" => "",
            "I.catidad_actual" => "cantAct",
            "I.catidad_max" => "capMax",
            "I.descripcion" => "idescrip",
            "F.id" => "idimg",
            "F.nombre" => "Fnom",
            "F.imgUrl" => "Fimg",
            "M.id" => "idmarca",
            "M.nombre" => "Nmarca",
        );

        $tables = array(
            "productos P" => "almacen A", #0-0
            "P.idAlmacen" => "A.id", #1-1
            "categorias C" => "", #2-0
            "P.idCategoria" => "C.id", #3-1
            "unidadmedida U" => "", #4-0
            "P.idUmedida" => "U.id", #5-1
            "infraestructura I" => "", #6-0
            "P.idInfraestructura" => "I.id", #7-1
            "images F" => "", #8-0
            "P.id" => "F.idProducto", /**/   # 9-1
            "marca M" => "", #8-0
            "P.id_marca" => "M.id", /**/   # 9-1
        );

        if ($idProd == "") {
            if ($idAlmac == 0) {
                $where = "";
            } else {
                $where = array(
                    "P.idAlmacen" => "='" . $idAlmac . "'",
                );
            }
        } else {
            $where = array(
                "P.id" => "='" . $idProd . "'",
            );
        }

        $products = ControllerQueryes::SELECT($select, $tables, $where);
        return $products;
    }
    /*=============================================
	CREAR / CREAR PRODUCTOS
=============================================*/
    static public function CtrAddProducts($produc, $depo, $imagen)
    {

        //deposito
        if ($depo['deposito'] == "NO") {
            $insert = array(
                "table" => "infraestructura",
                "estado" => "0",
                "LASTID" => "TRUE",
            );
            $deposito = ControllerQueryes::INSERT($insert);
            if ($deposito > 0) {
                $lastIdDepo = $deposito;
            }
        } else {
            if ($depo['deposito'] == "SI" and $depo['id'] == 0) {
                $insert = array(
                    "table" => "infraestructura",
                    "deposito" => $depo['nombre'],
                    "tipo" => $depo['tipo'],
                    "catidad_actual" => $depo['cantActual'],
                    "catidad_max" => $depo['capaciMax'],
                    "descripcion" => $depo['descrip'],
                    "estado" => "1",
                    "idAlmacen" => $produc['idalmacen'],
                    "LASTID" => "TRUE",
                );
                $deposito = ControllerQueryes::INSERT($insert);
                if ($deposito > 0) {
                    $lastIdDepo = $deposito;
                }
            } else {
                //actualiza deposito
                $update = array(
                    "table" => "infraestructura",
                    "deposito" => $depo['nombre'],
                    "tipo" => $depo['tipo'],
                    "catidad_actual" => $depo['cantActual'],
                    "estado" => "1",
                    "catidad_max" => $depo['capaciMax'],
                    "descripcion" => $depo['descrip'],
                    "idAlmacen" => $produc['idalmacen'],
                );
                $where = array(
                    "id" => $depo['id'], #condifion columna y valor
                );
                $depoUpdate = ControllerQueryes::UPDATE($update, $where);
                $lastIdDepo = $depo['id'];
            }
        }

        //unidad de medida
        $insert = "";
        if ($produc['idunidad'] == "NO") {
            $insert = array(
                "table" => "unidadmedida",
                "nombre" => $produc['unidadmed'],
                "abrev_sunat" => strtoupper($produc['abrevSunat']),
                "LASTID" => "TRUE",
            );
            $umedida = ControllerQueryes::INSERT($insert);
            if ($umedida > 0) {
                $lastidUm = $umedida;
            }
        } else {
            $update = "";
            $update = array(
                "table" => "unidadmedida",
                "nombre" => $produc['unidadmed'],
                "abrev_sunat" => strtoupper($produc['abrevSunat']),
            );
            $where = array(
                "id" => $produc['idunidad'], #condifion columna y valor
            );
            $umedUpdate = ControllerQueryes::UPDATE($update, $where);
            $lastidUm = $produc['idunidad'];
        }

        //marca
        if ($produc['idmarca'] == 0) {
            $insert = "";
            $insert = array(
                "table" => "marca",
                "nombre" => $produc['nombremarca'],
                "LASTID" => "TRUE",
            );
            $inmarca = ControllerQueryes::INSERT($insert);
            $idmara = $inmarca;
        } else {
            $update = "";
            $update = array(
                "table" => "marca",
                "nombre" => $produc['nombremarca'],
            );
            $where = array(
                "id" => $produc['idmarca'], #condifion columna y valor
            );
            $marcaUpdate = ControllerQueryes::UPDATE($update, $where);
            $idmara = $produc['idmarca'];
        }
        $product = "";
        if ($produc['editProd'] == "NO") { //INSERTA EL PRODUCTO
            $insert = "";
            $insert = array(
                "table" => "productos",
                "nombre" => $produc['nombreProd'],
                "descripcion" => $produc['descrip'],
                "idCategoria" => $produc['idcategory'],
                "idUmedida" => $lastidUm,
                "fecha_ingreso" => $produc['fechaingreso'],
                "fecha_end" => $produc['fechavenci'],
                "cantidad" => $produc['cantidad'],
                "idAlmacen" => $produc['idalmacen'],
                "idInfraestructura" => $lastIdDepo,
                "id_marca" => $idmara,
                "LASTID" => "TRUE",
            );
            $product = ControllerQueryes::INSERT($insert);
        } else {

            $update = "";
            $update = array(
                "table" => "productos",
                "nombre" => $produc['nombreProd'],
                "descripcion" => $produc['descrip'],
                "idCategoria" => $produc['idcategory'],
                "idUmedida" => $lastidUm,
                "fecha_ingreso" => $produc['fechaingreso'],
                "fecha_end" => $produc['fechavenci'],
                "cantidad" => $produc['cantidad'],
                "idAlmacen" => $produc['idalmacen'],
                "idInfraestructura" => $lastIdDepo,
                "id_marca" => $idmara,
            );
            $where = array(
                "id" => $produc['idProd'], #condifion columna y valor
            );
            $prodUpdate = ControllerQueryes::UPDATE($update, $where);
            $product = $produc['idProd'];
        }

        if (isset($imagen["noimg"]) and isset($imagen["imgemty"])) {
            $insert = "";
            if ($produc['ingresarImagen'] == "SI" and $produc['idimagen'] == 0) {
                $insert = array(
                    "table" => "images",
                    "nombre" =>  "false",
                    "imgUrl" =>  "https://image.flaticon.com/icons/png/512/136/136524.png",
                    "idProducto" => $product,
                );
                $image = ControllerQueryes::INSERT($insert);
                return  "ok";
            } else {
                if ($produc['ingresarImagen'] == "SI" and $produc['idimagen'] > 0) {
                    $update = "";
                    $update = array(
                        "table" => "images",
                        "nombre" => 'false',
                        "imgUrl" => 'https://image.flaticon.com/icons/png/512/136/136524.png',
                    );
                    $where = array(
                        "id" => $produc['idimagen'], #condifion columna y valor
                    );
                    $imageupd = ControllerQueryes::UPDATE($update, $where);
                    return  "ok";
                }
            }
        } else {
            $Name = "";
            $host = URL_HOST_WEB;
            $folder = "public/img/" . $produc['nombreAlm'] . "/";
            $TmpName = $_FILES['imageFile']['tmp_name'];
            $Name = $_FILES['imageFile']['name'];
            $urlfile = $folder . $Name;
            $url = $host . '/' . $urlfile;
            if (move_uploaded_file($TmpName, "../../../../" . $urlfile)) {

                if ($produc['ingresarImagen'] == "SI" and $produc['idimagen'] == 0) {
                    $insert = "";
                    $insert = array(
                        "table" => "images",
                        "nombre" =>  $Name,
                        "imgFile" => $urlfile,
                        "imgUrl" => $url,
                        "idProducto" => $product,
                    );
                    $image = ControllerQueryes::INSERT($insert);
                    if ($image == "ok") {
                        return  "ok";
                    } else {
                        return  "ok";
                    }
                } else {
                    $update = "";
                    $update = array(
                        "table" => "images",
                        "nombre" =>  $Name,
                        "imgFile" => $urlfile,
                        "imgUrl" => $url,
                    );
                    $where = array(
                        "id" => $produc['idimagen'], #condifion columna y valor
                    );
                    $imgupd = ControllerQueryes::UPDATE($update, $where);
                    return  "ok";
                }
            }
        }
    }
    /* ==========search prod move========= */
    static public function SEARCHPRODS($idAlmac, $value)
    {

        $resp = ModelQueryes::SEARCH($idAlmac, $value);
        return $resp;
    }
}

// SELECT P.id,P.nombre AS Pnom,P.descripcion AS Pdesc,P.fecha_ingreso AS Pfini,P.fecha_end AS Pfend,P.cantidad AS Pcant,P.estado AS Pest,P.idCategoria,C.nombre AS Cnom,P.idUmedida,U.nombre AS Unom,U.abrev_sunat AS Uasun,P.idAlmacen,A.nombre AS Anom,P.idInfraestructura,I.deposito AS Inom,F.imgUrl AS Fimg,M.nombre AS Nmarca 
// FROM productos P 
// INNER JOIN almacen A ON P.idAlmacen=A.id 
// INNER JOIN categorias C ON P.idCategoria=C.id 
// INNER JOIN unidadmedida U ON P.idUmedida=U.id 
// INNER JOIN infraestructura I ON P.idInfraestructura=I.id 
// INNER JOIN images F ON P.id=F.idProducto 
// INNER JOIN marca M ON P.id_marca=M.id