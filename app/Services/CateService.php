<?php

namespace App\Services;

use App\Models\Cate;

class CateService
{
    /**
     * 
     *
     * @param \App\Models\Cate $cate
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getCategories()
    {
        return Cate::orderBy('created_at', 'desc')->get()->keyBy('name_cate');
    }
}
