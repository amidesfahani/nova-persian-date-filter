<?php

namespace Amid\NovaPersianDateFilter;

use Illuminate\Http\Request;
use Laravel\Nova\Filters\Filter;

class NovaPersianDateFilter extends Filter
{
    public $component = 'nova-persian-date-filter';

    public function apply(Request $request, $query, $value){return $query;}
    public function options(Request $request){}

    public function color($color)
    {
        $this->withMeta(['color' => $color]);
        return $this;
    }

    public function type($type)
    {
        $this->withMeta(['type' => $type]);
        return $this;
    }
}