<?php

namespace TCG\Voyager\FormFields;

class ImageGuiHandler extends AbstractHandler
{
    protected $codename = 'imageGui';

    public function createContent($row, $dataType, $dataTypeContent, $options)
    {
        return view('voyager::formfields.imageGui', [
            'row'             => $row,
            'options'         => $options,
            'dataType'        => $dataType,
            'dataTypeContent' => $dataTypeContent,
        ]);
    }
}
