# Build Git history with feature branches for Assessment 3
$ErrorActionPreference = "Stop"
$git = "C:\Program Files\Git\bin\git.exe"
$root = (Resolve-Path (Join-Path $PSScriptRoot "..")).Path
$gc = @("-c", "user.name=Cornerstone Retail Team", "-c", "user.email=team@cornerstone-retail.local")

Set-Location $root

if (Test-Path ".git") { Remove-Item ".git" -Recurse -Force }

& $git @gc init -b main

function Git-Add($paths) {
    foreach ($p in $paths) {
        if (Test-Path (Join-Path $root $p)) { & $git @gc add $p }
    }
}

function Git-Commit($msg) {
    & $git @gc commit -m $msg
}

# 1 — Scaffold
Git-Add @(
    ".gitignore", "config", "database", "database.sql",
    "src/bootstrap.php", "src/Database.php", "src/Router.php", "src/helpers.php",
    "src/Auth.php", "src/Validator.php", "src/ActivityLogger.php",
    "public/index.php", "public/.htaccess", "public/assets/css/style.css", "public/assets/js/app.js",
    "views/layout", "views/errors"
)
Git-Commit "chore: project scaffold, database schema, and MVC bootstrap"

& $git @gc checkout -b develop

# 2 — Auth branch
& $git @gc checkout -b feature/auth
Git-Add @(
    "src/Controllers/AuthController.php", "src/Controllers/HomeController.php",
    "src/Models/UserModel.php", "views/auth"
)
Git-Commit "feat(auth): login, register, sessions, and role checks"
& $git @gc checkout develop
& $git @gc merge feature/auth --no-edit

# 3 — Products branch
& $git @gc checkout -b feature/products
Git-Add @(
    "src/Controllers/ProductController.php",
    "src/Models/ProductModel.php", "src/Models/CategoryModel.php",
    "views/products"
)
Git-Commit "feat(products): catalogue search filter pagination and admin CRUD"
& $git @gc checkout develop
& $git @gc merge feature/products --no-edit

# 4 — Orders branch
& $git @gc checkout -b feature/orders
Git-Add @(
    "src/Controllers/CartController.php", "src/Controllers/OrderController.php",
    "src/Models/OrderModel.php", "views/cart", "views/orders"
)
Git-Commit "feat(orders): cart checkout and order status management"
& $git @gc checkout develop
& $git @gc merge feature/orders --no-edit

# 5 — AI branch
& $git @gc checkout -b feature/ai
Git-Add @(
    "data", "src/Services", "src/Controllers/HelpController.php", "src/Controllers/AiController.php",
    "src/Controllers/AdminController.php", "src/Models/AiLogModel.php",
    "views/help", "views/admin"
)
Git-Commit "feat(ai): FAQ help assistant and description drafting with audit log"
& $git @gc checkout develop
& $git @gc merge feature/ai --no-edit

# 6 — UI / images
& $git @gc checkout -b feature/ui
Git-Add @(
    "src/Services/ImageUploadService.php", "views/partials",
    "public/assets/uploads/products/.gitkeep", "public/assets/css/style.css"
)
Git-Commit "feat(ui): product image upload and responsive empty states"
& $git @gc checkout develop
& $git @gc merge feature/ui --no-edit

# 7 — Docs + README
Git-Add @("README.md", "docs", "scripts", "github-link.txt")
Git-Commit "docs: assessment documentation and submission guide"

& $git @gc checkout main
& $git @gc merge develop --no-edit

Write-Host "Git history ready on main and develop with feature branches."
& $git @gc log --oneline --graph -15
