# Simple Rule-Based Chatbot (PHP)

A versatile PHP chatbot that can run both as a command-line application and as a web application, demonstrating basic natural language processing concepts using pattern matching and rule-based responses.

## Features

- **Dual Interface**: Works both as command-line script and web application
- **Pattern Matching**: Uses regular expressions to identify different types of user input
- **Mathematical Calculations**: Performs basic arithmetic (addition, subtraction, multiplication, division)
- **Conversation Flow**: Maintains context and provides appropriate responses
- **Time & Date**: Can tell you the current time and date
- **Session Management**: Web version maintains conversation history across requests
- **Responsive Design**: Mobile-friendly web interface
- **Error Handling**: Graceful handling of unexpected inputs

## How to Run

### Command Line Version

1. **Make sure you have PHP installed** (PHP 7.0 or higher)

2. **Open terminal/command prompt** and navigate to the folder containing the file

3. **Run the chatbot**:
   ```bash
   php chatbot.php
   ```

### Web Version

1. **Place the file in your web server directory** (htdocs, www, public_html, etc.)

2. **Start your web server** (Apache, Nginx, or PHP built-in server):
   ```bash
   # Using PHP built-in server
   php -S localhost:8000
   ```

3. **Open your browser** and navigate to:
   ```
   http://localhost:8000/chatbot.php
   ```

## Example Conversations

### Command Line:
```
💬 You: Hello!
🤖 Bot: Hi there! What's on your mind?

💬 You: What time is it?
🤖 Bot: The current time is 2:30 PM

💬 You: Calculate 15 + 25
🤖 Bot: 15 + 25 = 40

💬 You: bye
🤖 Bot: Goodbye! It was nice chatting with you.
```

### Web Interface:
The web version provides a beautiful, modern chat interface with:
- Real-time message display
- Session persistence
- Mobile-responsive design
- Clear chat functionality
- Auto-scrolling messages

## Supported Math Operations

- Addition: `5 + 3`, `10 + 20`
- Subtraction: `15 - 7`, `100 - 25`
- Multiplication: `6 * 4`, `7 x 8`, `9 × 3`
- Division: `20 / 4`, `15 ÷ 3`

## Pattern Categories

The chatbot recognizes these types of input:

- **Greetings**: hello, hi, hey, good morning, etc.
- **Farewells**: bye, goodbye, see you, quit, exit, etc.
- **Questions**: how are you, what's your name, what can you do, etc.
- **Weather**: weather, rain, sunny, temperature, etc.
- **Time**: time, date, what time is it, etc.
- **Math**: calculate, math, plus, minus, or direct calculations
- **Compliments**: good, great, awesome, helpful, etc.
- **Thanks**: thank you, thanks, appreciate, etc.

## Technical Details

- **Language**: PHP 7.0+
- **Dependencies**: None (uses only built-in PHP functions)
- **Architecture**: Object-oriented design with rule-based pattern matching
- **Web Features**: Session management, responsive CSS, form handling
- **CLI Features**: Interactive command-line interface with statistics
- **Pattern Matching**: Regular expressions (preg_match)
- **Session Handling**: PHP sessions for web version persistence

## File Structure

```
chatbot.php          # Main chatbot class and both interfaces
README_PHP.md        # This documentation file
```

## Learning Concepts

This chatbot demonstrates:

1. **Object-Oriented PHP**: Class structure and method organization
2. **Regular Expressions**: Pattern matching in text processing
3. **Session Management**: Maintaining state across web requests
4. **Dual Interface Design**: CLI and web application in one file
5. **Form Handling**: Processing POST requests and user input
6. **Responsive Web Design**: Mobile-friendly CSS layout
7. **Error Handling**: Input validation and edge case management

## Extending the Chatbot

You can easily extend the chatbot by:

1. **Adding new patterns** to the `initializePatterns()` method
2. **Creating new response categories** with custom logic
3. **Implementing database storage** for conversation history
4. **Adding AJAX** for real-time web responses without page refresh
5. **Integrating APIs** for weather, news, or other external data
6. **Adding user authentication** for personalized experiences

## Web Interface Features

- **Modern Design**: Clean, professional chat interface
- **Session Persistence**: Conversations maintained across page refreshes
- **Mobile Responsive**: Works perfectly on phones and tablets
- **Auto-scroll**: Messages automatically scroll to show latest
- **Clear Chat**: Reset conversation with one click
- **Input Focus**: Automatic focus on message input field

## Security Considerations

- Input sanitization with `htmlspecialchars()`
- Session management for state persistence
- Form validation and error handling
- No database storage (sessions only) for simplicity

## Browser Compatibility

The web version works on all modern browsers:
- Chrome, Firefox, Safari, Edge
- Mobile browsers (iOS Safari, Chrome Mobile)
- Responsive design adapts to all screen sizes