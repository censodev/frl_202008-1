<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\backend\Category;
use App\Models\backend\Post;
use App\Models\backend\Product;
use App\Models\backend\Gallery;
use App\Models\backend\Url;

class SiteMapCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sitemap:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'SiteMap Cron';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $categories   = Category::select('alias','created_at','updated_at')->where("status",1)->orderBy("id","desc")->get();
        $articles     = Post::select('alias','created_at','updated_at')->where("status",1)->orderBy("id","desc")->get();
        $products     = Product::select('alias','created_at','updated_at')->where("status",1)->orderBy("id","desc")->get();
        $galleries    = Gallery::select('alias','created_at','updated_at')->where("status",1)->orderBy("id","desc")->get();

        ob_start();
        echo '<?xml version="1.0" encoding="UTF-8"?>';
        ?>
        <urlset
              xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
              xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
              xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9
                    http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">
        <!-- created with Free Online Sitemap Generator www.xml-sitemaps.com -->
            <url>
                <loc><?php echo asset('/'); ?></loc>
                <lastmod><?php echo date('c', time()); ?></lastmod>
                <priority>1.00</priority>
            </url>
            <?php if( !empty( $categories ) && count( $categories ) > 0 ) :
                foreach ($categories as $category) : ?>
                    <url>
                        <loc><?php echo asset( $category->alias ); ?></loc>
                        <lastmod><?php echo date('c', strtotime ( $category->updated_at ) ); ?></lastmod>
                        <priority>0.80</priority>
                    </url>
                <?php endforeach;
            endif;

            if( !empty( $articles ) && count( $articles ) > 0 ) :
                foreach ($articles as $article ) : ?>
                    <url>
                        <loc><?php echo asset( $article->alias ); ?></loc>
                        <lastmod><?php echo date('c', strtotime ( $article->updated_at ) ); ?></lastmod>
                        <priority>0.80</priority>
                    </url>
                <?php endforeach;
            endif;

            if( !empty( $products ) && count( $products ) > 0 ) :
                foreach ($products as $product ) : ?>
                    <url>
                        <loc><?php echo asset( $product->alias ); ?></loc>
                        <lastmod><?php echo date('c', strtotime ( $product->updated_at ) ); ?></lastmod>
                        <priority>0.64</priority>
                    </url>
                <?php endforeach;
            endif;

            if( !empty( $galleries ) && count( $galleries ) > 0 ) :
                foreach ($galleries as $gallery ) : ?>
                    <url>
                        <loc><?php echo asset( $gallery->alias ); ?></loc>
                        <lastmod><?php echo date('c', strtotime ( $gallery->updated_at ) ); ?></lastmod>
                        <priority>0.64</priority>
                    </url>
                <?php endforeach;
            endif; ?>
        </urlset>
        <?php
        $sitemap_xml = ob_get_contents();
        ob_end_clean();
        $cwd = getcwd();
        $file = public_path() . "/sitemap.xml";
        @chmod($file,0755);
        $handle = fopen($file, 'w');
        fwrite($handle, $sitemap_xml);
        fclose($handle);
        die();
    }
}
