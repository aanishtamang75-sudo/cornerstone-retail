# Push Cornerstone Retail to GitHub and open pull requests
# Prerequisite: gh auth login  (run once in terminal)

$ErrorActionPreference = "Stop"
$git = "C:\Program Files\Git\bin\git.exe"
$root = (Resolve-Path (Join-Path $PSScriptRoot "..")).Path
$repoName = "cornerstone-retail"

$env:Path = [System.Environment]::GetEnvironmentVariable("Path","Machine") + ";" + [System.Environment]::GetEnvironmentVariable("Path","User")

gh auth status 2>&1 | Out-Null
if ($LASTEXITCODE -ne 0) {
    Write-Host "Not logged in. Run: gh auth login" -ForegroundColor Yellow
    Write-Host "Then run this script again."
    exit 1
}

Set-Location $root

# Create repo if missing (public; change to --private if preferred)
$exists = gh repo view $repoName 2>$null
if (-not $exists) {
    gh repo create $repoName --public --source=. --remote=origin --description "ICT203 A3 - Small retail catalogue + orders with responsible AI (PHP/MySQL)"
    Write-Host "Created repository."
} else {
    if (-not (git remote 2>$null | Select-String origin)) {
        $user = (gh api user -q .login)
        & $git remote add origin "https://github.com/$user/$repoName.git"
    }
}

# Push all branches
& $git push -u origin main
& $git push -u origin develop
& $git push -u origin feature/auth
& $git push -u origin feature/products
& $git push -u origin feature/orders
& $git push -u origin feature/ai
& $git push -u origin feature/ui

$user = (gh api user -q .login)
$url = "https://github.com/$user/$repoName"
$url | Set-Content (Join-Path $root "github-link.txt") -Encoding UTF8
Write-Host "Updated github-link.txt -> $url"

# Create PRs (ignore if already exist)
$prs = @(
    @{ base = "develop"; head = "feature/auth"; title = "feat: user authentication and role-based access" },
    @{ base = "develop"; head = "feature/products"; title = "feat: product catalogue with search and admin CRUD" },
    @{ base = "develop"; head = "feature/orders"; title = "feat: shopping cart and order management" },
    @{ base = "develop"; head = "feature/ai"; title = "feat: responsible AI help and description assistant" },
    @{ base = "develop"; head = "feature/ui"; title = "feat: product images and UX empty states" },
    @{ base = "main"; head = "develop"; title = "release: Assessment 3 MVP" }
)

foreach ($pr in $prs) {
    gh pr create --base $pr.base --head $pr.head --title $pr.title --body "Assessment 3 - Cornerstone Retail. See README and /docs." 2>$null
    if ($LASTEXITCODE -eq 0) { Write-Host "PR: $($pr.head) -> $($pr.base)" }
}

Write-Host ""
Write-Host "Done. Repository: $url"
Write-Host "Open Pull requests tab to merge or leave open for marking evidence."
