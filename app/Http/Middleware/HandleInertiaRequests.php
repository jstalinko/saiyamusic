<?php

namespace App\Http\Middleware;

use App\Helpers\Hook;
use Illuminate\Http\Request;
use Inertia\Middleware;
use App\Models\Label;
use App\Models\Post;
use Illuminate\Support\Facades\Cache;
use App\Models\Option;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    private function j_option_autoload()
    {
        // Cache 60 menit, bisa kamu ubah
        $options = Cache::remember('options.autoload', 60, function () {
            return Option::where('autoload', true)
                ->pluck('option_value', 'option_name')
                ->toArray();
        });

        // Masukkan ke config agar bisa diakses seperti config biasa
        config(['j_option_autoload' => $options]);
    }

    /**
     * Define the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     *
     * @return array<string, mixed>
     */
    public function share(Request $request)
    {
        // Load option autoload (cached)
        $this->j_option_autoload();

        // ============================
        // SHARE: OPTION SETTINGS (cached 60m)
        // ============================
        $setting = Cache::remember('shared.setting', 60, function () {
            return [
                'base_url' => j_get_option('base_url', url('/')),
                'site_name' => j_get_option('site_name', env('APP_NAME')),
                'tagline' => j_get_option('tagline'),
                'icon' => j_get_option('icon'),
                'meta_keywords' => j_get_option('meta_keywords'),
                'meta_description' => j_get_option('meta_description'),
                'meta_tags' => j_get_option('meta_tags', '{}'),
                'menus' => json_decode(j_get_option('menus', '[]'), true),
            ];
        });

        // ============================
        // SHARE: CATEGORY (cached 60m)
        // ============================
        $categories = Cache::remember('shared.categories', 60, function () {
            return Label::getCategoryOnly();
        });

        // ============================
        // SHARE: ARCHIVE (cached 60m)
        // ============================
        $archives = Cache::remember('shared.archives', 60, function () {
            return Post::getArchiveByMonth();
        });

        // ============================
        $pages = Cache::remember('shared.pages', 60, function () {
            return Post::where('type', 'page')->where('status', 'publish')->get();
        });

        // ============================
        // SHARE: LATEST POSTS (refresh tiap 10 menit)
        // ============================
        $latestPosts = Cache::remember('shared.latest_posts', 10, function () {
            return Post::latest()
                ->where('type', 'post')
                ->where('status', 'publish')
                ->take(5)
                ->get();
        });

        return array_merge(parent::share($request), [
            'flash' => [
                'message' => fn() => $request->session()->get('message')
            ],
            'setting'       => $setting,
            'sharedData'    => [
                'categories'   => $categories,
                'archives'     => $archives,
                'latest_posts' => $latestPosts,
                'pages'       => $pages,
            ],
            'j_option_autoload' => config('j_option_autoload'),
            'hooks' => Hook::all()
        ]);
    }
}
