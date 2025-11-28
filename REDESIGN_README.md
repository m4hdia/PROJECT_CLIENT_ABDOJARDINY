# Premium Garden Website Redesign - Complete Guide

## Overview

This is a complete premium redesign of the gardening/landscaping website with:
- **Dark mode first** design with light mode toggle
- **Premium animated logo preloader**
- **Cinematic hero section** with parallax
- **Before/after project sliders**
- **Bilingual support** (French LTR + Arabic RTL)
- **Advanced micro-interactions** and animations
- **Fully responsive** and accessible
- **WhatsApp integration** for bookings

---

## Site Name Change

The default site name is now **"VERTE"**. To change it:

1. **Update translations**:
   - `resources/lang/fr.json` → `"meta.site_name": "YOUR_NAME"`
   - `resources/lang/ar.json` → `"meta.site_name": "YOUR_NAME"`

2. **Update logo text in preloader**:
   - `resources/views/layouts/main.blade.php` → Line with `{{ __('meta.site_name', 'VERTE') }}`

3. **Update title tags**:
   - `resources/lang/fr.json` → `"meta.title"`
   - `resources/lang/ar.json` → `"meta.title"`

---

## Changing Images

### Replace Hero Image
1. Place your hero image at `/public/images/hero-gardener-working.jpg`
2. Recommended size: 1920x1080px minimum
3. For video background (optional):
   - Place video at `/public/videos/gardening-hero-loop.mp4`
   - Uncomment video code in `resources/views/welcome.blade.php` (hero section)
   - Comment out the `.hero-parallax` div

### Replace Project Images
1. Place images in `/public/images/projects/`
2. Update image filenames in `resources/views/welcome.blade.php`:
   - Search for `/images/projects/` to find all image paths
   - Replace with your image filenames

**See `IMAGE_PLACEHOLDERS.md` for complete list of required images**

---

## Changing Phone Number

Update WhatsApp links throughout the site:

1. **Navbar**: `resources/views/partials/navbar.blade.php`
   - Replace `33123456789` in WhatsApp links

2. **Homepage**: `resources/views/welcome.blade.php`
   - Replace `33123456789` in all WhatsApp links

3. **Floating WhatsApp button**: `resources/views/layouts/main.blade.php`
   - Replace `33123456789` in the floating button link

4. **Translation files** (optional):
   - `resources/lang/fr.json` → `"contact.phone"`
   - `resources/lang/ar.json` → `"contact.phone"`

**Format**: WhatsApp uses international format without + or spaces (e.g., `33123456789`)

---

## Changing Logo

### Update Logo Icon
1. In `resources/views/partials/navbar.blade.php`:
   - Change the Font Awesome icon class in the logo div
   - Current: `<i class="fas fa-leaf"></i>`
   - Change to any Font Awesome icon: `<i class="fas fa-tree"></i>`

### Update Logo Image (If Using Image)
1. Place your logo image at `/public/images/logo.png`
2. Update navbar to use `<img>` instead of icon:
   ```blade
   <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-12 h-12">
   ```

### Update Preloader Logo
1. In `resources/views/layouts/main.blade.php`:
   - Find `.logo-icon` section
   - Change the icon class or replace with logo image

---

## Updating Translations

### French Translations
Edit `resources/lang/fr.json`

### Arabic Translations
Edit `resources/lang/ar.json`

### Add New Translation Keys
1. Add key to both `fr.json` and `ar.json`
2. Use in Blade templates: `{{ __('your.key', 'Default fallback') }}`

### Example
```json
// fr.json
"hero.new_text": "Nouveau texte"

// ar.json
"hero.new_text": "نص جديد"

// In Blade
{{ __('hero.new_text') }}
```

---

## Customizing Colors

### Dark Mode Colors
Edit CSS variables in `resources/views/layouts/main.blade.php`:
```css
:root {
    --dark-bg: #0a0e0b;
    --accent-green: #4ade80;
    --warm-accent: #d4a574;
    /* ... */
}
```

### Light Mode Colors
```css
:root {
    --light-bg: #fafaf8;
    --light-text-primary: #0a0e0b;
    /* ... */
}
```

---

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

3. **Assets**:
   - The site uses CDN for Tailwind CSS and libraries
   - For production, consider hosting these locally or using Laravel Mix/Vite

4. **Image Optimization**:
   - Ensure all images are optimized (WebP format recommended)
   - Use lazy loading for non-critical images
   - Provide responsive image sizes with `srcset`

5. **Server Configuration**:
   - Point document root to `public/` directory
   - Enable mod_rewrite (Apache) or configure Nginx
   - Set proper file permissions

6. **Database**: Use MySQL/MariaDB or PostgreSQL in production

7. **HTTPS**: Always use HTTPS in production

---

## Key Features

### Dark Mode Toggle
- Toggle button in navbar (desktop & mobile)
- Preference saved in localStorage
- Default: Dark mode
- Smooth transitions between modes

### Premium Preloader
- Animated logo reveal on homepage
- Skips after 2.5 seconds or click "Skip" button
- Only shows on homepage
- Customizable logo text/icon

### Before/After Sliders
- Interactive drag sliders
- Touch support for mobile
- Located in featured projects section
- Customize in `resources/views/welcome.blade.php`

### Floating WhatsApp Button
- Fixed position (respects RTL/LTR)
- Bottom right (or left in RTL)
- Always visible
- Customizable phone number

### Language Switcher
- Top navbar (desktop & mobile)
- Footer
- Switches between French (LTR) and Arabic (RTL)
- Updates direction and alignment automatically

---

## Performance Optimization

### Implemented
- ✅ Lazy loading images
- ✅ Reduced motion respect
- ✅ Will-change for animations
- ✅ Intersection Observer for scroll animations
- ✅ CSS variables for theming

### Recommended Additions
- Image CDN (Cloudflare, AWS CloudFront)
- Font preloading
- Service Worker for offline support
- Critical CSS inlining
- JavaScript code splitting

---

## Accessibility Features

- ✅ Semantic HTML
- ✅ Alt text for images (add your own)
- ✅ ARIA labels for buttons
- ✅ Keyboard navigation support
- ✅ Reduced motion support
- ✅ High contrast support (via dark mode)
- ✅ Focus indicators

---

## Browser Support

- Chrome (latest)
- Firefox (latest)
- Safari (latest)
- Edge (latest)
- Mobile browsers (iOS Safari, Chrome Mobile)

---

## Troubleshooting

### Preloader Not Showing
- Check if you're on homepage (`routeIs('home')`)
- Clear browser cache
- Check browser console for errors

### Dark Mode Not Working
- Clear localStorage: `localStorage.removeItem('darkMode')`
- Check if JavaScript is enabled
- Verify `toggleDarkMode()` function is loaded

### Images Not Loading
- Check file paths in `/public/images/`
- Ensure file permissions are correct (644)
- Check image file names match exactly

### Language Switcher Not Working
- Verify routes in `routes/web.php`
- Check `LanguageController` exists
- Clear route cache: `php artisan route:clear`

---

## Customization Tips

### Change Fonts
1. Update Google Fonts link in `main.blade.php`
2. Change `font-family` in CSS variables
3. Ensure fonts support Arabic if using Arabic

### Modify Animations
1. Edit animation durations in CSS
2. Adjust `IntersectionObserver` thresholds in JavaScript
3. Respect `prefers-reduced-motion` for accessibility

### Add New Sections
1. Add HTML in `welcome.blade.php`
2. Add styles in `@push('styles')`
3. Add translations to JSON files
4. Add scroll animations with `fade-in-up` class

---

## Support

For questions or issues:
1. Check this README
2. Review code comments
3. Check Laravel documentation
4. Contact development team

---

**Built with ❤️ using Laravel + Premium Design**



## Overview

This is a complete premium redesign of the gardening/landscaping website with:
- **Dark mode first** design with light mode toggle
- **Premium animated logo preloader**
- **Cinematic hero section** with parallax
- **Before/after project sliders**
- **Bilingual support** (French LTR + Arabic RTL)
- **Advanced micro-interactions** and animations
- **Fully responsive** and accessible
- **WhatsApp integration** for bookings

---

## Site Name Change

The default site name is now **"VERTE"**. To change it:

1. **Update translations**:
   - `resources/lang/fr.json` → `"meta.site_name": "YOUR_NAME"`
   - `resources/lang/ar.json` → `"meta.site_name": "YOUR_NAME"`

2. **Update logo text in preloader**:
   - `resources/views/layouts/main.blade.php` → Line with `{{ __('meta.site_name', 'VERTE') }}`

3. **Update title tags**:
   - `resources/lang/fr.json` → `"meta.title"`
   - `resources/lang/ar.json` → `"meta.title"`

---

## Changing Images

### Replace Hero Image
1. Place your hero image at `/public/images/hero-gardener-working.jpg`
2. Recommended size: 1920x1080px minimum
3. For video background (optional):
   - Place video at `/public/videos/gardening-hero-loop.mp4`
   - Uncomment video code in `resources/views/welcome.blade.php` (hero section)
   - Comment out the `.hero-parallax` div

### Replace Project Images
1. Place images in `/public/images/projects/`
2. Update image filenames in `resources/views/welcome.blade.php`:
   - Search for `/images/projects/` to find all image paths
   - Replace with your image filenames

**See `IMAGE_PLACEHOLDERS.md` for complete list of required images**

---

## Changing Phone Number

Update WhatsApp links throughout the site:

1. **Navbar**: `resources/views/partials/navbar.blade.php`
   - Replace `33123456789` in WhatsApp links

2. **Homepage**: `resources/views/welcome.blade.php`
   - Replace `33123456789` in all WhatsApp links

3. **Floating WhatsApp button**: `resources/views/layouts/main.blade.php`
   - Replace `33123456789` in the floating button link

4. **Translation files** (optional):
   - `resources/lang/fr.json` → `"contact.phone"`
   - `resources/lang/ar.json` → `"contact.phone"`

**Format**: WhatsApp uses international format without + or spaces (e.g., `33123456789`)

---

## Changing Logo

### Update Logo Icon
1. In `resources/views/partials/navbar.blade.php`:
   - Change the Font Awesome icon class in the logo div
   - Current: `<i class="fas fa-leaf"></i>`
   - Change to any Font Awesome icon: `<i class="fas fa-tree"></i>`

### Update Logo Image (If Using Image)
1. Place your logo image at `/public/images/logo.png`
2. Update navbar to use `<img>` instead of icon:
   ```blade
   <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-12 h-12">
   ```

### Update Preloader Logo
1. In `resources/views/layouts/main.blade.php`:
   - Find `.logo-icon` section
   - Change the icon class or replace with logo image

---

## Updating Translations

### French Translations
Edit `resources/lang/fr.json`

### Arabic Translations
Edit `resources/lang/ar.json`

### Add New Translation Keys
1. Add key to both `fr.json` and `ar.json`
2. Use in Blade templates: `{{ __('your.key', 'Default fallback') }}`

### Example
```json
// fr.json
"hero.new_text": "Nouveau texte"

// ar.json
"hero.new_text": "نص جديد"

// In Blade
{{ __('hero.new_text') }}
```

---

## Customizing Colors

### Dark Mode Colors
Edit CSS variables in `resources/views/layouts/main.blade.php`:
```css
:root {
    --dark-bg: #0a0e0b;
    --accent-green: #4ade80;
    --warm-accent: #d4a574;
    /* ... */
}
```

### Light Mode Colors
```css
:root {
    --light-bg: #fafaf8;
    --light-text-primary: #0a0e0b;
    /* ... */
}
```

---

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

3. **Assets**:
   - The site uses CDN for Tailwind CSS and libraries
   - For production, consider hosting these locally or using Laravel Mix/Vite

4. **Image Optimization**:
   - Ensure all images are optimized (WebP format recommended)
   - Use lazy loading for non-critical images
   - Provide responsive image sizes with `srcset`

5. **Server Configuration**:
   - Point document root to `public/` directory
   - Enable mod_rewrite (Apache) or configure Nginx
   - Set proper file permissions

6. **Database**: Use MySQL/MariaDB or PostgreSQL in production

7. **HTTPS**: Always use HTTPS in production

---

## Key Features

### Dark Mode Toggle
- Toggle button in navbar (desktop & mobile)
- Preference saved in localStorage
- Default: Dark mode
- Smooth transitions between modes

### Premium Preloader
- Animated logo reveal on homepage
- Skips after 2.5 seconds or click "Skip" button
- Only shows on homepage
- Customizable logo text/icon

### Before/After Sliders
- Interactive drag sliders
- Touch support for mobile
- Located in featured projects section
- Customize in `resources/views/welcome.blade.php`

### Floating WhatsApp Button
- Fixed position (respects RTL/LTR)
- Bottom right (or left in RTL)
- Always visible
- Customizable phone number

### Language Switcher
- Top navbar (desktop & mobile)
- Footer
- Switches between French (LTR) and Arabic (RTL)
- Updates direction and alignment automatically

---

## Performance Optimization

### Implemented
- ✅ Lazy loading images
- ✅ Reduced motion respect
- ✅ Will-change for animations
- ✅ Intersection Observer for scroll animations
- ✅ CSS variables for theming

### Recommended Additions
- Image CDN (Cloudflare, AWS CloudFront)
- Font preloading
- Service Worker for offline support
- Critical CSS inlining
- JavaScript code splitting

---

## Accessibility Features

- ✅ Semantic HTML
- ✅ Alt text for images (add your own)
- ✅ ARIA labels for buttons
- ✅ Keyboard navigation support
- ✅ Reduced motion support
- ✅ High contrast support (via dark mode)
- ✅ Focus indicators

---

## Browser Support

- Chrome (latest)
- Firefox (latest)
- Safari (latest)
- Edge (latest)
- Mobile browsers (iOS Safari, Chrome Mobile)

---

## Troubleshooting

### Preloader Not Showing
- Check if you're on homepage (`routeIs('home')`)
- Clear browser cache
- Check browser console for errors

### Dark Mode Not Working
- Clear localStorage: `localStorage.removeItem('darkMode')`
- Check if JavaScript is enabled
- Verify `toggleDarkMode()` function is loaded

### Images Not Loading
- Check file paths in `/public/images/`
- Ensure file permissions are correct (644)
- Check image file names match exactly

### Language Switcher Not Working
- Verify routes in `routes/web.php`
- Check `LanguageController` exists
- Clear route cache: `php artisan route:clear`

---

## Customization Tips

### Change Fonts
1. Update Google Fonts link in `main.blade.php`
2. Change `font-family` in CSS variables
3. Ensure fonts support Arabic if using Arabic

### Modify Animations
1. Edit animation durations in CSS
2. Adjust `IntersectionObserver` thresholds in JavaScript
3. Respect `prefers-reduced-motion` for accessibility

### Add New Sections
1. Add HTML in `welcome.blade.php`
2. Add styles in `@push('styles')`
3. Add translations to JSON files
4. Add scroll animations with `fade-in-up` class

---

## Support

For questions or issues:
1. Check this README
2. Review code comments
3. Check Laravel documentation
4. Contact development team

---

**Built with ❤️ using Laravel + Premium Design**


