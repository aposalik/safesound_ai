<div class="container mt-5 pt-5">
    <div class="row justify-content-center">
        <div class="col-md-6" data-aos="zoom-in" data-aos-duration="1000">
            <div class="glass-panel text-white">
                <div class="card-body p-5">
                    <div class="text-center mb-4">
                        <i class="fas fa-shield-alt text-accent mb-3" style="font-size: 3rem;"></i>
                        <h2 class="fw-bold">Welcome Back</h2>
                        <p class="text-secondary">Sign in to your SafeSound AI account</p>
                    </div>
                    
                    <form method="POST" action="auth.php">
                        <input type="hidden" name="action" value="login">
                        
                        <div class="mb-3">
                            <label class="form-label text-white-50">Email Address</label>
                            <input type="email" name="email" class="form-control" required placeholder="name@example.com">
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label text-white-50">Password</label>
                            <input type="password" name="password" class="form-control" required placeholder="••••••••">
                        </div>
                        
                        <div class="mb-4 form-check">
                            <input type="checkbox" name="remember" class="form-check-input" id="remember">
                            <label class="form-check-label text-secondary" for="remember">Remember me</label>
                        </div>
                        
                        <div class="d-grid mb-4">
                            <button type="submit" class="btn btn-primary-glow btn-lg">Sign In</button>
                        </div>
                        
                        <div class="text-center">
                            <p class="text-secondary">Don't have an account? <a href="?page=signup" class="text-accent text-decoration-none fw-bold">Sign Up</a></p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>