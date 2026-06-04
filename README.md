# Event Management Theme

A custom WordPress Event Management platform built with a custom theme and MU plugin architecture.

The project provides a complete environment for managing:

* Events
* Professors
* Seminars
* User Notes
* Professor Likes
* Custom Search
* Custom Authentication Pages

The application is powered by WordPress Custom Post Types, Advanced Custom Fields (ACF), custom REST API endpoints, and a modern front-end build process.

---

## Features

### Event Management

* Custom Event post type
* Event archive page
* Upcoming event filtering
* Event date sorting
* Featured images support
* Comments support

### Professor Management

* Custom Professor post type
* Professor archive page
* Professor profile pages
* Like system for professors
* Featured images support
* Comments support

### Seminar Management

* Custom Seminar post type
* Seminar archive page
* Professor–Seminar relationships
* Featured images support
* Comments support

### Notes System

Authenticated users can:

* Create notes
* Update notes
* Delete notes

Additional security rules:

* Notes are automatically stored as Private posts
* Note content is sanitized before saving
* Maximum 5 notes per user

### Custom Search

A custom REST API search endpoint allows searching across:

* Pages
* Posts
* Events
* Professors
* Seminars

Related seminars are automatically included when matching professors are found.

### Professor Like System

Authenticated users can:

* Like professors
* Remove likes

The system prevents duplicate likes for the same professor.

### Authentication Customization

Includes:

* Custom login page
* Login page redirect
* Login error handling
* Custom login branding
* Custom login logo URL
* Custom login title

### User Experience Improvements

* Custom archive titles
* Subscriber dashboard restriction
* Subscriber admin bar removal
* Front-end login redirection

### Theme Features

* Featured images
* Dynamic page banners
* Custom logo support
* Dynamic page titles
* Responsive design
* Bootstrap integration
* Font Awesome integration

---

## Project Structure

```text
event-management-theme/
│
├── mu-plugins/
│   └── custom-post-type.php
│
└── themes/
    └── DevelopTheme/
        │
        ├── assets/
        ├── build/
        ├── inc/
        │   ├── custom-login.php
        │   ├── Likes_route.php
        │   └── search_route.php
        │
        ├── archive-event.php
        ├── archive-professor.php
        ├── archive-seminar.php
        ├── front-page.php
        ├── header.php
        ├── footer.php
        ├── functions.php
        └── style.css
```

---

## Custom Post Types

The project registers the following post types through an MU Plugin.

### Event

Slug:

```text
/events
```

Capabilities:

* Title
* Editor
* Excerpt
* Thumbnail
* Comments

### Professor

Slug:

```text
/professors
```

Capabilities:

* Title
* Editor
* Excerpt
* Thumbnail
* Comments

### Seminar

Slug:

```text
/seminars
```

Capabilities:

* Title
* Editor
* Excerpt
* Thumbnail
* Comments

### Note

Internal post type used by authenticated users.

Characteristics:

* Private
* REST enabled
* Limited to 5 notes per user

### Like

Internal post type used to store professor likes.

Characteristics:

* Hidden from public
* Stored per user

---

## REST API Endpoints

### Search Endpoint

```http
GET /wp-json/ataRoute/v1/search
```

Example:

```http
GET /wp-json/ataRoute/v1/search?keyword=wordpress
```

Returns:

* Pages
* Posts
* Events
* Professors
* Seminars

---

### Like Professor

Create Like:

```http
POST /wp-json/ataRoute/v1/like
```

Remove Like:

```http
DELETE /wp-json/ataRoute/v1/like
```

Authentication required.

---

## Dynamic Event Filtering

Upcoming events are automatically filtered using:

```php
pre_get_posts
```

Behavior:

* Past events are hidden
* Events are sorted by event date
* Closest upcoming events appear first

---

## Required Plugins

### Advanced Custom Fields (ACF)

The theme relies on ACF fields such as:

* event_date
* seminar_professor
* page_banner_background
* page_banner_description

Install and configure ACF before using the project.

---

## Front-End Stack

* WordPress
* PHP
* Bootstrap
* Font Awesome
* JavaScript
* REST API
* Webpack Build System

Compiled assets are located in:

```text
/build
```

---

## Installation

### 1. Clone Repository

```bash
git clone https://github.com/atta3554/wordpress.git
```

### 2. Copy MU Plugin

```text
mu-plugins/custom-post-type.php
```

to:

```text
wp-content/mu-plugins/
```

### 3. Copy Theme

```text
themes/DevelopTheme
```

to:

```text
wp-content/themes/
```

### 4. Install Required Plugins

* Advanced Custom Fields (ACF)

### 5. Activate Theme

WordPress Admin → Appearance → Themes → DevelopTheme

### 6. Flush Permalinks

Settings → Permalinks → Save Changes

---

## Security Features

* Sanitized note titles
* Sanitized note content
* Private note enforcement
* Like ownership validation
* Authentication checks for protected actions
* REST API nonce support

---

## Future Improvements

Potential enhancements:

* Custom capabilities for all CPTs
* Role management UI
* Event registration system
* Ticket booking
* Email notifications
* AJAX-powered archives
* PHPUnit tests
* Composer integration
* PSR-4 autoloading
* OOP architecture

---

## License

This project is provided for educational and development purposes.

Feel free to modify and extend it according to your requirements.
