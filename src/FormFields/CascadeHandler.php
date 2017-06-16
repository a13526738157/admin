<?php
/**
 * Created by PhpStorm.
 * User: wanghaibo
 * Date: 17/6/14
 * Time: 09:30
 */

namespace TCG\Voyager\FormFields;


class CascadeHandler extends AbstractHandler
{
    protected $codename = 'cascade';

    public function createContent($row, $dataType, $dataTypeContent, $options)
    {
        return view('voyager::formfields.cascade', [
            'row'             => $row,
            'options'         => $options,
            'dataType'        => $dataType,
            'dataTypeContent' => $dataTypeContent,
        ]);
    }
}