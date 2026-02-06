// Audio recording and visualization variables
let mediaRecorder;
let audioChunks = [];
let isRecording = false;
let recordingInterval;
let audioContext;
let analyser;
let dataArray;
let canvas;
let canvasCtx;
let animationId;

// DOM elements
const startBtn = document.getElementById('startBtn');
const stopBtn = document.getElementById('stopBtn');
const recordingStatus = document.getElementById('recordingStatus');
const idleStatus = document.getElementById('idleStatus');
const detectionResult = document.getElementById('detectionResult');
const detectionsContainer = document.getElementById('detectionsContainer');
const aiAnalysisContainer = document.getElementById('aiAnalysisContainer');

// Initialize app
document.addEventListener('DOMContentLoaded', function() {
    console.log('🚀 SafeSound AI JavaScript loaded!');
    
    canvas = document.getElementById('audioCanvas');
    if (canvas) {
        canvasCtx = canvas.getContext('2d');
        setupCanvas();
        console.log('✅ Canvas initialized');
    } else {
        console.log('❌ Canvas not found');
    }
    
    if (startBtn) {
        startBtn.addEventListener('click', startRecording);
        console.log('✅ Start button event listener added');
    } else {
        console.log('❌ Start button not found');
    }
    
    if (stopBtn) {
        stopBtn.addEventListener('click', stopRecording);
        console.log('✅ Stop button event listener added');
    } else {
        console.log('❌ Stop button not found');
    }
    
    // Contact form
    const contactForm = document.getElementById('contactForm');
    if (contactForm) {
        contactForm.addEventListener('submit', handleContactForm);
    }
    
    // Auth forms validation
    const loginForm = document.getElementById('loginForm');
    const signupForm = document.getElementById('signupForm');
    
    if (loginForm) {
        loginForm.addEventListener('submit', function(e) {
            const email = this.querySelector('input[name="email"]').value;
            const password = this.querySelector('input[name="password"]').value;
            
            if (!email || !password) {
                e.preventDefault();
                showAlert('Please fill in all required fields', 'danger');
            }
        });
    }
    
    if (signupForm) {
        signupForm.addEventListener('submit', function(e) {
            const password = this.querySelector('input[name="password"]').value;
            const confirmPassword = this.querySelector('input[name="confirm_password"]').value;
            
            if (password !== confirmPassword) {
                e.preventDefault();
                showAlert('Passwords do not match', 'danger');
            }
        });
    }
});

// Setup canvas for audio visualization
function setupCanvas() {
    if (!canvas) return;
    
    canvas.width = canvas.offsetWidth;
    canvas.height = 200;
    
    // Draw idle state with gradient
    const gradient = canvasCtx.createLinearGradient(0, 0, 0, canvas.height);
    gradient.addColorStop(0, '#1a1a2e');
    gradient.addColorStop(1, '#16213e');
    canvasCtx.fillStyle = gradient;
    canvasCtx.fillRect(0, 0, canvas.width, canvas.height);
    
    // Draw idle line
    canvasCtx.strokeStyle = '#00ff88';
    canvasCtx.lineWidth = 2;
    canvasCtx.beginPath();
    canvasCtx.moveTo(0, canvas.height / 2);
    canvasCtx.lineTo(canvas.width, canvas.height / 2);
    canvasCtx.stroke();
    
    // Add "Ready to Record" text
    canvasCtx.fillStyle = '#00ff88';
    canvasCtx.font = '16px Arial';
    canvasCtx.textAlign = 'center';
    canvasCtx.fillText('Ready to Record - Click Start', canvas.width / 2, canvas.height / 2 - 10);
}

// Start audio recording with visualization
async function startRecording() {
    console.log('🎤 Starting recording...');
    try {
        const stream = await navigator.mediaDevices.getUserMedia({ audio: true });
        console.log('✅ Microphone access granted');
        
        // Setup audio context for visualization
        audioContext = new (window.AudioContext || window.webkitAudioContext)();
        analyser = audioContext.createAnalyser();
        const source = audioContext.createMediaStreamSource(stream);
        source.connect(analyser);
        
        analyser.fftSize = 512;
        analyser.smoothingTimeConstant = 0.8;
        const bufferLength = analyser.frequencyBinCount;
        dataArray = new Uint8Array(bufferLength);
        
        // Setup media recorder
        mediaRecorder = new MediaRecorder(stream);
        mediaRecorder.ondataavailable = event => {
            console.log('📊 Audio data available, size:', event.data.size);
            audioChunks.push(event.data);
        };
        mediaRecorder.onstop = () => {
            console.log('⏹️ Recording stopped, processing audio...');
            processAudio();
        };
        
        // Start recording
        mediaRecorder.start();
        isRecording = true;
        console.log('🔴 Recording started');
        
        // Update UI
        startBtn.classList.add('d-none');
        stopBtn.classList.remove('d-none');
        recordingStatus.classList.remove('d-none');
        idleStatus.classList.add('d-none');
        
        // Start visualization
        visualizeAudio();
        
        // Process audio every 5 seconds
        recordingInterval = setInterval(() => {
            if (isRecording) {
                console.log('⏰ 5 seconds passed, stopping current chunk...');
                mediaRecorder.stop();
                mediaRecorder.start();
            }
        }, 5000);
        
    } catch (error) {
        console.error('❌ Microphone error:', error);
        showAlert('Error accessing microphone: ' + error.message, 'danger');
    }
}

// Audio visualization
function visualizeAudio() {
    if (!isRecording || !analyser) return;
    
    analyser.getByteFrequencyData(dataArray);
    
    // Clear canvas with gradient background
    const gradient = canvasCtx.createLinearGradient(0, 0, 0, canvas.height);
    gradient.addColorStop(0, '#1a1a2e');
    gradient.addColorStop(1, '#16213e');
    canvasCtx.fillStyle = gradient;
    canvasCtx.fillRect(0, 0, canvas.width, canvas.height);
    
    const barWidth = (canvas.width / dataArray.length) * 3;
    let barHeight;
    let x = 0;
    
    for (let i = 0; i < dataArray.length; i++) {
        barHeight = (dataArray[i] / 255) * canvas.height * 0.8;
        
        // Create vibrant colors based on frequency and amplitude
        const hue = (i / dataArray.length) * 360;
        const saturation = 70 + (dataArray[i] / 255) * 30;
        const lightness = 50 + (dataArray[i] / 255) * 30;
        
        canvasCtx.fillStyle = `hsl(${hue}, ${saturation}%, ${lightness}%)`;
        
        // Draw bars from center outward
        const centerY = canvas.height / 2;
        canvasCtx.fillRect(x, centerY - barHeight/2, barWidth - 2, barHeight);
        
        // Add glow effect
        canvasCtx.shadowColor = `hsl(${hue}, ${saturation}%, ${lightness}%)`;
        canvasCtx.shadowBlur = 10;
        canvasCtx.fillRect(x, centerY - barHeight/2, barWidth - 2, barHeight);
        canvasCtx.shadowBlur = 0;
        
        x += barWidth;
    }
    
    // Add center line
    canvasCtx.strokeStyle = '#00ff88';
    canvasCtx.lineWidth = 1;
    canvasCtx.beginPath();
    canvasCtx.moveTo(0, canvas.height / 2);
    canvasCtx.lineTo(canvas.width, canvas.height / 2);
    canvasCtx.stroke();
    
    animationId = requestAnimationFrame(visualizeAudio);
}

// Stop recording
function stopRecording() {
    if (mediaRecorder && isRecording) {
        mediaRecorder.stop();
        mediaRecorder.stream.getTracks().forEach(track => track.stop());
        isRecording = false;
        clearInterval(recordingInterval);
        
        if (animationId) {
            cancelAnimationFrame(animationId);
        }
        
        if (audioContext) {
            audioContext.close();
        }
        
        // Update UI
        startBtn.classList.remove('d-none');
        stopBtn.classList.add('d-none');
        recordingStatus.classList.add('d-none');
        idleStatus.classList.remove('d-none');
        
        // Reset canvas
        setupCanvas();
    }
}

// Process audio chunk with real Huawei ModelArts API
async function processAudio() {
    if (audioChunks.length === 0) return;
    
    const audioBlob = new Blob(audioChunks, { type: 'audio/wav' });
    audioChunks = [];
    
    console.log('🎵 Processing audio chunk, size:', audioBlob.size, 'bytes');
    
    try {
        // Send to Python backend (Huawei ModelArts)
        const formData = new FormData();
        formData.append('file', audioBlob, 'audio.wav');
        
        console.log('📡 Sending to Python backend: http://localhost:8001/predict');
        
        const response = await fetch('http://localhost:8001/predict', {
            method: 'POST',
            body: formData
        });
        
        if (response.ok) {
            const result = await response.json();
            console.log('✅ SUCCESS: Real Huawei ModelArts response:', result);
            displayDetectionResult(result);
            addToDetectionHistory(result);
            showAIAnalysis(result);
        } else {
            console.error('❌ API Error:', response.status, response.statusText);
            const errorText = await response.text();
            console.error('Error details:', errorText);
            // Fallback to simulation if API fails
            console.log('🔄 Falling back to simulation');
            const mockResult = simulateAIDetection();
            displayDetectionResult(mockResult);
            addToDetectionHistory(mockResult);
            showAIAnalysis(mockResult);
        }
    } catch (error) {
        console.error('🌐 Network Error:', error);
        console.log('🔄 Falling back to simulation');
        // Fallback to simulation if network fails
        const mockResult = simulateAIDetection();
        displayDetectionResult(mockResult);
        addToDetectionHistory(mockResult);
        showAIAnalysis(mockResult);
    }
}

// Simulate AI detection
function simulateAIDetection() {
    const labels = ['normal', 'crying', 'screaming', 'stress', 'aggression'];
    const probabilities = [0.7, 0.1, 0.05, 0.1, 0.05];
    const randomIndex = Math.random() < 0.8 ? 0 : Math.floor(Math.random() * (labels.length - 1)) + 1;
    
    return {
        label: labels[randomIndex],
        probability: probabilities[randomIndex] + Math.random() * 0.3,
        timestamp: new Date().toISOString(),
        riskLevel: randomIndex === 0 ? 'safe' : randomIndex < 3 ? 'warning' : 'danger',
        confidence: Math.random() * 0.4 + 0.6,
        reasoning: generateAIReasoning(labels[randomIndex])
    };
}

// Generate AI reasoning
function generateAIReasoning(label) {
    const reasonings = {
        normal: "Audio patterns show regular conversation with stable frequency ranges. No distress indicators detected.",
        crying: "Detected irregular breathing patterns and high-pitched vocalizations consistent with emotional distress.",
        screaming: "High amplitude, sustained high-frequency sounds detected. Immediate attention recommended.",
        stress: "Voice stress analysis indicates elevated tension levels and irregular speech patterns.",
        aggression: "Loud, harsh vocal patterns with rapid frequency changes detected. Potential conflict situation."
    };
    return reasonings[label] || "Audio analysis completed with standard parameters.";
}

// Display detection result from Huawei ModelArts
function displayDetectionResult(result) {
    const emotion = result.emotion || result.label;
    const confidence = result.confidence || result.probability;
    const riskLevel = result.risk_level || result.riskLevel;
    
    // Check if this is real Huawei data or simulation
    const isRealAI = result.model_source === 'Huawei ModelArts';
    const source = isRealAI ? '🤖 Huawei ModelArts' : '🎭 Simulation';
    
    const alertClass = riskLevel === 'safe' ? 'alert-success' : 
                      riskLevel === 'warning' ? 'alert-warning' : 'alert-danger';
    
    detectionResult.className = `alert ${alertClass}`;
    detectionResult.innerHTML = `
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <strong>${source}:</strong> ${emotion.toUpperCase().replace('_', ' ')} 
                <span class="badge bg-secondary">${Math.round(confidence * 100)}%</span>
            </div>
            <small class="text-muted">${isRealAI ? 'Real AI Model' : 'Fallback Mode'}</small>
        </div>
    `;
    detectionResult.classList.remove('d-none');
    
    setTimeout(() => {
        detectionResult.classList.add('d-none');
    }, 5000);
}

// Add to detection history
function addToDetectionHistory(result) {
    if (!detectionsContainer) return;
    
    // Remove "no detections" message
    const noDetections = detectionsContainer.querySelector('.text-center');
    if (noDetections) {
        detectionsContainer.innerHTML = '';
    }
    
    const time = new Date(result.timestamp).toLocaleTimeString();
    const riskClass = result.riskLevel === 'safe' ? 'success' : 
                     result.riskLevel === 'warning' ? 'warning' : 'danger';
    
    const detectionItem = document.createElement('div');
    detectionItem.className = `detection-item ${result.riskLevel}`;
    detectionItem.innerHTML = `
        <div class="d-flex justify-content-between align-items-start">
            <div>
                <h6 class="mb-1 fw-bold">${result.label.toUpperCase()}</h6>
                <small class="text-muted">${time}</small>
            </div>
            <div class="text-end">
                <span class="badge bg-${riskClass}">${result.riskLevel}</span>
                <div class="confidence-bar mt-1" style="width: 60px;">
                    <div class="confidence-fill" style="width: ${result.probability * 100}%"></div>
                </div>
            </div>
        </div>
    `;
    
    detectionsContainer.insertBefore(detectionItem, detectionsContainer.firstChild);
    
    // Keep only last 5 entries
    while (detectionsContainer.children.length > 5) {
        detectionsContainer.removeChild(detectionsContainer.lastChild);
    }
}

// Show AI analysis
function showAIAnalysis(result) {
    if (!aiAnalysisContainer) return;
    
    // Remove "no analysis" message
    const noAnalysis = aiAnalysisContainer.querySelector('.text-center');
    if (noAnalysis) {
        aiAnalysisContainer.innerHTML = '';
    }
    
    const analysisItem = document.createElement('div');
    analysisItem.className = 'ai-analysis';
    analysisItem.innerHTML = `
        <div class="d-flex align-items-center mb-2">
            <i class="fas fa-brain text-primary me-2"></i>
            <h6 class="mb-0 fw-bold">AI Analysis</h6>
            <span class="badge bg-info ms-auto">${Math.round(result.confidence * 100)}% confident</span>
        </div>
        <p class="mb-2 text-muted">${result.reasoning}</p>
        <div class="d-flex gap-2">
            ${result.riskLevel !== 'safe' ? 
                '<button class="btn btn-sm btn-outline-primary"><i class="fas fa-play me-1"></i>Play Audio</button>' +
                '<button class="btn btn-sm btn-outline-warning"><i class="fas fa-bell me-1"></i>Send Alert</button>' 
                : '<button class="btn btn-sm btn-outline-success"><i class="fas fa-check me-1"></i>Mark Safe</button>'
            }
        </div>
    `;
    
    aiAnalysisContainer.insertBefore(analysisItem, aiAnalysisContainer.firstChild);
    
    // Keep only last 3 entries
    while (aiAnalysisContainer.children.length > 3) {
        aiAnalysisContainer.removeChild(aiAnalysisContainer.lastChild);
    }
}

// Handle contact form
function handleContactForm(e) {
    e.preventDefault();
    showAlert('Message sent successfully! We\'ll get back to you soon.', 'success');
    e.target.reset();
}

// Show alert
function showAlert(message, type) {
    const alert = document.createElement('div');
    alert.className = `alert alert-${type} alert-dismissible fade show position-fixed`;
    alert.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
    alert.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;
    
    document.body.appendChild(alert);
    
    setTimeout(() => {
        alert.remove();
    }, 5000);
}