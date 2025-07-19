<?php

// Simple base classes first
namespace Illuminate\Support\Facades {
    class DB {
        public static function beginTransaction() {
            return true;
        }
        
        public static function commit() {
            return true;
        }
        
        public static function rollback() {
            return true;
        }
    }
    
    class Route {
        private static $routes = [];
        
        public static function get($uri, $action) {
            self::$routes[] = ['method' => 'GET', 'uri' => $uri, 'action' => $action];
            return new self();
        }
        
        public static function post($uri, $action) {
            self::$routes[] = ['method' => 'POST', 'uri' => $uri, 'action' => $action];
            return new self();
        }
        
        public static function put($uri, $action) {
            self::$routes[] = ['method' => 'PUT', 'uri' => $uri, 'action' => $action];
            return new self();
        }
        
        public static function delete($uri, $action) {
            self::$routes[] = ['method' => 'DELETE', 'uri' => $uri, 'action' => $action];
            return new self();
        }
        
        public static function resource($name, $controller) {
            return new self();
        }
        
        public static function controller($controller) {
            return new self();
        }
        
        public static function middleware($middleware) {
            return new self();
        }
        
        public static function prefix($prefix) {
            return new self();
        }
        
        public static function group($callback) {
            if (is_callable($callback)) {
                $callback();
            }
            return new self();
        }
        
        public function name($name) {
            return $this;
        }
        
        public function only($methods) {
            return $this;
        }
    }
}

namespace Illuminate\Contracts\Http {
    interface Kernel {
        
    }
}

namespace Illuminate\Http {
    class Request {
        public $product_id;
        public $quantity;
        public $shipping_address_id;
        public $billing_address_id;
        public $billing_same_as_shipping;
        public $payment_method;
        
        public function validate($rules) {
            return $this;
        }
        
        public function input($key, $default = null) {
            return $_POST[$key] ?? $_GET[$key] ?? $default;
        }
        
        public function only(...$keys) {
            $result = [];
            $allKeys = [];
            foreach ($keys as $key) {
                if (is_array($key)) {
                    $allKeys = array_merge($allKeys, $key);
                } else {
                    $allKeys[] = $key;
                }
            }
            foreach ($allKeys as $key) {
                $result[$key] = $this->input($key);
            }
            return $result;
        }
        
        public function boolean($key, $default = false) {
            $value = $this->input($key);
            return filter_var($value, FILTER_VALIDATE_BOOLEAN);
        }
        
        public function session() {
            return new class {
                public function regenerate() {
                    session_regenerate_id(true);
                }
                
                public function invalidate() {
                    session_destroy();
                }
                
                public function regenerateToken() {
                    // CSRF token regeneration would go here
                }
            };
        }
        
        public function filled($key) {
            $value = $this->input($key);
            return !empty($value);
        }
        
        public static function capture() {
            return new static();
        }
        
        public function __get($key) {
            return $this->input($key);
        }
    }
    
    class JsonResponse {
        
    }
}

namespace Illuminate\View {
    class View {
        
    }
}

namespace Illuminate\Http {
    class RedirectResponse {
        private $url;
        
        public function __construct($url) {
            $this->url = $url;
        }
        
        public function with($key, $value) {
            $_SESSION['flash'][$key] = $value;
            return $this;
        }
        
        public function withErrors($errors) {
            $_SESSION['errors'] = $errors;
            return $this;
        }
        
        public function onlyInput($keys) {
            $_SESSION['old_input'] = [];
            foreach ((array)$keys as $key) {
                $_SESSION['old_input'][$key] = $_POST[$key] ?? $_GET[$key] ?? '';
            }
            return $this;
        }
        
        public function __toString() {
            header("Location: {$this->url}");
            exit;
        }
    }
}

namespace Illuminate\Database\Eloquent\Relations {
    class BelongsTo {
        public $manage_stock = true;
        public $stock_quantity = 10;
        public $price = 100;
        public $sale_price = 90;
        
        public function __get($key) {
            return $this->$key ?? null;
        }
    }
    
    class HasMany {
        public function sum($column = null) {
            if (is_callable($column)) {
                return 0; // Mock sum for callback
            }
            return 0; // Mock sum for column
        }
        
        public function get() {
            return new class {
                public function sum($column = null) {
                    if (is_callable($column)) {
                        return 0; // Mock sum for callback
                    }
                    return 0; // Mock sum for column
                }
            };
        }
        
        public function first() {
            return null;
        }
    }
    
    class HasOne {
        
    }
    
    class BelongsToMany {
        
    }
}

namespace Illuminate\Database\Eloquent\Factories {
    trait HasFactory {
        
    }
}

// Simple Model base class
namespace Illuminate\Database\Eloquent {
    class Model {
        protected $fillable = [];
        protected $casts = [];
        
        public static function with($relations) {
            return static::query()->with($relations);
        }
        
        public static function where($column, $operator = null, $value = null) {
            return static::query()->where($column, $operator, $value);
        }
        
        public static function find($id) {
            return new static();
        }
        
        public static function all() {
            return static::query()->get();
        }
        
        public static function query() {
            return new class {
                public function with($relations) {
                    return $this;
                }
                
                public function where($column, $operator = null, $value = null) {
                    return $this;
                }
                
                public function when($condition, $callback) {
                    if ($condition) {
                        $callback($this);
                    }
                    return $this;
                }
                
                public function take($limit) {
                    return $this;
                }
                
                public function limit($limit) {
                    return $this;
                }
                
                public function orderBy($column, $direction = 'asc') {
                    return $this;
                }
                
                public function whereHas($relation, $callback = null) {
                    return $this;
                }
                
                public function withCount($relations) {
                    return $this;
                }
                
                public function sum($column = null) {
                    return 0;
                }
                
                public function count() {
                    return 5;
                }
                
                public function get() {
                    // Return mock data for demo with collection-like methods
                    $data = [
                        (object)[
                            'id' => 1,
                            'name' => 'Premium Office Chair',
                            'slug' => 'premium-office-chair',
                            'price' => 15999,
                            'sale_price' => 12999,
                            'featured_image' => '/images/chair-1.jpg',
                            'is_featured' => true,
                            'stock_quantity' => 25,
                            'category' => (object)['name' => 'Office Chairs'],
                            'category_id' => 1
                        ],
                        (object)[
                            'id' => 2,
                            'name' => 'Executive Desk',
                            'slug' => 'executive-desk',
                            'price' => 25999,
                            'sale_price' => null,
                            'featured_image' => '/images/desk-1.jpg',
                            'is_featured' => true,
                            'stock_quantity' => 15,
                            'category' => (object)['name' => 'Desks'],
                            'category_id' => 2
                        ],
                        (object)[
                            'id' => 3,
                            'name' => 'Ergonomic Sofa',
                            'slug' => 'ergonomic-sofa',
                            'price' => 45999,
                            'sale_price' => 39999,
                            'featured_image' => '/images/sofa-1.jpg',
                            'is_featured' => false,
                            'stock_quantity' => 8,
                            'category' => (object)['name' => 'Sofas'],
                            'category_id' => 3
                        ]
                    ];
                    
                    return new class($data) {
                        private $data;
                        
                        public function __construct($data) {
                            $this->data = $data;
                        }
                        
                        public function map($callback) {
                            return array_map($callback, $this->data);
                        }
                        
                        public function sum($column = null) {
                            if (is_callable($column)) {
                                return array_sum(array_map($column, $this->data));
                            }
                            return 0;
                        }
                        
                        public function count() {
                            return count($this->data);
                        }
                        
                        public function toArray() {
                            return $this->data;
                        }
                        
                        public function isEmpty() {
                            return empty($this->data);
                        }
                    };
                }
                
                public function first() {
                    $results = $this->get();
                    $data = $results->toArray();
                    return !empty($data) ? $data[0] : null;
                }
                
                public function delete() {
                    return true;
                }
                
                public function active() {
                    return $this;
                }
                
                public function featured() {
                    return $this;
                }
                
                public function inStock() {
                    return $this;
                }
                
                public function latest($column = 'created_at') {
                    return $this->orderBy($column, 'desc');
                }
                
                public function orWhere($column, $operator = null, $value = null) {
                    return $this;
                }
                
                public function parents() {
                    return $this;
                }
                
                public function paginate($perPage = 15) {
                    return [];
                }
            };
        }
        
        public static function findOrFail($id) {
            return new static();
        }
        
        public static function create($attributes) {
            $instance = new static();
            foreach ($attributes as $key => $value) {
                $instance->$key = $value;
            }
            // Mock: simulate saving to database
            $instance->id = rand(1, 1000);
            return $instance;
        }
        
        public static function active() {
            return static::query()->active();
        }
        
        public static function parents() {
            return static::query()->parents();
        }
        
        public static function count() {
            return rand(10, 100); // Mock count
        }
        
        public static function withCount($relations) {
            return static::query();
        }
        
        public static function selectRaw($sql) {
            return static::query();
        }
        
        public function load($relations) {
            return $this;
        }
        
        public function update($attributes) {
            return true;
        }
        
        public function delete() {
            return true;
        }
        
        public function toArray() {
            return [];
        }
        
        public function belongsTo($related, $foreignKey = null, $ownerKey = null) {
            return new \Illuminate\Database\Eloquent\Relations\BelongsTo();
        }
        
        public function hasMany($related, $foreignKey = null, $localKey = null) {
            return new \Illuminate\Database\Eloquent\Relations\HasMany();
        }
        
        public function hasOne($related, $foreignKey = null, $localKey = null) {
            return new \Illuminate\Database\Eloquent\Relations\HasOne();
        }
        
        public function belongsToMany($related, $table = null, $foreignPivotKey = null, $relatedPivotKey = null) {
            return new \Illuminate\Database\Eloquent\Relations\BelongsToMany();
        }
        
        public function __get($key) {
            return null;
        }
        
        public function __set($key, $value) {
            $this->$key = $value;
        }
    }
}

namespace Illuminate\Database {
    class Seeder {
        public function run() {
            // Override in child classes
        }
    }
}

// Support facades
namespace Illuminate\Support\Facades {
    // Add Auth facade
    class Auth {
        public static function attempt($credentials, $remember = false) {
            // Mock authentication - always return true for demo
            $_SESSION['user_id'] = 1;
            $_SESSION['user_name'] = 'Demo User';
            $_SESSION['user_email'] = $credentials['email'] ?? 'demo@example.com';
            return true;
        }
        
        public static function user() {
            return auth()->user();
        }
        
        public static function login($user) {
            $_SESSION['user_id'] = $user->id ?? 1;
            $_SESSION['user_name'] = $user->name ?? 'Demo User';
            $_SESSION['user_email'] = $user->email ?? 'demo@example.com';
        }
        
        public static function logout() {
            unset($_SESSION['user_id'], $_SESSION['user_name'], $_SESSION['user_email']);
        }
        
        public static function check() {
            return auth()->check();
        }
    }
    
    // Add Hash facade
    class Hash {
        public static function make($value) {
            return password_hash($value, PASSWORD_DEFAULT);
        }
        
        public static function check($value, $hashedValue) {
            return password_verify($value, $hashedValue);
        }
    }
}

namespace Illuminate\Support {
    // Add Str utility class
    class Str {
        public static function slug($title, $separator = '-') {
            $slug = preg_replace('/[^A-Za-z0-9-]+/', $separator, $title);
            return strtolower(trim($slug, $separator));
        }
    }
}

namespace Illuminate\Validation\Rules {
    class Password {
        public static function defaults() {
            return 'required|min:8';
        }
    }
}

namespace Laravel\Sanctum {
    trait HasApiTokens {
        // Mock API tokens functionality
    }
}

namespace Illuminate\Notifications {
    trait Notifiable {
        // Mock notifications functionality
    }
}

namespace Illuminate\Foundation\Auth {
    use Illuminate\Database\Eloquent\Model;
    
    class User extends Model {
        // Base authenticatable user functionality
        public static function create($attributes) {
            $instance = new static();
            foreach ($attributes as $key => $value) {
                $instance->$key = $value;
            }
            // Mock: simulate saving to database
            $instance->id = rand(1, 1000);
            return $instance;
        }
    }
}

namespace Illuminate\Database\Migrations {
    class Migration {
        public function up() {
            // Override in child classes
        }
        
        public function down() {
            // Override in child classes
        }
    }
}

namespace Illuminate\Database\Schema {
    class Blueprint {
        public function id() {
            return $this;
        }
        
        public function string($column, $length = null) {
            return $this;
        }
        
        public function text($column) {
            return $this;
        }
        
        public function integer($column) {
            return $this;
        }
        
        public function decimal($column, $precision = 8, $scale = 2) {
            return $this;
        }
        
        public function boolean($column) {
            return $this;
        }
        
        public function timestamp($column) {
            return $this;
        }
        
        public function timestamps() {
            return $this;
        }
        
        public function softDeletes() {
            return $this;
        }
        
        public function foreignId($column) {
            return $this;
        }
        
        public function constrained($table = null) {
            return $this;
        }
        
        public function onDelete($action) {
            return $this;
        }
        
        public function nullable() {
            return $this;
        }
        
        public function unique() {
            return $this;
        }
        
        public function index() {
            return $this;
        }
        
        public function default($value) {
            return $this;
        }
        
        public function rememberToken() {
            return $this;
        }
        
        public function email() {
            return $this;
        }
        
        public function dateTime($column) {
            return $this;
        }
    }
}

namespace Illuminate\Support\Facades {
    // Schema facade
    class Schema {
        public static function create($table, $callback) {
            $blueprint = new \Illuminate\Database\Schema\Blueprint();
            $callback($blueprint);
            // Mock: would actually create table
            return true;
        }
        
        public static function dropIfExists($table) {
            // Mock: would actually drop table
            return true;
        }
        
        public static function table($table, $callback) {
            $blueprint = new \Illuminate\Database\Schema\Blueprint();
            $callback($blueprint);
            // Mock: would actually modify table
            return true;
        }
    }
}

namespace Symfony\Component\HttpFoundation {
    class Response {
        public function __construct($content = '', $status = 200, $headers = []) {
            // Mock response
        }
    }
}

namespace {
    // Global helper functions
    if (!function_exists('now')) {
        function now() {
            return date('Y-m-d H:i:s');
        }
    }

    if (!function_exists('request')) {
        function request($key = null, $default = null) {
            $request = \Illuminate\Http\Request::capture();
            
            return new class($request) {
                private $request;
                
                public function __construct($request) {
                    $this->request = $request;
                }
                
                public function routeIs($pattern) {
                    // Mock route matching - always return false for demo
                    return false;
                }
                
                public function route() {
                    return new class {
                        public function getName() {
                            return 'home'; // Mock route name
                        }
                    };
                }
                
                public function is($pattern) {
                    return false; // Mock URL pattern matching
                }
                
                public function url() {
                    return $_SERVER['REQUEST_URI'] ?? '/';
                }
                
                public function fullUrl() {
                    return 'http://localhost' . ($_SERVER['REQUEST_URI'] ?? '/');
                }
            };
        }
    }

    if (!function_exists('view')) {
        function view($template, $data = []) {
            return new class($template, $data) extends \Illuminate\View\View {
                private $template;
                private $data;
                
                public function __construct($template, $data) {
                    $this->template = $template;
                    $this->data = $data;
                }
                
                public function __toString() {
                    ob_start();
                    extract($this->data);
                    $templatePath = __DIR__ . "/../resources/views/" . str_replace('.', '/', $this->template) . ".blade.php";
                    if (file_exists($templatePath)) {
                        include $templatePath;
                    } else {
                        echo "<h1>Template not found: {$this->template}</h1>";
                    }
                    return ob_get_clean();
                }
            };
        }
    }

    if (!function_exists('route')) {
        function route($name, $params = []) {
            $routes = [
                'home' => '/',
                'products.index' => '/products',
                'products.show' => '/products/' . ($params[0] ?? '{id}'),
                'cart.index' => '/cart',
                'login' => '/login',
                'register' => '/register',
                'logout' => '/logout',
                'admin.dashboard' => '/admin',
                'categories.show' => '/categories/' . ($params[0] ?? '{slug}'),
                'profile.index' => '/profile',
                'orders.index' => '/orders',
                'auth.login' => '/login',
                'auth.register' => '/register',
                'auth.logout' => '/logout',
                'checkout.index' => '/checkout',
                'checkout.process' => '/checkout/process',
                'checkout.success' => '/checkout/success',
                'orders.show' => '/orders/' . ($params[0] ?? '{id}'),
                'orders.invoice' => '/orders/' . ($params[0] ?? '{id}') . '/invoice',
                'terms' => '/terms',
                'privacy' => '/privacy',
                'admin.products.index' => '/admin/products',
                'admin.products.create' => '/admin/products/create',
            ];
            
            return $routes[$name] ?? '#';
        }
    }

    if (!function_exists('asset')) {
        function asset($path) {
            return '/' . ltrim($path, '/');
        }
    }

    if (!function_exists('csrf_token')) {
        function csrf_token() {
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
            if (!isset($_SESSION['csrf_token'])) {
                $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
            }
            return $_SESSION['csrf_token'];
        }
    }

    if (!function_exists('auth')) {
        function auth() {
            return new class {
                public function user() {
                    return new class {
                        public $name = 'Demo User';
                        public $first_name = 'Demo';
                        public $last_name = 'User';
                        public $email = 'demo@nilkamal.com';
                        public $cart_quantity = 2;
                        
                        public function isAdmin() {
                            return false;
                        }
                        
                        public function cartItems() {
                            return new class {
                                public function with($relations) {
                                    return $this;
                                }
                                
                                public function get() {
                                    $data = []; // Empty cart for demo
                                    
                                    return new class($data) {
                                        private $data;
                                        
                                        public function __construct($data) {
                                            $this->data = $data;
                                        }
                                        
                                        public function isEmpty() {
                                            return empty($this->data);
                                        }
                                        
                                        public function sum($column = null) {
                                            if (is_callable($column)) {
                                                return array_sum(array_map($column, $this->data));
                                            }
                                            return 0;
                                        }
                                        
                                        public function count() {
                                            return count($this->data);
                                        }
                                        
                                        public function toArray() {
                                            return $this->data;
                                        }
                                    };
                                }
                                
                                public function sum($callback = null) {
                                    return 0;
                                }
                            };
                        }
                        
                        public function addresses() {
                            return new class {
                                public function get() {
                                    return [];
                                }
                            };
                        }
                    };
                }
                
                public function check() {
                    return true;
                }
                
                public function id() {
                    return 1; // Mock user ID for demo
                }
                
                public function guest() {
                    return false;
                }
            };
        }
    }

    if (!function_exists('old')) {
        function old($key, $default = null) {
            return $_SESSION['old_input'][$key] ?? $default;
        }
    }

    if (!function_exists('session')) {
        function session($key = null, $default = null) {
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
            
            if ($key === null) {
                return $_SESSION;
            }
            
            return $_SESSION[$key] ?? $default;
        }
    }

    if (!function_exists('number_format')) {
        // This function already exists in PHP, but just in case
    }

    if (!function_exists('redirect')) {
        function redirect($url = null) {
            if ($url) {
                return new \Illuminate\Http\RedirectResponse($url);
            }
            
            return new class {
                public function route($name, $params = []) {
                    $url = route($name, $params);
                    return new \Illuminate\Http\RedirectResponse($url);
                }
                
                public function intended($default = '/') {
                    $url = $_SESSION['intended_url'] ?? $default;
                    unset($_SESSION['intended_url']);
                    return new \Illuminate\Http\RedirectResponse($url);
                }
                
                public function back() {
                    $url = $_SERVER['HTTP_REFERER'] ?? '/';
                    return new \Illuminate\Http\RedirectResponse($url);
                }
            };
        }
    }

    if (!function_exists('response')) {
        function response($content = '', $status = 200) {
            return new class($content, $status) {
                private $content;
                private $status;
                
                public function __construct($content, $status) {
                    $this->content = $content;
                    $this->status = $status;
                }
                
                public function json($data, $status = 200) {
                    header('Content-Type: application/json');
                    http_response_code($status);
                    echo json_encode($data);
                    return $this;
                }
                
                public function view($view, $data = []) {
                    return view($view, $data);
                }
                
                public function with($key, $value) {
                    $_SESSION['flash'][$key] = $value;
                    return $this;
                }
            };
        }
    }

    if (!function_exists('back')) {
        function back() {
            $url = $_SERVER['HTTP_REFERER'] ?? '/';
            return new \Illuminate\Http\RedirectResponse($url);
        }
    }

    if (!function_exists('abort')) {
        function abort($code, $message = '') {
            http_response_code($code);
            if ($code == 403) {
                echo "403 Forbidden";
            } elseif ($code == 404) {
                echo "404 Not Found";
            } else {
                echo "$code Error";
            }
            exit;
        }
    }
}

