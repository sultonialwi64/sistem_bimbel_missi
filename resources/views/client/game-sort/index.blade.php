@extends('layouts.app')

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@400;600;700&display=swap" rel="stylesheet">
<style>
    .font-game {
        font-family: 'Fredoka', 'Comic Sans MS', sans-serif;
    }
    
    /* Festive Background - CSS Art */
    .party-bg {
        background-color: #fcebd1;
        background-image: 
            radial-gradient(circle at 15% 50%, rgba(255, 182, 193, 0.4) 10%, transparent 40%),
            radial-gradient(circle at 85% 30%, rgba(173, 216, 230, 0.4) 15%, transparent 50%),
            radial-gradient(circle at 50% 80%, rgba(255, 255, 224, 0.4) 20%, transparent 50%),
            radial-gradient(circle at 30% 20%, rgba(221, 160, 221, 0.4) 12%, transparent 40%),
            radial-gradient(circle at 70% 70%, rgba(144, 238, 144, 0.4) 18%, transparent 50%);
        position: relative;
        overflow: hidden;
    }
    
    /* Wood texture for belt/floor */
    .wood-floor {
        background-color: #e5a96b;
        background-image: repeating-linear-gradient(
            0deg,
            rgba(0,0,0,0.03) 0px,
            rgba(0,0,0,0.03) 2px,
            transparent 2px,
            transparent 30px
        );
        box-shadow: inset 0 20px 20px -20px rgba(0,0,0,0.5);
    }

    /* Bunting Flags */
    .bunting-container {
        display: flex;
        width: 100%;
        overflow: hidden;
        height: 30px;
        background: linear-gradient(to bottom, rgba(0,0,0,0.1), transparent);
    }
    .flag {
        width: 0;
        height: 0;
        border-left: 20px solid transparent;
        border-right: 20px solid transparent;
        border-top: 30px solid;
        display: inline-block;
        filter: drop-shadow(0 2px 2px rgba(0,0,0,0.2));
    }

    /* Conveyor belt styling */
    .conveyor-belt {
        background: repeating-linear-gradient(
            90deg,
            #d4d4d4,
            #d4d4d4 20px,
            #a3a3a3 20px,
            #a3a3a3 22px
        );
        box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1), inset 0 10px 10px -10px rgba(0,0,0,0.3), inset 0 -10px 10px -10px rgba(0,0,0,0.3);
        border-top: 4px solid #737373;
        border-bottom: 4px solid #737373;
    }

    /* Target Box (Dropzone) */
    .target-box {
        border: 4px dashed #65a30d; /* lime-600 */
        background-color: #bef264; /* lime-300 */
        box-shadow: inset 0 0 15px rgba(101, 163, 13, 0.3), 0 5px 15px rgba(0,0,0,0.1);
        transition: all 0.2s;
    }
    .target-box.drag-over {
        transform: scale(1.05);
        background-color: #d9f99d; /* lime-200 */
        border-color: #4d7c0f; /* lime-700 */
        box-shadow: inset 0 0 25px rgba(101, 163, 13, 0.5), 0 10px 20px rgba(0,0,0,0.2);
    }

    /* Word Tile */
    .word-tile {
        background: linear-gradient(135deg, #a78bfa, #8b5cf6); /* purple */
        border: 4px solid #fff;
        box-shadow: 0 4px 10px rgba(0,0,0,0.2), inset 0 0 10px rgba(255,255,255,0.4);
        text-shadow: 1px 1px 2px rgba(0,0,0,0.3);
        cursor: grab;
        touch-action: none; /* Crucial for pointer events */
        user-select: none;
    }
    .word-tile:active {
        cursor: grabbing;
    }

    /* Animations */
    @keyframes slideRightToLeft {
        from { transform: translateX(100%); }
        to { transform: translateX(-100%); }
    }
    
    @keyframes pop {
        0% { transform: scale(0.5); opacity: 0; }
        70% { transform: scale(1.2); opacity: 1; }
        100% { transform: scale(1); opacity: 1; }
    }
    .animate-pop { animation: pop 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275) forwards; }
    
    @keyframes fadeOutUp {
        0% { transform: translateY(0); opacity: 1; }
        100% { transform: translateY(-50px); opacity: 0; }
    }
    .animate-fadeout { animation: fadeOutUp 0.5s ease-in forwards; }
    
    @keyframes wiggle {
        0%, 100% { transform: rotate(0deg); }
        25% { transform: rotate(-10deg); }
        75% { transform: rotate(10deg); }
    }
    .animate-wiggle { animation: wiggle 0.3s ease-in-out infinite; }

</style>
@endpush

@section('content')
<!-- Add overflow-hidden to body to prevent scrolling while dragging -->
<style> body { overflow: hidden; touch-action: none; } </style>

<div id="sort-game-wrapper" class="w-full h-[calc(100vh-100px)] relative overflow-hidden font-game rounded-[2rem] border-4 border-indigo-200 party-bg" x-data="sortGame()">
    
    <!-- Top Bunting -->
    <div class="absolute top-0 inset-x-0 z-10 flex">
        <div class="bunting-container" id="top-bunting"></div>
    </div>

    <!-- Header Overlay -->
    <div class="absolute top-8 inset-x-0 p-4 sm:p-6 flex justify-between items-start z-30 pointer-events-none">
        @php
            $role = auth()->user()->role ?? 'client';
            $backRoute = match($role) {
                'admin' => route('admin.learning-media.index'),
                'tutor' => route('tutor.learning-media.index'),
                default => route('client.learning-media.index')
            };
        @endphp
        <a href="{{ $backRoute }}" class="pointer-events-auto bg-white/90 backdrop-blur shadow-lg p-3 sm:px-6 sm:py-3 rounded-2xl text-indigo-900 hover:bg-white hover:scale-105 transition-all flex items-center gap-2 group border-2 border-indigo-100">
            <svg class="w-6 h-6 sm:w-5 sm:h-5 text-indigo-500 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            <span class="font-bold hidden sm:block">Kembali</span>
        </a>
        
        <div class="pointer-events-auto bg-white/90 backdrop-blur border-2 border-slate-200 px-6 py-2.5 rounded-2xl text-slate-800 font-bold text-xl shadow-lg flex items-center gap-3">
            <svg class="w-6 h-6 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
            <span x-text="score"></span> / <span x-text="totalWords"></span>
        </div>
    </div>

    <!-- Splash Screen -->
    <div x-show="!isStarted && !isGameOver"
         x-transition:leave="transition ease-in-out duration-700 transform"
         x-transition:leave-start="translate-y-0 opacity-100"
         x-transition:leave-end="-translate-y-full opacity-0"
         class="absolute inset-0 z-50 flex flex-col items-center justify-center bg-gradient-to-br from-indigo-500/95 to-purple-600/95 backdrop-blur-sm p-8 text-white text-center">
        <div class="relative z-10 space-y-8 max-w-md">
            <h1 class="text-5xl sm:text-7xl font-black tracking-tight leading-none drop-shadow-lg text-yellow-300">
                SORT<br><span class="text-white">THE DAYS</span>
            </h1>
            <p class="text-xl font-medium text-indigo-50/90 leading-relaxed max-w-sm mx-auto">
                Tarik kotak kata yang berjalan ke tempat yang tepat (Days atau Months)!
            </p>
            <button @click="startGame()" 
                    class="w-full py-5 bg-yellow-400 hover:bg-yellow-300 text-amber-950 font-black text-2xl rounded-3xl shadow-[0_8px_0_0_#c59b27] hover:translate-y-0.5 hover:shadow-[0_6px_0_0_#c59b27] active:translate-y-2 active:shadow-none transition-all duration-150 border-4 border-amber-900/10 cursor-pointer">
                MAIN SEKARANG 🎮
            </button>
        </div>
    </div>

    <!-- Game Over Screen -->
    <div x-show="isGameOver" style="display: none;"
         x-transition:enter="transition ease-out duration-700 delay-500 transform"
         x-transition:enter-start="scale-50 opacity-0"
         x-transition:enter-end="scale-100 opacity-100"
         class="absolute inset-0 z-50 flex flex-col items-center justify-center bg-black/60 backdrop-blur p-8 text-white text-center">
        <div class="bg-white rounded-[3rem] p-10 max-w-sm w-full text-center shadow-2xl border-8 border-yellow-400">
            <div class="w-32 h-32 mx-auto bg-emerald-100 rounded-full flex items-center justify-center mb-6 shadow-inner">
                <svg class="w-20 h-20 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="4" d="M5 13l4 4L19 7"/></svg>
            </div>
            <h2 class="text-4xl font-black text-slate-800 mb-2">Hebat!</h2>
            <p class="text-slate-500 font-bold text-lg mb-8">Kamu berhasil mengelompokkan semua kata.</p>
            <button @click="resetGame()" 
                    class="w-full py-4 bg-indigo-500 hover:bg-indigo-400 text-white font-black text-xl rounded-2xl shadow-[0_6px_0_0_#3730a3] hover:translate-y-0.5 hover:shadow-[0_4px_0_0_#3730a3] active:translate-y-2 active:shadow-none transition-all cursor-pointer">
                MAIN LAGI 🔄
            </button>
        </div>
    </div>

    <!-- Game Arena (Scaled) -->
    <div x-show="isStarted" class="absolute inset-0 flex flex-col justify-between items-center z-20 pt-[100px]">
        
        <!-- Conveyor Belt Area -->
        <div class="w-full h-40 mt-10 relative overflow-hidden flex items-center conveyor-belt shadow-2xl">
            <!-- Items on belt -->
            <template x-for="item in activeItems" :key="item.id">
                <div :id="'item-'+item.id"
                     draggable="false"
                     @mousedown="startDrag($event, item)"
                     @touchstart="startDrag($event, item)"
                     class="absolute top-1/2 -translate-y-1/2 w-40 h-24 word-tile rounded-xl flex items-center justify-center text-white text-2xl font-bold z-10 transition-opacity duration-150"
                     :class="item.isGrabbed ? 'opacity-0' : 'opacity-100'"
                     :style="`left: ${item.x}px;`"
                     x-text="item.word">
                </div>
            </template>
        </div>

        <!-- Feedback Overlay (Check/Cross) -->
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 z-40 pointer-events-none">
            <div x-show="feedback === 'success'" style="display: none;" class="animate-pop w-40 h-40 bg-emerald-500/90 backdrop-blur rounded-full flex items-center justify-center shadow-[0_0_50px_rgba(16,185,129,0.5)] border-4 border-white">
                <svg class="w-24 h-24 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="4" d="M5 13l4 4L19 7"/></svg>
            </div>
            <div x-show="feedback === 'error'" style="display: none;" class="animate-pop w-40 h-40 bg-rose-500/90 backdrop-blur rounded-full flex items-center justify-center shadow-[0_0_50px_rgba(244,63,94,0.5)] border-4 border-white">
                <svg class="w-24 h-24 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="4" d="M6 18L18 6M6 6l12 12"/></svg>
            </div>
        </div>

        <!-- Target Zones at Bottom -->
        <div class="w-full h-1/2 wood-floor relative flex justify-center items-end pb-8 sm:pb-12 px-4 gap-6 sm:gap-16">
            <!-- Middle Bunting -->
            <div class="absolute top-0 inset-x-0 z-10 flex rotate-180">
                <div class="bunting-container" id="mid-bunting"></div>
            </div>

            <div id="zone-month" class="target-box w-40 sm:w-56 h-32 sm:h-40 rounded-2xl flex items-center justify-center relative" 
                 :class="{ 
                     'drag-over': hoverZone === 'month',
                     'animate-wiggle ring-8 ring-emerald-400 shadow-[0_0_40px_rgba(52,211,153,0.8)]': animatingZone === 'month' && animatingFeedback === 'success',
                     'animate-wiggle ring-8 ring-rose-400 shadow-[0_0_40px_rgba(244,63,94,0.8)] !bg-rose-300 !border-rose-600': animatingZone === 'month' && animatingFeedback === 'error'
                 }">
                <div class="absolute inset-0 overflow-hidden rounded-2xl pointer-events-none">
                    <div class="absolute -bottom-4 -right-4 text-8xl opacity-20">📅</div>
                </div>
                <span class="text-3xl sm:text-4xl font-black text-lime-900 drop-shadow-md z-10" :class="{'!text-rose-900': animatingZone === 'month' && animatingFeedback === 'error'}">Months</span>
            </div>
            <div id="zone-day" class="target-box w-40 sm:w-56 h-32 sm:h-40 rounded-2xl flex items-center justify-center relative" 
                 :class="{ 
                     'drag-over': hoverZone === 'day',
                     'animate-wiggle ring-8 ring-emerald-400 shadow-[0_0_40px_rgba(52,211,153,0.8)]': animatingZone === 'day' && animatingFeedback === 'success',
                     'animate-wiggle ring-8 ring-rose-400 shadow-[0_0_40px_rgba(244,63,94,0.8)] !bg-rose-300 !border-rose-600': animatingZone === 'day' && animatingFeedback === 'error'
                 }">
                <div class="absolute inset-0 overflow-hidden rounded-2xl pointer-events-none">
                    <div class="absolute -bottom-4 -right-4 text-8xl opacity-20">☀️</div>
                </div>
                <span class="text-3xl sm:text-4xl font-black text-lime-900 drop-shadow-md z-10" :class="{'!text-rose-900': animatingZone === 'day' && animatingFeedback === 'error'}">Days</span>
            </div>
        </div>
    </div>
    
    <!-- Dragged Element Clone -->
    <div x-show="draggedItem !== null"
         id="drag-ghost"
         class="fixed word-tile rounded-xl flex items-center justify-center text-white text-2xl font-bold z-50 pointer-events-none opacity-90 scale-110 shadow-2xl"
         style="width: 160px; height: 96px; display: none;"
         :style="`left: ${dragX}px; top: ${dragY}px; transform: translate(-50%, -50%) ${dragWiggle ? 'rotate(5deg)' : 'rotate(-5deg)'}`"
         x-text="draggedItem ? draggedItem.word : ''">
    </div>

</div>

@push('scripts')
<script>
    // Generate random bunting colors
    function createBunting(containerId) {
        const colors = ['#f43f5e', '#3b82f6', '#10b981', '#f59e0b', '#8b5cf6', '#ec4899', '#06b6d4'];
        const container = document.getElementById(containerId);
        if(!container) return;
        const numFlags = Math.ceil(window.innerWidth / 40) + 2;
        let html = '';
        for(let i=0; i<numFlags; i++) {
            const color = colors[i % colors.length];
            html += `<div class="flag" style="border-top-color: ${color}"></div>`;
        }
        container.innerHTML = html;
    }

    document.addEventListener('DOMContentLoaded', () => {
        createBunting('top-bunting');
        createBunting('mid-bunting');
        window.addEventListener('resize', () => {
            createBunting('top-bunting');
            createBunting('mid-bunting');
        });
    });

    document.addEventListener('alpine:init', () => {
        Alpine.data('sortGame', () => ({
            rawWords: [
                { word: 'Monday', type: 'day' },
                { word: 'January', type: 'month' },
                { word: 'Friday', type: 'day' },
                { word: 'August', type: 'month' },
                { word: 'Sunday', type: 'day' },
                { word: 'December', type: 'month' },
                { word: 'Wednesday', type: 'day' },
                { word: 'March', type: 'month' },
                { word: 'Tuesday', type: 'day' },
                { word: 'October', type: 'month' }
            ],
            words: [],
            activeItems: [],
            score: 0,
            totalWords: 10,
            isStarted: false,
            isGameOver: false,
            
            // Conveyor engine
            conveyorSpeed: 2.5,
            animationFrame: null,
            spawnTimer: null,
            
            // Drag state
            draggedItem: null,
            dragX: 0,
            dragY: 0,
            hoverZone: null,
            dragWiggle: false,
            wiggleInterval: null,
            
            feedback: null, // 'success' or 'error'
            feedbackTimer: null,
            
            animatingZone: null,
            animatingFeedback: null,

            init() {
                // Initialize game state but don't start conveyor yet
                this.resetGame(false);
                
                // Mouse
                window.addEventListener('mousemove', (e) => {
                    if(this.draggedItem) this.onDragMove(e);
                });
                window.addEventListener('mouseup', (e) => {
                    if(this.draggedItem) this.onDragEnd(e);
                });
                
                // Touch
                window.addEventListener('touchmove', (e) => {
                    if(this.draggedItem) {
                        if (e.cancelable) e.preventDefault(); // Stop scrolling while dragging
                        this.onDragMove(e.touches[0]);
                    }
                }, {passive: false});
                
                window.addEventListener('touchend', (e) => {
                    if(this.draggedItem) this.onDragEnd(e.changedTouches[0]);
                });
                window.addEventListener('touchcancel', (e) => {
                    if(this.draggedItem) this.onDragEnd(e.changedTouches[0]);
                });
            },

            resetGame(startImmediately = true) {
                this.score = 0;
                this.isGameOver = false;
                this.activeItems = [];
                // Shuffle words
                this.words = JSON.parse(JSON.stringify(this.rawWords)).sort(() => Math.random() - 0.5);
                this.totalWords = this.words.length;
                
                if (this.animationFrame) cancelAnimationFrame(this.animationFrame);
                
                if(startImmediately) {
                    this.startGame();
                }
            },

            startGame() {
                this.isStarted = true;
                this.lastTime = performance.now();
                this.animationFrame = requestAnimationFrame((t) => this.gameLoop(t));
                
                // Spawn first item immediately
                this.spawnItem();
            },
            
            spawnItem() {
                if (this.words.length === 0) return;
                
                const wordData = this.words.pop();
                const startX = window.innerWidth + 50; // start off-screen right
                
                this.activeItems.push({
                    id: Date.now() + Math.random(),
                    word: wordData.word,
                    type: wordData.type,
                    x: startX,
                    isGrabbed: false
                });
            },

            gameLoop(timestamp) {
                if (!this.isStarted || this.isGameOver) return;
                
                let rightMostX = -9999;
                
                // Move active items left
                for (let i = this.activeItems.length - 1; i >= 0; i--) {
                    let item = this.activeItems[i];
                    
                    if (!item.isGrabbed) {
                        item.x -= this.conveyorSpeed;
                        
                        // If it goes off-screen left, respawn it at the end of the line (put back into words array)
                        if (item.x < -200) {
                            this.words.unshift({ word: item.word, type: item.type });
                            this.activeItems.splice(i, 1);
                            continue;
                        }
                    }
                    
                    if (item.x > rightMostX) {
                        rightMostX = item.x;
                    }
                }
                
                // Distance based spawning: guarantee ~250px gap
                if (this.activeItems.length === 0 || rightMostX < window.innerWidth - 250) {
                    this.spawnItem();
                }
                
                this.animationFrame = requestAnimationFrame((t) => this.gameLoop(t));
            },

            // --- DRAG AND DROP LOGIC ---
            
            startDrag(event, item) {
                if (this.draggedItem) return; // Prevent multi-drag
                if (item.isGrabbed) return; // Prevent grabbing invisible item
                
                if (event.cancelable) event.preventDefault();
                
                // Clear old feedback instantly
                this.feedback = null;
                this.animatingZone = null;
                if (this.feedbackTimer) clearTimeout(this.feedbackTimer);
                
                item.isGrabbed = true;
                this.draggedItem = item;
                
                const isTouch = event.type === 'touchstart';
                this.dragX = isTouch ? event.touches[0].clientX : event.clientX;
                this.dragY = isTouch ? event.touches[0].clientY : event.clientY;
                
                // Play pop sound
                this.playTone(600, 100);
                
                // Wiggle effect
                this.wiggleInterval = setInterval(() => {
                    this.dragWiggle = !this.dragWiggle;
                }, 150);
            },

            onDragMove(event) {
                if (!this.draggedItem) return;
                
                // Use clientX and clientY for coordinates
                this.dragX = event.clientX;
                this.dragY = event.clientY;
                
                // Check if hovering over a zone to show drag-over effect
                this.hoverZone = this.checkZoneHover(this.dragX, this.dragY);
            },
            
            onDragEnd(event) {
                if (!this.draggedItem) return;
                
                const cx = event.clientX !== undefined ? event.clientX : this.dragX;
                const cy = event.clientY !== undefined ? event.clientY : this.dragY;
                
                const zone = this.hoverZone || this.checkZoneHover(cx, cy);
                this.processDrop(zone);
            },
            
            processDrop(zone) {
                clearInterval(this.wiggleInterval);
                
                if (zone) {
                    this.animatingZone = zone;
                    
                    // Evaluate answer
                    if (this.draggedItem.type === zone) {
                        // Correct!
                        this.feedback = 'success';
                        this.animatingFeedback = 'success';
                        this.playTone(800, 100, 'sine');
                        setTimeout(() => this.playTone(1200, 150, 'sine'), 100);
                        this.score++;
                        
                        if (this.score >= this.totalWords) {
                            setTimeout(() => {
                                this.isGameOver = true;
                                this.playTone(500, 200, 'triangle');
                                setTimeout(() => this.playTone(700, 400, 'triangle'), 200);
                            }, 1000);
                        }
                    } else {
                        // Wrong!
                        this.feedback = 'error';
                        this.animatingFeedback = 'error';
                        this.playTone(200, 300, 'sawtooth');
                        // Put back into pool
                        this.words.unshift({ word: this.draggedItem.word, type: this.draggedItem.type });
                    }
                    
                    if (this.feedbackTimer) clearTimeout(this.feedbackTimer);
                    this.feedbackTimer = setTimeout(() => { 
                        this.feedback = null; 
                        this.animatingZone = null;
                    }, 1000);
                } else {
                    // Dropped nowhere, put back in pool
                    this.words.unshift({ word: this.draggedItem.word, type: this.draggedItem.type });
                }
                
                // Remove original from active items
                this.activeItems = this.activeItems.filter(i => i.id !== this.draggedItem.id);
                
                this.draggedItem = null;
                this.hoverZone = null;
            },
            
            checkZoneHover(x, y) {
                const dayBox = document.getElementById('zone-day');
                const monthBox = document.getElementById('zone-month');
                
                if (dayBox && this.isPointInRect(x, y, dayBox.getBoundingClientRect())) return 'day';
                if (monthBox && this.isPointInRect(x, y, monthBox.getBoundingClientRect())) return 'month';
                return null;
            },
            
            isPointInRect(x, y, rect) {
                return x >= rect.left && x <= rect.right && y >= rect.top && y <= rect.bottom;
            },
            
            playTone(frequency, duration, type = 'sine') {
                try {
                    const audioCtx = new (window.AudioContext || window.webkitAudioContext)();
                    const oscillator = audioCtx.createOscillator();
                    const gainNode = audioCtx.createGain();
                    
                    oscillator.type = type;
                    oscillator.frequency.value = frequency;
                    
                    oscillator.connect(gainNode);
                    gainNode.connect(audioCtx.destination);
                    
                    gainNode.gain.setValueAtTime(0.1, audioCtx.currentTime);
                    gainNode.gain.exponentialRampToValueAtTime(0.001, audioCtx.currentTime + duration / 1000);
                    
                    oscillator.start();
                    setTimeout(() => {
                        oscillator.stop();
                    }, duration);
                } catch(e) {
                    console.log('Audio disabled or not supported');
                }
            }
        }));
    });
</script>
@endpush
@endsection
