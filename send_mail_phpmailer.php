<?php
// Load PHPMailer MANUALLY (without Composer)
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

// Include files directly - ADJUST PATH IF NEEDED!
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

header('Content-Type: application/json');

$to_email = "arittrasingh.12@gmail.com";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $name = filter_var($_POST['name'] ?? '', FILTER_SANITIZE_STRING);
    $email = filter_var($_POST['email'] ?? '', FILTER_SANITIZE_EMAIL);
    $subject = filter_var($_POST['subject'] ?? '', FILTER_SANITIZE_STRING);
    $message = filter_var($_POST['message'] ?? '', FILTER_SANITIZE_STRING);
    
    // Validate...
    $errors = [];
    if (empty($name)) $errors[] = "Name is required";
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Valid email is required";
    if (empty($subject)) $errors[] = "Subject is required";
    if (empty($message)) $errors[] = "Message is required";
    
    if (!empty($errors)) {
        echo json_encode(['success' => false, 'message' => implode(", ", $errors)]);
        exit;
    }
    
    $mail = new PHPMailer(true);
    
    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';     // Gmail SMTP server
        $mail->SMTPAuth   = true;
        $mail->Username   = 'arittrasingh.12@gmail.com';  // Your Gmail
        $mail->Password   = 'czeq hpuf uwdg hihw';        // Your Gmail App Password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;
        
        // Recipients
        $mail->setFrom($email, $name);
        $mail->addAddress($to_email, 'Arittra Singh');
        $mail->addReplyTo($email, $name);
        
        // Content
        $mail->isHTML(true);
        $mail->Subject = "Portfolio Contact: $subject";
        
        // Email body with Font Awesome icons and complete template
        $mail->Body = '
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
            <style>
                body {
                    font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
                    line-height: 1.6;
                    color: #333;
                    margin: 0;
                    padding: 0;
                    background-color: #f4f4f4;
                }
                .email-container {
                    max-width: 600px;
                    margin: 20px auto;
                    background: white;
                    border-radius: 15px;
                    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
                    overflow: hidden;
                }
                .header {
                    background: linear-gradient(135deg, #2563eb 0%, #1e40af 100%);
                    color: white;
                    padding: 30px;
                    text-align: center;
                }
                .header h1 {
                    margin: 0;
                    font-size: 28px;
                }
                .header i {
                    margin-right: 10px;
                }
                .content {
                    padding: 30px;
                }
                .info-box {
                    background: #f8f9fa;
                    border-radius: 10px;
                    padding: 20px;
                    margin-bottom: 25px;
                    border-left: 4px solid #2563eb;
                }
                .info-item {
                    margin-bottom: 12px;
                    display: flex;
                    align-items: center;
                }
                .info-item i {
                    width: 25px;
                    color: #2563eb;
                    font-size: 18px;
                    margin-right: 10px;
                }
                .message-box {
                    background: #fff8e7;
                    border-radius: 10px;
                    padding: 20px;
                    margin-bottom: 25px;
                    border-left: 4px solid #ff9800;
                }
                .message-box i {
                    color: #ff9800;
                    margin-right: 10px;
                }
                .tech-section {
                    background: linear-gradient(135deg, #2563eb15 0%, #1e40af15 100%);
                    border-radius: 10px;
                    padding: 25px;
                    margin-bottom: 25px;
                }
                .tech-section h3 {
                    margin-top: 0;
                    color: #1e40af;
                    display: flex;
                    align-items: center;
                }
                .tech-section h3 i {
                    margin-right: 10px;
                    color: #2563eb;
                }
                .tech-grid {
                    display: flex;
                    flex-wrap: wrap;
                    gap: 12px;
                    margin-top: 20px;
                }
                .tech-item {
                    background: white;
                    padding: 10px 20px;
                    border-radius: 30px;
                    display: inline-flex;
                    align-items: center;
                    box-shadow: 0 2px 5px rgba(0,0,0,0.05);
                    border: 1px solid #e0e7ff;
                    transition: all 0.3s ease;
                }
                .tech-item i {
                    margin-right: 8px;
                    font-size: 18px;
                }
                /* Technology icon colors */
                .fa-php { color: #777bb3; }
                .fa-js { color: #f7df1e; }
                .fa-html5 { color: #e34f26; }
                .fa-css3-alt { color: #264de4; }
                .fa-react { color: #61dafb; }
                .fa-node-js { color: #68a063; }
                .fa-python { color: #3776ab; }
                .fa-laravel { color: #ff2d20; }
                .fa-git-alt { color: #f34f29; }
                .fa-database { color: #00758f; }
                .fa-cloud { color: #ff9900; }
                .fa-docker { color: #2496ed; }
                .fa-java { color: #007396; }
                .fa-vuejs { color: #4fc08d; }
                .fa-angular { color: #dd1b16; }
                .fa-figma { color: #f24e1e; }
                .fa-wordpress { color: #21759b; }
                .fa-aws { color: #ff9900; }
                .fa-terminal { color: #4d4d4d; }
                .footer {
                    text-align: center;
                    padding: 20px;
                    background: #f8f9fa;
                    color: #666;
                    font-size: 14px;
                    border-top: 1px solid #eee;
                }
                .footer i {
                    color: #2563eb;
                    margin: 0 5px;
                }
                hr {
                    border: none;
                    border-top: 1px solid #eee;
                    margin: 25px 0;
                }
                .social-links {
                    display: flex;
                    justify-content: center;
                    gap: 15px;
                    margin-top: 20px;
                }
                .social-links a {
                    display: inline-flex;
                    align-items: center;
                    justify-content: center;
                    width: 35px;
                    height: 35px;
                    background: #2563eb;
                    color: white;
                    border-radius: 50%;
                    text-decoration: none;
                    transition: transform 0.3s ease;
                }
                .social-links a:hover {
                    transform: translateY(-3px);
                }
            </style>
        </head>
        <body>
            <div class="email-container">
                <div class="header">
                    <h1><i class="fas fa-paper-plane"></i> New Portfolio Message</h1>
                    <p style="margin: 10px 0 0; opacity: 0.9;">You have received a new contact request</p>
                </div>
                
                <div class="content">
                    <div class="info-box">
                        <h3 style="margin-top: 0; color: #2563eb; display: flex; align-items: center;">
                            <i class="fas fa-address-card"></i> Sender Information
                        </h3>
                        <div class="info-item">
                            <i class="fas fa-user"></i>
                            <strong style="min-width: 80px;">Name:</strong>
                            <span>' . htmlspecialchars($name) . '</span>
                        </div>
                        <div class="info-item">
                            <i class="fas fa-envelope"></i>
                            <strong style="min-width: 80px;">Email:</strong>
                            <span><a href="mailto:' . htmlspecialchars($email) . '" style="color: #2563eb; text-decoration: none;">' . htmlspecialchars($email) . '</a></span>
                        </div>
                        <div class="info-item">
                            <i class="fas fa-tag"></i>
                            <strong style="min-width: 80px;">Subject:</strong>
                            <span>' . htmlspecialchars($subject) . '</span>
                        </div>
                    </div>
                    
                    <div class="message-box">
                        <h3 style="margin-top: 0; color: #ff9800; display: flex; align-items: center;">
                            <i class="fas fa-comment-dots"></i> Message Content
                        </h3>
                        <div style="background: white; padding: 15px; border-radius: 8px; margin-top: 10px;">
                            <p style="margin: 0; font-size: 16px; line-height: 1.8;">' . nl2br(htmlspecialchars($message)) . '</p>
                        </div>
                    </div>
                    
                    <div class="tech-section">
                        <h3>
                            <i class="fas fa-laptop-code"></i> Technologies I Work With
                        </h3>
                        <p style="color: #666; margin-bottom: 15px;">Here are some of the technologies in my stack:</p>
                        <div class="tech-grid">
                            <!-- Frontend -->
                            <span class="tech-item"><i class="fab fa-html5"></i> HTML5</span>
                            <span class="tech-item"><i class="fab fa-css3-alt"></i> CSS3</span>
                            <span class="tech-item"><i class="fab fa-js"></i> JavaScript</span>
                            <span class="tech-item"><i class="fab fa-react"></i> React</span>
                            <span class="tech-item"><i class="fab fa-vuejs"></i> Vue.js</span>
                            <span class="tech-item"><i class="fab fa-angular"></i> Angular</span>
                            
                            <!-- Backend -->
                            <span class="tech-item"><i class="fab fa-php"></i> PHP</span>
                            <span class="tech-item"><i class="fab fa-node-js"></i> Node.js</span>
                            <span class="tech-item"><i class="fab fa-python"></i> Python</span>
                            <span class="tech-item"><i class="fab fa-laravel"></i> Laravel</span>
                            <span class="tech-item"><i class="fab fa-java"></i> Java</span>
                            
                            <!-- Database -->
                            <span class="tech-item"><i class="fas fa-database"></i> MySQL</span>
                            <span class="tech-item"><i class="fas fa-database"></i> MongoDB</span>
                            <span class="tech-item"><i class="fas fa-database"></i> PostgreSQL</span>
                            
                            <!-- Tools & Cloud -->
                            <span class="tech-item"><i class="fab fa-git-alt"></i> Git</span>
                            <span class="tech-item"><i class="fab fa-docker"></i> Docker</span>
                            <span class="tech-item"><i class="fas fa-cloud"></i> AWS</span>
                            <span class="tech-item"><i class="fab fa-wordpress"></i> WordPress</span>
                            <span class="tech-item"><i class="fab fa-figma"></i> Figma</span>
                        </div>
                        
                        <hr>
                        
                        <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap;">
                            <div style="display: flex; align-items: center;">
                                <i class="fas fa-code-branch" style="color: #2563eb; margin-right: 8px;"></i>
                                <span style="color: #666;">Full Stack Developer</span>
                            </div>
                            <div style="display: flex; align-items: center;">
                                <i class="fas fa-tools" style="color: #2563eb; margin-right: 8px;"></i>
                                <span style="color: #666;">Available for work</span>
                            </div>
                            <div style="display: flex; align-items: center;">
                                <i class="fas fa-rocket" style="color: #2563eb; margin-right: 8px;"></i>
                                <span style="color: #666;">Always learning</span>
                            </div>
                        </div>
                    </div>
                    
                    <div style="background: #e8f4fd; border-radius: 8px; padding: 15px; margin-top: 20px; display: flex; align-items: center; gap: 15px;">
                        <i class="fas fa-reply-all" style="font-size: 24px; color: #0288d1;"></i>
                        <div>
                            <strong style="color: #0288d1;">Quick Reply:</strong>
                            <p style="margin: 5px 0 0; color: #555;">Click the email address above to respond to this inquiry.</p>
                        </div>
                    </div>
                    
                    <div class="footer">
                        <p>
                            <i class="fas fa-calendar-alt"></i> Sent on: ' . date('l, F j, Y') . '
                            <br>
                            <i class="fas fa-clock"></i> Time: ' . date('g:i A') . '
                        </p>
                        
                        <div class="social-links">
                            <a href="#"><i class="fab fa-github"></i></a>
                            <a href="#"><i class="fab fa-linkedin-in"></i></a>
                            <a href="#"><i class="fab fa-twitter"></i></a>
                            <a href="#"><i class="fab fa-leetcode"></i></a>
                        </div>
                        
                        <p style="margin-top: 15px;">
                            <i class="fas fa-envelope-open-text"></i>
                            This email was sent from Arittra Singh\'s portfolio contact form
                        </p>
                        <div style="margin-top: 15px;">
                            <span style="color: #999;">© ' . date('Y') . ' Arittra Singh - Portfolio</span>
                        </div>
                    </div>
                </div>
            </div>
        </body>
        </html>';
        
        // Plain text alternative for non-HTML email clients
        $mail->AltBody = "New Portfolio Contact Message\n\n";
        $mail->AltBody .= "Name: $name\n";
        $mail->AltBody .= "Email: $email\n";
        $mail->AltBody .= "Subject: $subject\n\n";
        $mail->AltBody .= "Message:\n$message\n\n";
        $mail->AltBody .= "This message was sent from your portfolio website contact form.\n";
        $mail->AltBody .= "Sent on: " . date('l, F j, Y, g:i A');
        
        $mail->send();
        
        echo json_encode([
            'success' => true,
            'message' => 'Thank you for your message! I will get back to you soon.'
        ]);
        
    } catch (Exception $e) {
        echo json_encode([
            'success' => false,
            'message' => "Message could not be sent. Error: {$mail->ErrorInfo}"
        ]);
    }
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Invalid request method.'
    ]);
}
?>