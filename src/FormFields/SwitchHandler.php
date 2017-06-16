<?php
/**
 * Created by PhpStorm.
 * User: wanghaibo
 * Date: 17/6/15
 * Time: 11:49
 */

namespace TCG\Voyager\FormFields;


class SwitchHandler extends AbstractHandler
{
    protected $codename = 'switch';
    public function createContent($row, $dataType, $dataTypeContent, $options)
    {
        return view('voyager::formfields.switch', [
            'row'             => $row,
            'options'         => $options,
            'dataType'        => $dataType,
            'dataTypeContent' => $dataTypeContent,
        ]);
    }
}