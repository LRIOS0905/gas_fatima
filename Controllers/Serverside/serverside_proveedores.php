<?php
include '../../Libraries/Core/Conexion.php';

class tableData extends Conexion
{
    private $_db;
    public function __construct()
    {
        $this->_db = Conexion::conexionPDO();
        
    }

    public function getVerListadoProveedores($table, $index_column, $columns)
    {
        $sLimit = "";
        if (isset($_GET['iDisplayStart']) && $_GET['iDisplayLength'] != '-1') {
            $sLimit = "LIMIT " . intval($_GET['iDisplayStart']) . ", " . intval($_GET['iDisplayLength']);
        }

        $sOrder = "";
        if (isset($_GET['iSortCol_0'])) {
            $sOrder = "ORDER BY  ";
            for ($i = 0; $i < intval($_GET['iSortingCols']); $i++) {
                if ($_GET['bSortable_' . intval($_GET['iSortCol_' . $i])] == "true") {
                    $sortDir = (strcasecmp($_GET['sSortDir_' . $i], 'DESC') == 0) ? 'ASC' : 'DESC';
                    $sOrder .= "`" . $columns[intval($_GET['iSortCol_' . $i])] . "`" . $sortDir . ", ";
                }
            }

            $sOrder = substr_replace($sOrder, "", -2);
            if ($sOrder == "ORDER BY") {
                $sOrder = "";
            }
        }

        $sWhere = "";
        if (isset($_GET['sSearch']) && $_GET['sSearch'] != "") {
            $sWhere = "WHERE (";
            for ($i = 0; $i < count($columns); $i++) {
                if (isset($_GET['bSearchable_' . $i]) && $_GET['bSearchable_' . $i] == "true") {
                    $sWhere .= "`" . $columns[$i] . "` LIKE :search OR ";
                }
            }

            $sWhere = substr_replace($sWhere, "", -3);
            $sWhere .= ')';
        }

        for ($i = 0; $i < count($columns); $i++) {
            if (isset($_GET['bSearchable_' . $i]) && $_GET['bSearchable_' . $i] == "true" && $_GET['sSearch_' . $i] != '') {
                if ($sWhere == "") {
                    $sWhere = "WHERE ";
                } else {
                    $sWhere .= " AND ";
                }
                $sWhere .= "`" . $columns[$i] . "` LIKE :search" . $i . " ";
            }
        }

        $sQuery = "SELECT SQL_CALC_FOUND_ROWS `" . str_replace(" , ", " ", implode("`, `", $columns)) . "` FROM `" . $table . "` " . $sWhere . " " . $sOrder . " " . $sLimit;
        $statement = $this->_db->prepare($sQuery);

        if (isset($_GET['sSearch']) && $_GET['sSearch'] != "") {
            $statement->bindValue(':search', '%' . $_GET['sSearch'] . '%', PDO::PARAM_STR);
        }

        for ($i = 0; $i < count($columns); $i++) {
            if (isset($_GET['bSearchable_' . $i]) && $_GET['bSearchable_' . $i] == "true" && $_GET['sSearch_' . $i] != '') {
                $statement->bindValue(':search' . $i, '%' . $_GET['sSearch_' . $i] . '%', PDO::PARAM_STR);
            }
        }

        $statement->execute();
        $rResult = $statement->fetchAll();

        $iFilteredTotal = current($this->_db->query('SELECT FOUND_ROWS()')->fetch());

        $sQuery = "SELECT COUNT(`" . $index_column . "`) FROM `" . $table . "`";
        $iTotal = current($this->_db->query($sQuery)->fetch());

        $output = array(
            "sEcho" => intval($_GET['sEcho']),
            "iTotalRecords" => $iTotal,
            "iTotalDisplayRecords" => $iFilteredTotal,
            "aaData" => array()
        );

        foreach ($rResult as $aRow) {
            $row = array();
            for ($i = 0; $i < count($columns); $i++) {
                if ($columns[$i] == "version") {
                    $row[] = ($aRow[$columns[$i]] == "0") ? '-' : $aRow[$columns[$i]];
                } else if ($columns[$i] != '') {
                    $row[] = $aRow[$columns[$i]];
                }
            }
            $output['aaData'][] = $row;
        }
        echo json_encode($output, JSON_UNESCAPED_UNICODE);
    }
}

$table_data = new tableData();
