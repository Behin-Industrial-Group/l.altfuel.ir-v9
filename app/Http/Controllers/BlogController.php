<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use BinshopsBlog\Models\BinshopsBlogCategory;
use BinshopsBlog\Models\BinshopsBlogPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BlogController extends Controller
{
    public function get()
    {
        return BinshopsBlogPost::where('is_published', 1)->get();
    }

    public function getByCatagory($catagory)
    {
        $catagory_ids = BinshopsBlogCategory::where('category_name', $catagory)->orWhere('slug', $catagory)->pluck('id');
        return BinshopsBlogPost::whereIn(
            'id', 
            DB::table('binshops_blog_post_categories')->whereIn('binshops_blog_category_id', $catagory_ids)->pluck('id')
        )
        ->where('is_published', 1)
        ->select('id', 'title', 'meta_desc', 'slug')->orderBy('id', 'desc')->get()->each(function($row){
            $row->readMoreLink = route('blog.getById', ['id' => $row->id]);
        });
    }

    public function getById($id)
    {
        return BinshopsBlogPost::where('id', $id)->where('is_published', 1)->first();
    }
}
