<?php 
include 'db.php';

// Agar user pehle se login hai toh seedha dashboard bhejo
if(isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$error = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    if (isset($_POST['signup_mode'])) {
        // Registration Logic
        $fullname = $_POST['fullname'];
        $hashed_pass = password_hash($password, PASSWORD_DEFAULT);
        
        $check = $conn->query("SELECT id FROM users WHERE email='$email'");
        if($check->num_rows > 0) {
            $error = "Email already exists!";
        } else {
            $sql = "INSERT INTO users (fullname, email, password) VALUES ('$fullname', '$email', '$hashed_pass')";
            if ($conn->query($sql)) {
                echo "<script>alert('Registration Successful! Please Sign In.'); window.location='auth.php';</script>";
            }
        }
    } else {
        // Login Logic
        $result = $conn->query("SELECT * FROM users WHERE email='$email'");
        if ($user = $result->fetch_assoc()) {
            if (password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['fullname'];
                header("Location: index.php");
                exit();
            } else { $error = "Invalid Password!"; }
        } else { $error = "User not found!"; }
    }
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <title>Finance Hub | Secure Access</title>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
  
  <style>
    :root {
        --primary: #7c3aed; /* Deep Violet */
        --secondary: #06b6d4; /* Cyan */
        --bg-dark: #020617;
        --card-bg: rgba(15, 23, 42, 0.6);
        --border-color: rgba(255, 255, 255, 0.08);
        --text-color: #f1f5f9;
        --muted-color: #94a3b8;
    }

    * { box-sizing: border-box; margin: 0; padding: 0; }

    body {
        font-family: 'Plus Jakarta Sans', sans-serif;
        background-color: var(--bg-dark);
        color: var(--text-color);
        height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        /* Dynamic Background fallback */
        background-image: radial-gradient(at 0% 0%, rgba(124, 58, 237, 0.15) 0px, transparent 50%),
                          radial-gradient(at 100% 100%, rgba(6, 182, 212, 0.15) 0px, transparent 50%);
    }

    #three-canvas { position: fixed; top: 0; left: 0; z-index: -1; opacity: 0.6; }

    /* --- SPOTLIGHT CARD EFFECT --- */
    .glass-card {
        position: relative;
        background: var(--card-bg);
        backdrop-filter: blur(24px);
        -webkit-backdrop-filter: blur(24px);
        border: 1px solid var(--border-color);
        border-radius: 24px;
        display: grid;
        grid-template-columns: 1fr 1.2fr;
        width: 900px;
        max-width: 95%;
        overflow: hidden;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
    }

    /* The moving glow element */
    .glass-card::before {
        content: "";
        position: absolute;
        height: 100%;
        width: 100%;
        top: 0;
        left: 0;
        border-radius: inherit;
        background: radial-gradient(
            800px circle at var(--mouse-x) var(--mouse-y),
            rgba(255, 255, 255, 0.06),
            transparent 40%
        );
        z-index: 2;
        pointer-events: none; /* Mouse clicks pass through */
        opacity: 0;
        transition: opacity 0.5s;
    }

    .glass-card:hover::before {
        opacity: 1;
    }

    /* Content Styling */
    .brand-section {
        padding: 60px;
        background: linear-gradient(135deg, rgba(124, 58, 237, 0.1), rgba(6, 182, 212, 0.05));
        border-right: 1px solid var(--border-color);
        position: relative;
        z-index: 3;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .logo-box {
        width: 50px;
        height: 50px;
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 800;
        font-size: 20px;
        margin-bottom: 25px;
        box-shadow: 0 0 20px rgba(124, 58, 237, 0.5);
    }

    .brand-section h1 {
        font-size: 42px;
        line-height: 1.1;
        letter-spacing: -1px;
        background: linear-gradient(to right, #fff, #94a3b8);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .form-section {
        padding: 60px;
        display: flex;
        flex-direction: column;
        /* INCREASED GAP FOR BETTER SPACING */
        gap: 32px; 
        position: relative;
        z-index: 3;
    }

    /* Tabs */
    .tab-nav {
        background: rgba(0, 0, 0, 0.3);
        padding: 4px;
        border-radius: 12px;
        display: flex;
        margin-bottom: 15px; /* Added margin below tabs */
    }

    .tab-btn {
        flex: 1;
        padding: 10px;
        border-radius: 8px;
        border: none;
        background: transparent;
        color: var(--muted-color);
        cursor: pointer;
        font-weight: 600;
        font-size: 14px;
        transition: all 0.3s ease;
    }

    .tab-btn.active {
        background: rgba(255, 255, 255, 0.1);
        color: #fff;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    }

    /* Inputs Wrapper to create space */
    .input-wrapper { 
        position: relative; 
        margin-bottom: 5px; 
    }
    
    input {
        width: 100%;
        /* INCREASED PADDING FOR AIRY FEEL */
        padding: 18px 22px; 
        background: rgba(255, 255, 255, 0.03);
        border: 1px solid var(--border-color);
        border-radius: 12px;
        color: #fff;
        font-size: 15px;
        transition: all 0.3s ease;
    }

    input:focus {
        outline: none;
        border-color: var(--primary);
        background: rgba(124, 58, 237, 0.05);
        box-shadow: 0 0 0 4px rgba(124, 58, 237, 0.1);
    }

    /* Button */
    .action-btn {
        padding: 18px; /* Bigger button */
        border-radius: 12px;
        border: none;
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        color: white;
        font-weight: 700;
        font-size: 16px;
        cursor: pointer;
        margin-top: 20px; /* More space above button */
        transition: transform 0.2s, box-shadow 0.2s;
        box-shadow: 0 10px 15px -3px rgba(124, 58, 237, 0.3);
    }

    .action-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 20px 25px -5px rgba(124, 58, 237, 0.4);
    }

    .action-btn:active { transform: scale(0.98); }

    /* Mobile */
    @media (max-width: 800px) {
        .glass-card { grid-template-columns: 1fr; width: 100%; height: 100vh; border-radius: 0; border: none; }
        .brand-section { display: none; }
        .form-section { justify-content: center; padding: 30px; gap: 25px; }
    }
  </style>
</head>
<body>
  
  <canvas id="three-canvas"></canvas>

  <div class="glass-card" id="card">
    <aside class="brand-section">
        <div class="logo-box">FH</div>
        <h1>Future<br>of Finance<br>is Here.</h1>
        <p style="color: var(--muted-color); margin-top: 20px; font-size: 15px; line-height: 1.6;">
            Experience real-time asset tracking with industry-grade security.
        </p>
    </aside>

    <section class="form-section">
        <div class="tab-nav">
            <button class="tab-btn active" onclick="switchMode('login')">Sign In</button>
            <button class="tab-btn" onclick="switchMode('signup')">Create Account</button>
        </div>

        <div>
            <h2 id="auth-title" style="font-size: 24px; font-weight: 700;">Welcome Back</h2>
            <p style="color: var(--muted-color); font-size: 14px; margin-top: 5px;">Enter your credentials to access your vault.</p>
        </div>

        <?php if($error) echo "<div style='background:rgba(239,68,68,0.1); color:#f87171; padding:12px; border-radius:8px; font-size:13px; border:1px solid rgba(239,68,68,0.2);'>$error</div>"; ?>

        <form id="authForm" method="POST" action="auth.php" style="display: flex; flex-direction: column; gap: 20px;">
            <input type="hidden" name="form_type" id="form_type" value="login">
            
            <div class="input-wrapper" id="name-field" style="display: none;">
                <input type="text" name="fullname" placeholder="Full Name">
            </div>
            
            <div class="input-wrapper">
                <input type="email" name="email" required placeholder="name@example.com">
            </div>
            
            <div class="input-wrapper">
                <input type="password" name="password" required placeholder="Password">
            </div>
            
            <button type="submit" class="action-btn" id="submit-btn">Sign In to Dashboard</button>
        </form>
    </section>
  </div>

  <script>
    // --- SPOTLIGHT CURSOR LOGIC ---
    const card = document.getElementById('card');

    document.addEventListener('mousemove', (e) => {
        const rect = card.getBoundingClientRect();
        const x = e.clientX - rect.left;
        const y = e.clientY - rect.top;

        card.style.setProperty('--mouse-x', `${x}px`);
        card.style.setProperty('--mouse-y', `${y}px`);
    });

    // --- FORM SWITCH LOGIC ---
    function switchMode(mode) {
        const title = document.getElementById('auth-title');
        const nameField = document.getElementById('name-field');
        const submitBtn = document.getElementById('submit-btn');
        const tabs = document.querySelectorAll('.tab-btn');
        
        tabs.forEach(t => t.classList.remove('active'));
        event.target.classList.add('active');

        if (mode === 'signup') {
            title.innerText = "Join Finance Hub";
            submitBtn.innerText = "Create Free Account";
            submitBtn.name = "signup_mode";
            
            // Animation for field
            nameField.style.display = "block";
            nameField.style.opacity = "0";
            setTimeout(() => nameField.style.opacity = "1", 50);
        } else {
            title.innerText = "Welcome Back";
            submitBtn.innerText = "Sign In to Dashboard";
            submitBtn.name = "login_mode";
            nameField.style.display = "none";
        }
    }

    // --- THREE.JS BACKGROUND (Simple Starfield) ---
    const canvas = document.getElementById('three-canvas');
    const scene = new THREE.Scene();
    const camera = new THREE.PerspectiveCamera(75, window.innerWidth / window.innerHeight, 0.1, 1000);
    const renderer = new THREE.WebGLRenderer({ canvas: canvas, alpha: true });
    
    renderer.setSize(window.innerWidth, window.innerHeight);
    renderer.setPixelRatio(window.devicePixelRatio);

    // Particles
    const geometry = new THREE.BufferGeometry();
    const particlesCount = 700;
    const posArray = new Float32Array(particlesCount * 3);

    for(let i = 0; i < particlesCount * 3; i++) {
        posArray[i] = (Math.random() - 0.5) * 15;
    }

    geometry.setAttribute('position', new THREE.BufferAttribute(posArray, 3));
    const material = new THREE.PointsMaterial({
        size: 0.02,
        color: 0x7c3aed, // Violet particles
        transparent: true,
        opacity: 0.8
    });

    const particlesMesh = new THREE.Points(geometry, material);
    scene.add(particlesMesh);
    camera.position.z = 3;

    // Animation
    document.addEventListener('mousemove', (event) => {
        particlesMesh.rotation.y = event.clientX * 0.0001;
        particlesMesh.rotation.x = event.clientY * 0.0001;
    });

    function animate() {
        requestAnimationFrame(animate);
        particlesMesh.rotation.y += 0.0005;
        renderer.render(scene, camera);
    }
    animate();

    // Resize handler
    window.addEventListener('resize', () => {
        camera.aspect = window.innerWidth / window.innerHeight;
        camera.updateProjectionMatrix();
        renderer.setSize(window.innerWidth, window.innerHeight);
    });
  </script>
</body>
</html>