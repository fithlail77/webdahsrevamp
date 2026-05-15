<?php

use Illuminate\Support\Facades\DB;

$columns = DB::select("
    SELECT column_name, data_type, numeric_precision, numeric_scale, character_maximum_length
    FROM information_schema.columns
    WHERE table_name = 'laprestan'
    ORDER BY ordinal_position
");

foreach ($columns as $col) {
    echo "Column: {$col->column_name}\n";
    echo "  Type: {$col->data_type}\n";
    echo "  Precision: {$col->numeric_precision}\n";
    echo "  Scale: {$col->numeric_scale}\n";
    echo "  Max Length: {$col->character_maximum_length}\n\n";
}
