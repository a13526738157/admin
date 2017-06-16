<?php
/**
 * Created by PhpStorm.
 * User: wanghaibo
 * Date: 17/6/15
 * Time: 15:55
 */

namespace TCG\Voyager\FormFields;


class LinkHandler extends AbstractHandler
{
    protected $codename = 'link';
    public function createContent ($row, $dataType, $dataTypeContent, $options)
    {
        return view('voyager::formfields.link', [
            'row'             => $row,
            'options'         => $options,
            'dataType'        => $dataType,
            'dataTypeContent' => $dataTypeContent,
        ]);
    }
}