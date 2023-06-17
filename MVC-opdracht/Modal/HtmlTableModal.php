<?php

namespace App\Modal;

use mysql_xdevapi\Exception;

class HtmlTableModal
{
    public function __construct()
    {
    }

    public function generateTableBody($tableData)
    {
        $htmlData = "";
        if ($tableData === null) return "";
        foreach ($tableData as $tableRow) {         //loop through rows of table
            $htmlData .= "<tr>";
            foreach ($tableRow as $key => $tableCelData) {      //loop through cells of a row
                if (!is_string($tableCelData)) {        //remove id fields
                    continue;
                }
                $htmlData .= "<td>";
                $htmlData .= $tableCelData;
                $htmlData .= "</td>";
            }
            if (is_array($tableRow)){
                $rowId = $tableRow['id'];
            }else{
                $rowId = $tableRow->getId();
            }

            $htmlData .= "<td><input type='button' id='delete-$rowId' class='text-danger' value='verwijder' onclick='deleteRobot(this.id)'></td></tr>";
        }
        return $htmlData; //return finished table
    }

    public function generateOptions($optionData){
        if ($optionData === null) return "";
        $htmlData = "";
        foreach ($optionData as $option){
            $htmlData .= "<option value='";
            $htmlData .= $option->getId();
            $htmlData .= "'>";
            $htmlData .= $option->getName() . " (" . $option->getId() . ")";
            $htmlData .= "</option>";
        }
        return $htmlData;
    }
}