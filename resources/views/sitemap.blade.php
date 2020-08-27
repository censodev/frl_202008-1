<?php

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

        <loc>{{ asset('/') }}</loc>

        <lastmod>{{ date('c', time()) }}</lastmod>

        <priority>1.00</priority>

    </url>

    @if( !empty( $categories ) && count( $categories ) > 0 )

	    @foreach ($categories as $category)

	        <url>

	            <loc>{{ asset( $category->alias ) }}</loc>

	            <lastmod>{{ date('c', strtotime ( $category->updated_at ) ) }}</lastmod>

	            <priority>0.80</priority>

	        </url>

	    @endforeach

    @endif



    @if( !empty( $articles ) && count( $articles ) > 0 )

	    @foreach ($articles as $article )

	        <url>

	            <loc>{{ asset( $article->alias ) }}</loc>

	            <lastmod>{{ date('c', strtotime ( $article->updated_at ) ) }}</lastmod>

	            <priority>0.80</priority>

	        </url>

	    @endforeach

    @endif



    @if( !empty( $products ) && count( $products ) > 0 )

	    @foreach ($products as $product )

	        <url>

	            <loc>{{ asset( $product->alias ) }}</loc>

	            <lastmod>{{ date('c', strtotime ( $product->updated_at ) ) }}</lastmod>

	            <priority>0.64</priority>

	        </url>

	    @endforeach

    @endif



    @if( !empty( $galleries ) && count( $galleries ) > 0 )

	    @foreach ($galleries as $gallery )

	        <url>

	            <loc>{{ asset( $gallery->alias ) }}</loc>

	            <lastmod>{{ date('c', strtotime ( $gallery->updated_at ) ) }}</lastmod>

	            <priority>0.64</priority>

	        </url>

	    @endforeach

    @endif

</urlset>

<?php

	$sitemap_xml = ob_get_contents();

	ob_end_clean();

	$cwd = getcwd();

   	$file = "sitemap.xml";

   	@chmod($file,0755);

   	$handle = fopen($file, 'w');

   	fwrite($handle, $sitemap_xml);

   	fclose($handle);

   	die();

?>