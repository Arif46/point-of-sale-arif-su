<?php
namespace App\Providers;
use Illuminate\Support\Facades\{Auth, Cache, DB, Redis};
use Illuminate\Support\ServiceProvider;

class CommonServiceProvider extends ServiceProvider
{
    protected $defer = true;
    /**
     * Register services.
     *
     * @return void
     */

    public function register()
    {
        /*-----Division Data-----*/
        $this->app->singleton('divisionList', function ($app) {
            return Cache::store('redis')->rememberForever('division', function () {
                return DB::table('divisions')
                    ->select('id as value','name as text',
                        'code', 'status')
                    ->orderBy('name', 'asc')
                    ->get();
            });
        });
        /*-----District Data-----*/
        $this->app->singleton('districtList', function ($app) {
            return Cache::store('redis')->rememberForever('districts', function () {
                return DB::table('districts')
                    ->select('id as value','name as text',
                        'code', 'division_id','status')
                    ->orderBy('name', 'asc')
                    ->get();
            });
        });
        /*-----Upazila Data-----*/
           $this->app->singleton('upazilaList', function ($app) {
            return Cache::store('redis')->rememberForever('upazillas', function () {
                return DB::table('upazillas')
                    ->select('id as value','name as text',
                        'code', 'district_id','status')
                    ->orderBy('name', 'asc')
                    ->get();
            });
        });
         /*-----Union Data-----*/
         $this->app->singleton('unionList', function ($app) {
            return Cache::store('redis')->rememberForever('unions', function () {
                return DB::table('unions')
                    ->select('id as value','name as text',
                        'code','division_id', 'upazila_id', 'district_id','status')
                    ->orderBy('name', 'asc')
                    ->get();
            });
        });
        /*-----Ward Data-----*/
           $this->app->singleton('wardList', function ($app) {
            return Cache::store('redis')->rememberForever('wards', function () {
                return DB::table('wards')
                    ->select('id as value','name as text',
                        'code','division_id', 'upazila_id', 'district_id', 'union_id','status')
                    ->orderBy('name', 'asc')
                    ->get();
            });
        });
         /*-----City Corporation Data-----*/
         $this->app->singleton('cityCorporationList', function ($app) {
            return Cache::store('redis')->rememberForever('cityCorporations', function () {
                return DB::table('city_corporations')
                    ->select('id as value','name as text',
                        'code', 'division_id', 'district_id','status')
                    ->orderBy('name', 'asc')
                    ->get();
            });
        });

        /*-----Pauroshova Data-----*/
        $this->app->singleton('paurashavaList', function ($app) {
            return Cache::store('redis')->rememberForever('paurashavas', function () {
                return DB::table('paurashavas')
                    ->select('id as value','name as text',
                        'code', 'division_id', 'district_id', 'upazila_id','status')
                    ->orderBy('name', 'asc')
                    ->get();
            });
        });

        /*-----Banks Data-----*/
        $this->app->singleton('bankList', function ($app) {
            return Cache::store('redis')->rememberForever('banks', function () {
                return DB::table('banks')
                    ->select('id as value','name as text',
                        'address','status')
                    ->orderBy('name', 'asc')
                    ->get();
            });
        });

        /*-----Branch Data-----*/
        $this->app->singleton('branchList', function ($app) {
            return Cache::store('redis')->rememberForever('branchs', function () {
                return DB::table('branches')
                    ->select('id as value','name as text',
                        'address','status', 'address', 'telephone', 'mobile', 'fax')
                    ->orderBy('name', 'asc')
                    ->get();
            });
        });

        /*-----Shop Data-----*/
         $this->app->singleton('shopList', function ($app) {
            return Cache::store('redis')->rememberForever('shops', function () {
                return DB::table('shops')
                    ->select('id as value','name as text',
                        'mobile','status', 'owner_name', 'area_type_id', 'division_id', 'district_id',
                        'city_corporation_id', 'upazila_id', 'paurashava_id', 'union_id', 'ward_id')
                    ->orderBy('name', 'asc')
                    ->get();
            });
        });

        /*-----Role Data-----*/
        $this->app->singleton('roleList', function ($app) {
            return Cache::store('redis')->rememberForever('roles', function () {
                return DB::table('roles')
                    ->select('id as value','name as text', 'shop_id')
                    ->orderBy('name', 'asc')
                    ->get();
            });
        });

        /*-----Category Data-----*/
         $this->app->singleton('categoryList', function ($app) {
            return Cache::store('redis')->rememberForever('categories', function () {
                return DB::table('categories')
                    ->select('id as value','name as text', 'code', 'shop_id')
                    ->orderBy('name', 'asc')
                    ->get();
            });
        });

        /*-----brand Data-----*/
         $this->app->singleton('brandList', function ($app) {
            return Cache::store('redis')->rememberForever('brands', function () {
                return DB::table('brands')
                    ->select('id as value','name as text', 'code', 'shop_id')
                    ->orderBy('name', 'asc')
                    ->get();
            });
        });

        /*-----Color Data-----*/
        $this->app->singleton('colorList', function ($app) {
            return Cache::store('redis')->rememberForever('colors', function () {
                return DB::table('colors')
                    ->select('id as value','name as text', 'code', 'shop_id')
                    ->orderBy('name', 'asc')
                    ->get();
            });
        });

        /*-----Model Data-----*/
        $this->app->singleton('modelList', function ($app) {
            return Cache::store('redis')->rememberForever('models', function () {
                return DB::table('models')
                    ->select('id as value','name as text', 'code', 'shop_id')
                    ->orderBy('name', 'asc')
                    ->get();
            });
        });

        /*-----Model Data-----*/
        $this->app->singleton('sizeList', function ($app) {
            return Cache::store('redis')->rememberForever('sizes', function () {
                return DB::table('sizes')
                    ->select('id as value','name as text', 'code', 'shop_id')
                    ->orderBy('name', 'asc')
                    ->get();
            });
        });

        /*-----Unit Data-----*/
        $this->app->singleton('unitList', function ($app) {
            return Cache::store('redis')->rememberForever('units', function () {
                return DB::table('units')
                    ->select('id as value','name as text', 'code', 'shop_id')
                    ->orderBy('name', 'asc')
                    ->get();
            });
        });

        /*-----Product Data-----*/
        $this->app->singleton('productList', function ($app) {
            return Cache::store('redis')->rememberForever('products', function () {
                return DB::table('products')
                    ->select('id as value','name as text', 'code', 'shop_id', 'supplier_id', 'category_id',
                    'brand_id', 'unit_id', 'size_id', 'model_id', 'color_id', 'purchase_price', 'sale_price', 'opening_stock',
                    'is_vat', 'expired_date')
                    ->orderBy('name', 'asc')
                    ->get();
            });
        });

        /*-----Supplier Data-----*/
        $this->app->singleton('supplierList', function ($app) {
            return Cache::store('redis')->rememberForever('suppliers', function () {
                return DB::table('suppliers')
                    ->select('id as value','name as text', 'code', 'shop_id', 'mobile', 'vat_reg_no',
                    'address', 'note')
                    ->orderBy('name', 'asc')
                    ->get();
            });
        });
    }
     /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    { }
}
