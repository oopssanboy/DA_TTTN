<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>500 - Mất Kết Nối | Chapter One</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        body {
            background-color: #050508;
            color: #fff;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            overflow: hidden;
            position: relative;
        }

        /* Lưới không gian ảo phía sau */
        .cyber-grid {
            position: absolute;
            top: 0; left: 0; width: 100vw; height: 100vh;
            background-image: 
                linear-gradient(rgba(0, 212, 255, 0.05) 1px, transparent 1px),
                linear-gradient(90deg, rgba(0, 212, 255, 0.05) 1px, transparent 1px);
            background-size: 50px 50px;
            z-index: 1;
            transition: background 0.1s ease;
        }

        .content-box {
            position: relative;
            z-index: 10;
            text-align: center;
        }

        /* Icon trôi nổi */
        .floating-icon {
            font-size: 4rem;
            color: #ff00c1;
            margin-bottom: 20px;
            text-shadow: 0 0 20px rgba(255, 0, 193, 0.5);
            animation: floatObj 3s ease-in-out infinite;
        }

        @keyframes floatObj {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-20px); }
        }

        /* HIỆU ỨNG CHỮ GLITCH (NHIỄU SÓNG) */
        .glitch-text {
            font-size: 12vw;
            font-weight: 900;
            line-height: 1;
            position: relative;
            text-shadow: 0 0 20px rgba(0, 212, 255, 0.8);
            letter-spacing: 10px;
            margin-bottom: 10px;
        }

        .glitch-text::before, .glitch-text::after {
            content: attr(data-text);
            position: absolute;
            top: 0; left: 0;
            width: 100%; height: 100%;
            background: #050508;
        }

        .glitch-text::before {
            left: 4px;
            text-shadow: -2px 0 #ff00c1;
            clip: rect(44px, 900px, 56px, 0);
            animation: glitch-anim 2s infinite linear alternate-reverse;
        }

        .glitch-text::after {
            left: -4px;
            text-shadow: -2px 0 #00fff9;
            clip: rect(44px, 900px, 56px, 0);
            animation: glitch-anim2 2.5s infinite linear alternate-reverse;
        }

        @keyframes glitch-anim {
            0% { clip: rect(10px, 9999px, 83px, 0); }
            20% { clip: rect(62px, 9999px, 14px, 0); }
            40% { clip: rect(31px, 9999px, 92px, 0); }
            60% { clip: rect(78px, 9999px, 24px, 0); }
            80% { clip: rect(12px, 9999px, 55px, 0); }
            100% { clip: rect(45px, 9999px, 33px, 0); }
        }

        @keyframes glitch-anim2 {
            0% { clip: rect(21px, 9999px, 91px, 0); }
            20% { clip: rect(55px, 9999px, 34px, 0); }
            40% { clip: rect(12px, 9999px, 62px, 0); }
            60% { clip: rect(81px, 9999px, 41px, 0); }
            80% { clip: rect(37px, 9999px, 73px, 0); }
            100% { clip: rect(9px, 9999px, 22px, 0); }
        }

        .sub-text {
            font-size: 1.2rem;
            color: #a0aabf;
            margin-bottom: 40px;
            letter-spacing: 3px;
            text-transform: uppercase;
        }

        /* Nút quay về giao diện Neon */
        .btn-neon {
            display: inline-block;
            padding: 15px 40px;
            background: transparent;
            color: #00d4ff;
            text-decoration: none;
            font-size: 1.1rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 2px;
            border: 2px solid #00d4ff;
            border-radius: 4px;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            box-shadow: 0 0 10px rgba(0, 212, 255, 0.2), inset 0 0 10px rgba(0, 212, 255, 0.2);
        }

        .btn-neon:hover {
            background: #00d4ff;
            color: #050508;
            box-shadow: 0 0 30px rgba(0, 212, 255, 0.8), inset 0 0 20px rgba(0, 212, 255, 0.8);
            transform: scale(1.05);
        }
    </style>
</head>
<body>

    <div class="cyber-grid" id="bg-grid"></div>

    <div class="content-box">
        <div class="floating-icon">
            <i class="fa-solid fa-user-astronaut"></i>
        </div>
        
        <h1 class="glitch-text" data-text="500">500</h1>
        
        <p class="sub-text">Chương sách này không tồn tại trong hệ thống</p>
        
        <a href="/" class="btn-neon"><i class="fa-solid fa-house-chimney"></i> Quay về Trang Chủ</a>
    </div>

    
</body>
</html>