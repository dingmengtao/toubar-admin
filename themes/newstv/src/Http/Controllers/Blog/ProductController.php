<?php namespace NewsTV\Http\Controllers\Blog;

use NewsTV\Http\Controllers\AbstractController;
use WebEd\Plugins\Blog\Models\Contracts\ProductModelContract;
use WebEd\Plugins\Blog\Models\Product;
use WebEd\Plugins\Blog\Repositories\Contracts\ProductRepositoryContract;
use WebEd\Plugins\Blog\Repositories\ProductRepository;
use Illuminate\Support\Facades\DB;

class ProductController extends AbstractController
{
    /**
     * @var Product
     */
    protected $product;

    /**
     * @var ProductRepository
     */
    protected $repository;
    protected $navigation;



    public function __construct(ProductRepositoryContract $repository)
    {
        parent::__construct();

        $this->repository = $repository;


    }

    /**
     * @param Product $item
     * @return mixed
     */
    public function handle(ProductModelContract $item, array $data)
    {
        $this->dis = $data;

        $this->product = $item;

//        $this->getMenu('category', $this->dis['categoryIds']);
//
        breadcrumbs()
            ->setBreadcrumbClass('breadcrumb')
            ->addLink(trans('webed-theme::base.home'), '/', '<i class="fa fa-home" style="margin-right: 5px;"></i>');

//        $allCategories = collect(get_categories([
//            'condition' => [
//                ['id', 'IN', $this->dis['categoryIds']],
//            ],
//            'select' => [
//                'id', 'title', 'slug', 'status', 'parent_id'
//            ]
//        ]));

//        foreach ($allCategories as $category) {
//            breadcrumbs()->addLink($category->title, get_category_link($category->slug));
//        }

        $happyMethod = '_template_' . studly_case($item->page_template);


        if (method_exists($this, $happyMethod)) {
            return $this->$happyMethod();
        }
        return $this->defaultTemplate();
    }

    /**
     * @return mixed
     */
    protected function defaultTemplate()
    {

        $this->navigation=DB::table(webed_db_prefix()."pages")->select('*')->get();
        print_r($this->navigation);
        exit();
        $this->dis['menu'] =$this->navigation;


//        if (view()->exists($this->currentThemeName . '::front.blog.post-templates.' . str_slug($this->product->page_template))) {
//            return $this->view('front.blog.post-templates.' . str_slug($this->post->page_template));
//        }
//        return $this->view('front.blog.post-templates.default');
    }
    protected function _template_Product(){
        $this->navigation=DB::table(webed_db_prefix()."cms_navigation")->select('*')->get();
        view()->share([
            'menu' =>$this->navigation,
        ]);
        return $this->view('front.page-templates.products');
    }
}
