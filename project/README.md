# Simple Rule-Based Chatbot (Python)

A command-line chatbot built with Python that demonstrates basic natural language processing concepts using pattern matching and rule-based responses.

## Features

- **Pattern Matching**: Uses regular expressions to identify different types of user input
- **Mathematical Calculations**: Performs basic arithmetic (addition, subtraction, multiplication, division)
- **Conversation Flow**: Maintains context and provides appropriate responses
- **Time & Date**: Can tell you the current time and date
- **Conversation History**: Tracks the entire conversation and provides statistics
- **Error Handling**: Graceful handling of unexpected inputs and interruptions

## How to Run

1. **Make sure you have Python installed** (Python 3.6 or higher)

2. **Download the chatbot.py file**

3. **Open terminal/command prompt** and navigate to the folder containing the file

4. **Run the chatbot**:
   ```bash
   python chatbot.py
   ```

## Example Conversations

```
💬 You: Hello!
🤖 Bot: Hi there! What's on your mind?

💬 You: What time is it?
🤖 Bot: The current time is 2:30 PM

💬 You: Calculate 15 + 25
🤖 Bot: 15 + 25 = 40

💬 You: What can you do?
🤖 Bot: I can chat with you, answer simple questions, do basic math, and respond to common conversation topics!

💬 You: bye
🤖 Bot: Goodbye! It was nice chatting with you.
```

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

- **Language**: Python 3.6+
- **Dependencies**: None (uses only standard library)
- **Architecture**: Rule-based pattern matching with regular expressions
- **Input Processing**: Text preprocessing and pattern recognition
- **Response Generation**: Random selection from predefined response sets
- **Error Handling**: Graceful handling of edge cases and user interruptions

## Learning Concepts

This chatbot demonstrates:

1. **Natural Language Processing Basics**: Pattern recognition in text
2. **Regular Expressions**: Text matching and extraction
3. **Conversation Flow**: Managing dialogue state and context
4. **Rule-Based AI**: If-else logic for decision making
5. **User Interface Design**: Command-line interaction patterns
6. **Error Handling**: Robust input processing and exception management

## Extending the Chatbot

You can easily extend the chatbot by:

1. **Adding new patterns** to the `_initialize_patterns()` method
2. **Creating new response categories** with custom logic
3. **Implementing more complex math operations**
4. **Adding conversation memory** for more context-aware responses
5. **Integrating with external APIs** for weather, news, etc.

## Exit Commands

To end the conversation, use any of these:
- `bye`
- `goodbye`
- `quit`
- `exit`
- `see you`
- `farewell`
- Or press `Ctrl+C`