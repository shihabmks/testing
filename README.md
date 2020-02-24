# Product Listing Application
In this package allows you to filter products with speed, price and color.

# Step 1: Database Configuration
Open <b>.env</b> file under your project directory. In my case my project directory is <b>/var/www/html/chamnes/</b>.

Specify the host, database name, username, and password and save it.
<div class="highlight highlight-source-shell">
    <pre>
DB_HOST=<b><i>"yourhostname"</i></b>
DB_PORT=<b><i>"YourMysqlPort"</i></b>
DB_DATABASE=<b><i>"DatabaseName"</i></b>
DB_USERNAME=<b><i>"DatabaseUserName"</i></b>
DB_PASSWORD=<b><i>"DatabasePassword"</i></b>
</pre>
</div>

# Step 2: Create Model & Database Migration.
Now, we are filtering products based on <b>speed, color and price</b>. So let us create the <b>Product</b> model and migration. So generate via the following command.

<code>php artisan make:model Product -m</code>

So it will create both model and migration file.

Inside <b>create_products_table.php</b> file (<i>You can see the file under /database/migrations/</i>), write the following schema in it.
<code>
    <pre>
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id');
			$table->string('name');
			$table->string('speed');
			$table->string('price');
			$table->string('color');
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
</pre>
</code>
Now we can migrate the product table in our database using the following command.

<code>php artisan migrate</code>
# Step 3: Create Controller
Next step is to create a <b>ProductController</b> file. 

So type the following command.

<code>php artisan make:controller ProductController</code>

Navigate to <code>app/Http/Controllers/</code> directory and open <b>ProductController.php</b>.

Define index method inside that ProductController.php file.
<code>
<pre>
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;

class ProductsController extends Controller
{
    //
	public function index(Request $request){	
		$products = Product::filter($request)->get();  	
	return view('pages.products')->with('products', $products);
	}	
}
</pre>
</code>

Define the route inside the <b>web.php</b> file.

<code>Route::get('/products', 'ProductsController@index')->name('products');</code>

# Step 4: Create a Filter.
Now, create a <b>Filters</b> folder inside <code>app</code> directory.

Inside <b>Filters</b> folder, create one abstract class called <b>AbstractFilter.php</b>. In the future, we have more filters, so It is better to use this class as an abstract and then different filter class can extend this class. So that we do not repeat each code every time.
<code>
    <pre>
    namespace App\Filters;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

abstract class AbstractFilter
{
    protected $request;

    protected $filters = [];

    public function __construct(Request $request)
    {
        $this->request = $request;
    }
   public function filter(Builder $builder)
    {   
        foreach($this->getFilters() as $filter => $value)
        {
            $this->resolveFilter($filter)->filter($builder, $value);
        }
        return $builder;
    }

    protected function getFilters()
    {
        return array_filter($this->request->only(array_keys($this->filters)));
    }

    protected function resolveFilter($filter)
    {
        return new $this->filters[$filter];
    }
}
</pre></code>

Inside <b>Filters</b> folder, create one file called <b>SpeedFilter.php</b>  and paste the following code. for filter with the option speed. This <b>SpeedFilter</b> class is responsible for filtering the data based on the <b>speed</b>. We pass the speed in the query string, and according to that, we get out the result.

<code>
    <pre>
    // SpeedFilter.php
namespace App\Filters;

class SpeedFilter
{
    public function filter($builder, $value)
    {        
		if($value=='greater'){
			return $builder->where('speed', '>' , '10'); // Speed is greater than 10
		}else{
			return $builder->where('speed', '<' , '10'); // Speed is less than 10
		}
    }
}
 </pre>
  </code>
  
Same like we need to create filter option for color. So create the file  <b>ColorFilter.php</b> inside <b>Filters</b> folder.

<code>
    <pre>
// ColorFilter.php

namespace App\Filters;

class ColorFilter
{
    public function filter($builder, $value)
    {
		if($value=='other'){
			return $builder->where('color', '!=', 'black'); // Color is not Black
		}else{
			return $builder->where('color', 'black'); // Color is Black
		}        
    }
}
 </pre>
  </code>
  
  Same like we need to create filter option for price. So create the file  <b>PriceFilter.php</b> inside <b>Filters</b> folder
  <code>
    <pre>
    // PriceFilter.php

namespace App\Filters;

class PriceFilter
{
    public function filter($builder, $value)
    {   
		if($value=='greater'){
			return $builder->where('price', '>' , '500'); // Price is greater than 500
		}else{
			return $builder->where('price', '<' , '500'); // Price is less than 500
		}		
    }
}
 </pre>
  </code>

Next step is to create a new file called <b>ProductFilter.php</b> inside <b>Filters</b> directory.
In this file, we will define the actual filter class.  For this example, I am using speed, color and price filters.

<code><pre>
// ProductFilter.php
namespace App\Filters;
use App\Filters\AbstractFilter;
use Illuminate\Database\Eloquent\Builder;

class ProductFilter extends AbstractFilter
{
    protected $filters = [
        'speed' => SpeedFilter::class,
		'color' => ColorFilter::class,
		'price' => PriceFilter::class
    ];
 }
</pre></code>

# Step 5: Update Model

Here, I am creating one filter function inside <b>Product</b> model.

Navigate to <code>app/</code> directory and open <b>Product.php</b>.

Pass the whole request as a parameter.

<code><pre>namespace App;
use App\Filters\ProductFilter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Product extends Model
{   
	public function scopeFilter(Builder $builder, $request)
    {
        return (new ProductFilter($request))->filter($builder);
    }
}</pre></code>

# Step 6: Route
Open <b>web.php</b> file in <code>route/</code> directory.

<code>Route::get('/products', 'ProductController@index')->name('products');</code>

So, now go to the /products path in the browser. 

# Step 7: View
Create a folder <b>layouts</b> in <code>resources/views/</code> directory and create a new file <b>app.blade.php</b> under <b>layouts</b> directory for the template for all website. In this case we can use to add the common things in to our website.

<code><pre>
Copy the content from the below link 
<a href="https://github.com/shihabmks/testing/tree/master/chamnes/resources/views/layouts/app.blade.php">Click to open app.blade.php Page</a>
</pre></code>

Also we need to create pages for each navigation pages in our website.  so create a folder <b>pages</b> under <code>resources/views/</code> directory.

now we need to create page for Products page. So create one file named as <b>products.blade.php</b> under <code>resources/views/pages/</code> directory.

<code><pre>
Copy the content from the below link 
<a href="https://github.com/shihabmks/testing/tree/master/chamnes/resources/views/pages/products.blade.php">Click to open app.blade.php Page</a>
</pre></code>




