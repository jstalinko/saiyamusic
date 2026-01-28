<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Comment;
use APp\Helpers\Hook;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Banner;

class JadiFrontendController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Frontend Controller
    |--------------------------------------------------------------------------
    */

    public function home()
    {


        j_inertia_meta(
            config('j_option_autoload.site_name') . ' - ' . config('j_option_autoload.tagline'),
            config('j_option_autoload.meta_description'),
            url('/'),
            url('/storage' . config('j_option_autoload.icon')),
            json_decode(config('j_option_autoload.meta_tags'), true)
        );

        $props['posts'] = Post::orderBy('created_at', 'desc')
            ->with(['meta', 'labels', 'comments'])
            ->where('type', '!=', 'page')
            ->get()
            ->map(function ($post) {
                $post->category = $post->labels
                    ->where('taxonomy', 'category')
                    ->pluck('name')
                    ->first();
                $post->category_slug = $post->labels
                    ->where('taxonomy', 'category')
                    ->pluck('slug')
                    ->first();
                $post->tags = $post->labels
                    ->where('taxonomy', 'tag')
                    ->pluck('name')
                    ->values();
                $post->comment_count = $post->comments->count();

                return $post;
            });

        $props['products'] = Product::where('active', true)->with('category')->orderBy('id', 'desc')->get();
        $props['categories'] = ProductCategory::where('active', true)->get();
        $props['featuredProducts'] = Product::where('active', true)->where('featured', true)->with('category')->orderBy('id', 'desc')->get();
        $props['banners'] = Banner::where('active', true)->get();
        $props['offices'] = json_decode(j_get_option('offices'), true);
        return Inertia::render('Home', j_inertia_props($props));
    }
    public function posts()
    {
        j_inertia_meta(
            "Semua Postingan",
            "Semua Postingan",
            url('/posts'),
            url('/storage' . config('j_option_autoload.icon')),
            json_decode(config('j_option_autoload.meta_tags'), true)
        );
        $props['posts'] = Post::orderBy('created_at', 'desc')->with(['meta', 'labels', 'comments'])->where('type', '!=', 'page')->get()
            ->map(function ($post) {
                $post->category = $post->labels->where('taxonomy', 'category')->pluck('name')->first();
                $post->category_slug = $post->labels->where('taxonomy', 'category')->pluck('slug')->first();
                $post->tags = $post->labels->where('taxonomy', 'tag')->pluck('name')->values();
                $post->comment_count = $post->comments->count();
                return $post;
            });
        return Inertia::render('Posts', j_inertia_props($props));
    }
    public function products()
    {
        j_inertia_meta(
            "Semua Produk",
            "Semua Produk",
            url('/products'),
            url('/storage' . config('j_option_autoload.icon')),
            json_decode(config('j_option_autoload.meta_tags'), true)
        );
        $props['products'] = Product::where('active', true)->with('category')->orderBy('id', 'desc')->get();
        $props['categories'] = ProductCategory::where('active', true)->get();

        return Inertia::render('Products', j_inertia_props($props));
    }

    public function detailProduct(Request $request)
    {
        j_inertia_meta(
            "Semua Produk",
            "Semua Produk",
            url('/products'),
            url('/storage' . config('j_option_autoload.icon')),
            json_decode(config('j_option_autoload.meta_tags'), true)
        );
        $props['product'] = Product::where('slug', $request->slug)->with('category')->firstOrFail();
        return Inertia::render('ProductDetail', j_inertia_props($props));
    }

    public function detailPost(Request $request)
    {
        $slug = $request->slug;
        $post = Post::where('slug', $slug)->with('meta')->with(['labels', 'comments', 'meta'])->firstOrFail();
        $post->category = $post->labels
            ->where('taxonomy', 'category')
            ->pluck('name')
            ->first();
        $post->tags = $post->labels
            ->where('taxonomy', 'tag')
            ->pluck('name')
            ->values();
        $post->comment_count = $post->comments->count();
        $comments = Comment::where('post_id', $post->id)->orderBy('created_at', 'desc')->get();
        $relatedPosts = Post::where('type', '!=', 'page')
            ->where('id', '!=', $post->id)
            ->inRandomOrder()
            ->with(['labels', 'comments', 'meta'])
            ->limit(6)
            ->get()
            ->map(function ($post) {
                $post->category = $post->labels->where('taxonomy', 'category')->pluck('name')->first();
                $post->tags = $post->labels->where('taxonomy', 'tag')->pluck('name')->values();
                $post->comment_count = $post->comments->count();
                return $post;
            });
        j_inertia_meta(
            $post->title . ' - ' . config('j_option_autoload.site_name'),
            $post->excerpt,
            url($post->slug),
            url('storage' . $post->image),
            json_decode(config('j_option_autoload.meta_tags'), true)
        );
        $props['post'] = $post;
        $props['comments'] = $comments;
        $props['relatedPosts'] = $relatedPosts;
        return Inertia::render('Single', j_inertia_props($props));
    }

    public function detailPage(Request $request)
    {

        $slug = $request->slug;
        $page = Post::where('slug', $slug)->where('type', 'page')->with('meta')->with('labels')->with('author')->firstOrFail();
        j_inertia_meta(
            $page->title . ' - ' . config('j_option_autoload.site_name'),
            $page->excerpt,
            url('page/' . $page->slug),
            url('storage' . $page->image),
            json_decode(config('j_option_autoload.meta_tags'), true)
        );
        $props['post'] = $page;
        $props['comments'] = [];
        $props['relatedPosts'] = [];
        return Inertia::render('Single', j_inertia_props($props));
    }

    public function categoryPost(Request $request)
    {
        $slug = $request->slug;
        $filterValue = "";
        $posts = Post::getPostByCategory($slug)->with('labels')->with('meta')->with('author')->get();
        if (count($posts) > 0) {
            j_inertia_meta(
                $posts?->first()?->category_name . ' - ' . config('j_option_autoload.site_name'),
                $posts?->first()?->category_name,
                url('category/' . $slug),
                url('storage' . $posts?->first()?->image),
                json_decode(config('j_option_autoload.meta_tags'), true)
            );
            $filterValue = $posts?->first()?->category_name;
        } else {
            j_inertia_meta(
                'Category not found - ' . config('j_option_autoload.site_name'),
                'Category not found',
                url('category/' . $slug),
                url('storage' . config('j_option_autoload.icon')),
                json_decode(config('j_option_autoload.meta_tags'), true)
            );
            $filterValue = 'Post not found';
        }
        $props['posts'] = $posts;
        $props['filterType'] = 'category';
        $props['filterValue'] = $filterValue;
        return Inertia::render('PostFilter', j_inertia_props($props));
    }

    public function archivePost(Request $request)
    {
        $slug = $request->slug;
        $posts = Post::getPostArchive($slug)->with('labels')->with('meta')->with('author')->get();
        j_inertia_meta(
            "Post archive " . $slug . ' - ' . config('j_option_autoload.site_name'),
            "Post archive " . $slug,
            url('archive/' . $slug),
            url('storage' . $posts->first()->image),
            json_decode(config('j_option_autoload.meta_tags'), true)
        );
        $props['posts'] = $posts;
        $props['filterType'] = 'archive';
        $props['filterValue'] = $slug;
        return Inertia::render('PostFilter', j_inertia_props($props));
    }

    public function searchPost(Request $request)
    {
        $search = $request->query('q');
        $posts = Post::where('title', 'like', '%' . $search . '%')->with('labels')->with('meta')->with('author')->get();
        if (count($posts) > 0) {
            j_inertia_meta(
                "Search result for " . $search . ' - ' . config('j_option_autoload.site_name'),
                "Search result for " . $search,
                url('search/' . $search),
                url('storage' . $posts->first()->image),
                json_decode(config('j_option_autoload.meta_tags'), true)
            );
            $filterValue = $search;
        } else {
            j_inertia_meta(
                "Search result for " . $search . ' - ' . config('j_option_autoload.site_name'),
                "Search result for " . $search,
                url('search/' . $search),
                url('storage' . config('j_option_autoload.icon')),
                json_decode(config('j_option_autoload.meta_tags'), true)
            );
            $filterValue = 'Post not found';
        }
        $props['posts'] = $posts;
        $props['filterType'] = 'search';
        $props['filterValue'] = $filterValue;
        return Inertia::render('PostFilter', j_inertia_props($props));
    }

    public function tagPost(Request $request)
    {
        $slug = $request->slug;
        $posts = Post::getPostByTag($slug)->with('labels')->with('meta')->with('author')->get();
        if (count($posts) > 0) {
            j_inertia_meta(
                "Tag " . $slug . ' - ' . config('j_option_autoload.site_name'),
                "Tag " . $slug,
                url('tag/' . $slug),
                url('storage' . $posts->first()->image),
                json_decode(config('j_option_autoload.meta_tags'), true)
            );
            $filterValue = $slug;
        } else {
            j_inertia_meta(
                "Tag " . $slug . ' - ' . config('j_option_autoload.site_name'),
                "Tag " . $slug,
                url('tag/' . $slug),
                url('storage' . config('j_option_autoload.icon')),
                json_decode(config('j_option_autoload.meta_tags'), true)
            );
            $filterValue = 'Post not found';
        }
        $props['posts'] = $posts;
        $props['filterType'] = 'tag';
        $props['filterValue'] = $filterValue;
        return Inertia::render('PostFilter', j_inertia_props($props));
    }

    public function contact()
    {
        j_inertia_meta(
            "Contact - " . config('j_option_autoload.site_name'),
            "Contact",
            url('/contact'),
            url('storage' . config('j_option_autoload.icon')),
            json_decode(config('j_option_autoload.meta_tags'), true)
        );
        $props['offices'] = json_decode(j_get_option('offices'), true);
        return Inertia::render('Contact', j_inertia_props($props));
    }
}
