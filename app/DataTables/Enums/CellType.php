<?php

namespace App\DataTables\Enums;

enum CellType: string
{
    case Text = 'text';
    case TextList = 'text_list';
    case Link = 'link';
    case RichText = 'rich_text';
    case Phone = 'phone';
    case Display = 'display';
}
