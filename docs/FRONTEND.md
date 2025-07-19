# 🎨 Frontend Guide - Nilkamal Furniture Platform

## 🖼️ UI/UX Design System

### Design Principles
- **Mobile-First**: Responsive design for all devices
- **Clean & Modern**: Minimalist furniture-focused aesthetic
- **User-Friendly**: Intuitive navigation and interactions
- **Performance**: Fast loading and smooth transitions

### Color Palette
```css
Primary Blue:   #2563eb (bg-blue-600)
Secondary:      #1e40af (bg-blue-700)
Accent Yellow:  #eab308 (bg-yellow-500)
Success Green:  #16a34a (bg-green-600)
Warning Orange: #ea580c (bg-orange-600)
Error Red:      #dc2626 (bg-red-600)
Gray Scale:     #f8fafc to #1e293b
```

## 📱 Layout Structure

### Main Layout (`layouts/app.blade.php`)
```html
<!DOCTYPE html>
<html>
<head>
    <!-- Meta tags, CSS -->
</head>
<body>
    <!-- Navigation -->
    <nav class="sticky top-0 z-50">
        <!-- Logo, Menu, Cart, User -->
    </nav>
    
    <!-- Main Content -->
    <main>
        @yield('content')
    </main>
    
    <!-- Footer -->
    <footer>
        <!-- Links, Contact, Social -->
    </footer>
</body>
</html>
```

### Admin Layout (`layouts/admin.blade.php`)
```html
<div class="min-h-screen flex">
    <!-- Sidebar -->
    <div class="w-64 bg-gray-800">
        <!-- Admin Navigation -->
    </div>
    
    <!-- Main Content -->
    <div class="flex-1">
        <!-- Top Bar -->
        <header class="bg-white shadow">
            <!-- Page Title, User Menu -->
        </header>
        
        <!-- Page Content -->
        <main class="p-6">
            @yield('content')
        </main>
    </div>
</div>
```

## 🏠 Page Templates

### Homepage (`home.blade.php`)
- **Hero Section**: Eye-catching banner with CTAs
- **Categories Grid**: Visual category navigation
- **Featured Products**: Showcase best sellers
- **Features Section**: Trust indicators

### Product Pages
#### Product Index (`products/index.blade.php`)
- **Filter Sidebar**: Category, price, brand filters
- **Product Grid**: Card-based product display
- **Pagination**: Navigate through results
- **Sort Options**: Price, name, popularity

#### Product Detail (`products/show.blade.php`)
- **Image Gallery**: Product photos carousel
- **Product Info**: Name, price, description
- **Add to Cart**: Quantity selector and button
- **Related Products**: Similar items suggestion

### Shopping Flow
#### Cart (`cart/index.blade.php`)
- **Item List**: Products with quantities
- **Price Summary**: Subtotal, tax, shipping
- **Update Controls**: Quantity change, remove
- **Checkout Button**: Proceed to payment

#### Checkout (`checkout/index.blade.php`)
- **Shipping Form**: Address and contact details
- **Payment Options**: COD, online payment
- **Order Summary**: Final price breakdown
- **Place Order**: Submit order button

## 🎨 Component System

### Reusable Components

#### Product Card
```php
<!-- Product Card Component -->
<div class="bg-white shadow rounded-lg p-4">
    <img src="{{ $product->image }}" class="w-full h-48 object-cover">
    <h3 class="font-semibold mt-2">{{ $product->name }}</h3>
    <p class="text-blue-600 font-bold">₹{{ $product->price }}</p>
    <button class="w-full bg-blue-600 text-white py-2 rounded mt-2">
        Add to Cart
    </button>
</div>
```

#### Navigation Menu
```php
<!-- Navigation Component -->
<nav class="bg-white shadow-lg">
    <div class="max-w-7xl mx-auto px-4">
        <div class="flex justify-between items-center h-16">
            <!-- Logo -->
            <a href="/" class="font-bold text-xl">Nilkamal</a>
            
            <!-- Menu Items -->
            <div class="hidden md:flex space-x-4">
                <a href="/products" class="hover:text-blue-600">Products</a>
                <a href="/categories" class="hover:text-blue-600">Categories</a>
            </div>
            
            <!-- User Actions -->
            <div class="flex items-center space-x-4">
                <a href="/cart" class="relative">
                    <svg><!-- Cart Icon --></svg>
                    <span class="cart-count">{{ $cartCount }}</span>
                </a>
                <a href="/login">Login</a>
            </div>
        </div>
    </div>
</nav>
```

## 📱 Responsive Design

### Breakpoints (Tailwind CSS)
- **Mobile**: < 640px (sm)
- **Tablet**: 640px - 768px (md)
- **Desktop**: 768px - 1024px (lg)
- **Large**: > 1024px (xl)

### Grid System
```css
/* Mobile First Approach */
.product-grid {
    @apply grid grid-cols-1;      /* 1 column on mobile */
    @apply sm:grid-cols-2;        /* 2 columns on tablet */
    @apply lg:grid-cols-3;        /* 3 columns on desktop */
    @apply xl:grid-cols-4;        /* 4 columns on large screens */
}
```

## 🎯 Interactive Elements

### Forms
- Input validation with visual feedback
- Loading states during submission
- Success/error messages
- Autocomplete for address fields

### Shopping Cart
- Quantity adjustment controls
- Real-time price updates
- Remove item confirmations
- Empty state handling

### Product Browsing
- Image hover effects
- Quick view modals
- Wishlist functionality
- Filter persistence

## 🔧 Technical Implementation

### CSS Framework
- **Tailwind CSS**: Utility-first styling
- **Custom Components**: Reusable UI elements
- **Dark Mode**: Optional theme switching

### JavaScript Enhancement
- **Alpine.js**: Lightweight interactivity
- **HTMX**: Dynamic content loading
- **Cart Updates**: AJAX form submissions

### Performance Optimization
- **Image Lazy Loading**: Improve page speed
- **CSS Purging**: Remove unused styles
- **Asset Bundling**: Combine and minify files

## 📋 Form Design

### User-Friendly Forms
```html
<!-- Example Form Structure -->
<form class="space-y-4">
    <div>
        <label class="block text-sm font-medium mb-1">
            Product Name
        </label>
        <input type="text" 
               class="w-full border rounded px-3 py-2 focus:ring-2 focus:ring-blue-500"
               required>
        <span class="text-red-500 text-sm">Error message</span>
    </div>
    
    <button type="submit" 
            class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">
        Save Product
    </button>
</form>
```

## 🎨 Visual Hierarchy

### Typography Scale
- **H1**: 2.5rem (text-4xl) - Page titles
- **H2**: 2rem (text-3xl) - Section headers
- **H3**: 1.5rem (text-xl) - Subsections
- **Body**: 1rem (text-base) - Regular text
- **Small**: 0.875rem (text-sm) - Captions

### Spacing System
- **Sections**: py-16 (4rem vertical padding)
- **Cards**: p-6 (1.5rem all around)
- **Elements**: mb-4 (1rem bottom margin)
- **Grids**: gap-6 (1.5rem grid gaps)

---

**Next:** [Backend Guide →](BACKEND.md) | **Previous:** [← Architecture Guide](ARCHITECTURE.md)
