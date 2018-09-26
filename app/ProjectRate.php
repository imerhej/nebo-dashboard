<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProjectRate extends Model
{
    protected $fillable = [
        'input_facility_management', 
        'input_margin', 
        'input_quote_time', 
        'input_project_management', 
        'input_travel',
        'input_truck',
        'input_van',
        'input_fuel',
        'input_hotel',
        'input_perdiem',
        'input_material',
        'input_receiving',
        'input_return',
    ];

}
