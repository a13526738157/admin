<?php
/**
 * Created by PhpStorm.
 * User: wanghaibo
 * Date: 17/6/15
 * Time: 10:19
 */

namespace TCG\Voyager\FormFields;


class EmailHandler extends AbstractHandler
{
    protected $codename = 'email';

    public function createContent($row, $dataType, $dataTypeContent, $options)
    {
        return view('voyager::formfields.email', [
            'row'             => $row,
            'options'         => $options,
            'dataType'        => $dataType,
            'dataTypeContent' => $dataTypeContent,
        ]);
    }
}