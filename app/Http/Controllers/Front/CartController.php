<?php

namespace App\Http\Controllers\Front;

use App\Shop\Carts\Requests\AddToCartRequest;
use App\Shop\Carts\Requests\UpdateCartRequest;
use App\Shop\Carts\Repositories\Interfaces\CartRepositoryInterface;
use App\Shop\Categories\Repositories\Interfaces\CategoryRepositoryInterface;
use App\Shop\Configurations\Repositories\ConfigurationRepository;
use App\Shop\Couriers\Repositories\Interfaces\CourierRepositoryInterface;
use App\Shop\ProductAttributes\Repositories\ProductAttributeRepositoryInterface;
use App\Shop\Products\Product;
use App\Shop\Products\Repositories\Interfaces\ProductRepositoryInterface;
use App\Shop\Products\Repositories\ProductRepository;
use App\Shop\Products\Transformations\ProductTransformable;
use Gloudemans\Shoppingcart\CartItem;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;

class CartController extends Controller
{
    use ProductTransformable;

    /**
     * @var CartRepositoryInterface
     */
    protected $cartRepo;

    /**
     * @var ProductRepositoryInterface
     */
    protected $productRepo;

    /**
     * @var CourierRepositoryInterface
     */
    private $courierRepo;

    /**
     * @var ProductAttributeRepositoryInterface
     */
    private $productAttributeRepo;

    protected $categoryRepo;

    /**
     * CartController constructor.
     * @param CartRepositoryInterface $cartRepository
     * @param ProductRepositoryInterface $productRepository
     * @param CourierRepositoryInterface $courierRepository
     * @param ProductAttributeRepositoryInterface $productAttributeRepository
     */
    public function __construct(
        CartRepositoryInterface $cartRepository,
        ProductRepositoryInterface $productRepository,
        CourierRepositoryInterface $courierRepository,
        ProductAttributeRepositoryInterface $productAttributeRepository,
        ConfigurationRepository $configurationRepository,
        CategoryRepositoryInterface $categoryRepository
    ) {
        $this->cartRepo = $cartRepository;
        $this->productRepo = $productRepository;
        $this->courierRepo = $courierRepository;
        $this->productAttributeRepo = $productAttributeRepository;
        $this->configRepo = $configurationRepository;
        $this->categoryRepo = $categoryRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->neededBag();

        $couriers = $this->courierRepo->allEnable();


        return view('front.carts.cart', [
            'cartItems' => $this->cartRepo->getCartItemsTransformed(),
            'subtotal' => $this->cartRepo->getSubTotal(),
            'tax' => $this->cartRepo->getTax(),
            'couriers' => $couriers,
            'total' => $this->cartRepo->getTotal(2),
            'config'=>$this->getConfig()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  AddToCartRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(AddToCartRequest $request)
    {
        $product = $this->productRepo->findProductById($request->input('product'));

        if ($product->attributes()->count() > 0) {
            $productAttr = $product->attributes()->where('default', 1)->first();

            if (isset($productAttr->sale_price)) {
                $product->price = $productAttr->price;

                if (!is_null($productAttr->sale_price)) {
                    $product->price = $productAttr->sale_price;
                }
            }
        }

        $options = [];
        if ($request->has('productAttribute')) {

            $attr = $this->productAttributeRepo->findProductAttributeById($request->input('productAttribute'));
            $product->price = $attr->price;

            $options['product_attribute_id'] = $request->input('productAttribute');
            $options['combination'] = $attr->attributesValues->toArray();
        }

        $this->cartRepo->addToCart($product, $request->input('quantity'), $options);

//        return redirect()->to(route('home').'#'.$request->input('category_slug'))
//            ->with('message', $product->name .' adicionado ao carrinho');
        return redirect()->back()->with('message', $product->name .' adicionado ao carrinho');
    }

    public function addToCartAjax(AddToCartRequest $request)
    {
        $product = $this->productRepo->findProductById($request->input('product'));

        if ($product->attributes()->count() > 0) {
            $productAttr = $product->attributes()->where('default', 1)->first();

            if (isset($productAttr->sale_price)) {
                $product->price = $productAttr->price;

                if (!is_null($productAttr->sale_price)) {
                    $product->price = $productAttr->sale_price;
                }
            }
        }

        $options = [];
        if ($request->has('productAttribute')) {

            $attr = $this->productAttributeRepo->findProductAttributeById($request->input('productAttribute'));
            $product->price = $attr->price;

            $options['product_attribute_id'] = $request->input('productAttribute');
            $options['combination'] = $attr->attributesValues->toArray();
        }
        if($product->quantity <1){
            $msg= $product->name .' Esgotado.';
            $status = 'error';
        }else if($product->quantity < $request->input('quantity')){
            $msg = $product->name .' só possui ' . $product->quantity . ' no estoque';
            $status = 'error';
        }else {
            $this->cartRepo->addToCart($product, $request->input('quantity'), $options);
            $msg= $product->name .' adicionado ao carrinho';
            $status = 'success';
        }
        $obj = ['status'=>$status,'message'=>$msg];

//        return redirect()->to(route('home').'#'.$request->input('category_slug'))
//            ->with('message', $product->name .' adicionado ao carrinho');
        //return redirect()->back()->with('message', $product->name .' adicionado ao carrinho');
        return Response::json($obj);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCartRequest $request, $id)
    {
        $this->cartRepo->updateQuantityInCart($id, $request->input('quantity'));

        request()->session()->flash('message', 'Update cart successful');
        return redirect()->route('cart.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->cartRepo->removeToCart($id);

        request()->session()->flash('message', 'Removed to cart successful');
        return redirect()->route('cart.index');
    }

    public function neededBag()
    {

        if(current_shop() == 2){
            return;
        }

        $carItens = $this->cartRepo->getCartItemsTransformed();
        $hasBag = false;
        foreach($carItens as $carItem){
            if($carItem->name == 'Sacola Retornável'){
                $hasBag = true;

            }
        }

        if ((!is_null(auth()->user())) && auth()->user()->countBought() < 1 && !$hasBag) {


            $product = $this->productRepo->findByProductName('Sacola Retornável');
            $options = [];

            $this->cartRepo->addToCart($product,1,$options);
        }


    }
}
