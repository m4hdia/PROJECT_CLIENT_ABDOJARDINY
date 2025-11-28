# Jardinier Pro - Premium Gardening & Landscaping Website

A premium, modern, bilingual (French & Arabic) website for a gardening and landscaping business built with Laravel.

## Features

- ✅ **Bilingual Support** - Full French (LTR) and Arabic (RTL) translations with language switcher
- ✅ **Premium Modern Design** - Clean, nature-inspired UI with smooth micro-animations
- ✅ **Fully Responsive** - Mobile, tablet, and desktop optimized
- ✅ **Accessibility** - Basic a11y support with alt tags, keyboard navigation, and good contrast
- ✅ **SEO Ready** - Meta tags, semantic HTML, optimized images
- ✅ **Performance Optimized** - Lazy loading images, optimized assets
- ✅ **Contact Form** - AJAX-powered with email integration
- ✅ **WhatsApp Integration** - Quick contact via WhatsApp
- ✅ **Gallery with Lightbox** - Filterable project gallery with image lightbox
- ✅ **Testimonials Section** - Client testimonials slider

## Pages

1. **Homepage** - Hero section, services overview, gallery preview, about summary, testimonials, contact strip
2. **Services** - Detailed list of all services with descriptions and benefits
3. **Gallery** - Filterable masonry gallery with lightbox
4. **About** - Company story, team, values, statistics
5. **Contact** - Contact form, WhatsApp button, contact information

## Installation

### Prerequisites

- PHP 8.2 or higher
- Composer
- Node.js and NPM (optional, for asset compilation)
- SQLite or MySQL/MariaDB

### Setup Steps

1. **Clone the repository** (if applicable) or navigate to the project directory

2. **Install dependencies:**
   ```bash
   composer install
   ```

3. **Create environment file:**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Configure database** in `.env`:
   ```env
   DB_CONNECTION=sqlite
   DB_DATABASE=/absolute/path/to/database/database.sqlite
   ```
   Or for MySQL:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=your_database
   DB_USERNAME=your_username
   DB_PASSWORD=your_password
   ```

5. **Run migrations:**
   ```bash
   php artisan migrate
   ```

6. **Start the development server:**
   ```bash
   php artisan serve
   ```

7. **Visit** `http://localhost:8000` in your browser

## Customization Guide

### Changing Translations

All translations are stored in JSON files:

- **French**: `resources/lang/fr.json`
- **Arabic**: `resources/lang/ar.json`

To add or modify translations:

1. Open the appropriate language file
2. Add your translation key-value pairs:
   ```json
   {
     "key.name": "Your translation here"
   }
   ```
3. Use in Blade templates:
   ```blade
   {{ __('key.name') }}
   ```

### Replacing Images

**Current Images**: The site uses placeholder images from Unsplash. All images need to be replaced with your unique high-quality garden/landscaping photos.

**Image Locations**:

1. **Hero Images** (Homepage, Services, Gallery, About, Contact):
   - Find the `<section>` tag with class `hero-section`
   - Replace the `background-image` URL in the `style` attribute

2. **Gallery Images**:
   - Open `resources/views/gallery.blade.php`
   - Replace all `src` and `href` attributes with your image URLs
   - Use high-resolution images (minimum 1200px width for full-size, 800px for thumbnails)

3. **About Section Images**:
   - Open `resources/views/welcome.blade.php` (homepage about section)
   - Open `resources/views/about.blade.php` (about page)
   - Replace image URLs in `background-image` styles or `<img src="">` tags

4. **Service Cards**: Currently use Font Awesome icons, but you can replace with images if desired

**Image Optimization Tips**:
- Use WebP format for better compression
- Optimize images before upload (use tools like TinyPNG, ImageOptim)
- Provide multiple sizes: thumbnail (400px), medium (800px), large (1200px+)
- Use `loading="lazy"` attribute for images below the fold

### Updating Logo

**Current Logo**: A simple icon-based logo (leaf icon) is used in the navbar.

**To Replace**:

1. Add your logo image to `public/images/logo.png` (or any format)
2. Open `resources/views/partials/navbar.blade.php`
3. Find the logo section (around line 10-15)
4. Replace the div with:
   ```blade
   <img src="{{ asset('images/logo.png') }}" alt="Jardinier Pro" class="h-12 w-auto">
   ```

### Changing Phone Number

**WhatsApp Links**:
1. Search for `wa.me/33123456789` in all files
2. Replace `33123456789` with your phone number (format: country code + number without + sign)
   - Example: `33612345678` for French number

**Contact Information**:
1. Update translations in `resources/lang/fr.json` and `resources/lang/ar.json`:
   - `contact.phone`
   - `contact.address`
   - `contact.email`
   - `contact.hours`

2. Update in `resources/views/contact.blade.php` and footer if hardcoded

### Updating Contact Form Email

1. Open `app/Http/Controllers/ContactController.php`
2. Find line with `$msg->to('anasbayaqour@gmail.com');`
3. Replace with your email address
4. Update email configuration in `.env`:
   ```env
   MAIL_MAILER=smtp
   MAIL_HOST=smtp.mailtrap.io
   MAIL_PORT=2525
   MAIL_USERNAME=your_username
   MAIL_PASSWORD=your_password
   MAIL_ENCRYPTION=tls
   MAIL_FROM_ADDRESS=noreply@yourdomain.com
   MAIL_FROM_NAME="${APP_NAME}"
   ```

### Changing Colors

The color scheme uses CSS variables in `resources/views/layouts/main.blade.php`:

```css
:root {
    --primary-green: #2d5016;
    --primary-green-light: #4a7c2c;
    --primary-green-lighter: #7fb04a;
    --accent-beige: #f5f1e8;
    --dark-gray: #1f2937;
    --soft-gray: #6b7280;
}
```

Replace these values to match your brand colors.

### Adding New Services

1. Add service details to `resources/views/services.blade.php`
2. Add translation keys to `fr.json` and `ar.json`
3. Add service option to contact form in `resources/views/contact.blade.php`

### Adding Gallery Images

1. Open `resources/views/gallery.blade.php`
2. Add new gallery items following the pattern:
   ```blade
   <div class="portfolio-item fade-in-up" data-category="your-category">
       <a href="full-size-image-url" data-lightbox="gallery" data-title="Image Title">
           <img src="thumbnail-image-url" alt="Description" class="w-full h-64 object-cover rounded-lg" loading="lazy">
       </a>
   </div>
   ```
3. Add filter button if needed in the filter section

## Deployment

### Production Checklist

1. **Environment Configuration**:
   ```bash
   APP_ENV=production
   APP_DEBUG=false
   ```

2. **Optimize Application**:
   ```bash
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   ```

3. **Assets**: The site uses CDN for Tailwind CSS and JavaScript libraries. For production, consider:
   - Downloading and hosting these locally
   - Using Laravel Mix or Vite to compile custom CSS/JS

4. **Server Configuration**:
   - Point document root to `public/` directory
   - Enable mod_rewrite (Apache) or configure Nginx properly
   - Set proper file permissions (755 for directories, 644 for files)

5. **Database**: Use MySQL/MariaDB or PostgreSQL in production instead of SQLite

6. **HTTPS**: Always use HTTPS in production (configure SSL certificate)

### Performance Tips

- Enable OPcache in PHP
- Use a CDN for images
- Implement image lazy loading (already included)
- Use browser caching headers
- Consider using a service like Cloudflare for additional optimization

## Structure

```
resources/
├── lang/
│   ├── fr.json          # French translations
│   └── ar.json          # Arabic translations
├── views/
│   ├── layouts/
│   │   └── main.blade.php    # Main layout
│   ├── partials/
│   │   ├── navbar.blade.php  # Navigation bar
│   │   └── footer.blade.php  # Footer
│   ├── welcome.blade.php     # Homepage
│   ├── services.blade.php    # Services page
│   ├── gallery.blade.php     # Gallery page
│   ├── about.blade.php       # About page
│   └── contact.blade.php     # Contact page
app/
├── Http/
│   ├── Controllers/
│   │   ├── ContactController.php    # Contact form handler
│   │   └── LanguageController.php   # Language switcher
└── Helpers/
    └── TranslationHelper.php        # Translation helper (if needed)
routes/
└── web.php                  # All routes
```

## Browser Support

- Chrome (latest)
- Firefox (latest)
- Safari (latest)
- Edge (latest)
- Mobile browsers (iOS Safari, Chrome Mobile)

## License

This project is proprietary. All rights reserved.

## Support

For questions or issues, please contact the development team.

---

**Note**: Remember to replace all placeholder images with your actual high-quality garden/landscaping photography. Each image should be unique and realistic. Avoid using the same stock photos multiple times.

## Image Credits

Currently using placeholder images from Unsplash. All images must be replaced with:
- Your own photography
- Licensed stock images
- Images with proper attribution if required

---

**Built with ❤️ using Laravel**
#   P R O J E C T _ C L I E N T _ A B D O J A R D I N Y  
 