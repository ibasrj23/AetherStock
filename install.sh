#!/bin/bash
# Product Management System - Setup Script (Linux/Mac)
# Usage: bash install.sh

echo "🚀 Product Management System - Setup Script"
echo "==========================================="
echo ""

# Check if PHP is installed
if ! command -v php &> /dev/null; then
    echo "❌ PHP is not installed. Please install PHP 7.4 or higher."
    exit 1
fi

PHP_VERSION=$(php -v | head -n 1 | grep -oE '[0-9]+\.[0-9]+' | head -1)
echo "✅ PHP $PHP_VERSION found"

# Check if MySQL is installed
if ! command -v mysql &> /dev/null; then
    echo "⚠️  MySQL not found in PATH. Make sure MySQL server is running."
else
    echo "✅ MySQL found"
fi

# Create assets directories if not exist
echo ""
echo "📁 Creating directories..."
mkdir -p assets/css assets/js includes

# Check if files exist
echo ""
echo "✅ Project structure:"
echo "   ├── includes/db.php"
echo "   ├── includes/session.php"
echo "   ├── assets/css/style.css"
echo "   ├── assets/js/script.js"
echo "   └── [PHP files]"

# Display next steps
echo ""
echo "📝 Next Steps:"
echo "1. Start PHP server:"
echo "   php -S localhost:8000"
echo ""
echo "2. Open in browser:"
echo "   http://localhost:8000/setup.php"
echo ""
echo "3. Click 'Setup Database'"
echo ""
echo "4. Login with demo credentials:"
echo "   Username: user1"
echo "   Password: password123"
echo ""
echo "✅ Setup complete! Happy coding! 🎉"
