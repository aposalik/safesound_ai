<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo ucfirst($page); ?> - SafeSound AI</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top glass-navbar">
        <div class="container">
            <a class="navbar-brand fw-bold" href="?page=home">
                <i class="fas fa-shield-alt me-2 text-accent"></i>SafeSound AI
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link <?php echo $page === 'home' ? 'active' : ''; ?>" href="?page=home">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo $page === 'about' ? 'active' : ''; ?>" href="?page=about">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo $page === 'contact' ? 'active' : ''; ?>" href="?page=contact">Contact</a>
                    </li>
                    <?php if (isset($_SESSION['user_id'])): ?>
                    <li class="nav-item">
                        <a class="nav-link btn btn-primary-glow text-white ms-2 px-3" href="?page=dashboard">Dashboard</a>
                    </li>
                    <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link" href="?page=login">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link btn btn-primary-glow text-white ms-2 px-3" href="?page=signup">Sign Up</a>
                    </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        <?php 
        if ($page === 'dashboard') {
            include "app/{$page}.php";
        } else {
            include "pages/{$page}.php";
        }
        ?>
    </main>

    <!-- Footer -->
    <footer class="bg-darker text-white py-5 mt-5 border-top border-light-subtle">
        <div class="container text-center">
            <div class="mb-4">
                <i class="fas fa-shield-alt fa-2x text-accent mb-3"></i>
                <h5 class="fw-bold">SafeSound AI</h5>
            </div>
            <p class="text-white-50">&copy; 2024 SafeSound AI. Protecting lives through intelligent audio monitoring.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="assets/js/app.js"></script>
    <script>
        AOS.init({
            duration: 800,
            once: true,
            offset: 100
        });
    </script>
</body>
</html>