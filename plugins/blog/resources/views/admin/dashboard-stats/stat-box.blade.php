<div class="col-lg-3 col-md-4 col-sm-6">
    <div class="small-box bg-yellow-mint">
        <div class="inner font-white">
            <h3>{{ $postsCount or 0 }}</h3>
            <p>Posts</p>
        </div>
        <div class="icon">
            <i class="icon-book-open"></i>
        </div>
        <a href="{{ route('admin::blog.posts.index.get') }}" class="small-box-footer">
            More info <i class="fa fa-arrow-circle-right"></i>
        </a>
    </div>
</div>
<div class="col-lg-3 col-md-4 col-sm-6">
    <div class="small-box bg-purple-medium">
        <div class="inner font-white">
            <h3>{{ $categoriesCount or 0 }}</h3>
            <p>Categories</p>
        </div>
        <div class="icon">
            <i class="fa fa-sitemap"></i>
        </div>
        <a href="{{ route('admin::blog.categories.index.get') }}" class="small-box-footer">
            More info <i class="fa fa-arrow-circle-right"></i>
        </a>
    </div>
</div>
