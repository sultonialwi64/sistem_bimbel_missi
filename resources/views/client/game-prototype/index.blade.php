@extends('layouts.app')

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@400;700;900&family=Short+Stack&display=swap" rel="stylesheet">
<style>
    .font-game {
        font-family: 'Fredoka', 'Comic Sans MS', sans-serif;
    }
    .font-chalk {
        font-family: 'Short Stack', 'Fredoka', cursive;
        text-shadow: 1px 1px 1px rgba(255, 255, 255, 0.4), -1px -1px 1px rgba(0, 0, 0, 0.2);
    }
    .wood-frame {
        border: 16px solid #5c3a21;
        border-radius: 2.5rem;
        box-shadow: 
            inset 0 0 10px rgba(0,0,0,0.6),
            0 10px 25px rgba(0,0,0,0.4);
    }
    .chalkboard-bg {
        background-color: #143520;
        background-image: 
            radial-gradient(#1a4429 15%, transparent 20%),
            radial-gradient(#1a4429 15%, transparent 20%);
        background-size: 4px 4px;
        background-position: 0 0, 2px 2px;
    }
    @keyframes shake {
        0%, 100% { transform: translateX(0); }
        10%, 30%, 50%, 70%, 90% { transform: translateX(-5px); }
        20%, 40%, 60%, 80% { transform: translateX(5px); }
    }
    .animate-shake {
        animation: shake 0.5s cubic-bezier(.36,.07,.19,.97) both;
    }
</style>
@endpush

@section('content')
<div id="main-game-wrapper" class="w-full h-[calc(100vh-100px)] bg-sky-100 relative overflow-hidden font-game rounded-[2rem] shadow-[inset_0_0_50px_rgba(0,0,0,0.1)] border-4 border-sky-200" x-data="spellingGame()">
    
    <!-- Classroom Background Layers (CSS Art) - FULL SCREEN -->
    <div class="absolute inset-0 z-0 pointer-events-none flex flex-col">
        <!-- Wallpaper / Wall -->
        <div class="flex-1 bg-gradient-to-b from-sky-100 to-sky-50 relative overflow-hidden">
            <!-- Posters on wall -->
            <div class="absolute top-8 left-8 sm:left-16 w-24 h-36 sm:w-32 sm:h-44 bg-yellow-50 border-4 border-yellow-200 rounded-xl shadow-md flex flex-col items-center justify-center transform -rotate-3 opacity-90">
                <span class="text-yellow-500 font-black text-4xl sm:text-5xl leading-none mb-2">A</span>
                <span class="text-yellow-500 font-black text-3xl sm:text-4xl leading-none">B C</span>
            </div>
            <div class="absolute top-12 right-8 sm:right-16 w-20 h-28 sm:w-28 sm:h-36 bg-pink-50 border-4 border-pink-200 rounded-xl shadow-md flex flex-col items-center justify-center transform rotate-6 opacity-90">
                <span class="text-pink-400 font-black text-3xl sm:text-4xl leading-none mb-2">1 2</span>
                <span class="text-pink-400 font-black text-3xl sm:text-4xl leading-none">3</span>
            </div>
            <!-- Clock -->
            <div class="absolute top-6 left-1/2 -translate-x-1/2 w-20 h-20 sm:w-24 sm:h-24 bg-white border-[8px] border-amber-700 rounded-full shadow-lg flex items-center justify-center">
                <div class="w-2 h-2 bg-slate-800 rounded-full absolute z-10"></div>
                <div class="w-1.5 h-6 sm:h-8 bg-slate-800 rounded-full origin-bottom absolute bottom-1/2 -rotate-45"></div>
                <div class="w-2 h-4 sm:h-5 bg-slate-800 rounded-full origin-bottom absolute bottom-1/2 rotate-45"></div>
            </div>
        </div>
        <!-- Wooden Floor / Wainscoting -->
        <div class="h-2/5 bg-amber-700 border-t-[16px] border-amber-900 relative shadow-[inset_0_15px_30px_rgba(0,0,0,0.4)]">
            <!-- Wood stripes -->
            <div class="absolute inset-0 opacity-30" style="background-image: repeating-linear-gradient(90deg, transparent, transparent 60px, rgba(0,0,0,0.8) 60px, rgba(0,0,0,0.8) 64px);"></div>
        </div>
    </div>
    
    <!-- Splash / Welcome Screen (Slides out on Start) -->
    <div x-show="!isStarted"
         x-transition:leave="transition ease-in-out duration-700 transform"
         x-transition:leave-start="translate-x-0 opacity-100"
         x-transition:leave-end="-translate-x-full opacity-0"
         class="absolute inset-0 z-50 flex flex-col items-center justify-center bg-gradient-to-br from-indigo-500 via-purple-500 to-pink-500 p-8 text-white text-center">
        
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_30%_30%,rgba(255,255,255,0.2),transparent_50%)] pointer-events-none"></div>
        
        <div class="relative z-10 space-y-8 max-w-md">
            <div class="animate-bounce">
                <span class="inline-block bg-white/20 px-6 py-2 rounded-full border-2 border-white/40 text-sm font-black tracking-widest uppercase shadow-md">
                    English is Fun!
                </span>
            </div>
            
            <h1 class="text-5xl sm:text-7xl font-black tracking-tight leading-none drop-shadow-lg">
                SPELLING<br><span class="text-yellow-300">GAME</span>
            </h1>
            
            <p class="text-lg font-medium text-indigo-50/90 leading-relaxed max-w-sm mx-auto">
                Dengarkan pelafalan suaranya dan susun hurufnya ke dalam papan tulis sekolah!
            </p>
            
            <button @click="startGame()" 
                    class="w-full py-5 bg-yellow-400 hover:bg-yellow-300 text-amber-950 font-black text-2xl rounded-3xl shadow-[0_8px_0_0_#c59b27] hover:translate-y-0.5 hover:shadow-[0_6px_0_0_#c59b27] active:translate-y-2 active:shadow-none transition-all duration-150 border-4 border-amber-900/10 cursor-pointer">
                MULAI BELAJAR 🎒
            </button>
        </div>
    </div>

    <!-- Header Overlay (Always visible when playing) -->
    <div class="absolute top-0 inset-x-0 p-4 sm:p-6 flex justify-between items-start z-30 pointer-events-none" x-show="isStarted" x-transition.opacity.duration.700ms>
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
        
        <div class="pointer-events-auto bg-amber-900/90 backdrop-blur border-4 border-amber-800 px-6 py-2.5 rounded-2xl text-amber-50 font-bold text-xl shadow-[0_4px_15px_rgba(0,0,0,0.3)]">
            Level <span x-text="currentLevelIndex + 1"></span> / <span x-text="words.length"></span>
        </div>
    </div>

    <!-- Game Arena Content -->
    <div x-show="isStarted"
         x-transition:enter="transition ease-out duration-700 delay-200 transform"
         x-transition:enter-start="translate-x-full opacity-0"
         x-transition:enter-end="translate-x-0 opacity-100"
         class="absolute top-[80px] inset-x-0 bottom-0 z-20 flex items-center justify-center overflow-hidden pointer-events-none">
        
        <!-- Scalable Fixed-Ratio Container -->
        <div class="relative w-[800px] h-[520px] flex flex-col items-center justify-between pointer-events-auto"
             :style="`transform: scale(${scale}); transform-origin: center;`">
            
            <!-- Chalkboard Frame -->
            <div class="w-full h-[340px] chalkboard-bg wood-frame p-6 flex flex-col items-center justify-center relative shadow-[0_25px_50px_-12px_rgba(0,0,0,0.5)]">
                
                <div class="absolute inset-0 bg-[linear-gradient(rgba(255,255,255,0.03)_1px,transparent_1px)] pointer-events-none rounded-[1.5rem]"></div>
                
                <!-- Speaker Button -->
                <button @click="speak()" class="relative group mt-2 shrink-0">
                    <div class="absolute inset-0 bg-white/10 rounded-full blur-xl opacity-30 group-hover:opacity-60 transition-opacity"></div>
                    <div class="relative w-24 h-24 bg-gradient-to-br from-yellow-300 to-amber-500 rounded-full flex items-center justify-center shadow-[0_8px_0_0_#9a6a1a] hover:translate-y-1 hover:shadow-[0_5px_0_0_#9a6a1a] active:translate-y-3 active:shadow-none transition-all cursor-pointer border-4 border-amber-100">
                        <svg class="w-12 h-12 text-amber-950 ml-1" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M13.5 4.06c0-1.336-1.616-2.005-2.56-1.06l-4.5 4.5H4.508c-1.141 0-2.318.664-2.66 1.905A9.76 9.76 0 001.5 12c0 .898.121 1.768.35 2.595.341 1.24 1.518 1.905 2.659 1.905h1.93l4.5 4.5c.945.945 2.561.276 2.561-1.06V4.06zM18.584 5.106a.75.75 0 011.06 0c3.808 3.807 3.808 9.98 0 13.788a.75.75 0 11-1.06-1.06 8.25 8.25 0 000-11.668.75.75 0 010-1.06z"/>
                            <path d="M15.932 7.757a.75.75 0 011.061 0 6 6 0 010 8.486.75.75 0 01-1.06-1.061 4.5 4.5 0 000-6.364.75.75 0 010-1.06z"/>
                        </svg>
                    </div>
                </button>

                <!-- Success / Error Message -->
                <div class="h-12 my-2 w-full flex justify-center items-center shrink-0">
                    <div x-show="isSuccess" style="display: none;" class="px-6 py-2 bg-emerald-500 text-white font-bold rounded-full shadow-lg text-2xl flex items-center gap-2">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="4" d="M5 13l4 4L19 7"/></svg>
                        EXCELLENT!
                    </div>
                    <div x-show="isError" style="display: none;" class="px-6 py-2 bg-rose-500 text-white font-bold rounded-full shadow-lg text-2xl flex items-center gap-2">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="4" d="M6 18L18 6M6 6l12 12"/></svg>
                        TRY AGAIN!
                    </div>
                </div>

                <!-- Answer Slots (Chalkboard Style) -->
                <div class="flex gap-4 mt-auto mb-4 justify-center flex-wrap shrink-0" :class="{ 'animate-bounce': isSuccess, 'animate-shake': isError }">
                    <template x-for="(slot, index) in userAnswer" :key="index">
                        <div @click="removeLetter(index)" 
                             class="w-16 h-16 bg-white/5 rounded-2xl border-[5px] border-dashed border-white/40 shadow-inner flex items-center justify-center text-5xl font-chalk text-[#fbf9f5] cursor-pointer hover:bg-white/10 transition-colors"
                             :class="{ 'border-emerald-400 bg-emerald-950/20 text-emerald-300': isSuccess, 'border-rose-400 bg-rose-950/20 text-rose-300': isError }">
                            <span x-text="slot ? slot.char : ''" x-show="slot"></span>
                        </div>
                    </template>
                </div>
            </div>

            <!-- Available Letters (Keyboard Deck at the bottom) -->
            <div class="w-[750px] h-[160px] bg-amber-100/95 backdrop-blur-md p-6 rounded-[2rem] border-[6px] border-amber-200/80 flex flex-wrap gap-4 justify-center items-center relative shadow-[0_15px_30px_rgba(0,0,0,0.3)]">
                <div class="absolute -top-5 bg-amber-800 px-6 py-1.5 text-base font-bold text-amber-50 rounded-full border-2 border-amber-900 shadow-md uppercase tracking-widest">
                    Pilih Huruf
                </div>
                
                <template x-for="(letter, index) in scrambledLetters" :key="letter.id">
                    <button @click="selectLetter(letter)" 
                            :disabled="letter.used || isSuccess"
                            class="w-14 h-14 rounded-xl flex items-center justify-center text-3xl font-black transition-all"
                            :class="letter.used ? 'bg-amber-200/50 text-amber-400/50 border-b-4 border-amber-300/30 cursor-not-allowed scale-95 opacity-50 shadow-none' : 'bg-yellow-400 text-amber-950 border-b-[8px] border-yellow-600 shadow-lg hover:bg-yellow-300 hover:-translate-y-1 active:translate-y-2 active:border-b-4 cursor-pointer'">
                        <span x-text="letter.char"></span>
                    </button>
                </template>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('spellingGame', () => ({
            words: [
                { word: 'one', hint: '1' },
                { word: 'two', hint: '2' },
                { word: 'three', hint: '3' },
                { word: 'four', hint: '4' },
                { word: 'five', hint: '5' },
                { word: 'six', hint: '6' },
                { word: 'seven', hint: '7' },
                { word: 'eight', hint: '8' },
                { word: 'nine', hint: '9' },
                { word: 'ten', hint: '10' }
            ],
            currentLevelIndex: 0,
            currentWord: '',
            scrambledLetters: [],
            userAnswer: [],
            isSuccess: false,
            isError: false,
            availableVoices: [],
            selectedVoiceName: '',
            selectedVoice: null,
            isStarted: false,
            scale: 1,

            updateScale() {
                const wrapper = document.getElementById('main-game-wrapper');
                if (wrapper) {
                    const availableWidth = wrapper.clientWidth - 32; // 16px padding on sides
                    const availableHeight = wrapper.clientHeight - 100; // top offset space
                    
                    const scaleX = availableWidth / 800;
                    const scaleY = availableHeight / 520;
                    
                    this.scale = Math.min(scaleX, scaleY, 1.1); // Cap scale so it doesn't get excessively huge on big monitors
                }
            },

            init() {
                this.loadLevel();
                this.loadVoices();
                if ('speechSynthesis' in window) {
                    window.speechSynthesis.onvoiceschanged = () => this.loadVoices();
                }

                // Initial scale setup and window resize listener
                this.updateScale();
                window.addEventListener('resize', () => this.updateScale());
            },

            startGame() {
                this.isStarted = true;
                setTimeout(() => this.speak(), 500);
            },

            loadVoices() {
                if ('speechSynthesis' in window) {
                    const voices = window.speechSynthesis.getVoices();
                    this.availableVoices = voices.filter(v => v.lang.startsWith('en'));
                    if (this.availableVoices.length > 0 && !this.selectedVoiceName) {
                        const primaryVoice = this.availableVoices.find(v => v.name === 'Google UK English Male');
                        if (primaryVoice) {
                            this.selectedVoiceName = primaryVoice.name;
                            this.selectedVoice = primaryVoice;
                        } else {
                            this.selectedVoiceName = this.availableVoices[0].name;
                            this.selectedVoice = this.availableVoices[0];
                        }
                    }
                }
            },

            loadLevel() {
                this.isSuccess = false;
                this.isError = false;
                const levelData = this.words[this.currentLevelIndex];
                this.currentWord = levelData.word.toUpperCase();
                
                let letters = this.currentWord.split('');
                const alphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
                const decoyCount = Math.max(3, 10 - this.currentWord.length);
                for(let i=0; i<decoyCount; i++) {
                    letters.push(alphabet[Math.floor(Math.random() * alphabet.length)]);
                }
                
                this.scrambledLetters = letters.sort(() => Math.random() - 0.5).map((char, id) => ({
                    id: id + '_' + char,
                    char: char,
                    used: false
                }));
                this.userAnswer = Array(this.currentWord.length).fill(null);
            },

            speak() {
                if ('speechSynthesis' in window) {
                    window.speechSynthesis.cancel();
                    const utterance = new SpeechSynthesisUtterance(this.currentWord.toLowerCase());
                    utterance.lang = 'en-US'; 
                    utterance.rate = 0.85;
                    utterance.pitch = 1.3;
                    if (this.selectedVoice) utterance.voice = this.selectedVoice;
                    window.speechSynthesis.speak(utterance);
                }
            },

            selectLetter(letterObj) {
                if (letterObj.used || this.isSuccess) return;
                const emptySlotIndex = this.userAnswer.findIndex(slot => slot === null);
                if (emptySlotIndex !== -1) {
                    this.userAnswer[emptySlotIndex] = letterObj;
                    letterObj.used = true;
                    this.userAnswer = [...this.userAnswer];
                    if (this.userAnswer.findIndex(slot => slot === null) === -1) this.checkAnswer();
                }
            },

            removeLetter(index) {
                if (this.isSuccess) return;
                const letterObj = this.userAnswer[index];
                if (letterObj) {
                    const originalLetter = this.scrambledLetters.find(l => l.id === letterObj.id);
                    if(originalLetter) originalLetter.used = false;
                    this.userAnswer[index] = null;
                    this.userAnswer = [...this.userAnswer];
                    this.isError = false;
                }
            },

            checkAnswer() {
                const answerStr = this.userAnswer.map(slot => slot.char).join('');
                if (answerStr === this.currentWord) {
                    this.isSuccess = true;
                    this.isError = false;
                    this.playBeep(800, 100);
                    setTimeout(() => this.playBeep(1200, 150), 150);
                    setTimeout(() => {
                        if (this.currentLevelIndex < this.words.length - 1) {
                            this.currentLevelIndex++;
                            this.loadLevel();
                            setTimeout(() => { this.speak(); }, 500);
                        } else {
                            alert("Selamat! Kamu telah menyelesaikan semua angka 1 sampai 10!");
                            this.currentLevelIndex = 0;
                            this.loadLevel();
                            setTimeout(() => { this.speak(); }, 500);
                        }
                    }, 2000);
                } else {
                    this.isError = true;
                    this.playBeep(200, 200); // error sound
                    setTimeout(() => {
                        this.isError = false;
                        // Reset answer
                        this.userAnswer.forEach(slot => {
                            if(slot) {
                                const originalLetter = this.scrambledLetters.find(l => l.id === slot.id);
                                if(originalLetter) originalLetter.used = false;
                            }
                        });
                        this.userAnswer = Array(this.currentWord.length).fill(null);
                    }, 800);
                }
            },
            
            playBeep(frequency, duration) {
                try {
                    const audioCtx = new (window.AudioContext || window.webkitAudioContext)();
                    const oscillator = audioCtx.createOscillator();
                    const gainNode = audioCtx.createGain();
                    
                    oscillator.type = 'sine';
                    oscillator.frequency.value = frequency;
                    
                    gainNode.gain.setValueAtTime(0.1, audioCtx.currentTime);
                    gainNode.gain.exponentialRampToValueAtTime(0.001, audioCtx.currentTime + duration/1000);
                    
                    oscillator.connect(gainNode);
                    gainNode.connect(audioCtx.destination);
                    
                    oscillator.start();
                    setTimeout(() => oscillator.stop(), duration);
                } catch(e) {
                    // Ignore if audio context not allowed
                }
            }
        }));
    });
</script>
@endpush
@endsection
