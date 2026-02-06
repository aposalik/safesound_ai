<!-- Dashboard Header -->
<section class="bg-light py-4 mt-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h1 class="display-6 fw-bold text-gradient">SafeSound Dashboard</h1>
                <p class="text-muted">Real-time audio monitoring and threat detection</p>
            </div>
            <div class="col-lg-4 text-end">
                <span class="status-indicator status-safe"></span>
                <span class="fw-bold text-success">System Active</span>
            </div>
        </div>
    </div>
</section>

<!-- Dashboard Content -->
<section class="py-4">
    <div class="container">
        <div class="row g-4">
            <!-- Live Monitor with Audio Visualizer -->
            <div class="col-lg-8">
                <div class="dashboard-card p-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h3 class="fw-bold">Live Audio Monitor</h3>
                        <div>
                            <button id="startBtn" class="btn btn-success btn-lg">
                                <i class="fas fa-play me-2"></i>Start Recording
                            </button>
                            <button id="stopBtn" class="btn btn-danger btn-lg d-none">
                                <i class="fas fa-stop me-2"></i>Stop Recording
                            </button>
                        </div>
                    </div>
                    
                    <!-- Audio Visualizer -->
                    <div class="audio-visualizer mb-4">
                        <canvas id="audioCanvas" width="700" height="200" class="w-100"></canvas>
                    </div>
                    
                    <div class="text-center py-3">
                        <div id="recordingStatus" class="d-none">
                            <div class="d-flex align-items-center justify-content-center mb-3">
                                <div class="spinner-border text-primary me-3"></div>
                                <div>
                                    <h5 class="mb-1">Monitoring Audio...</h5>
                                    <p class="text-muted mb-0">AI is analyzing audio patterns in real-time</p>
                                </div>
                            </div>
                        </div>
                        <div id="idleStatus">
                            <i class="fas fa-microphone-slash text-muted mb-3" style="font-size: 3rem;"></i>
                            <h5 class="text-muted">Click Start to Begin AI Monitoring</h5>
                        </div>
                    </div>
                    
                    <div id="detectionResult" class="alert d-none"></div>
                </div>
            </div>
            
            <!-- Quick Stats -->
            <div class="col-lg-4">
                <div class="dashboard-card p-4 mb-4">
                    <h5 class="fw-bold mb-3">Today's Activity</h5>
                    <div class="row g-3">
                        <div class="col-6 text-center">
                            <h3 class="text-success fw-bold">0</h3>
                            <small class="text-muted">Safe Events</small>
                        </div>
                        <div class="col-6 text-center">
                            <h3 class="text-warning fw-bold">0</h3>
                            <small class="text-muted">Alerts</small>
                        </div>
                    </div>
                </div>
                
                <div class="dashboard-card p-4">
                    <h5 class="fw-bold mb-3">Quick Actions</h5>
                    <div class="d-grid gap-2">
                        <button class="btn btn-outline-primary">
                            <i class="fas fa-history me-2"></i>View History
                        </button>
                        <button class="btn btn-outline-secondary">
                            <i class="fas fa-cog me-2"></i>Settings
                        </button>
                        <button class="btn btn-outline-info">
                            <i class="fas fa-download me-2"></i>Export Data
                        </button>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Detection Results Section -->
        <div class="row mt-4">
            <!-- Recent Detections -->
            <div class="col-lg-6">
                <div class="dashboard-card p-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="fw-bold mb-0">Recent Detections</h5>
                        <span class="badge bg-primary">Live</span>
                    </div>
                    
                    <div id="detectionsContainer">
                        <div class="text-center text-muted py-5">
                            <i class="fas fa-search mb-3" style="font-size: 2rem;"></i>
                            <p> No detections yet. Start monitoring to see results. </p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- AI Analysis Panel -->
            <div class="col-lg-6">
                <div class="dashboard-card p-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="fw-bold mb-0">AI Analysis</h5>
                        <i class="fas fa-brain text-primary"></i>
                    </div>
                    
                    <div id="aiAnalysisContainer">
                        <div class="text-center text-muted py-5">
                            <i class="fas fa-robot mb-3" style="font-size: 2rem;"></i>
                            <p>AI analysis will appear here when audio is detected.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>