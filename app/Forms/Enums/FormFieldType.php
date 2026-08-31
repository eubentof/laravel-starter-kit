<?php

namespace App\Forms\Enums;

enum FormFieldType: string
{
    case Text = 'text';
    case Email = 'email';
    case Url = 'url';
    case RichText = 'rich_text';
    case Textarea = 'textarea';
    case Number = 'number';
    case Money = 'money';
    case DateTime = 'date_time';
    case Phone = 'phone';
    case Agreement = 'agreement';
    case Checkbox = 'checkbox';
    case Rating = 'rating';
    case SingleChoice = 'single_choice';
    case MultipleChoice = 'multiple_choice';
    case CardSelection = 'card_selection';
    case ChoiceGrid = 'choice_grid';
    case LinearScale = 'linear_scale';
    case Classification = 'classification';
    case File = 'file';
    case ProvidedSingleSelect = 'provided_single_select';
    case ProvidedMultipleSelect = 'provided_multiple_select';
    case ProvidedPickList = 'provided_pick_list';
}
