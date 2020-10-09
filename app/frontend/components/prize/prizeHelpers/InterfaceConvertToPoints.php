<?php

namespace frontend\components\prize\prizeHelpers;

interface InterfaceConvertToPoints
{
    public function canConvertToPoints();

    public function convertToPoints();
}