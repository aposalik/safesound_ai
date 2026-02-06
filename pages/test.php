<!-- AI Test Header -->
<section class="bg-light py-4 mt-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h1 class="display-6 fw-bold text-gradient">AI Audio Test</h1>
                <p class="text-muted">Test your Huawei ModelArts model with 5-second audio recordings</p>
            </div>
            <div class="col-lg-4 text-end">
                <span class="badge bg-success">Huawei ModelArts Ready</span>
            </div>
        </div>
    </div>
</section>

<!-- Test Interface -->
<section class="py-4">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="dashboard-card p-4 mb-4">
                    <div class="text-center mb-4">
                        <h3 class="fw-bold">5-Second Audio Test</h3>
                        <p class="text-muted">Record exactly 5 seconds of audio in WAV format for AI analysis</p>
                    </div>
                    
                    <!-- Recording Controls -->
                    <div class="text-center mb-4">
                        <button id="testRecordBtn" class="btn btn-primary btn-lg me-3">
                            <i class="fas fa-microphone me-2"></i>Start 5s Recording
                        </button>
                        <button id="testStopBtn" class="btn btn-danger btn-lg d-none">
                            <i class="fas fa-stop me-2"></i>Stop Recording
                        </button>
                    </div>
                    
                    <!-- Recording Status -->
                    <div id="testStatus" class="text-center mb-4">
                        <div id="testIdle">
                            <i class="fas fa-microphone-slash text-muted mb-3" style="font-size: 3rem;"></i>
                            <h5 class="text-muted">Click to start 5-second recording</h5>
                        </div>
                        <div id="testRecording" class="d-none">
                            <div class="spinner-border text-danger mb-3"></div>
                            <h5 class="text-danger">Recording... <span id="countdown">5</span>s</h5>
                            <div class="progress mt-3" style="height: 10px;">
                                <div id="progressBar" class="progress-bar bg-danger" style="width: 0%"></div>
                            </div>
                        </div>
                        <div id="testProcessing" class="d-none">
                            <div class="spinner-border text-primary mb-3"></div>
                            <h5 class="text-primary">Analyzing with Huawei ModelArts...</h5>
                        </div>
                    </div>
                    
                    <!-- Results -->
                    <div id="testResults" class="d-none">
                        <div class="alert alert-info">
                            <h5 class="fw-bold mb-3">🤖 Huawei ModelArts Analysis</h5>
                            <div id="resultContent"></div>
                        </div>
                    </div>
                </div>
                
                <!-- Test History -->
                <div class="dashboard-card p-4">
                    <h5 class="fw-bold mb-3">Test History</h5>
                    <div id="testHistory">
                        <p class="text-muted text-center">No tests performed yet</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
// Test page specific JavaScript
let testRecorder;
let testAudioChunks = [];
let testCountdown;
let testProgress;

document.addEventListener('DOMContentLoaded', function() {
    const testRecordBtn = document.getElementById('testRecordBtn');
    const testStopBtn = document.getElementById('testStopBtn');
    
    if (testRecordBtn) {
        testRecordBtn.addEventListener('click', startTestRecording);
    }
    if (testStopBtn) {
        testStopBtn.addEventListener('click', stopTestRecording);
    }
});

async function startTestRecording() {
    try {
        const stream = await navigator.mediaDevices.getUserMedia({ audio: true });
        
        // Use WAV format if supported
        const options = { mimeType: 'audio/wav' };
        if (!MediaRecorder.isTypeSupported(options.mimeType)) {
            options.mimeType = 'audio/webm';
        }
        
        testRecorder = new MediaRecorder(stream, options);
        testAudioChunks = [];
        
        testRecorder.ondataavailable = event => {
            testAudioChunks.push(event.data);
        };
        
        testRecorder.onstop = processTestAudio;
        
        // Start recording
        testRecorder.start();
        
        // Update UI
        document.getElementById('testRecordBtn').classList.add('d-none');
        document.getElementById('testStopBtn').classList.remove('d-none');
        document.getElementById('testIdle').classList.add('d-none');
        document.getElementById('testRecording').classList.remove('d-none');
        
        // Start countdown and progress
        let timeLeft = 5;
        const countdownEl = document.getElementById('countdown');
        const progressBar = document.getElementById('progressBar');
        
        testCountdown = setInterval(() => {
            timeLeft--;
            countdownEl.textContent = timeLeft;
            progressBar.style.width = ((5 - timeLeft) / 5 * 100) + '%';
            
            if (timeLeft <= 0) {
                stopTestRecording();
            }
        }, 1000);
        
    } catch (error) {
        alert('Error accessing microphone: ' + error.message);
    }
}

function stopTestRecording() {
    if (testRecorder && testRecorder.state !== 'inactive') {
        testRecorder.stop();
        testRecorder.stream.getTracks().forEach(track => track.stop());
        
        clearInterval(testCountdown);
        
        // Update UI
        document.getElementById('testRecordBtn').classList.remove('d-none');
        document.getElementById('testStopBtn').classList.add('d-none');
        document.getElementById('testRecording').classList.add('d-none');
        document.getElementById('testProcessing').classList.remove('d-none');
    }
}

async function processTestAudio() {
    if (testAudioChunks.length === 0) return;
    
    const audioBlob = new Blob(testAudioChunks, { type: 'audio/wav' });
    const formData = new FormData();
    formData.append('file', audioBlob, 'test-audio.wav');
    
    try {
        const response = await fetch('http://localhost:8001/predict', {
            method: 'POST',
            body: formData
        });
        
        if (response.ok) {
            const result = await response.json();
            displayTestResult(result);
            addToTestHistory(result);
        } else {
            const errorText = await response.text();
            displayTestError('API Error: ' + errorText);
        }
    } catch (error) {
        displayTestError('Network Error: ' + error.message);
    }
    
    // Reset UI
    document.getElementById('testProcessing').classList.add('d-none');
    document.getElementById('testIdle').classList.remove('d-none');
}

function displayTestResult(result) {
    const resultContent = document.getElementById('resultContent');
    const riskColor = result.risk_level === 'safe' ? 'success' : 
                     result.risk_level === 'warning' ? 'warning' : 'danger';
    
    resultContent.innerHTML = `
        <div class="row">
            <div class="col-md-6">
                <h6 class="fw-bold">Emotion Detected:</h6>
                <span class="badge bg-${riskColor} fs-6">${result.emotion.toUpperCase().replace('_', ' ')}</span>
            </div>
            <div class="col-md-6">
                <h6 class="fw-bold">Confidence:</h6>
                <span class="fs-5">${Math.round(result.confidence * 100)}%</span>
            </div>
        </div>
        <hr>
        <h6 class="fw-bold">AI Reasoning:</h6>
        <p class="mb-2">${result.reasoning}</p>
        <small class="text-muted">Risk Level: ${result.risk_level.toUpperCase()} | Source: ${result.model_source}</small>
    `;
    
    document.getElementById('testResults').classList.remove('d-none');
}

function displayTestError(error) {
    const resultContent = document.getElementById('resultContent');
    resultContent.innerHTML = `
        <div class="text-danger">
            <h6 class="fw-bold">Error:</h6>
            <p>${error}</p>
        </div>
    `;
    document.getElementById('testResults').classList.remove('d-none');
}

function addToTestHistory(result) {
    const historyEl = document.getElementById('testHistory');
    
    // Remove "no tests" message
    if (historyEl.querySelector('.text-muted')) {
        historyEl.innerHTML = '';
    }
    
    const time = new Date().toLocaleTimeString();
    const riskColor = result.risk_level === 'safe' ? 'success' : 
                     result.risk_level === 'warning' ? 'warning' : 'danger';
    
    const historyItem = document.createElement('div');
    historyItem.className = 'border-bottom pb-2 mb-2';
    historyItem.innerHTML = `
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <strong>${result.emotion.toUpperCase().replace('_', ' ')}</strong>
                <small class="text-muted ms-2">${time}</small>
            </div>
            <div>
                <span class="badge bg-${riskColor}">${Math.round(result.confidence * 100)}%</span>
            </div>
        </div>
    `;
    
    historyEl.insertBefore(historyItem, historyEl.firstChild);
    
    // Keep only last 5 entries
    while (historyEl.children.length > 5) {
        historyEl.removeChild(historyEl.lastChild);
    }
}
</script>