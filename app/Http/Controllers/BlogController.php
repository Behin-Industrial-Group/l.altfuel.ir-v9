<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use BinshopsBlog\Models\BinshopsBlogCategory;
use BinshopsBlog\Models\BinshopsBlogPost;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function get()
    {
        return BinshopsBlogPost::where('is_published', 1)->get();
    }

    public function getByCatagory($catagory)
    {
        return BinshopsBlogCategory::where('category_name', $catagory)->orWhere('slug', $catagory)->get()->each(function($c){
            $c->posts = $c->posts();
        });
    }
}
