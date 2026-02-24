<?php 
session_start();
?>
<!DOCTYPE html>
<html lang="en" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Terms of Service - Finance Hub Pro</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --accent: #7c3aed;
            --accent-2: #06b6d4;
            --bg: #020617;
            --surface: #0f172a;
            --text: #f1f5f9;
            --muted: #94a3b8;
            --line: rgba(255,255,255,.05);
            --radius: 24px;
        }

        [data-theme="light"] {
            --bg: #f8fafc;
            --surface: #ffffff;
            --text: #0f172a;
            --muted: #64748b;
            --line: rgba(0,0,0,.05);
        }

        body { 
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--bg);
            color: var(--text);
            background-image: radial-gradient(at 0% 100%, rgba(6, 182, 212, 0.05) 0, transparent 50%), 
                              radial-gradient(at 100% 0%, rgba(124, 58, 237, 0.05) 0, transparent 50%);
        }

        .glass-card {
            background: var(--surface);
            backdrop-filter: blur(12px);
            border: 1px solid var(--line);
            border-radius: var(--radius);
        }

        .gradient-text {
            background: linear-gradient(135deg, var(--accent), var(--accent-2));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
    </style>
</head>
<body class="min-h-screen pb-12">

    <nav class="sticky top-0 z-50 px-6 py-4 glass-card m-4 flex justify-between items-center shadow-lg">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-[#7c3aed] to-[#06b6d4] flex items-center justify-center text-white font-bold text-xl shadow-lg shadow-purple-500/20">FH</div>
            <span class="font-extrabold text-xl tracking-tight text-white">FinanceHub<span class="text-[#7c3aed]">.</span></span>
        </div>
        <a href="index.php" class="text-sm font-bold px-5 py-2.5 rounded-xl border border-white/10 hover:bg-white/5 transition-all text-white">Back to Home</a>
    </nav>

    <main class="max-w-4xl mx-auto px-6 mt-12">
        <div class="glass-card p-8 md:p-12 shadow-2xl">
            <h1 class="text-4xl md:text-5xl font-extrabold mb-4 gradient-text">Terms of Service</h1>
            <p class="text-sm text-gray-400 mb-10 font-medium tracking-wide">EFFECTIVE DATE: <?php echo date('d M, Y'); ?></p>

            <div class="space-y-10 text-lg leading-relaxed opacity-90">
                
                <section>
                    <h2 class="text-2xl font-bold mb-4 flex items-center gap-3 text-white">
                        <div class="w-2 h-8 bg-gradient-to-b from-[#7c3aed] to-transparent rounded-full"></div>
                        1. Acceptance of Terms
                    </h2>
                    <p>Finance Hub Pro use karke aap hamari Terms of Service aur Privacy Policy se sehmat hote hain. Agar aap in terms se sehmat nahi hain, toh please hamari application use na karein.</p>
                </section>

                <section>
                    <h2 class="text-2xl font-bold mb-4 flex items-center gap-3 text-white">
                        <div class="w-2 h-8 bg-gradient-to-b from-[#06b6d4] to-transparent rounded-full"></div>
                        2. User Responsibilities
                    </h2>
                    <p class="mb-4">Finance Hub Pro par aap jo bhi data enter karte hain (Income, Expenses, Descriptions), uski zimmedari poori tarah aapki hai. Aap agree karte hain ki:</p>
                    <ul class="list-none space-y-3 pl-2">
                        <li class="flex gap-3"><span class="text-[#7c3aed]">✔</span> Aap galat ya misleading information enter nahi karenge.</li>
                        <li class="flex gap-3"><span class="text-[#7c3aed]">✔</span> Aap apna account credentials (email/password) secure rakhenge.</li>
                        <li class="flex gap-3"><span class="text-[#7c3aed]">✔</span> Aap system ko kisi bhi illegal financial activity ke liye use nahi karenge.</li>
                    </ul>
                </section>

                <section>
                    <h2 class="text-2xl font-bold mb-4 flex items-center gap-3 text-white">
                        <div class="w-2 h-8 bg-gradient-to-b from-purple-500 to-transparent rounded-full"></div>
                        3. Privacy & Data Protection
                    </h2>
                    <p>Hamara system aapka data sirf aapke financial analysis ke liye use karta hai. Hum aapka data bechte nahi hain. Adhik jankari ke liye hamari <a href="privacy.php" class="text-[#06b6d4] underline hover:text-[#7c3aed]">Privacy Policy</a> dekhein.</p>
                </section>

                <section class="p-8 rounded-3xl bg-white/5 border border-white/10 relative overflow-hidden">
                    <div class="absolute -right-4 -top-4 w-24 h-24 bg-[#7c3aed] opacity-10 blur-3xl"></div>
                    <h2 class="text-2xl font-bold mb-3 text-white">4. No Financial Advice</h2>
                    <p class="text-base text-gray-300 italic">"Finance Hub Pro ek tracking tool hai, koi financial advisor nahi."</p>
                    <p class="mt-2 text-base">Is app mein dikhaye gaye charts aur analytics sirf aapki history par based hain. Koi bhi bada investment ya financial decision lene se pehle expert se salaah lein.</p>
                </section>

                <section>
                    <h2 class="text-2xl font-bold mb-4 flex items-center gap-3 text-white">
                        <div class="w-2 h-8 bg-gradient-to-b from-red-500 to-transparent rounded-full"></div>
                        5. Termination
                    </h2>
                    <p>Hum kisi bhi waqt bina notice diye aapka access terminate kar sakte hain agar aap hamari terms break karte hain. Aap apna saara data "Clear All" feature ke zariye khud delete kar sakte hain.</p>
                </section>

                <section>
                    <h2 class="text-2xl font-bold mb-4 flex items-center gap-3 text-white">
                        <div class="w-2 h-8 bg-gradient-to-b from-yellow-500 to-transparent rounded-full"></div>
                        6. Changes to Terms
                    </h2>
                    <p>Hum in terms ko samay-samay par update kar sakte hain. Updates ke liye is page ko check karte rahein.</p>
                </section>

            </div>
        </div>
    </main>

    <footer class="text-center mt-12 py-8 opacity-40 text-sm font-semibold tracking-widest uppercase">
        Finance Hub Pro &bull; Built for Professionals
    </footer>

</body>
</html>