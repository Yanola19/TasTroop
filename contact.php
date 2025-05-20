<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Arial', sans-serif;
        }

        body {
            background-color: #b8e0f2;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            position: relative;
            overflow: hidden;
        }

        .background-elements {
            position: absolute;
            width: 100%;
            height: 100%;
            z-index: 0;
        }

        .circle {
            position: absolute;
            background-color: rgba(255, 255, 255, 0.4);
            border-radius: 50%;
        }

        .circle-1 {
            width: 40px;
            height: 40px;
            top: 25%;
            left: 15%;
        }

        .circle-2 {
            width: 30px;
            height: 30px;
            top: 50%;
            left: 20%;
        }

        .circle-3 {
            width: 25px;
            height: 25px;
            bottom: 25%;
            left: 25%;
        }

        .circle-4 {
            width: 35px;
            height: 35px;
            top: 20%;
            right: 20%;
        }

        .circle-5 {
            width: 45px;
            height: 45px;
            bottom: 30%;
            right: 15%;
        }

        .plus {
            position: absolute;
            color: rgba(255, 255, 255, 0.6);
            font-size: 40px;
            right: 25%;
            bottom: 40%;
        }

        .contact-container {
            width: 800px;
            max-width: 90%;
            background-color: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            position: relative;
            z-index: 1;
        }

        .header {
            background-color: #2b5783;
            padding: 15px 20px;
            display: flex;
            justify-content: flex-end;
        }

        .header-btn {
            width: 40px;
            height: 8px;
            background-color: #a0b4cc;
            margin-left: 15px;
            border-radius: 4px;
        }

        .contact-form {
            padding: 40px;
            display: flex;
        }

        .form-section {
            flex: 1;
            padding-right: 20px;
        }

        .form-title {
            font-size: 42px;
            color: #2b5783;
            font-weight: bold;
            margin-bottom: 30px;
        }

        .input-group {
            margin-bottom: 20px;
        }

        .form-input {
            width: 100%;
            padding: 15px;
            border-radius: 25px;
            border: none;
            background-color: #ecf4f9;
            font-size: 16px;
            color: #666;
        }

        .form-input::placeholder {
            color: #a0b4cc;
        }

        .form-textarea {
            width: 100%;
            padding: 15px;
            border-radius: 25px;
            border: none;
            background-color: #ecf4f9;
            font-size: 16px;
            height: 120px;
            resize: none;
            color: #666;
        }

        .form-textarea::placeholder {
            color: #a0b4cc;
        }

        .submit-btn {
            width: 100%;
            padding: 15px;
            border-radius: 25px;
            border: none;
            background-color: #00c2cb;
            color: white;
            font-size: 18px;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .submit-btn:hover {
            background-color: #00a9b1;
        }

        .illustration-section {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .illustration {
            width: 100%;
            max-width: 300px;
        }

        .footer {
            text-align: right;
            padding: 20px;
            color: white;
            font-size: 24px;
            font-weight: bold;
            font-style: italic;
        }

        .chat-icon-container {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 70px;
            height: 70px;
            background-color: white;
            border-radius: 50%;
            position: absolute;
            top: 300px;
            right: 280px;
            z-index: 2;
        }

        .chat-icon {
            color: #ffc107;
            font-size: 30px;
        }

        @media (max-width: 768px) {
            .contact-form {
                flex-direction: column;
            }
            .form-section {
                padding-right: 0;
                margin-bottom: 30px;
            }
            .chat-icon-container {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="background-elements">
        <div class="circle circle-1"></div>
        <div class="circle circle-2"></div>
        <div class="circle circle-3"></div>
        <div class="circle circle-4"></div>
        <div class="circle circle-5"></div>
        <div class="plus">+</div>
    </div>

    <div class="contact-container">
        <div class="header">
            <div class="header-btn"></div>
            <div class="header-btn"></div>
            <div class="header-btn"></div>
            <div class="header-btn"></div>
        </div>
        <div class="contact-form">
            <div class="form-section">
                <h1 class="form-title">Contact us</h1>
                <div class="input-group">
                    <input type="text" class="form-input" placeholder="Name">
                </div>
                <div class="input-group">
                    <input type="email" class="form-input" placeholder="Email">
                </div>
                <div class="input-group">
                    <textarea class="form-textarea" placeholder="Message"></textarea>
                </div>
                <a href="#" id="sendEmailBtn" class="submit-btn" style="text-align: center; text-decoration: none; display: inline-block;">Send Message</a>
            </div>
            <div class="illustration-section">
                <img src="asset/img/logo2.png" alt="Illustration" class="illustration">
            </div>
        </div>
    </div>

    <div class="chat-icon-container">
        <span class="chat-icon">💬</span>
    </div>

    <div class="footer">
        <span style="color: #b8e0f2;">MotoPress</span>
    </div>

    <script>
        // Add some simple animations
        document.addEventListener('DOMContentLoaded', function() {
            // Animate form inputs on focus
            const inputs = document.querySelectorAll('.form-input, .form-textarea');
            inputs.forEach(input => {
                input.addEventListener('focus', function() {
                    this.style.boxShadow = '0 0 0 3px rgba(0, 194, 203, 0.2)';
                });
                input.addEventListener('blur', function() {
                    this.style.boxShadow = 'none';
                });
            });

            // Animate submit button on hover
            const submitBtn = document.querySelector('.submit-btn');
            submitBtn.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-2px)';
                this.style.boxShadow = '0 5px 15px rgba(0, 194, 203, 0.3)';
            });
            submitBtn.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
                this.style.boxShadow = 'none';
            });

            // Add click effect to submit button
            const sendEmailBtn = document.getElementById('sendEmailBtn');
            sendEmailBtn.addEventListener('click', function(e) {
                e.preventDefault();
                
                const name = document.querySelector('input[placeholder="Name"]').value;
                const email = document.querySelector('input[placeholder="Email"]').value;
                const message = document.querySelector('textarea').value;

                if (name && email && message) {
                    const subject = encodeURIComponent("Contact from " + name);
                    const body = encodeURIComponent("From: " + name + " (" + email + ")\n\n" + message);
                    window.location.href = `mailto:202251230@std.umk.ac.id?subject=${subject}&body=${body}`;
                } else {
                    alert("Please fill all fields!");
                }
            });

            // Animate background elements
            const circles = document.querySelectorAll('.circle');
            circles.forEach(circle => {
                setInterval(() => {
                    const randomX = Math.random() * 10 - 5;
                    const randomY = Math.random() * 10 - 5;
                    circle.style.transform = `translate(${randomX}px, ${randomY}px)`;
                }, 3000);
            });
        });
    </script>
</body>
</html>