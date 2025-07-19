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
    
    class RedirectResponse {
        
    }
    
    class JsonResponse {
        
    }
}

namespace Illuminate\View {
    class View {
        
    }
}

namespace Illuminate\Foundation\Http {
    class FormRequest {
        
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
            return 0;
        }
        
        public function get() {
            return [];
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
                    // Return mock data for demo
                    return [
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
                }
                
                public function first() {
                    $results = $this->get();
                    return !empty($results) ? $results[0] : null;
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
            return new static();
        }
        
        public static function active() {
            return static::query()->active();
        }
        
        public static function parents() {
            return static::query()->parents();
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
        
        public function belongsTo($related) {
            return new \Illuminate\Database\Eloquent\Relations\BelongsTo();
        }
        
        public function hasMany($related) {
            return new \Illuminate\Database\Eloquent\Relations\HasMany();
        }
        
        public function hasOne($related) {
            return new \Illuminate\Database\Eloquent\Relations\HasOne();
        }
        
        public function belongsToMany($related) {
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

namespace {
    // Global helper functions
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
                                    return [];
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
            return new class($url) {
                private $url;
                
                public function __construct($url) {
                    $this->url = $url;
                }
                
                public function route($name, $params = []) {
                    $this->url = route($name, $params);
                    return $this;
                }
                
                public function with($key, $value) {
                    $_SESSION['flash'][$key] = $value;
                    return $this;
                }
                
                public function back() {
                    $this->url = $_SERVER['HTTP_REFERER'] ?? '/';
                    return $this;
                }
                
                public function __toString() {
                    if ($this->url) {
                        header("Location: {$this->url}");
                        exit;
                    }
                    return '';
                }
            };
        }
    }
}
