<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log In &lsaquo; WordPress</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        body { background-color: #f1f1f1; color: #3c434a; font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen-Sans, Ubuntu, Cantarell, "Helvetica Neue", sans-serif; }
        .login-box { width: 320px; margin: 6% auto; }
        .wp-logo { width: 84px; height: 84px; margin: 0 auto 25px; display: block; background-image: url('https://s.w.org/style/images/about/WordPress-logotype-wmark.png'); background-size: contain; background-repeat: no-repeat; opacity: 0.8;}
        .input-wp { border: 1px solid #8c8f94; border-radius: 4px; padding: 0 8px; line-height: 2; min-height: 40px; box-shadow: 0 0 0 transparent; transition: box-shadow .1s linear; }
        .input-wp:focus { border-color: #2271b1; box-shadow: 0 0 0 1px #2271b1; outline: none; }
        .btn-wp { background: #2271b1; color: #fff; border-color: #2271b1; border-radius: 3px; padding: 0 10px 1px; min-height: 32px; font-size: 13px; font-weight: 600; cursor: pointer; transition: all 0.2s;}
        .btn-wp:hover:not(:disabled) { background: #135e96; border-color: #135e96; }
        .btn-wp:disabled { background: #7ba8cc; cursor: not-allowed; border-color: #7ba8cc; }
    </style>
</head>
<body class="login">

    <div class="login-box">
        <a href="#" class="wp-logo" title="Powered by WordPress"></a>

        <div id="login_error" class="hidden bg-white border-l-4 border-red-500 shadow-sm p-3 mb-5 text-[14px]">
            <strong>Error:</strong> The username or password you entered is incorrect. <a href="#" class="text-blue-600 hover:underline">Lost your password?</a>
        </div>

        <form id="fake-wp-form" class="bg-white border border-[#c3c4c7] shadow-[0_1px_3px_rgba(0,0,0,0.04)] p-6 mb-6">
            <div class="mb-4">
                <label for="user_login" class="block mb-2 text-[14px]">Username or Email Address</label>
                <input type="text" name="log" id="user_login" class="input-wp w-full text-[18px]" value="" size="20" autocapitalize="off" autocomplete="username" required="required" autofocus>
            </div>

            <div class="mb-5">
                <div class="flex justify-between items-center mb-2">
                    <label for="user_pass" class="block text-[14px]">Password</label>
                </div>
                <input type="password" name="pwd" id="user_pass" class="input-wp w-full text-[18px]" value="" size="20" autocomplete="current-password" required="required">
            </div>

            <div class="flex justify-between items-center">
                <label class="text-[12px] flex items-center gap-1"><input type="checkbox" name="rememberme" value="forever" class="border-[#8c8f94] rounded-[3px]"> Remember Me</label>
                <button type="submit" id="submit-btn" class="btn-wp shadow-sm">Log In</button>
            </div>
        </form>

        <p class="text-[13px] text-center mb-2"><a href="#" class="text-[#2271b1] hover:text-[#0a4b78] hover:underline">Lost your password?</a></p>
        <p class="text-[13px] text-center"><a href="#" class="text-[#2271b1] hover:text-[#0a4b78] hover:underline">&larr; Go to SHIELD-AI System</a></p>
    </div>

<script>
    document.getElementById('fake-wp-form').addEventListener('submit', function(e) {
        e.preventDefault(); 

        // 🛡️ BƯỚC 1: ANTI-FLOOD (Vô hiệu hóa nút bấm ngay lập tức)
        const submitBtn = document.getElementById('submit-btn');
        if(submitBtn) {
            submitBtn.disabled = true;
            submitBtn.innerText = "Authenticating...";
        }

        // 2. Thu thập dữ liệu cực chuẩn (Bỏ gói JSON, dùng FormData gốc)
        let user = document.getElementById('user_login').value;
        let pass = document.getElementById('user_pass').value;

        let formData = new FormData();
        formData.append('username_attempt', user);
        formData.append('password_attempt', pass);
        formData.append('attack_path', window.location.pathname);
        
        formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));

        console.log("SHIELD-AI Tracking: Target logged payload.");

        // 3. Gửi đạn thẳng về Server (Bắn thẳng FormData, Laravel nhận 100%)
        fetch('/honeypot-catch', {
            method: 'POST',
            body: formData // Gửi trực tiếp, không cần headers lằng nhằng
        })
        .then(response => {
            // Khôi phục nút bấm sau 1.5 giây
            setTimeout(() => {
                if(submitBtn) {
                    submitBtn.disabled = false;
                    submitBtn.innerText = "Log In";
                }
            }, 1500);

            // 🎯 ĐÒN QUYẾT ĐỊNH: Nếu Server trả về 403 (Sếp đang bật AUTO-BLOCK)
            if (response.status === 403) {
                triggerDeathScreen(); 
                return;
            }

            // Nếu đang chế độ MANUAL, tiếp tục diễn kịch báo sai pass
            showFakeError();
        })
        .catch(error => {
            console.error("SHIELD-AI Uplink Error:", error);
            if(submitBtn) {
                submitBtn.disabled = false;
                submitBtn.innerText = "Log In";
            }
        });
    });

    // Hàm diễn kịch báo lỗi WordPress thông thường
    function showFakeError() {
        const errorDiv = document.getElementById('login_error');
        if(errorDiv) errorDiv.classList.remove('hidden');
        
        const passInput = document.getElementById('user_pass');
        passInput.value = '';
        passInput.focus();

        // Hiệu ứng rung lắc form y hệt WP thật
        const formBox = document.getElementById('fake-wp-form');
        formBox.animate([
            { transform: 'translateX(0)' },
            { transform: 'translateX(-5px)' },
            { transform: 'translateX(5px)' },
            { transform: 'translateX(0)' }
        ], { duration: 300 });
    }

    // 💀 HÀM TỬ THẦN: Khóa cứng trình duyệt hacker
    function triggerDeathScreen() {
        document.body.style.backgroundColor = "black";
        document.body.style.overflow = "hidden";
        document.body.innerHTML = `
            <div style="
                background: black; 
                color: #ff0000; 
                height: 100vh; 
                width: 100vw; 
                position: fixed; 
                top: 0; left: 0; 
                display: flex; flex-direction: column; align-items: center; justify-content: center; 
                font-family: 'Courier New', monospace; text-align: center;
                z-index: 999999; text-transform: uppercase; letter-spacing: 2px;
            ">
                <h1 style="font-size: 50px; margin-bottom: 20px; text-shadow: 0 0 20px red; animation: blink 1s infinite;">[!] CONNECTION TERMINATED [!]</h1>
                <div style="border: 1px solid red; padding: 20px; background: rgba(255,0,0,0.1); box-shadow: inset 0 0 20px rgba(255,0,0,0.2);">
                    <p style="font-size: 18px;">SHIELD-AI System Breach Detected from IP: ${window.location.hostname}</p>
                    <p style="font-size: 24px; font-weight: bold; margin: 20px 0;">YOUR IP HAS BEEN PERMANENTLY BLACKLISTED</p>
                    <p style="color: #666;">Security Protocol Q3T-MLSFS Activated.<br>All local data has been captured for legal evidence.</p>
                </div>
                <p style="margin-top: 50px; font-size: 12px; color: #444;">SHIELD-AI Neural Link // Unauthorized access is a federal crime.</p>
            </div>
            <style>@keyframes blink { 0%, 100% { opacity: 1; } 50% { opacity: 0.5; } }</style>
        `;
        
        window.addEventListener('contextmenu', e => e.preventDefault());
        document.onkeydown = function(e) {
            if(e.keyCode == 123 || (e.ctrlKey && e.shiftKey && (e.keyCode == 73 || e.keyCode == 74)) || (e.ctrlKey && e.keyCode == 85)) return false; 
        }
    }
</script>
</body>
</html>