<div class="container mt-5 pt-5">
    <div class="row justify-content-center">
        <div class="col-md-8" data-aos="zoom-in" data-aos-duration="1000">
            <div class="glass-panel text-white">
                <div class="card-body p-5">
                    <div class="text-center mb-4">
                        <i class="fas fa-user-plus text-accent mb-3" style="font-size: 3rem;"></i>
                        <h2 class="fw-bold">Create Account</h2>
                        <p class="text-secondary">Join SafeSound AI to protect what matters most</p>
                    </div>
                    
                    <form method="POST" action="auth.php">
                        <input type="hidden" name="action" value="signup">
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-white-50">First Name</label>
                                <input type="text" name="first_name" class="form-control" required placeholder="John">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-white-50">Last Name</label>
                                <input type="text" name="last_name" class="form-control" required placeholder="Doe">
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label text-white-50">Email Address</label>
                            <input type="email" name="email" class="form-control" required placeholder="name@example.com">
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label text-white-50">Phone Number</label>
                            <input type="tel" name="phone" class="form-control" placeholder="+1 (555) 000-0000">
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-white-50">Password</label>
                                <input type="password" name="password" class="form-control" required placeholder="••••••••">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-white-50">Confirm Password</label>
                                <input type="password" name="confirm_password" class="form-control" required placeholder="••••••••">
                            </div>
                        </div>
                        
                        <div class="mb-4 form-check">
                            <input type="checkbox" name="terms" class="form-check-input" id="terms" required>
                            <label class="form-check-label text-secondary" for="terms">I agree to the Terms of Service</label>
                        </div>
                        
                        <div class="d-grid mb-4">
                            <button type="submit" class="btn btn-primary-glow btn-lg">Create Account</button>
                        </div>
                        
                        <div class="text-center">
                            <p class="text-secondary">Already have an account? <a href="?page=login" class="text-accent text-decoration-none fw-bold">Sign In</a></p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>