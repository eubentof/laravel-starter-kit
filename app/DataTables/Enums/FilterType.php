<?php

namespace App\DataTables\Enums;

enum FilterType: string
{
    case Text = 'text';
    case Number = 'number';
    case DateRange = 'date_range';
    case Range = 'range';
    case Select = 'select';
}
