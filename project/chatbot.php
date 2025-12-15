<?php

class SimpleChatBot {
    private $name = "Simple ChatBot";
    private $conversationHistory = [];
    private $chatPatterns = [];
    
    public function __construct() {
        $this->initializePatterns();
    }
    
    private function initializePatterns() {
        $this->chatPatterns = [
            // Greetings
            [
                'pattern' => '/\b(hello|hi|hey|greetings|good morning|good afternoon|good evening)\b/i',
                'responses' => [
                    "Hello! How can I help you today?",
                    "Hi there! What's on your mind?",
                    "Hey! Nice to meet you. What would you like to talk about?",
                    "Greetings! I'm here to chat. What can I do for you?"
                ]
            ],
            
            // Farewells
            [
                'pattern' => '/\b(bye|goodbye|see you|farewell|take care|later|quit|exit)\b/i',
                'responses' => [
                    "Goodbye! It was nice chatting with you.",
                    "See you later! Have a great day!",
                    "Take care! Feel free to come back anytime.",
                    "Farewell! Thanks for the conversation."
                ],
                'action' => 'exit'
            ],
            
            // How are you
            [
                'pattern' => '/\b(how are you|how do you feel|what\'s up|how\'s it going)\b/i',
                'responses' => [
                    "I'm doing great! Thanks for asking. How are you?",
                    "I'm fantastic! Ready to help you with anything you need.",
                    "I'm doing well! What about you?",
                    "All systems running smoothly! How can I assist you today?"
                ]
            ],
            
            // Name questions
            [
                'pattern' => '/\b(what\'s your name|who are you|what are you called)\b/i',
                'responses' => [
                    "I'm a simple chatbot created to demonstrate basic conversation patterns!",
                    "You can call me ChatBot. I'm here to chat and help with simple questions.",
                    "I'm your friendly neighborhood chatbot! What should I call you?"
                ]
            ],
            
            // Weather
            [
                'pattern' => '/\b(weather|rain|sunny|cloudy|temperature|hot|cold|snow)\b/i',
                'responses' => [
                    "I wish I could check the weather for you! Try looking outside or checking a weather app.",
                    "I don't have access to real weather data, but I hope it's nice where you are!",
                    "Weather is always a great conversation starter! What's it like where you are?"
                ]
            ],
            
            // Time
            [
                'pattern' => '/\b(time|clock|what time|when|date|today)\b/i',
                'responses' => [
                    "The current time is " . date('g:i A'),
                    "Today is " . date('F j, Y') . ". The time is " . date('g:i A'),
                    "Time flies when you're having a good conversation!"
                ]
            ],
            
            // Math questions
            [
                'pattern' => '/\b(calculate|math|plus|minus|multiply|divide)\b/i',
                'responses' => [
                    "I can do simple math! Try asking me something like '5 + 3' or 'what is 10 times 2?'",
                    "Math is fun! Give me a simple calculation and I'll try to help.",
                    "I love numbers! What would you like me to calculate?"
                ]
            ],
            
            // Compliments
            [
                'pattern' => '/\b(good|great|awesome|amazing|nice|cool|smart|helpful)\b/i',
                'responses' => [
                    "Thank you! That's very kind of you to say.",
                    "I appreciate the compliment! You're pretty great yourself.",
                    "Aww, thanks! I try my best to be helpful.",
                    "You're making me blush! Well, if I could blush..."
                ]
            ],
            
            // Questions about capabilities
            [
                'pattern' => '/\b(what can you do|help|capabilities|features)\b/i',
                'responses' => [
                    "I can chat with you, answer simple questions, do basic math, and respond to common conversation topics!",
                    "I'm a simple chatbot that can have basic conversations. Try asking about weather, time, or just chat!",
                    "I can respond to greetings, answer questions, do simple calculations, and have friendly conversations!"
                ]
            ],
            
            // Thank you
            [
                'pattern' => '/\b(thank you|thanks|appreciate)\b/i',
                'responses' => [
                    "You're welcome! Happy to help.",
                    "No problem at all! Glad I could assist.",
                    "My pleasure! Feel free to ask anything else.",
                    "Anytime! That's what I'm here for."
                ]
            ]
        ];
    }
    
    private function calculateMath($userInput) {
        // Addition
        if (preg_match('/(\d+)\s*\+\s*(\d+)/', $userInput, $matches)) {
            $result = intval($matches[1]) + intval($matches[2]);
            return $matches[1] . " + " . $matches[2] . " = " . $result;
        }
        
        // Subtraction
        if (preg_match('/(\d+)\s*\-\s*(\d+)/', $userInput, $matches)) {
            $result = intval($matches[1]) - intval($matches[2]);
            return $matches[1] . " - " . $matches[2] . " = " . $result;
        }
        
        // Multiplication
        if (preg_match('/(\d+)\s*[\*x×]\s*(\d+)/', $userInput, $matches)) {
            $result = intval($matches[1]) * intval($matches[2]);
            return $matches[1] . " × " . $matches[2] . " = " . $result;
        }
        
        // Division
        if (preg_match('/(\d+)\s*[\/÷]\s*(\d+)/', $userInput, $matches)) {
            $divisor = intval($matches[2]);
            if ($divisor == 0) {
                return "I can't divide by zero! That would break the universe!";
            }
            $result = intval($matches[1]) / $divisor;
            if ($result == intval($result)) {
                $result = intval($result);
            }
            return $matches[1] . " ÷ " . $matches[2] . " = " . $result;
        }
        
        return null;
    }
    
    public function processInput($userInput) {
        $userInput = trim($userInput);
        
        // Store conversation
        $this->conversationHistory[] = ['user', $userInput, date('Y-m-d H:i:s')];
        
        // Check for math calculations first
        $mathResult = $this->calculateMath($userInput);
        if ($mathResult) {
            $response = $mathResult;
        } else {
            // Check patterns
            $response = null;
            $shouldExit = false;
            
            foreach ($this->chatPatterns as $pattern) {
                if (preg_match($pattern['pattern'], $userInput)) {
                    $response = $pattern['responses'][array_rand($pattern['responses'])];
                    if (isset($pattern['action']) && $pattern['action'] == 'exit') {
                        $shouldExit = true;
                    }
                    break;
                }
            }
            
            // Default responses for unmatched input
            if (!$response) {
                $defaultResponses = [
                    "That's interesting! Tell me more about that.",
                    "I'm not sure I understand completely, but I'm here to listen!",
                    "Could you rephrase that? I'd love to help if I can.",
                    "That's a great point! What else would you like to talk about?",
                    "I'm still learning! Can you ask me something else?",
                    "Hmm, that's beyond my current knowledge. Try asking about the weather, time, or math!"
                ];
                $response = $defaultResponses[array_rand($defaultResponses)];
            }
        }
        
        // Store bot response
        $this->conversationHistory[] = ['bot', $response, date('Y-m-d H:i:s')];
        
        // Check if user wants to exit
        $exitPatterns = ['bye', 'goodbye', 'quit', 'exit', 'see you', 'farewell'];
        $shouldExit = false;
        foreach ($exitPatterns as $pattern) {
            if (stripos($userInput, $pattern) !== false) {
                $shouldExit = true;
                break;
            }
        }
        
        return ['response' => $response, 'shouldExit' => $shouldExit];
    }
    
    public function displayWelcome() {
        echo str_repeat("=", 60) . "\n";
        echo "🤖 Welcome to " . $this->name . "!\n";
        echo str_repeat("=", 60) . "\n";
        echo "I'm a rule-based chatbot that can:\n";
        echo "• Have conversations and answer questions\n";
        echo "• Perform basic math calculations (e.g., '5 + 3', '10 * 2')\n";
        echo "• Tell you the current time and date\n";
        echo "• Respond to greetings and common phrases\n\n";
        echo "Try saying: 'Hello', 'What time is it?', '15 + 25', or 'What can you do?'\n";
        echo "Type 'bye', 'quit', or 'exit' to end the conversation.\n";
        echo str_repeat("-", 60) . "\n";
    }
    
    public function displayConversationStats() {
        if (count($this->conversationHistory) > 2) {
            $userMessages = 0;
            $botMessages = 0;
            
            foreach ($this->conversationHistory as $message) {
                if ($message[0] == 'user') $userMessages++;
                if ($message[0] == 'bot') $botMessages++;
            }
            
            echo "\n📊 Conversation Summary:\n";
            echo "   • You sent " . $userMessages . " messages\n";
            echo "   • I sent " . $botMessages . " responses\n";
            echo "   • Total conversation length: " . count($this->conversationHistory) . " messages\n";
        }
    }
    
    public function runCommandLine() {
        $this->displayWelcome();
        
        while (true) {
            echo "\n💬 You: ";
            $userInput = trim(fgets(STDIN));
            
            if (empty($userInput)) {
                echo "🤖 Bot: Please say something! I'm here to chat.\n";
                continue;
            }
            
            $result = $this->processInput($userInput);
            echo "🤖 Bot: " . $result['response'] . "\n";
            
            if ($result['shouldExit']) {
                $this->displayConversationStats();
                break;
            }
        }
    }
    
    public function getWebResponse($userInput) {
        $result = $this->processInput($userInput);
        return $result;
    }
    
    public function getConversationHistory() {
        return $this->conversationHistory;
    }
}

// Check if running from command line or web
if (php_sapi_name() === 'cli') {
    // Command line version
    $chatbot = new SimpleChatBot();
    $chatbot->runCommandLine();
} else {
    // Web version
    session_start();
    
    if (!isset($_SESSION['chatbot'])) {
        $_SESSION['chatbot'] = new SimpleChatBot();
        $_SESSION['messages'] = [
            ['bot', "Hello! I'm a simple chatbot. I can help you with basic questions and have a conversation. Try asking me about the weather, time, math, or just say hello!", date('H:i')]
        ];
    }
    
    $chatbot = $_SESSION['chatbot'];
    $messages = $_SESSION['messages'];
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['message'])) {
        $userMessage = trim($_POST['message']);
        if (!empty($userMessage)) {
            $messages[] = ['user', $userMessage, date('H:i')];
            
            $result = $chatbot->getWebResponse($userMessage);
            $messages[] = ['bot', $result['response'], date('H:i')];
            
            $_SESSION['messages'] = $messages;
            
            if ($result['shouldExit']) {
                session_destroy();
                header('Location: ' . $_SERVER['PHP_SELF']);
                exit;
            }
        }
    }
    
    if (isset($_POST['clear'])) {
        session_destroy();
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit;
    }
    ?>
    
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Simple PHP Chatbot</title>
        <style>
            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
            }
            
            body {
                font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                min-height: 100vh;
                display: flex;
                align-items: center;
                justify-content: center;
                padding: 20px;
            }
            
            .chat-container {
                background: white;
                border-radius: 20px;
                box-shadow: 0 20px 40px rgba(0,0,0,0.1);
                width: 100%;
                max-width: 600px;
                height: 600px;
                display: flex;
                flex-direction: column;
                overflow: hidden;
            }
            
            .chat-header {
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                color: white;
                padding: 20px;
                text-align: center;
                position: relative;
            }
            
            .chat-header h1 {
                font-size: 24px;
                margin-bottom: 5px;
            }
            
            .chat-header p {
                opacity: 0.9;
                font-size: 14px;
            }
            
            .clear-btn {
                position: absolute;
                right: 20px;
                top: 50%;
                transform: translateY(-50%);
                background: rgba(255,255,255,0.2);
                border: none;
                color: white;
                padding: 8px 12px;
                border-radius: 8px;
                cursor: pointer;
                font-size: 12px;
                transition: background 0.3s;
            }
            
            .clear-btn:hover {
                background: rgba(255,255,255,0.3);
            }
            
            .chat-messages {
                flex: 1;
                overflow-y: auto;
                padding: 20px;
                background: #f8f9fa;
            }
            
            .message {
                margin-bottom: 15px;
                display: flex;
                align-items: flex-start;
            }
            
            .message.user {
                justify-content: flex-end;
            }
            
            .message-content {
                max-width: 70%;
                padding: 12px 16px;
                border-radius: 18px;
                position: relative;
            }
            
            .message.bot .message-content {
                background: white;
                color: #333;
                border-bottom-left-radius: 4px;
                box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            }
            
            .message.user .message-content {
                background: #667eea;
                color: white;
                border-bottom-right-radius: 4px;
            }
            
            .message-time {
                font-size: 11px;
                opacity: 0.7;
                margin-top: 4px;
            }
            
            .chat-input {
                padding: 20px;
                background: white;
                border-top: 1px solid #eee;
            }
            
            .input-form {
                display: flex;
                gap: 10px;
            }
            
            .input-field {
                flex: 1;
                padding: 12px 16px;
                border: 2px solid #eee;
                border-radius: 25px;
                outline: none;
                font-size: 14px;
                transition: border-color 0.3s;
            }
            
            .input-field:focus {
                border-color: #667eea;
            }
            
            .send-btn {
                background: #667eea;
                color: white;
                border: none;
                padding: 12px 20px;
                border-radius: 25px;
                cursor: pointer;
                font-weight: 600;
                transition: background 0.3s;
            }
            
            .send-btn:hover {
                background: #5a6fd8;
            }
            
            .suggestions {
                text-align: center;
                margin-top: 10px;
                font-size: 12px;
                color: #666;
            }
            
            @media (max-width: 480px) {
                .chat-container {
                    height: 100vh;
                    border-radius: 0;
                }
                
                .message-content {
                    max-width: 85%;
                }
            }
        </style>
    </head>
    <body>
        <div class="chat-container">
            <div class="chat-header">
                <h1>🤖 Simple PHP Chatbot</h1>
                <p>Rule-based conversation AI</p>
                <form method="post" style="display: inline;">
                    <button type="submit" name="clear" class="clear-btn">Clear Chat</button>
                </form>
            </div>
            
            <div class="chat-messages" id="messages">
                <?php foreach ($messages as $message): ?>
                    <div class="message <?php echo $message[0]; ?>">
                        <div class="message-content">
                            <?php echo htmlspecialchars($message[1]); ?>
                            <div class="message-time"><?php echo $message[2]; ?></div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            
            <div class="chat-input">
                <form method="post" class="input-form">
                    <input type="text" name="message" class="input-field" placeholder="Type your message here..." required autocomplete="off">
                    <button type="submit" class="send-btn">Send</button>
                </form>
                <div class="suggestions">
                    Try: "Hello", "What time is it?", "5 + 3", "What can you do?"
                </div>
            </div>
        </div>
        
        <script>
            // Auto-scroll to bottom
            const messages = document.getElementById('messages');
            messages.scrollTop = messages.scrollHeight;
            
            // Focus input field
            document.querySelector('.input-field').focus();
        </script>
    </body>
    </html>
    
    <?php
}
?>