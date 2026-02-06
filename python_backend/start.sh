#!/bin/bash
echo "🚀 Starting SafeSound AI - Huawei ModelArts Backend"
echo "📁 Current directory: $(pwd)"
echo "📋 Installing requirements..."

python3 -m pip install -r requirements.txt

echo "🤖 Starting FastAPI server..."
echo "🌐 API will be available at: http://localhost:8001"
echo "📊 API docs at: http://localhost:8001/docs"

python3 -m uvicorn app:app --host 0.0.0.0 --port 8001 --reload




