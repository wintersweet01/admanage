<?php

ini_set('max_execution_time', 0);
ini_set('memory_limit', '512M');

require LIB . '/library/PHPExcel.php';

Class SrvPHPExcel
{

    public static function downloadExcel($filename, $headerArray, $data)
    {
        if (!$filename) return false;
        $filename = $filename . '(' . date('Ymd') . ').xls';

        if (!empty($headerArray)) {
            $excelObj = new PHPExcel;// 设置excel文档的属性
            $excelObj->getProperties()->setCreator("author")->setLastModifiedBy("author")->setTitle("Microsoft Office Excel Document")->setSubject("Daily data")->setDescription("Daily data")->setKeywords("Daily data")->setCategory("Daily data result file");
            // 开始操作excel表
            $excelObj->setActiveSheetIndex(0);// 操作第一个工作表
            $excelObj->getActiveSheet()->setTitle(iconv('gbk', 'utf-8', 'sheet_1'));// 设置工作薄名称
            $excelObj->getDefaultStyle()->getFont()->setName(iconv('gbk', 'utf-8', '宋体')); // 设置默认字体和大小
            $excelObj->getDefaultStyle()->getFont()->setSize(10);
            $objWriter = PHPExcel_IOFactory::createWriter($excelObj, 'Excel5');// 设置导出文件格式为excel
            // 设置表头
            $a = 'A';
            foreach ($headerArray as $v) {
                $excelObj->getActiveSheet()->setCellValue($a . '1', $v);
                $a++;
            }
            // 填充表单数据
            if (!empty($data) && is_array($data)) {
                $i = 2;
                foreach ($data as $val) {
                    $j = 'A';
                    foreach ($val as $k => $v) {
                        $excelObj->getActiveSheet()->setCellValue($j . $i, $v);
                        //换行
                        if (strpos($v, Chr(13))) {
                            $excelObj->getActiveSheet()->getStyle($j . $i)->getAlignment()->setWrapText(true);
                        }
                        $j++;
                    }
                    $i++;
                }
            }
            // 从浏览器直接输出$filename
            header("Pragma: public");
            header("Expires: 0");
            header("Cache-Control:must-revalidate, post-check=0, pre-check=0");
            header("Content-Type:application/force-download");
            header("Content-Type: application/vnd.ms-excel;");
            header("Content-Type:application/octet-stream");
            header("Content-Type:application/download");
            header("Content-Disposition:attachment;filename=" . $filename);
            header("Content-Transfer-Encoding:binary");
            $objWriter->save("php://output");
        }
        exit;
    }

    public static function excel2array($file)
    {
        $inputFileType = PHPExcel_IOFactory::identify($file);
        $objReader = PHPExcel_IOFactory::createReader($inputFileType);
        $objPHPExcel = $objReader->load($file);
        $data = $objPHPExcel->getActiveSheet()->toArray();
        unset($data[0]);
        return $data;
    }

    /**
     * 复杂表头导出
     * @param array $head
     * @param array $data
     * @param string $fileName
     * @param int $dataLine 从第几行显示数据
     * @return unkown
     */
    public static function RecursionCreateExecl($head, $data, $fileName, $dataLine = 4)
    {
        $PHPExecl = new PHPExcel();
        $objWriter = PHPExcel_IOFactory::createWriter($PHPExecl, 'Excel2007');
        $PHPExecl->getProperties()->setCreator("4399om")
            ->setLastModifiedBy("Summer")
            ->setTitle("Office 2007 XLSX Test Document")
            ->setSubject("Office 2007 XLSX Test Document")
            ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
            ->setKeywords("office 2007 openxml php")
            ->setCategory("Test result file");
        $PHPExecl->setActiveSheetIndex(0);
        $sheet = $PHPExecl->getActiveSheet();
        self::HandleHeadToNode($sheet, $head, 1, 0, 0);
        self::SummerInsertDateToExecl($sheet, $head, $data, $dataLine);
        self::OutinputHeader($fileName, $objWriter);
    }

    private static function OutinputHeader($fileName, $objWriter)
    {
        //$fileName = str_replace('.php', '.xlsx', pathinfo(__FILE__, PATHINFO_BASENAME));
        $fileName = $fileName . '.xlsx';
        header("Content-Type: application/force-download");
        header("Content-Type: application/octet-stream");
        header("Content-Type: application/download");
        header('Content-Disposition:inline;filename="' . $fileName . '"');
        header("Content-Transfer-Encoding: binary");
        header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Pragma: no-cache");
        $objWriter->save('php://output');
        exit;
    }

    private static function HandleHeadToNode($sheet, $Head, $beginRow, $col, $StartCol)
    {
        foreach ($Head as $key => $cells) {
            $row = $beginRow; //表示行
            $beginCol = PHPExcel_Cell::stringFromColumnIndex($col) . $row;
            $sheet->getCell($beginCol)->setValue($cells['value']);
            //设置表格样式
            $sheet->getStyle($beginCol)->getAlignment()->applyFromArray(
                array(
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                    'rotation' => 0,
                    'wrap' => TRUE,
                )
            );
            $sheet->getStyle($beginCol)->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_DARKGREEN);
            //设置单元格的宽度
            if (isset($cells['width'])) {
                $Cell = $sheet->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex($col));
                $Cell->setWidth($cells['width']);
            }
            //哥元素打上标记
            if (isset($cells['Content'])) {
                self::setComment($sheet, $beginCol, $cells['Content']);
            }
            $merge = false; //合并单元格
            if (isset($cells['col'])) {
                $col += $cells['col'] - 1;
                $merge = true;
            }
            if (isset($cells['row'])) {
                $row += $cells['row'] - 1;
                $merge = true;
            }
            if ($merge) {
                $endCol = PHPExcel_Cell::stringFromColumnIndex($col) . $row;
                $sheet->mergeCells($beginCol . ":" . $endCol);
            }
            $row++;
            $col++;
            //表示有存在孩子节点
            if (isset($cells['children']) && is_array($cells['children'])) {
                $cols = $StartCol;
                if (!self::IsExistChildren($cells['children'])) {
                    $cols = $col - $cells['col'];
                    $StartCol = $col;
                }
                self::HandleHeadToNode($sheet, $cells['children'], $row, $cols, $StartCol);
            } else {
                $StartCol = $col;
            }
        }
    }

    /*
    * 将数据写入到数据表中
    * $Data Array 表示要插入进Execl数据
    * $RuleData Array 表示数据格式的规则数组
    * $i int 表示从第几行起的插入数据
    * **/
    public static function SummerInsertDateToExecl($sheet, $Head, $Data, $n = 3, $RuleData = array())
    {
        $SimpleHead = self::getHead($Head);
        $row = $n;
        foreach ($Data as $key => $valueArr) {
            $m = 0;
            foreach ($valueArr as $k => $v) {
                $StartCol = PHPExcel_Cell::stringFromColumnIndex($m) . $row;
                $sheet->getCell($StartCol)->setValue($v);
                $sheet->getStyle($StartCol)->getAlignment()->applyFromArray(
                    array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                        'rotation' => 0,
                        'wrap' => TRUE,
                    )
                );
                if (isset($SimpleHead[$k]['col'])) {
                    $m = $m + $SimpleHead[$k]['col'] - 1;
                    $endCol = PHPExcel_Cell::stringFromColumnIndex($m) . $row;
                    $sheet->mergeCells($StartCol . ":" . $endCol);
                }
                $m++;
                $type = false;
                if (isset($SimpleHead[$k]['type'])) {
                    $type = $SimpleHead[$k]['type'];
                    $AllowArray = $SimpleHead[$k]['allowarray'];
                }
                //设置单元格的数据验证
                if ($type) {
                    switch ($type) {
                        case 'list':
                            self::setSelectionRange($sheet, $StartCol, $AllowArray);
                            break;
                        case 'range':
                            self::setValueRange($sheet, $StartCol, $AllowArray);
                            break;
                    }
                }
            }
            $row++;
        }
    }

    //判断自己的孩子节点中是否存在孙子节点
    private static function IsExistChildren($Data)
    {
        foreach ($Data as $key => $value) {
            if (isset($value['children']) && is_array($value['children'])) {
                return true;
            }
        }
        return false;
    }

    //获取底层数据
    private static function getHead($Head, &$Node = array())
    {
        foreach ($Head as $key => $value) {
            if (isset($value['children']) && is_array($value['children'])) {
                self::getHead($value['children'], $Node);
            } else {
                $Node[] = $value;
            }
        }
        return $Node;
    }

    //数据控制，设置单元格数据在一个可选方位类
    private static function setSelectionRange($sheet, $Cell, $rangeStr, $Title = "数据类型")
    {
        $objValidation = $sheet->getCell($Cell)->getDataValidation();
        $objValidation->setType(PHPExcel_Cell_DataValidation::TYPE_LIST)
            ->setErrorStyle(PHPExcel_Cell_DataValidation::STYLE_STOP)
            ->setAllowBlank(true)
            ->setShowInputMessage(true)
            ->setShowErrorMessage(true)
            ->setShowDropDown(true)
            ->setErrorTitle('输入的值有误')
            ->setError('您输入的值不在下拉框列表内.')
            ->setPromptTitle('"' . $Title . '"')
            ->setFormula1('"' . $rangeStr . '"');
    }

    /*
    * 现在单元格的有效数据范围，暂时仅限于数字
    * $sheet 当前的工作簿对象
    * $Cell 需要设置属性的单元格
    * $ValueRange array 允许输入数组的访问
    */
    private static function setValueRange($sheet, $Cell, $ValueRange)
    {
        //设置单元格的的数据类型是数字，并且保留有效位数
        $sheet->getStyle($Cell)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00);
        $ValueRange = explode(",", $ValueRange);
        //开始数值有效访问设定
        $objValidation = $sheet->getCell($Cell)->getDataValidation();
        $objValidation->setType(PHPExcel_Cell_DataValidation:: TYPE_WHOLE);
        $objValidation->setErrorStyle(PHPExcel_Cell_DataValidation:: STYLE_STOP);
        $objValidation->setAllowBlank(true);
        $objValidation->setShowInputMessage(true); //设置显示提示信息
        $objValidation->setShowErrorMessage(true); //设置显示错误信息
        $objValidation->setErrorTitle('输入错误'); //错误标题
        $objValidation->setError('请输入数据范围在从' . $ValueRange[0] . '到' . $ValueRange[1] . '之间的所有值'); //错误内容
        $objValidation->setPromptTitle('允许输入'); //设置提示标题
        $objValidation->setPrompt('请输入数据范围在从' . $ValueRange[0] . '到' . $ValueRange[1] . '之间的所有值'); //提示内容
        $objValidation->setFormula1($ValueRange['0']); //设置最大值
        $objValidation->setFormula2($ValueRange['1']); //设置最小值
    }

    /*
    * 生成Execl单元格备注
    * $sheet 当前的工作簿对象
    * $Cell 需要设置属性的单元格
    * $content 备注内容
    * */
    private static function setComment($sheet, $Cell, $content)
    {
        $sheet->getComment($Cell)->setAuthor('4399om');
        $objCommentRichText = $sheet->getComment($Cell)->getText()->createTextRun('4399om:');
        $objCommentRichText->getFont()->setBold(true);
        $sheet->getComment($Cell)->getText()->createTextRun("\r\n");
        $sheet->getComment($Cell)->getText()->createTextRun($content);
        $sheet->getComment($Cell)->setWidth('100pt');
        $sheet->getComment($Cell)->setHeight('100pt');
        $sheet->getComment($Cell)->setMarginLeft('150pt');
        $sheet->getComment($Cell)->getFillColor()->setRGB('EEEEEE');
    }

}