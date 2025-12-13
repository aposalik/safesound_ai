<!-- Hero Section -->
<section class="hero-section d-flex align-items-center">
    <div class="container position-relative z-1">
        <div class="row align-items-center">
            <div class="col-lg-6" data-aos="fade-right">
                <h1 class="display-3 fw-bold mb-4">
                    <span class="text-white">AI-Powered</span><br>
                    <span class="text-gradient">Audio Safety Monitoring</span>
                </h1>
                <p class="lead mb-4 text-white-50">
                    Protect your loved ones with intelligent real-time detection of distress signals, 
                    domestic violence, and emergency situations through advanced audio analysis.
                </p>
                <div class="d-flex gap-3">
                    <?php if (isset($_SESSION['user_id'])): ?>
                    <a href="?page=dashboard" class="btn btn-primary-glow btn-lg">
                        <i class="fas fa-play me-2"></i>Start Monitoring
                    </a>
                    <?php else: ?>
                    <a href="?page=signup" class="btn btn-primary-glow btn-lg">
                        <i class="fas fa-user-plus me-2"></i>Get Started
                    </a>
                    <?php endif; ?>
                    <a href="?page=about" class="btn btn-outline-glow btn-lg">
                        Learn More
                    </a>
                </div>
            </div>
            <div class="col-lg-6 text-center" data-aos="fade-left" data-aos-delay="200">
                <div class="position-relative floating">
                    <div class="glass-panel p-5 d-inline-block rounded-circle pulse-glow">
                        <i class="fas fa-microphone-alt text-gradient" style="font-size: 8rem;"></i>
                    </div>
                    <!-- Orbiting Elements -->
                    <div class="position-absolute top-0 start-0 translate-middle">
                        <div class="glass-panel p-3 rounded-circle" data-aos="zoom-in" data-aos-delay="400">
                            <i class="fas fa-shield-alt text-success fa-2x"></i>
                        </div>
                    </div>
                    <div class="position-absolute bottom-0 end-0 translate-middle">
                        <div class="glass-panel p-3 rounded-circle" data-aos="zoom-in" data-aos-delay="600">
                            <i class="fas fa-bell text-warning fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="section-padding bg-dark-section">
    <div class="container">
        <div class="row text-center mb-5" data-aos="fade-up">
            <div class="col-lg-8 mx-auto">
                <h2 class="display-5 fw-bold mb-3"><span class="text-white">How</span> <span class="text-gradient">SafeSound AI</span> <span class="text-white">Works</span></h2>
                <p class="lead text-secondary">Advanced AI technology monitors audio patterns to detect potential dangers and alert you instantly</p>
            </div>
        </div>
        
        <div class="row g-4">
            <!-- Feature 1 -->
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
                <div class="feature-card text-center">
                    <div class="feature-icon">
                        <i class="fas fa-microphone"></i>
                    </div>
                    <h4 class="fw-bold mb-3 text-white">Real-Time Monitoring</h4>
                    <p class="text-secondary">Continuous audio analysis with 5-second intervals for immediate threat detection.</p>
                </div>
            </div>
            
            <!-- Feature 2 -->
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
                <div class="feature-card text-center">
                    <div class="feature-icon">
                        <i class="fas fa-brain"></i>
                    </div>
                    <h4 class="fw-bold mb-3 text-white">AI Classification</h4>
                    <p class="text-secondary">Advanced machine learning identifies crying, screaming, aggression, and distress signals.</p>
                </div>
            </div>
            
            <!-- Feature 3 -->
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
                <div class="feature-card text-center">
                    <div class="feature-icon">
                        <i class="fas fa-bell"></i>
                    </div>
                    <h4 class="fw-bold mb-3 text-white">Instant Alerts</h4>
                    <p class="text-secondary">Immediate notifications via email and SMS when dangerous situations are detected.</p>
                </div>
            </div>
            
            <!-- Feature 4 -->
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="400">
                <div class="feature-card text-center">
                    <div class="feature-icon">
                        <i class="fas fa-cloud"></i>
                    </div>
                    <h4 class="fw-bold mb-3 text-white">Cloud Storage</h4>
                    <p class="text-secondary">Secure cloud backup of critical audio evidence for review and posterior analysis.</p>
                </div>
            </div>
            
            <!-- Feature 5 -->
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="500">
                <div class="feature-card text-center">
                    <div class="feature-icon">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <h4 class="fw-bold mb-3 text-white">Analytics Dashboard</h4>
                    <p class="text-secondary">Comprehensive reporting and historical data analysis for long-term pattern recognition.</p>
                </div>
            </div>
            
            <!-- Feature 6 -->
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="600">
                <div class="feature-card text-center">
                    <div class="feature-icon">
                        <i class="fas fa-lock"></i>
                    </div>
                    <h4 class="fw-bold mb-3 text-white">Privacy First</h4>
                    <p class="text-secondary">Only high-risk audio is stored, ensuring privacy while maintaining safety protocols.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="section-padding position-relative overflow-hidden">
    <div class="container position-relative z-1">
        <div class="glass-panel p-5 text-center" data-aos="zoom-in">
            <div class="row justify-content-center">
                <div class="col-lg-9">
                    <h2 class="display-5 fw-bold mb-4 text-white">Ready to Enhance Your Safety?</h2>
                    <p class="lead text-secondary mb-5">Join thousands of families and institutions using SafeSound AI to protect what matters most.</p>
                    <?php if (isset($_SESSION['user_id'])): ?>
                    <a href="?page=dashboard" class="btn btn-primary-glow btn-lg px-5">
                        <i class="fas fa-rocket me-2"></i>Go to Dashboard
                    </a>
                    <?php else: ?>
                    <a href="?page=signup" class="btn btn-primary-glow btn-lg px-5">
                        <i class="fas fa-rocket me-2"></i>Get Started Now
                    </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>