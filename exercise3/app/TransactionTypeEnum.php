<?php

namespace App;

enum TransactionTypeEnum: string
{
    case CREDIT = 'credit';
    case DEBIT = 'debit';
}
