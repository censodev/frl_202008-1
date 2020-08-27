<div class="sidebar-side col-lg-4 col-md-12 col-sm-12">
    <aside class="sidebar default-sidebar">

        <!--search box-->
        <div class="sidebar-widget search-box">
            <form method="post" action="blog.html">
                <div class="form-group">
                    <input type="search" name="search-field" value="" placeholder="Search....." required="">
                    <button type="submit"><span class="icon fa fa-search"></span></button>
                </div>
            </form>
        </div>

        <!-- Categories -->
        <div class="sidebar-widget categories">
            <div class="sidebar-title"><h3>Danh Mục</h3></div>
            <ul class="cat-list">
                <li><a href="#">Residential <span>25</span></a></li>
                <li><a href="#">Commercial <span>20</span></a></li>
                <li class="active"><a href="#">Corporate <span>10</span></a></li>
                <li><a href="#">Hospitality <span>15</span></a></li>
                <li><a href="#">Restaurant <span>10</span></a></li>
                <li><a href="#">Industrial <span>05</span></a></li>
            </ul>
        </div>

         <!-- Latest News -->
        <div class="sidebar-widget latest-news">
            <div class="sidebar-title"><h3>Bài Viết Mới Nhất</h3></div>
            <div class="widget-content">
                <article class="post">
                    <div class="post-thumb"><a href="blog-detail.html"><img src="{{ asset('assets/client/dist/images/resource/post-thumb-3.jpg') }}" alt=""></a></div>
                    <h3><a href="blog-detail.html">Hardood Is The Best For Floor</a></h3>
                    <div class="post-info">by John Doe</div>
                </article>

                <article class="post">
                    <div class="post-thumb"><a href="blog-detail.html"><img src="{{ asset('assets/client/dist/images/resource/post-thumb-4.jpg') }}" alt=""></a></div>
                    <h3><a href="blog-detail.html">Best Floor Service With Chepaest Price</a></h3>
                    <div class="post-info">by John Doe</div>
                </article>
            </div>
        </div>

        <!-- Tags -->
        <div class="sidebar-widget tags">
            <div class="sidebar-title"><h3>Từ Khóa</h3></div>
            <ul class="tag-list clearfix">
                <li><a href="#">Chair</a></li>
                <li><a href="#">Table</a></li>
                <li><a href="#">Bad</a></li>
                <li><a href="#">Dressing</a></li>
                <li><a href="#">furnitures</a></li>
                <li><a href="#">MARBAL</a></li>
                <li><a href="#">Repair</a></li>
            </ul>
        </div>
    </aside>
</div>
