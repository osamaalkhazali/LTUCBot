# 🎓 LTUC AI Assistant

<div align="center">
  <img src="public/assets/images/LTUCBot.png" alt="LTUC AI Assistant" width="120" height="120">
  
  **Intelligent Learning Companion for Modern Education**
  
  [![Laravel](https://img.shields.io/badge/Laravel-11.31-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)](https://laravel.com)
  [![PHP](https://img.shields.io/badge/PHP-8.2+-777BB4?style=for-the-badge&logo=php&logoColor=white)](https://php.net)
  [![Docker](https://img.shields.io/badge/Docker-Ready-2496ED?style=for-the-badge&logo=docker&logoColor=white)](https://docker.com)
  [![OpenAI](https://img.shields.io/badge/OpenAI-GPT--4o-412991?style=for-the-badge&logo=openai&logoColor=white)](https://openai.com)
  [![TailwindCSS](https://img.shields.io/badge/Tailwind-3.1-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white)](https://tailwindcss.com)

  ### 🌐 Live Deployments
  
  **Production:** [https://ltucbot.up.railway.app/](https://ltucbot.up.railway.app/)  
  **Backup:** [https://ltucbot.onrender.com/](https://ltucbot.onrender.com/)  
  **Database:** Hosted on [Clever Cloud](https://clever-cloud.com) MySQL
</div>

## 📋 Table of Contents

-   [About the Project](#-about-the-project)
-   [Why Laravel over Python?](#-why-laravel-over-python)
-   [Features](#-features)
-   [Technologies](#-technologies)
-   [Installation](#-installation)
-   [Docker Deployment](#-docker-deployment)
-   [Configuration](#-configuration)
-   [Usage](#-usage)
-   [File Processing](#-file-processing)
-   [API Integration](#-api-integration)
-   [Contributing](#-contributing)
-   [License](#-license)

## 🚀 About the Project

LTUC AI Assistant is a cutting-edge educational platform that leverages OpenAI's GPT-4o model to provide intelligent academic support. Built with Laravel 11 and modern web technologies, it offers students 24/7 access to an AI-powered learning companion capable of processing multiple file formats and providing comprehensive educational assistance.

### 🎯 Mission

Transform the educational experience by providing instant, intelligent, and personalized academic support through advanced AI technology, while maintaining a robust, scalable, and user-friendly web application architecture.

### 🌟 Project Highlights

- **Multi-Platform Deployment**: Running on Railway and Render for high availability
- **Cloud Database**: MySQL database hosted on Clever Cloud for reliability
- **Enterprise-Grade Architecture**: Built with Laravel for scalability and maintainability
- **Modern UI/UX**: Responsive design with TailwindCSS and mobile-first approach
- **Advanced File Processing**: Supports 30+ file formats with intelligent content extraction
- **Real-time Chat**: Persistent chat history with user authentication

## 🤔 Why Laravel over Python?

While we acknowledge that **Python is the dominant language in AI and machine learning** ecosystems, we chose Laravel/PHP for this educational platform for several compelling reasons:

### 🔐 **Superior Authentication & User Management**
- **Built-in Laravel Breeze**: Complete authentication system out of the box
- **Robust Session Management**: Secure user sessions and CSRF protection
- **Role-Based Access Control**: Easy implementation of user roles and permissions
- **Password Security**: Built-in hashing, password reset, and email verification

### 🏗️ **Rapid Web Development**
- **MVC Architecture**: Clean, organized code structure for large applications
- **Eloquent ORM**: Intuitive database interactions with relationships
- **Blade Templating**: Powerful templating engine for dynamic UIs
- **Artisan CLI**: Hundreds of built-in commands for development efficiency

### 🌐 **Enterprise Web Features**
- **Advanced Routing**: RESTful routing with middleware and route caching
- **Database Migrations**: Version control for database schema changes
- **Queue System**: Background job processing for file handling
- **Caching**: Redis/Memcached integration for performance
- **File Storage**: Seamless cloud storage integration (AWS S3, etc.)

### 📊 **Production-Ready Infrastructure**
- **Mature Ecosystem**: 10+ years of enterprise-grade packages
- **Horizontal Scaling**: Easy deployment across multiple servers
- **Error Handling**: Comprehensive logging and debugging tools
- **Security**: Built-in protection against OWASP top 10 vulnerabilities
- **Performance**: Optimized for web applications with request lifecycle optimization

### 🔧 **Development Experience**
- **Hot Reloading**: Vite integration for instant frontend updates
- **Testing Suite**: PHPUnit integration with feature and unit testing
- **Package Management**: Composer for PHP and npm for frontend dependencies
- **API Development**: Laravel Sanctum for API authentication

### 💡 **Why Not Pure Python for Web?**
While frameworks like Django and FastAPI are excellent, Laravel provides:
- **Faster MVP Development**: Pre-built components for common web features
- **Better Documentation**: Extensive, beginner-friendly documentation
- **Hosting Flexibility**: Runs on shared hosting to enterprise infrastructure
- **Community Support**: Large, active community with extensive package ecosystem

## ✨ Features

### 🤖 Core AI Capabilities

-   **Advanced Conversational AI** - Powered by OpenAI GPT-4o for natural, intelligent responses
-   **Multi-Modal Processing** - Supports text, images, documents, and spreadsheets
-   **Contextual Understanding** - Maintains conversation context for coherent interactions
-   **Educational Focus** - Specifically tuned for academic and learning scenarios

### 📁 File Processing Support

-   **Documents**: PDF, DOCX, DOC, TXT, RTF
-   **Spreadsheets**: XLSX, XLS, CSV
-   **Images**: PNG, JPG, JPEG, GIF, BMP, WEBP
-   **Code Files**: PHP, JS, Python, Java, C++, HTML, CSS, JSON, XML
-   **Data Formats**: JSON, XML, YAML, SQL
-   **Archives**: ZIP (content extraction)
-   **Notebooks**: Jupyter notebooks with cell-by-cell analysis

### 🔧 Advanced Features

-   **Image Analysis** - Extract text and analyze visual content using GPT-4o Vision
-   **Code Block Rendering** - Syntax-highlighted code display with copy functionality
-   **Markdown Support** - Rich text formatting and rendering
-   **File Upload** - Drag-and-drop interface with multiple file support
-   **Responsive Design** - Mobile-first, modern UI with TailwindCSS
-   **User Authentication** - Secure login and registration system
-   **Chat History** - Persistent conversation storage with user accounts
-   **Real-time Processing** - Instant file analysis and AI responses

### 🎨 User Experience

-   **Dark Theme Code Blocks** - Professional ChatGPT-like appearance
-   **Gradient Headers** - Beautiful pink-to-purple gradients matching LTUC branding
-   **Interactive Elements** - Hover effects and smooth animations
-   **Mobile Optimized** - Perfect mobile experience with responsive design
-   **Copy to Clipboard** - Easy code and text copying functionality
-   **Demo Mode** - Public demo for non-authenticated users

## 🛠 Technologies

### Backend Framework

-   **Laravel 11.31** - Modern PHP framework with latest features
-   **PHP 8.2+** - Latest PHP features and performance improvements
-   **MySQL** - Production database (hosted on Clever Cloud)
-   **SQLite** - Development database option
-   **OpenAI PHP Client 0.15** - Official OpenAI API integration

### Frontend Technologies

-   **TailwindCSS 3.1** - Utility-first CSS framework
-   **Alpine.js 3.4** - Lightweight JavaScript framework
-   **Vite 6.0** - Fast build tool and dev server
-   **FontAwesome 6.5** - Professional icon library
-   **Inter Font** - Modern typography

### File Processing Libraries

-   **PHPOffice/PhpSpreadsheet 4.5** - Excel and spreadsheet processing
-   **PHPOffice/PHPWord 1.4** - Word document processing
-   **Smalot/PdfParser 2.12** - PDF content extraction
-   **Spatie/PDF-to-Text 1.54** - Alternative PDF processing
-   **League/CommonMark 2.7** - Markdown parsing and rendering

### Development Tools

-   **Laravel Breeze 2.3** - Authentication scaffolding
-   **Laravel Pint 1.13** - Code style fixer
-   **PHPUnit 11.0** - Testing framework
-   **Faker** - Test data generation

## � Docker Deployment

The project includes comprehensive Docker configuration optimized for production deployment on Railway and Render.

### Multi-Stage Dockerfile

Our Dockerfile uses a multi-stage build process for optimal performance:

**Stage 1: Frontend Asset Building (Node.js 20)**
```dockerfile
FROM node:20 AS assets
# Builds Vite assets with support for npm, yarn, or pnpm
# Automatically detects package manager and uses frozen lockfiles
# Outputs optimized production assets
```

**Stage 2: PHP Application (PHP 8.3-CLI)**
```dockerfile
FROM php:8.3-cli
# Installs required PHP extensions: PDO, MySQL, GD, ZIP, Intl, BCMath
# Configures file upload limits (10MB)
# Optimizes for production with --no-dev dependencies
```

### Key Docker Features

- **PHP 8.3-CLI** with all required extensions (GD, ZIP, PDO MySQL, BCMath, Intl)
- **Node.js 20** for modern frontend asset building
- **Composer 2** for optimized PHP dependency management
- **Multi-Package Manager Support** - Auto-detects npm, yarn, or pnpm
- **File Upload Support** - Pre-configured for 10MB max file size
- **Production Optimized** - No dev dependencies in final image
- **Smart Caching** - Separate layers for dependencies and source code
- **Flexible Port Configuration** - Uses PORT environment variable

### Docker Configuration Details

```dockerfile
# PHP Extensions Installed
pdo pdo_mysql zip gd intl bcmath

# File Upload Settings
upload_max_filesize = 10M
post_max_size = 10M

# Production Optimizations
composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader

# Port Configuration
EXPOSE 10000
CMD php artisan serve --host=0.0.0.0 --port=${PORT}
```

### Quick Docker Commands

```bash
# Build the image
docker build -t ltuc-ai-assistant .

# Run locally
docker run -p 10000:10000 --env-file .env ltuc-ai-assistant

# Access application
http://localhost:10000
```

### Production Deployment

#### Railway Deployment
1. Connect your GitHub repository to Railway
2. Set environment variables (OpenAI API key, database credentials)
3. Railway automatically detects Dockerfile and deploys
4. Access at: https://ltucbot.up.railway.app/

#### Render Deployment
1. Create new Web Service on Render
2. Connect GitHub repository
3. Render builds using Dockerfile
4. Access at: https://ltucbot.onrender.com/

#### Database Setup (Clever Cloud)
1. Create MySQL database on Clever Cloud
2. Copy connection credentials
3. Update environment variables on Railway/Render
4. Run migrations: `php artisan migrate`

## �🚀 Installation

### Prerequisites

-   PHP 8.2 or higher
-   Composer
-   Node.js 18+ and npm
-   MySQL or SQLite
-   OpenAI API key

### Step 1: Clone Repository

```bash
git clone https://github.com/osamaalkhazali/LTUCBot.git
cd LTUCBot
```

### Step 2: Install Dependencies

```bash
# Install PHP dependencies
composer install

# Install Node.js dependencies
npm install
```

### Step 3: Environment Setup

```bash
# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate
```

### Step 4: Database Setup

```bash
# Run migrations
php artisan migrate

# (Optional) Seed database
php artisan db:seed
```

### Step 5: Build Assets

```bash
# Development
npm run dev

# Production
npm run build
```

### Step 6: Start Development Server

```bash
# Laravel server
php artisan serve

# Asset watcher (in separate terminal)
npm run dev
```

## 🐳 Docker Deployment

### Docker Setup for Render

The project includes Docker configuration optimized for Render deployment:

#### Dockerfile
```dockerfile
# استخدم صورة PHP 8.2 مع CLI
FROM php:8.2-cli

# تثبيت الإضافات المطلوبة لـ Laravel + MySQL
RUN apt-get update && apt-get install -y \
    unzip \
    libpq-dev \
    libzip-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    && docker-php-ext-install pdo pdo_mysql zip gd

# تثبيت Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# نسخ ملفات المشروع
WORKDIR /var/www
COPY . .

# تثبيت مكتبات Laravel
RUN composer install --no-dev --optimize-autoloader

# فتح المنفذ وتشغيل Laravel
EXPOSE 10000
CMD php artisan serve --host=0.0.0.0 --port=10000
```

#### .dockerignore
```
vendor
node_modules
.env
```

### Local Docker Commands

```bash
# Build Docker image
docker build -t ltuc-ai-assistant .

# Run container
docker run -p 10000:10000 --env-file .env ltuc-ai-assistant

# Access application
http://localhost:10000
```

### Render Deployment

1. **Push to GitHub**: Ensure Dockerfile and .dockerignore are committed
2. **Create Render Service**: Connect your GitHub repository
3. **Set Environment Variables**: Configure OpenAI API key and database
4. **Deploy**: Render will automatically build and deploy using Docker

## ⚙️ Configuration

### Environment Variables

Create your `.env` file with the following configurations:

```env
# Application
APP_NAME="LTUC AI Assistant"
APP_ENV=production
APP_KEY=base64:your-generated-key
APP_DEBUG=false
APP_URL=https://ltucbot.up.railway.app

# Database (Clever Cloud MySQL)
DB_CONNECTION=mysql
DB_HOST=your-clever-cloud-host
DB_PORT=3306
DB_DATABASE=your-database-name
DB_USERNAME=your-username
DB_PASSWORD=your-password

# OpenAI Configuration
OPENAI_API_KEY=your_openai_api_key_here
OPENAI_ORGANIZATION=your_org_id_optional

# Mail Configuration
MAIL_MAILER=smtp
MAIL_HOST=your-smtp-host
MAIL_PORT=587
MAIL_USERNAME=your-email
MAIL_PASSWORD=your-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="noreply@ltucbot.com"
MAIL_FROM_NAME="${APP_NAME}"

# Session Configuration
SESSION_DRIVER=database
SESSION_LIFETIME=120

# Cache Configuration
CACHE_DRIVER=file
QUEUE_CONNECTION=sync

# File Upload Limits
UPLOAD_MAX_FILESIZE=10M
POST_MAX_SIZE=10M
```

### OpenAI API Setup

1. **Get API Key**: Visit [OpenAI Platform](https://platform.openai.com/api-keys)
2. **Create New Key**: Generate a new secret key
3. **Add to Environment**: Set `OPENAI_API_KEY` in your `.env` file
4. **Set Usage Limits**: Configure billing and usage limits in OpenAI dashboard

### File Upload Configuration

The application is configured to handle files up to 10MB. Adjust in Docker or PHP settings:

```ini
upload_max_filesize = 10M
post_max_size = 10M
max_execution_time = 300
memory_limit = 512M
```

## 📖 Usage

### Access the Application

1. **Production**: [https://ltucbot.up.railway.app/](https://ltucbot.up.railway.app/)
2. **Demo Mode**: Try the chatbot without registration
3. **Full Features**: Register for persistent chat history and file uploads

### Basic Interaction

1. **Register/Login**
   - Create account for full features
   - Or use demo mode for quick testing

2. **Start Chatting**
   - Type questions in the chat interface
   - Upload files for analysis
   - View formatted responses with syntax highlighting

### File Upload Examples

- **Documents**: Upload PDFs, Word docs, spreadsheets
- **Code Files**: Analyze Python, PHP, JavaScript, etc.
- **Images**: Extract text and analyze visual content
- **Data Files**: Process CSV, JSON, XML files

### Chat Features

- **Persistent History**: All conversations saved to your account
- **Multiple Chats**: Start new conversations anytime
- **File Attachments**: Each message can include multiple files
- **Mobile Responsive**: Perfect experience on all devices

### Sample Interactions

**Text Questions:**

```
"Explain the concept of object-oriented programming"
"Help me understand calculus derivatives"
"What are the best practices for Laravel development?"
```

**File-based Questions:**

```
"Analyze this code and suggest improvements" + upload .php file
"Extract key points from this PDF" + upload document
"What does this diagram show?" + upload image
"Summarize this spreadsheet data" + upload .xlsx file
```

## 📄 File Processing

### Supported File Types

| Category         | Extensions                                             | Processing Method                 |
| ---------------- | ------------------------------------------------------ | --------------------------------- |
| **Documents**    | `.pdf`, `.docx`, `.doc`, `.txt`, `.rtf`                | Text extraction + AI analysis     |
| **Spreadsheets** | `.xlsx`, `.xls`, `.csv`                                | Data parsing + structure analysis |
| **Images**       | `.png`, `.jpg`, `.jpeg`, `.gif`, `.bmp`, `.webp`       | GPT-4o Vision API                 |
| **Code**         | `.php`, `.js`, `.py`, `.java`, `.cpp`, `.html`, `.css` | Syntax-aware processing           |
| **Data**         | `.json`, `.xml`, `.yaml`, `.sql`                       | Structure-aware parsing           |
| **Archives**     | `.zip`                                                 | Content extraction + analysis     |

### Processing Features

-   **Automatic Type Detection** - Smart MIME type and extension analysis
-   **Content Extraction** - Text, code, and data extraction from various formats
-   **Image Analysis** - OCR and visual content understanding via AI
-   **Error Handling** - Graceful fallbacks for unsupported or corrupted files
-   **Size Limits** - Configurable file size restrictions (default: 10MB for images)

## 🔌 API Integration

### OpenAI Configuration

The application uses OpenAI's latest models:

```php
// Chat Completions
'model' => 'gpt-4o',
'max_tokens' => 16000,
'temperature' => 0.7

// Vision API (for images)
'model' => 'gpt-4o-mini',
'detail' => 'high'
```

### Custom Controllers

**ChatbotController.php** - Main AI interaction handler:

-   Message processing and context management
-   File upload and analysis
-   Markdown parsing and rendering
-   Error handling and user feedback

### Response Formatting

Responses include:

-   **Raw Text** - Original AI response
-   **HTML** - Parsed markdown with syntax highlighting
-   **Code Blocks** - Formatted with copy functionality
-   **File Analysis** - Structured content extraction results

## 🎨 Customization

### Styling

The application uses a custom color scheme:

```css
/* LTUC Brand Colors */
.ltuc-primary {
    background-color: #d60095;
} /* Pink */
.ltuc-secondary {
    background-color: #2e8570;
} /* Green */
.ltuc-accent {
    background-color: #a84a9d;
} /* Purple */
.ltuc-dark {
    background-color: #333333;
} /* Dark Gray */
.ltuc-light {
    background-color: #999999;
} /* Light Gray */
```

### Code Block Theming

Professional dark theme with gradient headers:

```css
/* Code blocks with ChatGPT-like appearance */
.code-block-header {
    background: linear-gradient(135deg, #ec4899 0%, #8b5cf6 100%);
    color: white;
}
.code-block-content {
    background: #1e293b;
    color: white;
}
```

## 🤝 Contributing

### Development Workflow

1. **Fork the Repository**
2. **Create Feature Branch**: `git checkout -b feature/amazing-feature`
3. **Make Changes**: Follow PSR-12 coding standards
4. **Run Tests**: Ensure all tests pass
5. **Submit Pull Request**: With detailed description

### Code Standards

- **PSR-12**: PHP coding standard compliance
- **Laravel Conventions**: Follow Laravel best practices
- **Documentation**: Comment complex functions
- **Testing**: Write tests for new features

### Setting up Development Environment

```bash
# Install development dependencies
composer install --dev
npm install --dev

# Set up testing database
php artisan migrate --env=testing

# Run development server with debugging
php artisan serve --env=local
```

## � License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## 🙏 Acknowledgments

- **OpenAI** for providing the GPT-4o API
- **Laravel Community** for the amazing framework and packages
- **Railway & Render** for reliable hosting platforms
- **Clever Cloud** for managed MySQL database
- **LTUC** for supporting innovative educational technology

## � Support

- **Issues**: [GitHub Issues](https://github.com/osamaalkhazali/LTUCBot/issues)
- **Documentation**: This README and inline code comments
- **Live Demo**: [https://ltucbot.up.railway.app/](https://ltucbot.up.railway.app/)

---

<div align="center">
  <p><strong>Built with ❤️ for Education</strong></p>
  <p>© 2025 LTUC AI Assistant | Powered by Laravel & OpenAI</p>
</div>
  <p>© 2025 LTUC AI Assistant. All rights reserved.</p>
</div>
